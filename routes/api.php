<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MidtransWebhookController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\Api\EventController;
use App\Http\Controllers\Api\KategoriController;
use App\Http\Controllers\Api\AuthController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::middleware('auth:sanctum')->group(function () {
//     Route::get('/event', [\App\Http\Controllers\EventController::class, 'indexapi']);
//     Route::get('/event/{id}', [\App\Http\Controllers\EventController::class, 'show']);

// });

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/events', [EventController::class, 'index']);
    Route::get('/events/{id}', [EventController::class, 'show']);
    Route::post('/events', [EventController::class, 'store']);
    Route::put('/events/{id}', [EventController::class, 'update']);
    Route::delete('/events/{id}', [EventController::class, 'destroy']);
    Route::get('/your-event', [EventController::class, 'yourEvent']);
});

Route::resource('kategori', KategoriController::class)->except(['edit', 'create']);

Route::post('/register', [\App\Http\Controllers\Api\AuthController::class, 'register']);
Route::post('/login', [\App\Http\Controllers\Api\AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [\App\Http\Controllers\Api\AuthController::class, 'logout']);
});

Route::post('/admin/pembayaran/{id}/bayar', [PembayaranController::class, 'bayar'])->name('admin.pembayaran.bayar');
Route::post('/midtrans/webhook', [MidtransWebhookController::class, 'handle']);
