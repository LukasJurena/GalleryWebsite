<?php
use Illuminate\Support\Facades\Route;
Route::get('/', function () {
    return view('welcome');
});
use App\Http\Controllers\AdminController;
use App\Http\Controllers\GalleryController;

Route::get('/', [GalleryController::class, 'index'])->name('home');

// Admin login a autentizace
Route::get('/admin', [GalleryController::class, 'admin'])->name('admin.index');

Route::post('/admin/authenticate', [AdminController::class, 'authenticate'])->name('admin.authenticate');

// Administrativní sekce pro nahrávání obrázků
Route::post('/admin/store', [GalleryController::class, 'store'])->name('admin.store');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::post('/albums/store', [GalleryController::class, 'storeAlbum'])->name('albums.store');
});
// Zobrazení jednoho obrázku
Route::get('/image/{id}', [GalleryController::class, 'showImage'])->name('gallery.show');

// Zobrazení alba
Route::get('/album/{id}', [GalleryController::class, 'showAlbum'])->name('album.show');

Route::get('image/{imageId}', [GalleryController::class, 'showImage'])->name('image.show');

Route::prefix('admin')->middleware(['auth'])->group(function() {
    // Trasa pro zobrazení admin indexu
    Route::get('/', [GalleryController::class, 'index'])->name('admin.index');

    // Trasa pro zobrazení všech obrázků
    Route::get('images', [GalleryController::class, 'showImages'])->name('admin.images.index');

    // Trasa pro smazání obrázku
    Route::delete('images/{id}', [GalleryController::class, 'destroyImage'])->name('admin.images.destroy');

    // Trasa pro zobrazení alb
    Route::get('albums', [GalleryController::class, 'showAlbums'])->name('admin.albums.index');

    // Trasa pro smazání alba
    Route::delete('albums/{id}', [GalleryController::class, 'destroyAlbum'])->name('admin.albums.destroy');

    // Trasa pro úpravu obrázku
    Route::get('images/{id}/edit', [GalleryController::class, 'editImage'])->name('admin.images.edit');
    Route::put('images/{id}', [GalleryController::class, 'updateImage'])->name('admin.images.update');

    // Trasa pro úpravu alba
    Route::get('albums/{id}/edit', [GalleryController::class, 'editAlbum'])->name('admin.albums.edit');
    Route::put('albums/{id}', [GalleryController::class, 'updateAlbum'])->name('admin.albums.update');
});