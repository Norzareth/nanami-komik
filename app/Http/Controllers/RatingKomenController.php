<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rating;
use App\Models\Komentar;
use App\Models\Like;

class RatingKomenController extends Controller
{
    // Submit rating
    public function rating(Request $request)
    {
        $request->validate(['id_komik' => 'required', 'nilai' => 'required|integer|min:1|max:5']);

        Rating::updateOrCreate(
            ['id_komik' => $request->id_komik, 'id_user' => auth()->id()],
            ['nilai' => $request->nilai]
        );

        return back()->with('success', 'Rating tersimpan!');
    }

    // Submit komentar
    public function komentar(Request $request)
    {
        $request->validate(['id_komik' => 'required', 'isi' => 'required|string|max:500']);

        Komentar::create([
            'id_komik' => $request->id_komik,
            'id_user'  => auth()->id(),
            'isi'      => $request->isi,
        ]);

        return back()->with('success', 'Komentar ditambahkan!');
    }

    // Toggle like
    public function like(Request $request)
    {
        $existing = Like::where('id_komik', $request->id_komik)
                        ->where('id_user', auth()->id())
                        ->first();

        if ($existing) {
            $existing->delete();
        } else {
            Like::create(['id_komik' => $request->id_komik, 'id_user' => auth()->id()]);
        }

        return back();
    }
}