<?php

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
    })->name('super-admin.dashboard');

    Route::prefix('sekolah')->group(function () {
        Route::get('/', [SekolahController::class, 'index'])->name('sekolah.index');
        Route::get('/create', [SekolahController::class, 'create'])->name('sekolah.create');
        Route::post('/', [SekolahController::class, 'store'])->name('sekolah.store');
        Route::get('/{sekolah}', [SekolahController::class, 'show'])->name('sekolah.show');
        Route::get('/{sekolah}/edit', [SekolahController::class, 'edit'])->name('sekolah.edit');
        Route::patch('/{sekolah}', [SekolahController::class, 'update'])->name('sekolah.update');
        Route::delete('/{sekolah}', [SekolahController::class, 'destroy'])->name('sekolah.destroy');
    });
});
