<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ValidateSignature
{
    /**
     * API isteklerini doğrula
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // API için X-API-Key doğrulama
        $validApiKey = env('RIDR_API_KEY');
        
        if (empty($validApiKey)) {
            return response()->json([
                'error' => 'API anahtarı yapılandırılmamış.'
            ], 500);
        }
        
        $apiKey = $request->header('X-API-Key');
        
        if (empty($apiKey) || $apiKey !== $validApiKey) {
            return response()->json([
                'error' => 'Geçersiz API anahtarı.'
            ], 401);
        }
        
        return $next($request);
    }
}
