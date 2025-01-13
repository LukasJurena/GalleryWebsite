<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
use App\Http\Controllers\GalleryController;

Route::get('/', [GalleryController::class, 'index'])->name('home');
Route::get('/album/{id}', [GalleryController::class, 'show'])->name('album.show');

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin', [GalleryController::class, 'admin'])->name('admin');
    Route::post('/admin/store', [GalleryController::class, 'store'])->name('admin.store');
});

use App\Http\Controllers\ProfileController;

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
