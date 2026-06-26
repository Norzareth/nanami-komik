<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bookmark;
use App\Models\Chapter;
use App\Models\Komik;
use Illuminate\Support\Facades\Auth;

class KomikController extends Controller
{
    // 1. Halaman Home
    public function index()
    {
        $rekomendasi = Komik::withCount('likes')
                            ->with('ratings')
                            ->inRandomOrder()
                            ->take(6)
                            ->get();

        $topKomik = Komik::withCount('likes')
                         ->with('ratings')
                         ->get()
                         ->sortByDesc(fn($k) => $k->rating_rata)
                         ->take(5)
                         ->values();

        return view('home', compact('rekomendasi', 'topKomik'));
    }

    // 2. Halaman Browse
    public function browse(Request $request)
    {
        $search = $request->query('search');

        $semuaKomik = Komik::withCount('likes')
                           ->with('ratings')
                           ->when($search, fn($query) => $query->where('nama_komik', 'like', "%{$search}%"))
                           ->latest()
                           ->get();

        return view('browse', compact('semuaKomik', 'search'));
    }

    // 3. Halaman Library
    public function library()
    {
        $bookmarks = collect();

        if (Auth::check()) {
            $bookmarks = Bookmark::with(['komik' => function ($query) {
                $query->withCount('likes')->with('ratings');
            }])
            ->where('ID_Pengguna', Auth::id())
            ->get();
        }

        return view('library', compact('bookmarks'));
    }

    // 4. Detail Komik
    public function show(Komik $komik)
    {
        $komik->load([
            'chapters' => fn($q) => $q->orderBy('nomor_chapter'),
            'ratings',
            'likes',
            'komentar.user',
            'bookmarks',
        ]);

        $isBookmarked = false;
        $bookmarkId = null;

        if (Auth::check()) {
            $bookmark = $komik->bookmarks->firstWhere('ID_Pengguna', Auth::id());
            $isBookmarked = $bookmark !== null;
            $bookmarkId = $bookmark?->ID_Bookmark;
        }

        return view('komik.show', compact('komik', 'isBookmarked', 'bookmarkId'));
    }

    // 5. Baca Chapter
    public function showChapter(Chapter $chapter)
    {
        $chapter->load('pages', 'komik');

        return view('chapters.show', compact('chapter'));
    }
}