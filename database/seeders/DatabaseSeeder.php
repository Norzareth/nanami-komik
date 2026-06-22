<?php

namespace Database\Seeders;

use App\Models\Pengguna; // Pastikan memakai model Pengguna
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash; // Wajib dipanggil untuk mengenkripsi password

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Buat Akun Admin (role_user = 1)
        Pengguna::create([
            'nama_user' => 'Admin Nanami',
            'email_user' => 'admin@gmail.com',
            'password' => Hash::make('admin123'), // Password admin
            'role_user' => 1, 
        ]);

        // 2. Buat Akun Mahasiswa (role_user = 0)
        Pengguna::create([
            'nama_user' => 'Mahasiswa Testing',
            'email_user' => 'testing12@gmail.com',
            'password' => Hash::make('user123'), // Password mahasiswa
            'role_user' => 0, 
        ]);
    }
}