<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Ridr - Konser Yönetimi</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

        <style>
            body {
                font-family: 'Instrument Sans', sans-serif;
                background-color: #f7f7f7;
                color: #333;
                margin: 0;
                padding: 0;
                display: flex;
                justify-content: center;
                align-items: center;
                min-height: 100vh;
            }
            .container {
                max-width: 800px;
                margin: 0 auto;
                padding: 2rem;
                background-color: white;
                border-radius: 8px;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            }
            h1 {
                color: #e63946;
                margin-bottom: 1rem;
            }
            .status-box {
                padding: 1rem;
                border-radius: 4px;
                margin-bottom: 1.5rem;
            }
            .success {
                background-color: #d4edda;
                color: #155724;
                border: 1px solid #c3e6cb;
            }
            .error {
                background-color: #f8d7da;
                color: #721c24;
                border: 1px solid #f5c6cb;
            }
            .info-row {
                display: flex;
                margin-bottom: 0.5rem;
            }
            .info-label {
                width: 100px;
                font-weight: 600;
            }
            .button {
                display: inline-block;
                background-color: #e63946;
                color: white;
                padding: 0.75rem 1.5rem;
                border-radius: 4px;
                text-decoration: none;
                font-weight: 500;
                margin-top: 1rem;
            }
            .button:hover {
                background-color: #d62f3d;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <h1>Ridr - Supabase Test</h1>
            
            @isset($status)
                <div class="status-box {{ str_contains($status, 'Hata') ? 'error' : 'success' }}">
                    <p>{{ $status }}</p>
                </div>
            @endisset
            
            @isset($url)
                <div class="info-row">
                    <div class="info-label">URL:</div>
                    <div>{{ $url }}</div>
                </div>
            @endisset
            
            @isset($key)
                <div class="info-row">
                    <div class="info-label">API Key:</div>
                    <div>{{ $key }}</div>
                </div>
            @endisset
            
            <p>Ridr, konser etkinlik yönetimi için tasarlanmış bir web uygulamasıdır. Sanatçılar, etkinlikler ve ekipler hakkında bilgileri yönetebilirsiniz.</p>
            
            <a href="{{ url('/') }}" class="button">Ana Sayfaya Dön</a>
        </div>
    </body>
</html>
