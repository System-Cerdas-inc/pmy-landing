<?php

namespace App\Http\Controllers;

use App\Models\PaketModel;
use Illuminate\Http\Request;
use App\Models\RegisterModel;
use App\Http\Library\WaNotification;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    use WaNotification;

    public function index()
    {
        date_default_timezone_set('Asia/Jakarta');
        $data['year'] = date("Y");
        $data['nama_menu'] = "Register";
        $data['data_paket'] = PaketModel::where('status', 1)->get();
        $data['package_id'] = request()->package ? Crypt::decrypt(request()->package) : null;
        return view('register', $data);
    }

    public function test()
    {
        // Contoh data klien
        $clients = collect([
            (object)[
                'nama' => 'John Doe',
                'alamat' => 'Jl. Kebon Jeruk No. 123',
                'paket' => 'Paket A',
                'biaya_pemasangan' => '500.000',
                'no_telp' => '6281226260649'
            ],
        ]);

        $responses = [];

        foreach ($clients as $client) {
            $response = $this->sendToClient($client);
            $responses[] = $response;
        }

        return response()->json($responses);
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
        $user->rekomendasi = $request->rekomendasi;
        $user->status = '1';
        $user->save();

        //mengambil nama paket
        $paket = PaketModel::find($request->paket);

        // Send data klien
        $client = (object)[
            'nama' => $request->nama_depan . ' ' . $request->nama_belakang,
            'alamat' => $request->alamat,
            'paket' => $paket ? $paket->nama : 'Belum dipilih',
            'biaya_pemasangan' => 'Rp. ' . number_format($paket->registrasi, 0, ',', '.'),
            'no_telp' => $this->cleanNumber($request->no_wa)
        ];

        $this->sendToClient($client);


        // Send data registrasi
        $registration = (object)[
            'nama' => $request->nama_depan . ' ' . $request->nama_belakang,
            'alamat' => $request->alamat,
            'kelurahan' => $request->kelurahan,
            'kecamatan' => $request->kecamatan,
            'nomor_whatsapp' => $this->cleanNumber($request->no_wa),
            'paket' => $paket ? $paket->nama : 'Belum dipilih',
            'biaya_pemasangan' => 'Rp. ' . number_format($paket->registrasi, 0, ',', '.'),
            'rekomendasi' => $request->rekomendasi
        ];


        $this->sendToAdmin($registration);


        // Redirect atau berikan respons bahwa data berhasil disimpan
        return redirect()->route('register')->with([
            'message' => 'Data anda sudah berhasil di register.',
            'alert-type' => 'success'
        ]);
    }

    //buat function untuk clean nomor whatsapp pake regex
    public function cleanNumber($number)
    {
        //- hapus spasi, strip, dan karakter selain angka
        $cleaned = preg_replace('/[^0-9]/', '', $number);
        return $cleaned;
    }
}
