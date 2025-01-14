<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
use App\Http\Controllers\AdminController;
use App\Http\Controllers\GalleryController;

Route::get('/', [GalleryController::class, 'index'])->name('home');
Route::get('/album/{id}', [GalleryController::class, 'show'])->name('album.show');

// Admin login a autentizace
Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
Route::post('/admin/authenticate', [AdminController::class, 'authenticate'])->name('admin.authenticate');

// Administrativní sekce pro nahrávání obrázků
Route::post('/admin/store', [GalleryController::class, 'store'])->name('admin.store');


