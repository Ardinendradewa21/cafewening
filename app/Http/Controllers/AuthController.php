<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    function login()
    {
        return view('login');
    }

    function authenticating(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
        //Auth::attempt($credentials) itu memanggil function attempt, ngecek credentials yang diinput sama si user
        // jadi email dan password yang diinputkan itu sama dengan yg ada di database
        // jika sama, maka session dibuat, setelah itu redirect ke halaman dashboard
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            // ini kalau berhasil
            return redirect()->intended('admin');
        }
        // ini invalid
        return back()->withErrors([
            'email' => 'Login Tidak Berhasil.',
        ])->onlyInput('email');
    }
}
