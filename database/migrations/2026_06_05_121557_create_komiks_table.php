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
    // Pastikan namanya 'komik' (tanpa s) agar sesuai dengan Model yang kita buat
    Schema::create('komik', function (Blueprint $table) {
        $table->id('id_komik'); // Primary Key
        $table->unsignedBigInteger('id_user')->nullable(); // Foreign Key ke tabel User/Pengguna
        $table->text('sinopsis_komik')->nullable();
        $table->string('nama_komik');
        $table->string('url_cover')->nullable();
        $table->date('tanggal_rilis')->nullable();
        $table->string('status_pengerjaan')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('komiks');
    }
};
