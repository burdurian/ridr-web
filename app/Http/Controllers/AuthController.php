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
            'email' => 'required|email',
            'password' => 'required',
            'userType' => 'required|in:team,manager',
        ]);
        
        // Şifreyi SHA-256 ile hashleme
        $hashedPassword = hash('sha256', $request->password);
        
        // Supabase bağlantı bilgileri
        $supabaseUrl = env('SUPABASE_URL');
        $supabaseKey = env('SUPABASE_KEY');
        
        if (!$supabaseUrl || !$supabaseKey) {
            return back()->withErrors(['error' => 'Supabase bağlantı bilgileri eksik.']);
        }
        
        try {
            if ($request->userType === 'team') {
                // Ekip üyesi girişi - users tablosundan kullanıcıyı sorgula
                $response = Http::withHeaders([
                    'apikey' => $supabaseKey,
                    'Authorization' => 'Bearer ' . $supabaseKey,
                    'Content-Type' => 'application/json',
                ])->get($supabaseUrl . '/rest/v1/users', [
                    'select' => 'user_id,mail,pass,user_name,user_surname,user_username',
                    'mail' => 'eq.' . $request->email,
                    'pass' => 'eq.' . $hashedPassword,
                ]);
                
                if (!$response->successful()) {
                    throw new \Exception('Kullanıcı sorgulanırken hata: ' . $response->body());
                }
                
                $users = $response->json();
                
                if (empty($users)) {
                    return back()->withErrors([
                        'email' => 'Geçersiz e-posta veya şifre.',
                    ]);
                }
                
                $user = $users[0]; // İlk eşleşen kullanıcı
                
                // Session'a kullanıcı bilgilerini kaydet
                Session::put('user_id', $user['user_id']);
                Session::put('user_type', 'team');
                Session::put('user_email', $user['mail']);
                Session::put('user_name', $user['user_name'] . ' ' . $user['user_surname']);
                
            } else {
                // Menajer girişi - managers tablosundan sorgu
                $response = Http::withHeaders([
                    'apikey' => $supabaseKey,
                    'Authorization' => 'Bearer ' . $supabaseKey,
                    'Content-Type' => 'application/json',
                ])->get($supabaseUrl . '/rest/v1/managers', [
                    'select' => 'manager_id,manager_email,manager_pass,manager_name,manager_surname,company',
                    'manager_email' => 'eq.' . $request->email,
                    'manager_pass' => 'eq.' . $hashedPassword,
                ]);
                
                if (!$response->successful()) {
                    throw new \Exception('Menajer sorgulanırken hata: ' . $response->body());
                }
                
                $managers = $response->json();
                
                if (empty($managers)) {
                    return back()->withErrors([
                        'email' => 'Geçersiz e-posta veya şifre.',
                    ]);
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