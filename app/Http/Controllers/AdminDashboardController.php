<?php

namespace App\Http\Controllers;

use App\Models\PaketModel;
use App\Models\RegisterModel;
use App\Models\UsersModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Helpers\EncryptionHelper;

class AdminDashboardController extends Controller
{
    protected $encryptionHelper;

    public function __construct()
    {
        $this->encryptionHelper = new EncryptionHelper();
    }

    public function index()
    {
        // Periksa apakah pengguna telah diautentikasi
        if (Auth::check()) {
            // Mengambil nilai dari sesi dengan kunci 'user'
            $userData = Session::get('user');

            $nama = $userData['nama'];
            date_default_timezone_set('Asia/Jakarta');
            $data['year'] = date("Y");
            $data['menu'] = 'Dashboard';
            $data['nama_user'] = $nama;
            // Jika pengguna telah diautentikasi, lanjutkan ke dashboard
            return view('admin.dashboard', $data);
        }

        // Jika pengguna belum diautentikasi, redirect ke halaman login
        return redirect()->route('auth')->with([
            'message' => 'Anda harus login untuk mengakses menu tersebut.',
            'alert-type' => 'error'
        ]);
    }

    public function index_profil()
    {
        // Periksa apakah pengguna telah diautentikasi
        if (Auth::check()) {
            // Mengambil nilai dari sesi dengan kunci 'user'
            $userData = Session::get('user');

            $id_user = $userData['id'];
            $nama = $userData['nama'];
            date_default_timezone_set('Asia/Jakarta');
            $data['year'] = date("Y");
            $data['menu'] = 'Profil';
            $data['nama_user'] = $nama;
            $data['data_user'] = UsersModel::where('id', $id_user)->first();
            // Jika pengguna telah diautentikasi, lanjutkan ke dashboard
            return view('admin.profil', $data);
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
            // Mengambil nilai dari sesi dengan kunci 'user'
            $userData = Session::get('user');

            $nama = $userData['nama'];
            date_default_timezone_set('Asia/Jakarta');
            $data['year'] = date("Y");
            $data['menu'] = 'Pendaftaran';
            $data['nama_user'] = $nama;
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

    public function datadiri_profil(Request $request)
    {
        // Validasi data
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'email' => 'required|email'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Mengambil nilai dari sesi dengan kunci 'user'
        $userData = Session::get('user');

        $id_user = $userData['id'];

        // Simpan atau update data di database
        $data = UsersModel::findOrFail($id_user);
        $data->full_name = $request->input('nama');
        $data->email = $request->input('email');
        $simpan = $data->save();

        if ($simpan) {
            return redirect()->route('admin-profil')->with([
                'message' => 'Data diri anda berhasil diperbarui.',
                'alert-type' => 'success'
            ]);
        } else {
            return redirect()->route('admin-profil')->with([
                'message' => 'Data diri gagal disimpan.',
                'alert-type' => 'error'
            ]);
        }
    }
    public function password_profil(Request $request)
    {
        // Validasi data
        $validator = Validator::make($request->all(), [
            'password' => 'required', // Password harus ada dan minimal 8 karakter
            'konfirm_password' => 'required|same:password', // Konfirmasi password harus sama dengan password baru
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Mengambil nilai dari sesi dengan kunci 'user'
        $userData = Session::get('user');

        $id_user = $userData['id'];

        // Simpan atau update data di database
        $data = UsersModel::findOrFail($id_user);
        $data->password = $this->encryptionHelper->dekrip($request->input('password'));
        $simpan = $data->save();

        if ($simpan) {
            return redirect()->route('admin-profil')->with([
                'message' => 'Data password anda berhasil diperbarui.',
                'alert-type' => 'success'
            ]);
        } else {
            return redirect()->route('admin-profil')->with([
                'message' => 'Data password gagal disimpan.',
                'alert-type' => 'error'
            ]);
        }
    }
}
