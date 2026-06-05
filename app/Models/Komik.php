<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Komik extends Model
{
    protected $table = 'komik'; // Sesuai nama tabel di SQL
    protected $primaryKey = 'id_komik';
    
    // Kolom yang boleh diisi
    protected $fillable = ['id_user', 'sinopsis_komik', 'nama_komik', 'url_cover', 'tanggal_rilis', 'status_pengerjaan'];
}