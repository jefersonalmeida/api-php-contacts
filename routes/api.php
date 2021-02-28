<?php

use Illuminate\Support\Facades\Route;
use Jas\Http\Controllers\ContactController;
use Jas\Http\Controllers\PersonController;


Route::group(['prefix' => 'persons', 'as' => 'persons.'], function () {
    Route::get('', [PersonController::class, 'index'])->name('index');
    Route::post('', [PersonController::class, 'store'])->name('store');
    Route::get('{person}', [PersonController::class, 'show'])->name('show');
    Route::put('{person}', [PersonController::class, 'update'])->name('update');
    Route::delete('{person}', [PersonController::class, 'destroy'])->name('destroy');

    Route::group(['prefix' => '{person}'], function () {
        Route::group(['prefix' => 'contacts', 'as' => 'contacts.'], function () {
            Route::get('', [ContactController::class, 'index'])->name('index');
            Route::post('', [ContactController::class, 'store'])->name('store');
            Route::get('{contact}', [ContactController::class, 'show'])->name('show');
            Route::put('{contact}', [ContactController::class, 'update'])->name('update');
            Route::delete('{contact}', [ContactController::class, 'destroy'])->name('destroy');
        });
    });
});
