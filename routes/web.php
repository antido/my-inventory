<?php

use App\Http\Controllers\Admin\PrivilegeController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'create'])->name('login');
    Route::post('/login', [AuthController::class, 'store'])->name('login.store');
    Route::get('/sign-up', [AuthController::class, 'register'])->name('register');
    Route::post('/sign-up', [AuthController::class, 'storeRegistration'])->name('register.store');
});

Route::get('/dashboard', [DashboardController::class, 'redirect'])
    ->middleware('auth')
    ->name('dashboard');

Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'role:admin'])
    ->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'admin'])->name('dashboard');
        Route::resource('users', UserController::class)->except('show');
        Route::resource('roles', RoleController::class)->except('show');
        Route::resource('privileges', PrivilegeController::class)->except('show');
        Route::resource('products', ProductController::class)->except('show');
    });

Route::get('/user/dashboard', [DashboardController::class, 'user'])
    ->middleware(['auth', 'role:user'])
    ->name('user.dashboard');

Route::post('/logout', [AuthController::class, 'destroy'])->middleware('auth')->name('logout');
