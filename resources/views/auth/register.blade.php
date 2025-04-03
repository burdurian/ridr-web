<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ridr - Kayıt Ol</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/flowbite@1.5.3/dist/flowbite.js"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #e4e8ed 100%);
        }
        .register-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }
        .register-card {
            width: 100%;
            max-width: 580px;
            background: white;
            border-radius: 16px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
            overflow: hidden;
            position: relative;
        }
        .register-header {
            background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
            padding: 2rem 2rem 3rem;
            text-align: center;
            color: white;
            position: relative;
        }
        .register-logo {
            height: auto;
            width: 160px;
            margin-bottom: 1rem;
            display: block;
            margin-left: auto;
            margin-right: auto;
        }
        .register-steps {
            margin-top: -1.5rem;
            position: relative;
            z-index: 10;
            padding: 0 1.5rem;
        }
        .steps-container {
            display: flex;
            justify-content: space-between;
            background: white;
            border-radius: 12px;
            padding: 0.75rem 1.5rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        .step {
            display: flex;
            align-items: center;
            font-size: 0.875rem;
            color: #6b7280;
            position: relative;
        }
        .step-number {
            width: 24px;
            height: 24px;
            border-radius: 50%;
            background: #e5e7eb;
            color: #6b7280;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 0.5rem;
            font-weight: 600;
            font-size: 0.75rem;
        }
        .step.active .step-number {
            background: #4f46e5;
            color: white;
        }
        .step.active {
            color: #4f46e5;
            font-weight: 500;
        }
        .step.completed .step-number {
            background: #10b981;
            color: white;
        }
        .step.completed .step-number:after {
            content: '✓';
        }
        .register-form-container {
            padding: 2rem 2rem 2.5rem;
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
        .user-type-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
            margin-top: 1rem;
        }
        .user-type-card {
            border: 2px solid #e5e7eb;
            border-radius: 8px;
            padding: 1.5rem;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s;
        }
        .user-type-card:hover {
            border-color: #4f46e5;
            background: #f9fafb;
        }
        .user-type-card.selected {
            border-color: #4f46e5;
            background: rgba(79, 70, 229, 0.05);
        }
        .user-type-icon {
            width: 48px;
            height: 48px;
            background: #4f46e5;
            border-radius: 50%;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
        }
        .user-type-title {
            font-weight: 600;
            font-size: 1.1rem;
            color: #111827;
            margin-bottom: 0.5rem;
        }
        .user-type-desc {
            font-size: 0.875rem;
            color: #6b7280;
        }
        .form-buttons {
            display: flex;
            justify-content: space-between;
            margin-top: 2rem;
        }
        .back-button {
            padding: 0.75rem 1.5rem;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            background: white;
            color: #4b5563;
            font-weight: 500;
            font-size: 0.95rem;
            cursor: pointer;
            transition: all 0.3s;
        }
        .back-button:hover {
            background: #f9fafb;
            border-color: #9ca3af;
        }
        .next-button {
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 8px;
            background: #4f46e5;
            color: white;
            font-weight: 600;
            font-size: 0.95rem;
            cursor: pointer;
            transition: all 0.3s;
        }
        .next-button:hover {
            background: #4338ca;
        }
        .next-button:disabled {
            background: #9ca3af;
            cursor: not-allowed;
        }
        .checkbox-container {
            margin-bottom: 1rem;
        }
        .checkbox-label {
            display: flex;
            align-items: flex-start;
            font-size: 0.875rem;
            color: #4b5563;
        }
        .checkbox-input {
            width: 1rem;
            height: 1rem;
            border-radius: 4px;
            border: 1px solid #d1d5db;
            appearance: none;
            position: relative;
            background: white;
            cursor: pointer;
            margin-top: 0.25rem;
            margin-right: 0.75rem;
            flex-shrink: 0;
        }
        .checkbox-input:checked {
            background: #4f46e5;
            border-color: #4f46e5;
        }
        .checkbox-input:checked:after {
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
        .form-column {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }
        .form-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: #111827;
            margin-bottom: 1.5rem;
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
        .login-link {
            margin-top: 1.5rem;
            text-align: center;
            font-size: 0.875rem;
            color: #6b7280;
        }
        .login-link a {
            color: #4f46e5;
            font-weight: 500;
            text-decoration: none;
        }
        .login-link a:hover {
            text-decoration: underline;
        }
        .error-message {
            color: #ef4444;
            font-size: 0.8rem;
            margin-top: 0.5rem;
        }
        .privacy-text {
            max-height: 120px;
            overflow-y: auto;
            padding: 0.75rem;
            background: #f9fafb;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            font-size: 0.8rem;
            color: #4b5563;
            margin-bottom: 0.75rem;
        }
    </style>
</head>
<body>
    <div class="register-container">
        <div class="register-card">
            <div class="decorated-bg"></div>
            <div class="register-header">
                <img src="{{ asset('images/ridr-w.svg') }}" alt="Ridr Logo" class="register-logo">
            </div>
            
            <div class="register-steps">
                <div class="steps-container">
                    <div class="step active" id="step-1">
                        <div class="step-number">1</div>
                        <span>Hesap Tipi</span>
                    </div>
                    <div class="step" id="step-2">
                        <div class="step-number">2</div>
                        <span>Giriş Bilgileri</span>
                    </div>
                    <div class="step" id="step-3">
                        <div class="step-number">3</div>
                        <span>Kişisel Bilgiler</span>
                    </div>
                    <div class="step" id="step-4">
                        <div class="step-number">4</div>
                        <span>Onay</span>
                    </div>
                </div>
            </div>
            
            <div class="register-form-container">
                <form id="register-form">
                    <!-- Adım 1: Hesap Tipi Seçimi -->
                    <div class="form-step" id="form-step-1">
                        <h2 class="form-title">Hesap Tipinizi Seçin</h2>
                        <div class="user-type-container">
                            <div class="user-type-card" data-user-type="manager">
                                <div class="user-type-icon">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M20 7H4C2.9 7 2 7.9 2 9V20C2 21.1 2.9 22 4 22H20C21.1 22 22 21.1 22 20V9C22 7.9 21.1 7 20 7Z" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M16 21V5C16 4.46957 15.7893 3.96086 15.4142 3.58579C15.0391 3.21071 14.5304 3 14 3H10C9.46957 3 8.96086 3.21071 8.58579 3.58579C8.21071 3.96086 8 4.46957 8 5V21" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </div>
                                <h3 class="user-type-title">Menajer</h3>
                                <p class="user-type-desc">Sanatçıları yönetmek ve etkinlikleri organize etmek için</p>
                            </div>
                            <div class="user-type-card" data-user-type="team">
                                <div class="user-type-icon">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M17 21V19C17 17.9391 16.5786 16.9217 15.8284 16.1716C15.0783 15.4214 14.0609 15 13 15H5C3.93913 15 2.92172 15.4214 2.17157 16.1716C1.42143 16.9217 1 17.9391 1 19V21" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M9 11C11.2091 11 13 9.20914 13 7C13 4.79086 11.2091 3 9 3C6.79086 3 5 4.79086 5 7C5 9.20914 6.79086 11 9 11Z" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M23 21V19C22.9993 18.1137 22.7044 17.2528 22.1614 16.5523C21.6184 15.8519 20.8581 15.3516 20 15.13" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M16 3.13C16.8604 3.35031 17.623 3.85071 18.1676 4.55232C18.7122 5.25392 19.0078 6.11683 19.0078 7.005C19.0078 7.89318 18.7122 8.75608 18.1676 9.45769C17.623 10.1593 16.8604 10.6597 16 10.88" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </div>
                                <h3 class="user-type-title">Ekip Üyesi</h3>
                                <p class="user-type-desc">Sanatçı ekibinde yer almak için</p>
                            </div>
                        </div>
                        
                        <div class="form-buttons">
                            <div></div> <!-- Boş div, back butonu için yer tutucu -->
                            <button type="button" class="next-button" id="step-1-next" disabled>Devam Et</button>
                        </div>
                    </div>
                    
                    <!-- Adım 2: İletişim ve Giriş Bilgileri -->
                    <div class="form-step" id="form-step-2" style="display: none;">
                        <h2 class="form-title">Giriş Bilgilerinizi Girin</h2>
                        <div class="input-group">
                            <label for="phone" class="input-label">Telefon Numarası</label>
                            <input type="tel" id="phone" name="phone" class="form-input" placeholder="05XX XXX XX XX" required>
                        </div>
                        
                        <div class="input-group">
                            <label for="email" class="input-label">E-posta Adresi</label>
                            <input type="email" id="email" name="email" class="form-input" placeholder="ornek@mail.com" required>
                        </div>
                        
                        <div class="input-group">
                            <label for="password" class="input-label">Parola</label>
                            <input type="password" id="password" name="password" class="form-input" placeholder="••••••••••" required>
                        </div>
                        
                        <div class="input-group">
                            <label for="password_confirmation" class="input-label">Parola Tekrarı</label>
                            <input type="password" id="password_confirmation" name="password_confirmation" class="form-input" placeholder="••••••••••" required>
                        </div>
                        
                        <div class="form-buttons">
                            <button type="button" class="back-button" id="step-2-back">Geri Dön</button>
                            <button type="button" class="next-button" id="step-2-next">Devam Et</button>
                        </div>
                    </div>
                    
                    <!-- Adım 3: Menajer - Şirket/Kişisel Bilgiler -->
                    <div class="form-step" id="form-step-3-manager" style="display: none;">
                        <h2 class="form-title">Şirket/Menajerlik Bilgilerinizi Girin</h2>
                        <div class="input-group">
                            <label for="company_name" class="input-label">Şirket/Menajerlik Adı</label>
                            <input type="text" id="company_name" name="company_name" class="form-input" required>
                        </div>
                        
                        <div class="form-column">
                            <div class="input-group">
                                <label for="first_name" class="input-label">Yetkili Adı</label>
                                <input type="text" id="first_name" name="first_name" class="form-input" required>
                            </div>
                            
                            <div class="input-group">
                                <label for="last_name" class="input-label">Yetkili Soyadı</label>
                                <input type="text" id="last_name" name="last_name" class="form-input" required>
                            </div>
                        </div>
                        
                        <div class="form-buttons">
                            <button type="button" class="back-button" id="step-3-manager-back">Geri Dön</button>
                            <button type="button" class="next-button" id="step-3-manager-next">Devam Et</button>
                        </div>
                    </div>
                    
                    <!-- Adım 3: Ekip Üyesi - Kişisel Bilgiler -->
                    <div class="form-step" id="form-step-3-team" style="display: none;">
                        <h2 class="form-title">Kişisel Bilgilerinizi Girin</h2>
                        <div class="form-column">
                            <div class="input-group">
                                <label for="team_first_name" class="input-label">Adınız</label>
                                <input type="text" id="team_first_name" name="team_first_name" class="form-input" required>
                            </div>
                            
                            <div class="input-group">
                                <label for="team_last_name" class="input-label">Soyadınız</label>
                                <input type="text" id="team_last_name" name="team_last_name" class="form-input" required>
                            </div>
                        </div>
                        
                        <div class="input-group">
                            <label for="username" class="input-label">Kullanıcı Adı</label>
                            <input type="text" id="username" name="username" class="form-input" required>
                        </div>
                        
                        <div class="form-buttons">
                            <button type="button" class="back-button" id="step-3-team-back">Geri Dön</button>
                            <button type="button" class="next-button" id="step-3-team-next">Devam Et</button>
                        </div>
                    </div>
                    
                    <!-- Adım 4: Menajer - Onay -->
                    <div class="form-step" id="form-step-4-manager" style="display: none;">
                        <h2 class="form-title">Kayıt İşlemini Tamamlayın</h2>
                        
                        <div class="checkbox-container">
                            <div class="privacy-text">
                                Kişisel Verilerin Korunması Kanunu kapsamında, kişisel verileriniz Ridr tarafından, hizmetlerimizi sunmak, geliştirmek ve yasal yükümlülüklerimizi yerine getirmek amacıyla işlenmektedir. Detaylı bilgi için Kişisel Verilerin Korunması Politikamızı inceleyebilirsiniz.
                            </div>
                            <label class="checkbox-label">
                                <input type="checkbox" class="checkbox-input" name="privacy_policy" required>
                                <span>Kişisel Verilerin Korunmasına Dair Aydınlatma Metnini okudum ve anladım.</span>
                            </label>
                        </div>
                        
                        <div class="checkbox-container">
                            <div class="privacy-text">
                                Ridr platformunda kişisel verilerinizin kullanılması, saklanması ve işlenmesi için açık rızanızı vermeniz gerekmektedir. Bu kapsamda, tarafınıza sunulan hizmetlerin iyileştirilmesi, kullanıcı deneyiminin geliştirilmesi ve yasal yükümlülüklerin yerine getirilmesi amacıyla kişisel verileriniz işlenecektir.
                            </div>
                            <label class="checkbox-label">
                                <input type="checkbox" class="checkbox-input" name="terms_conditions" required>
                                <span>Açık Rıza Beyanını kabul ediyorum ve kişisel verilerimin işlenmesine izin veriyorum.</span>
                            </label>
                        </div>
                        
                        <div class="form-buttons">
                            <button type="button" class="back-button" id="step-4-manager-back">Geri Dön</button>
                            <button type="submit" class="next-button" id="submit-button-manager">Kaydı Tamamla</button>
                        </div>
                    </div>
                    
                    <!-- Adım 4: Ekip Üyesi - Onay -->
                    <div class="form-step" id="form-step-4-team" style="display: none;">
                        <h2 class="form-title">Kayıt İşlemini Tamamlayın</h2>
                        
                        <div class="checkbox-container">
                            <div class="privacy-text">
                                Kişisel Verilerin Korunması Kanunu kapsamında, kişisel verileriniz Ridr tarafından, hizmetlerimizi sunmak, geliştirmek ve yasal yükümlülüklerimizi yerine getirmek amacıyla işlenmektedir. Detaylı bilgi için Kişisel Verilerin Korunması Politikamızı inceleyebilirsiniz.
                            </div>
                            <label class="checkbox-label">
                                <input type="checkbox" class="checkbox-input" name="team_privacy_policy" required>
                                <span>Kişisel Verilerin Korunmasına Dair Aydınlatma Metnini okudum ve anladım.</span>
                            </label>
                        </div>
                        
                        <div class="checkbox-container">
                            <div class="privacy-text">
                                Ridr platformunda kişisel verilerinizin kullanılması, saklanması ve işlenmesi için açık rızanızı vermeniz gerekmektedir. Bu kapsamda, tarafınıza sunulan hizmetlerin iyileştirilmesi, kullanıcı deneyiminin geliştirilmesi ve yasal yükümlülüklerin yerine getirilmesi amacıyla kişisel verileriniz işlenecektir.
                            </div>
                            <label class="checkbox-label">
                                <input type="checkbox" class="checkbox-input" name="team_terms_conditions" required>
                                <span>Açık Rıza Beyanını kabul ediyorum ve kişisel verilerimin işlenmesine izin veriyorum.</span>
                            </label>
                        </div>
                        
                        <div class="form-buttons">
                            <button type="button" class="back-button" id="step-4-team-back">Geri Dön</button>
                            <button type="submit" class="next-button" id="submit-button-team">Kaydı Tamamla</button>
                        </div>
                    </div>
                </form>
                
                <div class="login-link">
                    Zaten hesabınız var mı? <a href="{{ route('login') }}">Giriş Yapın</a>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Değişkenler
            const userTypeCards = document.querySelectorAll('.user-type-card');
            const step1NextButton = document.getElementById('step-1-next');
            const step2NextButton = document.getElementById('step-2-next');
            const step2BackButton = document.getElementById('step-2-back');
            const step3ManagerNextButton = document.getElementById('step-3-manager-next');
            const step3ManagerBackButton = document.getElementById('step-3-manager-back');
            const step3TeamNextButton = document.getElementById('step-3-team-next');
            const step3TeamBackButton = document.getElementById('step-3-team-back');
            const step4ManagerBackButton = document.getElementById('step-4-manager-back');
            const step4TeamBackButton = document.getElementById('step-4-team-back');
            const registerForm = document.getElementById('register-form');
            
            // Form alanları
            const phoneInput = document.getElementById('phone');
            const emailInput = document.getElementById('email');
            const passwordInput = document.getElementById('password');
            const passwordConfirmInput = document.getElementById('password_confirmation');
            const companyNameInput = document.getElementById('company_name');
            const firstNameInput = document.getElementById('first_name');
            const lastNameInput = document.getElementById('last_name');
            const teamFirstNameInput = document.getElementById('team_first_name');
            const teamLastNameInput = document.getElementById('team_last_name');
            const usernameInput = document.getElementById('username');
            
            // Hata mesajları için elementler
            const errorElements = {};
            
            // Form adımları
            const formStep1 = document.getElementById('form-step-1');
            const formStep2 = document.getElementById('form-step-2');
            const formStep3Manager = document.getElementById('form-step-3-manager');
            const formStep3Team = document.getElementById('form-step-3-team');
            const formStep4Manager = document.getElementById('form-step-4-manager');
            const formStep4Team = document.getElementById('form-step-4-team');
            
            // Adım göstergeleri
            const step1 = document.getElementById('step-1');
            const step2 = document.getElementById('step-2');
            const step3 = document.getElementById('step-3');
            const step4 = document.getElementById('step-4');
            
            let selectedUserType = null;
            
            // Hesap tipi seçimi
            userTypeCards.forEach(card => {
                card.addEventListener('click', function() {
                    userTypeCards.forEach(c => c.classList.remove('selected'));
                    this.classList.add('selected');
                    selectedUserType = this.getAttribute('data-user-type');
                    step1NextButton.disabled = false;
                });
            });
            
            // Telefon numarası formatı
            phoneInput.addEventListener('input', function(e) {
                let value = e.target.value;
                
                // Sadece rakamları al
                value = value.replace(/\D/g, "");
                
                if (value.length > 0) {
                    // Türkiye telefon numarası formatı: 05XX XXX XX XX
                    if (value.startsWith('0')) {
                        value = value.substring(1); // Başındaki 0'ı kaldır
                    }
                    
                    if (value.length > 10) {
                        value = value.substring(0, 10); // Maksimum 10 rakam
                    }
                    
                    // Format oluştur
                    if (value.length > 0) {
                        value = "0" + value;
                        
                        if (value.length > 4) {
                            value = value.substring(0, 4) + " " + value.substring(4);
                        }
                        
                        if (value.length > 8) {
                            value = value.substring(0, 8) + " " + value.substring(8);
                        }
                        
                        if (value.length > 11) {
                            value = value.substring(0, 11) + " " + value.substring(11);
                        }
                    }
                }
                
                e.target.value = value;
                validatePhoneNumber();
            });
            
            // Kullanıcı adı validasyonu
            usernameInput?.addEventListener('input', function() {
                validateUsername();
            });
            
            // Email validasyonu
            emailInput.addEventListener('input', function() {
                validateEmail();
            });
            
            // Parola validasyonu
            passwordInput.addEventListener('input', function() {
                validatePassword();
            });
            
            // Parola tekrar validasyonu
            passwordConfirmInput.addEventListener('input', function() {
                validatePasswordConfirm();
            });
            
            // Validasyon fonksiyonları
            function validatePhoneNumber() {
                const phoneValue = phoneInput.value.replace(/\s/g, "");
                
                if (!phoneValue) {
                    showError(phoneInput, 'Telefon numarası gereklidir');
                    return false;
                }
                
                if (phoneValue.length !== 11 || !phoneValue.startsWith('05')) {
                    showError(phoneInput, 'Geçerli bir telefon numarası girin (05XX XXX XX XX)');
                    return false;
                }
                
                hideError(phoneInput);
                return true;
            }
            
            function validateEmail() {
                const emailValue = emailInput.value;
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                
                if (!emailValue) {
                    showError(emailInput, 'E-posta adresi gereklidir');
                    return false;
                }
                
                if (!emailRegex.test(emailValue)) {
                    showError(emailInput, 'Geçerli bir e-posta adresi girin');
                    return false;
                }
                
                hideError(emailInput);
                return true;
            }
            
            function validatePassword() {
                const passwordValue = passwordInput.value;
                
                if (!passwordValue) {
                    showError(passwordInput, 'Parola gereklidir');
                    return false;
                }
                
                if (passwordValue.length < 6) {
                    showError(passwordInput, 'Parola en az 6 karakter olmalıdır');
                    return false;
                }
                
                hideError(passwordInput);
                validatePasswordConfirm();
                return true;
            }
            
            function validatePasswordConfirm() {
                const passwordValue = passwordInput.value;
                const passwordConfirmValue = passwordConfirmInput.value;
                
                if (!passwordConfirmValue) {
                    showError(passwordConfirmInput, 'Parola tekrarı gereklidir');
                    return false;
                }
                
                if (passwordValue !== passwordConfirmValue) {
                    showError(passwordConfirmInput, 'Parolalar eşleşmiyor');
                    return false;
                }
                
                hideError(passwordConfirmInput);
                return true;
            }
            
            function validateCompanyName() {
                if (!companyNameInput.value) {
                    showError(companyNameInput, 'Şirket/Menajerlik adı gereklidir');
                    return false;
                }
                
                hideError(companyNameInput);
                return true;
            }
            
            function validateFirstName() {
                if (!firstNameInput.value) {
                    showError(firstNameInput, 'Yetkili adı gereklidir');
                    return false;
                }
                
                hideError(firstNameInput);
                return true;
            }
            
            function validateLastName() {
                if (!lastNameInput.value) {
                    showError(lastNameInput, 'Yetkili soyadı gereklidir');
                    return false;
                }
                
                hideError(lastNameInput);
                return true;
            }
            
            function validateTeamFirstName() {
                if (!teamFirstNameInput.value) {
                    showError(teamFirstNameInput, 'Ad gereklidir');
                    return false;
                }
                
                hideError(teamFirstNameInput);
                return true;
            }
            
            function validateTeamLastName() {
                if (!teamLastNameInput.value) {
                    showError(teamLastNameInput, 'Soyad gereklidir');
                    return false;
                }
                
                hideError(teamLastNameInput);
                return true;
            }
            
            function validateUsername() {
                const usernameValue = usernameInput.value;
                
                if (!usernameValue) {
                    showError(usernameInput, 'Kullanıcı adı gereklidir');
                    return false;
                }
                
                if (usernameValue.length < 3) {
                    showError(usernameInput, 'Kullanıcı adı en az 3 karakter olmalıdır');
                    return false;
                }
                
                const usernameRegex = /^[a-zA-Z0-9_]+$/;
                if (!usernameRegex.test(usernameValue)) {
                    showError(usernameInput, 'Kullanıcı adı sadece harf, rakam ve alt çizgi (_) içerebilir');
                    return false;
                }
                
                hideError(usernameInput);
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
            
            // Adım 1'den Adım 2'ye geçiş
            step1NextButton.addEventListener('click', function() {
                formStep1.style.display = 'none';
                formStep2.style.display = 'block';
                
                step1.classList.remove('active');
                step1.classList.add('completed');
                step2.classList.add('active');
            });
            
            // Adım 2'den Adım 1'e geri dönüş
            step2BackButton.addEventListener('click', function() {
                formStep2.style.display = 'none';
                formStep1.style.display = 'block';
                
                step2.classList.remove('active');
                step1.classList.remove('completed');
                step1.classList.add('active');
            });
            
            // Adım 2'den Adım 3'e geçiş
            step2NextButton.addEventListener('click', function() {
                // Validasyon kontrolleri
                const isPhoneValid = validatePhoneNumber();
                const isEmailValid = validateEmail();
                const isPasswordValid = validatePassword();
                const isPasswordConfirmValid = validatePasswordConfirm();
                
                if (!isPhoneValid || !isEmailValid || !isPasswordValid || !isPasswordConfirmValid) {
                    return;
                }
                
                formStep2.style.display = 'none';
                
                if (selectedUserType === 'manager') {
                    formStep3Manager.style.display = 'block';
                } else {
                    formStep3Team.style.display = 'block';
                }
                
                step2.classList.remove('active');
                step2.classList.add('completed');
                step3.classList.add('active');
            });
            
            // Menajer Adım 3'ten Adım 2'ye geri dönüş
            step3ManagerBackButton.addEventListener('click', function() {
                formStep3Manager.style.display = 'none';
                formStep2.style.display = 'block';
                
                step3.classList.remove('active');
                step2.classList.remove('completed');
                step2.classList.add('active');
            });
            
            // Menajer Adım 3'ten Adım 4'e geçiş
            step3ManagerNextButton.addEventListener('click', function() {
                // Validasyon kontrolleri
                const isCompanyNameValid = validateCompanyName();
                const isFirstNameValid = validateFirstName();
                const isLastNameValid = validateLastName();
                
                if (!isCompanyNameValid || !isFirstNameValid || !isLastNameValid) {
                    return;
                }
                
                formStep3Manager.style.display = 'none';
                formStep4Manager.style.display = 'block';
                
                step3.classList.remove('active');
                step3.classList.add('completed');
                step4.classList.add('active');
            });
            
            // Ekip Üyesi Adım 3'ten Adım 2'ye geri dönüş
            step3TeamBackButton.addEventListener('click', function() {
                formStep3Team.style.display = 'none';
                formStep2.style.display = 'block';
                
                step3.classList.remove('active');
                step2.classList.remove('completed');
                step2.classList.add('active');
            });
            
            // Ekip Üyesi Adım 3'ten Adım 4'e geçiş
            step3TeamNextButton.addEventListener('click', function() {
                // Validasyon kontrolleri
                const isTeamFirstNameValid = validateTeamFirstName();
                const isTeamLastNameValid = validateTeamLastName();
                const isUsernameValid = validateUsername();
                
                if (!isTeamFirstNameValid || !isTeamLastNameValid || !isUsernameValid) {
                    return;
                }
                
                formStep3Team.style.display = 'none';
                formStep4Team.style.display = 'block';
                
                step3.classList.remove('active');
                step3.classList.add('completed');
                step4.classList.add('active');
            });
            
            // Menajer Adım 4'ten Adım 3'e geri dönüş
            step4ManagerBackButton.addEventListener('click', function() {
                formStep4Manager.style.display = 'none';
                formStep3Manager.style.display = 'block';
                
                step4.classList.remove('active');
                step3.classList.remove('completed');
                step3.classList.add('active');
            });
            
            // Ekip Üyesi Adım 4'ten Adım 3'e geri dönüş
            step4TeamBackButton.addEventListener('click', function() {
                formStep4Team.style.display = 'none';
                formStep3Team.style.display = 'block';
                
                step4.classList.remove('active');
                step3.classList.remove('completed');
                step3.classList.add('active');
            });
            
            // Form gönderimi
            registerForm.addEventListener('submit', async function(e) {
                e.preventDefault();
                
                // SHA-256 hash fonksiyonu
                async function sha256(message) {
                    const msgBuffer = new TextEncoder().encode(message);
                    const hashBuffer = await crypto.subtle.digest('SHA-256', msgBuffer);
                    const hashArray = Array.from(new Uint8Array(hashBuffer));
                    const hashHex = hashArray.map(b => b.toString(16).padStart(2, '0')).join('');
                    return hashHex;
                }
                
                try {
                    const phone = phoneInput.value.replace(/\s/g, "");
                    const formattedPhone = "+90" + phone.substring(1); // 05XXXXXXXXX -> +905XXXXXXXXX
                    const hashedPassword = await sha256(passwordInput.value);
                    
                    let formData = new FormData();
                    formData.append('userType', selectedUserType);
                    
                    if (selectedUserType === 'team') {
                        // Ekip üyesi için
                        formData.append('phone', formattedPhone);
                        formData.append('mail', emailInput.value);
                        formData.append('pass', hashedPassword);
                        formData.append('user_name', teamFirstNameInput.value);
                        formData.append('user_surname', teamLastNameInput.value);
                        formData.append('user_username', usernameInput.value);
                    } else {
                        // Menajer için
                        formData.append('manager_phone', formattedPhone);
                        formData.append('manager_email', emailInput.value);
                        formData.append('company', companyNameInput.value);
                        formData.append('manager_name', firstNameInput.value);
                        formData.append('manager_surname', lastNameInput.value);
                        formData.append('manager_pass', hashedPassword);
                    }
                    
                    // Form gönderimi
                    // Bu kısmı backend entegrasyonu hazır olduğunda açacağız
                    // const response = await fetch('/api/register', {
                    //     method: 'POST',
                    //     body: formData
                    // });
                    // 
                    // if (response.ok) {
                    //     // Başarılı kayıt
                    //     window.location.href = '/login';
                    // } else {
                    //     // Hata durumu
                    //     const data = await response.json();
                    //     alert(data.message || 'Kayıt işlemi sırasında bir hata oluştu.');
                    // }
                    
                    console.log('Form verileri:', Object.fromEntries(formData.entries()));
                    alert('Kayıt işlemi başarılı! (Test amaçlı mesaj, backend entegrasyonu yapılacak)');
                    
                } catch (error) {
                    console.error('Kayıt sırasında hata:', error);
                    alert('Kayıt işlemi sırasında bir hata oluştu.');
                }
            });
            
            // Form alanları için stil
            document.head.insertAdjacentHTML('beforeend', `
                <style>
                    .form-input.error {
                        border-color: #ef4444;
                        background-color: #fef2f2;
                    }
                    .error-message {
                        color: #ef4444;
                        font-size: 0.8rem;
                        margin-top: 0.35rem;
                    }
                </style>
            `);
        });
    </script>
</body>
</html> 