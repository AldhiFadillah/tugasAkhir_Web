<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Middleware\AttachApiToken;
use App\Http\Middleware\CheckAdmin;

Route::middleware([AttachApiToken::class, CheckAdmin::class])->group(function () {
    Route::get('/user', [DashboardController::class, 'user'])->name('user');
    Route::get('/dataUser', [DashboardController::class, 'dataUser'])->name('dataUser');
    Route::get('/createUser', [DashboardController::class, 'createUser'])->name('createUser');
    Route::get('/deleteUser/{id}', [DashboardController::class, 'deleteUser'])->name('deleteUser');
});

Route::middleware([AttachApiToken::class])->group(function () {
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/', [DashboardController::class, 'index']);
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
