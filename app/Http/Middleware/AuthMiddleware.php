<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if(!Auth::check()) {
            redirect()->route('login')->with('error', 'Silahkan Login Terlebih Dahulu');
        }

        return $next($request);
    }
}
