<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Etkinliklerim | Ridr</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/tr.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.0/flowbite.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.0/flowbite.min.css" rel="stylesheet" />
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
        
        .events-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 1.25rem;
        }
        
        @media (min-width: 768px) {
            .events-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
        
        .event-card {
            display: flex;
            background-color: white;
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid #e5e7eb;
            transition: all 0.2s ease;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.02);
            text-decoration: none;
            color: inherit;
            cursor: pointer;
            position: relative;
            z-index: 1;
        }
        
        .event-card:hover {
            border-color: #d1d5db;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.04);
            transform: translateY(-2px);
            color: inherit;
        }
        
        .event-date {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 1rem 0.5rem 1rem 1rem;
            min-width: 70px;
            text-align: center;
        }
        
        .event-date-day {
            font-size: 1.5rem;
            font-weight: 600;
            color: #4f46e5;
            line-height: 1;
        }
        
        .event-date-month {
            font-size: 0.875rem;
            color: #6b7280;
            margin-top: 0.25rem;
            text-transform: capitalize;
        }
        
        .event-content {
            display: flex;
            flex: 1;
            padding: 1rem 1rem 1rem 0.5rem;
            align-items: center;
        }
        
        .event-artist-image {
            width: 80px;
            height: 80px;
            border-radius: 8px;
            object-fit: cover;
            margin-right: 1.25rem;
        }
        
        .event-details {
            flex: 1;
        }
        
        .event-title {
            font-weight: 600;
            font-size: 1.125rem;
            color: #111827;
            margin-bottom: 0.25rem;
            line-height: 1.3;
        }
        
        .event-artist-name {
            font-size: 0.95rem;
            color: #4b5563;
            margin-bottom: 0.75rem;
        }
        
        .event-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
        }
        
        .event-pill {
            font-size: 0.75rem;
            padding: 0.25rem 0.625rem;
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
        
        .no-events {
            text-align: center;
            padding: 3rem 1rem;
            color: #6b7280;
        }
        
        .no-events-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
            color: #d1d5db;
        }
        
        .no-events-text {
            font-size: 1.125rem;
            margin-bottom: 0.5rem;
        }
        
        .no-events-subtext {
            font-size: 0.95rem;
            color: #9ca3af;
        }
        
        .error-banner {
            background-color: #fee2e2;
            color: #b91c1c;
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            font-size: 0.95rem;
        }
        
        .month-separator {
            display: flex;
            align-items: center;
            margin: 2rem 0 1rem;
        }
        
        .month-separator:first-child {
            margin-top: 0;
        }
        
        .month-title {
            font-size: 1.125rem;
            font-weight: 500;
            color: #4b5563;
            white-space: nowrap;
        }
        
        .month-count {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.25rem 0.75rem;
            background-color: #ede9fe;
            color: #5b21b6;
            border-radius: 9999px;
            font-size: 0.875rem;
            font-weight: 500;
            white-space: nowrap;
        }
        
        .month-separator::before {
            content: none;
        }
        
        .month-separator-line {
            height: 1px;
            background-color: #e5e7eb;
            flex: 1;
            margin: 0 1rem;
        }
        
        /* Filtreler bölümü */
        .filters-section {
            margin-bottom: 2rem;
            border-radius: 0.75rem;
        }
        
        .filter-row {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            margin-bottom: 1.5rem;
            align-items: center;
        }
        
        .filter-group {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        
        .filter-label {
            font-weight: 500;
            font-size: 0.95rem;
            color: #4b5563;
            white-space: nowrap;
        }
        
        .artist-filters {
            display: flex;
            flex-wrap: nowrap;
            gap: 0.5rem;
            overflow-x: auto;
            padding-bottom: 0.5rem;
            -webkit-overflow-scrolling: touch;
            scrollbar-width: thin;
            scrollbar-color: #d1d5db #f3f4f6;
        }
        
        .artist-filters::-webkit-scrollbar {
            height: 6px;
        }
        
        .artist-filters::-webkit-scrollbar-track {
            background: #f3f4f6;
            border-radius: 3px;
        }
        
        .artist-filters::-webkit-scrollbar-thumb {
            background-color: #d1d5db;
            border-radius: 3px;
        }
        
        .artist-filter {
            display: inline-flex;
            align-items: center;
            padding: 0.375rem 0.75rem;
            background-color: #f3f4f6;
            color: #4b5563;
            border-radius: 9999px;
            font-size: 0.875rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
            text-decoration: none;
            white-space: nowrap;
        }
        
        .artist-filter:hover {
            background-color: #e5e7eb;
        }
        
        .artist-filter.active {
            background-color: #4f46e5;
            color: white;
        }
        
        .advanced-filters {
            margin-top: 1rem;
            border-top: 1px solid #e5e7eb;
            padding-top: 1.5rem;
        }
        
        @media (max-width: 640px) {
            .filter-row {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }
            
            .filter-group {
                width: 100%;
            }
        }
        
        .detailed-filter-row {
            display: grid;
            grid-template-columns: 1fr;
            gap: 1.25rem;
            margin-bottom: 1.5rem;
        }
        
        @media (min-width: 768px) {
            .detailed-filter-row {
                grid-template-columns: repeat(3, 1fr);
            }
        }
        
        .filter-actions {
            display: flex;
            justify-content: flex-end;
            gap: 0.75rem;
            margin-top: 1.5rem;
        }
        
        .time-filter-switch {
            display: flex;
            background-color: #f3f4f6;
            border-radius: 9999px;
            padding: 0.25rem;
            width: fit-content;
            height: 38px; /* Sanatçı filtreleriyle aynı yükseklik */
        }
        
        .time-filter-option {
            font-size: 0.875rem;
            font-weight: 500;
            padding: 0.375rem 0.75rem;
            border-radius: 9999px;
            cursor: pointer;
            transition: all 0.2s ease;
            color: #4b5563;
            display: flex;
            align-items: center;
        }
        
        .time-filter-option.active {
            background-color: #4f46e5;
            color: white;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Sayfa Başlık ve Çıkış -->
        <div class="page-header">
            <h1 class="page-title">Etkinliklerim</h1>
            <div class="user-welcome">
                <span class="user-name">Hoş geldin, {{ $userName ?? 'Kullanıcı' }}</span>
                <a href="{{ route('auth.logout') }}" class="logout-btn">Çıkış Yap</a>
            </div>
        </div>
        
        <!-- Hata Mesajı -->
        @if(isset($error))
            <div class="error-banner">
                <strong>Hata:</strong> {{ $error }}
            </div>
        @endif
        
        <!-- Filtreler -->
        <div class="filters-section">
            <!-- Sanatçı ve Zaman Filtreleri -->
            <div class="filter-row">
                <div class="filter-group">
                    <div class="artist-filters">
                        <a href="{{ route('events.index', request()->except('artist')) }}" 
                           class="artist-filter {{ $filteredArtistId == null ? 'active' : '' }}">
                            Tümü
                        </a>
                        @foreach($artists as $artist)
                            <a href="{{ route('events.index', array_merge(request()->except('artist'), ['artist' => $artist['artist_id']])) }}" 
                               class="artist-filter {{ $filteredArtistId == $artist['artist_id'] ? 'active' : '' }}">
                                {{ $artist['artist_name'] }}
                            </a>
                        @endforeach
                    </div>
                </div>
                
                <div class="filter-group ms-auto">
                    <div class="time-filter-switch">
                        <div id="future-option" class="time-filter-option {{ request('time_filter', 'future') === 'future' ? 'active' : '' }}">Yaklaşan</div>
                        <div id="all-option" class="time-filter-option {{ request('time_filter') === 'all' ? 'active' : '' }}">Tümü</div>
                    </div>
                    <input type="hidden" name="time_filter" id="time-filter-input" form="filter-form" value="{{ request('time_filter', 'future') }}">
                    
                    <button id="detailed-filter-toggle" type="button" class="ml-2 text-gray-600 hover:text-gray-900 bg-gray-100 hover:bg-gray-200 rounded-full p-2 inline-flex items-center justify-center">
                        <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 1.096v1.044a2.25 2.25 0 0 1-.659 1.591l-5.432 5.432a2.25 2.25 0 0 0-.659 1.591v2.927a2.25 2.25 0 0 1-1.244 2.013L9.75 21v-6.568a2.25 2.25 0 0 0-.659-1.591L3.659 7.409A2.25 2.25 0 0 1 3 5.818V4.774c0-.54.384-1.006.917-1.096A48.32 48.32 0 0 1 12 3z" />
                        </svg>
                    </button>
                </div>
            </div>
            
            <!-- Detaylı Filtre Alanı -->
            <div id="detailed-filters" class="hidden advanced-filters">
                <form id="filter-form" action="{{ route('events.index') }}" method="GET">
                    @if($filteredArtistId)
                        <input type="hidden" name="artist" value="{{ $filteredArtistId }}">
                    @endif
                    
                    <div class="detailed-filter-row grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                        <div>
                            <label for="city-dropdown" class="block mb-2 text-sm font-medium text-gray-700">Şehir</label>
                            <button id="city-dropdown-button" data-dropdown-toggle="city-dropdown" class="text-gray-700 bg-white border border-gray-300 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2.5 text-left inline-flex items-center justify-between w-full" type="button">
                                {{ request('city') ? request('city') : 'Tüm Şehirler' }}
                                <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                                </svg>
                            </button>
                            <div id="city-dropdown" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-sm max-w-full" style="width: 100%; min-width: 200px;">
                                <ul class="py-2 text-sm text-gray-700" aria-labelledby="city-dropdown-button">
                                    <li>
                                        <a href="#" class="city-option block px-4 py-2 hover:bg-gray-100" data-value="">Tüm Şehirler</a>
                                    </li>
                                    @foreach($cities ?? [] as $city)
                                        <li>
                                            <a href="#" class="city-option block px-4 py-2 hover:bg-gray-100 {{ request('city') == $city ? 'bg-gray-100' : '' }}" data-value="{{ $city }}">{{ $city }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            <input type="hidden" name="city" id="city-input" value="{{ request('city') }}">
                        </div>
                        
                        <div>
                            <label for="event-type-dropdown" class="block mb-2 text-sm font-medium text-gray-700">Etkinlik Türü</label>
                            <button id="event-type-dropdown-button" data-dropdown-toggle="event-type-dropdown" class="text-gray-700 bg-white border border-gray-300 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2.5 text-left inline-flex items-center justify-between w-full" type="button">
                                {{ request('event_type') ? request('event_type') : 'Tüm Türler' }}
                                <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                                </svg>
                            </button>
                            <div id="event-type-dropdown" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-sm max-w-full" style="width: 100%; min-width: 200px;">
                                <ul class="py-2 text-sm text-gray-700" aria-labelledby="event-type-dropdown-button">
                                    <li>
                                        <a href="#" class="event-type-option block px-4 py-2 hover:bg-gray-100" data-value="">Tüm Türler</a>
                                    </li>
                                    @foreach($eventTypes ?? [] as $type)
                                        <li>
                                            <a href="#" class="event-type-option block px-4 py-2 hover:bg-gray-100 {{ request('event_type') == $type ? 'bg-gray-100' : '' }}" data-value="{{ $type }}">{{ $type }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            <input type="hidden" name="event_type" id="event-type-input" value="{{ request('event_type') }}">
                        </div>
                        
                        <div>
                            <label for="date-range" class="block mb-2 text-sm font-medium text-gray-700">Tarih Aralığı</label>
                            <div id="date-range-picker" date-rangepicker class="flex items-center">
                                <div class="relative w-full">
                                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                        <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                                        </svg>
                                    </div>
                                    <input id="date_range" name="date_range" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5" placeholder="Tarih aralığı seçin" value="{{ request('date_range') }}" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="filter-actions">
                        <button type="button" id="reset-filters" class="py-2 px-3 text-sm font-medium text-gray-700 bg-white rounded-lg border border-gray-200 hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-primary-300">
                            Filtreleri Temizle
                        </button>
                        <button type="submit" class="py-2 px-3 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300">
                            Uygula
                        </button>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- Etkinlikler -->
        @if(count($groupedEvents) > 0)
            @foreach($groupedEvents as $monthGroup)
                <div class="month-separator">
                    <div class="month-title">{{ ucfirst($monthGroup['month_name']) }} {{ $monthGroup['year'] }}</div>
                    <div class="month-separator-line"></div>
                    <div class="month-count">{{ count($monthGroup['events']) }} etkinlik</div>
                </div>
                
                <div class="events-grid">
                    @foreach($monthGroup['events'] as $event)
                        <a href="{{ url('/events/'.$event['event_id']) }}" class="event-card" onclick="window.location.href='{{ url('/events/'.$event['event_id']) }}'">
                            <div class="event-date">
                                <div class="event-date-day">{{ $event['formatted_date']['day'] }}</div>
                                <div class="event-date-month">{{ $event['formatted_date']['month'] }}</div>
                            </div>
                            
                            <div class="event-content">
                                <img src="{{ $event['artist_image'] }}" alt="{{ $event['artist_name'] }}" class="event-artist-image">
                                
                                <div class="event-details">
                                    <h3 class="event-title">{{ $event['event_title'] }}</h3>
                                    <div class="event-artist-name">{{ $event['artist_name'] }}</div>
                                    
                                    <div class="event-meta">
                                        <span class="event-pill event-city">{{ $event['event_city'] }}</span>
                                        <span class="event-pill event-type">{{ $event['event_type'] }}</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            @endforeach
        @else
            <div class="no-events">
                <div class="no-events-icon">📅</div>
                <p class="no-events-text">Henüz etkinliğiniz bulunmuyor</p>
                <p class="no-events-subtext">Yakında yeni etkinlikleriniz burada görünecek</p>
            </div>
        @endif
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Zaman filtresi işlevi
            const futureOption = document.getElementById('future-option');
            const allOption = document.getElementById('all-option');
            const timeFilterInput = document.getElementById('time-filter-input');
            
            futureOption.addEventListener('click', function() {
                timeFilterInput.value = 'future';
                this.classList.add('active');
                allOption.classList.remove('active');
                document.getElementById('filter-form').submit();
            });
            
            allOption.addEventListener('click', function() {
                timeFilterInput.value = 'all';
                this.classList.add('active');
                futureOption.classList.remove('active');
                document.getElementById('filter-form').submit();
            });
            
            // Şehir seçenekleri
            const cityOptions = document.querySelectorAll('.city-option');
            const cityInput = document.getElementById('city-input');
            const cityDropdownButton = document.getElementById('city-dropdown-button');
            
            cityOptions.forEach(option => {
                option.addEventListener('click', function(e) {
                    e.preventDefault();
                    const value = this.getAttribute('data-value');
                    cityInput.value = value;
                    cityDropdownButton.textContent = value ? value : 'Tüm Şehirler';
                });
            });
            
            // Etkinlik türü seçenekleri
            const eventTypeOptions = document.querySelectorAll('.event-type-option');
            const eventTypeInput = document.getElementById('event-type-input');
            const eventTypeDropdownButton = document.getElementById('event-type-dropdown-button');
            
            eventTypeOptions.forEach(option => {
                option.addEventListener('click', function(e) {
                    e.preventDefault();
                    const value = this.getAttribute('data-value');
                    eventTypeInput.value = value;
                    eventTypeDropdownButton.textContent = value ? value : 'Tüm Türler';
                });
            });
            
            // Detaylı filtre toggle
            const detailedFilterToggle = document.getElementById('detailed-filter-toggle');
            const detailedFilters = document.getElementById('detailed-filters');
            
            detailedFilterToggle.addEventListener('click', function() {
                detailedFilters.classList.toggle('hidden');
            });
            
            // Filtreleri sıfırlama
            const resetFiltersButton = document.getElementById('reset-filters');
            
            resetFiltersButton.addEventListener('click', function() {
                cityInput.value = '';
                eventTypeInput.value = '';
                document.getElementById('date_range').value = '';
                cityDropdownButton.textContent = 'Tüm Şehirler';
                eventTypeDropdownButton.textContent = 'Tüm Türler';
                
                // Yaklaşan etkinliklere dön
                timeFilterInput.value = 'future';
                futureOption.classList.add('active');
                allOption.classList.remove('active');
            });
            
            // Tarih aralığı seçici
            flatpickr("#date_range", {
                mode: "range",
                dateFormat: "d.m.Y",
                locale: "tr",
                allowInput: false,
                disableMobile: "true"
            });
            
            // Etkinlik kartlarının tıklanabilirliğini güçlendir
            document.querySelectorAll('.event-card').forEach(card => {
                card.addEventListener('click', function() {
                    const href = this.getAttribute('href');
                    if (href) {
                        window.location.href = href;
                    }
                });
            });
        });
    </script>
</body>
</html>