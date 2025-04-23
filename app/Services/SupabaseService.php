<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class SupabaseService
{
    protected $client;
    protected $url;
    protected $key;
    protected $headers;

    public function __construct()
    {
        $this->url = config('supabase.url');
        $this->key = config('supabase.key');
        
        $this->headers = [
            'apikey' => $this->key,
            'Authorization' => 'Bearer ' . $this->key,
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ];

        $this->client = new Client([
            'base_uri' => $this->url,
            'headers' => $this->headers,
        ]);
    }

    /**
     * Veritabanından veri çeker
     *
     * @param string $table Tablo adı
     * @param array $params Sorgu parametreleri
     * @return array
     */
    public function select(string $table, array $params = [])
    {
        try {
            $query = '';
            
            if (!empty($params)) {
                $query = '?' . http_build_query($params);
            }
            
            $response = $this->client->get('/rest/v1/' . $table . $query);
            
            return json_decode($response->getBody()->getContents(), true);
        } catch (\Exception $e) {
            Log::error('Supabase select error: ' . $e->getMessage());
            return ['error' => $e->getMessage()];
        }
    }

    /**
     * Veritabanına veri ekler
     *
     * @param string $table Tablo adı
     * @param array $data Eklenecek veriler
     * @return array
     */
    public function insert(string $table, array $data)
    {
        try {
            $response = $this->client->post('/rest/v1/' . $table, [
                'json' => $data,
                'headers' => array_merge($this->headers, [
                    'Prefer' => 'return=representation',
                ]),
            ]);
            
            return json_decode($response->getBody()->getContents(), true);
        } catch (\Exception $e) {
            Log::error('Supabase insert error: ' . $e->getMessage());
            return ['error' => $e->getMessage()];
        }
    }

    /**
     * Veritabanındaki veriyi günceller
     *
     * @param string $table Tablo adı
     * @param array $data Güncellenecek veriler
     * @param array $conditions Güncelleme koşulları
     * @return array
     */
    public function update(string $table, array $data, array $conditions)
    {
        try {
            $query = '?' . http_build_query($conditions);

            $response = $this->client->patch('/rest/v1/' . $table . $query, [
                'json' => $data,
                'headers' => array_merge($this->headers, [
                    'Prefer' => 'return=representation',
                ]),
            ]);
            
            return json_decode($response->getBody()->getContents(), true);
        } catch (\Exception $e) {
            Log::error('Supabase update error: ' . $e->getMessage());
            return ['error' => $e->getMessage()];
        }
    }

    /**
     * Veritabanından veri siler
     *
     * @param string $table Tablo adı
     * @param array $conditions Silme koşulları
     * @return array
     */
    public function delete(string $table, array $conditions)
    {
        try {
            $query = '?' . http_build_query($conditions);

            $response = $this->client->delete('/rest/v1/' . $table . $query, [
                'headers' => array_merge($this->headers, [
                    'Prefer' => 'return=representation',
                ]),
            ]);
            
            return json_decode($response->getBody()->getContents(), true);
        } catch (\Exception $e) {
            Log::error('Supabase delete error: ' . $e->getMessage());
            return ['error' => $e->getMessage()];
        }
    }

    /**
     * Özel bir SQL sorgusu çalıştırır
     *
     * @param string $query SQL sorgusu
     * @return array
     */
    public function rpc(string $function, array $params = [])
    {
        try {
            $response = $this->client->post('/rest/v1/rpc/' . $function, [
                'json' => $params,
            ]);
            
            return json_decode($response->getBody()->getContents(), true);
        } catch (\Exception $e) {
            Log::error('Supabase RPC error: ' . $e->getMessage());
            return ['error' => $e->getMessage()];
        }
    }
} 