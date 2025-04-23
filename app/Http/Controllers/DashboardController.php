<?php

namespace App\Http\Controllers;

use App\Services\SupabaseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class DashboardController extends Controller
{
    protected $supabaseService;

    public function __construct(SupabaseService $supabaseService)
    {
        $this->supabaseService = $supabaseService;
    }

    /**
     * Dashboard sayfasını gösterir
     */
    public function index()
    {
        return view('dashboard');
    }

    /**
     * Menajer için ilişkili sanatçıları getirir - API endpoint'i
     */
    public function getAssociatedArtists(Request $request)
    {
        $manager = Session::get('manager');
        
        if (!$manager) {
            return response()->json(['error' => 'Oturum bulunamadı'], 401);
        }
        
        \Log::info('1. Menajer bilgileri:', ['manager_id' => $manager['manager_id']]);
        
        // Direkt olarak veritabanından ilişkili sanatçıları getirelim (RPC fonksiyonu bypass)
        $result = $this->supabaseService->select('artists', [
            'related_manager' => 'eq.' . $manager['manager_id'],
            'select' => 'artist_id,artist_name,artist_image,genre,artist_slug,subscription_plan'
        ]);
        
        if (isset($result['error'])) {
            \Log::error('2. Sanatçı getirme hatası:', ['error' => $result['error']]);
            return response()->json(['error' => 'Sanatçılar getirilirken bir hata oluştu'], 500);
        }
        
        \Log::info('3. Veritabanından dönen sanatçı sayısı:', ['count' => count($result)]);
        
        // Sanatçı planlarını belirle
        if (!empty($result)) {
            // Plan ID'lerini topla
            $planIds = [];
            foreach ($result as $artist) {
                if (isset($artist['subscription_plan']) && $artist['subscription_plan']) {
                    $planIds[] = $artist['subscription_plan'];
                }
            }
            
            if (!empty($planIds)) {
                $planIds = array_unique($planIds);
                \Log::info('4. Bulunan plan ID\'leri:', ['planIds' => $planIds]);
                
                // Plan ID'lerini SQL için formatla
                $planIdsStr = implode("','", $planIds);
                $planIdsStr = "'" . $planIdsStr . "'";
                
                // Plan bilgilerini veritabanından çek
                $plansResult = $this->supabaseService->select('subscription_plans', [
                    'select' => 'plan_id,plan_name,max_members,monthly_price,annual_price,price_currency'
                ]);
                
                if (!isset($plansResult['error']) && !empty($plansResult)) {
                    \Log::info('5. Tüm planlar başarıyla getirildi:', ['plan_count' => count($plansResult)]);
                    
                    // Plan haritası oluştur
                    $plans = [];
                    foreach ($plansResult as $plan) {
                        $plans[$plan['plan_id']] = $plan;
                    }
                    
                    // Sanatçılara plan bilgilerini ekle
                    foreach ($result as &$artist) {
                        if (isset($artist['subscription_plan']) && isset($plans[$artist['subscription_plan']])) {
                            $artist['plan'] = $plans[$artist['subscription_plan']];
                            \Log::debug('6. Sanatçıya plan bilgisi eklendi:', [
                                'artist_name' => $artist['artist_name'],
                                'plan_name' => $plans[$artist['subscription_plan']]['plan_name']
                            ]);
                        } else {
                            $artist['plan'] = null;
                        }
                    }
                } else {
                    \Log::error('5. Planlar getirilirken hata oluştu:', [
                        'error' => $plansResult['error'] ?? 'Bilinmeyen hata'
                    ]);
                }
            }
        }
        
        return response()->json($result);
    }
} 