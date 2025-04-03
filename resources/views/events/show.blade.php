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
            max-width: 1000px;
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
        
        .back-button {
            display: flex;
            align-items: center;
            font-size: 0.95rem;
            color: #6b7280;
            text-decoration: none;
            transition: color 0.2s;
        }
        
        .back-button:hover {
            color: #4b5563;
        }
        
        .back-button svg {
            margin-right: 0.5rem;
            width: 16px;
            height: 16px;
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
        
        .event-hero {
            display: flex;
            flex-direction: column;
            background-color: white;
            border-radius: 16px;
            overflow: hidden;
            border: 1px solid #e5e7eb;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.03);
            margin-bottom: 2rem;
            padding: 2rem;
        }
        
        @media (min-width: 768px) {
            .event-hero {
                flex-direction: row;
                align-items: center;
            }
        }
        
        .event-artist-image {
            width: 160px;
            height: 160px;
            border-radius: 12px;
            object-fit: cover;
            margin-bottom: 1.5rem;
            flex-shrink: 0;
        }
        
        @media (min-width: 768px) {
            .event-artist-image {
                margin-right: 2rem;
                margin-bottom: 0;
            }
        }
        
        .event-hero-content {
            flex: 1;
        }
        
        .event-title {
            font-size: 1.75rem;
            font-weight: 700;
            color: #111827;
            margin: 0 0 0.5rem;
            line-height: 1.3;
        }
        
        .event-artist-name {
            font-size: 1.125rem;
            color: #4b5563;
            margin-bottom: 1rem;
            font-weight: 500;
        }
        
        .event-meta {
            display: flex;
            flex-wrap: wrap;
            margin-bottom: 1.5rem;
            color: #4b5563;
        }
        
        .event-meta-item {
            display: flex;
            align-items: center;
            margin-right: 1.5rem;
            margin-bottom: 0.5rem;
            font-size: 0.95rem;
        }
        
        .event-meta-item svg {
            width: 18px;
            height: 18px;
            margin-right: 0.5rem;
            color: #6b7280;
        }
        
        .event-pills {
            display: flex;
            flex-wrap: wrap;
            gap: 0.75rem;
        }
        
        .event-pill {
            font-size: 0.875rem;
            padding: 0.375rem 0.75rem;
            border-radius: 9999px;
            font-weight: 500;
        }
        
        .event-city {
            background-color: #ede9fe;
            color: #5b21b6;
        }
        
        .event-type {
            background-color: #f3f4f6;
            color: #4b5563;
        }
        
        .event-cards {
            display: grid;
            grid-template-columns: 1fr;
            gap: 1.5rem;
        }
        
        @media (min-width: 768px) {
            .event-cards {
                grid-template-columns: repeat(2, 1fr);
            }
        }
        
        .event-card {
            background-color: white;
            border-radius: 12px;
            border: 1px solid #e5e7eb;
            padding: 1.5rem;
            height: 100%;
        }
        
        .card-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: #111827;
            margin: 0 0 1rem;
            padding-bottom: 0.75rem;
            border-bottom: 1px solid #f3f4f6;
        }
        
        .event-description {
            color: #4b5563;
            font-size: 0.95rem;
            line-height: 1.6;
            margin-bottom: 1.5rem;
            white-space: pre-line;
        }
        
        .stream-title {
            font-size: 1.125rem;
            font-weight: 600;
            color: #111827;
            margin: 1.5rem 0 1rem;
        }
        
        .timeline {
            position: relative;
            margin-left: 1rem;
            padding-left: 1.5rem;
        }
        
        .timeline:before {
            content: '';
            position: absolute;
            top: 0;
            bottom: 0;
            left: 0;
            width: 2px;
            background-color: #e5e7eb;
            border-radius: 1px;
        }
        
        .timeline-item {
            position: relative;
            padding-bottom: 1.5rem;
        }
        
        .timeline-item:last-child {
            padding-bottom: 0;
        }
        
        .timeline-point {
            position: absolute;
            left: -1.675rem;
            top: 0.25rem;
            width: 12px;
            height: 12px;
            background-color: #6366f1;
            border-radius: 50%;
            border: 2px solid white;
        }
        
        .timeline-content {
            position: relative;
        }
        
        .timeline-time {
            font-weight: 600;
            color: #4b5563;
            margin-bottom: 0.25rem;
            font-size: 0.95rem;
        }
        
        .timeline-end-time {
            font-size: 0.875rem;
            color: #6b7280;
            margin-bottom: 0.5rem;
        }
        
        .timeline-description {
            font-size: 0.95rem;
            color: #4b5563;
            line-height: 1.5;
        }
        
        .error-banner {
            background-color: #fee2e2;
            color: #b91c1c;
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            font-size: 0.95rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="page-header">
            <a href="{{ route('events.index') }}" class="back-button">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M12.79 5.23a.75.75 0 01-.02 1.06L8.832 10l3.938 3.71a.75.75 0 11-1.04 1.08l-4.5-4.25a.75.75 0 010-1.08l4.5-4.25a.75.75 0 011.06.02z" clip-rule="evenodd" />
                </svg>
                Etkinliklere Dön
            </a>
            
            <div class="user-welcome">
                <span class="user-name">{{ $userName }}</span>
                <a href="{{ route('auth.logout') }}" class="logout-btn">Çıkış</a>
            </div>
        </div>
        
        <div class="event-hero">
            <img src="{{ $event['artist']['artist_image'] }}" alt="{{ $event['artist']['artist_name'] }}" class="event-artist-image">
            
            <div class="event-hero-content">
                <h1 class="event-title">{{ $event['event_title'] }}</h1>
                <div class="event-artist-name">{{ $event['artist']['artist_name'] }}</div>
                
                <div class="event-meta">
                    <div class="event-meta-item">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.75 2a.75.75 0 01.75.75V4h7V2.75a.75.75 0 011.5 0V4h.25A2.75 2.75 0 0118 6.75v8.5A2.75 2.75 0 0115.25 18H4.75A2.75 2.75 0 012 15.25v-8.5A2.75 2.75 0 014.75 4H5V2.75A.75.75 0 015.75 2zm-1 5.5c-.69 0-1.25.56-1.25 1.25v6.5c0 .69.56 1.25 1.25 1.25h10.5c.69 0 1.25-.56 1.25-1.25v-6.5c0-.69-.56-1.25-1.25-1.25H4.75z" clip-rule="evenodd" />
                        </svg>
                        {{ $event['formatted_date'] }}
                    </div>
                    
                    <div class="event-meta-item">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm.75-13a.75.75 0 00-1.5 0v5c0 .414.336.75.75.75h4a.75.75 0 000-1.5h-3.25V5z" clip-rule="evenodd" />
                        </svg>
                        {{ $event['formatted_time'] }}
                    </div>
                </div>
                
                <div class="event-pills">
                    <span class="event-pill event-city">{{ $event['event_city'] }}</span>
                    <span class="event-pill event-type">{{ $event['event_type'] }}</span>
                </div>
            </div>
        </div>
        
        <div class="event-cards">
            <div class="event-card">
                <h2 class="card-title">Etkinlik Detayları</h2>
                
                @if(!empty($event['event_description']))
                    <div class="event-description">{{ $event['event_description'] }}</div>
                @else
                    <div class="event-description">Bu etkinlik için henüz bir açıklama eklenmemiştir.</div>
                @endif
                
                @if(count($event['stream_items']) > 0)
                    <h3 class="stream-title">Etkinlik Akışı</h3>
                    
                    <div class="timeline">
                        @foreach($event['stream_items'] as $item)
                            <div class="timeline-item">
                                <div class="timeline-point"></div>
                                <div class="timeline-content">
                                    <div class="timeline-time">{{ $item['time'] }}</div>
                                    @if(isset($item['hasEndTime']) && $item['hasEndTime'] === 'true' && isset($item['endTime']))
                                        <div class="timeline-end-time">{{ $item['endTime'] }} (Bitiş)</div>
                                    @endif
                                    <div class="timeline-description">{{ $item['description'] }}</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
            
            <div class="event-card">
                <h2 class="card-title">Etkinlik Katılımcıları</h2>
                
                <p>Bu kısım henüz geliştirme aşamasındadır. Yakında etkinliğe katılacak tüm ekip ve yönetim ekibini burada görebileceksiniz.</p>
            </div>
        </div>
    </div>
</body>
</html> 