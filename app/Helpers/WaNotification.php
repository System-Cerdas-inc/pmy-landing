<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;

class WaNotification
{
    public function sendToAdmin($nama, $no_telp, $url)
    {
        $message = "Your message{nl}";
        $message .= "Your message *" . $nama . "*{nl}{nl}";

        $body = str_replace('{nl}', '%0a', $message);

        try {
            $response = $this->sendMessage($no_telp, $body);
            return $response;
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }
    }

    public function sendToClient($client)
    {
        $message = "Terimaksih sudah mendaftar untuk pemasangan internet,{nl}{nl}";
        $message .= "Nama : *" . $client->nama . "*{nl}";
        $message .= "Alamat : *" . $client->alamat . "*{nl}";
        $message .= "Paket : *" . $client->paket . "*{nl}";
        $message .= "Biaya Pemasangan : *" . $client->biaya_pemasangan . "*{nl}";
        $message .= "data sudah diterima, akan segera kami kabarin kembali ke nomer yang didaftarkan untuk jadwal pemasangannya.{nl}{nl}";
        $message .= "Terima kasih.{nl}";

        $body = str_replace('{nl}', '%0a', $message);

        try {
            $response = $this->sendMessage($client->no_telp, $body);
            return $response;
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }
    }

    public function sendMessage($number, $message)
    {
        $url = config('app.api_wa_host');
        $token = config('app.api_wa_token');

        try {
            $response = Http::timeout(120)
                ->withHeaders([
                    'Authorization' => 'Bearer ' . $token,
                    'Content-Type' => 'application/json',
                ])
                ->post($url, [
                    'recipient_type' => 'individual',
                    'to' => $number,
                    'type' => 'text',
                    'text' => [
                        'body' => urldecode($message)
                    ]
                ]);

            return json_decode($response->body());
        } catch (\Throwable $th) {
            return [
                'status' => false,
                'message' => "Terjadi kesalahan saat memproses permintaan {$th}"
            ];
        }
    }


    public function sendMessageWithCheck($number, $message)
    {
        $url = config('app.api_wa_host') . '/send';
        $token = config('app.api_wa_token');

        try {
            if (!$this->checkWaNumber($number)) {
                $response = Http::timeout(120)
                    ->withHeaders([
                        'Authorization' => $token,
                    ])
                    ->post($url, [
                        'target' => $number,
                        'message' => urldecode($message),
                        'delay' => '2',
                        'countryCode' => '62',
                    ]);

                return json_decode($response->body());
            }
        } catch (\Throwable $th) {
            return [
                'status' => false,
                'message' => "Terjadi kesalahan saat memproses permintaan {$th}"
            ];
        }
    }

    public function checkWaNumber($number)
    {
        $url = config('app.api_wa_host') . '/validate';
        $token = config('app.api_wa_token');

        try {
            $response = Http::timeout(120)
                ->withHeaders([
                    'Authorization' => $token,
                ])
                ->post($url, [
                    'target' => $number,
                    'countryCode' => '62',
                ]);

            $response = json_decode($response->body());
            return $response->not_registered;
        } catch (\Throwable $th) {
            return (object)[];
        }
    }
}
