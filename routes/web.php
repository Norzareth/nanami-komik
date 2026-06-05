<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KomikController;
use App\Http\Controllers\AuthController; // Dari yang kita buat di Step sebelumnya

// Route Utama (Komik)
Route::get('/', [KomikController::class, 'index'])->name('home');
Route::get('/browse', [KomikController::class, 'browse'])->name('browse');
Route::get('/library', [KomikController::class, 'library'])->name('library');

// Route Login
Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/login', [AuthController::class, 'authenticate']);