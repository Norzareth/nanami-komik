<?php

namespace App\Http\Controllers;

use App\Models\RiwayatBaca;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RiwayatBacaController extends Controller
{
    // fitur read : buat nampilin daftar history baca komik
    public function index()
    {
        // ngambil data history baca mahasiswa/pengguna berdasarkan id mahasiswa itu
        $riwayat = RiwayatBaca::where('ID_Pengguna', Auth::id())->get();

        // kirim data dan tampilin ke halaman daftar history baca
        return view('profil.riwayat', compact('riwayat'));
    }

    // fitur create dan update: buat nyimpen progress bacaan komik 
    // (otomatis dipanggil saat mahasiswa sedang membaca komik)
    public function store(Request $request)
    {
        // divalidasi dulu 3 data ini
        $request->validate([
            'ID_Komik' => 'required|integer',
            'ID_Chapter' => 'required|integer',
            'halaman_terakhir' => 'required|integer'
        ]);

        // ngecek kalo komik ini udah ada history bacanya sebelumnya (hindari duplikasi)
        $riwayat = RiwayatBaca::where('ID_Pengguna', Auth::id())
                              ->where('ID_Komik', $request->ID_Komik)
                              ->first();

        if ($riwayat) {
            // kalo ada , lngsng update nomor chapter atau halaman yg baru
            $riwayat->update([
                'ID_Chapter' => $request->ID_Chapter,
                'halaman_terakhir' => $request->halaman_terakhir
            ]);
        } else {
            // kalo blm ada (baru pertama kali baca komik ini) , 
            // buat data history baru untuk komik ini
            RiwayatBaca::create([
                'ID_Pengguna' => Auth::id(),
                'ID_Komik' => $request->ID_Komik,
                'ID_Chapter' => $request->ID_Chapter,
                'halaman_terakhir' => $request->halaman_terakhir
            ]);
        }

        // tampilkan pesan , progress membaca dikirim via API di background
        return response()->json(['message' => 'Progress bacaan disimpan']);
    }

    // fitur delete : buat ngehapus daftar history baca
    public function destroy($id)
    {
        // ngepastiin kalo mahasiswa/pengguna ini bisa ngehapus daftar history baca miliknya sendiri|
        // berdasarkan id nya sendiri
        $riwayat = RiwayatBaca::where('ID_Riwayat', $id)
                              ->where('ID_Pengguna', Auth::id())
                              ->firstOrFail();
        
        // hapus dari database nya lngsng
        $riwayat->delete();
        
        // lngsng direfresh halaman daftar history baca nya
        return redirect()->back();
    }
}