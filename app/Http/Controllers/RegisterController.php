<?php

namespace App\Http\Controllers;

// use App\Http\Library\WaNotification as LibraryWaNotification;

use App\Helpers\WaNotification;
use App\Models\PaketModel;
use App\Models\RegisterModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    protected $WaNotification;

    public function __construct()
    {
        $this->WaNotification = new WaNotification();
    }

    public function index()
    {
        date_default_timezone_set('Asia/Jakarta');
        $data['year'] = date("Y");
        $data['data_paket'] = PaketModel::where('status', 1)->get();
        return view('register', $data);
    }

    public function test()
    {
        $client = [
            'nama' => 'Test',
            'alamat' => 'Alamat',
            'paket' => "Paket Happy",
            'biaya_pemasangan' => 'Rp. 200.000',
            'no_telp' => '+6283834581221',
        ];

        try {
            $response = $this->WaNotification->sendToClient((object) $client);

            if ($response->status) {
                return response()->json([
                    'success' => true,
                    'message' => 'Notifikasi berhasil dikirim ke klien.'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal mengirim notifikasi ke klien.'
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function register(Request $request)
    {
        // Validasi data yang diterima dari formulir
        $validator_sk = Validator::make($request->all(), [
            'syarat_dan_ketentuan' => 'required', // Menambahkan validasi untuk checkbox
        ]);
        if ($validator_sk->fails()) {
            return redirect()->back()->with([
                'message' => 'Anda belum menyetujui syarat dan ketentuan yang berlaku.',
                'alert-type' => 'error'
            ])->withInput();
        }

        // Validasi data
        $validator = Validator::make($request->all(), [
            'nama_depan' => 'required|string|max:255',
            'nama_belakang' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'no_wa' => 'required|string|max:255',
            'kecamatan' => 'required|string|max:255',
            'kelurahan' => 'required|string|max:255',
            'paket' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Simpan data ke database atau proses data lebih lanjut
        // Contoh: menyimpan data pengguna baru
        $user = new RegisterModel();
        $user->nama_depan = $request->nama_depan;
        $user->nama_belakang = $request->nama_belakang;
        $user->alamat = $request->alamat;
        $user->no_wa = $request->no_wa;
        $user->kecamatan = $request->kecamatan;
        $user->kelurahan = $request->kelurahan;
        $user->paket = $request->paket;
        $user->save();

        //mengambil nama paket
        $paket = PaketModel::find($request->paket);

        $client = (object) [
            'nama' => $request->nama_depan . ' ' . $request->nama_belakang,
            'alamat' => $request->alamat,
            'paket' => $paket ? $paket->nama : 'Belum dipilih',
            'biaya_pemasangan' => 'Rp. ' . number_format($paket->registrasi, 0, ',', '.'),
            'no_telp' => $request->no_wa,
        ];
        $this->WaNotification->sendToClient($client);

        // Redirect atau berikan respons bahwa data berhasil disimpan
        return redirect()->route('register')->with([
            'message' => 'Data anda sudah berhasil di register.',
            'alert-type' => 'success'
        ]);
    }
}