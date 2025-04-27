<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Exception;

class FileManagerService
{
    protected $apiUrl;
    protected $apiKey;

    public function __construct()
    {
        $this->apiUrl = 'https://cdn.ridr.live/ridrapp.api';
        $this->apiKey = env('RIDR_API_KEY', '');
    }

    /**
     * Dosyayı cdn.ridr.live'a yükler
     *
     * @param UploadedFile $file Yüklenecek dosya
     * @param string $type Dosya türü (artist_images, user_profile_images, vb.)
     * @param string|null $uuid Klasör adı (isteğe bağlı)
     * @return array Sonuç (başarılı ise url, başarısız ise error)
     */
    public function uploadFile(UploadedFile $file, string $type, string $uuid = null): array
    {
        try {
            // Dosyanın geçerli olduğunu kontrol et
            if (!$file->isValid()) {
                Log::error('Dosya geçerli değil', [
                    'error' => $file->getError(),
                    'errorMessage' => $file->getErrorMessage()
                ]);
                return [
                    'success' => false,
                    'error' => 'Yüklenen dosya geçerli değil: ' . $file->getErrorMessage()
                ];
            }
            
            // Dosya türünü ve boyutunu logla
            Log::info('Dosya yükleme başlatılıyor', [
                'filename' => $file->getClientOriginalName(),
                'type' => $type,
                'mime' => $file->getMimeType(),
                'size' => $file->getSize(),
                'uuid' => $uuid
            ]);
            
            // Form verilerini hazırla
            $formData = [
                'type' => $type,
                'file' => $file
            ];

            if ($uuid) {
                $formData['uuid'] = $uuid;
            }

            // API isteği yap
            Log::info('API isteği gönderiliyor: ' . $this->apiUrl);
            $response = Http::withoutVerifying()
                ->timeout(30)
                ->withHeaders([
                    'X-API-Key' => $this->apiKey
                ])
                ->post($this->apiUrl, $formData);

            // Yanıtı kontrol et
            if ($response->successful()) {
                $result = $response->json();
                Log::info('API yanıtı alındı', ['response' => $result]);
                
                if (isset($result['url'])) {
                    Log::info('Dosya başarıyla yüklendi', ['url' => $result['url']]);
                    return [
                        'success' => true,
                        'url' => $result['url']
                    ];
                } else {
                    Log::error('API yanıtında URL yok', ['response' => $result]);
                    return [
                        'success' => false,
                        'error' => 'API yanıtında URL bilgisi bulunamadı.'
                    ];
                }
            }

            // Hata durumunda
            $statusCode = $response->status();
            $responseBody = $response->body();
            $responseJson = $response->json();
            
            Log::error('Dosya yükleme hatası', [
                'url' => $this->apiUrl,
                'status' => $statusCode,
                'body' => $responseBody,
                'json' => $responseJson
            ]);

            return [
                'success' => false,
                'error' => 'Dosya yüklenirken bir hata oluştu (HTTP ' . $statusCode . '): ' . 
                    ($responseJson['error'] ?? $responseBody ?? 'Bilinmeyen hata')
            ];

        } catch (Exception $e) {
            Log::error('Dosya yükleme istisnası', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);

            return [
                'success' => false,
                'error' => 'Dosya yüklenirken bir istisna oluştu: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Görüntüyü yeniden boyutlandırır ve sıkıştırır
     *
     * @param UploadedFile $imageFile Görüntü dosyası
     * @param int $height Hedef yükseklik
     * @param float $quality Kalite (0.0-1.0)
     * @return UploadedFile İşlenmiş görüntü dosyası
     */
    public function processImage(UploadedFile $imageFile, int $height = 720, float $quality = 0.8): UploadedFile
    {
        try {
            // Geçici dosya oluştur
            $tempPath = sys_get_temp_dir() . '/' . uniqid('img_') . '.jpg';
            
            // Görüntüyü GD kütüphanesi ile işle
            $sourceImage = $this->createImageFromFile($imageFile);
            
            if (!$sourceImage) {
                throw new Exception("Görüntü açılamadı.");
            }
            
            // Orijinal boyutları al
            $srcWidth = imagesx($sourceImage);
            $srcHeight = imagesy($sourceImage);
            
            // Yeni boyutları hesapla
            $ratio = $srcHeight / $height;
            $newWidth = $srcWidth / $ratio;
            $newHeight = $height;
            
            // Yeni görüntü oluştur
            $destImage = imagecreatetruecolor($newWidth, $newHeight);
            
            // Görüntüyü yeniden boyutlandır
            imagecopyresampled(
                $destImage, 
                $sourceImage, 
                0, 0, 0, 0, 
                $newWidth, $newHeight, 
                $srcWidth, $srcHeight
            );
            
            // JPEG olarak kaydet
            imagejpeg($destImage, $tempPath, $quality * 100);
            
            // Kaynakları temizle
            imagedestroy($sourceImage);
            imagedestroy($destImage);

            // Geçici dosyadan yeni bir UploadedFile oluştur
            return new UploadedFile(
                $tempPath,
                pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME) . '.jpg',
                'image/jpeg',
                null,
                true // Test modu = true, dosya geçici olarak oluşturuldu
            );

        } catch (Exception $e) {
            Log::error('Görüntü işleme hatası', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            // Hata durumunda orijinal dosyayı döndür
            return $imageFile;
        }
    }
    
    /**
     * Dosya türüne göre uygun görüntü oluşturma fonksiyonunu çağırır
     *
     * @param UploadedFile $file
     * @return resource|false GD görüntü kaynağı veya false
     */
    private function createImageFromFile(UploadedFile $file)
    {
        $mime = $file->getMimeType();
        $path = $file->getRealPath();
        
        switch ($mime) {
            case 'image/jpeg':
                return imagecreatefromjpeg($path);
            case 'image/png':
                return imagecreatefrompng($path);
            case 'image/gif':
                return imagecreatefromgif($path);
            case 'image/webp':
                return imagecreatefromwebp($path);
            default:
                return false;
        }
    }

    /**
     * Dosyaları listeler
     *
     * @param string $type Dosya türü
     * @param string|null $uuid Klasör adı (isteğe bağlı)
     * @return array Dosya listesi
     */
    public function listFiles(string $type, string $uuid = null): array
    {
        try {
            $params = ['type' => $type];
            
            if ($uuid) {
                $params['uuid'] = $uuid;
            }

            $response = Http::withoutVerifying()
                ->timeout(15)
                ->withHeaders([
                    'X-API-Key' => $this->apiKey
                ])
                ->get($this->apiUrl, $params);

            if ($response->successful()) {
                return $response->json();
            }

            return [
                'success' => false,
                'error' => 'Dosya listesi alınamadı: ' . ($response->json()['error'] ?? 'Bilinmeyen hata')
            ];

        } catch (Exception $e) {
            return [
                'success' => false,
                'error' => 'Dosya listesi alınırken hata oluştu: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Dosyayı siler
     *
     * @param string $type Dosya türü
     * @param string $filename Dosya adı
     * @param string|null $uuid Klasör adı (isteğe bağlı)
     * @return array Sonuç
     */
    public function deleteFile(string $type, string $filename, string $uuid = null): array
    {
        try {
            $params = [
                'type' => $type,
                'filename' => $filename
            ];
            
            if ($uuid) {
                $params['uuid'] = $uuid;
            }

            $response = Http::withoutVerifying()
                ->timeout(15)
                ->withHeaders([
                    'X-API-Key' => $this->apiKey
                ])
                ->delete($this->apiUrl, $params);

            if ($response->successful()) {
                return [
                    'success' => true,
                    'message' => 'Dosya başarıyla silindi'
                ];
            }

            return [
                'success' => false,
                'error' => 'Dosya silinemedi: ' . ($response->json()['error'] ?? 'Bilinmeyen hata')
            ];

        } catch (Exception $e) {
            return [
                'success' => false,
                'error' => 'Dosya silinirken hata oluştu: ' . $e->getMessage()
            ];
        }
    }
} 