<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\Auth\LoginRequest;

class AuthenticatedSessionController extends Controller
{
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();
        $request->session()->regenerate();


        $user = Auth::user();
        if ($user->role === 'admin') {
            return redirect()->intended('/admin/dashboard');
        }
        return redirect()->intended('/kasir'); // Default untuk kasir
    }
}