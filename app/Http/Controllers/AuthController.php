<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // --- 1. FUNGSI BARU UNTUK MENAMPILKAN FORM LOGIN ---
    public function index()
    {
        // 'login' di sini merujuk ke file resources/views/login.blade.php
        // (Jika file kamu ada di dalam folder auth, ubah menjadi 'auth.login')
        return view('login'); 
    }

    // --- 2. FUNGSI PROSES LOGIN (Yang sudah kamu miliki) ---
    public function authenticate(Request $request)
    {
        // 1. Validasi input dari form login
        $request->validate([
            'email_user' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // 2. Cek apakah email dan password cocok
        if (Auth::guard('web')->attempt(['email_user' => $request->email_user, 'password' => $request->password])) {
            $request->session()->regenerate();

            // 3. CEK ROLE MENGGUNAKAN ANGKA (Dari kolom role_user)
            $role = Auth::user()->role_user; 

            if ($role == 1) {
                return redirect()->intended('/admin/dashboard');
            } elseif ($role == 0) {
                return redirect()->intended('/katalog-komik'); 
            }
        }

        return back()->withErrors([
            'email_user' => 'Email atau password salah.',
        ])->onlyInput('email_user');
    }
}