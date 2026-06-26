<?php

namespace App\Http\Controllers;

use App\Models\Bookmark;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookmarkController extends Controller
{
    // fitur read : buat nampilin daftar favorit komik / bookmark dari mahasiswa/pengguna itu
    public function index()
    {
        // nyari data bookmark berdasarkan id pengguna yang sedang login
        $bookmarks = Bookmark::where('ID_Pengguna', Auth::id())->get();

        // kirim data buat nampilin daftar bookmark itu
        return view('profil.bookmark', compact('bookmarks'));
    }

    // fitur create : buat nyimpen komik ke daftar bookmark
    public function store(Request $request)
    {
        // divalidasi dulu kalo sistem bener2 nerima id komik
        $request->validate([
            'ID_Komik' => 'required|integer'
        ]);

        // ngecek kalo komik ini udah di bookmark sama mahasiswa/pengguna itu (hindari duplikasi)
        $cekBookmark = Bookmark::where('ID_Pengguna', Auth::id())
                               ->where('ID_Komik', $request->ID_Komik)
                               ->first();
        
        // kalo hasil cek tadi kosong/nda ada, 
        // langsung dikasi baris data baru buat komik itu dlm tabel bookmark di database
        if (!$cekBookmark) {
            Bookmark::create([
                'ID_Pengguna' => Auth::id(),
                'ID_Komik' => $request->ID_Komik
            ]);
        }

        return redirect()->back(); // ngembaliin layar ke sebelumnya
    }

    // fiture delete : buat ngehapus komik dari daftar bookmark
    public function destroy($id)
    {
        // ngepastiin kalo mahasiswa/pengguna ini bisa ngehapus daftar favorit miliknya sendiri
        // berdasarkan id nya sendiri
        $bookmark = Bookmark::where('ID_Bookmark', $id)
                            ->where('ID_Pengguna', Auth::id())
                            ->firstOrFail();
        
        // hapus dari database nya lngsng
        $bookmark->delete();

        // lngsng direfresh halaman daftar bookmark nya
        return redirect()->back();
    }
}