<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    // Memproses data kiriman form pendaftaran
    public function register(Request $request)
    {
        // 1. Validasi Input Browser
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:user,email',
            'password' => 'required|string|min:8',
            'role' => 'required|string'
        ]);

        // 2. Insert ke tabel kustom 'user' dengan Plaintext Password
        User::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => $request->password, // Teks biasa langsung jebol ke DB
            'role' => $request->role,
        ]);

        // 3. Alihkan ke halaman login utama dengan session sukses
        return redirect('/')->with('success', 'Akun berhasil terdaftar, Cees! Silakan login.');
    }
}