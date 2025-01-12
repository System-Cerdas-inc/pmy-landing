<?php

namespace App\Http\Controllers;

use App\Models\PaketModel;
use Illuminate\Http\Request;
use App\Models\PostinganModel;
use Illuminate\Support\Facades\DB;
use App\Http\Library\WaNotification;

class HomeController extends Controller
{
    use WaNotification;

    public function index()
    {
        date_default_timezone_set('Asia/Jakarta');
        $data['year'] = date("Y");
        $data['nama_menu'] = "Home";

        $postingan = PostinganModel::where('jenis', 'Harga Dashboard')
            ->orderBy('created_at', 'desc') // Urutkan berdasarkan created_at secara descending (terbaru dulu)
            ->first(); // Ambil data pertama yang cocok dengan kriteria di atas

        $data['data_paket'] = PaketModel::select('*', DB::raw('COALESCE(urutan, 999) as urutan_temp'))
            ->where('jenis', 'Promo')->take(4)
            ->orderBy('urutan_temp', 'asc')->where('status', '1')
            ->get();
        $data['data_postingan'] = PostinganModel::where('jenis', 'Video')->get();
        $data['data_postingan_harga'] = '0';

        if ($postingan) {
            if (is_numeric($postingan->judul)) {
                $data['data_postingan_harga'] = number_format($postingan->judul, 0, ',', '.');
            } else {
                $data['data_postingan_harga'] = '0';
            }
        }
        return view('home', $data);
    }

    public function index_sk()
    {
        date_default_timezone_set('Asia/Jakarta');
        $data['nama_menu'] = "Sarat dan Ketentuan";
        $data['year'] = date("Y");
        return view('sk', $data);
    }

    public function testWaClient()
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

    public function testWaAdmin()
    {
        // Contoh data registrasi
        $registrations = collect([
            (object)[
                'nama' => 'John Doe',
                'alamat' => 'Jl. Kebon Jeruk No. 123',
                'kelurahan' => 'Kebon Jeruk',
                'kecamatan' => 'Kebon Jeruk',
                'nomor_whatsapp' => '6281226260649',
                'paket' => 'Paket A',
                'biaya_pemasangan' => '500.000',
                'rekomendasi' => 'Teman'
            ],
        ]);

        $responses = [];

        foreach ($registrations as $registration) {
            $response = $this->sendToAdmin($registration);
            $responses[] = $response;
        }

        return response()->json($responses);
    }
}
