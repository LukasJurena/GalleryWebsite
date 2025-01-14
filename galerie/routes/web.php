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

use App\Http\Controllers\AdminController;

Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
Route::post('/admin/authenticate', [AdminController::class, 'authenticate'])->name('admin.authenticate');
Route::post('/admin/store', [AdminController::class, 'store'])->name('admin.store');
