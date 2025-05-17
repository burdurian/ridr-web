<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>RIDR - Yeni Sanatçı (Aşama 1)</title>
    <link rel="shortcut icon" href="/ridrfavicon.ico" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .navbar {
            background-color: #fff;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            padding: 12px 0;
            position: sticky;
            top: 0;
            z-index: 1000;
        }
        .navbar-brand {
            font-weight: 600;
            font-size: 20px;
            color: #2c3e50;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .navbar-brand img {
            height: 28px;
        }
        .navbar-nav {
            gap: 8px;
        }
        .navbar-nav .nav-link {
            font-weight: 500;
            color: #64748b;
            padding: 8px 16px;
            border-radius: 8px;
            transition: all 0.2s ease;
            font-size: 14px;
        }
        .navbar-nav .nav-link:hover,
        .navbar-nav .nav-link.active {
            color: #6c63ff;
            background-color: rgba(108, 99, 255, 0.05);
        }
        .navbar-nav .nav-link i {
            margin-right: 6px;
            font-size: 13px;
        }
        .btn-outline-danger {
            color: #ef4444;
            border-color: #ef4444;
            font-weight: 500;
            padding: 8px 16px;
            border-radius: 8px;
            font-size: 14px;
            transition: all 0.2s ease;
        }
        .btn-outline-danger:hover {
            background-color: #ef4444;
            color: white;
            transform: translateY(-1px);
        }
        .btn-outline-danger i {
            margin-right: 6px;
            font-size: 13px;
        }
        .user-menu {
            position: relative;
        }
        .user-menu .dropdown-toggle::after {
            display: none;
        }
        .user-menu .dropdown-menu {
            border: none;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            border-radius: 8px;
            padding: 0.5rem;
            min-width: 200px;
        }
        .user-menu .dropdown-item {
            padding: 0.5rem 1rem;
            border-radius: 6px;
            color: #495057;
            transition: all 0.3s ease;
        }
        .user-menu .dropdown-item:hover {
            background-color: rgba(111, 66, 193, 0.1);
            color: #6f42c1;
        }
        .user-menu .dropdown-item i {
            width: 20px;
            text-align: center;
            margin-right: 8px;
        }
        .user-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            object-fit: cover;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }
        .card-header {
            background-color: #fff;
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
            padding: 20px;
        }
        .card-body {
            padding: 20px;
        }
        .form-label {
            font-weight: 500;
            color: #495057;
            margin-bottom: 8px;
        }
        .form-control {
            border-radius: 8px;
            border: 1px solid #ced4da;
            padding: 10px 15px;
            transition: all 0.3s ease;
        }
        .form-control:focus {
            border-color: #6f42c1;
            box-shadow: 0 0 0 0.2rem rgba(111, 66, 193, 0.25);
        }
        .btn-primary {
            background-color: #6f42c1;
            border: none;
            border-radius: 8px;
            padding: 10px 20px;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            background-color: #5a32a3;
        }
        .btn-outline-primary {
            color: #6f42c1;
            border-color: #6f42c1;
            border-radius: 8px;
            padding: 10px 20px;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        .btn-outline-primary:hover {
            background-color: #6f42c1;
            color: #fff;
        }
        @media (max-width: 991.98px) {
            .navbar {
                padding: 8px 0;
            }
            .navbar-collapse {
                background-color: #fff;
                padding: 16px;
                border-radius: 12px;
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
                margin-top: 12px;
            }
            .navbar-nav {
                gap: 4px;
            }
            .navbar-nav .nav-link {
                padding: 12px 16px;
                border-radius: 8px;
                margin: 2px 0;
            }
            .navbar-nav .nav-link:hover,
            .navbar-nav .nav-link.active {
                background-color: rgba(108, 99, 255, 0.05);
            }
            .d-flex {
                margin-top: 12px;
                padding-top: 12px;
                border-top: 1px solid rgba(0, 0, 0, 0.05);
            }
            .btn-outline-danger {
                width: 100%;
                text-align: center;
                padding: 12px 16px;
            }
        }
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fc;
            color: #2c3e50;
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

        .main-card .back-button {
            display: inline-flex;
            align-items: center;
            font-weight: 500;
            color: #6c63ff;
            text-decoration: none;
            margin-bottom: 15px;
            transition: all 0.2s;
        }

        .main-card .back-button i {
            margin-right: 6px;
        }

        .main-card .back-button:hover {
            color: #5a52e0;
        }

        /* Adım Göstergesi */
        .step-indicator {
            display: flex;
            margin-bottom: 30px;
            position: relative;
            z-index: 1;
        }

        .step {
            flex: 1;
            text-align: center;
            padding: 15px 5px;
            position: relative;
        }

        .step-line {
            position: absolute;
            top: 45px;
            left: 0;
            right: 0;
            height: 2px;
            background-color: #e9ecef;
            z-index: -1;
        }

        .step.active {
            font-weight: 600;
        }

        .step.completed {
            color: #6c63ff;
        }

        .step-number {
            width: 36px;
            height: 36px;
            line-height: 36px;
            border-radius: 50%;
            background-color: #e9ecef;
            display: inline-block;
            margin-bottom: 10px;
            font-weight: 600;
            position: relative;
            z-index: 2;
        }

        .step.active .step-number,
        .step.completed .step-number {
            background-color: #6c63ff;
            color: white;
            box-shadow: 0 3px 10px rgba(108, 99, 255, 0.3);
        }

        .step-title {
            font-size: 14px;
            color: #7f8c8d;
        }

        .step.active .step-title,
        .step.completed .step-title {
            color: #2c3e50;
        }

        /* Form Elementleri */
        .form-section {
            padding: 25px;
            background-color: #fff;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            margin-bottom: 25px;
        }

        .form-section-title {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid #f1f1f1;
            color: #2c3e50;
        }

        /* Plan Kartları */
        .plan-card-container {
            margin-top: 25px;
        }

        .plan-card {
            border: 2px solid #f0f0f0;
            border-radius: 15px;
            padding: 25px;
            margin-bottom: 20px;
            transition: all 0.3s;
            position: relative;
            overflow: hidden;
            height: 100%;
            background-color: #fff;
        }

        .plan-card:hover {
            border-color: #6c63ff;
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .plan-card.selected {
            border-color: #6c63ff;
            background-color: rgba(108, 99, 255, 0.03);
            box-shadow: 0 10px 20px rgba(108, 99, 255, 0.1);
        }

        .plan-badge {
            position: static;
            display: inline-block;
            margin-left: 10px;
            padding: 4px 10px;
            border-radius: 15px;
            font-size: 11px;
            font-weight: 600;
            vertical-align: middle;
        }

        .plan-badge.basic {
            background-color: #e8f4fd;
            color: #3498db;
        }

        .plan-badge.premium {
            background-color: #fdf2e9;
            color: #e67e22;
            font-weight: 600;
            border: 1px solid rgba(230, 126, 34, 0.3);
        }

        .plan-badge.pro {
            background-color: #ebe7ff;
            color: #6c63ff;
        }

        .plan-name {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 5px;
            color: #2c3e50;
        }

        .plan-price {
            font-size: 24px;
            font-weight: 700;
            color: #2c3e50;
            margin: 15px 0;
        }

        .plan-price span {
            font-size: 14px;
            font-weight: 400;
            color: #7f8c8d;
        }

        .plan-price price-annual {
            display: none;
        }
        
        .original-price {
            text-decoration: line-through;
            color: #7f8c8d;
            font-size: 16px;
            margin-bottom: 5px;
        }

        .plan-features {
            margin: 20px 0;
            padding: 0;
            list-style: none;
        }

        .plan-features li {
            margin-bottom: 10px;
            padding-left: 25px;
            position: relative;
            font-size: 14px;
        }

        .plan-features .feature-yes::before {
            content: "\f00c";
            font-family: "Font Awesome 6 Free";
            font-weight: 900;
            position: absolute;
            left: 0;
            color: #2ecc71;
        }

        .plan-features .feature-no {
            opacity: 0.5;
        }

        .plan-features .feature-no::before {
            content: "\f00d";
            font-family: "Font Awesome 6 Free";
            font-weight: 900;
            position: absolute;
            left: 0;
            color: #e74c3c;
        }

        .plan-card .plan-check {
            position: absolute;
            top: 15px;
            right: 15px;
            width: 24px;
            height: 24px;
            border: 2px solid #e9ecef;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s;
        }

        .plan-card.selected .plan-check {
            background-color: #6c63ff;
            border-color: #6c63ff;
            color: white;
        }

        .action-buttons {
            margin-top: 30px;
        }

        /* Uyarlar */
        .alert {
            border-radius: 10px;
            border: none;
            padding: 15px 20px;
        }

        .alert-danger {
            background-color: #fdedee;
            color: #e74c3c;
        }

        /* Footer */
        .footer {
            margin-top: 40px;
            padding: 20px 0;
            text-align: center;
            color: #95a5a6;
            font-size: 14px;
        }

        /* Ödeme Toggle Butonu */
        .payment-toggle {
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            width: auto;
        }
        
        .payment-toggle-btn {
            font-weight: 500;
            transition: all 0.3s;
            border: none;
            color: #7f8c8d;
        }
        
        .payment-toggle-btn.active {
            background-color: #6c63ff;
            color: white;
            box-shadow: 0 2px 5px rgba(108, 99, 255, 0.3);
        }

        .price-annual {
            display: none;
        }
        
        .original-price {
            text-decoration: line-through;
            color: #7f8c8d;
            font-size: 16px;
            margin-bottom: 5px;
        }

        /* Çoklu Seçim (Genre) Stili */
        .genre-multiselect {
            position: relative;
        }
        
        .genre-selector {
            padding: 0.5rem;
            border: 1px solid #e9ecef;
            border-radius: 10px;
            min-height: 55px;
            cursor: pointer;
            background-color: white;
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 8px;
            transition: all 0.3s;
        }
        
        .genre-selector:focus, 
        .genre-selector.active {
            border-color: #6c63ff;
            box-shadow: 0 0 0 0.25rem rgba(108, 99, 255, 0.25);
            outline: none;
        }
        
        .genre-dropdown {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background-color: white;
            border: 1px solid #e9ecef;
            border-radius: 10px;
            margin-top: 5px;
            z-index: 1000;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            padding: 10px;
            display: none;
            max-height: 250px;
            overflow-y: auto;
        }
        
        .genre-dropdown.show {
            display: block !important;
        }
        
        .genre-option {
            padding: 8px 12px;
            cursor: pointer;
            border-radius: 6px;
            margin-bottom: 4px;
            transition: all 0.2s;
        }
        
        .genre-option:hover {
            background-color: #f8f9fa;
        }
        
        .genre-option.selected {
            background-color: #e3e1ff;
            color: #6c63ff;
        }
        
        .genre-chip {
            display: inline-flex;
            align-items: center;
            background-color: #e3e1ff;
            color: #6c63ff;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 13px;
            margin-right: 5px;
            margin-bottom: 5px;
        }
        
        .genre-chip .close {
            margin-left: 6px;
            font-size: 14px;
            cursor: pointer;
            opacity: 0.7;
            transition: all 0.2s;
        }
        
        .genre-chip .close:hover {
            opacity: 1;
        }
        
        .genre-placeholder {
            color: #7f8c8d;
            margin-left: 5px;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            <a class="navbar-brand" href="{{ route('dashboard') }}">
                <img src="/ridrlogo.svg" alt="RIDR Logo">
            </a>
            @if(!isset($reviewMode) || $reviewMode == false)
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
                        <a class="nav-link" href="{{ route('invoices.index') }}">
                            <i class="fas fa-file-invoice"></i> Faturalar
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
            @else
            <div class="ms-auto">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger">
                        <i class="fas fa-sign-out-alt"></i> Çıkış Yap
                    </button>
                </form>
            </div>
            @endif
        </div>
    </nav>

    <!-- Ana İçerik -->
    <div class="container my-4">
        <div class="main-card">
            <a href="{{ route('artists.index') }}" class="back-button">
                <i class="fas fa-arrow-left"></i> Sanatçılara Dön
            </a>
            <h2>Yeni Sanatçı Ekle</h2>
            
            <!-- Adım Göstergesi -->
            <div class="step-indicator">
                <div class="step-line"></div>
                <div class="step active">
                    <div class="step-number">1</div>
                    <div class="step-title">Sanatçı Bilgileri</div>
                </div>
                @if(!isset($reviewMode) || $reviewMode == false)
                <div class="step">
                    <div class="step-number">2</div>
                    <div class="step-title">Ödeme</div>
                </div>
                <div class="step">
                    <div class="step-number">3</div>
                    <div class="step-title">Tamamlandı</div>
                </div>
                @else
                <div class="step">
                    <div class="step-number">2</div>
                    <div class="step-title">Tamamlandı</div>
                </div>
                @endif
            </div>

            @if(session('error'))
                <div class="alert alert-danger mb-4">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('artists.process.step1') }}" method="POST">
                @csrf
                
                <!-- Sanatçı Bilgileri Formu -->
                <div class="form-section">
                    <h3 class="form-section-title">Sanatçı Bilgileri</h3>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="artist_name" class="form-label">Sanatçı Adı *</label>
                            <input type="text" class="form-control @error('artist_name') is-invalid @enderror" id="artist_name" name="artist_name" value="{{ old('artist_name') }}" required>
                            @error('artist_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="genre" class="form-label">Müzik Türleri *</label>
                            <div class="genre-multiselect">
                                <div class="genre-selector" id="genre-selector" tabindex="0">
                                    <span class="genre-placeholder">Müzik türlerini seçin...</span>
                                </div>
                                <div class="genre-dropdown" id="genre-dropdown">
                                    <div class="genre-option" data-value="Pop">Pop</div>
                                    <div class="genre-option" data-value="Rock">Rock</div>
                                    <div class="genre-option" data-value="HipHop">Hip Hop</div>
                                    <div class="genre-option" data-value="R&B">R&B</div>
                                    <div class="genre-option" data-value="Jazz">Jazz</div>
                                    <div class="genre-option" data-value="Electronic">Electronic</div>
                                    <div class="genre-option" data-value="Classical">Classical</div>
                                    <div class="genre-option" data-value="Country">Country</div>
                                    <div class="genre-option" data-value="Reggae">Reggae</div>
                                    <div class="genre-option" data-value="Folk">Folk</div>
                                    <div class="genre-option" data-value="Metal">Metal</div>
                                    <div class="genre-option" data-value="Blues">Blues</div>
                                    <div class="genre-option" data-value="Latin">Latin</div>
                                    <div class="genre-option" data-value="Alternative">Alternative</div>
                                    <div class="genre-option" data-value="Indie">Indie</div>
                                </div>
                                <input type="hidden" name="genre" id="genre-input" value="{{ old('genre') }}" required>
                            </div>
                            @error('genre')
                                <div class="text-danger mt-2" style="font-size: 0.875em;">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                
                @if(!isset($reviewMode) || $reviewMode == false)
                <!-- Abonelik Planı -->
                <div class="form-section">
                    <h3 class="form-section-title">Abonelik Planı</h3>
                    <p>Sanatçınız için bir abonelik planı seçin. Her sanatçı için ayrı bir abonelik planı gereklidir.</p>
                    
                    <!-- Aylık/Yıllık Geçiş Switchi -->
                    <div class="d-flex justify-content-center mb-4">
                        <div class="payment-toggle bg-light p-1 rounded-pill d-inline-flex">
                            <button type="button" class="btn rounded-pill px-4 payment-toggle-btn active" id="monthly-btn">Aylık</button>
                            <button type="button" class="btn rounded-pill px-4 payment-toggle-btn" id="annual-btn">Yıllık</button>
                        </div>
                    </div>
                    
                    @if($errors->has('subscription_plan'))
                        <div class="alert alert-danger">
                            {{ $errors->first('subscription_plan') }}
                        </div>
                    @endif
                    
                    <div class="row plan-card-container">
                        @php
                            // Planları sıralama (Temel, Seçkin, Sınırsız)
                            $sortedPlans = [];
                            $basicPlan = null;
                            $premiumPlan = null;
                            $proPlan = null;
                            
                            foreach($plans as $plan) {
                                if (strpos(strtolower($plan['plan_name']), 'temel') !== false) {
                                    $basicPlan = $plan;
                                } elseif (strpos(strtolower($plan['plan_name']), 'seçkin') !== false) {
                                    $premiumPlan = $plan;
                                } elseif (strpos(strtolower($plan['plan_name']), 'sınırsız') !== false) {
                                    $proPlan = $plan;
                                } else {
                                    $sortedPlans[] = $plan;
                                }
                            }
                            
                            // Planları doğru sırada ekleme
                            if ($basicPlan) $sortedPlans[] = $basicPlan;
                            if ($premiumPlan) $sortedPlans[] = $premiumPlan;
                            if ($proPlan) $sortedPlans[] = $proPlan;
                            
                            // Eğer özel sınıflandırma yapılamazsa orijinal planları kullan
                            if (empty($sortedPlans)) {
                                $sortedPlans = $plans;
                            }
                        @endphp
                        
                        @foreach($sortedPlans as $plan)
                            @php
                                $badgeClass = 'basic';
                                $badgeText = '';
                                $highlightStyle = '';
                                
                                if (strpos(strtolower($plan['plan_name']), 'temel') !== false) {
                                    $badgeClass = 'basic';
                                } elseif (strpos(strtolower($plan['plan_name']), 'seçkin') !== false) {
                                    $badgeClass = 'premium';
                                    $badgeText = 'En Çok Tercih Edilen';
                                    $highlightStyle = 'style="border-color: #e67e22; box-shadow: 0 10px 20px rgba(230, 126, 34, 0.15);"';
                                } elseif (strpos(strtolower($plan['plan_name']), 'sınırsız') !== false) {
                                    $badgeClass = 'pro';
                                }
                                
                                // Feature mapping from JSON
                                $featuresMapping = [
                                    'davetiye_talebi' => 'Davetiye Talebi',
                                    'takvim_gorunumu' => 'Takvim Görünümü',
                                    'oncelikli_destek' => 'Öncelikli Destek',
                                    'detayli_analizler' => 'Detaylı Analizler',
                                    'sanatci_dosyalari' => 'Sanatçı Dosyaları',
                                    'etkinlik_olusturma' => 'Etkinlik Oluşturma',
                                    'apple_watch_destegi' => 'Apple Watch Desteği',
                                    'konser_takvimi_gorseli' => 'Konser Takvimi Görseli',
                                    'etkinlik_akisi_zamansiz' => 'Etkinlik Akışı Yönetimi',
                                    'ulasim_konaklama_yonetimi' => 'Ulaşım ve Konaklama Yönetimi',
                                    'etkinlik_akisi_bildirimleri' => 'Etkinlik Akışı Bildirimleri'
                                ];
                                
                                // Özelliklerin sıralama dizisi
                                $featureOrder = [
                                    'takvim_gorunumu',
                                    'etkinlik_olusturma',
                                    'etkinlik_akisi_zamansiz',
                                    'ulasim_konaklama_yonetimi',
                                    'davetiye_talebi',
                                    'sanatci_dosyalari',
                                    'etkinlik_akisi_bildirimleri',
                                    'detayli_analizler',
                                    'apple_watch_destegi',
                                    'konser_takvimi_gorseli',
                                    'oncelikli_destek'
                                ];
                            @endphp
                            <div class="col-md-4 mb-4">
                                <div id="plan-card-{{ $plan['plan_id'] }}" class="plan-card {{ old('subscription_plan') == $plan['plan_id'] ? 'selected' : '' }}" data-plan="{{ $plan['plan_id'] }}" {!! $highlightStyle !!}>
                                    <div class="plan-check"><i class="fas fa-check"></i></div>
                                    <div class="plan-name">
                                        {{ $plan['plan_name'] }}
                                        @if(!empty($badgeText))
                                            <span class="plan-badge {{ $badgeClass }}">{{ $badgeText }}</span>
                                        @endif
                                    </div>
                                    <div class="plan-price monthly-plan">
                                        {{ $plan['monthly_price'] }} {{ $plan['price_currency'] }}<span>/ay</span>
                                    </div>
                                    
                                    <div class="plan-price price-annual">
                                        <div class="original-price">{{ $plan['monthly_price'] * 12 }} {{ $plan['price_currency'] }}</div>
                                        
                                        <!-- Debug: annual_price değerini ve türünü kontrol et -->
                                        <div style="display: none;">
                                            <pre>
                                            annual_price var mı: {{ isset($plan['annual_price']) ? 'Evet' : 'Hayır' }}
                                            annual_price değeri: {{ isset($plan['annual_price']) ? $plan['annual_price'] : 'Yok' }}
                                            annual_price türü: {{ isset($plan['annual_price']) ? gettype($plan['annual_price']) : 'Yok' }}
                                            </pre>
                                        </div>
                                        
                                        <!-- Doğrudan plan dizisinden annual_price değerini almaya çalış -->
                                        @if(isset($plan['annual_price']))
                                            {{ $plan['annual_price'] }} {{ $plan['price_currency'] }}<span>/yıl</span>
                                        @else
                                            {{ $plan['monthly_price'] * 10 }} {{ $plan['price_currency'] }}<span>/yıl</span>
                                        @endif
                                    </div>
                                    
                                    @if(isset($plan['plan_desc']) && !empty($plan['plan_desc']))
                                        <p class="text-muted my-2" style="font-size: 14px;">{{ $plan['plan_desc'] }}</p>
                                    @endif
                                    
                                    <div class="mt-2 mb-3">
                                        <span class="badge bg-light text-dark">
                                            <i class="fas fa-user-group me-1"></i> 
                                            @if(isset($plan['max_members']) && $plan['max_members'] == 9999)
                                                Sınırsız ekip üyesi
                                            @else
                                                Maksimum {{ $plan['max_members'] }} ekip üyesi
                                            @endif
                                        </span>
                                    </div>
                                    
                                    <ul class="plan-features">
                                        @if(isset($plan['plan_features']))
                                            @php
                                                $features = [];
                                                if (is_string($plan['plan_features'])) {
                                                    $features = json_decode($plan['plan_features'], true);
                                                } elseif (is_array($plan['plan_features'])) {
                                                    $features = $plan['plan_features'];
                                                }
                                            @endphp
                                            
                                            @if(is_array($features))
                                                @foreach($featureOrder as $featureKey)
                                                    @if(isset($features[$featureKey]) && $features[$featureKey])
                                                        <li class="available">
                                                            <i class="fas fa-check"></i> 
                                                            {{ $featuresMapping[$featureKey] ?? $featureKey }}
                                                        </li>
                                                    @endif
                                                @endforeach
                                            @endif
                                        @endif
                                    </ul>
                                    
                                    <input type="radio" name="subscription_plan" value="{{ $plan['plan_id'] }}" class="d-none plan-radio" {{ old('subscription_plan') == $plan['plan_id'] ? 'checked' : '' }}>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif
                
                <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                    @if(isset($reviewMode) && $reviewMode == true)
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-check me-1"></i> Sanatçı Oluştur
                    </button>
                    @else
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-arrow-right me-1"></i> Devam Et
                    </button>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <div class="container">
            <p>RIDR Menajer Paneli &copy; 2024 | Tüm Hakları Saklıdır</p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Plan seçimi
            const planCards = document.querySelectorAll('.plan-card');
            
            planCards.forEach(card => {
                card.addEventListener('click', function() {
                    // Tüm kartlardan selected sınıfını kaldır
                    planCards.forEach(c => c.classList.remove('selected'));
                    
                    // Bu kartı seçili olarak işaretle
                    this.classList.add('selected');
                    
                    // Radio butonu işaretle
                    const planId = this.getAttribute('data-plan');
                    const radioInput = document.querySelector(`input[value="${planId}"]`);
                    if (radioInput) {
                        radioInput.checked = true;
                    }
                });
            });
            
            // Sayfa yüklendiğinde seçili planı vurgulamak için
            const selectedPlan = document.querySelector('input[name="subscription_plan"]:checked');
            if (selectedPlan) {
                const planCard = document.getElementById('plan-card-' + selectedPlan.value);
                if (planCard) {
                    planCard.classList.add('selected');
                }
            }
            
            // Aylık/Yıllık Toggle İşlevselliği
            const monthlyBtn = document.getElementById('monthly-btn');
            const annualBtn = document.getElementById('annual-btn');
            if (monthlyBtn && annualBtn) {
                const monthlyPrices = document.querySelectorAll('.monthly-plan');
                const annualPrices = document.querySelectorAll('.price-annual');
                
                monthlyBtn.addEventListener('click', function() {
                    monthlyBtn.classList.add('active');
                    annualBtn.classList.remove('active');
                    
                    monthlyPrices.forEach(price => price.style.display = 'block');
                    annualPrices.forEach(price => price.style.display = 'none');
                });
                
                annualBtn.addEventListener('click', function() {
                    annualBtn.classList.add('active');
                    monthlyBtn.classList.remove('active');
                    
                    monthlyPrices.forEach(price => price.style.display = 'none');
                    annualPrices.forEach(price => price.style.display = 'block');
                });
            }

            // Müzik Türü Çoklu Seçim İşlevselliği
            const genreSelector = document.getElementById('genre-selector');
            const genreDropdown = document.getElementById('genre-dropdown');
            const genreInput = document.getElementById('genre-input');
            
            if (genreSelector && genreDropdown && genreInput) {
                const genreOptions = document.querySelectorAll('.genre-option');
                let selectedGenres = [];
                
                // Sayfa yüklendiğinde önceden seçilmiş türleri göster
                if (genreInput.value) {
                    selectedGenres = genreInput.value.split(',');
                    updateGenreDisplay();
                }
                
                // Seçici tıklandığında dropdown'ı göster/gizle
                genreSelector.addEventListener('click', function(e) {
                    e.stopPropagation();
                    genreDropdown.classList.toggle('show');
                    genreSelector.classList.toggle('active');
                    console.log('Genre selector clicked', genreDropdown.classList.contains('show'));
                });
                
                // Enter veya space tuşuna basıldığında dropdown'ı göster/gizle
                genreSelector.addEventListener('keydown', function(e) {
                    if (e.key === 'Enter' || e.key === ' ') {
                        e.preventDefault();
                        genreDropdown.classList.toggle('show');
                        genreSelector.classList.toggle('active');
                    }
                });
                
                // Bir tür seçildiğinde
                genreOptions.forEach(option => {
                    option.addEventListener('click', function(e) {
                        e.stopPropagation();
                        const genreValue = this.getAttribute('data-value');
                        console.log('Genre option clicked', genreValue);
                        
                        // Eğer zaten seçiliyse, seçimi kaldır
                        if (selectedGenres.includes(genreValue)) {
                            selectedGenres = selectedGenres.filter(g => g !== genreValue);
                            this.classList.remove('selected');
                        } else {
                            // Değilse, seçimi ekle
                            selectedGenres.push(genreValue);
                            this.classList.add('selected');
                        }
                        
                        // Input değerini ve gösterimi güncelle
                        genreInput.value = selectedGenres.join(',');
                        updateGenreDisplay();
                    });
                });
                
                // Dışarı tıklandığında dropdown'ı kapat
                document.addEventListener('click', function(e) {
                    if (!genreSelector.contains(e.target) && !genreDropdown.contains(e.target)) {
                        genreDropdown.classList.remove('show');
                        genreSelector.classList.remove('active');
                    }
                });
                
                // Seçili türleri göster
                function updateGenreDisplay() {
                    // Placeholder'ı temizle
                    while (genreSelector.firstChild) {
                        genreSelector.removeChild(genreSelector.firstChild);
                    }
                    
                    // Eğer seçili tür yoksa placeholder göster
                    if (selectedGenres.length === 0) {
                        const placeholder = document.createElement('span');
                        placeholder.className = 'genre-placeholder';
                        placeholder.textContent = 'Müzik türlerini seçin...';
                        genreSelector.appendChild(placeholder);
                    } else {
                        // Seçili türleri chip olarak göster
                        selectedGenres.forEach(genre => {
                            const chip = document.createElement('div');
                            chip.className = 'genre-chip';
                            chip.innerHTML = genre + '<span class="close">&times;</span>';
                            
                            // Chip'teki çarpıya tıklayınca türü kaldır
                            chip.querySelector('.close').addEventListener('click', function(e) {
                                e.stopPropagation();
                                selectedGenres = selectedGenres.filter(g => g !== genre);
                                genreInput.value = selectedGenres.join(',');
                                
                                // İlgili option'ın seçimini kaldır
                                const optionEl = document.querySelector(`.genre-option[data-value="${genre}"]`);
                                if (optionEl) {
                                    optionEl.classList.remove('selected');
                                }
                                
                                updateGenreDisplay();
                            });
                            
                            genreSelector.appendChild(chip);
                        });
                    }
                    
                    // Option'ların seçili durumunu güncelle
                    genreOptions.forEach(option => {
                        const value = option.getAttribute('data-value');
                        if (selectedGenres.includes(value)) {
                            option.classList.add('selected');
                        } else {
                            option.classList.remove('selected');
                        }
                    });
                }
            }
        });
    </script>
</body>
</html> 