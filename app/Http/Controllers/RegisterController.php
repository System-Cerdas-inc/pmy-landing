<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function index()
    {
        date_default_timezone_set('Asia/Jakarta');
        $data['year'] = date("Y");
        return view('register', $data);
    }
}
