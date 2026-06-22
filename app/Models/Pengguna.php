<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Pengguna extends Authenticatable
{
    use Notifiable;

    // 1. Beritahu nama tabel yang benar
    protected $table = 'pengguna';
    
    // 2. Beritahu Primary Key yang benar
    protected $primaryKey = 'id_user';

    // 3. Kolom yang diizinkan untuk diisi
    protected $fillable = [
        'nama_user', 
        'email_user', 
        'password',
        'role_user'
    ];

    // 4. Sembunyikan password agar aman
    protected $hidden = [
        'password',
    ];
}
