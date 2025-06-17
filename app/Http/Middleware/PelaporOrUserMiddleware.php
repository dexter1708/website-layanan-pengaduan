<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PelaporOrUserMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            // Jika belum login, redirect ke halaman login
            return redirect()->route('login');
        }

        $user = Auth::user();

        if ($user->role === 'pelapor' ) {
            return $next($request); // Izinkan akses
        }
        if ($user->role === 'user') {
            return $next($request); // Izinkan akses
        }
        abort(403, 'Anda tidak memiliki izin untuk mengakses halaman ini.');
    }
} 