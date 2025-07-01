<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    // $role akan diisi dari file route (misal: 'admin' atau 'kasir')
    public function handle(Request $request, Closure $next, string $role)
    {
        // Jika pengguna tidak login ATAU perannya tidak sesuai
        if (!Auth::check() || Auth::user()->role !== $role) {
            // Alihkan ke halaman login
            return redirect('/login');
        }
        // Jika peran sesuai, lanjutkan ke halaman yang dituju
        return $next($request);
    }
}
