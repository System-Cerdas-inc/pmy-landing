<?php

namespace App\Http\Controllers;

use App\Models\PostinganModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class AdminPostinganController extends Controller
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
            $data['menu'] = 'Postingan';
            $data['nama_user'] = $nama;
            // Jika pengguna telah diautentikasi, lanjutkan ke dashboard
            return view('admin.postingan.postingan', $data);
        }

        // Jika pengguna belum diautentikasi, redirect ke halaman login
        return redirect()->route('auth')->with([
            'message' => 'Anda harus login untuk mengakses menu tersebut.',
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
            $data['menu'] = 'Postingan';
            $data['nama_user'] = $nama;
            $data['data_postingan'] = $id ? PostinganModel::findOrFail($id) : null;
            // Jika pengguna telah diautentikasi, lanjutkan ke dashboard
            return view('admin.postingan.form', $data);
        }

        // Jika pengguna belum diautentikasi, redirect ke halaman login
        return redirect()->route('auth')->with([
            'message' => 'Anda harus masuk untuk mengakses dashboard.',
            'alert-type' => 'error'
        ]);
    }

    public function show_table()
    {
        $data = PostinganModel::all();

        $result = [];
        $counter = 1;
        foreach ($data as $item) {
            //check video
            if ($item->link_video == '') {
                $video = '';
            } else {
                $video = '<video width="640" height="360" controls="controls" type="video/mp4" preload="none">
                                    <source src="' . $item->link_video . '" autostart="false">
                                </video>';
            }

            //check harga 
            if ($item->jenis == 'Harga Dashboard') {
                if (is_numeric($item->judul)) {
                    $judul = 'Rp. ' . number_format($item->judul, 0, ',', '.');
                } else {
                    $judul = 'Judul harus berupa harga atau angka';
                }
            } else {
                $judul = $item->judul;
            }
            $result[] = [
                'jenis' => $item->jenis,
                'judul' => $judul,
                'keterangan' => $item->keterangan,
                'link_video' => $video,
                'button' => '<button type="button" class="btn btn-warning btn-sm" onclick="modal_edit(' . "'" . $item->id . "'" . ')" style="margin-right: 10px;"><span class="fas fa-edit fe-12"></span></button>',
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
            'jenis' => 'required',
            'judul' => [
                'required',
                'string',
                'max:255',
                function ($attribute, $value, $fail) use ($request) {
                    // Cek apakah jenis adalah "Harga Dashboard"
                    if ($request->jenis === 'Harga Dashboard') {
                        // Lakukan validasi bahwa judul harus berupa angka
                        if (!is_numeric($value)) {
                            $fail('Judul harus berupa angka jika jenis adalah "Harga Dashboard".');
                        }
                    }
                },
            ],
            'video' => 'nullable|file|mimetypes:video/mp4',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Inisialisasi variabel untuk video URL
        $videoUrl = null;

        // Jika ada file video yang diunggah
        if ($request->hasFile('video')) {
            // Simpan video ke storage
            $videoPath = $request->file('video')->store('videos', 'public');
            $videoUrl = asset('storage/' . $videoPath); // URL untuk akses video
        }

        $id = $request->input('id');

        // Simpan data video ke database
        $data = $id ? PostinganModel::findOrFail($id) : new PostinganModel();
        $data->jenis = $request->input('jenis');
        $data->judul = $request->input('judul');
        $data->keterangan = $request->input('keterangan');
        if ($id == '') {
            $data->link_video = $videoUrl; // Simpan URL video, bisa null jika tidak ada video
        }
        $simpan = $data->save();

        $message = $id ? 'Data postingan berhasil diperbarui.' : 'Data postingan berhasil disimpan.';

        if ($simpan) {
            return redirect()->route('admin-postingan')->with([
                'message' => $message,
                'alert-type' => 'success'
            ]);
        } else {
            return redirect()->route('admin-postingan')->with([
                'message' => 'Data postingan gagal disimpan.',
                'alert-type' => 'error'
            ]);
        }
    }
}
