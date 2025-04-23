<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RIDR - Sanatçılar</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .sidebar {
            background-color: #343a40;
            min-height: 100vh;
            color: white;
            padding-top: 20px;
        }
        .sidebar-header {
            text-align: center;
            padding-bottom: 20px;
            border-bottom: 1px solid #484e53;
        }
        .sidebar-menu {
            padding-top: 20px;
        }
        .sidebar-menu a {
            color: rgba(255, 255, 255, 0.8);
            display: block;
            padding: 10px 20px;
            text-decoration: none;
            transition: all 0.3s;
        }
        .sidebar-menu a:hover, .sidebar-menu a.active {
            color: white;
            background-color: #2c3136;
        }
        .sidebar-menu i {
            margin-right: 10px;
        }
        .main-content {
            padding: 30px;
        }
        .card {
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            height: 100%;
        }
        .card-img-top {
            height: 200px;
            object-fit: cover;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
        }
        .artist-placeholder {
            height: 200px;
            background-color: #e9ecef;
            display: flex;
            align-items: center;
            justify-content: center;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
        }
        .user-info {
            text-align: center;
            margin-bottom: 30px;
        }
        .user-info img {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            margin-bottom: 10px;
            object-fit: cover;
        }
        .badge-plan {
            background-color: #6c63ff;
            color: white;
            font-weight: normal;
            padding: 5px 10px;
            border-radius: 30px;
            margin-bottom: 10px;
            display: inline-block;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 sidebar">
                <div class="sidebar-header">
                    <h3>RIDR</h3>
                    <div class="user-info">
                        @if(isset(session('manager')['company_logo']) && !empty(session('manager')['company_logo']))
                            <img src="{{ session('manager')['company_logo'] }}" alt="Logo">
                        @else
                            <div style="width: 80px; height: 80px; background-color: #6c63ff; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 10px;">
                                <i class="fas fa-user" style="font-size: 2rem; color: white;"></i>
                            </div>
                        @endif
                        <h5>{{ session('manager')['manager_name'] }} {{ session('manager')['manager_surname'] }}</h5>
                        <p class="text-muted">{{ session('manager')['company'] ?? 'Menajer' }}</p>
                    </div>
                </div>
                <div class="sidebar-menu">
                    <a href="{{ route('dashboard') }}">
                        <i class="fas fa-tachometer-alt"></i> Dashboard
                    </a>
                    <a href="{{ route('artists.index') }}" class="active">
                        <i class="fas fa-music"></i> Sanatçılar
                    </a>
                    <a href="{{ route('subscriptions.index') }}">
                        <i class="fas fa-credit-card"></i> Abonelikler
                    </a>
                    <form action="{{ route('logout') }}" method="POST" class="mt-5">
                        @csrf
                        <button type="submit" class="btn btn-link text-white-50" style="text-decoration: none; width: 100%; text-align: left; padding: 10px 20px;">
                            <i class="fas fa-sign-out-alt"></i> Çıkış Yap
                        </button>
                    </form>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-md-9 col-lg-10 main-content">
                <div class="row mb-4">
                    <div class="col-md-8">
                        <h2>Sanatçılarım</h2>
                    </div>
                    <div class="col-md-4 text-end">
                        <a href="{{ route('artists.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Yeni Sanatçı Ekle
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

                @if(empty($artists))
                    <div class="alert alert-info">
                        Henüz hiç sanatçınız yok. <a href="{{ route('artists.create') }}">Yeni bir sanatçı ekleyin</a> ve başlayın!
                    </div>
                @else
                    <div class="row">
                        @foreach($artists as $artist)
                            <div class="col-md-4 col-lg-3 mb-4">
                                <div class="card">
                                    @if(!empty($artist['artist_image']))
                                        <img src="{{ $artist['artist_image'] }}" class="card-img-top" alt="{{ $artist['artist_name'] }}">
                                    @else
                                        <div class="artist-placeholder">
                                            <i class="fas fa-music fa-3x text-muted"></i>
                                        </div>
                                    @endif
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $artist['artist_name'] }}</h5>
                                        @if(isset($artist['plan']))
                                            <span class="badge-plan">{{ $artist['plan']['plan_name'] }}</span>
                                        @endif
                                        <p class="card-text">{{ $artist['genre'] }}</p>
                                        <div class="d-flex justify-content-between">
                                            <a href="{{ route('artists.show', $artist['artist_id']) }}" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-eye"></i> Görüntüle
                                            </a>
                                            <a href="{{ route('artists.edit', $artist['artist_id']) }}" class="btn btn-sm btn-outline-secondary">
                                                <i class="fas fa-edit"></i> Düzenle
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 