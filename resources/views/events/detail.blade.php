<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $event['event_title'] }} | Ridr</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #fdfdfc;
            color: #333;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem 1rem;
        }
        
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }
        
        .page-title {
            font-size: 1.75rem;
            font-weight: 600;
            color: #111827;
            margin: 0;
        }
        
        .user-welcome {
            display: flex;
            align-items: center;
        }
        
        .user-name {
            margin-right: 1rem;
            color: #4b5563;
            font-size: 0.95rem;
        }
        
        .logout-btn {
            padding: 0.5rem 1rem;
            background-color: #f3f4f6;
            color: #4b5563;
            border-radius: 8px;
            font-size: 0.875rem;
            text-decoration: none;
            transition: all 0.2s ease;
        }
        
        .logout-btn:hover {
            background-color: #e5e7eb;
        }
        
        .back-link {
            display: inline-flex;
            align-items: center;
            color: #4b5563;
            text-decoration: none;
            font-size: 0.95rem;
            margin-bottom: 1.5rem;
        }
        
        .back-link:hover {
            color: #374151;
        }
        
        .back-link svg {
            width: 1.25rem;
            height: 1.25rem;
            margin-right: 0.5rem;
        }
        
        .card {
            background-color: white;
            border-radius: 12px;
            border: 1px solid #e5e7eb;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.02);
            margin-bottom: 1.5rem;
            overflow: hidden;
        }
        
        .card-header {
            padding: 1.25rem 1.5rem 0;
            font-weight: 600;
            color: #374151;
            font-size: 1.125rem;
        }
        
        .card-body {
            padding: 1rem 1.5rem 1.5rem;
        }
        
        .mb-4 {
            margin-bottom: 1rem;
        }
        
        .mb-6 {
            margin-bottom: 1.5rem;
        }
        
        .row {
            display: flex;
            flex-wrap: wrap;
            margin-left: -0.75rem;
            margin-right: -0.75rem;
        }
        
        .col {
            padding-left: 0.75rem;
            padding-right: 0.75rem;
            width: 100%;
        }
        
        .col-12 {
            width: 100%;
        }
        
        .col-md-4 {
            width: 100%;
        }
        
        .col-md-6 {
            width: 100%;
        }
        
        .col-md-8 {
            width: 100%;
        }
        
        @media (min-width: 768px) {
            .col-md-4 {
                width: 33.333333%;
            }
            
            .col-md-6 {
                width: 50%;
            }
            
            .col-md-8 {
                width: 66.666667%;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Sayfa Başlık ve Çıkış -->
        <div class="page-header">
            <h1 class="page-title">Etkinlik Detayı</h1>
            <div class="user-welcome">
                <span class="user-name">Hoş geldin, {{ $userName ?? 'Kullanıcı' }}</span>
                <a href="{{ route('auth.logout') }}" class="logout-btn">Çıkış Yap</a>
            </div>
        </div>
        
        <!-- Geri Dön Linki -->
        <a href="{{ route('events.index') }}" class="back-link">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
            </svg>
            Etkinliklere Dön
        </a>
        
        <!-- Üst Satır: Tek Kart Etkinlik Bilgileri ve Açıklaması -->
        <div class="row mb-6">
            <div class="col col-12">
                <div class="card">
                    <div class="card-body" style="padding: 1.5rem;">
                        <div style="display: flex; gap: 1.5rem;">
                            <!-- Sol Kısım: Etkinlik Bilgileri -->
                            <div style="flex: 1; min-width: 0;">
                                <div style="display: flex;">
                                    <div class="event-image-container" style="width: 160px; margin-right: 1rem;">
                                        <img src="{{ $event['artist_image'] }}" alt="{{ $event['artist_name'] }}" 
                                             style="width: 100%; height: 160px; object-fit: cover; border-radius: 8px;">
                                    </div>
                                    <div class="event-info-container">
                                        <h2 style="font-size: 1.5rem; font-weight: 600; color: #111827; margin-bottom: 0.5rem;">
                                            {{ $event['event_title'] }}
                                        </h2>
                                        <div style="font-size: 1.1rem; color: #4b5563; margin-bottom: 0.5rem;">
                                            {{ $event['artist_name'] }}
                                        </div>
                                        
                                        <div style="display: flex; align-items: center; color: #6b7280; font-size: 0.9rem; margin-bottom: 0.75rem;">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width: 1rem; height: 1rem; margin-right: 0.25rem;">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                                            </svg>
                                            {{ $event['formatted_date']['full'] }}, {{ isset($event['event_time']) ? \Carbon\Carbon::parse($event['event_time'])->format('H.i') : $event['formatted_date']['time'] }}
                                        </div>
                                        
                                        <div class="event-meta" style="display: flex; gap: 0.5rem;">
                                            <span class="event-pill event-city" 
                                                  style="font-size: 0.75rem; padding: 0.375rem 0.75rem; border-radius: 9999px; 
                                                         background-color: #ede9fe; color: #5b21b6; font-weight: 500;">
                                                {{ $event['event_city'] }}
                                            </span>
                                            <span class="event-pill event-type"
                                                  style="font-size: 0.75rem; padding: 0.375rem 0.75rem; border-radius: 9999px; 
                                                         background-color: #f3f4f6; color: #4b5563; font-weight: 500;">
                                                {{ $event['event_type'] }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            @if(isset($event['event_details']) && !empty($event['event_details']))
                            <!-- Dikey Ayraç -->
                            <div style="width: 1px; background-color: #e5e7eb;"></div>
                            
                            <!-- Sağ Kısım: Etkinlik Açıklaması -->
                            <div style="flex: 1; min-width: 0; display: flex; flex-direction: column; justify-content: center;">
                                <h3 style="font-size: 1.125rem; font-weight: 600; color: #374151; margin-top: 0; margin-bottom: 1rem;">
                                    Etkinlik Açıklaması
                                </h3>
                                
                                <div style="line-height: 1.6; color: #4b5563;">
                                    {!! nl2br(e($event['event_details'])) !!}
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Alt Satır: Farklı Genişlikte İki Sütun (md-4 ve md-8) -->
        <div class="row">
            <!-- Sol Sütun (md-4): Etkinlik Akışı ve Katılımcılar -->
            <div class="col col-md-4 mb-4">
                <!-- Etkinlik Akışı Kartı -->
                <div class="card mb-4">
                    <div class="card-header">
                        Etkinlik Katılımcıları
                    </div>
                    <div class="card-body">
                        <!-- Etkinlik akışı içeriği sonra eklenecek -->
                        <p>Etkinlik katılımcıları içeriği burada görüntülenecek.</p>
                    </div>
                </div>
                
                <!-- Etkinlik Katılımcıları Kartı -->
                <div class="card">
                    <div class="card-header">
                        Etkinlik Akışı
                    </div>
                    <div class="card-body">
                        <!-- Etkinlik katılımcıları içeriği sonra eklenecek -->
                        <p>Etkinlik akışı burada görüntülenecek.</p>
                    </div>
                </div>
            </div>
            
            <!-- Sağ Sütun (md-8): Detaylar, Konaklama ve Ulaşım -->
            <div class="col col-md-8">
                
                
                <!-- Konaklama Kartı -->
                <div class="card mb-4">
                    <div class="card-header">
                        Konaklama
                    </div>
                    <div class="card-body">
                        <!-- Konaklama içeriği sonra eklenecek -->
                        <p>Konaklama bilgileri burada görüntülenecek.</p>
                    </div>
                </div>
                
                <!-- Ulaşım Kartı -->
                <div class="card">
                    <div class="card-header">
                        Ulaşım
                    </div>
                    <div class="card-body">
                        <!-- Ulaşım içeriği sonra eklenecek -->
                        <p>Ulaşım bilgileri burada görüntülenecek.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html> 