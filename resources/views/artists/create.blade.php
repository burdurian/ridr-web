<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RIDR - Yeni Sanatçı</title>
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
        .plan-card {
            border: 2px solid #e9ecef;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            transition: all 0.3s;
            position: relative;
        }
        .plan-card:hover {
            border-color: #6c63ff;
            cursor: pointer;
        }
        .plan-card.selected {
            border-color: #6c63ff;
            background-color: rgba(108, 99, 255, 0.05);
        }
        .plan-card .plan-check {
            position: absolute;
            top: 15px;
            right: 15px;
            width: 20px;
            height: 20px;
            border: 2px solid #adb5bd;
            border-radius: 50%;
        }
        .plan-card.selected .plan-check {
            background-color: #6c63ff;
            border-color: #6c63ff;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
        }
        .plan-price {
            font-size: 1.5rem;
            font-weight: bold;
            color: #343a40;
            margin: 15px 0;
        }
        .plan-features {
            margin: 15px 0;
        }
        .plan-features li {
            margin-bottom: 5px;
        }
        .plan-features .feature-yes {
            color: #28a745;
        }
        .plan-features .feature-no {
            color: #dc3545;
            text-decoration: line-through;
            opacity: 0.7;
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
                    <div class="col-12">
                        <a href="{{ route('artists.index') }}" class="btn btn-outline-secondary mb-3">
                            <i class="fas fa-arrow-left"></i> Sanatçılara Dön
                        </a>
                        <h2>Yeni Sanatçı Ekle</h2>
                    </div>
                </div>

                @if(session('error'))
                    <div class="alert alert-danger mb-4">
                        {{ session('error') }}
                    </div>
                @endif

                <form action="{{ route('artists.store') }}" method="POST">
                    @csrf
                    <div class="card mb-4">
                        <div class="card-header bg-white">
                            <h5 class="mb-0">Sanatçı Bilgileri</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="artist_name" class="form-label">Sanatçı Adı *</label>
                                <input type="text" class="form-control @error('artist_name') is-invalid @enderror" id="artist_name" name="artist_name" value="{{ old('artist_name') }}" required>
                                @error('artist_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label for="genre" class="form-label">Müzik Türü *</label>
                                <select class="form-select @error('genre') is-invalid @enderror" id="genre" name="genre" required>
                                    <option value="" selected disabled>Seçiniz...</option>
                                    <option value="Pop" {{ old('genre') == 'Pop' ? 'selected' : '' }}>Pop</option>
                                    <option value="Rock" {{ old('genre') == 'Rock' ? 'selected' : '' }}>Rock</option>
                                    <option value="Hip Hop" {{ old('genre') == 'Hip Hop' ? 'selected' : '' }}>Hip Hop</option>
                                    <option value="R&B" {{ old('genre') == 'R&B' ? 'selected' : '' }}>R&B</option>
                                    <option value="Elektronik" {{ old('genre') == 'Elektronik' ? 'selected' : '' }}>Elektronik</option>
                                    <option value="Jazz" {{ old('genre') == 'Jazz' ? 'selected' : '' }}>Jazz</option>
                                    <option value="Klasik" {{ old('genre') == 'Klasik' ? 'selected' : '' }}>Klasik</option>
                                    <option value="Türk Halk Müziği" {{ old('genre') == 'Türk Halk Müziği' ? 'selected' : '' }}>Türk Halk Müziği</option>
                                    <option value="Türk Sanat Müziği" {{ old('genre') == 'Türk Sanat Müziği' ? 'selected' : '' }}>Türk Sanat Müziği</option>
                                    <option value="Arabesk" {{ old('genre') == 'Arabesk' ? 'selected' : '' }}>Arabesk</option>
                                    <option value="Diğer" {{ old('genre') == 'Diğer' ? 'selected' : '' }}>Diğer</option>
                                </select>
                                @error('genre')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label for="artist_image" class="form-label">Sanatçı Resmi URL (İsteğe Bağlı)</label>
                                <input type="url" class="form-control @error('artist_image') is-invalid @enderror" id="artist_image" name="artist_image" value="{{ old('artist_image') }}" placeholder="https://ornek.com/resim.jpg">
                                @error('artist_image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Sanatçı resmi için geçerli bir URL girin. Boş bırakırsanız varsayılan görsel kullanılacaktır.</small>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header bg-white">
                            <h5 class="mb-0">Abonelik Planı Seçin</h5>
                            <p class="text-muted mb-0">Her sanatçı için bir abonelik planı seçmelisiniz.</p>
                        </div>
                        <div class="card-body">
                            @if(empty($plans))
                                <div class="alert alert-warning">
                                    Hiç abonelik planı bulunamadı. Lütfen sistem yöneticinizle iletişime geçin.
                                </div>
                            @else
                                <div class="row">
                                    @foreach($plans as $plan)
                                        <div class="col-md-4 mb-3">
                                            <div class="plan-card" onclick="selectPlan('{{ $plan['plan_id'] }}')">
                                                <div class="plan-check" id="plan-check-{{ $plan['plan_id'] }}"></div>
                                                <h4>{{ $plan['plan_name'] }}</h4>
                                                <div class="plan-price">
                                                    {{ number_format($plan['monthly_price'], 2) }} {{ $plan['price_currency'] }}/ay
                                                </div>
                                                <p>{{ $plan['plan_desc'] }}</p>
                                                <p>Maksimum {{ $plan['max_members'] }} sanatçı</p>
                                                
                                                @if(isset($plan['plan_features']) && is_array($plan['plan_features']))
                                                    <ul class="plan-features list-unstyled">
                                                        @foreach($plan['plan_features'] as $feature => $value)
                                                            <li class="{{ $value == 'yes' ? 'feature-yes' : 'feature-no' }}">
                                                                <i class="fas {{ $value == 'yes' ? 'fa-check' : 'fa-times' }} me-2"></i>
                                                                {{ ucwords(str_replace('_', ' ', $feature)) }}
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                @endif
                                            </div>
                                            <input type="radio" name="subscription_plan" id="plan-{{ $plan['plan_id'] }}" value="{{ $plan['plan_id'] }}" class="d-none" {{ old('subscription_plan') == $plan['plan_id'] ? 'checked' : '' }}>
                                        </div>
                                    @endforeach
                                </div>
                                @error('subscription_plan')
                                    <div class="text-danger">Lütfen bir abonelik planı seçin.</div>
                                @enderror
                            @endif
                        </div>
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary">Sanatçı Oluştur</button>
                        <a href="{{ route('artists.index') }}" class="btn btn-outline-secondary ms-2">İptal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function selectPlan(planId) {
            // Tüm plan kartlarını döngüye al
            document.querySelectorAll('.plan-card').forEach(card => {
                card.classList.remove('selected');
                card.querySelector('.plan-check').innerHTML = '';
            });
            
            // Seçili plan kartını güncelle
            const selectedCard = document.querySelector(`.plan-card:has(+ #plan-${planId}), .plan-card:has(+ input[value="${planId}"])`);
            if (selectedCard) {
                selectedCard.classList.add('selected');
                selectedCard.querySelector('.plan-check').innerHTML = '<i class="fas fa-check" style="font-size: 0.8rem;"></i>';
            }
            
            // Radio butonunu seç
            document.getElementById(`plan-${planId}`).checked = true;
        }

        // Sayfa yüklendiğinde seçili planı kontrol et
        document.addEventListener('DOMContentLoaded', function() {
            const checkedPlan = document.querySelector('input[name="subscription_plan"]:checked');
            if (checkedPlan) {
                selectPlan(checkedPlan.value);
            }
        });
    </script>
</body>
</html> 