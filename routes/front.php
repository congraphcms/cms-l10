<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Congraph\Eav\AttributesController;




// OLD Congraph
Route::prefix('api/v1')->name('CB.')->group(function () {

    // Entities
    Route::prefix('entities')->name('entity.')->group(function () {
        // Get
        Route::get('/', [ App\Http\Controllers\Front\EntityController::class, 'index'])
            ->name('get')
            ->middleware([]);
        // Fetch
        Route::get('/{id}', [App\Http\Controllers\Front\EntityController::class, 'show'])
            ->name('fetch')
            ->middleware([]);

    });

    // Files
    Route::prefix('files')->name('file.')->group(function () {
        // Get
        Route::get('/', [ App\Http\Controllers\Front\FileController::class, 'index'])
            ->name('get')
            ->middleware([]);
        // Fetch
        Route::get('/{id}', [App\Http\Controllers\Front\FileController::class, 'show'])
            ->name('fetch')
            ->where('id', '[0-9]+')
            ->middleware([]);

        // Serve
        Route::get('/{file}', [App\Http\Controllers\Front\FileServeController::class, 'index'])
            ->name('serve')
            ->middleware([]);

    });
});
