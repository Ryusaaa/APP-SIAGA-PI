<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DataSiswaController;
use App\Http\Controllers\Admin\MasterDataController;
use App\Http\Controllers\Admin\TrackingController;
use App\Http\Controllers\DashboardUserController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\keluarKampusController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\SuratTelatController;
use App\Http\Controllers\Admin\UsersController;
use Illuminate\Support\Facades\Route;

// Admin
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('users', [UsersController::class, 'index'])->name('users.index');
    Route::get('users/create', [UsersController::class, 'create'])->name('users.create');
    Route::post('users', [UsersController::class, 'store'])->name('users.store');

    Route::get('users/{id}/edit', [UsersController::class, 'edit'])->name('users.edit');
    Route::patch('users/{id}', [UsersController::class, 'update'])->name('users.update');
    Route::delete('users/{id}', [UsersController::class, 'destroy'])->name('users.destroy');

    Route::controller(SiswaController::class)->group(function () {
        Route::get('siswa', 'index')->name('siswa.index');
        Route::post('siswa-import', 'import')->name('siswa.import');
        Route::get('siswa-template', 'downloadTemplate')->name('siswa.template');
        Route::delete('siswa/delete/{id}', 'delete')->name('siswa.delete');
    });

    Route::controller(KelasController::class)->group(function () {
        Route::get('kelas', 'index')->name('kelas.index');
        Route::post('kelas-import', 'import')->name('kelas.import');
        Route::delete('kelas/delete/{id}', 'delete')->name('kelas.delete');
    });

    Route::controller(DataSiswaController::class)->group(function () {
        Route::get('data', 'index')->name('data.index');
        Route::get('data/izin', 'izin')->name('data.izin');

        Route::get('data/terlambat', 'terlambat')->name('data.terlambat');
        Route::delete('data/terlambat/delete/{id}', 'lateDelete')->name('data.lateDelete');
        Route::get('data/terlambat/filter', 'filterLate')->name('filter.terlambat');

        Route::get('data/guest', 'guest')->name('data.guest');
        Route::delete('data/guest/delete/{id}', 'guestDelete')->name('data.guestDelete');
        Route::get('data/guest/filter', 'filterGuest')->name('filter.guest');
    });
    Route::middleware(['auth'])->prefix('admin/master')->name('master.')->group(function () {
        // Jurusan
        Route::get('/jurusan', [MasterDataController::class, 'indexJurusan'])->name('jurusan');
        Route::post('/jurusan', [MasterDataController::class, 'storeJurusan'])->name('jurusan.store');
        Route::get('/jurusan/{id}', [MasterDataController::class, 'showJurusan']);
        Route::put('/jurusan/{id}', [MasterDataController::class, 'updateJurusan']);
        Route::delete('/jurusan/{id}', [MasterDataController::class, 'deleteJurusan']);

        // Mapel
        Route::get('/mapel', [MasterDataController::class, 'indexMapel'])->name('mapel');
        Route::post('/mapel', [MasterDataController::class, 'storeMapel'])->name('mapel.store');
        Route::put('/mapel/{id}', [MasterDataController::class, 'updateMapel']);
        Route::delete('/mapel/{id}', [MasterDataController::class, 'deleteMapel']);
    });

    Route::middleware(['auth'])->prefix('admin/tracking')->name('tracking.')->group(function () {
        Route::get('/', [TrackingController::class, 'index'])->name('index');
        Route::post('/{id}/kembali', [TrackingController::class, 'updateKembali']);
    });
});

// User
Route::controller(SuratTelatController::class)->group(function () {
    Route::get('terlambat', 'index')->name('terlambat.index');
    Route::post('terlambat/store', 'store')->name('terlambat.store');
});

Route::redirect('/', 'keluar-kampus');
Route::get('/', [DashboardUserController::class, 'index'])->name('home');

Route::get('/api/mapel-by-kelas/{kelasId}', function ($kelasId) {
    $kelas = \App\Models\Kelas::findOrFail($kelasId);
    $jurusan = \App\Models\Jurusan::where('nama', $kelas->jurusan)->first();

    $mapels = \App\Models\Mapel::where('is_active', true)
        ->where(function ($query) use ($jurusan) {
            $query->whereNull('jurusan_id')
                ->orWhere('jurusan_id', $jurusan->id ?? null);
        })
        ->get();

    return response()->json($mapels);
});

Route::resource('keluar-kampus', keluarKampusController::class);

Route::controller(keluarKampusController::class)->group(function () {
    Route::post('keluar-kampus/storeIzinkeluar', 'storeIzinkeluar')->name('keluar-kampus.storeIzinkeluar');
    Route::post('keluar-kampus/storePindahkelas', 'storePindahkelas')->name('keluar-kampus.storePindahkelas');
    Route::post('keluar-kampus/storeSuratTamu', 'storeSuratTamu')->name('keluar-kampus.storeSuratTamu');
    Route::get('/pdf/{filename}', 'showPdf')->name('showPdf');
});

// etc
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
require __DIR__ . '/auth.php';
