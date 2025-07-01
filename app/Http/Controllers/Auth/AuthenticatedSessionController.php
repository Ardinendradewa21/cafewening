<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Menampilkan halaman login.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Menangani permintaan login yang masuk.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // 1. Lakukan proses autentikasi
        $request->authenticate();

        // 2. Regenerate session untuk keamanan
        $request->session()->regenerate();

        // 3. Ambil data pengguna yang baru saja login
        $user = Auth::user();

        // 4. Periksa perannya (role) dan arahkan ke URL yang benar
        if ($user->role === 'admin') {
            // Jika admin, arahkan ke URL '/admin/dashboard'
            return redirect('/admin/dashboard');
        } elseif ($user->role === 'dapur') { // <-- Tambahkan blok ini
            return redirect('/dapur');
        }

        // Jika bukan admin (berarti kasir), arahkan ke URL '/kasir'
        return redirect('/kasir');
    }

    /**
     * Hancurkan sesi autentikasi (logout).
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
