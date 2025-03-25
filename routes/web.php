<?php

use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminCardPaketController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminPaketController;
use App\Http\Controllers\AdminPostinganController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PaketController;
use App\Http\Controllers\RegisterController;
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
Route::get('/paket', [PaketController::class, 'index'])->name('paket');
Route::get('/register', [RegisterController::class, 'index'])->name('register');
Route::post('/proses-register', [RegisterController::class, 'register'])->name('proses-register');
Route::get('/syarat-dan-ketentuan', [HomeController::class, 'index_sk'])->name('syarat-dan-ketentuan');

//test wa
// Route::get('/test-wa-client', [HomeController::class, 'testWaClient'])->name('test-wa-client');
// Route::get('/test-wa-admin', [HomeController::class, 'testWaAdmin'])->name('test-wa-admin');

//admin
Route::get('/auth', [AdminAuthController::class, 'index'])->name('auth');
Route::post('/login-proses', [AdminAuthController::class, 'login'])->name('login-proses');
Route::get('/logout-proses', [AdminAuthController::class, 'logout'])->name('logout-proses');

Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

//admin profil
Route::get('/admin-profil', [AdminDashboardController::class, 'index_profil'])->name('admin-profil');
Route::post('/datadiri-profil', [AdminDashboardController::class, 'datadiri_profil'])->name('datadiri-profil');
Route::post('/password-profil', [AdminDashboardController::class, 'password_profil'])->name('password-profil');

//admin pendaftaran
Route::get('/admin-pendaftaran', [AdminDashboardController::class, 'index_register'])->name('admin-pendaftaran');
Route::get('/table-pendaftaran', [AdminDashboardController::class, 'show_table_register'])->name('table-pendaftaran');
Route::post('/status-pendaftaran', [AdminDashboardController::class, 'status_register'])->name('status-pendaftaran');
Route::post('/delete-masal-pendaftaran', [AdminDashboardController::class, 'delete_masal_register'])->name('delete-masal-pendaftaran');
Route::get('/form-pendaftaran/{id?}', [AdminDashboardController::class, 'index_form_register'])->name('form-pendaftaran');
Route::post('/update-paket', [AdminDashboardController::class, 'update_register'])->name('update-paket');

//admin paket
Route::get('/admin-paket', [AdminPaketController::class, 'index'])->name('admin-paket');
Route::get('/table-paket', [AdminPaketController::class, 'show_table'])->name('table-paket');
Route::get('/form-paket/{id?}', [AdminPaketController::class, 'index_form'])->name('form-paket');
Route::post('/tambah-paket', [AdminPaketController::class, 'tambah'])->name('tambah-paket');
Route::post('/status-paket', [AdminPaketController::class, 'status'])->name('status-paket');
Route::post('/delete-paket', [AdminPaketController::class, 'delete'])->name('delete-paket');

//admin paket keterangan
Route::get('/admin-paket-keterangan', [AdminCardPaketController::class, 'index'])->name('admin-paket-keterangan');
Route::get('/table-paket-keterangan', [AdminCardPaketController::class, 'show_table'])->name('table-paket-keterangan');
Route::get('/form-paket-keterangan/{id?}', [AdminCardPaketController::class, 'index_form'])->name('form-paket-keterangan');
Route::post('/tambah-paket-keterangan', [AdminCardPaketController::class, 'tambah'])->name('tambah-paket-keterangan');
Route::post('/delete-paket-keterangan', [AdminCardPaketController::class, 'delete'])->name('delete-paket-keterangan');

//admin postingan
Route::get('/admin-postingan', [AdminPostinganController::class, 'index'])->name('admin-postingan');
Route::get('/table-postingan', [AdminPostinganController::class, 'show_table'])->name('table-postingan');
Route::get('/form-postingan/{id?}', [AdminPostinganController::class, 'index_form'])->name('form-postingan');
Route::post('/tambah-postingan', [AdminPostinganController::class, 'tambah'])->name('tambah-postingan');
