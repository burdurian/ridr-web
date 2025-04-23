<?php

namespace App\Services;

use App\Models\Subscription;
use App\Models\SubscriptionPlan;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class SubscriptionService
{
    protected $iyzicoService;
    protected $supabaseService;

    public function __construct(IyzicoService $iyzicoService, SupabaseService $supabaseService)
    {
        $this->iyzicoService = $iyzicoService;
        $this->supabaseService = $supabaseService;
    }

    /**
     * Kullanıcıya yeni bir abonelik oluşturur
     *
     * @param string $userId Supabase kullanıcı ID'si
     * @param int $planId Abonelik planı ID'si
     * @param array $userData Kullanıcı bilgileri
     * @param string $callbackUrl İşlem sonrası yönlendirilecek URL
     * @return array
     */
    public function createSubscription(string $userId, int $planId, array $userData, string $callbackUrl)
    {
        try {
            // Planı veritabanından al
            $plan = SubscriptionPlan::findOrFail($planId);
            
            if (!$plan->is_active) {
                return [
                    'success' => false,
                    'message' => 'Bu abonelik planı şu anda aktif değil.'
                ];
            }
            
            // İyzico abonelik başlatma işlemi için parametreleri hazırla
            $subscriptionParams = [
                'conversation_id' => uniqid('sub_'),
                'pricing_plan_reference_code' => $plan->iyzico_plan_reference,
                'callback_url' => $callbackUrl,
                'buyer' => [
                    'id' => $userId,
                    'name' => $userData['name'] ?? 'İsimsiz',
                    'surname' => $userData['surname'] ?? 'Kullanıcı',
                    'gsm_number' => $userData['phone'] ?? '',
                    'email' => $userData['email'] ?? '',
                    'identity_number' => $userData['identity_number'] ?? '11111111111',
                    'address' => $userData['address'] ?? '',
                    'ip' => request()->ip(),
                    'city' => $userData['city'] ?? 'İstanbul',
                    'country' => $userData['country'] ?? 'Türkiye',
                ],
                'billing_address' => [
                    'contact_name' => $userData['name'] . ' ' . $userData['surname'],
                    'city' => $userData['city'] ?? 'İstanbul',
                    'country' => $userData['country'] ?? 'Türkiye',
                    'address' => $userData['address'] ?? '',
                ]
            ];
            
            // İyzico'da abonelik işlemini başlat
            $response = $this->iyzicoService->initializeSubscription($subscriptionParams);
            
            if (isset($response->getErrorCode)) {
                Log::error('İyzico subscription error: ' . $response->getErrorMessage());
                return [
                    'success' => false,
                    'message' => 'Abonelik oluşturulurken bir hata oluştu: ' . $response->getErrorMessage()
                ];
            }
            
            // Aboneliği veritabanında oluştur
            $startDate = Carbon::now();
            $endDate = $this->calculatePeriodEndDate($startDate, $plan->billing_period);
            
            $subscription = new Subscription([
                'supabase_user_id' => $userId,
                'subscription_plan_id' => $plan->id,
                'iyzico_subscription_reference' => $response->getReferenceCode(),
                'status' => 'pending',
                'current_period_starts_at' => $startDate,
                'current_period_ends_at' => $endDate,
            ]);
            
            // Deneme süresi varsa ekle
            if ($plan->hasTrial()) {
                $subscription->status = 'trial';
                $subscription->trial_ends_at = Carbon::now()->addDays($plan->trial_days);
            }
            
            $subscription->save();
            
            // İşlem başarılı, ödeme formunu yönlendir
            return [
                'success' => true,
                'redirect_url' => $response->getPaymentPageUrl(),
                'subscription_id' => $subscription->id
            ];
        } catch (\Exception $e) {
            Log::error('Subscription creation error: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Abonelik oluşturulurken bir hata oluştu: ' . $e->getMessage()
            ];
        }
    }
    
    /**
     * Abonelik ödeme işleminin sonucunu işler
     *
     * @param string $token İşlem token'ı
     * @return array
     */
    public function handleSubscriptionCallback(string $token)
    {
        try {
            // İyzico'dan ödeme sonucunu al
            $result = $this->iyzicoService->retrieveCheckoutForm($token);
            
            if (isset($result->getErrorCode)) {
                Log::error('İyzico payment result error: ' . $result->getErrorMessage());
                return [
                    'success' => false,
                    'message' => 'Ödeme sonucu alınırken bir hata oluştu: ' . $result->getErrorMessage()
                ];
            }
            
            // Ödeme başarılı mı kontrol et
            if ($result->getPaymentStatus() === 'SUCCESS') {
                // Aboneliği bul ve güncelle
                $subscription = Subscription::where('iyzico_subscription_reference', $result->getReferenceCode())->first();
                
                if (!$subscription) {
                    return [
                        'success' => false,
                        'message' => 'Abonelik bulunamadı.'
                    ];
                }
                
                // Deneme süresi yoksa veya deneme süresi bittiyse aktif olarak işaretle
                if (!$subscription->onTrial()) {
                    $subscription->markAsActive();
                }
                
                return [
                    'success' => true,
                    'subscription' => $subscription,
                    'message' => 'Abonelik başarıyla oluşturuldu.'
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'Ödeme işlemi başarısız oldu.'
                ];
            }
        } catch (\Exception $e) {
            Log::error('Subscription callback error: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Ödeme sonucu işlenirken bir hata oluştu: ' . $e->getMessage()
            ];
        }
    }
    
    /**
     * Kullanıcının aktif aboneliğini getirir
     *
     * @param string $userId Supabase kullanıcı ID'si
     * @return Subscription|null
     */
    public function getActiveSubscription(string $userId)
    {
        return Subscription::where('supabase_user_id', $userId)
            ->whereIn('status', ['active', 'trial'])
            ->where(function ($query) {
                $query->whereNull('current_period_ends_at')
                    ->orWhere('current_period_ends_at', '>', now());
            })
            ->latest()
            ->first();
    }
    
    /**
     * Aboneliği iptal eder
     *
     * @param int $subscriptionId Abonelik ID'si
     * @param bool $immediately Hemen iptal edilsin mi (true) yoksa dönem sonunda mı (false)
     * @return array
     */
    public function cancelSubscription(int $subscriptionId, bool $immediately = false)
    {
        try {
            $subscription = Subscription::findOrFail($subscriptionId);
            
            if ($immediately) {
                // Hemen iptal et
                $subscription->markAsCanceled();
                
                // İyzico'da iptal işlemi yapılabilir
                // $this->iyzicoService->cancelSubscription($subscription->iyzico_subscription_reference);
                
                return [
                    'success' => true,
                    'message' => 'Abonelik iptal edildi.'
                ];
            } else {
                // Dönem sonunda iptal et
                $subscription->cancelAtPeriodEnd();
                
                return [
                    'success' => true,
                    'message' => 'Abonelik dönem sonunda iptal edilecek.'
                ];
            }
        } catch (\Exception $e) {
            Log::error('Subscription cancellation error: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Abonelik iptal edilirken bir hata oluştu: ' . $e->getMessage()
            ];
        }
    }
    
    /**
     * Periyot bitiş tarihini hesaplar
     *
     * @param Carbon $startDate Başlangıç tarihi
     * @param string $billingPeriod Periyot türü (monthly, yearly)
     * @return Carbon
     */
    private function calculatePeriodEndDate(Carbon $startDate, string $billingPeriod): Carbon
    {
        if ($billingPeriod === 'yearly') {
            return $startDate->copy()->addYear();
        }
        
        return $startDate->copy()->addMonth();
    }
} 