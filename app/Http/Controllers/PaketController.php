<?php

namespace App\Http\Controllers;

use App\Models\PaketModel;
use Illuminate\Http\Request;

class PaketController extends Controller
{
    public function index()
    {
        date_default_timezone_set('Asia/Jakarta');
        $data['year'] = date("Y");
        $data['nama_menu'] = "Paket";
        $data['data_paket'] = PaketModel::where('status', '1')->get();
        return view('paket', $data);
    }
}
