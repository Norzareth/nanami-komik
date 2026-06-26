<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    protected $table = 'ratings';
    protected $fillable = ['id_komik', 'id_user', 'nilai'];

    public function user()
{
    return $this->belongsTo(Pengguna::class, 'id_user', 'id_user');
}
}