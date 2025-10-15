<?php

use App\Http\Controllers\Auth\Admin\UserController;
use App\Http\Controllers\Auth\Admin\LoginController;
use App\Http\Controllers\Auth\Admin\RegisterController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\UrlController;

Route::get('/generate-admin-url', [LoginController::class, 'generateUrlsAndSend'])->name('admin.generate.url');

Route::prefix('admin')->group(function () {
    Route::get('/register/token/{token}', [RegisterController::class, 'create'])->name('admin.register.token');
    Route::post('register', [RegisterController::class, 'store'])->name('admin.register');

    Route::get('/login/token/{token}', [LoginController::class, 'create'])->name('admin.login.token');
    Route::post('login', [LoginController::class, 'store'])->name('admin.login');
});

// Routes for authenticated admins
Route::prefix('admin')->middleware('auth:admin')->group(function () {
    Route::post('logout', [LoginController::class, 'destroy'])->name('admin.logout');

    // User management routes
    Route::get('users', [UserController::class, 'index'])->name('admin.users.index');
    Route::post('users/{user}/assign-role', [UserController::class, 'assignRole'])->name('admin.users.assign-role');
    Route::delete('users/{user}/remove-role/{role}', [UserController::class, 'removeRole'])->name('admin.users.remove-role');
    Route::delete('users/{user}', [UserController::class, 'destroy'])->name('admin.users.destroy');
});
