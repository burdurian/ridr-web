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
            <div class="col-md-6">
                <div class="info-card">
                    <div class="info-card-header">
                        <h4><i class="fas fa-info-circle me-2"></i> Sanatçı Bilgileri</h4>
                    </div>
                    <div class="info-card-body">
                        <div class="info-item">
                            <div class="info-label">ID:</div>
                            <div class="info-value">{{ $artist['artist_id'] }}</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">İsim:</div>
                            <div class="info-value">{{ $artist['artist_name'] }}</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Müzik Türü:</div>
                            <div class="info-value">{{ $artist['genre'] }}</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Slug:</div>
                            <div class="info-value">{{ $artist['artist_slug'] }}</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Oluşturulma Tarihi:</div>
                            <div class="info-value">{{ \Carbon\Carbon::parse($artist['created_at'])->format('d.m.Y H:i') }}</div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6">
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

        <div class="row mt-4">
            <div class="col-12">
                <div class="info-card">
                    <div class="info-card-header d-flex justify-content-between align-items-center">
                        <h4><i class="fas fa-users me-2"></i> Sanatçı Ekibi</h4>
                        <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addTeamMemberModal">
                            <i class="fas fa-user-plus me-1"></i> Yeni Üye Ekle
                        </button>
                    </div>
                    <div class="info-card-body">
                        <div class="table-responsive">
                            <table class="table table-hover" id="teamMembersTable">
                                <thead>
                                    <tr>
                                        <th scope="col">Üye</th>
                                        <th scope="col">Rol</th>
                                        <th scope="col">İşlemler</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(empty($teamMembers))
                                        <tr>
                                            <td colspan="3" class="text-center py-4">
                                                <p class="text-muted mb-0">Henüz ekip üyesi eklenmemiş.</p>
                                            </td>
                                        </tr>
                                    @else
                                        @foreach($teamMembers as $member)
                                            <tr data-user-id="{{ $member['user_id'] }}">
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        @if(!empty($member['user_img']))
                                                            <img src="{{ $member['user_img'] }}" alt="{{ $member['user_name'] }}" class="rounded-circle me-3" style="width: 40px; height: 40px; object-fit: cover;">
                                                        @else
                                                            <div class="rounded-circle me-3 bg-light d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                                <i class="fas fa-user text-secondary"></i>
                                                            </div>
                                                        @endif
                                                        <div>
                                                            <h6 class="mb-0">{{ $member['user_name'] }} {{ $member['user_surname'] }}</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="badge {{ $member['is_admin'] ? 'bg-primary' : 'bg-secondary' }}">
                                                        {{ $member['is_admin'] ? 'Yönetici' : 'Üye' }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-sm btn-outline-secondary change-role-btn" data-user-id="{{ $member['user_id'] }}" data-current-role="{{ $member['is_admin'] ? 'admin' : 'member' }}">
                                                            <i class="fas fa-exchange-alt me-1"></i> Rol Değiştir
                                                        </button>
                                                        <button type="button" class="btn btn-sm btn-outline-danger remove-member-btn" data-user-id="{{ $member['user_id'] }}">
                                                            <i class="fas fa-user-minus me-1"></i> Çıkar
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Yeni Ekip Üyesi Ekleme Modal -->
    <div class="modal fade" id="addTeamMemberModal" tabindex="-1" aria-labelledby="addTeamMemberModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addTeamMemberModalLabel">Yeni Ekip Üyesi Ekle</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Kapat"></button>
                </div>
                <div class="modal-body">
                    <div class="search-container mb-4">
                        <label for="phone" class="form-label">Telefon Numarası</label>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" id="phone" placeholder="5xxxxxxxxx, 05xxxxxxxxx veya +905xxxxxxxxx">
                            <button class="btn btn-primary" type="button" id="searchUserBtn">
                                <i class="fas fa-search"></i> Ara
                            </button>
                        </div>
                        <small class="form-text text-muted">Kullanıcının sisteme kayıtlı telefon numarasını girin.</small>
                    </div>
                    
                    <div id="userSearchResult" class="d-none">
                        <div class="alert alert-danger d-none" id="searchError"></div>
                        
                        <div class="card mb-3 d-none" id="userCard">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="user-image-container me-3">
                                        <img src="" alt="" class="rounded-circle d-none" id="userImage" style="width: 60px; height: 60px; object-fit: cover;">
                                        <div class="rounded-circle bg-light d-flex align-items-center justify-content-center d-none" id="userDefaultImage" style="width: 60px; height: 60px;">
                                            <i class="fas fa-user text-secondary fa-2x"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <h5 class="card-title mb-1" id="userName"></h5>
                                        <p class="card-text mb-0 text-muted" id="userPhone"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3 d-none" id="roleSelection">
                            <label class="form-label">Kullanıcı Rolü</label>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="userRole" id="roleMember" value="member" checked>
                                <label class="form-check-label" for="roleMember">
                                    <i class="fas fa-user me-1"></i> Üye
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="userRole" id="roleAdmin" value="admin">
                                <label class="form-check-label" for="roleAdmin">
                                    <i class="fas fa-user-shield me-1"></i> Yönetici
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">İptal</button>
                    <button type="button" class="btn btn-primary" id="addUserBtn" disabled>Ekle</button>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Telefon numarasıyla kullanıcı arama
            const searchUserBtn = document.getElementById('searchUserBtn');
            const phoneInput = document.getElementById('phone');
            const searchResult = document.getElementById('userSearchResult');
            const searchError = document.getElementById('searchError');
            const userCard = document.getElementById('userCard');
            const userImage = document.getElementById('userImage');
            const userDefaultImage = document.getElementById('userDefaultImage');
            const userName = document.getElementById('userName');
            const userPhone = document.getElementById('userPhone');
            const roleSelection = document.getElementById('roleSelection');
            const addUserBtn = document.getElementById('addUserBtn');
            let currentUserId = null;
            
            searchUserBtn.addEventListener('click', function() {
                const phone = phoneInput.value.trim();
                
                if (!phone) {
                    showSearchError('Lütfen bir telefon numarası girin.');
                    return;
                }
                
                // Kullanıcı arama isteği gönder
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
                    if (data.success) {
                        // Kullanıcı bulundu
                        showUserData(data.user);
                    } else {
                        // Kullanıcı bulunamadı
                        showSearchError(data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showSearchError('Bir hata oluştu. Lütfen tekrar deneyin.');
                });
            });
            
            // Kullanıcı bulunduğunda verileri göster
            function showUserData(user) {
                searchResult.classList.remove('d-none');
                searchError.classList.add('d-none');
                userCard.classList.remove('d-none');
                roleSelection.classList.remove('d-none');
                addUserBtn.disabled = false;
                
                // Kullanıcı bilgilerini doldur
                if (user.user_img) {
                    userImage.src = user.user_img;
                    userImage.alt = user.user_name;
                    userImage.classList.remove('d-none');
                    userDefaultImage.classList.add('d-none');
                } else {
                    userImage.classList.add('d-none');
                    userDefaultImage.classList.remove('d-none');
                }
                
                userName.textContent = `${user.user_name} ${user.user_surname}`;
                userPhone.textContent = user.phone;
                currentUserId = user.user_id;
            }
            
            // Arama hatası göster
            function showSearchError(message) {
                searchResult.classList.remove('d-none');
                searchError.classList.remove('d-none');
                searchError.textContent = message;
                userCard.classList.add('d-none');
                roleSelection.classList.add('d-none');
                addUserBtn.disabled = true;
                currentUserId = null;
            }
            
            // Kullanıcı ekleme butonu
            addUserBtn.addEventListener('click', function() {
                if (!currentUserId) return;
                
                const role = document.querySelector('input[name="userRole"]:checked').value;
                
                // Ekip üyesi ekleme isteği gönder
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
                    if (data.success) {
                        // Başarılı ise sayfayı yenile
                        window.location.reload();
                    } else {
                        alert(data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Bir hata oluştu. Lütfen tekrar deneyin.');
                });
            });
            
            // Üye çıkarma butonları
            document.querySelectorAll('.remove-member-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const userId = this.getAttribute('data-user-id');
                    
                    if (confirm('Bu üyeyi sanatçı ekibinden çıkarmak istediğinize emin misiniz?')) {
                        // Üye çıkarma isteği gönder
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
                                // Başarılı ise sayfayı yenile
                                window.location.reload();
                            } else {
                                alert(data.message);
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('Bir hata oluştu. Lütfen tekrar deneyin.');
                        });
                    }
                });
            });
            
            // Rol değiştirme butonları
            document.querySelectorAll('.change-role-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const userId = this.getAttribute('data-user-id');
                    const currentRole = this.getAttribute('data-current-role');
                    const newRole = currentRole === 'admin' ? 'member' : 'admin';
                    const roleName = newRole === 'admin' ? 'Yönetici' : 'Üye';
                    
                    if (confirm(`Bu üyenin rolünü "${roleName}" olarak değiştirmek istediğinize emin misiniz?`)) {
                        // Rol değiştirme isteği gönder
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
                                // Başarılı ise sayfayı yenile
                                window.location.reload();
                            } else {
                                alert(data.message);
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('Bir hata oluştu. Lütfen tekrar deneyin.');
                        });
                    }
                });
            });
        });
    </script>
</body>
</html> 