<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Komentar extends Model
{
    protected $table = 'komentar';
    protected $fillable = ['id_komik', 'id_user', 'isi'];

    public function user()
{
    return $this->belongsTo(Pengguna::class, 'id_user', 'id_user'); // ganti foreign & local key
}
}