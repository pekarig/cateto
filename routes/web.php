<?php

use App\Http\Controllers\PageController;
use App\Http\Controllers\Api\ContactInteractionController;
use Illuminate\Support\Facades\Route;

// Főoldal
Route::get('/', [PageController::class, 'home'])->name('home');

// Contact analytics (POST endpoint session-nel és CSRF-fel)
Route::post('/api/contact-interaction', [ContactInteractionController::class, 'logInteraction']);

// Admin route-ok (Filament kezeli automatikusan)
// /admin útvonal elérhető

// Gyerek oldalak (pl: unraid/docker-setup)
Route::get('/{parent}/{child}', [PageController::class, 'showChild'])->name('pages.child');

// Fő oldalak (pl: /grafika, /kapcsolat)
Route::get('/{slug}', [PageController::class, 'show'])->name('pages.show');
