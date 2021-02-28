<?php

use Illuminate\Support\Facades\Route;
use Jas\Http\Controllers\Controller;

Route::get('/', [Controller::class, 'welcome'])->name('home');
Route::get('routes', [Controller::class, 'routes'])->name('routes');
