<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>RIDR - Sanatçı Oluşturuldu</title>
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

        .step.completed .step-number {
            background-color: #6c63ff;
            color: white;
            box-shadow: 0 3px 10px rgba(108, 99, 255, 0.3);
        }

        .step-title {
            font-size: 14px;
            color: #7f8c8d;
        }

        .step.completed .step-title {
            color: #2c3e50;
        }

        /* Success Card */
        .success-card {
            text-align: center;
            padding: 40px 20px;
        }

        .success-icon {
            font-size: 80px;
            color: #2ecc71;
            margin-bottom: 20px;
        }

        .success-card h3 {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 15px;
            color: #2c3e50;
        }

        .success-card p {
            font-size: 16px;
            color: #7f8c8d;
            margin-bottom: 30px;
        }

        /* Bilgi Kartları */
        .info-card {
            background-color: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            border-left: 4px solid #6c63ff;
        }

        .info-card h4 {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 15px;
            color: #2c3e50;
        }

        .info-card p {
            margin-bottom: 5px;
        }

        .info-card .label {
            font-weight: 500;
            color: #7f8c8d;
        }

        .info-card .value {
            font-weight: 600;
            color: #2c3e50;
        }

        /* Butonlar */
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

        /* Footer */
        .footer {
            margin-top: 40px;
            padding: 20px 0;
            text-align: center;
            color: #95a5a6;
            font-size: 14px;
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
            <h2>Sanatçı Oluşturuldu</h2>
            
            <!-- Adım Göstergesi -->
            <div class="step-indicator">
                <div class="step-line"></div>
                <div class="step completed">
                    <div class="step-number">1</div>
                    <div class="step-title">Sanatçı Bilgileri</div>
                </div>
                @if(!isset($reviewMode) || $reviewMode == false)
                <div class="step completed">
                    <div class="step-number">2</div>
                    <div class="step-title">Ödeme</div>
                </div>
                <div class="step completed">
                    <div class="step-number">3</div>
                    <div class="step-title">Tamamlandı</div>
                </div>
                @else
                <div class="step completed">
                    <div class="step-number">2</div>
                    <div class="step-title">Tamamlandı</div>
                </div>
                @endif
            </div>
            
            <div class="success-card">
                <i class="fas fa-check-circle success-icon"></i>
                <h3>Tebrikler!</h3>
                <p>Sanatçınız başarıyla oluşturuldu{{ isset($reviewMode) && $reviewMode ? '' : ' ve aboneliğiniz aktifleştirildi' }}.</p>
                <div class="alert alert-info mt-3">
                    <i class="fas fa-info-circle me-2"></i>
                    <strong>Bilgi:</strong> Sanatçı resmi ve sanatçı ekibini düzenlemek için bu ekranı kapatıp Ridr uygulamasından devam edebilirsiniz.
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="info-card">
                        <h4>Sanatçı Bilgileri</h4>
                        <p><span class="label">Sanatçı Adı:</span> <span class="value">{{ $artist['artist_name'] }}</span></p>
                        <p><span class="label">Müzik Türü:</span> <span class="value">{{ $artist['genre'] }}</span></p>
                        @if(isset($artist['artist_slug']))
                        <p><span class="label">Sanatçı Link:</span> <span class="value">{{ $artist['artist_slug'] }}</span></p>
                        @endif
                    </div>
                </div>
                @if(!isset($reviewMode) || $reviewMode == false)
                <div class="col-md-6">
                    <div class="info-card">
                        <h4>Abonelik Bilgileri</h4>
                        @if(isset($plan))
                        <p><span class="label">Plan Adı:</span> <span class="value">{{ $plan['plan_name'] }}</span></p>
                        <p><span class="label">Aylık Ödeme:</span> <span class="value">{{ number_format($plan['monthly_price'], 2) }} {{ $plan['price_currency'] }}</span></p>
                        @else
                        <p><span class="label">Plan Adı:</span> <span class="value">Aktif Plan</span></p>
                        @endif
                        <p><span class="label">Durum:</span> <span class="value text-success">Aktif</span></p>
                    </div>
                </div>
                @endif
            </div>
            
            <div class="text-center mt-4">
                <a href="{{ route('artists.show.slug', $artist['artist_slug']) }}" class="btn btn-primary">
                    <i class="fas fa-users me-2"></i> Ekibi Oluşturmaya Başla
                </a>
                
                <a href="{{ route('artists.index') }}" class="btn btn-outline-secondary ms-2">
                    <i class="fas fa-music me-2"></i> Tüm Sanatçılarımı Görüntüle
                </a>
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
</body>
</html> 