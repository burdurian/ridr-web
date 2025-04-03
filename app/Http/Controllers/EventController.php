<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

class EventController extends Controller
{
    public function index(Request $request)
    {
        // Auth sistemimizden kullanıcı bilgisini alıyoruz
        // Session'dan user_id veya manager_id'yi alıyoruz
        $userId = Session::get('user_id');
        $userType = Session::get('user_type'); // 'team' veya 'manager'
        
        // Kullanıcı giriş yapmamışsa login sayfasına yönlendir
        if (!$userId) {
            return redirect()->route('login');
        }
        
        // Supabase bağlantı bilgileri
        $supabaseUrl = env('SUPABASE_URL');
        $supabaseKey = env('SUPABASE_KEY');

        // Sanatçı filtreleri için ilişkili sanatçıları çek
        $artists = [];
        $cities = [];
        $eventTypes = [];
        
        try {
            // İlişkili sanatçıları get_associated_artists fonksiyonu ile çek
            $artistsResponse = Http::withHeaders([
                'apikey' => $supabaseKey,
                'Authorization' => 'Bearer ' . $supabaseKey,
                'Content-Type' => 'application/json',
                'Prefer' => 'return=representation'
            ])->post($supabaseUrl . '/rest/v1/rpc/get_associated_artists', [
                'user_id' => $userId,
                'user_type' => $userType
            ]);
            
            if (!$artistsResponse->successful()) {
                throw new \Exception('Sanatçılar getirilemedi: ' . $artistsResponse->body());
            }
            
            $artists = $artistsResponse->json();
            
            // Filtrelenmiş sanatçı ID'sini al (varsa)
            $filteredArtistId = $request->query('artist');
            
            // Filtre parametrelerini al
            $filteredCity = $request->query('city');
            $filteredEventType = $request->query('event_type');
            $dateRange = $request->query('date_range');
            $timeFilter = $request->query('time_filter', 'future'); // Varsayılan: gelecek etkinlikler
            
            // Supabase'e RPC isteği göndererek etkinlikleri çek
            $rpcParams = [
                'p_user_id' => $userId, // Login olan kullanıcının ID'sini kullan
                'p_filter_by_date' => 'false' // Tarih filtresini devre dışı bırak (başlangıçta)
            ];
            
            // Zaman filtresini ayarla
            if ($timeFilter === 'future') {
                $rpcParams['p_current_date'] = Carbon::now()->format('Y-m-d');
                $rpcParams['p_filter_by_date'] = 'true';
            } else {
                $rpcParams['p_current_date'] = null; // Tüm zamanlar
            }
            
            $response = Http::withHeaders([
                'apikey' => $supabaseKey,
                'Authorization' => 'Bearer ' . $supabaseKey,
                'Content-Type' => 'application/json',
                'Prefer' => 'return=representation'
            ])->post($supabaseUrl . '/rest/v1/rpc/get_user_events', $rpcParams);
            
            // İstek başarısız olursa hata fırlat
            if (!$response->successful()) {
                throw new \Exception('Etkinlikler getirilemedi: ' . $response->body());
            }
            
            // Başarılı cevap, etkinlikleri al
            $events = $response->json();
            
            // Etkinlik yoksa boş array döner
            if (empty($events)) {
                $events = [];
            }
            
            // Eğer etkinlikler varsa şehir ve etkinlik türlerini topla (filtre için)
            if (!empty($events)) {
                $cities = collect($events)->pluck('event_city')->unique()->sort()->values()->all();
                $eventTypes = collect($events)->pluck('event_type')->unique()->sort()->values()->all();
            }

            // Sanatçı filtresine göre etkinlikleri filtrele
            if ($filteredArtistId) {
                $filteredEvents = [];
                foreach ($events as $event) {
                    if ($event['event_artist'] === $filteredArtistId) {
                        $filteredEvents[] = $event;
                    }
                }
                $events = $filteredEvents;
            }
            
            // Şehir filtresine göre etkinlikleri filtrele
            if ($filteredCity) {
                $filteredEvents = [];
                foreach ($events as $event) {
                    if ($event['event_city'] === $filteredCity) {
                        $filteredEvents[] = $event;
                    }
                }
                $events = $filteredEvents;
            }
            
            // Etkinlik türüne göre filtrele
            if ($filteredEventType) {
                $filteredEvents = [];
                foreach ($events as $event) {
                    if ($event['event_type'] === $filteredEventType) {
                        $filteredEvents[] = $event;
                    }
                }
                $events = $filteredEvents;
            }
            
            // Tarih aralığına göre filtrele
            if ($dateRange) {
                // Format: "GG.AA.YYYY - GG.AA.YYYY"
                $dates = explode(' - ', $dateRange);
                if (count($dates) == 2) {
                    $startDate = Carbon::createFromFormat('d.m.Y', $dates[0])->startOfDay();
                    $endDate = Carbon::createFromFormat('d.m.Y', $dates[1])->endOfDay();
                    
                    $filteredEvents = [];
                    foreach ($events as $event) {
                        $eventDate = Carbon::parse($event['event_date']);
                        if ($eventDate->between($startDate, $endDate)) {
                            $filteredEvents[] = $event;
                        }
                    }
                    $events = $filteredEvents;
                }
            }
            
            // Etkinlikleri tarih formatına göre düzenle
            foreach ($events as &$event) {
                $eventDate = Carbon::parse($event['event_date']);
                $event['formatted_date'] = [
                    'day' => $eventDate->format('d'),
                    'month' => $eventDate->locale('tr')->shortMonthName, // Türkçe kısa ay adı
                ];
                
                // Ayları gruplamak için gereken bilgiler
                $event['month_year'] = [
                    'month_name' => $eventDate->locale('tr')->monthName, // Tam ay adı
                    'year' => $eventDate->format('Y'),
                    'sort_key' => $eventDate->format('Y-m'), // Sıralama için
                ];
            }
            
            // Etkinlikleri aylara göre grupla
            $groupedEvents = [];
            foreach ($events as $event) {
                $monthYearKey = $event['month_year']['sort_key'];
                if (!isset($groupedEvents[$monthYearKey])) {
                    $groupedEvents[$monthYearKey] = [
                        'month_name' => $event['month_year']['month_name'],
                        'year' => $event['month_year']['year'],
                        'sort_key' => $monthYearKey,
                        'events' => []
                    ];
                }
                $groupedEvents[$monthYearKey]['events'][] = $event;
            }
            
            // Ayları tarihe göre sırala (en yakın tarih en üstte)
            ksort($groupedEvents);
            
            // View'a verileri gönder
            return view('events.index', [
                'groupedEvents' => $groupedEvents,
                'userType' => $userType,
                'userName' => Session::get('user_name'),
                'artists' => $artists,
                'filteredArtistId' => $filteredArtistId,
                'cities' => $cities,
                'eventTypes' => $eventTypes
            ]);
            
        } catch (\Exception $e) {
            // Hata durumunda boş bir array ile view'ı çağırıyoruz
            
            return view('events.index', [
                'groupedEvents' => [], // Boş grup
                'userType' => $userType,
                'userName' => Session::get('user_name'),
                'artists' => $artists,
                'filteredArtistId' => null,
                'cities' => [],
                'eventTypes' => [],
                'error' => $e->getMessage()
            ]);
        }
    }
    
    /**
     * Test amaçlı dummy etkinlik verileri
     * Bu metodu artık kullanmıyoruz.
     */
    /* 
    private function getDummyEvents()
    {
        // Eski dummy veriler kodu kaldırıldı
    }
    */

    /**
     * Etkinlik detaylarını gösterir
     */
    public function show($eventId)
    {
        // Auth sistemimizden kullanıcı bilgisini alıyoruz
        $userId = Session::get('user_id');
        $userType = Session::get('user_type'); // 'team' veya 'manager'
        
        // Kullanıcı giriş yapmamışsa login sayfasına yönlendir
        if (!$userId) {
            return redirect()->route('login');
        }
        
        // Supabase bağlantı bilgileri
        $supabaseUrl = env('SUPABASE_URL');
        $supabaseKey = env('SUPABASE_KEY');
        
        try {
            // Etkinlik detaylarını getir
            $response = Http::withHeaders([
                'apikey' => $supabaseKey,
                'Authorization' => 'Bearer ' . $supabaseKey,
                'Content-Type' => 'application/json',
            ])->get($supabaseUrl . '/rest/v1/events', [
                'select' => 'event_id,event_title,event_date,event_time,event_city,event_type,event_description,event_stream,event_artist',
                'event_id' => 'eq.' . $eventId
            ]);
            
            if (!$response->successful()) {
                throw new \Exception('Etkinlik detayları getirilemedi: ' . $response->body());
            }
            
            $events = $response->json();
            
            if (empty($events)) {
                return redirect()->route('events.index')->withErrors('Etkinlik bulunamadı.');
            }
            
            $event = $events[0];
            
            // Sanatçı bilgilerini getir
            $artistResponse = Http::withHeaders([
                'apikey' => $supabaseKey,
                'Authorization' => 'Bearer ' . $supabaseKey,
                'Content-Type' => 'application/json',
            ])->get($supabaseUrl . '/rest/v1/artists', [
                'select' => 'artist_id,artist_name,artist_image',
                'artist_id' => 'eq.' . $event['event_artist']
            ]);
            
            if (!$artistResponse->successful()) {
                throw new \Exception('Sanatçı bilgileri getirilemedi: ' . $artistResponse->body());
            }
            
            $artists = $artistResponse->json();
            
            if (!empty($artists)) {
                $event['artist'] = $artists[0];
            } else {
                $event['artist'] = [
                    'artist_name' => 'Bilinmeyen Sanatçı',
                    'artist_image' => 'https://via.placeholder.com/150'
                ];
            }
            
            // Etkinlik akışını (stream) işle
            if (!empty($event['event_stream'])) {
                try {
                    // JSON string'i PHP dizisine çevir
                    $streamItems = json_decode($event['event_stream'], true);
                    
                    // Stream elemanlarını başlangıç saatine göre sırala
                    usort($streamItems, function($a, $b) {
                        return strtotime($a['time']) - strtotime($b['time']);
                    });
                    
                    // İşlenmiş stream verilerini etkinlik nesnesine ekle
                    $event['stream_items'] = $streamItems;
                } catch (\Exception $e) {
                    $event['stream_items'] = [];
                    \Log::error('Etkinlik akışı ayrıştırılamadı: ' . $e->getMessage());
                }
            } else {
                $event['stream_items'] = [];
            }
            
            // Tarihi ve saati formatlayalım
            $eventDate = Carbon::parse($event['event_date']);
            $event['formatted_date'] = $eventDate->locale('tr')->isoFormat('D MMMM YYYY');
            
            if (!empty($event['event_time'])) {
                $startTime = Carbon::parse($event['event_time'])->format('H:i');
                $event['formatted_time'] = $startTime;
            } else {
                $event['formatted_time'] = 'Belirtilmemiş';
            }
            
            return view('events.show', [
                'event' => $event,
                'userName' => Session::get('user_name'),
                'userType' => $userType
            ]);
            
        } catch (\Exception $e) {
            return redirect()->route('events.index')->withErrors('Etkinlik detayları alınırken bir hata oluştu: ' . $e->getMessage());
        }
    }
} 