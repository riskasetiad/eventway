<?php

    use App\Http\Controllers\EventController;
    use App\Http\Controllers\KategoriController;
    use App\Http\Controllers\PengajuanEventController;
    use App\Http\Controllers\PenyelenggaraController;
    use App\Http\Controllers\TiketController;
    use App\Http\Controllers\UploadController;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Route;

    Route::get('/', function () {
        return view('auth.login');
    });

    Auth::routes();

    //route admin
    Route::prefix('admin')->middleware(['auth', 'can:view_admin'])->as('admin.')->group(function () {
        Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

        Route::resource('kategori', KategoriController::class);
        Route::resource('events', EventController::class);
        Route::resource('tiket', TiketController::class);
        Route::resource('penyelenggara', PenyelenggaraController::class);

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
