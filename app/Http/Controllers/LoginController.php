<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // ================= TAMPIL LOGIN =================
    public function showLogin()
    {
        return view('login');
    }

    // ================= PROSES LOGIN =================
    public function login(Request $request)
    {
        // VALIDASI
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ], [
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'password.required' => 'Password wajib diisi',
        ]);

        // COBA LOGIN
        if (Auth::attempt($credentials)) {

            // regenerate session (security)
            $request->session()->regenerate();

            // 🔥 REDIRECT KE BERANDA (FIX)
            return redirect()->route('beranda');
        }

        // LOGIN GAGAL
        return back()->withErrors([
            'email' => 'Email atau password salah',
        ])->onlyInput('email');
    }

    // ================= LOGOUT =================
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}