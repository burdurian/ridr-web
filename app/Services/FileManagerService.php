<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Intervention\Image\Facades\Image;
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
            $formData = [
                'type' => $type,
                'file' => $file
            ];

            if ($uuid) {
                $formData['uuid'] = $uuid;
            }

            $response = Http::withoutVerifying()
                ->timeout(30)
                ->withHeaders([
                    'X-API-Key' => $this->apiKey
                ])
                ->post($this->apiUrl, $formData);

            if ($response->successful()) {
                $result = $response->json();
                if (isset($result['url'])) {
                    return [
                        'success' => true,
                        'url' => $result['url']
                    ];
                }
            }

            // Hata durumunda
            Log::error('Dosya yükleme hatası', [
                'response' => $response->body(),
                'status' => $response->status()
            ]);

            return [
                'success' => false,
                'error' => 'Dosya yüklenirken bir hata oluştu: ' . ($response->json()['error'] ?? 'Bilinmeyen hata')
            ];

        } catch (Exception $e) {
            Log::error('Dosya yükleme istisnası', [
                'message' => $e->getMessage(),
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

            // Görüntüyü aç, boyutlandır ve sıkıştır
            $img = Image::make($imageFile->getRealPath());
            
            // Orijinal oranları koruyarak yüksekliği ayarla
            $img->heighten($height, function ($constraint) {
                $constraint->upsize(); // Küçük görüntüleri büyütme
            });

            // JPEG formatında kaydet
            $img->save($tempPath, $quality * 100);

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