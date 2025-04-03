<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UploadController;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/uploads', [UploadController::class, 'index'])->name('upload.index');
    Route::get('/create', [UploadController::class, 'create'])->name('upload.create');
    Route::get('/upload/{upload}', [UploadController::class, 'show'])->name('upload.show');
    Route::post('/uploads', [UploadController::class, 'store'])->name('upload.store');
});

// Auth routes (no middleware needed)
Route::get('/register', [AuthController::class, 'register'])->name('register.show');
Route::post('/register', [AuthController::class, 'store'])->name('register.store');
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'verify'])->name('login.verify');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
