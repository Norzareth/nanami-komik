<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Komik;

class Bookmark extends Model
{
    protected $table = 'bookmark';
    protected $primaryKey = 'ID_Bookmark';

    protected $fillable = [
        'ID_Pengguna', 
        'ID_Komik'
    ];

    public function komik()
    {
        return $this->belongsTo(Komik::class, 'ID_Komik', 'id_komik');
    }
}