<?php

namespace App\Http\Controllers;

use App\Http\Library\WaNotification;
use App\Models\PaketModel;
use App\Models\RegisterModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    use WaNotification;

    public function index()
    {
        date_default_timezone_set('Asia/Jakarta');
        $data['year'] = date("Y");
        $data['data_paket'] = PaketModel::where('status', 1)->get();
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
        $user->save();

        //mengambil nama paket
        $paket = PaketModel::find($request->paket);

        // Send data klien
        // $clients = collect([
        //     (object)[
        //         'nama' => $request->nama_depan . ' ' . $request->nama_belakang,
        //         'alamat' => $request->alamat,
        //         'paket' => $paket ? $paket->nama : 'Belum dipilih',
        //         'biaya_pemasangan' => 'Rp. ' . number_format($paket->registrasi, 0, ',', '.'),
        //         'no_telp' => $request->no_wa,
        //     ],
        // ]);

        // $responses = [];

        // foreach ($clients as $client) {
        //     $response = $this->sendToClient($client);
        //     $responses[] = $response;
        // }

        // // Send data registrasi
        // $registrations = collect([
        //     (object)[
        //         'nama' => $request->nama_depan . ' ' . $request->nama_belakang,
        //         'alamat' => $request->alamat,
        //         'kelurahan' => $request->kelurahan,
        //         'kecamatan' => $request->kecamatan,
        //         'nomor_whatsapp' => $request->no_wa,
        //         'paket' => $paket ? $paket->nama : 'Belum dipilih',
        //         'biaya_pemasangan' => 'Rp. ' . number_format($paket->registrasi, 0, ',', '.'),
        //         'rekomendasi' => $request->rekomendasi
        //     ],
        // ]);

        // $responses = [];

        // foreach ($registrations as $registration) {
        //     $response = $this->sendToAdmin($registration);
        //     $responses[] = $response;
        // }

        // Redirect atau berikan respons bahwa data berhasil disimpan
        return redirect()->route('register')->with([
            'message' => 'Data anda sudah berhasil di register.',
            'alert-type' => 'success'
        ]);
    }
}
