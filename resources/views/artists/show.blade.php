<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $artist['artist_name'] }} - Ridr</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .sidebar {
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            padding: 0;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            z-index: 100;
            background-color: #fff;
        }
        .sidebar-sticky {
            position: sticky;
            top: 0;
            height: 100vh;
            padding-top: 1.5rem;
            overflow-x: hidden;
            overflow-y: auto;
        }
        .logo {
            font-size: 1.5rem;
            font-weight: bold;
            margin-bottom: 2rem;
            padding: 0 1rem;
        }
        .nav-link {
            color: #333;
            border-radius: 0;
            padding: 0.75rem 1rem;
        }
        .nav-link:hover {
            background-color: #f8f9fa;
        }
        .nav-link.active {
            background-color: #6c63ff;
            color: white;
        }
        .logo-img {
            width: 40px;
            height: 40px;
            background-color: #6c63ff;
            color: white;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            margin-right: 10px;
        }
        .main-content {
            margin-left: 250px;
            padding: 2rem;
        }
        .profile-header {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.05);
            padding: 2rem;
            margin-bottom: 2rem;
        }
        .profile-image {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border-radius: 50%;
            margin-right: 2rem;
        }
        .default-profile {
            width: 150px;
            height: 150px;
            background-color: #e9ecef;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 2rem;
            color: #6c757d;
            font-size: 3rem;
        }
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.05);
            margin-bottom: 1.5rem;
        }
        .card-header {
            background-color: transparent;
            border-bottom: 1px solid #eee;
            padding: 1.25rem 1.5rem;
            font-weight: bold;
        }
        .card-body {
            padding: 1.5rem;
        }
        .btn-edit {
            background-color: #6c63ff;
            border-color: #6c63ff;
        }
        .btn-edit:hover {
            background-color: #5a52e0;
            border-color: #5a52e0;
        }
        .btn-back {
            background-color: transparent;
            border-color: #ddd;
            color: #333;
        }
        .btn-back:hover {
            background-color: #f8f9fa;
            border-color: #ddd;
            color: #333;
        }
        .badge {
            padding: 0.5rem 0.75rem;
            font-weight: 500;
        }
        .plan-badge {
            background-color: #6c63ff;
            color: white;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="col-md-3 col-lg-2 d-md-block sidebar">
        <div class="sidebar-sticky">
            <div class="logo d-flex align-items-center">
                <div class="logo-img">R</div>
                <span>RIDR</span>
            </div>
            
            <div class="user-info mb-4 px-3">
                <small class="text-muted d-block">Menajer</small>
                <span class="fw-bold">{{ session('manager')['manager_name'] }} {{ session('manager')['manager_surname'] }}</span>
            </div>
            
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('dashboard') }}">
                        <i class="fas fa-home me-2"></i>
                        Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="{{ route('artists.index') }}">
                        <i class="fas fa-music me-2"></i>
                        Sanatçılarım
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('subscriptions.index') }}">
                        <i class="fas fa-credit-card me-2"></i>
                        Abonelikler
                    </a>
                </li>
            </ul>
            
            <div class="mt-auto px-3 mb-3 position-absolute bottom-0 start-0 end-0">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-outline-secondary w-100">
                        <i class="fas fa-sign-out-alt me-2"></i>
                        Çıkış Yap
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <div class="main-content">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Sanatçı Detayları</h1>
            <div>
                <a href="{{ route('artists.index') }}" class="btn btn-back me-2">
                    <i class="fas fa-arrow-left me-1"></i> Geri
                </a>
                <a href="{{ route('artists.edit', $artist['artist_id']) }}" class="btn btn-edit">
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
        
        <div class="profile-header d-flex align-items-center">
            @if(!empty($artist['artist_image']))
                <img src="{{ $artist['artist_image'] }}" alt="{{ $artist['artist_name'] }}" class="profile-image">
            @else
                <div class="default-profile">
                    <i class="fas fa-user"></i>
                </div>
            @endif
            
            <div>
                <h2 class="mb-1">{{ $artist['artist_name'] }}</h2>
                <div class="mb-2">
                    <span class="badge bg-secondary me-2">{{ $artist['genre'] }}</span>
                    @if($plan)
                        <span class="badge plan-badge">{{ $plan['plan_name'] }}</span>
                    @endif
                </div>
                <p class="text-muted mb-0">Slug: {{ $artist['artist_slug'] }}</p>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Sanatçı Bilgileri</div>
                    <div class="card-body">
                        <div class="mb-3">
                            <strong>ID:</strong> {{ $artist['artist_id'] }}
                        </div>
                        <div class="mb-3">
                            <strong>İsim:</strong> {{ $artist['artist_name'] }}
                        </div>
                        <div class="mb-3">
                            <strong>Müzik Türü:</strong> {{ $artist['genre'] }}
                        </div>
                        <div class="mb-3">
                            <strong>Slug:</strong> {{ $artist['artist_slug'] }}
                        </div>
                        <div>
                            <strong>Oluşturulma Tarihi:</strong> {{ \Carbon\Carbon::parse($artist['created_at'])->format('d.m.Y H:i') }}
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Abonelik Bilgileri</div>
                    <div class="card-body">
                        @if($plan)
                            <div class="mb-3">
                                <strong>Plan:</strong> {{ $plan['plan_name'] }}
                            </div>
                            <div class="mb-3">
                                <strong>Fiyat:</strong> {{ $plan['monthly_price'] }} {{ $plan['price_currency'] }} / ay
                            </div>
                            <div class="mb-3">
                                <strong>Maksimum Müzisyen Sayısı:</strong> {{ $plan['max_members'] }}
                            </div>
                            @if(!empty($plan['plan_features']) && is_array($plan['plan_features']))
                                <div>
                                    <strong>Özellikler:</strong>
                                    <ul class="mt-2">
                                        @foreach($plan['plan_features'] as $key => $value)
                                            <li>
                                                {{ ucfirst(str_replace('_', ' ', $key)) }}:
                                                <span class="{{ $value == 'yes' ? 'text-success' : 'text-danger' }}">
                                                    {{ $value == 'yes' ? 'Var' : 'Yok' }}
                                                </span>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        @else
                            <p>Abonelik bilgisi bulunamadı.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 