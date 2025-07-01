<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAunthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        // ... (kode di atasnya biarkan) ...

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                // Tambahkan logika pengecekan peran di sini
                $user = Auth::user();
                if ($user->role === 'admin') {
                    return redirect('/admin/dashboard');
                } elseif ($user->role === 'dapur') {
                    return redirect('/dapur');
                }
                return redirect('/kasir');
            }
        }

        return $next($request);
    }
}
