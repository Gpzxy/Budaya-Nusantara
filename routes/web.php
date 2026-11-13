<?php

use App\Http\Controllers\CultureController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/budaya/{slug}', [CultureController::class, 'show'])->name('culture.show');
