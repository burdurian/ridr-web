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

        // Kullanıcıyı kayıtlı intended URL'e veya dashboard'a yönlendir
        $intendedUrl = Session::get('url.intended');
        
        if ($intendedUrl) {
            Session::forget('url.intended');
            return redirect($intendedUrl);
        }
        
        // Eğer intended URL yoksa dashboard'a yönlendir
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
} 