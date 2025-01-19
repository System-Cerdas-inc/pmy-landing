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
        $data = PaketModel::orderBy('urutan', 'asc')->get();

        $result = [];
        $counter = 1;
        foreach ($data as $item) {
            // Check status
            if ($item->status == '1') {
                $status = '<span class="badge badge-pill badge-success">Aktif</span>';
                $btn_status = '<a class="dropdown-item" href="javascript:void(0);" onclick="btn_nonaktif(' . "'" . $item->id . "'" . ', ' . "'" . $item->nama . "'" . ')"><i class="fas fa-times mr-2"></i>Nonaktifkan</a>';
            } else {
                $status = '<span class="badge badge-pill badge-danger">Tidak Aktif</span>';
                $btn_status = '<a class="dropdown-item" href="javascript:void(0);" onclick="btn_aktif(' . "'" . $item->id . "'" . ', ' . "'" . $item->nama . "'" . ')"><i class="fas fa-check mr-2"></i>Aktifkan</a>';
            }

            // Check popular
            if ($item->popular == '1') {
                $popular = 'Ya';
            } else {
                $popular = 'Tidak';
            }

            // Format visibility
            $visibility = '
            <div class="d-flex flex-wrap gap-2">
                <span class="badge ' . ($item->nama_visible ? 'badge-success mb-1' : 'badge-secondary') . '">Nama</span>
                <span class="badge ' . ($item->kecepatan_visible ? 'badge-success mb-1' : 'badge-secondary') . '">Kecepatan</span>
                <span class="badge ' . ($item->device_visible ? 'badge-success mb-1' : 'badge-secondary') . '">Device</span>
                <span class="badge ' . ($item->harga_visible ? 'badge-success mb-1' : 'badge-secondary') . '">Harga</span>
                <span class="badge ' . ($item->registrasi_visible ? 'badge-success mb-1' : 'badge-secondary') . '">Registrasi</span>
                <span class="badge ' . ($item->popular_visible ? 'badge-success mb-1' : 'badge-secondary') . '">Popular</span>
            </div>
        ';

            // Format harga dan registrasi
            $harga = '<span class="badge badge-primary">Paket: Rp. ' . number_format($item->harga) . '</span><br><span class="badge badge-primary">Registrasi: Rp. ' . number_format($item->registrasi) . '</span>';

            // Dropdown button
            $button = '
            <div class="dropdown">
                <button class="btn btn-sm btn-primary dropdown-toggle" type="button" id="dropdownMenuButton' . $item->id . '" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-cog"></i> Aksi
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton' . $item->id . '">
                    <a class="dropdown-item" href="javascript:void(0);" onclick="modal_edit(' . "'" . $item->id . "'" . ')"><i class="fas fa-edit mr-2"></i>Edit</a>
                    ' . $btn_status . '
                    <a class="dropdown-item text-danger" href="javascript:void(0);" onclick="btn_delete(' . "'" . $item->id . "'" . ', ' . "'" . $item->nama . "'" . ')"><i class="fas fa-trash mr-2"></i>Hapus</a>
                </div>
            </div>
        ';

            $result[] = [
                'nama' => $item->nama . '<br>' . $item->jenis,
                'kecepatan' => $item->kecepatan,
                'harga' => $harga,
                'device' => $item->device,
                'popular' => $popular,
                'urutan' => $item->urutan ?? '-',
                'status' => $status,
                'visibility' => $visibility, // Kolom visibility
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
            'nama' => 'required|string|max:255',
            'kecepatan' => 'required|string|max:255',
            'harga' => 'required|string|max:255',
            'jenis' => 'required|string|max:255',
            'device' => 'required|string|max:255',
            'registrasi' => 'required|string|max:255',
            'urutan' => 'required|numeric',
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

        // Simpan status visibility
        $data->nama_visible = $request->has('nama_visible');
        $data->kecepatan_visible = $request->has('kecepatan_visible');
        $data->device_visible = $request->has('device_visible');
        $data->harga_visible = $request->has('harga_visible');
        $data->registrasi_visible = $request->has('registrasi_visible');
        $data->jenis_visible = $request->has('jenis_visible');
        $data->popular_visible = $request->has('popular_visible');

        $sortOrder = $request->input('urutan', 0);

        // Atur data lama ke 0 jika `sort_order` duplikat, kecuali record yang sedang diupdate
        PaketModel::where('urutan', $sortOrder)
            ->where('id', '!=', $id)
            ->update(['urutan' => null]);

        // Set nilai `sort_order` untuk data baru
        $data->urutan = $sortOrder;

        // Set status default 1 jika data baru
        if (!$id) {
            $data->status = 1; // Ubah status menjadi 1: Aktif
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
            $data_status = '1'; // Ubah status menjadi 1: Aktif
        } else {
            $data_status = '2'; // Ubah status menjadi 2: Tidak Aktif
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

    public function delete(Request $request)
    {
        $id = $request->input('id_confirm');

        // Cari data berdasarkan ID
        $data = PaketModel::find($id);

        if ($data) {
            $data->delete(); // Hapus data
            return response()->json(['status' => 'success', 'message' => 'Data berhasil dihapus.']);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Data tidak ditemukan.']);
        }
    }
}
