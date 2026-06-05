<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up(): void
{
    Schema::create('pengguna', function (Blueprint $table) {
        $table->id('id_user'); // PK sesuai ERD
        $table->string('nama_user');
        $table->string('email_user')->unique();
        $table->string('password'); // Wajib untuk autentikasi login
        $table->integer('role_user')->default(0); // 0 = User, 1 = Admin
        $table->timestamps();
    });
}
};
