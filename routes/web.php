<?php

use Illuminate\Support\Facades\Route;

/**
 * Application Routes
 * All routes that require authentication
 */
Route::get('/', function () {
    return redirect()->route('gallery.index');
});

Route::get('/proxy-img', [App\Http\Controllers\ImgController::class, 'proxy_image'])->name('proxy.img');

Route::middleware('auth')->group(function () {
    Route::prefix('gallery')->name('gallery.')->group(function () {
        // list of all your images
        Route::get('/', [App\Http\Controllers\ImgController::class, 'index'])->name('index');

        // upload image(s)
        Route::get('/upload', [App\Http\Controllers\ImgController::class, 'create'])->name('create');
        Route::post('/', [App\Http\Controllers\ImgController::class, 'store'])->name('store');
        Route::post('/bulk', [App\Http\Controllers\ImgController::class, 'bulk_upload'])->name('bulk');

        // delete image(s)
        Route::delete('/del/{img}', [App\Http\Controllers\ImgController::class, 'destroy'])->name('destroy');
        Route::delete('/del', [App\Http\Controllers\ImgController::class, 'selected_destroy'])->name('sel.destroy');
    });

    Route::get('/settings', [App\Http\Controllers\ProfileController::class, 'edit'])->name('settings');
    Route::put('/settings', [App\Http\Controllers\ProfileController::class, 'apikey'])->name('settings.apikey');
    Route::get('/settings/sharex', [App\Http\Controllers\ProfileController::class, 'sharex'])->name('settings.sharex');
});

require __DIR__.'/auth.php';

/**
 * Image Routes
 */
Route::middleware('cache.headers:public;max_age=2628000;etag')->get('/{id}', [App\Http\Controllers\ImgController::class, 'show_img'])->name('img');
