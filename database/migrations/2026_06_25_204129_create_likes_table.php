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
    Schema::create('likes', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('id_komik');
        $table->unsignedBigInteger('id_user');
        $table->timestamps();
        $table->unique(['id_komik', 'id_user']); // 1 user = 1 like per komik
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('likes');
    }
};
