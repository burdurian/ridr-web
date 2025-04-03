<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ridr - Giriş</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/flowbite@1.5.3/dist/flowbite.js"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #e4e8ed 100%);
        }
        .login-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }
        .login-card {
            width: 100%;
            max-width: 480px;
            background: white;
            border-radius: 16px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
            overflow: hidden;
            position: relative;
        }
        .login-header {
            background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
            padding: 2.5rem 2rem 3.5rem;
            text-align: center;
            color: white;
            position: relative;
        }
        .login-header h1 {
            font-weight: 700;
            font-size: 1.75rem;
            margin: 0.5rem 0 0;
        }
        .login-header p {
            opacity: 0.85;
            font-weight: 400;
            margin-top: 0.5rem;
        }
        .login-logo {
            height: auto;
            width: 160px;
            margin-bottom: 1rem;
            display: block;
            margin-left: auto;
            margin-right: auto;
        }
        .login-tabs {
            margin-top: -1.5rem;
            position: relative;
            z-index: 10;
        }
        .tab-container {
            display: flex;
            background: white;
            border-radius: 12px;
            padding: 0.2rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            margin: 0 2rem;
        }
        .tab-button {
            flex: 1;
            text-align: center;
            padding: 0.85rem 1rem;
            border-radius: 10px;
            font-weight: 500;
            font-size: 0.95rem;
            color: #374151;
            transition: all 0.3s ease;
        }
        .tab-button.active {
            background: #4f46e5;
            color: white;
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3);
        }
        .login-form-container {
            padding: 2.5rem 2rem 2rem;
        }
        .input-group {
            margin-bottom: 1.25rem;
        }
        .input-label {
            display: block;
            margin-bottom: 0.5rem;
            font-size: 0.875rem;
            font-weight: 500;
            color: #374151;
        }
        .form-input {
            width: 100%;
            padding: 0.75rem 1rem;
            font-size: 0.95rem;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            background: #f9fafb;
            transition: all 0.3s;
        }
        .form-input:focus {
            background: white;
            border-color: #4f46e5;
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
            outline: none;
        }
        .form-options {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin: 1.5rem 0;
        }
        .remember-me {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.875rem;
            color: #4b5563;
        }
        .remember-checkbox {
            width: 1rem;
            height: 1rem;
            border-radius: 4px;
            border: 1px solid #d1d5db;
            appearance: none;
            position: relative;
            background: white;
            cursor: pointer;
        }
        .remember-checkbox:checked {
            background: #4f46e5;
            border-color: #4f46e5;
        }
        .remember-checkbox:checked:after {
            content: '';
            position: absolute;
            left: 5px;
            top: 2px;
            width: 5px;
            height: 10px;
            border: solid white;
            border-width: 0 2px 2px 0;
            transform: rotate(45deg);
        }
        .forgot-password {
            font-size: 0.875rem;
            font-weight: 500;
            color: #4f46e5;
            text-decoration: none;
            transition: color 0.3s;
        }
        .forgot-password:hover {
            color: #4338ca;
            text-decoration: underline;
        }
        .login-button {
            width: 100%;
            padding: 0.875rem;
            border: none;
            border-radius: 8px;
            background: #4f46e5;
            color: white;
            font-weight: 600;
            font-size: 0.95rem;
            cursor: pointer;
            transition: all 0.3s;
            position: relative;
            overflow: hidden;
        }
        .login-button:hover {
            background: #4338ca;
            transform: translateY(-1px);
        }
        .login-button:active {
            transform: translateY(0);
        }
        .login-button:after {
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            pointer-events: none;
            background-image: radial-gradient(circle, #fff 10%, transparent 10.01%);
            background-repeat: no-repeat;
            background-position: 50%;
            transform: scale(10, 10);
            opacity: 0;
            transition: transform .5s, opacity 1s;
        }
        .login-button:active:after {
            transform: scale(0, 0);
            opacity: .3;
            transition: 0s;
        }
        .login-footer {
            margin-top: 1.5rem;
            text-align: center;
            font-size: 0.875rem;
            color: #6b7280;
        }
        .signup-link {
            color: #4f46e5;
            font-weight: 500;
            text-decoration: none;
        }
        .signup-link:hover {
            text-decoration: underline;
        }
        .decorated-bg {
            position: absolute;
            width: 400px;
            height: 400px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(99, 102, 241, 0.1) 0%, rgba(99, 102, 241, 0) 70%);
            top: -200px;
            right: -200px;
            z-index: 0;
        }
        .error-message {
            color: #ef4444;
            font-size: 0.875rem;
            margin-top: 0.5rem;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <div class="decorated-bg"></div>
            <div class="login-header">
                <img src="{{ asset('images/ridr-w.svg') }}" alt="Ridr Logo" class="login-logo">
            </div>
            
            @if($errors->any())
                <div style="background-color: #fee2e2; color: #b91c1c; padding: 1rem; margin: 1rem 2rem 0; border-radius: 8px; font-size: 0.9rem;">
                    <ul style="margin: 0; padding-left: 1.5rem;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            
            <div class="login-tabs">
                <div class="tab-container">
                    <button class="tab-button active" id="team-tab" data-tab="team">Ekip Üyesi</button>
                    <button class="tab-button" id="manager-tab" data-tab="manager">Menajer</button>
                </div>
            </div>
            
            <div class="login-form-container">
                <!-- Ekip Üyesi Girişi -->
                <div class="form-tab" id="team-form">
                    <form action="{{ route('auth.login') }}" method="POST">
                        @csrf
                        <input type="hidden" name="userType" value="team">
                        <div class="input-group">
                            <label for="team-email" class="input-label">E-posta Adresi</label>
                            <input type="email" id="team-email" name="email" placeholder="ornek@ridr.com" class="form-input" required>
                        </div>
                        
                        <div class="input-group">
                            <label for="team-password" class="input-label">Şifre</label>
                            <input type="password" id="team-password" name="password" placeholder="••••••••••" class="form-input" required>
                        </div>
                        
                        <div class="form-options">
                            <label for="team-remember" class="remember-me">
                                <input type="checkbox" id="team-remember" name="remember" class="remember-checkbox">
                                <span>Beni Hatırla</span>
                            </label>
                            
                            <a href="#" class="forgot-password">Şifremi Unuttum</a>
                        </div>
                        
                        <button type="submit" class="login-button">Giriş Yap</button>
                    </form>
                </div>
                
                <!-- Menajer Girişi -->
                <div class="form-tab" id="manager-form" style="display: none;">
                    <form action="{{ route('auth.login') }}" method="POST">
                        @csrf
                        <input type="hidden" name="userType" value="manager">
                        <div class="input-group">
                            <label for="manager-email" class="input-label">E-posta Adresi</label>
                            <input type="email" id="manager-email" name="email" placeholder="menajer@ridr.com" class="form-input" required>
                        </div>
                        
                        <div class="input-group">
                            <label for="manager-password" class="input-label">Şifre</label>
                            <input type="password" id="manager-password" name="password" placeholder="••••••••••" class="form-input" required>
                        </div>
                        
                        <div class="form-options">
                            <label for="manager-remember" class="remember-me">
                                <input type="checkbox" id="manager-remember" name="remember" class="remember-checkbox">
                                <span>Beni Hatırla</span>
                            </label>
                            
                            <a href="#" class="forgot-password">Şifremi Unuttum</a>
                        </div>
                        
                        <button type="submit" class="login-button">Giriş Yap</button>
                    </form>
                </div>
                
                <div class="login-footer">
                    Henüz hesabınız yok mu? <a href="#" class="signup-link">Kayıt Olun</a>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tabButtons = document.querySelectorAll('.tab-button');
            const formTabs = document.querySelectorAll('.form-tab');
            
            // Formlar ve inputlar
            const teamForm = document.querySelector('#team-form form');
            const managerForm = document.querySelector('#manager-form form');
            const errorElements = {};
            
            // Tab değiştirme işlevselliği
            tabButtons.forEach(button => {
                button.addEventListener('click', function() {
                    // Aktif tab'ı güncelle
                    tabButtons.forEach(btn => {
                        btn.classList.remove('active');
                    });
                    this.classList.add('active');
                    
                    // İlgili formu göster
                    const tabId = this.getAttribute('data-tab');
                    formTabs.forEach(tab => {
                        tab.style.display = 'none';
                    });
                    document.getElementById(tabId + '-form').style.display = 'block';
                });
            });
            
            // Ekip üye formu için validasyon
            teamForm.addEventListener('submit', function(e) {
                const emailInput = document.getElementById('team-email');
                const passwordInput = document.getElementById('team-password');
                
                // Validasyon kontrolleri
                if (!validateEmail(emailInput) || !validatePassword(passwordInput)) {
                    e.preventDefault(); // Sadece validasyon başarısız olursa önle
                    return;
                }
                
                // Form valid, normal submit işleyişine devam et
                // Şifre hash'leme artık backend'de yapılacak
            });
            
            // Menajer formu için validasyon
            managerForm.addEventListener('submit', function(e) {
                const emailInput = document.getElementById('manager-email');
                const passwordInput = document.getElementById('manager-password');
                
                // Validasyon kontrolleri
                if (!validateEmail(emailInput) || !validatePassword(passwordInput)) {
                    e.preventDefault(); // Sadece validasyon başarısız olursa önle
                    return;
                }
                
                // Form valid, normal submit işleyişine devam et
                // Şifre hash'leme artık backend'de yapılacak
            });
            
            // Email validasyonu
            function validateEmail(input) {
                const emailValue = input.value;
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                
                if (!emailValue) {
                    showError(input, 'E-posta adresi gereklidir');
                    return false;
                }
                
                if (!emailRegex.test(emailValue)) {
                    showError(input, 'Geçerli bir e-posta adresi girin');
                    return false;
                }
                
                hideError(input);
                return true;
            }
            
            // Parola validasyonu
            function validatePassword(input) {
                const passwordValue = input.value;
                
                if (!passwordValue) {
                    showError(input, 'Parola gereklidir');
                    return false;
                }
                
                hideError(input);
                return true;
            }
            
            // Error yönetimi
            function showError(input, message) {
                const inputId = input.id;
                let errorElement = errorElements[inputId];
                
                if (!errorElement) {
                    errorElement = document.createElement('div');
                    errorElement.className = 'error-message';
                    input.parentNode.appendChild(errorElement);
                    errorElements[inputId] = errorElement;
                }
                
                input.classList.add('error');
                errorElement.textContent = message;
                errorElement.style.display = 'block';
            }
            
            function hideError(input) {
                const inputId = input.id;
                const errorElement = errorElements[inputId];
                
                if (errorElement) {
                    errorElement.style.display = 'none';
                }
                
                input.classList.remove('error');
            }
            
            // Form input stil eklemeleri
            document.head.insertAdjacentHTML('beforeend', `
                <style>
                    .form-input.error, input.error {
                        border-color: #ef4444 !important;
                        background-color: #fef2f2 !important;
                    }
                    .error-message {
                        color: #ef4444;
                        font-size: 0.8rem;
                        margin-top: 0.35rem;
                        display: block;
                    }
                </style>
            `);
        });
    </script>
</body>
</html> 