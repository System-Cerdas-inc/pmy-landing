<?php

namespace App\Http\Controllers;

use App\Models\PaketModel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AdminPaketController extends Controller
{
    public function index()
    {
        // Periksa apakah pengguna telah diautentikasi
        if (Auth::check()) {
            // Mengambil nilai dari sesi dengan kunci 'user'
            $userData = Session::get('user');

            $nama = $userData['nama'];
            date_default_timezone_set('Asia/Jakarta');
            $data['year'] = date("Y");
            $data['menu'] = 'Paket';
            $data['nama_user'] = $nama;
            // Jika pengguna telah diautentikasi, lanjutkan ke dashboard
            return view('admin.paket.paket', $data);
        }

        // Jika pengguna belum diautentikasi, redirect ke halaman login
        return redirect()->route('auth')->with([
            'message' => 'Anda harus masuk untuk mengakses dashboard.',
            'alert-type' => 'error'
        ]);
    }
    public function index_form($id = null)
    {
        // Periksa apakah pengguna telah diautentikasi
        if (Auth::check()) {
            // Mengambil nilai dari sesi dengan kunci 'user'
            $userData = Session::get('user');

            $nama = $userData['nama'];
            date_default_timezone_set('Asia/Jakarta');
            $data['year'] = date("Y");
            $data['menu'] = 'Paket';
            $data['nama_user'] = $nama;
            $data['data_paket'] = $id ? PaketModel::findOrFail($id) : null;
            // Jika pengguna telah diautentikasi, lanjutkan ke dashboard
            return view('admin.paket.form', $data);
        }

        // Jika pengguna belum diautentikasi, redirect ke halaman login
        return redirect()->route('auth')->with([
            'message' => 'Anda harus masuk untuk mengakses dashboard.',
            'alert-type' => 'error'
        ]);
    }

    public function show_table()
    {
        $data = PaketModel::all();

        $result = [];
        $counter = 1;
        foreach ($data as $item) {
            //check status
            if ($item->status == '1') {
                $status = '<span class="badge badge-pill badge-success">Aktif</span>';
                $btn = '<button type="button" class="btn btn-danger btn-sm" id="btn_nonaktif" onclick="btn_nonaktif(' . "'" . $item->id . "'" . ', ' . "'" . $item->nama . "'" . ')"><span class="fas fa-times fe-12"></span></button>';
            } else {
                $status = '<span class="badge badge-pill badge-danger">Tidak Aktif</span>';
                $btn = '<button type="button" class="btn btn-success btn-sm" id="btn_aktif" onclick="btn_aktif(' . "'" . $item->id . "'" . ', ' . "'" . $item->nama . "'" . ')"><span class="fas fa-check fe-12"></span></button>';
            }
            //check popular
            if ($item->popular == '1') {
                $popular = 'Ya';
            } else {
                $popular = 'Tidak';
            }
            $result[] = [
                'nama' => $item->nama,
                'kecepatan' => $item->kecepatan,
                'harga' => 'Rp. ' . number_format($item->harga),
                'jenis' => $item->jenis,
                'device' => $item->device,
                'registrasi' => 'Rp. ' . number_format($item->registrasi),
                'popular' => $popular,
                'status' => $status,
                'button' => '<button type="button" class="btn btn-warning btn-sm" onclick="modal_edit(' . "'" . $item->id . "'" . ')" style="margin-right: 10px;"><span class="fas fa-edit fe-12"></span></button>' . $btn,
                // Sesuaikan dengan atribut yang ada di model Anda
            ];
            $counter++;
        }

        return response()->json(['data' => $result]);
    }

    public function tambah(Request $request)
    {
        // Validasi data
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'kecepatan' => 'required|string|max:255',
            'harga' => 'required|string|max:255',
            'jenis' => 'required|string|max:255',
            'device' => 'required|string|max:255',
            'registrasi' => 'required|string|max:255'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $id = $request->input('id');

        // Simpan atau update data di database
        $data = $id ? PaketModel::findOrFail($id) : new PaketModel();
        $data->nama = $request->input('nama');
        $data->kecepatan = $request->input('kecepatan');
        $data->device = $request->input('device');
        $data->harga = str_replace(".", "", $request->input('harga'));
        $data->registrasi = str_replace(".", "", $request->input('registrasi'));
        $data->jenis = $request->input('jenis');
        $data->popular = $request->has('popular');
        // Set status default 1 jika data baru
        if (!$id) {
            $data->status = 1;
        }
        $simpan = $data->save();

        $message = $id ? 'Data paket berhasil diperbarui.' : 'Data paket berhasil disimpan.';

        if ($simpan) {
            return redirect()->route('admin-paket')->with([
                'message' => $message,
                'alert-type' => 'success'
            ]);
        } else {
            return redirect()->route('admin-paket')->with([
                'message' => 'Data paket gagal disimpan.',
                'alert-type' => 'error'
            ]);
        }
    }

    public function status(Request $request)
    {
        //check status
        if ($request->input('kondisi') == 'aktif') {
            $data_status = '1';
        } else {
            $data_status = '2';
        }
        // Temukan paket berdasarkan ID
        $data = PaketModel::findOrFail($request->input('id_confirm'));
        $data->status = $data_status;
        $simpan = $data->save();

        if ($simpan) {
            return response()->json(['status' => 'success']);
        } else {
            return response()->json(['status' => 'error']);
        }
    }
}
