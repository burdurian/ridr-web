<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $artist['artist_name'] }} - Ridr</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fc;
            color: #2c3e50;
        }

        /* Navbar Stili */
        .navbar {
            background-color: #fff;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.05);
            padding: 15px 0;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 24px;
            color: #6c63ff;
        }

        .navbar-brand img {
            height: 35px;
            margin-right: 10px;
        }

        .navbar-nav .nav-link {
            font-weight: 500;
            color: #2c3e50;
            padding: 10px 15px;
            transition: all 0.3s;
        }

        .navbar-nav .nav-link:hover,
        .navbar-nav .nav-link.active {
            color: #6c63ff;
        }

        .navbar-nav .nav-link i {
            margin-right: 5px;
        }

        /* Ana Kart Stili */
        .main-card {
            background-color: #fff;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            padding: 30px;
            margin-bottom: 25px;
            position: relative;
            border: none;
            overflow: hidden;
        }

        .main-card::before {
            content: "";
            position: absolute;
            top: -50px;
            right: -50px;
            width: 200px;
            height: 200px;
            background: rgba(108, 99, 255, 0.05);
            border-radius: 50%;
            z-index: 0;
        }

        .main-card h2 {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 20px;
            color: #2c3e50;
            position: relative;
        }

        /* Profil Kartı */
        .profile-card {
            display: flex;
            align-items: center;
            background-color: #fff;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            padding: 20px;
            margin-bottom: 30px;
        }

        .profile-image {
            width: 120px;
            height: 120px;
            border-radius: 15px;
            object-fit: cover;
            margin-right: 25px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .default-profile {
            width: 120px;
            height: 120px;
            background-color: #e9ecef;
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 25px;
            color: #6c757d;
            font-size: 3rem;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        .profile-info h3 {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 10px;
            color: #2c3e50;
        }

        .badge {
            padding: 8px 15px;
            border-radius: 30px;
            font-weight: 500;
            font-size: 12px;
            letter-spacing: 0.5px;
        }

        .badge-genre {
            background-color: #f1f2f6;
            color: #2c3e50;
        }

        .badge-plan {
            background-color: #6c63ff;
            color: #fff;
        }

        /* Bilgi Kartları */
        .info-card {
            background-color: #fff;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            margin-bottom: 25px;
            border-top: 4px solid #6c63ff;
        }

        .info-card-header {
            padding: 20px 25px;
            border-bottom: 1px solid #f1f2f6;
        }

        .info-card-header h4 {
            margin: 0;
            font-size: 18px;
            font-weight: 600;
            color: #2c3e50;
        }

        .info-card-body {
            padding: 20px 25px;
        }

        .info-item {
            margin-bottom: 15px;
            display: flex;
            align-items: flex-start;
        }

        .info-item:last-child {
            margin-bottom: 0;
        }

        .info-label {
            font-weight: 500;
            color: #7f8c8d;
            width: 40%;
        }

        .info-value {
            font-weight: 600;
            color: #2c3e50;
            width: 60%;
        }

        /* Butonlar */
        .btn-primary {
            background-color: #6c63ff;
            border-color: #6c63ff;
            font-weight: 500;
            padding: 10px 20px;
            border-radius: 10px;
            transition: all 0.3s;
        }

        .btn-primary:hover {
            background-color: #5a52e0;
            border-color: #5a52e0;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(108, 99, 255, 0.2);
        }

        .btn-outline-secondary {
            color: #6c757d;
            border-color: #ced4da;
            font-weight: 500;
            padding: 10px 20px;
            border-radius: 10px;
            transition: all 0.3s;
        }

        .btn-outline-secondary:hover {
            background-color: #f8f9fa;
            color: #5a6268;
            transform: translateY(-2px);
        }

        /* Plan Özellikleri */
        .plan-features {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        .plan-features li {
            padding: 8px 0;
            border-bottom: 1px solid #f1f2f6;
            display: flex;
            justify-content: space-between;
        }

        .plan-features li:last-child {
            border-bottom: none;
        }

        .feature-status {
            font-weight: 600;
        }

        .feature-status.available {
            color: #2ecc71;
        }

        .feature-status.unavailable {
            color: #e74c3c;
        }

        /* Uyarılar */
        .alert {
            border-radius: 10px;
            border: none;
            padding: 15px 20px;
        }

        .alert-success {
            background-color: #d4f5e2;
            color: #1d8348;
        }

        .alert-danger {
            background-color: #fdedee;
            color: #e74c3c;
        }

        .team-management-card {
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
            border-radius: 16px;
            border-top: 4px solid #6c63ff;
            overflow: hidden;
            margin-bottom: 25px;
        }
        
        .team-management-card .info-card-header {
            background-color: #fff;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            padding: 20px 25px;
        }
        
        .team-add-section {
            background-color: #f8f9fc;
            transition: all 0.3s ease;
            padding: 20px;
            border-bottom: 1px solid #eaecef;
        }
        
        .team-add-section .input-group {
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            border-radius: 10px;
            overflow: hidden;
        }
        
        .search-focused {
            background-color: #fff !important;
            box-shadow: 0 4px 12px rgba(108, 99, 255, 0.15) !important;
        }
        
        #phoneSearch {
            font-size: 16px;
            padding: 12px 15px;
            height: auto;
            transition: all 0.3s ease;
            border: none;
        }
        
        #phoneSearch:focus {
            outline: none;
            box-shadow: none;
        }
        
        #searchUserBtn {
            font-size: 16px;
            padding: 12px 20px;
            cursor: pointer;
            transition: all 0.2s ease;
            border-radius: 0;
        }
        
        #searchUserBtn:hover {
            background-color: #5a52e0;
        }
        
        .search-results-container {
            background-color: #fff;
            border-bottom: 1px solid #eee;
            transition: all 0.3s ease;
        }
        
        .team-member-row {
            transition: all 0.3s ease;
            border-bottom: 1px solid #eaecef;
            padding: 15px 20px;
        }
        
        .team-member-row:hover {
            background-color: #f8f9fc;
        }
        
        .badge {
            padding: 8px 15px;
            font-weight: 500;
            font-size: 14px;
            letter-spacing: 0.3px;
            border-radius: 6px;
            margin-top: 5px;
            display: inline-block;
            transition: all 0.3s ease;
        }
        
        .role-changing {
            animation: rolePulse 1.5s infinite;
        }
        
        .user-name-text {
            font-weight: 600;
            color: #333;
            font-size: 18px;
        }
        
        .member-name {
            font-weight: 600;
            color: #333;
            font-size: 16px;
        }
        
        .user-phone-text {
            color: #6c757d;
            font-size: 15px;
            margin-top: 3px;
        }
        
        .member-meta {
            margin-top: 8px;
        }
        
        .role-select {
            border-color: #eaecef;
            font-size: 15px;
            padding: 8px 12px;
            height: auto;
            border-radius: 8px;
            width: 100px !important;
            font-size: 14px;
        }
        
        .add-user-btn {
            border-radius: 8px;
            padding: 10px 20px;
            font-size: 15px;
            background-color: #6c63ff;
            border-color: #6c63ff;
            transition: all 0.3s ease;
        }
        
        .add-user-btn:hover {
            background-color: #5a52e0;
            border-color: #5a52e0;
            transform: translateY(-1px);
            box-shadow: 0 4px 10px rgba(108, 99, 255, 0.2);
        }
        
        .empty-team-state {
            background-color: #fcfcfc;
            border-radius: 8px;
            margin: 20px;
            padding: 40px 20px;
        }
        
        .empty-team-icon {
            display: inline-block;
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background-color: #f5f5f5;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
        }
        
        .team-members-list {
            max-height: 600px;
            overflow-y: auto;
        }
        
        @keyframes rolePulse {
            0% { opacity: 1; }
            50% { opacity: 0.5; }
            100% { opacity: 1; }
        }
        
        @media (max-width: 768px) {
            .team-member-item .member-actions {
                position: absolute;
                top: 15px;
                right: 15px;
            }
            
            .user-info {
                margin-right: 20px;
            }
            
            .add-user-btn {
                font-size: 14px;
                padding: 8px 15px;
            }
            
            .role-select {
                width: 100px !important;
                font-size: 14px;
            }
        }
        
        /* Etkinlik Stilleri */
        .events-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            margin-top: 10px;
        }
        
        .event-card {
            display: flex;
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            overflow: hidden;
            transition: all 0.3s ease;
            cursor: pointer;
            border: 1px solid #eaecef;
        }
        
        .event-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 16px rgba(108, 99, 255, 0.15);
            border-color: #d8dbe4;
        }
        
        .event-date {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-width: 70px;
            padding: 10px;
            background-color: #f8f9fa;
            border-right: 1px solid #eaecef;
        }
        
        .event-day {
            font-size: 24px;
            font-weight: 700;
            color: #6c63ff;
            line-height: 1;
        }
        
        .event-month {
            font-size: 14px;
            font-weight: 500;
            color: #6c757d;
            text-transform: uppercase;
        }
        
        .event-image {
            width: 80px;
            height: 80px;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .event-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .event-image-placeholder {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #e9ecef;
            color: #6c757d;
            font-size: 24px;
        }
        
        .event-details {
            flex-grow: 1;
            padding: 15px;
        }
        
        .event-title {
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 8px;
            color: #343a40;
        }
        
        .event-meta {
            display: flex;
            gap: 8px;
        }
        
        .event-city-badge,
        .event-type-badge {
            font-size: 12px;
            font-weight: 500;
            padding: 4px 10px;
            border-radius: 20px;
            background-color: #f1f2f6;
            color: #6c757d;
        }
        
        .event-city-badge {
            background-color: #e3f2fd;
            color: #0d6efd;
        }
        
        .event-type-badge {
            background-color: #fff3cd;
            color: #ff9800;
        }
        
        .empty-events-icon {
            display: inline-block;
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background-color: #f5f5f5;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            <a class="navbar-brand" href="{{ route('dashboard') }}">
                <img src="/ridrlogo.svg" alt="RIDR Logo">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('dashboard') }}">
                            <i class="fas fa-home"></i> Ana Sayfa
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('artists.index') }}">
                            <i class="fas fa-music"></i> Sanatçılarım
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('subscriptions.index') }}">
                            <i class="fas fa-credit-card"></i> Abonelikler
                        </a>
                    </li>
                </ul>
                <div class="d-flex">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger">
                            <i class="fas fa-sign-out-alt"></i> Çıkış Yap
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- Ana İçerik -->
    <div class="container my-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Sanatçı Detayları</h2>
            <div>
                <a href="{{ route('artists.index') }}" class="btn btn-outline-secondary me-2">
                    <i class="fas fa-arrow-left me-1"></i> Geri Dön
                </a>
                <a href="{{ route('artists.edit', $artist['artist_id']) }}" class="btn btn-primary">
                    <i class="fas fa-edit me-1"></i> Düzenle
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success mb-4">
                {{ session('success') }}
            </div>
        @endif
        
        @if(session('error'))
            <div class="alert alert-danger mb-4">
                {{ session('error') }}
            </div>
        @endif

        <!-- Profil Kartı -->
        <div class="profile-card">
            @if(!empty($artist['artist_image']))
                <img src="{{ $artist['artist_image'] }}" alt="{{ $artist['artist_name'] }}" class="profile-image">
            @else
                <div class="default-profile">
                    <i class="fas fa-user"></i>
                </div>
            @endif
            
            <div class="profile-info">
                <h3>{{ $artist['artist_name'] }}</h3>
                <div class="mb-3">
                    <span class="badge badge-genre me-2">
                        <i class="fas fa-music me-1"></i> {{ $artist['genre'] }}
                    </span>
                    @if($plan)
                        <span class="badge badge-plan">
                            <i class="fas fa-crown me-1"></i> {{ $plan['plan_name'] }}
                        </span>
                    @endif
                </div>
                <p class="text-muted mb-0">{{ $artist['artist_slug'] }}</p>
            </div>
        </div>

        <div class="row">
            <div class="col-md-5">
                <!-- Ekip Yönetimi Kartı -->
                <div class="info-card team-management-card">
                    <div class="info-card-header">
                        <h4><i class="fas fa-users me-2"></i> Sanatçı Ekibi</h4>
                    </div>
                    <div class="info-card-body p-0">
                        <div class="team-add-section p-3">
                            <h5 class="mb-3"><i class="fas fa-user-plus me-2"></i> Yeni Ekip Üyesi Ekle</h5>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0"><i class="fas fa-phone text-primary"></i></span>
                                <input type="text" id="phoneSearch" class="form-control py-3" placeholder="Eklemek istediğiniz kişinin telefon numarasını girin...">
                                <button type="button" id="searchUserBtn" class="btn btn-primary px-4">
                                    <i class="fas fa-search me-2"></i> Kişi Ara
                                </button>
                            </div>
                        </div>
                        
                        <div id="searchResults" class="search-results-container d-none">
                            <div class="p-3 border-top">
                                <h6 class="mb-3 text-primary"><i class="fas fa-check-circle me-2"></i> Arama Sonucu</h6>
                                <div class="d-flex align-items-center p-3 bg-light rounded-3" id="userResultContainer">
                                    <div id="userImageContainer" class="me-3">
                                        <img id="userImage" src="" alt="" class="rounded-circle d-none" style="width: 48px; height: 48px; object-fit: cover;">
                                        <div id="userDefaultImage" class="rounded-circle bg-white d-flex align-items-center justify-content-center d-none" style="width: 48px; height: 48px;">
                                            <i class="fas fa-user text-secondary"></i>
                                        </div>
                                    </div>
                                    <div class="user-info flex-grow-1">
                                        <h5 id="userName" class="mb-0 user-name-text"></h5>
                                        <div id="userPhone" class="text-muted user-phone-text"></div>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <select id="userRoleSelect" class="form-select me-2 role-select" style="width: 120px;">
                                            <option value="member">Üye</option>
                                            <option value="admin">Yönetici</option>
                                        </select>
                                        <button id="addUserBtn" class="btn btn-primary add-user-btn">
                                            <i class="fas fa-plus me-1"></i> Ekibe Ekle
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div id="searchError" class="alert alert-danger mx-4 my-3 d-none"></div>
                        </div>
                        
                        <div class="team-members-list">
                            <h6 class="px-4 pt-3 pb-2 border-top">Mevcut Ekip Üyeleri</h6>
                            @if(empty($teamMembers))
                                <div class="empty-team-state text-center py-5">
                                    <div class="empty-team-icon mb-3">
                                        <i class="fas fa-users text-muted" style="font-size: 48px; opacity: 0.3;"></i>
                                    </div>
                                    <h5 class="text-muted">Henüz Ekip Üyesi Yok</h5>
                                    <p class="text-muted mb-0">Yukarıdaki arama bölümünden ekip üyesi ekleyebilirsiniz</p>
                                </div>
                            @else
                                @foreach($teamMembers as $member)
                                    <div class="team-member-item" data-user-id="{{ $member['user_id'] }}">
                                        <div class="d-flex align-items-center px-4 py-3 border-top position-relative team-member-row">
                                            <div class="member-avatar me-3">
                                                @if(!empty($member['user_img']))
                                                    <img src="{{ $member['user_img'] }}" alt="{{ $member['user_name'] }}" class="rounded-circle" style="width: 42px; height: 42px; object-fit: cover;">
                                                @else
                                                    <div class="rounded-circle bg-light d-flex align-items-center justify-content-center" style="width: 42px; height: 42px;">
                                                        <i class="fas fa-user text-secondary"></i>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="member-info flex-grow-1">
                                                <h6 class="mb-0 member-name">{{ $member['user_name'] }} {{ $member['user_surname'] }}</h6>
                                                <div class="d-flex align-items-center member-meta">
                                                    <span class="badge {{ $member['is_admin'] ? 'bg-primary' : 'bg-secondary' }} me-2">
                                                        {{ $member['is_admin'] ? 'Yönetici' : 'Üye' }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="member-actions">
                                                <div class="dropdown">
                                                    <button class="btn btn-sm btn-light border-0 p-1" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="fas fa-ellipsis-v"></i>
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-end">
                                                        <li>
                                                            <a class="dropdown-item change-role-btn" href="#" data-user-id="{{ $member['user_id'] }}" data-current-role="{{ $member['is_admin'] ? 'admin' : 'member' }}">
                                                                <i class="fas fa-exchange-alt me-2 text-primary"></i>
                                                                {{ $member['is_admin'] ? 'Üye Yap' : 'Yönetici Yap' }}
                                                            </a>
                                                        </li>
                                                        <li><hr class="dropdown-divider"></li>
                                                        <li>
                                                            <a class="dropdown-item text-danger remove-member-btn" href="#" data-user-id="{{ $member['user_id'] }}">
                                                                <i class="fas fa-user-minus me-2"></i>
                                                                Çıkar
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-7">
                <div class="info-card">
                    <div class="info-card-header">
                        <h4><i class="fas fa-crown me-2"></i> Abonelik Bilgileri</h4>
                    </div>
                    <div class="info-card-body">
                        @if($plan)
                            <div class="info-item">
                                <div class="info-label">Plan:</div>
                                <div class="info-value">{{ $plan['plan_name'] }}</div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">Fiyat:</div>
                                <div class="info-value">{{ $plan['monthly_price'] }} {{ $plan['price_currency'] }} / ay</div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">Maksimum Müzisyen:</div>
                                <div class="info-value">{{ $plan['max_members'] }}</div>
                            </div>
                            @if(!empty($plan['plan_features']) && is_array($plan['plan_features']))
                                <div class="info-item">
                                    <div class="info-label">Özellikler:</div>
                                    <div class="info-value">
                                        <ul class="plan-features">
                                            @foreach($plan['plan_features'] as $key => $value)
                                                <li>
                                                    {{ ucfirst(str_replace('_', ' ', $key)) }}
                                                    <span class="feature-status {{ $value == 'yes' ? 'available' : 'unavailable' }}">
                                                        {{ $value == 'yes' ? 'Var' : 'Yok' }}
                                                    </span>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            @endif
                        @else
                            <p class="text-muted">Abonelik bilgisi bulunamadı.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Etkinlikler Bölümü -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="info-card">
                    <div class="info-card-header d-flex justify-content-between align-items-center">
                        <h4><i class="fas fa-calendar-alt me-2"></i> Yaklaşan Etkinlikler</h4>
                        <span class="badge bg-primary">{{ count($events ?? []) }} Etkinlik</span>
                    </div>
                    <div class="info-card-body">
                        @if(empty($events))
                            <div class="empty-events-state text-center py-5">
                                <div class="empty-events-icon mb-3">
                                    <i class="fas fa-calendar-times text-muted" style="font-size: 48px; opacity: 0.3;"></i>
                                </div>
                                <h5 class="text-muted">Henüz Etkinlik Bulunmuyor</h5>
                                <p class="text-muted mb-0">Etkinlikler mobil uygulama üzerinden oluşturulur</p>
                            </div>
                        @else
                            <div class="events-grid">
                                @foreach($events as $event)
                                    @php
                                        // Bağlantı adları farklı olabileceği için kontrol ederek kullan
                                        $eventDate = isset($event['eventDate']) 
                                            ? \Carbon\Carbon::parse($event['eventDate']) 
                                            : (isset($event['event_date']) 
                                                ? \Carbon\Carbon::parse($event['event_date']) 
                                                : \Carbon\Carbon::now());
                                        
                                        $day = $eventDate->format('d');
                                        $month = $eventDate->locale('tr')->shortMonthName;
                                        
                                        $eventTitle = isset($event['eventTitle']) 
                                            ? $event['eventTitle'] 
                                            : (isset($event['event_title']) 
                                                ? $event['event_title'] 
                                                : 'Etkinlik Adı');
                                                
                                        $eventCity = isset($event['eventCity']) 
                                            ? $event['eventCity'] 
                                            : (isset($event['event_city']) 
                                                ? $event['event_city'] 
                                                : 'Şehir');
                                                
                                        $eventType = isset($event['eventType']) 
                                            ? $event['eventType'] 
                                            : (isset($event['event_type']) 
                                                ? $event['event_type'] 
                                                : 'Tür');
                                                
                                        $eventImage = isset($event['eventImage']) 
                                            ? $event['eventImage'] 
                                            : (isset($event['event_image']) 
                                                ? $event['event_image'] 
                                                : '');
                                        
                                        $eventId = isset($event['eventId']) 
                                            ? $event['eventId'] 
                                            : (isset($event['event_id']) 
                                                ? $event['event_id'] 
                                                : '');
                                    @endphp
                                    <div class="event-card" data-event-id="{{ $eventId }}">
                                        <div class="event-date">
                                            <div class="event-day">{{ $day }}</div>
                                            <div class="event-month">{{ $month }}</div>
                                        </div>
                                        <div class="event-image">
                                            @if(!empty($eventImage))
                                                <img src="{{ $eventImage }}" alt="{{ $eventTitle }}">
                                            @else
                                                <div class="event-image-placeholder">
                                                    <i class="fas fa-music"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="event-details">
                                            <h5 class="event-title">{{ $eventTitle }}</h5>
                                            <div class="event-meta">
                                                <span class="event-city-badge">{{ $eventCity }}</span>
                                                <span class="event-type-badge">{{ $eventType }}</span>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const phoneSearch = document.getElementById('phoneSearch');
            const searchUserBtn = document.getElementById('searchUserBtn');
            const searchResults = document.getElementById('searchResults');
            const userResultContainer = document.getElementById('userResultContainer');
            const userImage = document.getElementById('userImage');
            const userDefaultImage = document.getElementById('userDefaultImage');
            const userName = document.getElementById('userName');
            const userPhone = document.getElementById('userPhone');
            const userRoleSelect = document.getElementById('userRoleSelect');
            const addUserBtn = document.getElementById('addUserBtn');
            const searchError = document.getElementById('searchError');
            let currentUserId = null;
            
            phoneSearch.addEventListener('focus', function() {
                this.parentElement.classList.add('search-focused');
            });
            
            phoneSearch.addEventListener('blur', function() {
                if (this.value.trim() === '') {
                    this.parentElement.classList.remove('search-focused');
                }
            });
            
            let searchTimeout = null;
            phoneSearch.addEventListener('input', function() {
                const phone = this.value.trim();
                
                clearTimeout(searchTimeout);
                
                if (phone.length >= 10) {
                    searchTimeout = setTimeout(() => {
                        searchUser(phone);
                    }, 300);
                } else if (phone.length === 0) {
                    hideSearchResults();
                }
            });
            
            phoneSearch.addEventListener('keydown', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    const phone = this.value.trim();
                    if (phone.length >= 5) {
                        searchUser(phone);
                    }
                }
            });
            
            searchUserBtn.addEventListener('click', function() {
                const phone = phoneSearch.value.trim();
                if (phone.length >= 5) {
                    searchUser(phone);
                }
            });
            
            function searchUser(phone) {
                showSearchResults();
                userResultContainer.classList.add('loading');
                
                fetch('/api/artists/find-user', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ phone: phone })
                })
                .then(response => response.json())
                .then(data => {
                    userResultContainer.classList.remove('loading');
                    
                    if (data.success) {
                        showUserData(data.user);
                    } else {
                        showSearchError(data.message);
                    }
                })
                .catch(error => {
                    userResultContainer.classList.remove('loading');
                    console.error('Error:', error);
                    showSearchError('Bir hata oluştu. Lütfen tekrar deneyin.');
                });
            }
            
            function showSearchResults() {
                searchResults.classList.remove('d-none');
                userResultContainer.classList.remove('d-none');
                searchError.classList.add('d-none');
            }
            
            function hideSearchResults() {
                searchResults.classList.add('d-none');
            }
            
            function showUserData(user) {
                currentUserId = user.user_id;
                
                if (user.user_img) {
                    userImage.src = user.user_img;
                    userImage.alt = user.user_name + ' ' + user.user_surname;
                    userImage.classList.remove('d-none');
                    userDefaultImage.classList.add('d-none');
                } else {
                    userImage.classList.add('d-none');
                    userDefaultImage.classList.remove('d-none');
                }
                
                userName.textContent = user.user_name + ' ' + user.user_surname;
                userPhone.textContent = user.phone;
                
                userResultContainer.classList.remove('d-none');
                searchError.classList.add('d-none');
            }
            
            function showSearchError(message) {
                userResultContainer.classList.add('d-none');
                searchError.textContent = message;
                searchError.classList.remove('d-none');
                currentUserId = null;
            }
            
            addUserBtn.addEventListener('click', function() {
                if (!currentUserId) return;
                
                const role = userRoleSelect.value;
                addUserBtn.disabled = true;
                addUserBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Ekleniyor...';
                
                fetch('/api/artists/{{ $artist["artist_id"] }}/team/add', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        user_id: currentUserId,
                        role: role
                    })
                })
                .then(response => response.json())
                .then(data => {
                    addUserBtn.disabled = false;
                    addUserBtn.innerHTML = '<i class="fas fa-plus me-1"></i> Ekle';
                    
                    if (data.success) {
                        addUserBtn.innerHTML = '<i class="fas fa-check me-1"></i> Eklendi';
                        addUserBtn.classList.remove('btn-primary');
                        addUserBtn.classList.add('btn-success');
                        
                        setTimeout(() => {
                            window.location.reload();
                        }, 1000);
                    } else {
                        showSearchError(data.message);
                    }
                })
                .catch(error => {
                    addUserBtn.disabled = false;
                    addUserBtn.innerHTML = '<i class="fas fa-plus me-1"></i> Ekle';
                    console.error('Error:', error);
                    showSearchError('Bir hata oluştu. Lütfen tekrar deneyin.');
                });
            });
            
            document.querySelectorAll('.remove-member-btn').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    const userId = this.getAttribute('data-user-id');
                    const memberItem = document.querySelector(`.team-member-item[data-user-id="${userId}"]`);
                    const memberName = memberItem.querySelector('.member-name').textContent;
                    
                    if (confirm(`${memberName} adlı üyeyi ekipten çıkarmak istediğinizden emin misiniz?`)) {
                        memberItem.style.opacity = '0.5';
                        memberItem.style.pointerEvents = 'none';
                        
                        fetch('/api/artists/{{ $artist["artist_id"] }}/team/remove', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            },
                            body: JSON.stringify({
                                user_id: userId
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                memberItem.style.height = memberItem.offsetHeight + 'px';
                                setTimeout(() => {
                                    memberItem.style.height = '0';
                                    memberItem.style.overflow = 'hidden';
                                    memberItem.style.padding = '0';
                                    memberItem.style.margin = '0';
                                    memberItem.style.border = 'none';
                                    
                                    setTimeout(() => {
                                        memberItem.remove();
                                        
                                        const remainingMembers = document.querySelectorAll('.team-member-item');
                                        if (remainingMembers.length === 0) {
                                            const emptyState = document.createElement('div');
                                            emptyState.className = 'empty-team-state text-center py-5';
                                            emptyState.innerHTML = `
                                                <div class="empty-team-icon mb-3">
                                                    <i class="fas fa-users text-muted" style="font-size: 48px; opacity: 0.3;"></i>
                                                </div>
                                                <h5 class="text-muted">Bu Sanatçının Henüz Ekip Üyesi Yok</h5>
                                                <p class="text-muted mb-0">Yukarıdan telefon numarası girerek ekip üyesi ekleyebilirsiniz</p>
                                            `;
                                            document.querySelector('.team-members-list').appendChild(emptyState);
                                        }
                                    }, 300);
                                }, 50);
                            } else {
                                memberItem.style.opacity = '1';
                                memberItem.style.pointerEvents = 'auto';
                                alert(data.message);
                            }
                        })
                        .catch(error => {
                            memberItem.style.opacity = '1';
                            memberItem.style.pointerEvents = 'auto';
                            console.error('Error:', error);
                            alert('Bir hata oluştu. Lütfen tekrar deneyin.');
                        });
                    }
                });
            });
            
            document.querySelectorAll('.change-role-btn').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    const userId = this.getAttribute('data-user-id');
                    const currentRole = this.getAttribute('data-current-role');
                    const newRole = currentRole === 'admin' ? 'member' : 'admin';
                    const newRoleText = newRole === 'admin' ? 'Yönetici' : 'Üye';
                    const memberItem = document.querySelector(`.team-member-item[data-user-id="${userId}"]`);
                    const memberName = memberItem.querySelector('.member-name').textContent;
                    const badgeElement = memberItem.querySelector('.badge');
                    
                    if (confirm(`${memberName} adlı üyenin rolünü "${newRoleText}" olarak değiştirmek istediğinizden emin misiniz?`)) {
                        badgeElement.classList.add('role-changing');
                        
                        fetch('/api/artists/{{ $artist["artist_id"] }}/team/change-role', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            },
                            body: JSON.stringify({
                                user_id: userId,
                                role: newRole
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                badgeElement.textContent = newRoleText;
                                badgeElement.classList.remove('bg-primary', 'bg-secondary');
                                badgeElement.classList.add(newRole === 'admin' ? 'bg-primary' : 'bg-secondary');
                                
                                this.innerHTML = `
                                    <i class="fas fa-exchange-alt me-2 text-primary"></i>
                                    ${newRole === 'admin' ? 'Üye Yap' : 'Yönetici Yap'}
                                `;
                                this.setAttribute('data-current-role', newRole);
                                
                                setTimeout(() => {
                                    badgeElement.classList.remove('role-changing');
                                }, 500);
                            } else {
                                badgeElement.classList.remove('role-changing');
                                alert(data.message);
                            }
                        })
                        .catch(error => {
                            badgeElement.classList.remove('role-changing');
                            console.error('Error:', error);
                            alert('Bir hata oluştu. Lütfen tekrar deneyin.');
                        });
                    }
                });
            });
            
            // Etkinliklere tıklama işlevi
            const eventCards = document.querySelectorAll('.event-card');
            eventCards.forEach(card => {
                card.addEventListener('click', function() {
                    alert('Etkinlik detaylarını görmek için Ridr uygulamasını kullanın');
                });
            });
        });
    </script>
</body>
</html> 