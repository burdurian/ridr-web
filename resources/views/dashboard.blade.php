<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>RIDR - Menajer Paneli</title>
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

        /* Menajer Profil Kartı */
        .profile-card {
            background: #ffffff;
            border-radius: 16px;
            padding: 24px;
            margin-bottom: 24px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
            border: 1px solid rgba(0, 0, 0, 0.04);
            transition: all 0.3s ease;
        }

        .profile-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }

        .profile-header {
            display: flex;
            align-items: center;
            margin-bottom: 24px;
        }

        .profile-image {
            width: 80px;
            height: 80px;
            border-radius: 16px;
            overflow: hidden;
            margin-right: 20px;
            background-color: #f8f9fa;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
        }

        .profile-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .profile-image .placeholder {
            font-size: 32px;
            color: #6c63ff;
        }

        .profile-info h2 {
            font-size: 20px;
            font-weight: 600;
            color: #1a1a1a;
            margin-bottom: 4px;
            line-height: 1.4;
        }

        .profile-info .company {
            font-size: 14px;
            color: #64748b;
            margin-bottom: 4px;
            font-weight: 500;
        }

        .profile-info .email {
            font-size: 13px;
            color: #94a3b8;
            font-weight: 400;
        }

        .profile-stats {
            display: flex;
            justify-content: space-between;
            margin-top: 24px;
            padding-top: 20px;
            border-top: 1px solid rgba(0, 0, 0, 0.04);
        }

        .stat {
            text-align: center;
            flex: 1;
        }

        .stat-value {
            font-size: 20px;
            font-weight: 600;
            color: #1a1a1a;
            margin-bottom: 4px;
        }

        .stat-label {
            font-size: 13px;
            color: #64748b;
            font-weight: 500;
        }

        /* Dashboard Kartlar */
        .dashboard-card {
            background-color: #fff;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            padding: 25px;
            height: 100%;
            transition: all 0.3s;
            position: relative;
            border: none;
        }

        .dashboard-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .dashboard-card .card-header {
            background-color: transparent;
            border-bottom: 0;
            padding: 0 0 15px 0;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .dashboard-card .card-header h5 {
            font-weight: 600;
            font-size: 18px;
            margin: 0;
        }

        .dashboard-card .card-header .card-icon {
            width: 45px;
            height: 45px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            color: white;
        }

        .dashboard-card.purple .card-icon {
            background: linear-gradient(135deg, #6c63ff 0%, #4a44e0 100%);
        }

        .dashboard-card.blue .card-icon {
            background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);
        }

        .dashboard-card .card-body {
            padding: 0;
        }

        .dashboard-card .card-text {
            font-size: 15px;
            color: #7f8c8d;
            margin-bottom: 20px;
            line-height: 1.6;
        }

        .dashboard-card .card-footer {
            background-color: transparent;
            border-top: 0;
            padding: 15px 0 0 0;
        }

        .dashboard-card .btn {
            padding: 10px 20px;
            border-radius: 10px;
            font-weight: 500;
            transition: all 0.3s;
        }

        .dashboard-card .btn-primary {
            background-color: #6c63ff;
            border-color: #6c63ff;
        }

        .dashboard-card .btn-primary:hover {
            background-color: #5a52e0;
            border-color: #5a52e0;
        }

        .dashboard-card .btn-outline-primary {
            color: #6c63ff;
            border-color: #6c63ff;
        }

        .dashboard-card .btn-outline-primary:hover {
            background-color: #6c63ff;
            border-color: #6c63ff;
            color: white;
        }

        /* Sanatçı listesi */
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

        /* Alt menü */
        .footer {
            margin-top: 40px;
            padding: 20px 0;
            text-align: center;
            color: #95a5a6;
            font-size: 14px;
        }

        /* Duyarlı tasarım ayarlamaları */
        @media (max-width: 992px) {
            .profile-card {
                margin-bottom: 30px;
            }
        }

        @media (max-width: 768px) {
            .profile-header {
                flex-direction: column;
                text-align: center;
            }
            
            .profile-image {
                margin-right: 0;
                margin-bottom: 15px;
            }
            
            .profile-stats {
                flex-wrap: wrap;
            }
            
            .stat {
                flex: 0 0 50%;
                margin-bottom: 15px;
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
            @if(!isset($reviewMode) || $reviewMode == false)
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('dashboard') }}">
                            <i class="fas fa-home"></i> Ana Sayfa
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
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row">
            <!-- Profil kartı -->
            <div class="col-md-4 col-12 order-1">
                <div class="profile-card">
                    <div class="profile-header">
                        <div class="profile-image">
                            @if(isset(session('manager')['company_logo']) && session('manager')['company_logo'])
                                <img src="{{ session('manager')['company_logo'] }}" alt="Profil">
                            @else
                                <div class="placeholder">
                                    <i class="fas fa-user"></i>
                                </div>
                            @endif
                        </div>
                        <div class="profile-info">
                            <h2>{{ session('manager')['manager_name'] }} {{ session('manager')['manager_surname'] }}</h2>
                            @if(isset(session('manager')['company']) && session('manager')['company'])
                                <div class="company">{{ session('manager')['company'] }}</div>
                            @endif
                            @if(isset(session('manager')['manager_email']) && session('manager')['manager_email'])
                                <div class="email">{{ session('manager')['manager_email'] }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="profile-stats">
                        <div class="stat">
                            <div class="stat-value" id="artist-count">0</div>
                            <div class="stat-label">Sanatçı</div>
                        </div>
                        @if(!isset($reviewMode) || $reviewMode == false)
                        <div class="stat">
                            <div class="stat-value" id="monthly-revenue">₺0</div>
                            <div class="stat-label">Aylık Abonelik</div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Sanatçılar listesi -->
            <div class="col-md-8 col-12 order-2 mb-4">
                <!-- Sanatçılarım -->
                <div class="dashboard-card h-100 purple">
                    <div class="card-header">
                        <h5>Sanatçılarım</h5>
                        <a href="{{ route('artists.create.step1') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus me-1"></i> Yeni Sanatçı Ekle
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="artist-list" id="artists-list">
                            <!-- Sanatçı listesi sunucu tarafından doldurulacak -->
                            <div class="text-center py-4">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="visually-hidden">Yükleniyor...</span>
                                </div>
                                <p class="mt-2 text-muted">Sanatçılar yükleniyor...</p>
                            </div>
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
        document.addEventListener('DOMContentLoaded', function() {
            // Sanatçı verilerini getir
            fetch('/api/artists', {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                console.log('API\'den gelen tüm veri:', data);
                
                if (data.error) {
                    console.error("Sanatçılar yüklenirken hata oluştu:", data.error);
                    document.getElementById('artists-list').innerHTML = `
                        <div class="text-center py-4">
                            <i class="fas fa-exclamation-circle text-danger" style="font-size: 40px;"></i>
                            <p class="mt-2">Sanatçılar yüklenirken bir hata oluştu.</p>
                        </div>
                    `;
                    return;
                }
                
                // İstatistikleri güncelle
                document.getElementById('artist-count').textContent = data.length;
                
                // Aylık toplam abonelik tutarını hesapla
                let totalMonthlyRevenue = 0;
                @if(!isset($reviewMode) || $reviewMode == false)
                data.forEach(artist => {
                    if (artist.plan && artist.plan.monthly_price) {
                        totalMonthlyRevenue += parseFloat(artist.plan.monthly_price);
                    }
                });
                
                // Aylık toplam abonelik tutarını formatla ve göster
                document.getElementById('monthly-revenue').textContent = 
                    '₺' + totalMonthlyRevenue.toLocaleString('tr-TR', {
                        minimumFractionDigits: 0,
                        maximumFractionDigits: 0
                    });
                @endif
                
                // Sanatçıları listele
                const artistContainer = document.getElementById('artists-list');
                
                if (data.length === 0) {
                    artistContainer.innerHTML = `
                        <div class="text-center py-4">
                            <img src="https://cdn-icons-png.flaticon.com/512/3588/3588614.png" alt="Sanatçılar" style="width: 120px; opacity: 0.5;" class="mb-3">
                            <p class="mb-0">Henüz hiç sanatçı eklenmemiş.</p>
                            <p class="mt-1">
                                <a href="{{ route('artists.create.step1') }}" class="btn btn-sm btn-primary mt-2">
                                    <i class="fas fa-plus-circle me-1"></i> İlk Sanatçını Ekle
                                </a>
                            </p>
                        </div>
                    `;
                } else {
                    artistContainer.innerHTML = '';
                    
                    // Tüm sanatçıları göster (limit kaldırıldı)
                    for (let i = 0; i < data.length; i++) {
                        const artist = data[i];
                        const artistItem = document.createElement('div');
                        artistItem.className = 'artist-item';
                        
                        // Plan bilgilerini al
                        let planName = 'Temel';
                        let planBadgeClass = 'basic';
                        
                        if (artist.plan && artist.plan.plan_name) {
                            planName = artist.plan.plan_name;
                            
                            // Plan rozetinin sınıfını belirle
                            if (planName.includes('Seçkin')) {
                                planBadgeClass = 'premium';
                            } else if (planName.includes('Sınırsız')) {
                                planBadgeClass = 'pro';
                            }
                        }
                        
                        artistItem.innerHTML = `
                            <div class="artist-image">
                                ${artist.artist_image 
                                    ? `<img src="${artist.artist_image}" alt="${artist.artist_name}">`
                                    : `<div class="placeholder"><i class="fas fa-user"></i></div>`
                                }
                            </div>
                            <div class="artist-info">
                                <div class="artist-name">${artist.artist_name}</div>
                                <div class="artist-genre">
                                    ${artist.genre}
                                    <span class="plan-badge ${planBadgeClass}">${planName}</span>
                                </div>
                            </div>
                            <div class="ms-auto">
                                <a href="/artists/${artist.artist_slug}" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </div>
                        `;
                        
                        artistContainer.appendChild(artistItem);
                    }
                }
            })
            .catch(error => {
                console.error("API hatası:", error);
                document.getElementById('artists-list').innerHTML = `
                    <div class="text-center py-4">
                        <i class="fas fa-exclamation-circle text-danger" style="font-size: 40px;"></i>
                        <p class="mt-2">Bağlantı hatası. Sanatçılar yüklenemedi.</p>
                    </div>
                `;
            });
        });
    </script>
</body>
</html> 