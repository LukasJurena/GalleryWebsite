<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
use App\Http\Controllers\GalleryController;

Route::get('/', [GalleryController::class, 'index'])->name('home');
Route::get('/album/{id}', [GalleryController::class, 'show'])->name('album.show');
Route::get('/admin', [GalleryController::class, 'admin'])->name('admin');
Route::post('/admin/store', [GalleryController::class, 'store'])->name('admin.store');