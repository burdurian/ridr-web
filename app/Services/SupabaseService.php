<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SupabaseService
{
    protected $url;
    protected $key;
    protected $serviceKey;
    protected $client;

    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        $this->url = env('SUPABASE_URL');
        $this->key = env('SUPABASE_KEY');
        $this->serviceKey = env('SUPABASE_SERVICE_KEY');
        
        $this->client = new Client([
            'base_uri' => $this->url,
            'headers' => [
                'apikey' => $this->key,
                'Authorization' => 'Bearer ' . $this->key,
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ]
        ]);
    }

    /**
     * Tablo verilerini al
     */
    public function getTable($table, $params = [])
    {
        try {
            $response = $this->client->get('/rest/v1/' . $table, [
                'query' => $params
            ]);
            
            return json_decode($response->getBody()->getContents(), true);
        } catch (\Exception $e) {
            Log::error('Supabase getTable error: ' . $e->getMessage());
            return ['error' => $e->getMessage()];
        }
    }

    /**
     * Tabloya veri ekle
     */
    public function insert($table, $data)
    {
        try {
            $response = $this->client->post('/rest/v1/' . $table, [
                'json' => $data
            ]);
            
            return json_decode($response->getBody()->getContents(), true);
        } catch (\Exception $e) {
            Log::error('Supabase insert error: ' . $e->getMessage());
            return ['error' => $e->getMessage()];
        }
    }

    /**
     * Tablo verisini güncelle
     */
    public function update($table, $data, $match)
    {
        try {
            $response = $this->client->patch('/rest/v1/' . $table, [
                'json' => $data,
                'query' => [
                    'match' => $match
                ]
            ]);
            
            return json_decode($response->getBody()->getContents(), true);
        } catch (\Exception $e) {
            Log::error('Supabase update error: ' . $e->getMessage());
            return ['error' => $e->getMessage()];
        }
    }

    /**
     * Tablo verisini sil
     */
    public function delete($table, $match)
    {
        try {
            $response = $this->client->delete('/rest/v1/' . $table, [
                'query' => [
                    'match' => $match
                ]
            ]);
            
            return json_decode($response->getBody()->getContents(), true);
        } catch (\Exception $e) {
            Log::error('Supabase delete error: ' . $e->getMessage());
            return ['error' => $e->getMessage()];
        }
    }

    /**
     * Özel SQL sorgularını çalıştır
     */
    public function query($query, $params = [])
    {
        try {
            $headers = [
                'apikey' => $this->serviceKey,
                'Authorization' => 'Bearer ' . $this->serviceKey,
                'Content-Type' => 'application/json',
            ];

            $response = Http::withHeaders($headers)
                ->post($this->url . '/rest/v1/rpc/pg_query', [
                    'query' => $query,
                    'params' => $params
                ]);
            
            return $response->json();
        } catch (\Exception $e) {
            Log::error('Supabase custom query error: ' . $e->getMessage());
            return ['error' => $e->getMessage()];
        }
    }
}
