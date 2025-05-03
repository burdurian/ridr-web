<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>RIDR - Faturalar</title>
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

        /* Sayfa Başlığı */
        .page-header {
            margin-bottom: 32px;
        }

        .page-title {
            font-size: 24px;
            font-weight: 600;
            color: #1a1a1a;
            margin-bottom: 8px;
        }

        .page-subtitle {
            font-size: 14px;
            color: #64748b;
        }

        /* Filtreler */
        .filters {
            background: #ffffff;
            border-radius: 12px;
            padding: 16px;
            margin-bottom: 24px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
            border: 1px solid rgba(0, 0, 0, 0.04);
        }

        .filter-group {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .filter-label {
            font-size: 14px;
            font-weight: 500;
            color: #64748b;
            white-space: nowrap;
        }

        .filter-select {
            border: 1px solid rgba(0, 0, 0, 0.08);
            border-radius: 8px;
            padding: 8px 12px;
            font-size: 14px;
            color: #1a1a1a;
            background-color: #f8f9fa;
            min-width: 160px;
            transition: all 0.2s ease;
        }

        .filter-select:focus {
            outline: none;
            border-color: #6c63ff;
            background-color: #ffffff;
        }

        /* Fatura Tablosu */
        .invoice-table {
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
            border: 1px solid rgba(0, 0, 0, 0.04);
            overflow: hidden;
        }

        .table {
            margin: 0;
        }

        .table thead th {
            background-color: #f8f9fa;
            border-bottom: 1px solid rgba(0, 0, 0, 0.04);
            font-weight: 600;
            font-size: 14px;
            color: #64748b;
            padding: 16px;
            white-space: nowrap;
        }

        .table tbody td {
            padding: 16px;
            vertical-align: middle;
            border-bottom: 1px solid rgba(0, 0, 0, 0.04);
            font-size: 14px;
            color: #1a1a1a;
        }

        .table tbody tr:last-child td {
            border-bottom: none;
        }

        .table tbody tr:hover {
            background-color: #f8f9fa;
        }

        .invoice-number {
            font-weight: 600;
            color: #1a1a1a;
        }

        .invoice-date {
            color: #64748b;
        }

        .invoice-amount {
            font-weight: 600;
            color: #1a1a1a;
        }

        .invoice-status {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .status-paid {
            background-color: #ecfdf5;
            color: #059669;
        }

        .status-paid i {
            color: #059669;
        }

        .status-pending {
            background-color: #fef3c7;
            color: #d97706;
        }

        .status-pending i {
            color: #d97706;
        }

        .status-overdue {
            background-color: #fee2e2;
            color: #dc2626;
        }

        .status-overdue i {
            color: #dc2626;
        }

        .btn-view {
            background-color: #f3f4f6;
            color: #4b5563;
            border: none;
            padding: 8px 16px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-view:hover {
            background-color: #e5e7eb;
            color: #1f2937;
        }

        .btn-view i {
            font-size: 14px;
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

            .filter-group {
                flex-direction: column;
                align-items: stretch;
                gap: 12px;
            }

            .table-responsive {
                border-radius: 16px;
            }

            .table thead {
                display: none;
            }

            .table tbody tr {
                display: block;
                padding: 20px;
                border-bottom: 1px solid rgba(0, 0, 0, 0.04);
                background: #ffffff;
                margin-bottom: 8px;
                border-radius: 12px;
                box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
            }

            .table tbody tr:last-child {
                border-bottom: none;
                margin-bottom: 0;
            }

            .table tbody td {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 12px 0;
                border: none;
            }

            .table tbody td::before {
                content: attr(data-label);
                font-weight: 500;
                color: #64748b;
                margin-right: 16px;
            }

            .table tbody td:last-child {
                justify-content: flex-end;
            }

            .table tbody td:last-child::before {
                display: none;
            }

            .btn-view {
                width: 100%;
                justify-content: center;
                margin-top: 8px;
            }

            .invoice-status {
                margin-left: auto;
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
                        <a class="nav-link active" href="{{ route('invoices.index') }}">
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
        </div>
    </nav>

    <!-- Ana İçerik -->
    <div class="container my-4">
        <div class="row">
            <div class="col-12">
                <!-- Sayfa Başlığı -->
                <div class="page-header">
                    <h1 class="page-title">Faturalar</h1>
                    <p class="page-subtitle">Tüm faturalarınızı buradan görüntüleyebilirsiniz</p>
                </div>

                <!-- Filtreler -->
                <div class="filters">
                    <div class="filter-group">
                        <span class="filter-label">Durum:</span>
                        <select class="filter-select">
                            <option value="all">Tümü</option>
                            <option value="paid">Ödendi</option>
                            <option value="pending">Beklemede</option>
                            <option value="overdue">Gecikmiş</option>
                        </select>
                        <span class="filter-label">Tarih:</span>
                        <select class="filter-select">
                            <option value="all">Tümü</option>
                            <option value="this-month">Bu Ay</option>
                            <option value="last-month">Geçen Ay</option>
                            <option value="this-year">Bu Yıl</option>
                        </select>
                    </div>
                </div>
                
                <!-- Fatura Listesi -->
                <div class="invoice-table">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Fatura No</th>
                                    <th>Tarih</th>
                                    <th>Tutar</th>
                                    <th>Durum</th>
                                    <th>İşlemler</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td data-label="Fatura No" class="invoice-number">FTR-2024-001</td>
                                    <td data-label="Tarih" class="invoice-date">15 Mart 2024</td>
                                    <td data-label="Tutar" class="invoice-amount">₺1,250</td>
                                    <td data-label="Durum">
                                        <span class="invoice-status status-paid">
                                            <i class="fas fa-check-circle"></i>
                                            Ödendi
                                        </span>
                                    </td>
                                    <td data-label="İşlemler">
                                        <button class="btn btn-view">
                                            <i class="fas fa-eye"></i>
                                            İncele
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td data-label="Fatura No" class="invoice-number">FTR-2024-002</td>
                                    <td data-label="Tarih" class="invoice-date">1 Nisan 2024</td>
                                    <td data-label="Tutar" class="invoice-amount">₺1,750</td>
                                    <td data-label="Durum">
                                        <span class="invoice-status status-pending">
                                            <i class="fas fa-clock"></i>
                                            Beklemede
                                        </span>
                                    </td>
                                    <td data-label="İşlemler">
                                        <button class="btn btn-view">
                                            <i class="fas fa-eye"></i>
                                            İncele
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td data-label="Fatura No" class="invoice-number">FTR-2024-003</td>
                                    <td data-label="Tarih" class="invoice-date">15 Nisan 2024</td>
                                    <td data-label="Tutar" class="invoice-amount">₺2,000</td>
                                    <td data-label="Durum">
                                        <span class="invoice-status status-overdue">
                                            <i class="fas fa-exclamation-circle"></i>
                                            Gecikmiş
                                        </span>
                                    </td>
                                    <td data-label="İşlemler">
                                        <button class="btn btn-view">
                                            <i class="fas fa-eye"></i>
                                            İncele
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Filtre seçicilerini al
            const statusFilter = document.querySelector('select[class="filter-select"]:nth-child(2)');
            const dateFilter = document.querySelector('select[class="filter-select"]:nth-child(4)');
            
            // Tüm fatura satırlarını al
            const invoiceRows = document.querySelectorAll('.table tbody tr');
            
            // Filtreleme fonksiyonu
            function filterInvoices() {
                const statusValue = statusFilter.value;
                const dateValue = dateFilter.value;
                
                invoiceRows.forEach(row => {
                    let showRow = true;
                    
                    // Durum filtresi
                    if (statusValue !== 'all') {
                        const status = row.querySelector('.invoice-status').textContent.trim();
                        if (statusValue === 'paid' && status !== 'Ödendi') showRow = false;
                        if (statusValue === 'pending' && status !== 'Beklemede') showRow = false;
                        if (statusValue === 'overdue' && status !== 'Gecikmiş') showRow = false;
                    }
                    
                    // Tarih filtresi
                    if (dateValue !== 'all') {
                        const dateText = row.querySelector('.invoice-date').textContent.trim();
                        const date = new Date(dateText);
                        const now = new Date();
                        
                        if (dateValue === 'this-month' && 
                            (date.getMonth() !== now.getMonth() || date.getFullYear() !== now.getFullYear())) {
                            showRow = false;
                        }
                        
                        if (dateValue === 'last-month') {
                            const lastMonth = new Date(now.getFullYear(), now.getMonth() - 1, 1);
                            if (date.getMonth() !== lastMonth.getMonth() || date.getFullYear() !== lastMonth.getFullYear()) {
                                showRow = false;
                            }
                        }
                        
                        if (dateValue === 'this-year' && date.getFullYear() !== now.getFullYear()) {
                            showRow = false;
                        }
                    }
                    
                    // Satırı göster/gizle
                    row.style.display = showRow ? '' : 'none';
                });
            }
            
            // Filtre değişikliklerini dinle
            statusFilter.addEventListener('change', filterInvoices);
            dateFilter.addEventListener('change', filterInvoices);
            
            // Sayfa yüklendiğinde filtreleme yap
            filterInvoices();
        });
    </script>
</body>
</html> 