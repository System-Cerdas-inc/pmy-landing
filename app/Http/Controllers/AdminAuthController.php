<?php

namespace App\Http\Controllers;

use App\Helpers\EncryptionHelper;
use App\Models\UsersModel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AdminAuthController extends Controller
{
    protected $encryptionHelper;

    public function __construct()
    {
        $this->encryptionHelper = new EncryptionHelper();
    }

    public function index()
    {
        date_default_timezone_set('Asia/Jakarta');
        $data['year'] = date("Y");
        return view('admin.auth', $data);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => [
                'required',
                'string',
                'email',
                'max:255'
            ],
            'password' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = UsersModel::where('email', $request->email)->first();

        if ($user && $this->checkPassword($request->password, $user->password)) {
            Auth::login($user);

            // Manually store user information in the session
            Session::put('user', [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
            ]);

            return redirect()->route('dashboard')->with([
                'message' => 'Selamat Datang, login berhasil.',
                'alert-type' => 'success'
            ]);
        }

        return redirect()->back()->with([
            'message' => 'Email dan password tidak ditemukan, coba lagi!.',
            'alert-type' => 'error'
        ]);
    }
    protected function checkPassword($inputPassword, $storedPassword)
    {
        $decryptedStoredPassword = $this->encryptionHelper->dekrip($storedPassword);
        return $inputPassword === $decryptedStoredPassword;
    }

    public function logout()
    {
        Auth::logout();
        Session::flush();
        return redirect()->route('auth')->with([
            'message' => 'Logged out successfully!',
            'alert-type' => 'success'
        ]);
    }
}
