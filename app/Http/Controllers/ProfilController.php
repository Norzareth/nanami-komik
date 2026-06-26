<?php

namespace App\Http\Controllers;

use App\Models\Pengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfilController extends Controller
{
    // fitur read : buat nampilin halaman edit profil buat mahasiswa itu sendiri
    public function edit()
    {
        // ngambil data mahasiswa/pengguna yg lagi login
        $pengguna = Auth::user();
        
        // kirim data yg diambil tadi ke halaman edit profil
        return view('profil.edit', compact('pengguna'));
    }

    // fitur update : buat ngeproses data editan profil yg baru
    public function update(Request $request)
    {
        // divalidasi dulu inputan edit form mahasiswa (biar nda asal2 an isinya)
        $request->validate([
            'nama_user' => 'required|string|max:255',
            'email_user' => 'required|email',
        ]);

        // ngambil id mahasiswa yg lagi login
        $user_login = Auth::user();
        
        // nyari data mahasiswa itu berdasarkan ID yang tadi diambil
        $pengguna = Pengguna::findOrFail($user_login->ID_User);

        // nyiapin data yang boleh diubah (nama,email)
        $dataUpdate = [
            'nama_user' => $request->nama_user,
            'email_user' => $request->email_user,
        ];

        // kalo mahasiswa ngisi/ngubah password lama jadi baru, nanti langsung di update passwordnya
        if ($request->filled('password')) {
            $dataUpdate['password'] = Hash::make($request->password); 
        }

        // lngsng di update ke database mysql
        $pengguna->update($dataUpdate);

        // ngembaliin mahasiswa/pengguna ke halaman profil
        return redirect()->route('profil.edit');
    }
}