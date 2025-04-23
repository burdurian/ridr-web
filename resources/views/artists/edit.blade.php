<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $artist['artist_name'] }} Düzenle - Ridr</title>
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
        .btn-save {
            background-color: #6c63ff;
            border-color: #6c63ff;
        }
        .btn-save:hover {
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
            <h1>Sanatçı Düzenle</h1>
            <div>
                <a href="{{ route('artists.show', $artist['artist_id']) }}" class="btn btn-back me-2">
                    <i class="fas fa-arrow-left me-1"></i> Detaylara Geri Dön
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
        
        <div class="card">
            <div class="card-header">Sanatçı Bilgilerini Düzenle</div>
            <div class="card-body">
                <form action="{{ route('artists.update', $artist['artist_id']) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="artist_name" class="form-label">Sanatçı Adı</label>
                        <input type="text" class="form-control @error('artist_name') is-invalid @enderror" id="artist_name" name="artist_name" value="{{ old('artist_name', $artist['artist_name']) }}" required>
                        @error('artist_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="genre" class="form-label">Müzik Türü</label>
                        <select class="form-select @error('genre') is-invalid @enderror" id="genre" name="genre" required>
                            <option value="" disabled>Seçiniz</option>
                            <option value="Pop" {{ (old('genre', $artist['genre']) == 'Pop') ? 'selected' : '' }}>Pop</option>
                            <option value="Rock" {{ (old('genre', $artist['genre']) == 'Rock') ? 'selected' : '' }}>Rock</option>
                            <option value="Hip Hop" {{ (old('genre', $artist['genre']) == 'Hip Hop') ? 'selected' : '' }}>Hip Hop</option>
                            <option value="R&B" {{ (old('genre', $artist['genre']) == 'R&B') ? 'selected' : '' }}>R&B</option>
                            <option value="Elektronik" {{ (old('genre', $artist['genre']) == 'Elektronik') ? 'selected' : '' }}>Elektronik</option>
                            <option value="Klasik" {{ (old('genre', $artist['genre']) == 'Klasik') ? 'selected' : '' }}>Klasik</option>
                            <option value="Jazz" {{ (old('genre', $artist['genre']) == 'Jazz') ? 'selected' : '' }}>Jazz</option>
                            <option value="Blues" {{ (old('genre', $artist['genre']) == 'Blues') ? 'selected' : '' }}>Blues</option>
                            <option value="Folk" {{ (old('genre', $artist['genre']) == 'Folk') ? 'selected' : '' }}>Folk</option>
                            <option value="Metal" {{ (old('genre', $artist['genre']) == 'Metal') ? 'selected' : '' }}>Metal</option>
                            <option value="Country" {{ (old('genre', $artist['genre']) == 'Country') ? 'selected' : '' }}>Country</option>
                            <option value="Reggae" {{ (old('genre', $artist['genre']) == 'Reggae') ? 'selected' : '' }}>Reggae</option>
                            <option value="Punk" {{ (old('genre', $artist['genre']) == 'Punk') ? 'selected' : '' }}>Punk</option>
                            <option value="Türk Halk Müziği" {{ (old('genre', $artist['genre']) == 'Türk Halk Müziği') ? 'selected' : '' }}>Türk Halk Müziği</option>
                            <option value="Türk Sanat Müziği" {{ (old('genre', $artist['genre']) == 'Türk Sanat Müziği') ? 'selected' : '' }}>Türk Sanat Müziği</option>
                            <option value="Arabesk" {{ (old('genre', $artist['genre']) == 'Arabesk') ? 'selected' : '' }}>Arabesk</option>
                            <option value="Diğer" {{ (old('genre', $artist['genre']) == 'Diğer') ? 'selected' : '' }}>Diğer</option>
                        </select>
                        @error('genre')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="artist_image" class="form-label">Fotoğraf URL (İsteğe Bağlı)</label>
                        <input type="url" class="form-control @error('artist_image') is-invalid @enderror" id="artist_image" name="artist_image" value="{{ old('artist_image', $artist['artist_image']) }}">
                        <div class="form-text">Sanatçınızın fotoğrafı için bir URL girin</div>
                        @error('artist_image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-4">
                        <label class="form-label">Mevcut Abonelik Planı</label>
                        <div class="card bg-light">
                            <div class="card-body">
                                @if(isset($plans))
                                    @foreach($plans as $plan)
                                        @if($plan['plan_id'] == $artist['subscription_plan'])
                                            <h5 class="mb-1">{{ $plan['plan_name'] }}</h5>
                                            <p class="mb-2">{{ $plan['monthly_price'] }} {{ $plan['price_currency'] }} / ay</p>
                                            <p class="mb-0 small text-muted">Maksimum {{ $plan['max_members'] }} sanatçı</p>
                                        @endif
                                    @endforeach
                                @else
                                    <p class="mb-0">Abonelik bilgisi bulunamadı.</p>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('artists.show', $artist['artist_id']) }}" class="btn btn-back">İptal</a>
                        <button type="submit" class="btn btn-save">
                            <i class="fas fa-save me-1"></i> Değişiklikleri Kaydet
                        </button>
                    </div>
                </form>
            </div>
        </div>
        
        <div class="card bg-danger bg-opacity-10 border-0 mt-4">
            <div class="card-body">
                <h5 class="text-danger mb-3">Sanatçıyı Sil</h5>
                <p class="text-muted">Bu işlem geri alınamaz. Sanatçı ve ilgili tüm bilgiler kalıcı olarak silinecektir.</p>
                <form action="{{ route('artists.destroy', $artist['artist_id']) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Sanatçıyı silmek istediğinizden emin misiniz? Bu işlem geri alınamaz.')">
                        <i class="fas fa-trash me-1"></i> Sanatçıyı Sil
                    </button>
                </form>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 