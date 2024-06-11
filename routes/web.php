<?php

use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\HomeController;
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

Route::get('/', [HomeController::class, 'index'])->name('home');

//admin
Route::get('/auth', [AdminAuthController::class, 'index'])->name('auth');
Route::post('/login-proses', [AdminAuthController::class, 'login'])->name('login-proses');
Route::get('/logout-proses', [AdminAuthController::class, 'logout'])->name('logout-proses');

Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
