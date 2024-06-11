<?php

namespace App\Helpers;

class EncryptionHelper
{
    public function enkrip($string)
    {
        $encrypt_method = "AES-256-CBC";
        $secret_key = 'AaBbCcDdEe12FfGgHhIiJj24KkLlMmNnOo00PpQqRrSsTt56UuVv06WwXxYyZz9';
        $secret_iv = 'DigitalJB@0624';
        $key = hash('sha256', $secret_key);
        $iv = substr(hash('sha256', $secret_iv), 0, 16);

        $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
        $output = base64_encode($output);
        return $output;
    }
    public function dekrip($string)
    {
        $encrypt_method = "AES-256-CBC";
        $secret_key = 'AaBbCcDdEe12FfGgHhIiJj24KkLlMmNnOo00PpQqRrSsTt56UuVv06WwXxYyZz9'; // user define private key
        $secret_iv = 'DigitalJB@0624'; // user define secret key
        $key = hash('sha256', $secret_key);
        $iv = substr(hash('sha256', $secret_iv), 0, 16); // sha256 is hash_hmac_algo

        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);

        return $output;
    }
}
