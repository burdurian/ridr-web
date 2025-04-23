<?php

namespace App\Http\Controllers;

use App\Models\SubscriptionPlan;
use App\Services\SubscriptionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SubscriptionController extends Controller
{
    protected $subscriptionService;

    public function __construct(SubscriptionService $subscriptionService)
    {
        $this->subscriptionService = $subscriptionService;
    }

    /**
     * Kullanılabilir abonelik planlarını görüntüler
     */
    public function index()
    {
        $plans = SubscriptionPlan::where('is_active', true)->get();
        return view('subscriptions.index', compact('plans'));
    }

    /**
     * Abonelik oluşturma formunu görüntüler
     */
    public function create(SubscriptionPlan $plan)
    {
        if (!$plan->is_active) {
            return redirect()->route('subscriptions.index')
                ->with('error', 'Bu abonelik planı artık mevcut değil.');
        }

        return view('subscriptions.create', compact('plan'));
    }

    /**
     * Abonelik oluşturma işlemini başlatır
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'plan_id' => 'required|exists:subscription_plans,id',
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'country' => 'required|string|max:100',
            'supabase_user_id' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $userData = $request->only([
            'name', 'surname', 'email', 'phone', 'address', 'city', 'country'
        ]);

        $callbackUrl = route('subscriptions.callback');
        
        $result = $this->subscriptionService->createSubscription(
            $request->input('supabase_user_id'),
            $request->input('plan_id'),
            $userData,
            $callbackUrl
        );

        if (!$result['success']) {
            return redirect()->back()
                ->with('error', $result['message'])
                ->withInput();
        }

        // Ödeme sayfasına yönlendir
        return redirect()->away($result['redirect_url']);
    }

    /**
     * İyzico'dan gelen ödeme sonucunu işler
     */
    public function callback(Request $request)
    {
        $token = $request->input('token');

        if (!$token) {
            return redirect()->route('subscriptions.index')
                ->with('error', 'Geçersiz işlem.');
        }

        $result = $this->subscriptionService->handleSubscriptionCallback($token);

        if (!$result['success']) {
            return redirect()->route('subscriptions.index')
                ->with('error', $result['message']);
        }

        return redirect()->route('dashboard')
            ->with('success', 'Aboneliğiniz başarıyla oluşturuldu!');
    }

    /**
     * Kullanıcının aktif aboneliğini görüntüler
     */
    public function show(Request $request)
    {
        $userId = $request->input('supabase_user_id');
        
        if (!$userId) {
            return redirect()->route('subscriptions.index')
                ->with('error', 'Kullanıcı bilgisi bulunamadı.');
        }
        
        $subscription = $this->subscriptionService->getActiveSubscription($userId);
        
        if (!$subscription) {
            return redirect()->route('subscriptions.index')
                ->with('error', 'Aktif abonelik bulunamadı.');
        }
        
        return view('subscriptions.show', compact('subscription'));
    }

    /**
     * Aboneliği iptal etme formunu görüntüler
     */
    public function cancel(Request $request, $id)
    {
        $subscription = $this->subscriptionService->getActiveSubscription($request->input('supabase_user_id'));
        
        if (!$subscription || $subscription->id != $id) {
            return redirect()->route('dashboard')
                ->with('error', 'Abonelik bulunamadı veya size ait değil.');
        }
        
        return view('subscriptions.cancel', compact('subscription'));
    }

    /**
     * Aboneliği iptal etme işlemini gerçekleştirir
     */
    public function destroy(Request $request, $id)
    {
        $immediately = $request->has('immediately');
        
        $result = $this->subscriptionService->cancelSubscription($id, $immediately);
        
        if (!$result['success']) {
            return redirect()->back()
                ->with('error', $result['message']);
        }
        
        return redirect()->route('dashboard')
            ->with('success', $result['message']);
    }
}
