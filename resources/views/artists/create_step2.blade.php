<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>RIDR - Yeni Sanatçı (Aşama 2)</title>
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

        /* Mobil Görünüm */
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
        .form-label {
            font-weight: 500;
            font-size: 15px;
            color: #2c3e50;
            margin-bottom: 8px;
        }

        .form-control, .form-select {
            padding: 12px 15px;
            border-radius: 10px;
            border: 1px solid #e9ecef;
            font-size: 15px;
            transition: all 0.3s;
        }

        .form-control:focus, .form-select:focus {
            border-color: #6c63ff;
            box-shadow: 0 0 0 0.25rem rgba(108, 99, 255, 0.25);
        }

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

        /* Ödeme Özeti Kartı */
        .payment-summary {
            background-color: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            border: 1px solid #e9ecef;
            margin-top: 20px;
        }

        .payment-total {
            font-size: 1.3rem;
            font-weight: 700;
            color: #2c3e50;
            margin-top: 10px;
            padding-top: 10px;
            border-top: 1px solid #e9ecef;
        }

        /* Kredi Kartı Stili */
        .credit-card-wrapper {
            background-color: #fff;
            border-radius: 10px;
            padding: 20px;
            border: 1px solid #e9ecef;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.03);
            margin-bottom: 20px;
        }

        .credit-card-icon {
            position: absolute;
            top: 12px;
            right: 15px;
            color: #adb5bd;
        }

        .form-control-wrapper {
            position: relative;
        }

        .action-buttons {
            margin-top: 30px;
        }

        .btn-primary {
            background-color: #6c63ff;
            border-color: #6c63ff;
            font-weight: 500;
            padding: 12px 25px;
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
            padding: 12px 25px;
            border-radius: 10px;
        }

        .btn-outline-secondary:hover {
            background-color: #f8f9fa;
            color: #5a6268;
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

        /* Duyarlı tasarım */
        @media (max-width: 768px) {
            .step-title {
                font-size: 12px;
            }
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
        </div>
    </nav>

    <!-- Ana İçerik -->
    <div class="container my-4">
        <div class="main-card">
            <a href="{{ route('artists.create.step1') }}" class="back-button">
                <i class="fas fa-arrow-left"></i> Önceki Adıma Dön
            </a>
            <h2>Yeni Sanatçı Ekle</h2>
            
            <!-- Adım Göstergesi -->
            <div class="step-indicator">
                <div class="step-line"></div>
                <div class="step completed">
                    <div class="step-number">1</div>
                    <div class="step-title">Sanatçı Bilgileri</div>
                </div>
                <div class="step active">
                    <div class="step-number">2</div>
                    <div class="step-title">Ödeme</div>
                </div>
                <div class="step">
                    <div class="step-number">3</div>
                    <div class="step-title">Tamamlandı</div>
                </div>
            </div>

            @if(session('error'))
                <div class="alert alert-danger mb-4">
                    {{ session('error') }}
                </div>
            @endif

            <div class="row">
                <div class="col-md-8">
                    <form action="{{ route('artists.store') }}" method="POST" id="payment-form">
                        @csrf
                        
                        <!-- Kredi Kartı Bilgileri -->
                        <div class="form-section">
                            <h3 class="form-section-title">Ödeme Bilgileri</h3>
                            
                            <div class="mb-4">
                                <h6 class="mb-3 fw-bold">Kredi Kartı Bilgileri</h6>
                                
                                <div class="mb-3">
                                    <label for="card_holder_name" class="form-label">Kart Üzerindeki İsim</label>
                                    <input type="text" class="form-control" id="card_holder_name" name="card_holder_name" required>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="card_number" class="form-label">Kart Numarası</label>
                                    <div class="form-control-wrapper">
                                        <input type="text" class="form-control" id="card_number" name="card_number" placeholder="XXXX XXXX XXXX XXXX" required>
                                        <i class="fas fa-credit-card credit-card-icon"></i>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="card_expiry" class="form-label">Son Kullanma Tarihi</label>
                                        <input type="text" class="form-control" id="card_expiry" name="card_expiry" placeholder="AA / YY" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="card_cvc" class="form-label">Güvenlik Kodu (CVC)</label>
                                        <input type="text" class="form-control" id="card_cvc" name="card_cvc" placeholder="XXX" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Fatura Bilgileri -->
                        <div class="form-section">
                            <h3 class="form-section-title">Fatura Bilgileri</h3>
                            
                            <div class="mb-3">
                                <label class="form-label d-block">Fatura Tipi</label>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="billing_type" id="billing_type_personal" value="personal" checked onclick="toggleBillingType('personal')">
                                    <label class="form-check-label" for="billing_type_personal">Bireysel</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="billing_type" id="billing_type_corporate" value="corporate" onclick="toggleBillingType('corporate')">
                                    <label class="form-check-label" for="billing_type_corporate">Kurumsal</label>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="billing_name" class="form-label">Ad</label>
                                    <input type="text" class="form-control" id="billing_name" name="billing_name" value="{{ $manager['manager_name'] }}" required disabled>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="billing_surname" class="form-label">Soyad</label>
                                    <input type="text" class="form-control" id="billing_surname" name="billing_surname" value="{{ $manager['manager_surname'] }}" required disabled>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="billing_email" class="form-label">E-posta</label>
                                <input type="email" class="form-control" id="billing_email" name="billing_email" value="{{ $manager['manager_email'] ?? '' }}" required disabled>
                            </div>
                            
                            <div class="mb-3">
                                <label for="billing_phone" class="form-label">Telefon</label>
                                <input type="text" class="form-control" id="billing_phone" name="billing_phone" value="{{ $manager['manager_phone'] }}" required disabled>
                            </div>
                            
                            <!-- Bireysel fatura için TC Kimlik No alanı -->
                            <div id="personal_billing_fields" class="mb-3">
                                <label for="billing_identity_number" class="form-label">TC Kimlik Numarası</label>
                                <input type="text" class="form-control" id="billing_identity_number" name="billing_identity_number" maxlength="11" value="{{ $manager['manager_tax_kimlikno'] ?? '' }}" required>
                            </div>
                            
                            <!-- Kurumsal fatura için vergi bilgileri -->
                            <div id="corporate_billing_fields" class="d-none">
                                <div class="mb-3">
                                    <label for="billing_company_name" class="form-label">Şirket Adı</label>
                                    <input type="text" class="form-control" id="billing_company_name" name="billing_company_name" value="{{ $manager['company_legal_name'] ?? '' }}">
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="billing_tax_number" class="form-label">Vergi Numarası</label>
                                        <input type="text" class="form-control" id="billing_tax_number" name="billing_tax_number" value="{{ $manager['company_tax_number'] ?? '' }}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="billing_tax_office" class="form-label">Vergi Dairesi</label>
                                        <input type="text" class="form-control" id="billing_tax_office" name="billing_tax_office" value="{{ $manager['company_tax_office'] ?? '' }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Aksiyon Butonları -->
                        <div class="action-buttons d-flex justify-content-between">
                            <a href="{{ route('artists.create.step1') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-1"></i> Geri Dön
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-lock me-1"></i> Güvenli Ödeme Yap
                            </button>
                        </div>
                    </form>
                </div>
                
                <div class="col-md-4">
                    <div class="form-section h-100">
                        <h3 class="form-section-title">Sipariş Özeti</h3>
                        
                        <div class="mb-4">
                            <h6 class="mb-2 fw-bold">Sanatçı Bilgileri</h6>
                            <p class="mb-1"><strong>Sanatçı Adı:</strong> {{ $artistData['artist_name'] }}</p>
                            <p class="mb-0"><strong>Müzik Türü:</strong> {{ $artistData['genre'] }}</p>
                        </div>
                        
                        <div class="mb-4">
                            <h6 class="mb-2 fw-bold">Abonelik Planı</h6>
                            <div class="d-flex justify-content-between mb-2">
                                <span>{{ $plan['plan_name'] }}</span>
                                <span>{{ number_format($plan['monthly_price'], 2) }} {{ $plan['price_currency'] }}</span>
                            </div>
                            <p class="mb-0 small text-muted">Aylık ödeme</p>
                        </div>
                        
                        <div class="payment-summary">
                            <div class="d-flex justify-content-between mb-2">
                                <span>Plan Ücreti (KDV Dahil):</span>
                                <span>{{ number_format($plan['monthly_price'], 2) }} {{ $plan['price_currency'] }}</span>
                            </div>
                            <div class="d-flex justify-content-between payment-total">
                                <span>Toplam:</span>
                                <span>{{ number_format($plan['monthly_price'], 2) }} {{ $plan['price_currency'] }}</span>
                            </div>
                        </div>
                        
                        <div class="mt-4 text-center">
                            <img src="https://www.iyzico.com/assets/images/content/logo.svg" alt="İyzico" height="30" class="me-2">
                            <img src="https://cdn.pixabay.com/photo/2021/12/06/13/48/visa-6850402_1280.png" alt="Visa" height="25" class="me-2">
                            <img src="https://brand.mastercard.com/content/dam/mccom/brandcenter/thumbnails/mastercard_vrt_pos_92px_2x.png" alt="Mastercard" height="25">
                        </div>
                    </div>
                </div>
            </div>
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
        // Kart numarası formatlaması
        document.getElementById('card_number').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length > 16) value = value.slice(0, 16);
            
            // 4'lü gruplar halinde formatla
            if (value.length > 0) {
                value = value.match(/.{1,4}/g).join(' ');
            }
            
            e.target.value = value;
        });
        
        // Son kullanma tarihi formatlaması
        document.getElementById('card_expiry').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length > 4) value = value.slice(0, 4);
            
            if (value.length > 2) {
                value = value.slice(0, 2) + ' / ' + value.slice(2);
            }
            
            e.target.value = value;
        });
        
        // CVC formatlaması
        document.getElementById('card_cvc').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length > 3) value = value.slice(0, 3);
            e.target.value = value;
        });
        
        // TC Kimlik Numarası formatlaması
        document.getElementById('billing_identity_number').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length > 11) value = value.slice(0, 11);
            e.target.value = value;
        });
        
        // Sayfa yüklendiğinde mevcut verilere göre fatura tipini ayarla
        document.addEventListener('DOMContentLoaded', function() {
            @if(isset($manager['company_tax_number']) && $manager['company_tax_number'])
                document.getElementById('billing_type_corporate').checked = true;
                toggleBillingType('corporate');
            @elseif(isset($manager['manager_tax_kimlikno']) && $manager['manager_tax_kimlikno'])
                document.getElementById('billing_type_personal').checked = true;
                toggleBillingType('personal');
            @endif
        });
        
        // Fatura tipine göre alanları gizle/göster
        function toggleBillingType(type) {
            if (type === 'personal') {
                document.getElementById('personal_billing_fields').classList.remove('d-none');
                document.getElementById('corporate_billing_fields').classList.add('d-none');
                document.getElementById('billing_identity_number').setAttribute('required', 'required');
                document.getElementById('billing_tax_number').removeAttribute('required');
                document.getElementById('billing_tax_office').removeAttribute('required');
                document.getElementById('billing_company_name').removeAttribute('required');
            } else {
                document.getElementById('personal_billing_fields').classList.add('d-none');
                document.getElementById('corporate_billing_fields').classList.remove('d-none');
                document.getElementById('billing_identity_number').removeAttribute('required');
                document.getElementById('billing_tax_number').setAttribute('required', 'required');
                document.getElementById('billing_tax_office').setAttribute('required', 'required');
                document.getElementById('billing_company_name').setAttribute('required', 'required');
            }
        }
    </script>
</body>
</html> 