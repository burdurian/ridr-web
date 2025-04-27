<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ManagerAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (!Session::has('manager')) {
            // Kullanıcının gitmek istediği URL'i session'a kaydet
            Session::put('url.intended', url()->current());
            return redirect()->route('login');
        }
        
        return $next($request);
    }
} 