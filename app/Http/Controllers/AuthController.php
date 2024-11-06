<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Tambahkan ini

class AuthController extends Controller
{
    public function login()
    {
        // Memeriksa apakah pengguna sudah login
        if (Auth::check()) {
            return redirect('/'); // Redirect ke halaman utama jika sudah login
        }
        return view('auth.login'); // Menampilkan halaman login
    }
}
