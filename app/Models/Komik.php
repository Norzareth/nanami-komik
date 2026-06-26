<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\Chapter;
use App\Models\Rating;
use App\Models\Komentar;
use App\Models\Like;
use App\Models\Bookmark;

class Komik extends Model
{
    protected $table = 'komik';
    protected $primaryKey = 'id_komik';

    protected $fillable = ['id_user', 'sinopsis_komik', 'nama_komik', 'url_cover', 'tanggal_rilis', 'status_pengerjaan'];

    // =====================
    // URL Cover Accessor
    // =====================

    public function getUrlCoverAttribute($value)
    {
        if (!$value) {
            return $value;
        }

        $value = $this->normalizeRemoteImageUrl($value);

        if (Str::startsWith($value, ['http://', 'https://', '/storage/'])) {
            return $value;
        }

        if (Str::startsWith($value, 'storage/')) {
            return '/' . $value;
        }

        return Storage::disk('public')->url($value);
    }

    protected function normalizeRemoteImageUrl(string $value): string
    {
        if (preg_match('#https?://drive\.google\.com/file/d/([A-Za-z0-9_-]+)(?:/view(?:\?.*)?)?#i', $value, $matches)) {
            return 'https://drive.google.com/uc?export=view&id=' . $matches[1];
        }

        if (preg_match('#https?://drive\.google\.com/open\?id=([^&]+)#i', $value, $matches)) {
            return 'https://drive.google.com/uc?export=view&id=' . $matches[1];
        }

        if (preg_match('#https?://drive\.google\.com/uc\?id=([^&]+)#i', $value, $matches)) {
            return 'https://drive.google.com/uc?export=view&id=' . $matches[1];
        }

        return $value;
    }

    // =====================
    // Relasi
    // =====================

    public function chapters()
    {
        return $this->hasMany(Chapter::class, 'id_komik', 'id_komik');
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class, 'id_komik', 'id_komik');
    }

    public function komentar()
    {
        return $this->hasMany(Komentar::class, 'id_komik', 'id_komik');
    }

    public function likes()
    {
        return $this->hasMany(Like::class, 'id_komik', 'id_komik');
    }

    public function bookmarks()
    {
        return $this->hasMany(Bookmark::class, 'ID_Komik', 'id_komik');
    }

    // =====================
    // Accessor Rating Rata
    // =====================

    public function getRatingRataAttribute()
    {
        return $this->ratings()->avg('nilai') ?? 0;
    }
}