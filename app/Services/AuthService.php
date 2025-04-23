<?php

namespace App\Services;

use App\Models\Manager;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    protected $supabaseService;

    public function __construct(SupabaseService $supabaseService)
    {
        $this->supabaseService = $supabaseService;
    }

    /**
     * Telefon numarasını standart formata çevirir (+901234567890)
     */
    public function normalizePhoneNumber(string $phone): string
    {
        // Tüm boşlukları ve özel karakterleri temizle
        $phone = preg_replace('/\D/', '', $phone);
        
        // Türkiye numarası için başında 0 veya 90 kontrolü yap
        if (strlen($phone) === 10 && substr($phone, 0, 1) === '5') {
            // 5XXXXXXXXX formatı - başına +90 ekle
            return '+90' . $phone;
        } elseif (strlen($phone) === 11 && substr($phone, 0, 1) === '0' && substr($phone, 1, 1) === '5') {
            // 05XXXXXXXXX formatı - 0'ı kaldır, başına +90 ekle
            return '+90' . substr($phone, 1);
        } elseif (strlen($phone) === 12 && substr($phone, 0, 2) === '90' && substr($phone, 2, 1) === '5') {
            // 905XXXXXXXXX formatı - başına + ekle
            return '+' . $phone;
        } elseif (strlen($phone) === 13 && substr($phone, 0, 3) === '+90' && substr($phone, 3, 1) === '5') {
            // +905XXXXXXXXX formatı - olduğu gibi döndür
            return $phone;
        }
        
        // Diğer durumlarda olduğu gibi döndür
        return $phone;
    }

    /**
     * SHA-256 hashleme işlemi
     */
    public function hashPassword(string $password): string
    {
        return hash('sha256', $password);
    }

    /**
     * Menajer girişi
     */
    public function authenticate(string $phone, string $password): array
    {
        try {
            $normalizedPhone = $this->normalizePhoneNumber($phone);
            $hashedPassword = $this->hashPassword($password);
            
            // Supabase'den menajer verisini çek
            $result = $this->supabaseService->select('managers', [
                'manager_phone' => 'eq.' . $normalizedPhone,
                'select' => 'manager_id,manager_name,manager_surname,manager_email,manager_phone,company,company_logo,manager_pass'
            ]);
            
            if (isset($result['error']) || empty($result)) {
                Log::error('Menajer sorgulamada hata: ' . (isset($result['error']) ? $result['error'] : 'Menajer bulunamadı'));
                return [
                    'success' => false,
                    'message' => 'Geçersiz telefon numarası veya parola.'
                ];
            }
            
            $manager = $result[0] ?? null;
            
            if (!$manager || $manager['manager_pass'] !== $hashedPassword) {
                return [
                    'success' => false,
                    'message' => 'Geçersiz telefon numarası veya parola.'
                ];
            }
            
            // Şifreyi çıkart
            unset($manager['manager_pass']);
            
            return [
                'success' => true,
                'manager' => $manager
            ];
        } catch (\Exception $e) {
            Log::error('Kimlik doğrulama hatası: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Giriş işlemi sırasında bir hata oluştu. Lütfen daha sonra tekrar deneyin.'
            ];
        }
    }
    
    /**
     * Supabase tablosundaki verileri Laravel Manager modeline dönüştürür
     */
    public function mapToModel(array $managerData): Manager
    {
        return new Manager([
            'manager_id' => $managerData['manager_id'],
            'manager_name' => $managerData['manager_name'],
            'manager_surname' => $managerData['manager_surname'],
            'manager_email' => $managerData['manager_email'],
            'manager_phone' => $managerData['manager_phone'],
            'company' => $managerData['company'] ?? null,
            'company_logo' => $managerData['company_logo'] ?? null,
        ]);
    }
} 