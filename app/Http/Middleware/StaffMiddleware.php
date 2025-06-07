<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StaffMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        \Illuminate\Support\Facades\Log::info('StaffMiddleware called', [
            'url' => $request->url(),
            'user' => Auth::user(),
            'role' => Auth::user()->role ?? 'not logged in'
        ]);

        if (Auth::check() && Auth::user()->role === 'staff') {
            return $next($request);
        }

        \Illuminate\Support\Facades\Log::warning('StaffMiddleware: Unauthorized access', [
            'url' => $request->url(),
            'user' => Auth::user()
        ]);

        abort(403, 'Unauthorized action. Staff access required.');
    }
} 