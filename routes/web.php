<?php

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\PengajuanEventController;
use App\Http\Controllers\PenyelenggaraController;
use App\Http\Controllers\TiketController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});
Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegisterController::class, 'register']);

Auth::routes();

//route admin
Route::prefix('admin')->middleware(['auth', 'can:view_admin'])->as('admin.')->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::resource('kategori', KategoriController::class);
    Route::resource('events', EventController::class);
    Route::resource('tiket', TiketController::class);
    Route::resource('penyelenggara', PenyelenggaraController::class);
    Route::resource('pembayaran', PembayaranController::class);
    Route::post('/admin/pembayaran/{id}/bayar', [PembayaranController::class, 'bayar'])->name('admin.pembayaran.bayar');
    Route::put('/pembayaran/{id}/status_tiket', [PembayaranController::class, 'updateStatusTiket'])->name('pembayaran.updateStatusTiket');

    Route::get('/pengajuan', [PengajuanEventController::class, 'index'])->name('pengajuan.index');
    Route::post('/pengajuan/{event}/approve', [PengajuanEventController::class, 'approve'])->name('pengajuan.approve');
    Route::post('/pengajuan/{event}/reject', [PengajuanEventController::class, 'reject'])->name('pengajuan.reject');
    Route::post('/events/{event}/reapply', [EventController::class, 'reapply'])->name('events.reapply');

    Route::post('/upload-image', [UploadController::class, 'upload'])->name('upload.image');
});

//route user
Route::middleware(['auth'])->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::middleware('can:category_read')->group(function () {
        Route::resource('kategori', KategoriController::class);
    });

    Route::middleware('can:event_read')->group(function () {
        Route::resource('events', EventController::class);
        Route::post('/events/{event}/reapply', [EventController::class, 'reapply'])->name('events.reapply');

    });

    Route::middleware('can:ticket_read')->group(function () {
        Route::resource('tiket', TiketController::class);
    });
});
