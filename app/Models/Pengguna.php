<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Pengguna extends Authenticatable
{
    protected $table = 'pengguna';
    protected $primaryKey = 'id_user';
    
    protected $fillable = [
        'nama_user',
        'email_user',
        'password',
        'role_user',
    ];
}
