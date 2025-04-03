<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    /**
     * Login işlemi
     */
    public function login(Request $request)
    {
        // Form validasyonu
        $request->validate([
            'identifier' => 'required|string',
            'password' => 'required',
            'userType' => 'required|in:team,manager',
        ]);
        
        // Şifreyi SHA-256 ile hashleme
        $hashedPassword = hash('sha256', $request->password);
        
        // Giriş bilgisinin telefon mu e-posta mı olduğunu kontrol et
        $identifier = $request->identifier;
        $isEmail = filter_var($identifier, FILTER_VALIDATE_EMAIL);
        
        // Telefon formatı doğrulama ve standartlaştırma
        $phoneFormats = [
            '/^\+90[5-9][0-9]{9}$/', // +905xxxxxxxxx formatı
            '/^0[5-9][0-9]{9}$/',    // 05xxxxxxxxx formatı
            '/^[5-9][0-9]{9}$/'      // 5xxxxxxxxx formatı (başında 0 olmadan)
        ];
        
        $isPhone = false;
        $normalizedPhone = null;
        
        foreach ($phoneFormats as $pattern) {
            if (preg_match($pattern, $identifier)) {
                $isPhone = true;
                
                // Telefon numarasını +90 standardına dönüştür
                if (preg_match('/^\+90/', $identifier)) {
                    $normalizedPhone = $identifier; // Zaten +90 formatında
                } else if (preg_match('/^0/', $identifier)) {
                    $normalizedPhone = '+90' . substr($identifier, 1); // 0'ı kaldır, +90 ekle
                } else {
                    $normalizedPhone = '+90' . $identifier; // Başına +90 ekle
                }
                
                break;
            }
        }
        
        if (!$isEmail && !$isPhone) {
            return back()->withErrors([
                'identifier' => 'Geçerli bir e-posta adresi veya telefon numarası giriniz.',
            ]);
        }
        
        // Supabase bağlantı bilgileri
        $supabaseUrl = env('SUPABASE_URL');
        $supabaseKey = env('SUPABASE_KEY');
        
        if (!$supabaseUrl || !$supabaseKey) {
            return back()->withErrors(['error' => 'Supabase bağlantı bilgileri eksik.']);
        }
        
        try {
            if ($request->userType === 'team') {
                // Ekip üyesi girişi - users tablosundan kullanıcıyı sorgula
                $queryParams = [
                    'select' => 'user_id,mail,phone,pass,user_name,user_surname,user_username',
                    'pass' => 'eq.' . $hashedPassword,
                ];
                
                // E-posta veya telefon filtresini ekle
                if ($isEmail) {
                    $queryParams['mail'] = 'eq.' . $identifier;
                } else {
                    $queryParams['phone'] = 'eq.' . $normalizedPhone;
                }
                
                $response = Http::withHeaders([
                    'apikey' => $supabaseKey,
                    'Authorization' => 'Bearer ' . $supabaseKey,
                    'Content-Type' => 'application/json',
                ])->get($supabaseUrl . '/rest/v1/users', $queryParams);
                
                if (!$response->successful()) {
                    throw new \Exception('Kullanıcı sorgulanırken hata: ' . $response->body());
                }
                
                $users = $response->json();
                
                if (empty($users)) {
                    return back()->withErrors([
                        'identifier' => 'Geçersiz e-posta/telefon veya şifre.',
                    ])->withInput($request->except('password'));
                }
                
                $user = $users[0]; // İlk eşleşen kullanıcı
                
                // Session'a kullanıcı bilgilerini kaydet
                Session::put('user_id', $user['user_id']);
                Session::put('user_type', 'team');
                Session::put('user_email', $user['mail']);
                Session::put('user_name', $user['user_name'] . ' ' . $user['user_surname']);
                
            } else {
                // Menajer girişi - managers tablosundan sorgu
                $queryParams = [
                    'select' => 'manager_id,manager_email,manager_phone,manager_pass,manager_name,manager_surname,company',
                    'manager_pass' => 'eq.' . $hashedPassword,
                ];
                
                // E-posta veya telefon filtresini ekle
                if ($isEmail) {
                    $queryParams['manager_email'] = 'eq.' . $identifier;
                } else {
                    $queryParams['manager_phone'] = 'eq.' . $normalizedPhone;
                }
                
                $response = Http::withHeaders([
                    'apikey' => $supabaseKey,
                    'Authorization' => 'Bearer ' . $supabaseKey,
                    'Content-Type' => 'application/json',
                ])->get($supabaseUrl . '/rest/v1/managers', $queryParams);
                
                if (!$response->successful()) {
                    throw new \Exception('Menajer sorgulanırken hata: ' . $response->body());
                }
                
                $managers = $response->json();
                
                if (empty($managers)) {
                    return back()->withErrors([
                        'identifier' => 'Geçersiz e-posta/telefon veya şifre.',
                    ])->withInput($request->except('password'));
                }
                
                $manager = $managers[0]; // İlk eşleşen menajer
                
                // Session'a menajer bilgilerini kaydet
                Session::put('user_id', $manager['manager_id']);
                Session::put('user_type', 'manager');
                Session::put('user_email', $manager['manager_email']);
                Session::put('user_name', $manager['manager_name'] . ' ' . $manager['manager_surname']);
                Session::put('company', $manager['company']);
            }
            
            return redirect()->route('events.index');
            
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Giriş yapılırken bir hata oluştu: ' . $e->getMessage()]);
        }
    }
    
    /**
     * Logout işlemi
     */
    public function logout()
    {
        Session::forget(['user_id', 'user_type', 'user_email', 'user_name', 'company']);
        return redirect()->route('login');
    }
} 