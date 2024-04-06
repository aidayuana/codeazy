<?php

use App\Http\Controllers\ProfileController;
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

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('pages.dashboard.admin-dashboard');
    })->name('dashboard.admin');

    Route::patch('/admin/profile/sekolah', [ProfileController::class, 'updateSekolah'])->name('profile.updateSekolah');
});
