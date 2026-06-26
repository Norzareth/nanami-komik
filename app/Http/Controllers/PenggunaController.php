<?php

namespace App\Http\Controllers;

use App\Models\Pengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PenggunaController extends Controller
{
    // fitur read : buat nampilin halaman utama dashboard admin
    public function index()
    {
        // ngambil semua data pengguna dari database
        $pengguna = Pengguna::all();

        // ngirim data nya untuk di tampilin di halaman
        return view('pengguna.index', compact('pengguna'));
    }

    // fitur create : buat nampilin halaman form buat nambah pengguna baru
    public function create()
    {
        // cuman nampilin halaman form kosong buat nambah pengguna baru
        return view('pengguna.create');
    }

    // fitur create : buat ngeproses data yang diinput dari form tadi ,
    // trus disimpen ke database
    public function store(Request $request)
    {
        // divalidasi dulu inputan form dr mahasiswa sesuai ketentuan atau nda 
        // (cegah input asal2 an)
        $request->validate([
            'nama_user' => 'required|string|max:255|unique:pengguna',
            'email_user' => 'required|email|unique:pengguna',
            'password' => 'required|string|min:8',
            'role_user' => 'required|integer',
        ]);

        // data disimpen ke dalam tabel pengguna di database
        Pengguna::create([
            'nama_user' => $request->nama_user,
            'email_user' => $request->email_user,
            'password' => Hash::make($request->password), 
            'role_user' => $request->role_user,
        ]);

        // ngembaliin layar web ke halaman daftar pengguna
        return redirect()->route('pengguna.index');
    }

    // fitur update : buat nampilin halaman form edit data lama
    public function edit($id)
    {
        // nyari data pengguna sesuai id , 
        // kalo nda ada id nya dikirim pesan error
        $pengguna = Pengguna::findOrFail($id);

        // ngirim datanya untuk ditampilin ke halaman form edit
        return view('pengguna.edit', compact('pengguna'));
    }

    // fitur update : buat ngeproses perubahan data profil lama jadi baru dari form edit
    public function update(Request $request, $id)
    {
        // divalidasi dulu data barunya
        $request->validate([
            'nama_user' => 'required|string|max:255',
            'email_user' => 'required|email',
            'role_user' => 'required|integer',
        ]);

        // nyari data lama pengguna yang mau diedit
        $pengguna = Pengguna::findOrFail($id);
        
        // nyiapin array data yang mau di update
        $dataUpdate = [
            'nama_user' => $request->nama_user,
            'email_user' => $request->email_user,
            'role_user' => $request->role_user,
        ];

        // kalo admin ngisi/ngubah password lama jadi baru, 
        // nanti langsung di update passwordnya
        if ($request->filled('password')) {
            $dataUpdate['password'] = Hash::make($request->password);
        }

        // lngsng di update perubahan data lama ke baru 
        // berdasarkan array data tadi
        $pengguna->update($dataUpdate);

        // ngembaliin layar web ke tabel daftar pengguna
        return redirect()->route('pengguna.index');
    }

    // fitur delete : buat ngehapus data profil pengguna secara permanen
    public function destroy($id)
    {
        // nyari data yang mau dihapus berdasarkan id
        $pengguna = Pengguna::findOrFail($id);

        // lngsng delete datanya dari database
        $pengguna->delete();

        // ngembaliin layar web ke tabel daftar pengguna
        return redirect()->route('pengguna.index');
    }
}