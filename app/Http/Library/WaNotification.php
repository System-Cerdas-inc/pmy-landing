<?php

namespace App\Http\Library;

use Illuminate\Support\Facades\Http;

trait WaNotification
{
    protected function sendToAdmin($dataRegistrasi)
    {
        $message = "Pendaftaran Baru{nl}{nl}";
        $message .= "Nama : *" . $dataRegistrasi->nama . "*{nl}";
        $message .= "Alamat : *" . $dataRegistrasi->alamat . "*{nl}";
        $message .= "Kelurahan : *" . $dataRegistrasi->kelurahan . "*{nl}";
        $message .= "Kecamatan : *" . $dataRegistrasi->kecamatan . "*{nl}";
        $message .= "Nomor Whatsapp : *" . $dataRegistrasi->nomor_whatsapp . "*{nl}";
        $message .= "Paket : *" . $dataRegistrasi->paket . "*{nl}";
        $message .= "Biaya Pemasangan : *" . $dataRegistrasi->biaya_pemasangan . "*{nl}";
        $message .= "Rekomendasi dari : *" . $dataRegistrasi->rekomendasi . "*{nl}{nl}";

        $body = str_replace('{nl}', '%0a', $message);


        try {
            $response = $this->sendMessageGroup($body);
            return $response;
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }
    }

    protected function sendToAdminPasang($dataRegistrasi)
    {
        $message = "Silahkan lakukan pemasangan pada tanggal " . $dataRegistrasi->tanggal_pasang . ", untuk data pelangan berikut:{nl}{nl}";
        $message .= "Nama : *" . $dataRegistrasi->nama . "*{nl}";
        $message .= "Alamat : *" . $dataRegistrasi->alamat . "*{nl}";
        $message .= "Kelurahan : *" . $dataRegistrasi->kelurahan . "*{nl}";
        $message .= "Kecamatan : *" . $dataRegistrasi->kecamatan . "*{nl}";
        $message .= "Nomor Whatsapp : *" . $dataRegistrasi->nomor_whatsapp . "*{nl}";
        $message .= "Paket : *" . $dataRegistrasi->paket . "*{nl}";
        $message .= "Biaya Pemasangan : *" . $dataRegistrasi->biaya_pemasangan . "*{nl}";
        $message .= "Rekomendasi dari : *" . $dataRegistrasi->rekomendasi . "*{nl}{nl}";

        $body = str_replace('{nl}', '%0a', $message);


        try {
            $response = $this->sendMessageGroupPasang($body, );
            return $response;
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }
    }

    protected function sendToClient($client)
    {
        $message = "Terimaksih sudah mendaftar untuk pemasangan internet, di link paket.digitaljb.com{nl}{nl}";
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

    protected function sendMessage($number, $message)
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

    protected function sendMessageGroup($message)
    {
        $url = config('app.api_wa_host');
        $token = config('app.api_wa_token');
        $number = config('app.api_wa_group');

        try {
            $response = Http::timeout(120)
                ->withHeaders([
                    'Authorization' => 'Bearer ' . $token,
                    'Content-Type' => 'application/json',
                ])
                ->post($url, [
                    'recipient_type' => 'group',
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

    protected function sendMessageGroupPasang($message)
    {
        $url = config('app.api_wa_host');
        $token = config('app.api_wa_token');
        $number = config('app.api_wa_pasang_group');

        try {
            $response = Http::timeout(120)
                ->withHeaders([
                    'Authorization' => 'Bearer ' . $token,
                    'Content-Type' => 'application/json',
                ])
                ->post($url, [
                    'recipient_type' => 'group',
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


    protected function sendMessageWithCheck($number, $message)
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

    protected function checkWaNumber($number)
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
