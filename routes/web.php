<?php

use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminPaketController;
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

Route::get('/paket', [AdminPaketController::class, 'index'])->name('paket');
Route::get('/table-paket', [AdminPaketController::class, 'show_table'])->name('table-paket');
Route::get('/form-paket/{id?}', [AdminPaketController::class, 'index_form'])->name('form-paket');
Route::post('/tambah-paket', [AdminPaketController::class, 'tambah'])->name('tambah-paket');
Route::post('/status-paket', [AdminPaketController::class, 'status'])->name('status-paket');
