<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>RIDR - Sanatçılar</title>
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

        /* Ana İçerik */
        .main-content {
            padding: 30px 0;
        }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .page-header h2 {
            font-size: 24px;
            font-weight: 600;
            margin: 0;
            color: #2c3e50;
        }

        /* Sanatçı Kartları */
        .artist-list {
            margin-top: 15px;
        }

        .artist-item {
            display: flex;
            align-items: center;
            padding: 16px;
            border-radius: 16px;
            margin-bottom: 16px;
            background-color: #ffffff;
            transition: all 0.3s ease;
            border: 1px solid #f0f0f0;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.03);
        }

        .artist-item:hover {
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
            transform: translateY(-3px);
        }

        .artist-image {
            width: 70px;
            height: 70px;
            border-radius: 14px;
            overflow: hidden;
            margin-right: 18px;
            background-color: #f1f2f6;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            position: relative;
        }

        .artist-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }
        
        .artist-item:hover .artist-image img {
            transform: scale(1.05);
        }

        .artist-image .placeholder {
            font-size: 24px;
            color: #6c63ff;
        }

        .artist-info {
            flex: 1;
        }

        .artist-name {
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 4px;
            color: #2c3e50;
        }

        .artist-genre {
            font-size: 14px;
            color: #7f8c8d;
            display: flex;
            align-items: center;
        }

        /* Plan rozeti */
        .plan-badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            margin-left: 8px;
        }
        
        .plan-badge.basic {
            background-color: #e8f4fd;
            color: #3498db;
        }
        
        .plan-badge.premium {
            background-color: #fdf2e9;
            color: #e67e22;
        }
        
        .plan-badge.pro {
            background-color: #ebe7ff;
            color: #6c63ff;
        }

        /* Butonlar */
        .btn-primary {
            background-color: #6c63ff;
            border-color: #6c63ff;
            font-weight: 500;
            padding: 8px 16px;
            border-radius: 10px;
            transition: all 0.3s;
        }

        .btn-primary:hover {
            background-color: #5a52e0;
            border-color: #5a52e0;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(108, 99, 255, 0.2);
        }

        .btn-outline-primary {
            color: #6c63ff;
            border-color: #6c63ff;
            background-color: transparent;
            font-weight: 500;
            padding: 8px 16px;
            border-radius: 10px;
            transition: all 0.3s;
        }

        .btn-outline-primary:hover {
            background-color: #6c63ff;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(108, 99, 255, 0.2);
        }

        .btn-outline-secondary {
            color: #6c757d;
            border-color: #ced4da;
            font-weight: 500;
            padding: 8px 16px;
            border-radius: 10px;
            transition: all 0.3s;
        }

        .btn-outline-secondary:hover {
            background-color: #f8f9fa;
            color: #5a6268;
            transform: translateY(-2px);
        }

        /* Uyarılar */
        .alert {
            border-radius: 10px;
            border: none;
            padding: 15px 20px;
            margin-bottom: 30px;
        }

        .alert-success {
            background-color: #d4f5e2;
            color: #1d8348;
        }

        .alert-danger {
            background-color: #fdedee;
            color: #e74c3c;
        }

        .alert-info {
            background-color: #e7f3fe;
            color: #3498db;
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 40px 20px;
            background-color: #fff;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        .empty-state i {
            font-size: 60px;
            color: #a4b0be;
            margin-bottom: 20px;
        }

        .empty-state h3 {
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 10px;
            color: #2c3e50;
        }

        .empty-state p {
            color: #7f8c8d;
            margin-bottom: 20px;
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
    <div class="container main-content">
        <div class="page-header">
            <h2>Sanatçılarım</h2>
            <a href="{{ route('artists.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i> Yeni Sanatçı Ekle
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        
        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        @if(empty($artists))
            <div class="empty-state">
                <i class="fas fa-music"></i>
                <h3>Henüz Hiç Sanatçınız Yok</h3>
                <p>Sanatçı ekleyerek müzik yolculuğunuza başlayın!</p>
                <a href="{{ route('artists.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-1"></i> Yeni Sanatçı Ekle
                </a>
            </div>
        @else
            <div class="artist-list">
                @foreach($artists as $artist)
                    <div class="artist-item">
                        <div class="artist-image">
                            @if(!empty($artist['artist_image']))
                                <img src="{{ $artist['artist_image'] }}" alt="{{ $artist['artist_name'] }}">
                            @else
                                <div class="placeholder">
                                    <i class="fas fa-user"></i>
                                </div>
                            @endif
                        </div>
                        <div class="artist-info">
                            <div class="artist-name">{{ $artist['artist_name'] }}</div>
                            <div class="artist-genre">
                                {{ $artist['genre'] }}
                                
                                @if(!empty($artist['plan']) && is_array($artist['plan']) && !empty($artist['plan']['plan_name']))
                                    <span class="plan-badge basic">{{ $artist['plan']['plan_name'] }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="ms-auto">
                            <a href="{{ route('artists.show.slug', $artist['artist_slug']) }}" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-eye me-1"></i> Görüntüle
                            </a>
                            <a href="{{ route('artists.edit', $artist['artist_id']) }}" class="btn btn-sm btn-outline-secondary ms-2">
                                <i class="fas fa-edit me-1"></i> Düzenle
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 