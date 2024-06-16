<?php

namespace App\Http\Controllers;

use App\Http\Library\WaNotification;
use App\Models\PaketModel;
use App\Models\PostinganModel;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    use WaNotification;

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

    public function testWa()
    {
        // Contoh data klien
        $clients = collect([
            (object)[
                'nama' => 'John Doe',
                'alamat' => 'Jl. Kebon Jeruk No. 123',
                'paket' => 'Paket A',
                'biaya' => '500.000',
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
}
