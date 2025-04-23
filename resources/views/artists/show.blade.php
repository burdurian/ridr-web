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
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.min.css">
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
                <!-- Ekip Yönetimi Kartı -->
                <div class="info-card team-management-card">
                    <div class="info-card-header d-flex justify-content-between align-items-center">
                        <h4><i class="fas fa-users me-2"></i> Sanatçı Ekibi</h4>
                        <span class="badge bg-primary">{{ empty($teamMembers) ? 0 : count($teamMembers) }} Üye</span>
                    </div>
                    <div class="info-card-body p-0">
                        <div class="team-add-section p-4 bg-light border-bottom">
                            <h5 class="mb-3 text-primary fw-bold"><i class="fas fa-user-plus me-2"></i> Yeni Ekip Üyesi Ekle</h5>
                            <div class="input-group mb-2">
                                <span class="input-group-text bg-white"><i class="fas fa-phone text-primary"></i></span>
                                <input type="text" id="phoneSearch" class="form-control py-2" placeholder="Telefon numarası girin (5xxxxxxxxx)">
                                <button type="button" id="searchUserBtn" class="btn btn-primary px-4">
                                    <i class="fas fa-search me-2"></i> Ara
                                </button>
                            </div>
                            <small class="text-muted d-block">Eklemek istediğiniz kişinin telefon numarasını girerek sistemde arayın</small>
                        </div>
                        
                        <div id="searchResults" class="search-results-container d-none p-4 border-bottom">
                            <div class="d-flex align-items-center" id="userResultContainer">
                                <div id="userImageContainer" class="me-3">
                                    <img id="userImage" src="" alt="" class="rounded-circle d-none" style="width: 60px; height: 60px; object-fit: cover;">
                                    <div id="userDefaultImage" class="rounded-circle bg-light d-flex align-items-center justify-content-center d-none" style="width: 60px; height: 60px;">
                                        <i class="fas fa-user text-secondary"></i>
                                    </div>
                                </div>
                                <div class="user-info flex-grow-1">
                                    <h5 id="userName" class="mb-1 user-name-text"></h5>
                                    <p id="userPhone" class="mb-0 text-muted user-phone-text"></p>
                                </div>
                                <div class="d-flex flex-column flex-md-row align-items-end align-items-md-center gap-2">
                                    <select id="userRoleSelect" class="form-select role-select">
                                        <option value="member">Üye</option>
                                        <option value="admin">Yönetici</option>
                                    </select>
                                    <button id="addUserBtn" class="btn btn-success add-user-btn">
                                        <i class="fas fa-plus me-2"></i> Ekle
                                    </button>
                                </div>
                            </div>
                            <div id="searchError" class="alert alert-danger mt-3 mb-0 d-none"></div>
                        </div>
                        
                        <div class="p-4">
                            <h5 class="mb-4"><i class="fas fa-list-ul me-2 text-primary"></i> Mevcut Ekip Üyeleri</h5>
                            <div class="team-members-list">
                                @if(empty($teamMembers))
                                    <div class="empty-team-state text-center py-5 bg-light rounded">
                                        <div class="empty-team-icon mb-3 mx-auto">
                                            <i class="fas fa-users text-muted" style="font-size: 36px; opacity: 0.3;"></i>
                                        </div>
                                        <h5 class="text-muted">Henüz Ekip Üyesi Yok</h5>
                                        <p class="text-muted mb-0">Yukarıdan telefon numarası ile arama yaparak ekip üyesi ekleyebilirsiniz</p>
                                    </div>
                                @else
                                    @foreach($teamMembers as $member)
                                        <div class="team-member-item card mb-3 shadow-sm" data-user-id="{{ $member['user_id'] }}">
                                            <div class="card-body d-flex align-items-center position-relative py-3">
                                                <div class="member-avatar me-3">
                                                    @if(!empty($member['user_img']))
                                                        <img src="{{ $member['user_img'] }}" alt="{{ $member['user_name'] }}" class="rounded-circle" style="width: 60px; height: 60px; object-fit: cover;">
                                                    @else
                                                        <div class="rounded-circle bg-light d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                                            <i class="fas fa-user text-secondary"></i>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="member-info flex-grow-1">
                                                    <h5 class="mb-1 member-name">{{ $member['user_name'] }} {{ $member['user_surname'] }}</h5>
                                                    <div class="d-flex align-items-center member-meta">
                                                        <span class="badge {{ $member['is_admin'] ? 'bg-primary' : 'bg-secondary' }} me-2">
                                                            {{ $member['is_admin'] ? 'Yönetici' : 'Üye' }}
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="member-actions">
                                                    <div class="dropdown">
                                                        <button class="btn btn-light" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                            <i class="fas fa-ellipsis-v"></i>
                                                        </button>
                                                        <ul class="dropdown-menu dropdown-menu-end">
                                                            <li>
                                                                <a class="dropdown-item change-role-btn" href="#" data-user-id="{{ $member['user_id'] }}" data-current-role="{{ $member['is_admin'] ? 'admin' : 'member' }}">
                                                                    <i class="fas fa-exchange-alt me-2 text-primary"></i>
                                                                    {{ $member['is_admin'] ? 'Üye Yap' : 'Yönetici Yap' }}
                                                                </a>
                                                            </li>
                                                            <li><hr class="dropdown-divider"></li>
                                                            <li>
                                                                <a class="dropdown-item text-danger remove-member-btn" href="#" data-user-id="{{ $member['user_id'] }}">
                                                                    <i class="fas fa-user-minus me-2"></i>
                                                                    Çıkar
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
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
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.all.min.js"></script>
    <script>
        $(document).ready(function() {
            // Telefon numarası arama kısmına odaklandığında arkaplan değişimi
            $('#phoneSearch').on('focus', function() {
                $('.team-add-section').addClass('search-focused');
            }).on('blur', function() {
                $('.team-add-section').removeClass('search-focused');
            });

            // Kullanıcı Arama
            $('#searchUserBtn').on('click', function() {
                searchUser();
            });

            $('#phoneSearch').on('keypress', function(e) {
                if (e.which === 13) {
                    searchUser();
                }
            });

            function searchUser() {
                const phoneNumber = $('#phoneSearch').val().trim();
                
                if (!phoneNumber) {
                    showSearchError('Lütfen bir telefon numarası girin');
                    return;
                }
                
                // Yükleniyor göstergesi
                $('#searchUserBtn').html('<i class="fas fa-spinner fa-spin"></i>');
                $('#searchError').addClass('d-none');
                
                $.ajax({
                    url: '/api/artists/find-user',
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        phone: phoneNumber,
                        artist_id: '{{ $artist["artist_id"] }}'
                    },
                    success: function(response) {
                        // Buton metnini geri yükle
                        $('#searchUserBtn').html('<i class="fas fa-search me-2"></i> Ara');
                        
                        if (response.success) {
                            const userData = response.user;
                            
                            // Kullanıcı sonucunu göster
                            $('#userName').text(userData.user_name + ' ' + userData.user_surname);
                            $('#userPhone').text(userData.phone);
                            
                            if (userData.user_img) {
                                $('#userImage').attr('src', userData.user_img).removeClass('d-none');
                                $('#userDefaultImage').addClass('d-none');
                            } else {
                                $('#userImage').addClass('d-none');
                                $('#userDefaultImage').removeClass('d-none');
                            }
                            
                            // Kullanıcı ID'sini ekle butonu için sakla
                            $('#addUserBtn').data('user-id', userData.user_id);
                            
                            // Sonuç konteynırını göster
                            $('#searchResults').removeClass('d-none');
                            $('#userResultContainer').removeClass('d-none');
                            
                            // Sonuç animasyonu
                            $('#userResultContainer').css('opacity', '0').animate({
                                opacity: 1
                            }, 300);
                            
                        } else {
                            showSearchError(response.message || 'Kullanıcı bulunamadı');
                        }
                    },
                    error: function(xhr) {
                        $('#searchUserBtn').html('<i class="fas fa-search me-2"></i> Ara');
                        
                        let errorMessage = 'Arama sırasında bir hata oluştu';
                        
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        } else if (xhr.status === 404) {
                            errorMessage = 'Bu telefon numarasına sahip kullanıcı bulunamadı';
                        } else if (xhr.status === 422) {
                            errorMessage = 'Geçersiz telefon numarası formatı';
                        }
                        
                        showSearchError(errorMessage);
                    }
                });
            }

            function showSearchError(message) {
                $('#searchResults').removeClass('d-none');
                $('#userResultContainer').addClass('d-none');
                $('#searchError').removeClass('d-none').text(message);
            }

            // Kullanıcı Ekleme
            $('#addUserBtn').on('click', function() {
                const userId = $(this).data('user-id');
                const userRole = $('#userRoleSelect').val();
                
                if (!userId) {
                    showSearchError('Kullanıcı bulunamadı');
                    return;
                }
                
                // Buton yükleniyor durumu
                const originalBtnText = $(this).html();
                $(this).html('<i class="fas fa-spinner fa-spin"></i> Ekleniyor...').prop('disabled', true);
                
                $.ajax({
                    url: '/api/artists/{{ $artist["artist_id"] }}/team/add',
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        user_id: userId,
                        role: userRole
                    },
                    success: function(response) {
                        if (response.success) {
                            // Yeni üyeyi ekle
                            Swal.fire({
                                icon: 'success',
                                title: 'Başarılı!',
                                text: 'Kullanıcı ekip üyesi olarak eklendi',
                                showConfirmButton: false,
                                timer: 1500
                            }).then(() => {
                                // Sayfayı yenile
                                location.reload();
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Hata',
                                text: response.message || 'Kullanıcı eklenirken bir hata oluştu'
                            });
                            $('#addUserBtn').html(originalBtnText).prop('disabled', false);
                        }
                    },
                    error: function(xhr) {
                        let errorMessage = 'Kullanıcı eklenirken bir hata oluştu';
                        
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        }
                        
                        Swal.fire({
                            icon: 'error',
                            title: 'Hata',
                            text: errorMessage
                        });
                        
                        $('#addUserBtn').html(originalBtnText).prop('disabled', false);
                    }
                });
            });

            // Ekip Üyesi Rolünü Değiştirme
            $('.change-role-btn').on('click', function(e) {
                e.preventDefault();
                
                const userId = $(this).data('user-id');
                const currentRole = $(this).data('current-role');
                const newRole = currentRole === 'admin' ? 'member' : 'admin';
                const $memberItem = $(this).closest('.team-member-item');
                
                // Rol değiştirilirken animasyon
                $memberItem.addClass('role-changing');
                
                $.ajax({
                    url: '/api/artists/{{ $artist["artist_id"] }}/team/change-role',
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        user_id: userId,
                        role: newRole
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Başarılı!',
                                text: 'Kullanıcı rolü güncellendi',
                                showConfirmButton: false,
                                timer: 1500
                            }).then(() => {
                                location.reload();
                            });
                        } else {
                            $memberItem.removeClass('role-changing');
                            Swal.fire({
                                icon: 'error',
                                title: 'Hata',
                                text: response.message || 'Rol değiştirilirken bir hata oluştu'
                            });
                        }
                    },
                    error: function(xhr) {
                        $memberItem.removeClass('role-changing');
                        
                        let errorMessage = 'Rol değiştirilirken bir hata oluştu';
                        
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        }
                        
                        Swal.fire({
                            icon: 'error',
                            title: 'Hata',
                            text: errorMessage
                        });
                    }
                });
            });

            // Ekip Üyesini Çıkarma
            $('.remove-member-btn').on('click', function(e) {
                e.preventDefault();
                
                const userId = $(this).data('user-id');
                const $memberItem = $(this).closest('.team-member-item');
                
                Swal.fire({
                    title: 'Emin misiniz?',
                    text: "Bu kullanıcıyı ekipten çıkarmak istediğinize emin misiniz?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Evet, çıkar',
                    cancelButtonText: 'İptal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Çıkarma işlemi animasyonu
                        $memberItem.css('opacity', '1').animate({
                            opacity: 0.5
                        }, 300);
                        
                        $.ajax({
                            url: '/api/artists/{{ $artist["artist_id"] }}/team/remove',
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            data: {
                                user_id: userId
                            },
                            success: function(response) {
                                if (response.success) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Başarılı!',
                                        text: 'Kullanıcı ekipten çıkarıldı',
                                        showConfirmButton: false,
                                        timer: 1500
                                    }).then(() => {
                                        // Sayfayı yenile
                                        location.reload();
                                    });
                                } else {
                                    $memberItem.animate({
                                        opacity: 1
                                    }, 300);
                                    
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Hata',
                                        text: response.message || 'Kullanıcı çıkarılırken bir hata oluştu'
                                    });
                                }
                            },
                            error: function(xhr) {
                                $memberItem.animate({
                                    opacity: 1
                                }, 300);
                                
                                let errorMessage = 'Kullanıcı çıkarılırken bir hata oluştu';
                                
                                if (xhr.responseJSON && xhr.responseJSON.message) {
                                    errorMessage = xhr.responseJSON.message;
                                }
                                
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Hata',
                                    text: errorMessage
                                });
                            }
                        });
                    }
                });
            });
        });
    </script>
    <style>
        .team-management-card {
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
            border-radius: 16px;
            overflow: hidden;
        }
        
        .team-management-card .info-card-header {
            background-color: #fff;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            padding: 20px 25px;
        }
        
        .team-add-section {
            background-color: #f8f9fd;
            transition: all 0.3s ease;
        }
        
        .search-focused {
            background-color: #fff !important;
            box-shadow: 0 4px 12px rgba(108, 99, 255, 0.15) !important;
        }
        
        #phoneSearch {
            font-size: 16px;
            transition: all 0.3s ease;
        }
        
        #phoneSearch:focus {
            outline: none;
            border-color: #6c63ff;
            box-shadow: 0 0 0 0.25rem rgba(108, 99, 255, 0.25);
        }
        
        #searchUserBtn {
            font-size: 16px;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        
        .search-results-container {
            background-color: #fff;
            transition: all 0.3s ease;
        }
        
        .team-member-item {
            transition: all 0.3s ease;
            border-radius: 10px;
        }
        
        .team-member-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08) !important;
        }
        
        .badge {
            padding: 8px 16px;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.3s ease;
            border-radius: 30px;
        }
        
        .role-changing {
            animation: rolePulse 1.5s infinite;
        }
        
        .user-name-text,
        .member-name {
            font-weight: 600;
            color: #333;
            font-size: 18px;
        }
        
        .user-phone-text {
            color: #6c757d;
            font-size: 15px;
        }
        
        .member-meta {
            margin-top: 5px;
        }
        
        .role-select {
            border-color: #eaecef;
            font-size: 16px;
            padding: 10px 16px;
            border-radius: 8px;
        }
        
        .add-user-btn {
            border-radius: 8px;
            padding: 10px 20px;
            font-size: 16px;
            transition: all 0.3s ease;
        }
        
        .add-user-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 10px rgba(46, 204, 113, 0.2);
        }
        
        .empty-team-state {
            background-color: #fcfcfc;
            border-radius: 12px;
        }
        
        .empty-team-icon {
            display: inline-block;
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background-color: #f5f5f5;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .team-members-list {
            max-height: 600px;
            overflow-y: auto;
        }
        
        @keyframes rolePulse {
            0% { opacity: 1; }
            50% { opacity: 0.5; }
            100% { opacity: 1; }
        }
        
        @media (max-width: 768px) {
            .user-info {
                margin-right: 20px;
            }
        }
    </style>
</body>
</html> 