<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Intervention\Image\Facades\Image;

class FileManagerService
{
    protected $apiUrl;
    
    public function __construct()
    {
        $this->apiUrl = 'https://cdn.ridr.live/ridrapp.api';
    }
    
    /**
     * Resim dosyasını yükle ve işle
     * 
     * @param UploadedFile $file
     * @param string $type Klasör tipi (örn: artist_images)
     * @param string|null $uuid Benzersiz ID (bazı klasörler için gerekli)
     * @param array $imageOptions Resim işleme seçenekleri
     * @return array|false
     */
    public function uploadImage(UploadedFile $file, string $type, ?string $uuid = null, array $imageOptions = [])
    {
        try {
            // Resim işleme seçenekleri
            $defaultOptions = [
                'width' => null,
                'height' => 720, // Varsayılan 720p yükseklik
                'quality' => 80, // %80 kalite
                'format' => 'jpg'
            ];
            
            $options = array_merge($defaultOptions, $imageOptions);
            
            // Geçici bir dosyada resmi işleyelim
            $image = Image::make($file->getRealPath());
            
            // Boyutlandırma
            if ($options['width'] && $options['height']) {
                $image->fit($options['width'], $options['height']);
            } elseif ($options['width']) {
                $image->widen($options['width'], function ($constraint) {
                    $constraint->upsize();
                });
            } elseif ($options['height']) {
                $image->heighten($options['height'], function ($constraint) {
                    $constraint->upsize();
                });
            }
            
            // Geçici dosyaya kaydet
            $tempPath = sys_get_temp_dir() . '/' . uniqid() . '.' . $options['format'];
            $image->save($tempPath, $options['quality']);
            
            // API'ye yükle
            $response = Http::attach(
                'file', 
                file_get_contents($tempPath), 
                pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME) . '.' . $options['format']
            )->post($this->apiUrl, [
                'type' => $type,
                'uuid' => $uuid
            ]);
            
            // Geçici dosyayı sil
            @unlink($tempPath);
            
            if ($response->successful()) {
                return $response->json();
            }
            
            Log::error('Dosya yükleme hatası: ' . $response->body());
            return false;
        } catch (\Exception $e) {
            Log::error('Dosya yükleme hatası: ' . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Herhangi bir dosyayı API'ye yükler
     * 
     * @param UploadedFile $file
     * @param string $type Klasör tipi (örn: artist_files)
     * @param string|null $uuid Benzersiz ID (bazı klasörler için gerekli)
     * @return array|false
     */
    public function uploadFile(UploadedFile $file, string $type, ?string $uuid = null)
    {
        try {
            $response = Http::attach(
                'file', 
                file_get_contents($file->getRealPath()), 
                $file->getClientOriginalName()
            )->post($this->apiUrl, [
                'type' => $type,
                'uuid' => $uuid
            ]);
            
            if ($response->successful()) {
                return $response->json();
            }
            
            Log::error('Dosya yükleme hatası: ' . $response->body());
            return false;
        } catch (\Exception $e) {
            Log::error('Dosya yükleme hatası: ' . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Belirli bir klasördeki dosyaları listeler
     * 
     * @param string $type Klasör tipi
     * @param string|null $uuid Benzersiz ID (bazı klasörler için gerekli)
     * @return array|false
     */
    public function listFiles(string $type, ?string $uuid = null)
    {
        try {
            $params = ['type' => $type];
            
            if ($uuid) {
                $params['uuid'] = $uuid;
            }
            
            $response = Http::get($this->apiUrl, $params);
            
            if ($response->successful()) {
                return $response->json();
            }
            
            Log::error('Dosya listeleme hatası: ' . $response->body());
            return false;
        } catch (\Exception $e) {
            Log::error('Dosya listeleme hatası: ' . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Dosyayı siler
     * 
     * @param string $type Klasör tipi
     * @param string $filename Dosya adı
     * @param string|null $uuid Benzersiz ID (bazı klasörler için gerekli)
     * @return bool
     */
    public function deleteFile(string $type, string $filename, ?string $uuid = null)
    {
        try {
            $params = [
                'type' => $type,
                'filename' => $filename
            ];
            
            if ($uuid) {
                $params['uuid'] = $uuid;
            }
            
            $response = Http::delete($this->apiUrl, $params);
            
            if ($response->successful()) {
                return true;
            }
            
            Log::error('Dosya silme hatası: ' . $response->body());
            return false;
        } catch (\Exception $e) {
            Log::error('Dosya silme hatası: ' . $e->getMessage());
            return false;
        }
    }
} 