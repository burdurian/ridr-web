<?php

namespace App\Http\Controllers;

use App\Services\SupabaseService;
use App\Services\FileManagerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ArtistController extends Controller
{
    protected $supabaseService;
    protected $fileManagerService;

    public function __construct(SupabaseService $supabaseService, FileManagerService $fileManagerService)
    {
        $this->supabaseService = $supabaseService;
        $this->fileManagerService = $fileManagerService;
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
            'artist_image' => 'nullable',
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
            'artist_image' => '',
            'artist_slug' => $slug,
            'subscription_plan' => $request->input('subscription_plan'),
        ];
        
        // Görsel işleme - Base64 formatında gelen görseli işle
        $imageData = $request->input('artist_image');
        if (!empty($imageData) && strpos($imageData, 'data:image/') === 0) {
            try {
                \Log::info('Base64 görsel işleniyor');
                
                // MIME türünü çıkar
                $mimeType = '';
                if (preg_match('/^data:image\/(\w+);base64,/', $imageData, $matches)) {
                    $mimeType = 'image/' . $matches[1];
                } else {
                    throw new \Exception('Geçersiz görsel formatı');
                }
                
                // Base64 veriyi çıkar
                $base64Data = substr($imageData, strpos($imageData, ',') + 1);
                $base64Data = str_replace(' ', '+', $base64Data);
                $decodedData = base64_decode($base64Data, true);
                
                if ($decodedData === false) {
                    throw new \Exception('Base64 veri çözülemedi');
                }
                
                // Dosya uzantısını belirle
                $extension = 'jpg'; // Varsayılan olarak jpg
                if ($mimeType === 'image/png') $extension = 'png';
                if ($mimeType === 'image/gif') $extension = 'gif';
                if ($mimeType === 'image/webp') $extension = 'webp';
                
                // Geçici dosya oluştur
                $tempFileName = 'artist_image_' . time() . '.' . $extension;
                $tempFilePath = sys_get_temp_dir() . '/' . $tempFileName;
                
                \Log::info('Geçici dosya oluşturuluyor: ' . $tempFilePath);
                if (file_put_contents($tempFilePath, $decodedData) === false) {
                    throw new \Exception('Geçici dosya oluşturulamadı');
                }
                
                // UploadedFile nesnesine dönüştür
                $uploadedFile = new \Illuminate\Http\UploadedFile(
                    $tempFilePath,
                    $tempFileName,
                    $mimeType,
                    null,
                    true
                );
                
                \Log::info('Görüntü işleniyor...');
                // Görüntüyü işle (yeniden boyutlandır ve sıkıştır)
                $processedImage = $this->fileManagerService->processImage($uploadedFile, 720, 0.8);
                
                \Log::info('Görüntü sunucuya yükleniyor...');
                // Görüntüyü sunucuya yükle
                $uploadResult = $this->fileManagerService->uploadFile($processedImage, 'artist_images');
                
                \Log::info('Yükleme sonucu: ', $uploadResult);
                
                // Upload başarılı ise URL'i kaydet
                if (isset($uploadResult['success']) && $uploadResult['success']) {
                    $artistData['artist_image'] = $uploadResult['url'];
                    \Log::info('Görüntü URL\'i kaydedildi: ' . $uploadResult['url']);
                } else {
                    \Log::error('Görüntü yükleme başarısız: ', $uploadResult);
                }
                
                // Geçici dosyayı temizle
                if (file_exists($tempFilePath)) {
                    unlink($tempFilePath);
                    \Log::info('Geçici dosya temizlendi');
                }
                
            } catch (\Exception $e) {
                \Log::error('Görsel işleme hatası: ' . $e->getMessage());
                return redirect()->back()
                    ->with('error', 'Görsel yüklenirken bir hata oluştu: ' . $e->getMessage())
                    ->withInput();
            }
        } else if (!empty($imageData)) {
            \Log::warning('Geçersiz görsel formatı: Base64 data URI değil.');
            return redirect()->back()
                ->with('error', 'Geçersiz görsel formatı. Lütfen farklı bir resim yükleyin.')
                ->withInput();
        }
        
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
            $managerUpdateData['company_legal_name'] = $request->input('billing_legal_name');
            // Eğer daha önce bireysel bilgi varsa ve şimdi kurumsal seçildiyse, bireysel bilgileri NULL yap
            $managerUpdateData['manager_tax_kimlikno'] = null;
        }
        
        // Menajer bilgilerini güncelle
        if (!empty($managerUpdateData)) {
            $this->supabaseService->update('managers', $managerUpdateData, [
                'manager_id' => 'eq.' . $manager['manager_id']
            ]);
            
            // Session'daki menajer bilgilerini güncelle
            $manager = array_merge($manager, $managerUpdateData);
            Session::put('manager', $manager);
        }
        
        // Sanatçı verilerini hazırla
        $artistInsertData = [
            'artist_name' => $artistData['artist_name'],
            'artist_slug' => $artistData['artist_slug'],
            'genre' => $artistData['genre'],
            'artist_image' => $artistData['artist_image'],
            'related_manager' => $manager['manager_id'],
            'subscription_plan' => $artistData['subscription_plan'],
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];
        
        // Sanatçı oluştur
        $result = $this->supabaseService->insert('artists', $artistInsertData);
        
        if (isset($result['error'])) {
            return redirect()->route('artists.create.step1')
                ->with('error', 'Sanatçı oluşturulurken bir hata oluştu: ' . $result['error']['message'])
                ->withInput();
        }
        
        // Yeni oluşturulan sanatçının ID'sini al
        $newArtistId = $result[0]['artist_id'] ?? null;
        
        if (!$newArtistId) {
            return redirect()->route('artists.create.step1')
                ->with('error', 'Sanatçı oluşturuldu fakat ID alınamadı.')
                ->withInput();
        }
        
        // Eğer görsel URL'i base64 verisinden oluşturulduysa ve geçici bir dosya ise
        // Bu adımda artist_id'yi kullanarak dosya adını güncelleyelim
        if (!empty($artistData['artist_image']) && preg_match('/time_[0-9]+_/', $artistData['artist_image'])) {
            try {
                // Mevcut URL'den dosya adını çıkar
                $imageUrl = $artistData['artist_image'];
                $urlParts = parse_url($imageUrl);
                $pathParts = pathinfo($urlParts['path']);
                
                // Dosya adını al (time_timestamp_name.jpg formatında)
                $oldFilename = $pathParts['basename'];
                
                // Yeni dosya adı oluştur (artist_id.jpg formatında)
                $extension = $pathParts['extension'] ?? 'jpg';
                $newFilename = 'artist_' . $newArtistId . '.' . $extension;
                
                // CDN'de dosya adını değiştir (burada varsayımsal bir API çağrısı yapılıyor)
                // Not: Bu fonksiyon şu anda mevcut değil, bu nedenle devre dışı bırakıldı
                // $renameResult = $this->fileManagerService->renameFile('artist_images', $oldFilename, $newFilename);
                
                // Dosya adını değiştirme işlemi başarısız olduysa, yeni bir dosya oluştur
                $tempFile = sys_get_temp_dir() . '/' . uniqid('artist_temp_');
                $imageContent = file_get_contents($imageUrl);
                
                if ($imageContent !== false) {
                    file_put_contents($tempFile, $imageContent);
                    
                    // Dosyayı UploadedFile nesnesine dönüştür
                    $uploadedFile = new \Illuminate\Http\UploadedFile(
                        $tempFile,
                        $newFilename,
                        mime_content_type($tempFile),
                        null,
                        true
                    );
                    
                    // Görüntüyü sunucuya yükle
                    $uploadResult = $this->fileManagerService->uploadFile($uploadedFile, 'artist_images');
                    
                    // Upload başarılı ise URL'i güncelle
                    if (isset($uploadResult['success']) && $uploadResult['success']) {
                        // Veritabanında artist_image'ı güncelle
                        $this->supabaseService->update('artists', [
                            'artist_image' => $uploadResult['url']
                        ], [
                            'artist_id' => 'eq.' . $newArtistId
                        ]);
                    }
                    
                    // Geçici dosyayı temizle
                    if (file_exists($tempFile)) {
                        unlink($tempFile);
                    }
                }
                
            } catch (\Exception $e) {
                // Hata durumunda sadece logla, kullanıcıya gösterme
                \Log::error('Sanatçı görseli yeniden adlandırma hatası: ' . $e->getMessage());
            }
        }
        
        // Session'dan artist verilerini temizle
        Session::forget('artist_creation_data');
        
        // Başarı sayfasına yönlendir
        return redirect()->route('artists.payment.success', ['id' => $newArtistId]);
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
        
        // Sanatçı ID'sini logla
        \Log::info('Sanatçı ID değeri:', ['artist_id' => $artist['artist_id']]);
        
        // Abonelik planı bilgilerini çek
        $planResult = $this->supabaseService->select('subscription_plans', [
            'plan_id' => 'eq.' . $artist['subscription_plan'],
            'select' => '*'
        ]);
        
        $plan = null;
        if (!isset($planResult['error']) && !empty($planResult)) {
            $plan = $planResult[0];
        }
        
        // Ekip üyelerini çek
        $teamResult = $this->supabaseService->rpc('get_users_for_artist', [
            'artist_id_param' => $artist['artist_id']
        ]);
        
        $teamMembers = [];
        if (!isset($teamResult['error'])) {
            $teamMembers = $teamResult;
        }
        
        // Etkinlikleri çekmeyi deneyelim ve sorguyu logla
        \Log::info('Events sorgusu yapılıyor:', ['artist_id' => $artist['artist_id']]);
        
        // Sütun adlarıyla ilgili hatalar olduğu için basitleştirilmiş bir sorgu kullanalım
        // order seçeneğini kaldırdık ve tüm sütunları getiriyoruz
        try {
            $eventsResult = $this->supabaseService->select('events', [
                'event_artist' => 'eq.' . $artist['artist_id'],
                'select' => '*'
            ]);
            
            \Log::info('Etkinlik sorgusu sonuçları:', ['sonuç' => $eventsResult]);
            
            $events = [];
            if (!isset($eventsResult['error']) && !empty($eventsResult)) {
                $events = $eventsResult;
                \Log::info('Bulunan etkinlikler:', ['events' => $events]);
            } else {
                \Log::info('Etkinlik bulunamadı veya hata oluştu', [
                    'error' => isset($eventsResult['error']) ? $eventsResult['error'] : 'Sonuç boş'
                ]);
            }
        } catch (\Exception $e) {
            \Log::error('Etkinlik sorgusunda istisna oluştu: ' . $e->getMessage());
            $events = [];
        }
        
        return view('artists.show', compact('artist', 'plan', 'teamMembers', 'events'));
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
        
        // Sanatçı ID'sini logla
        \Log::info('Sanatçı ID değeri:', ['artist_id' => $artist['artist_id']]);
        
        // Abonelik planı bilgilerini çek
        $planResult = $this->supabaseService->select('subscription_plans', [
            'plan_id' => 'eq.' . $artist['subscription_plan'],
            'select' => '*'
        ]);
        
        $plan = null;
        if (!isset($planResult['error']) && !empty($planResult)) {
            $plan = $planResult[0];
        }
        
        // Ekip üyelerini çek
        $teamResult = $this->supabaseService->rpc('get_users_for_artist', [
            'artist_id_param' => $artist['artist_id']
        ]);
        
        $teamMembers = [];
        if (!isset($teamResult['error'])) {
            $teamMembers = $teamResult;
        }
        
        // Etkinlikleri çekmeyi deneyelim ve sorguyu logla
        \Log::info('Events sorgusu yapılıyor:', ['artist_id' => $artist['artist_id']]);
        
        // Sütun adlarıyla ilgili hatalar olduğu için basitleştirilmiş bir sorgu kullanalım
        // order seçeneğini kaldırdık ve tüm sütunları getiriyoruz
        try {
            $eventsResult = $this->supabaseService->select('events', [
                'event_artist' => 'eq.' . $artist['artist_id'],
                'select' => '*'
            ]);
            
            \Log::info('Etkinlik sorgusu sonuçları:', ['sonuç' => $eventsResult]);
            
            $events = [];
            if (!isset($eventsResult['error']) && !empty($eventsResult)) {
                $events = $eventsResult;
                \Log::info('Bulunan etkinlikler:', ['events' => $events]);
            } else {
                \Log::info('Etkinlik bulunamadı veya hata oluştu', [
                    'error' => isset($eventsResult['error']) ? $eventsResult['error'] : 'Sonuç boş'
                ]);
            }
        } catch (\Exception $e) {
            \Log::error('Etkinlik sorgusunda istisna oluştu: ' . $e->getMessage());
            $events = [];
        }
        
        return view('artists.show', compact('artist', 'plan', 'teamMembers', 'events'));
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

    /**
     * Telefon numarası ile kullanıcı arama
     */
    public function findUserByPhone(Request $request)
    {
        $phone = $request->input('phone');
        
        // Telefon numarasını standart formata çevir
        $formattedPhone = $this->formatPhoneNumber($phone);
        
        if (empty($formattedPhone)) {
            return response()->json([
                'success' => false,
                'message' => 'Geçersiz telefon numarası formatı'
            ]);
        }
        
        // Kullanıcıyı ara
        $result = $this->supabaseService->select('users', [
            'phone' => 'eq.' . $formattedPhone,
            'select' => 'user_id,user_name,user_surname,user_img,phone'
        ]);
        
        if (isset($result['error']) || empty($result)) {
            return response()->json([
                'success' => false,
                'message' => 'Bu telefon numarasına sahip kullanıcı bulunamadı'
            ]);
        }
        
        return response()->json([
            'success' => true,
            'user' => $result[0]
        ]);
    }
    
    /**
     * Sanatçı ekibine üye ekle
     */
    public function addTeamMember(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|string',
            'role' => 'required|in:admin,member'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Geçersiz veri'
            ]);
        }
        
        $manager = Session::get('manager');
        $userId = $request->input('user_id');
        $role = $request->input('role');
        
        // Sanatçının var olduğunu ve yöneticiye ait olduğunu kontrol et
        $artistResult = $this->supabaseService->select('artists', [
            'artist_id' => 'eq.' . $id,
            'related_manager' => 'eq.' . $manager['manager_id'],
            'select' => 'artist_id,artist_members,artist_admins'
        ]);
        
        if (isset($artistResult['error']) || empty($artistResult)) {
            return response()->json([
                'success' => false,
                'message' => 'Sanatçı bulunamadı veya bu sanatçıya erişim izniniz yok'
            ]);
        }
        
        $artist = $artistResult[0];
        
        // Mevcut ekip üyelerini diziye çevir
        $members = [];
        if (!empty($artist['artist_members'])) {
            $members = array_map('trim', explode(',', $artist['artist_members']));
            // Çift tırnakları temizle
            $members = array_map(function($member) {
                return trim($member, '"');
            }, $members);
        }
        
        $admins = [];
        if (!empty($artist['artist_admins'])) {
            $admins = array_map('trim', explode(',', $artist['artist_admins']));
            // Çift tırnakları temizle
            $admins = array_map(function($admin) {
                return trim($admin, '"');
            }, $admins);
        }
        
        // Kullanıcı ID'sini ilgili diziye ekle
        if ($role === 'admin') {
            // Eğer kullanıcı zaten admin değilse ekle
            if (!in_array($userId, $admins)) {
                $admins[] = $userId;
            }
            
            // Yönetici rolündeki kullanıcılar hem admin hem de member olarak eklenecek
            if (!in_array($userId, $members)) {
                $members[] = $userId;
            }
        } else {
            // Eğer kullanıcı zaten normal üye değilse ekle
            if (!in_array($userId, $members)) {
                $members[] = $userId;
            }
            
            // Admin'lerden kaldır (bir kişi hem üye hem admin olamaz)
            if (in_array($userId, $admins)) {
                $admins = array_diff($admins, [$userId]);
            }
        }
        
        // Güncellenmiş üye listelerini virgülle birleştir
        $updatedMembers = implode(',', $members);
        $updatedAdmins = implode(',', $admins);
        
        // Sanatçı bilgilerini güncelle
        $updateResult = $this->supabaseService->update('artists', [
            'artist_members' => $updatedMembers,
            'artist_admins' => $updatedAdmins
        ], [
            'artist_id' => 'eq.' . $id
        ]);
        
        if (isset($updateResult['error'])) {
            return response()->json([
                'success' => false,
                'message' => 'Ekip üyesi eklenirken bir hata oluştu: ' . $updateResult['error']
            ]);
        }
        
        return response()->json([
            'success' => true,
            'message' => 'Ekip üyesi başarıyla eklendi'
        ]);
    }
    
    /**
     * Sanatçı ekibinden üye çıkar
     */
    public function removeTeamMember(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Geçersiz veri'
            ]);
        }
        
        $manager = Session::get('manager');
        $userId = $request->input('user_id');
        
        // Sanatçının var olduğunu ve yöneticiye ait olduğunu kontrol et
        $artistResult = $this->supabaseService->select('artists', [
            'artist_id' => 'eq.' . $id,
            'related_manager' => 'eq.' . $manager['manager_id'],
            'select' => 'artist_id,artist_members,artist_admins'
        ]);
        
        if (isset($artistResult['error']) || empty($artistResult)) {
            return response()->json([
                'success' => false,
                'message' => 'Sanatçı bulunamadı veya bu sanatçıya erişim izniniz yok'
            ]);
        }
        
        $artist = $artistResult[0];
        
        // Mevcut ekip üyelerini diziye çevir
        $members = [];
        if (!empty($artist['artist_members'])) {
            $members = array_map('trim', explode(',', $artist['artist_members']));
            // Çift tırnakları temizle
            $members = array_map(function($member) {
                return trim($member, '"');
            }, $members);
        }
        
        $admins = [];
        if (!empty($artist['artist_admins'])) {
            $admins = array_map('trim', explode(',', $artist['artist_admins']));
            // Çift tırnakları temizle
            $admins = array_map(function($admin) {
                return trim($admin, '"');
            }, $admins);
        }
        
        // Kullanıcıyı her iki diziden de kaldır
        $members = array_diff($members, [$userId]);
        $admins = array_diff($admins, [$userId]);
        
        // Güncellenmiş üye listelerini virgülle birleştir
        $updatedMembers = implode(',', $members);
        $updatedAdmins = implode(',', $admins);
        
        // Sanatçı bilgilerini güncelle
        $updateResult = $this->supabaseService->update('artists', [
            'artist_members' => $updatedMembers,
            'artist_admins' => $updatedAdmins
        ], [
            'artist_id' => 'eq.' . $id
        ]);
        
        if (isset($updateResult['error'])) {
            return response()->json([
                'success' => false,
                'message' => 'Ekip üyesi çıkarılırken bir hata oluştu: ' . $updateResult['error']
            ]);
        }
        
        return response()->json([
            'success' => true,
            'message' => 'Ekip üyesi başarıyla çıkarıldı'
        ]);
    }
    
    /**
     * Ekip üyesinin rolünü değiştir
     */
    public function changeTeamMemberRole(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|string',
            'role' => 'required|in:admin,member'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Geçersiz veri'
            ]);
        }
        
        $manager = Session::get('manager');
        $userId = $request->input('user_id');
        $role = $request->input('role');
        
        // Sanatçının var olduğunu ve yöneticiye ait olduğunu kontrol et
        $artistResult = $this->supabaseService->select('artists', [
            'artist_id' => 'eq.' . $id,
            'related_manager' => 'eq.' . $manager['manager_id'],
            'select' => 'artist_id,artist_members,artist_admins'
        ]);
        
        if (isset($artistResult['error']) || empty($artistResult)) {
            return response()->json([
                'success' => false,
                'message' => 'Sanatçı bulunamadı veya bu sanatçıya erişim izniniz yok'
            ]);
        }
        
        $artist = $artistResult[0];
        
        // Mevcut ekip üyelerini diziye çevir
        $members = [];
        if (!empty($artist['artist_members'])) {
            $members = array_map('trim', explode(',', $artist['artist_members']));
            // Çift tırnakları temizle
            $members = array_map(function($member) {
                return trim($member, '"');
            }, $members);
        }
        
        $admins = [];
        if (!empty($artist['artist_admins'])) {
            $admins = array_map('trim', explode(',', $artist['artist_admins']));
            // Çift tırnakları temizle
            $admins = array_map(function($admin) {
                return trim($admin, '"');
            }, $admins);
        }
        
        // Kullanıcının rolünü değiştir
        if ($role === 'admin') {
            // Kullanıcıyı admin dizisine ekle
            if (!in_array($userId, $admins)) {
                $admins[] = $userId;
            }
            
            // Yönetici olan kullanıcılar aynı zamanda member listesinde de olacak
            if (!in_array($userId, $members)) {
                $members[] = $userId;
            }
        } else {
            // Kullanıcıyı normal üye dizisine ekle
            if (!in_array($userId, $members)) {
                $members[] = $userId;
            }
            
            // Kullanıcıyı admin dizisinden çıkar
            $admins = array_diff($admins, [$userId]);
        }
        
        // Güncellenmiş üye listelerini virgülle birleştir
        $updatedMembers = implode(',', $members);
        $updatedAdmins = implode(',', $admins);
        
        // Sanatçı bilgilerini güncelle
        $updateResult = $this->supabaseService->update('artists', [
            'artist_members' => $updatedMembers,
            'artist_admins' => $updatedAdmins
        ], [
            'artist_id' => 'eq.' . $id
        ]);
        
        if (isset($updateResult['error'])) {
            return response()->json([
                'success' => false,
                'message' => 'Ekip üyesi rolü değiştirilirken bir hata oluştu: ' . $updateResult['error']
            ]);
        }
        
        return response()->json([
            'success' => true,
            'message' => 'Ekip üyesi rolü başarıyla değiştirildi'
        ]);
    }
    
    /**
     * Telefon numarasını +90XXXXXXXXXX formatına dönüştür
     */
    private function formatPhoneNumber($phone)
    {
        // Telefon numarasından gereksiz karakterleri temizle
        $phone = preg_replace('/[^0-9]/', '', $phone);
        
        // Türkiye için +90 formatına çevir
        if (strlen($phone) === 10 && substr($phone, 0, 1) === '5') {
            // 5XXXXXXXXX formatında ise başına +90 ekle
            return '+90' . $phone;
        } elseif (strlen($phone) === 11 && substr($phone, 0, 1) === '0' && substr($phone, 1, 1) === '5') {
            // 05XXXXXXXXX formatında ise başındaki 0'ı kaldırıp +90 ekle
            return '+90' . substr($phone, 1);
        } elseif (strlen($phone) === 12 && substr($phone, 0, 2) === '90' && substr($phone, 2, 1) === '5') {
            // 905XXXXXXXXX formatında ise başına + ekle
            return '+' . $phone;
        } elseif (strlen($phone) === 13 && substr($phone, 0, 3) === '+90' && substr($phone, 3, 1) === '5') {
            // +905XXXXXXXXX formatında ise doğrudan döndür
            return $phone;
        }
        
        return null;
    }
} 