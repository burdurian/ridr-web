<?php

namespace App\Http\Controllers;

use App\Services\SupabaseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ArtistController extends Controller
{
    protected $supabaseService;

    public function __construct(SupabaseService $supabaseService)
    {
        $this->supabaseService = $supabaseService;
    }

    /**
     * Sanatçı listesini gösterir (dashboard'a yönlendirildi)
     */
    public function index()
    {
        // Sanatçılar sayfası yerine dashboard'a yönlendirme yapıyoruz
        return redirect()->route('dashboard');
    }

    /**
     * Yeni sanatçı oluşturma formunu gösterir - Aşama 1 (Temel Bilgiler ve Plan Seçimi)
     */
    public function create()
    {
        // Bu metot artık createStep1'e yönlendir
        return redirect()->route('artists.create.step1');
    }

    /**
     * Yeni sanatçı oluşturma formunu gösterir - Aşama 1 (Temel Bilgiler ve Plan Seçimi)
     */
    public function createStep1()
    {
        $result = $this->supabaseService->select('subscription_plans', [
            'select' => 'plan_id,plan_name,max_members,monthly_price,annual_price,price_currency,plan_desc,plan_features',
        ]);
        
        $plans = [];
        if (!isset($result['error']) && !empty($result)) {
            $plans = $result;
        }
        
        return view('artists.create_step1', compact('plans'));
    }

    /**
     * Aşama 1'den gelen verileri doğrular ve Aşama 2'yi gösterir (Ödeme)
     */
    public function processStep1(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'artist_name' => 'required|string|max:255',
            'genre' => 'required|string|max:100',
            'subscription_plan' => 'required|string',
            'artist_image' => 'nullable|url|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        
        $manager = Session::get('manager');
        
        // Plan limitini kontrol et
        $planResult = $this->supabaseService->select('subscription_plans', [
            'plan_id' => 'eq.' . $request->input('subscription_plan'),
            'select' => 'plan_id,plan_name,max_members,monthly_price,annual_price,price_currency,plan_desc,plan_features'
        ]);
        
        if (isset($planResult['error']) || empty($planResult)) {
            return redirect()->back()
                ->with('error', 'Geçersiz abonelik planı seçildi.')
                ->withInput();
        }
        
        $plan = $planResult[0];
        
        // Bu plan için mevcut sanatçı sayısını kontrol et
        $artistsResult = $this->supabaseService->select('artists', [
            'related_manager' => 'eq.' . $manager['manager_id'],
            'subscription_plan' => 'eq.' . $plan['plan_id'],
            'select' => 'count'
        ]);
        
        if (!isset($artistsResult['error']) && count($artistsResult) >= $plan['max_members']) {
            return redirect()->back()
                ->with('error', 'Bu plan için maksimum sanatçı sayısına ulaştınız. Lütfen planınızı yükseltin veya başka bir plan seçin.')
                ->withInput();
        }
        
        // Sanatçı slug oluştur
        $slug = Str::slug($request->input('artist_name'));
        $baseSlug = $slug;
        $counter = 1;
        
        // Slugın benzersiz olduğundan emin ol
        while (true) {
            $checkResult = $this->supabaseService->select('artists', [
                'artist_slug' => 'eq.' . $slug,
                'select' => 'artist_id'
            ]);
            
            if (isset($checkResult['error']) || empty($checkResult)) {
                break;
            }
            
            $slug = $baseSlug . '-' . $counter++;
        }
        
        // Formdan gelen verileri session'a kaydet
        $artistData = [
            'artist_name' => $request->input('artist_name'),
            'genre' => $request->input('genre'),
            'artist_image' => $request->input('artist_image', ''),
            'artist_slug' => $slug,
            'subscription_plan' => $request->input('subscription_plan'),
        ];
        
        Session::put('artist_creation_data', $artistData);
        
        return redirect()->route('artists.create.step2', ['plan_id' => $plan['plan_id']]);
    }

    /**
     * Ödeme sayfasını gösterir - Aşama 2
     */
    public function createStep2($plan_id)
    {
        if (!Session::has('artist_creation_data')) {
            return redirect()->route('artists.create.step1')
                ->with('error', 'Lütfen önce sanatçı bilgilerini girin.');
        }
        
        $artistData = Session::get('artist_creation_data');
        
        // Plan bilgilerini çek
        $planResult = $this->supabaseService->select('subscription_plans', [
            'plan_id' => 'eq.' . $plan_id,
            'select' => 'plan_id,plan_name,monthly_price,annual_price,price_currency,plan_desc,plan_features'
        ]);
        
        if (isset($planResult['error']) || empty($planResult)) {
            return redirect()->route('artists.create.step1')
                ->with('error', 'Geçersiz abonelik planı.');
        }
        
        $plan = $planResult[0];
        $manager = Session::get('manager');
        
        // Menajer fatura bilgilerini çek
        $managerDetailsResult = $this->supabaseService->select('managers', [
            'manager_id' => 'eq.' . $manager['manager_id'],
            'select' => 'manager_tax_kimlikno,company_tax_number,company_tax_office,company_legal_name',
        ]);
        
        if (!isset($managerDetailsResult['error']) && !empty($managerDetailsResult)) {
            $manager = array_merge($manager, $managerDetailsResult[0]);
        }
        
        return view('artists.create_step2', compact('artistData', 'plan', 'manager'));
    }

    /**
     * Yeni sanatçı kaydeder (ödeme sonrası)
     */
    public function store(Request $request)
    {
        // Ödeme başarılıysa ve session'da artist verileri varsa devam et
        if (!Session::has('artist_creation_data')) {
            return redirect()->route('artists.create.step1')
                ->with('error', 'Sanatçı oluşturma verileri eksik. Lütfen yeniden deneyin.');
        }
        
        // Session'dan artist verilerini al
        $artistData = Session::get('artist_creation_data');
        $manager = Session::get('manager');
        
        // Payment sonucunu kontrol et - Bu örnekte ödeme başarılı kabul ediyoruz
        // Gerçek uygulamada, İyzico veya başka bir ödeme geçidi entegrasyonu olacaktır
        
        // Menajer fatura bilgilerini güncelle
        $managerUpdateData = [];
        $billingType = $request->input('billing_type', 'personal');
        
        if ($billingType === 'personal') {
            $managerUpdateData['manager_tax_kimlikno'] = $request->input('billing_identity_number');
            // Eğer daha önce kurumsal bilgi varsa ve şimdi bireysel seçildiyse, kurumsal bilgileri NULL yap
            $managerUpdateData['company_tax_number'] = null;
            $managerUpdateData['company_tax_office'] = null;
            $managerUpdateData['company_legal_name'] = null;
        } else {
            $managerUpdateData['company_tax_number'] = $request->input('billing_tax_number');
            $managerUpdateData['company_tax_office'] = $request->input('billing_tax_office');
            $managerUpdateData['company_legal_name'] = $request->input('billing_company_name');
            // Eğer daha önce bireysel bilgi varsa ve şimdi kurumsal seçildiyse, bireysel bilgileri NULL yap
            $managerUpdateData['manager_tax_kimlikno'] = null;
        }
        
        // Menajer bilgilerini güncelle
        $this->supabaseService->update('managers', $managerUpdateData, [
            'manager_id' => 'eq.' . $manager['manager_id']
        ]);
        
        // Sanatçı verisini hazırla
        $artistData['related_manager'] = $manager['manager_id'];
        
        // Veritabanına yeni sanatçıyı ekle
        $result = $this->supabaseService->insert('artists', $artistData);
        
        if (isset($result['error'])) {
            return redirect()->route('artists.create.step1')
                ->with('error', 'Sanatçı oluşturulurken bir hata oluştu: ' . $result['error']);
        }
        
        // Oluşturulan sanatçı bilgilerini al
        $createdArtist = $result[0] ?? null;
        
        // Abonelik plan bilgilerini çek
        $planInfo = null;
        if ($createdArtist && isset($createdArtist['subscription_plan'])) {
            $planResult = $this->supabaseService->select('subscription_plans', [
                'plan_id' => 'eq.' . $createdArtist['subscription_plan'],
                'select' => 'plan_id,plan_name,monthly_price,price_currency'
            ]);
            
            if (!isset($planResult['error']) && !empty($planResult)) {
                $planInfo = $planResult[0];
            }
        }
        
        // Session'daki geçici verileri temizle
        Session::forget('artist_creation_data');
        
        // Başarı sayfasına yönlendir
        return redirect()->route('artists.payment.success', ['id' => $createdArtist['artist_id']])
            ->with('plan', $planInfo);
    }

    /**
     * Ödeme başarılı sayfasını gösterir
     */
    public function paymentSuccess($id)
    {
        $manager = Session::get('manager');
        
        // Sanatçı bilgilerini çek
        $result = $this->supabaseService->select('artists', [
            'artist_id' => 'eq.' . $id,
            'related_manager' => 'eq.' . $manager['manager_id'],
            'select' => '*'
        ]);
        
        if (isset($result['error']) || empty($result)) {
            return redirect()->route('artists.index')
                ->with('error', 'Sanatçı bulunamadı veya bu sanatçıya erişim izniniz yok.');
        }
        
        $artist = $result[0];
        
        // Abonelik planı bilgilerini çek (eğer session'da yoksa)
        $plan = Session::get('plan');
        
        if (!$plan) {
            $planResult = $this->supabaseService->select('subscription_plans', [
                'plan_id' => 'eq.' . $artist['subscription_plan'],
                'select' => 'plan_id,plan_name,monthly_price,price_currency'
            ]);
            
            if (!isset($planResult['error']) && !empty($planResult)) {
                $plan = $planResult[0];
            }
        }
        
        return view('artists.payment_success', compact('artist', 'plan'));
    }

    /**
     * Sanatçı detay sayfasını gösterir
     */
    public function show($id)
    {
        $manager = Session::get('manager');
        
        $result = $this->supabaseService->select('artists', [
            'artist_id' => 'eq.' . $id,
            'related_manager' => 'eq.' . $manager['manager_id'],
            'select' => '*'
        ]);
        
        if (isset($result['error']) || empty($result)) {
            return redirect()->route('artists.index')
                ->with('error', 'Sanatçı bulunamadı veya bu sanatçıya erişim izniniz yok.');
        }
        
        $artist = $result[0];
        
        // Abonelik planı bilgilerini çek
        $planResult = $this->supabaseService->select('subscription_plans', [
            'plan_id' => 'eq.' . $artist['subscription_plan'],
            'select' => '*'
        ]);
        
        $plan = null;
        if (!isset($planResult['error']) && !empty($planResult)) {
            $plan = $planResult[0];
        }
        
        return view('artists.show', compact('artist', 'plan'));
    }

    /**
     * Sanatçıyı slug ile bulup detay sayfasını gösterir
     */
    public function showBySlug($slug)
    {
        $manager = Session::get('manager');
        
        $result = $this->supabaseService->select('artists', [
            'artist_slug' => 'eq.' . $slug,
            'related_manager' => 'eq.' . $manager['manager_id'],
            'select' => '*'
        ]);
        
        if (isset($result['error']) || empty($result)) {
            return redirect()->route('artists.index')
                ->with('error', 'Sanatçı bulunamadı veya bu sanatçıya erişim izniniz yok.');
        }
        
        $artist = $result[0];
        
        // Abonelik planı bilgilerini çek
        $planResult = $this->supabaseService->select('subscription_plans', [
            'plan_id' => 'eq.' . $artist['subscription_plan'],
            'select' => '*'
        ]);
        
        $plan = null;
        if (!isset($planResult['error']) && !empty($planResult)) {
            $plan = $planResult[0];
        }
        
        return view('artists.show', compact('artist', 'plan'));
    }

    /**
     * Sanatçı düzenleme formunu gösterir
     */
    public function edit($id)
    {
        $manager = Session::get('manager');
        
        $result = $this->supabaseService->select('artists', [
            'artist_id' => 'eq.' . $id,
            'related_manager' => 'eq.' . $manager['manager_id'],
            'select' => '*'
        ]);
        
        if (isset($result['error']) || empty($result)) {
            return redirect()->route('artists.index')
                ->with('error', 'Sanatçı bulunamadı veya bu sanatçıya erişim izniniz yok.');
        }
        
        $artist = $result[0];
        
        // Abonelik planlarını çek
        $plansResult = $this->supabaseService->select('subscription_plans', [
            'select' => 'plan_id,plan_name,max_members,monthly_price,annual_price,price_currency,plan_desc,plan_features',
        ]);
        
        $plans = [];
        if (!isset($plansResult['error']) && !empty($plansResult)) {
            $plans = $plansResult;
        }
        
        return view('artists.edit', compact('artist', 'plans'));
    }

    /**
     * Sanatçı bilgilerini günceller
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'artist_name' => 'required|string|max:255',
            'genre' => 'required|string|max:100',
            'artist_image' => 'nullable|url|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        
        $manager = Session::get('manager');
        
        // Sanatçının var olduğunu ve yöneticiye ait olduğunu kontrol et
        $checkResult = $this->supabaseService->select('artists', [
            'artist_id' => 'eq.' . $id,
            'related_manager' => 'eq.' . $manager['manager_id'],
            'select' => 'artist_id,artist_slug,subscription_plan'
        ]);
        
        if (isset($checkResult['error']) || empty($checkResult)) {
            return redirect()->route('artists.index')
                ->with('error', 'Sanatçı bulunamadı veya bu sanatçıya erişim izniniz yok.');
        }
        
        $artist = $checkResult[0];
        
        // Sanatçı verilerini güncelle
        $artistData = [
            'artist_name' => $request->input('artist_name'),
            'artist_image' => $request->input('artist_image', ''),
            'genre' => $request->input('genre'),
        ];
        
        // Plan limitini kontrol et
        if ($request->has('subscription_plan') && $request->input('subscription_plan') !== $artist['subscription_plan']) {
            // Plan limitini kontrol et
            $planResult = $this->supabaseService->select('subscription_plans', [
                'plan_id' => 'eq.' . $request->input('subscription_plan'),
                'select' => 'plan_id,max_members,monthly_price,annual_price,price_currency'
            ]);
            
            if (!isset($planResult['error']) && !empty($planResult)) {
                $plan = $planResult[0];
                
                // Bu plan için mevcut sanatçı sayısını kontrol et
                $artistsResult = $this->supabaseService->select('artists', [
                    'related_manager' => 'eq.' . $manager['manager_id'],
                    'subscription_plan' => 'eq.' . $plan['plan_id'],
                    'select' => 'count'
                ]);
                
                if (!isset($artistsResult['error']) && count($artistsResult) >= $plan['max_members']) {
                    return redirect()->back()
                        ->with('error', 'Bu plan için maksimum sanatçı sayısına ulaştınız. Lütfen planınızı yükseltin veya başka bir plan seçin.')
                        ->withInput();
                }
                
                $artistData['subscription_plan'] = $request->input('subscription_plan');
            }
        }
        
        $result = $this->supabaseService->update('artists', $artistData, [
            'artist_id' => 'eq.' . $id
        ]);
        
        if (isset($result['error'])) {
            return redirect()->back()
                ->with('error', 'Sanatçı güncellenirken bir hata oluştu: ' . $result['error'])
                ->withInput();
        }
        
        return redirect()->route('artists.show.slug', $artist['artist_slug'])
            ->with('success', 'Sanatçı bilgileri başarıyla güncellendi.');
    }

    /**
     * Sanatçıyı siler
     */
    public function destroy($id)
    {
        $manager = Session::get('manager');
        
        // Sanatçının var olduğunu ve yöneticiye ait olduğunu kontrol et
        $checkResult = $this->supabaseService->select('artists', [
            'artist_id' => 'eq.' . $id,
            'related_manager' => 'eq.' . $manager['manager_id'],
            'select' => 'artist_id'
        ]);
        
        if (isset($checkResult['error']) || empty($checkResult)) {
            return redirect()->route('artists.index')
                ->with('error', 'Sanatçı bulunamadı veya bu sanatçıya erişim izniniz yok.');
        }
        
        $result = $this->supabaseService->delete('artists', [
            'artist_id' => 'eq.' . $id
        ]);
        
        if (isset($result['error'])) {
            return redirect()->back()
                ->with('error', 'Sanatçı silinirken bir hata oluştu: ' . $result['error']);
        }
        
        return redirect()->route('artists.index')
            ->with('success', 'Sanatçı başarıyla silindi.');
    }
} 