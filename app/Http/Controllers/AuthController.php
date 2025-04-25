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
        
        if ($userId && $token) {
            // Token doğrulama işlemi
            $isValid = $this->validateToken($userId, $token);
            
            if ($isValid) {
                // Supabase'den kullanıcıyı getir
                $result = $this->authService->getManagerById($userId);
                
                if ($result['success'] && !empty($result['manager'])) {
                    // Oturuma menajer bilgilerini kaydet
                    Session::put('manager', $result['manager']);
                    
                    // Kullanıcı tipine göre yönlendirme
                    return redirect()->intended('dashboard');
                }
            }
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
        
        // Gerçek uygulamada aşağıdaki kontrol daha güvenli olmalıdır
        // Önerilen yöntem: Token'ın veritabanında saklanması ve süresinin kontrol edilmesi
        
        // Şimdilik basit bir kontrol - üretim ortamında GÜVENLİ DEĞİLDİR!
        $expectedToken = hash('sha256', $userId . env('MOBILE_API_SECRET', 'ridr_mobile_secret_key'));
        
        return hash_equals($expectedToken, $token);
    }
} 