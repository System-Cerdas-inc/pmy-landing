<?php

namespace App\Http\Controllers;

use App\Models\PaketModel;
use App\Models\RegisterModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function index()
    {
        date_default_timezone_set('Asia/Jakarta');
        $data['year'] = date("Y");
        $data['data_paket'] = PaketModel::where('status', 1)->get();
        return view('register', $data);
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

        // Redirect atau berikan respons bahwa data berhasil disimpan
        return redirect()->route('register')->with([
            'message' => 'Data anda sudah berhasil di register.',
            'alert-type' => 'success'
        ]);
    }
}
