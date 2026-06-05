<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Menampilkan halaman login
    public function index()
    {
        return view('login');
    }

    // Memproses data login (CRUD - Read untuk Autentikasi)
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email_user' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Melakukan pengecekan ke database
        if (Auth::guard('pengguna')->attempt(['email_user' => $credentials['email_user'], 'password' => $credentials['password']])) {
            $request->session()->regenerate();
            return redirect()->intended('/'); // Kembali ke landing page jika sukses
        }

        return back()->withErrors([
            'email_user' => 'Kredensial yang diberikan tidak cocok dengan data kami.',
        ]);
    }
}