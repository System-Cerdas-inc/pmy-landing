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
use App\Http\Library\WaNotification;

class AdminDashboardController extends Controller
{
    use WaNotification;

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
        $data->password = $this->encryptionHelper->enkrip($request->input('password'));
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
            return view('admin.register.register', $data);
        }

        // Jika pengguna belum diautentikasi, redirect ke halaman login
        return redirect()->route('auth')->with([
            'message' => 'Anda harus login untuk mengakses menu tersebut.',
            'alert-type' => 'error'
        ]);
    }

    public function index_form_register($id = null)
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
            $data['data_register'] = $id ? RegisterModel::findOrFail($id) : null;
            $data['data_paket'] = PaketModel::where('status', 1)->get();
            // Jika pengguna telah diautentikasi, lanjutkan ke dashboard
            return view('admin.register.form', $data);
        }

        // Jika pengguna belum diautentikasi, redirect ke halaman login
        return redirect()->route('auth')->with([
            'message' => 'Anda harus masuk untuk mengakses dashboard.',
            'alert-type' => 'error'
        ]);
    }

    public function show_table_register()
    {
        $data = RegisterModel::where('status', '!=', 0)->orderBy('updated_at', 'desc')->get();

        $result = [];
        $counter = 1;
        foreach ($data as $item) {
            $nama = $item->nama_depan . ' ' . $item->nama_belakang;
            // Misalkan Anda telah mengambil data paket dari model PaketModel
            $paket = null;
            if (!empty($item->paket)) {
                $paket = PaketModel::find($item->paket);
            }

            switch ($item->status) {
                    //aktif
                case '1':
                    $status = '<span class="badge badge-pill badge-success"><i class="fas fa-check-circle"></i> Aktif</span>';
                    break;
                    //proses pasang
                case '2':
                    $status = '<span class="badge badge-pill badge-primary"><i class="fas fa-check"></i> Pasang</span>';
                    break;
                    //tidak pasang
                case '3':
                    $status = '<span class="badge badge-pill badge-danger"><i class="fas fa-times"></i> Tidak Pasang</span>';
                    break;
                    //pending
                case '4':
                    $status = '<span class="badge badge-pill badge-warning"><i class="fas fa-exclamation-triangle"></i> Pending</span>';
                    break;
                default:
                    $status = '<span class="badge badge-pill badge-danger"><i class="fas fa-ban"></i> Tidak Aktif</span>';
                    break;
            }

            $btn = '<button type="button" class="btn btn-warning btn-sm" alt="Edit" onclick="modal_edit(' . "'" . $item->id . "'" . ')">
                    <span class="fas fa-edit fe-12"></span>
                    </button>';

            if ($item->status == 1) {
                $btn .= '<button type="button" class="btn btn-danger btn-sm mt-1" id="btn_nonaktif" alt="Nonaktif" onclick="btn_nonaktif(' . "'" . $item->id . "'" . ', ' . "'" . $nama . "'" . ')"><span class="fas fa-ban fe-12"></span></button>';
            } elseif ($item->status == 0) {
                $btn .= '<button type="button" class="btn btn-success btn-sm mt-1" id="btn_nonaktif" alt="Nonaktif" onclick="btn_aktif(' . "'" . $item->id . "'" . ', ' . "'" . $nama . "'" . ')"><span class="fas fa-check fe-12"></span></button>';
            }

            $btn .= '<div class="btn-group">
                    <button type="button" class="btn btn-primary btn-sm dropdown-toggle mt-1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="fas fa-cog fe-12"></span>
                    </button>
                    <div class="dropdown-menu">
                    <a class="dropdown-item" onclick="btn_pasang(' . "'" . $item->id . "'" . ', ' . "'" . $nama . "'" . ')">Pasang</a>
                    <a class="dropdown-item" onclick="btn_pending(' . "'" . $item->id . "'" . ', ' . "'" . $nama . "'" . ')">Pending</a>
                    <a class="dropdown-item" onclick="btn_tidak_pasang(' . "'" . $item->id . "'" . ', ' . "'" . $nama . "'" . ')">Tidak Pasang</a>
                    </div>
                    </div>';

            $result[] = [
                'nama' => 'Nama: ' . $nama . '<br>' . 'No. WA: ' . $item->no_wa . '<br>' . 'Alamat: ' . $item->alamat . ', kel: ' . $item->kelurahan . ', kec: ' . $item->kecamatan . '<br>' . 'Tanggal Pasang: ' . $item->tanggal_pasang,
                'kecamatan' => $item->kecamatan,
                'kelurahan' => $item->kelurahan,
                'rekomendasi' => $item->rekomendasi,
                'paket' => $paket ? $paket->nama : 'Belum dipilih',
                'created_at' => $item->updated_at->format('Y-m-d H:i:s'),
                'tanggal_pasang' => $item->tanggal_pasang,
                'status' => $status,
                'button' => $btn,
                // Sesuaikan dengan atribut yang ada di model Anda
            ];
            $counter++;
        }

        return response()->json(['data' => $result]);
    }

    public function status_register(Request $request)
    {
        // Temukan paket berdasarkan ID
        $data = RegisterModel::findOrFail($request->input('id_confirm'));
        $data->status = $request->input('kondisi');
        $data->tanggal_pasang = $request->input('kondisi') == '2' ? $request->input('tanggal_pasang') : null;
        $simpan = $data->save();

        if ($request->input('kondisi') == '2') {
            $this->sendToAdminPasang($data);
        }

        if ($simpan) {
            return response()->json(['status' => 'success']);
        } else {
            return response()->json(['status' => 'error']);
        }
    }

    public function update_register(Request $request)
    {
        // Validasi data
        $validator = Validator::make($request->all(), [
            'nama_depan' => 'required|string|max:255',
            'nama_belakang' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'no_wa' => 'required|string|max:255',
            'kecamatan' => 'required|string|max:255',
            'kelurahan' => 'required|string|max:255',
            'paket' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $id = $request->input('id');

        // Update data di database
        $data = RegisterModel::findOrFail($id);
        $data->nama_depan = $request->nama_depan;
        $data->nama_belakang = $request->nama_belakang;
        $data->alamat = $request->alamat;
        $data->no_wa = $request->no_wa;
        $data->kecamatan = $request->kecamatan;
        $data->kelurahan = $request->kelurahan;
        $data->paket = $request->paket;
        $simpan = $data->save();

        $message = $id ? 'Data register berhasil diperbarui.' : 'Data register berhasil disimpan.';

        if ($simpan) {
            return redirect()->route('admin-pendaftaran')->with([
                'message' => $message,
                'alert-type' => 'success'
            ]);
        } else {
            return redirect()->route('admin-pendaftaran')->with([
                'message' => 'Data paket gagal disimpan.',
                'alert-type' => 'error'
            ]);
        }
    }
}
