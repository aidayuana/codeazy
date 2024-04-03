<?php

use App\Http\Controllers\GuruController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\SekolahController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware(['auth', 'role:super_admin'])->group(function () {
    Route::get('/super-admin/dashboard', function () {
        return view('pages.dashboard.super-admin-dashboard');
    })->name('dashboard.super-admin');

    Route::prefix('sekolah')->group(function () {
        Route::get('/', [SekolahController::class, 'index'])->name('sekolah.index');
        Route::get('/create', [SekolahController::class, 'create'])->name('sekolah.create');
        Route::post('/', [SekolahController::class, 'store'])->name('sekolah.store');
        Route::get('/{sekolah}', [SekolahController::class, 'show'])->name('sekolah.show');
        Route::get('/{sekolah}/edit', [SekolahController::class, 'edit'])->name('sekolah.edit');
        Route::patch('/{sekolah}', [SekolahController::class, 'update'])->name('sekolah.update');
        Route::delete('/{sekolah}', [SekolahController::class, 'destroy'])->name('sekolah.destroy');
    });

    Route::prefix('kelas')->group(function () {
        Route::get('/', [KelasController::class, 'index'])->name('kelas.index');
        Route::get('/create', [KelasController::class, 'create'])->name('kelas.create');
        Route::post('/', [KelasController::class, 'store'])->name('kelas.store');
        Route::get('/{kelas}', [KelasController::class, 'show'])->name('kelas.show');
        Route::get('/{kelas}/edit', [KelasController::class, 'edit'])->name('kelas.edit');
        Route::patch('/{kelas}', [KelasController::class, 'update'])->name('kelas.update');
        Route::delete('/{kelas}', [KelasController::class, 'destroy'])->name('kelas.destroy');
    });

    Route::prefix('user/guru')->group(function () {
        Route::get('/', [GuruController::class, 'index'])->name('guru.index');
        Route::get('/create', [GuruController::class, 'create'])->name('guru.create');
        Route::post('/', [GuruController::class, 'store'])->name('guru.store');
        Route::get('/{guru}', [GuruController::class, 'show'])->name('guru.show');
        Route::get('/{guru}/edit', [GuruController::class, 'edit'])->name('guru.edit');
        Route::patch('/{guru}', [GuruController::class, 'update'])->name('guru.update');
        Route::delete('/{guru}', [GuruController::class, 'destroy'])->name('guru.destroy');
    });
});