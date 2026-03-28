<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ContentBlockController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\Api\ContactInteractionController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application.
|
*/

// Test endpoint
Route::get('/test', function () {
    return response()->json([
        'message' => 'Laravel API működik!',
        'status' => 'success',
        'timestamp' => now()
    ]);
});

// Contact info endpoint (GDPR védett)
Route::get('/contact-info', function () {
    return response()->json([
        'address' => 'Póvoa de Santa Iria e Forte da Casa, Portugal',
        'email' => 'geral@cateto.com',
        'phone' => '+351 936 750 011'
    ]);
});

// Contact interaction moved to web.php (needs session + CSRF)
// Route::post('/contact-interaction', [ContactInteractionController::class, 'logInteraction']);

// Publikus route-ok
Route::get('/pages', [PageController::class, 'index']);
Route::get('/pages/{slug}', [PageController::class, 'show']);

// Content Blocks - PUBLIC (nincs auth)
Route::get('/content-blocks', [ContentBlockController::class, 'publicIndex']);
Route::get('/content-blocks/{key}', [ContentBlockController::class, 'show']);

// Auth route-ok (bejelentkezés nélkül)
Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/login', [AuthController::class, 'login']);

// Védett route-ok (bejelentkezés szükséges)
Route::middleware('auth:sanctum')->group(function () {
    // Auth
    Route::get('/auth/user', [AuthController::class, 'user']);
    Route::post('/auth/logout', [AuthController::class, 'logout']);

    // Admin Pages
    Route::get('/admin/pages', [PageController::class, 'adminIndex']);
    Route::post('/admin/pages', [PageController::class, 'store']);
    Route::put('/admin/pages/{page}', [PageController::class, 'update']);
    Route::delete('/admin/pages/{page}', [PageController::class, 'destroy']);

    // Admin Content Blocks
    Route::get('/admin/content-blocks', [ContentBlockController::class, 'index']);
    Route::post('/admin/content-blocks', [ContentBlockController::class, 'store']);
    Route::put('/admin/content-blocks/{key}', [ContentBlockController::class, 'update']);
    Route::delete('/admin/content-blocks/{key}', [ContentBlockController::class, 'destroy']);

    // Content Block Revisions (verziókezelés)
    Route::get('/admin/content-blocks/{key}/revisions', [ContentBlockController::class, 'revisions']);
    Route::post('/admin/content-blocks/{key}/revisions/{revisionId}/restore', [ContentBlockController::class, 'restoreRevision']);
});
