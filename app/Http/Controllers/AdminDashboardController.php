<?php

namespace App\Http\Controllers;

use App\Models\PaketModel;
use App\Models\RegisterModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Periksa apakah pengguna telah diautentikasi
        if (Auth::check()) {
            date_default_timezone_set('Asia/Jakarta');
            $data['year'] = date("Y");
            $data['menu'] = 'Dashboard';
            // Jika pengguna telah diautentikasi, lanjutkan ke dashboard
            return view('admin.dashboard', $data);
        }

        // Jika pengguna belum diautentikasi, redirect ke halaman login
        return redirect()->route('auth')->with([
            'message' => 'Anda harus login untuk mengakses menu tersebut.',
            'alert-type' => 'error'
        ]);
    }

    public function index_register()
    {
        // Periksa apakah pengguna telah diautentikasi
        if (Auth::check()) {
            date_default_timezone_set('Asia/Jakarta');
            $data['year'] = date("Y");
            $data['menu'] = 'Pendaftaran';
            // Jika pengguna telah diautentikasi, lanjutkan ke dashboard
            return view('admin.register', $data);
        }

        // Jika pengguna belum diautentikasi, redirect ke halaman login
        return redirect()->route('auth')->with([
            'message' => 'Anda harus login untuk mengakses menu tersebut.',
            'alert-type' => 'error'
        ]);
    }

    public function show_table_register()
    {
        $data = RegisterModel::all();

        $result = [];
        $counter = 1;
        foreach ($data as $item) {
            // Misalkan Anda telah mengambil data paket dari model PaketModel
            $paket = null;
            if (!empty($item->paket)) {
                $paket = PaketModel::find($item->paket);
            }

            $result[] = [
                'nama' => $item->nama_depan . ' ' . $item->nama_belakang,
                'alamat' => $item->alamat,
                'no_wa' => $item->no_wa,
                'kecamatan' => $item->kecamatan,
                'kelurahan' => $item->kelurahan,
                'paket' => $paket ? $paket->nama : 'Belum dipilih',
                'status' => $item->status,
                'button' => '<button type="button" class="btn btn-warning btn-sm" hidden onclick="modal_edit(' . "'" . $item->id . "'" . ')" style="margin-right: 10px;"><span class="fas fa-edit fe-12"></span></button>',
                // Sesuaikan dengan atribut yang ada di model Anda
            ];
            $counter++;
        }

        return response()->json(['data' => $result]);
    }
}
