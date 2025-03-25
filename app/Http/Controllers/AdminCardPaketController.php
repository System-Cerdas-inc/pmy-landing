<?php

namespace App\Http\Controllers;

use App\Models\CardPaket;
use App\Models\PaketModel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AdminCardPaketController extends Controller
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
            $data['menu'] = 'Keterangan Paket';
            $data['nama_user'] = $nama;
            // Jika pengguna telah diautentikasi, lanjutkan ke dashboard
            return view('admin.paket-keterangan.keterangan', $data);
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
            $data['data_paket'] = $id ? PaketModel::findOrFail($id) : PaketModel::all();
            $data['data_paket_keterangan'] = $id ? CardPaket::findOrFail($id) : null;

            // Jika pengguna telah diautentikasi, lanjutkan ke dashboard
            return view('admin.paket-keterangan.form', $data);
        }

        // Jika pengguna belum diautentikasi, redirect ke halaman login
        return redirect()->route('auth')->with([
            'message' => 'Anda harus masuk untuk mengakses dashboard.',
            'alert-type' => 'error'
        ]);
    }

    public function show_table()
    {
        $data = CardPaket::orderBy('updated_at', 'asc')->get();

        $result = [];
        $counter = 1;
        foreach ($data as $item) {

            // Dropdown button
            $button = '
            <div class="dropdown">
                <button class="btn btn-sm btn-primary dropdown-toggle" type="button" id="dropdownMenuButton' . $item->id . '" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-cog"></i> Aksi
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton' . $item->id . '">
                    <a class="dropdown-item" href="javascript:void(0);" onclick="modal_edit(' . "'" . $item->id . "'" . ')"><i class="fas fa-edit mr-2"></i>Edit</a>
                    <a class="dropdown-item text-danger" href="javascript:void(0);" onclick="btn_delete(' . "'" . $item->id . "'" . ', ' . "'" . $item->title . "'" . ')"><i class="fas fa-trash mr-2"></i>Hapus</a>
                </div>
            </div>
            ';

            $result[] = [
                'id' => $item->id,
                'title' => $item->title,
                'button' => $button, // Kolom action (dropdown)
            ];
            $counter++;
        }

        return response()->json(['data' => $result]);
    }

    public function tambah(Request $request)
    {
        // Validasi data
        $validator = Validator::make($request->all(), [
            'judul_keterangan_paket' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $id = $request->input('id');

        // Simpan atau update data di database
        $data = $id ? CardPaket::findOrFail($id) : new CardPaket();
        $data->title = $request->input('judul_keterangan_paket');
        $simpan = $data->save();

        $message = $id ? 'Data paket berhasil diperbarui.' : 'Data paket berhasil disimpan.';

        if ($simpan) {
            return redirect()->route('admin-paket-keterangan')->with([
                'message' => $message,
                'alert-type' => 'success'
            ]);
        } else {
            return redirect()->route('admin-paket-keterangan')->with([
                'message' => 'Data paket gagal disimpan.',
                'alert-type' => 'error'
            ]);
        }
    }

    public function delete(Request $request)
    {
        $id = $request->input('id_confirm');

        // Cari data berdasarkan ID
        $data = CardPaket::find($id);

        if ($data) {
            $data->delete(); // Hapus data
            return response()->json(['status' => 'success', 'message' => 'Data berhasil dihapus.']);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Data tidak ditemukan.']);
        }
    }
}
