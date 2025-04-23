# RIDR Web Uygulaması

RIDR Web, mobil etkinlik yönetimi uygulaması için web yönetim panelidir. Menajerler bu panel üzerinden sanatçılarını yönetebilir ve abonelik planlarını satın alabilirler.

## Proje Yapısı

### Veritabanı Entegrasyonu
- Supabase veritabanı ile doğrudan entegrasyon
- `SupabaseService` sınıfı ile REST API üzerinden veri erişimi

### Kimlik Doğrulama
- Yerel kimlik doğrulama (Supabase Auth kullanmadan)
- Menajer giriş sistemi (telefon numarası + şifre)
- SHA-256 ile şifre doğrulama
- Oturum Yönetimi

### Modeller
- `Manager`: Menajer bilgileri
- `Artist`: Sanatçı bilgileri
- `SubscriptionPlan`: Abonelik planları

### Servisler
- `SupabaseService`: Supabase ile iletişim
- `IyzicoService`: İyzico ile ödeme işlemleri
- `SubscriptionService`: Abonelik işlemleri
- `AuthService`: Kimlik doğrulama işlemleri

### Controller'lar
- `AuthController`: Giriş, çıkış ve kimlik doğrulama
- `ArtistController`: Sanatçı yönetimi
- `SubscriptionController`: Abonelik yönetimi

### Ana Ekranlar
- Login Sayfası
- Dashboard
- Sanatçı Listeleme
- Sanatçı Ekleme/Düzenleme
- Abonelik Planları

## Özellikler

### Menajer Yönetimi
- Telefon numarası ve parola ile giriş
- Telefon numarası normalizasyon desteği (+90, 0, 5xx formatları)
- Şirket ve profil bilgileri görüntüleme

### Sanatçı Yönetimi
- Sanatçı listeleme, ekleme, düzenleme ve silme
- Sanatçı detay görüntüleme
- Sanatçılara özel abonelik planı atama
- Plan başına maksimum sanatçı sayısı kontrolü

### Abonelik ve Ödeme İşlemleri
- Abonelik planı seçimi ve görüntüleme
- İyzico ile ödeme işlemleri
- Aylık abonelik yönetimi
- Plan özellikleri görüntüleme

## Teknolojiler

- PHP Laravel 10+
- Supabase Veritabanı
- İyzico Ödeme Entegrasyonu
- Bootstrap 5 UI
- FontAwesome İkonları

## Kurulum

1. `.env` dosyasında Supabase ve İyzico bilgilerini ayarlayın
```
SUPABASE_URL=https://xxxx.supabase.co
SUPABASE_KEY=your-key
SUPABASE_SECRET=your-secret
SUPABASE_JWT_SECRET=your-jwt-secret

IYZICO_API_KEY=your-api-key
IYZICO_SECRET_KEY=your-secret-key
IYZICO_BASE_URL=https://sandbox-api.iyzipay.com
IYZICO_SANDBOX=true
```

2. Bağımlılıkları yükleyin
```
composer install
```

3. Uygulama anahtarını oluşturun
```
php artisan key:generate
```

4. Gerekli tabloları oluşturun
```
php artisan migrate
```

5. Uygulamayı başlatın
```
php artisan serve
```

## Veritabanı Yapısı

Projede Supabase veritabanı kullanılmaktadır ve aşağıdaki tablolarla çalışılmaktadır:

### managers
- manager_id (uuid)
- manager_email (text)
- manager_phone (text) (+90 ile başlayan)
- manager_name (varchar)
- manager_surname (varchar)
- company_logo (varchar)
- company (varchar)
- manager_pass (text) (SHA-256 ile şifrelenmiş)

### artists
- artist_id (uuid)
- artist_name (varchar)
- related_manager (uuid) (managers tablosu ile ilişkili)
- artist_image (varchar)
- genre (varchar)
- artist_slug (varchar)
- subscription_plan (uuid) (subscription_plans tablosu ile ilişkili)

### subscription_plans
- plan_id (uuid)
- plan_name (text)
- max_members (numeric)
- monthly_price (numeric)
- price_currency (text)
- plan_desc (text)
- plan_features (jsonb) (özellik listesi)

## Giriş İşlemi

Kullanıcılar telefon numarası ve parola ile giriş yapabilirler. Telefon numarası çeşitli formatlarda girilebilir:
- +90 5XX XXX XX XX
- 90 5XX XXX XX XX
- 0 5XX XXX XX XX
- 5XX XXX XX XX

Parolalar SHA-256 algoritması ile şifrelenmektedir.
