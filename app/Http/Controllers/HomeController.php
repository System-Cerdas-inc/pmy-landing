<?php

namespace App\Http\Controllers;

use App\Models\PaketModel;
use App\Models\PostinganModel;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        date_default_timezone_set('Asia/Jakarta');
        $data['year'] = date("Y");

        $postingan = PostinganModel::where('jenis', 'Harga Dashboard')
            ->orderBy('created_at', 'desc') // Urutkan berdasarkan created_at secara descending (terbaru dulu)
            ->first(); // Ambil data pertama yang cocok dengan kriteria di atas

        $data['data_paket'] = PaketModel::take(3)->get();
        $data['data_postingan'] = PostinganModel::where('jenis', 'Video')->get();
        $data['data_postingan_harga'] = $postingan->judul;
        return view('home', $data);
    }

    public function index_sk()
    {
        date_default_timezone_set('Asia/Jakarta');
        $data['year'] = date("Y");
        return view('sk', $data);
    }
}
