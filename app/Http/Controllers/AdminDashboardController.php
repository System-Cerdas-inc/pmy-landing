<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Periksa apakah pengguna telah diautentikasi
        if (Auth::check()) {
            // Jika pengguna telah diautentikasi, lanjutkan ke dashboard
            return view('admin.dashboard');
        }

        // Jika pengguna belum diautentikasi, redirect ke halaman login
        return redirect()->route('auth')->with([
            'message' => 'Anda harus masuk untuk mengakses dashboard.',
            'alert-type' => 'error'
        ]);
    }
}
