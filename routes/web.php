<?php

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\Guest\EventGuestController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\PengajuanEventController;
use App\Http\Controllers\PenyelenggaraController;
use App\Http\Controllers\TiketController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Route;

Route::get('/', [EventGuestController::class, 'home'])->name('guest.home');
Route::get('/event', [EventGuestController::class, 'index'])->name('guest.event');
Route::get('/event/{slug}', [EventGuestController::class, 'show'])->name('guest.detail');
Route::get('/tentang', function () {return view('guest.about');})->name('guest.about');
Route::get('/kontak', function () {return view('guest.kontak');})->name('guest.kontak');
// GET - Tampilkan form
Route::get('/beli', [PembayaranController::class, 'formCheckout'])->name('guest.checkout.form');

// POST - Proses pembelian
Route::post('/beli', [PembayaranController::class, 'guestCheckout'])->name('guest.checkout.proses');

Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

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
Route::get('/uploads/{filename}', function ($filename) {
    $path = public_path('uploads/' . $filename);

    if (! File::exists($path)) {
        abort(404);
    }

    $file = File::get($path);
    $type = File::mimeType($path);

    return response($file, 200)
        ->header("Content-Type", $type)
        ->header("Access-Control-Allow-Origin", "*");
});

//route guest
