<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * Login sayfasını gösterir
     */
    public function showLoginForm()
    {
        if (Session::has('manager')) {
            return redirect()->route('dashboard');
        }
        
        return view('auth.login');
    }

    /**
     * Giriş işlemini gerçekleştirir
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required|string',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput($request->except('password'));
        }

        $result = $this->authService->authenticate(
            $request->input('phone'),
            $request->input('password')
        );

        if (!$result['success']) {
            return redirect()->back()
                ->with('error', $result['message'])
                ->withInput($request->except('password'));
        }

        // Oturuma menajer bilgilerini kaydet
        Session::put('manager', $result['manager']);

        // Dashboard'a yönlendir
        return redirect()->route('dashboard');
    }

    /**
     * Oturumu sonlandırır
     */
    public function logout()
    {
        Session::forget('manager');
        return redirect()->route('login');
    }
    
    /**
     * Mobil uygulama token kontrolü ve otomatik giriş
     */
    public function checkMobileToken(Request $request)
    {
        $userId = $request->query('userId');
        $token = $request->query('token');
        
        // Debug için parametreleri logla
        \Log::info('WebView Token Check', [
            'userId' => $userId,
            'token' => $token,
            'allParams' => $request->all(),
            'url' => $request->fullUrl()
        ]);
        
        if ($userId && $token) {
            // Token doğrulama işlemi
            $isValid = $this->validateToken($userId, $token);
            
            // Debug için validasyon sonucunu logla
            \Log::info('Token Validation', [
                'userId' => $userId, 
                'token' => $token,
                'isValid' => $isValid,
                'expectedToken' => hash('sha256', $userId . env('MOBILE_API_SECRET', 'ridr_mobile_secret_key'))
            ]);
            
            if ($isValid) {
                // Supabase'den kullanıcıyı getir
                $result = $this->authService->getManagerById($userId);
                
                // Debug için kullanıcı sorgusu sonucunu logla
                \Log::info('Manager Query Result', ['result' => $result]);
                
                if ($result['success'] && !empty($result['manager'])) {
                    // Oturuma menajer bilgilerini kaydet
                    Session::put('manager', $result['manager']);
                    
                    // Debug bilgisi logla
                    \Log::info('Auto Login Success', ['managerId' => $userId]);
                    
                    // Kullanıcı tipine göre yönlendirme
                    return redirect()->intended('dashboard');
                } else {
                    \Log::warning('Manager not found or query failed', ['managerId' => $userId]);
                }
            } else {
                \Log::warning('Token validation failed', ['userId' => $userId, 'token' => $token]);
            }
        } else {
            \Log::info('No token parameters provided in WebView request');
        }
        
        // Eğer zaten bir oturum varsa, dashboard'a yönlendir
        if (Session::has('manager')) {
            return redirect()->route('dashboard');
        }
        
        // Normal sayfa görüntüleme
        return view('auth.login');
    }

    /**
     * Token doğrulama işlemi
     */
    private function validateToken($userId, $token)
    {
        // Burada güvenlik kontrolü yapılacak
        // Örneğin: Token bir SHA-256 hash ve userId ile birlikte özel bir anahtar kullanarak oluşturulmuş olabilir
        
        if (empty($userId) || empty($token)) {
            return false;
        }
        
        // Geliştirme aşamasında, doğrulamayı daha kolay test etmek için
        if (env('APP_ENV') === 'local' || env('APP_ENV') === 'development') {
            // Test için basit kontrol - local veya development ortamında token kontrolünü bypass et
            if ($token === 'test_token') {
                return true;
            }
        }
        
        // Gerçek uygulamada aşağıdaki kontrol daha güvenli olmalıdır
        // Önerilen yöntem: Token'ın veritabanında saklanması ve süresinin kontrol edilmesi
        
        // Şimdilik basit bir kontrol - üretim ortamında GÜVENLİ DEĞİLDİR!
        $mobileApiSecret = env('MOBILE_API_SECRET', 'ridr_mobile_secret_key');
        $expectedToken = hash('sha256', $userId . $mobileApiSecret);
        
        return hash_equals($expectedToken, $token);
    }
} 