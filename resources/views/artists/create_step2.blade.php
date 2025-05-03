<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>RIDR - Yeni Sanatçı (Aşama 2)</title>
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
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            padding: 1rem 2rem;
        }
        .navbar-brand {
            font-weight: 600;
            color: #6f42c1;
        }
        .nav-link {
            color: #495057;
            font-weight: 500;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            transition: all 0.3s ease;
        }
        .nav-link:hover {
            color: #6f42c1;
            background-color: rgba(111, 66, 193, 0.1);
        }
        .nav-link.active {
            color: #6f42c1;
            background-color: rgba(111, 66, 193, 0.1);
        }
        .user-menu {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        .user-info {
            text-align: right;
        }
        .user-name {
            font-weight: 600;
            color: #212529;
            margin: 0;
        }
        .user-role {
            font-size: 0.875rem;
            color: #6c757d;
            margin: 0;
        }
        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: #6f42c1;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
        }
        .step-container {
            max-width: 800px;
            margin: 2rem auto;
            background: white;
            border-radius: 1rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 2rem;
        }
        .step-header {
            text-align: center;
            margin-bottom: 2rem;
        }
        .step-title {
            color: #6f42c1;
            font-weight: 600;
            margin-bottom: 1rem;
        }
        .step-description {
            color: #6c757d;
        }
        .form-label {
            font-weight: 500;
            color: #495057;
        }
        .form-control {
            border-radius: 0.5rem;
            padding: 0.75rem 1rem;
            border: 1px solid #ced4da;
        }
        .form-control:focus {
            border-color: #6f42c1;
            box-shadow: 0 0 0 0.2rem rgba(111, 66, 193, 0.25);
        }
        .btn-primary {
            background-color: #6f42c1;
            border-color: #6f42c1;
            padding: 0.75rem 1.5rem;
            font-weight: 500;
            border-radius: 0.5rem;
        }
        .btn-primary:hover {
            background-color: #5a32a3;
            border-color: #5a32a3;
        }
        .btn-outline-secondary {
            color: #6c757d;
            border-color: #ced4da;
            padding: 0.75rem 1.5rem;
            font-weight: 500;
            border-radius: 0.5rem;
        }
        .btn-outline-secondary:hover {
            background-color: #e9ecef;
            border-color: #ced4da;
            color: #495057;
        }
        @media (max-width: 768px) {
            .step-container {
                margin: 1rem;
                padding: 1.5rem;
            }
            .navbar {
                padding: 1rem;
            }
            .user-info {
                display: none;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand" href="/dashboard">
                <img src="/ridrlogo.svg" alt="Ridr" height="30">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/dashboard">
                            <i class="fas fa-home"></i> Ana Sayfa
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="/artists">
                            <i class="fas fa-users"></i> Sanatçılar
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/invoices">
                            <i class="fas fa-file-invoice"></i> Faturalar
                        </a>
                    </li>
                </ul>
                <div class="user-menu">
                    <div class="user-info">
                        <p class="user-name">{{ Auth::user()->name }}</p>
                        <p class="user-role">Yönetici</p>
                    </div>
                    <div class="user-avatar">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
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