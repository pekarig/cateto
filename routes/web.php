<?php

use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

// Főoldal
Route::get('/', [PageController::class, 'home'])->name('home');

// Admin route-ok (Filament kezeli automatikusan)
// /admin útvonal elérhető

// Gyerek oldalak (pl: unraid/docker-setup)
Route::get('/{parent}/{child}', [PageController::class, 'showChild'])->name('pages.child');

// Fő oldalak (pl: /grafika, /kapcsolat)
Route::get('/{slug}', [PageController::class, 'show'])->name('pages.show');
