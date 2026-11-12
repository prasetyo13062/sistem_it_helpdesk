<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Halaman Login
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [AuthController::class, 'showLogin'])
    ->name('login');

Route::post('/login', [AuthController::class, 'login'])
    ->name('login.process');

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

// =====================================================
// PROFIL
// Bisa diakses PEGAWAI dan IT
// =====================================================

Route::middleware('auth')->group(function () {

    Route::get('/profil', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::put('/profil', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::put('/profil/password', [ProfileController::class, 'updatePassword'])
        ->name('profile.password');

});

/*
|--------------------------------------------------------------------------
| Pegawai
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:pegawai'])->group(function () {

    Route::get('/pegawai/dashboard', [DashboardController::class, 'pegawai'])
        ->name('pegawai.dashboard');

    Route::get('/pegawai/tiket', [TicketController::class, 'index'])
        ->name('pegawai.tickets.index');

    Route::get('/pegawai/tiket/create', [TicketController::class, 'create'])
        ->name('pegawai.tickets.create');

    Route::get('/pegawai/tiket/{id}', [TicketController::class, 'show'])
        ->name('pegawai.tickets.show');

    Route::post('/pegawai/tiket', [TicketController::class, 'store'])
        ->name('pegawai.tickets.store');

    Route::post('/pegawai/tiket/{id}/komentar', [TicketController::class, 'addComment'])
        ->name('pegawai.tickets.comment');

    Route::middleware('auth')->group(function () {});
});

/*
|--------------------------------------------------------------------------
| IT
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:it'])->group(function () {

    Route::get('/it/dashboard', [DashboardController::class, 'it'])
        ->name('it.dashboard');

    Route::get('/it/tiket', [TicketController::class, 'itIndex'])
        ->name('it.tickets.index');

    Route::get('/it/semua-tiket', [TicketController::class, 'allTickets'])
        ->name('it.tickets.all');

    Route::get('/it/riwayat', [TicketController::class, 'history'])
        ->name('it.tickets.history');

    Route::get('/it/laporan', [ReportController::class, 'index'])
        ->name('it.reports.index');

    Route::get('/it/laporan/export', [ReportController::class, 'export'])
        ->name('it.reports.export');

    Route::get('/it/pegawai', [UserController::class, 'index'])
        ->name('it.users.index');

    Route::get('/it/pegawai/create', [UserController::class, 'create'])
        ->name('it.users.create');

    Route::post('/it/pegawai', [UserController::class, 'store'])
        ->name('it.users.store');

    Route::delete('/it/pegawai/{id}', [UserController::class, 'destroy'])
        ->name('it.users.destroy');

    Route::get('/it/tiket/{id}', [TicketController::class, 'itShow'])
        ->name('it.tickets.show');

    Route::post('/it/tiket/{id}/terima', [TicketController::class, 'accept'])
        ->name('it.tickets.accept');

    Route::post('/it/tiket/{id}/mulai-penanganan', [TicketController::class, 'startHandling'])
        ->name('it.tickets.start');

    Route::post('/it/tiket/{id}/penanganan', [TicketController::class, 'addHandling'])
        ->name('it.tickets.handling');

    Route::post('/it/tiket/{id}/selesaikan', [TicketController::class, 'complete'])
        ->name('it.tickets.complete');

    Route::post('/it/tiket/{id}/komentar', [TicketController::class, 'addComment'])
        ->name('it.tickets.comment');

});
