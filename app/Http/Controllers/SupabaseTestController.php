<?php

namespace App\Http\Controllers;

use App\Services\SupabaseService;
use Illuminate\Http\Request;

class SupabaseTestController extends Controller
{
    protected $supabase;

    public function __construct(SupabaseService $supabase)
    {
        $this->supabase = $supabase;
    }

    public function index()
    {
        try {
            // Test için bağlantı bilgilerini göster
            $url = env('SUPABASE_URL');
            $key = substr(env('SUPABASE_KEY'), 0, 10) . '...'; // Güvenlik için anahtarın tamamını gösterme
            
            return view('test', [
                'status' => 'Supabase bağlantısı hazır',
                'url' => $url,
                'key' => $key
            ]);
        } catch (\Exception $e) {
            return view('test', [
                'status' => 'Hata: ' . $e->getMessage()
            ]);
        }
    }
}
