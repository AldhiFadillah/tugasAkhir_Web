<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        $user = Session::get('user');
        if($user != null)
            return redirect()->route('dashboard');

        return view('auth.login'); // menampilkan view form login
    }

    public function login(Request $request)
    {
        // validasi form
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        // kirim request ke API untuk autentikasi
        $response = Http::post('http://127.0.0.1:8000/api/login', [
            'username' => $request->username,
            'password' => $request->password,
        ]);

        if ($response->successful()) {
            // jika berhasil, ambil token dari response
            $token = $response->json()['access_token'];
            $refresh_token = $response->json()['refresh_token'];
            $user = $response->json()['user'];

            // simpan token ke session
            Session::put('api_token', $token);
            Session::put('refresh_token', $refresh_token);
            Session::put('user', $user);

            return redirect()->route('dashboard'); // redirect ke halaman setelah login
        } else {
            // jika gagal, tampilkan pesan error
            return back()->withErrors([
                'email' => 'Email atau password salah.',
            ]);
        }
    }

    public function logout()
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . Session::get('api_token')
        ])->get('http://127.0.0.1:8000/api/logout');
        if ($response->successful()) {
            // jika berhasil, hapus token dari session
            Session::forget('api_token');
            Session::forget('refresh_token');
            Session::forget('user');

            return redirect()->route('login');
        } else {
            // jika gagal, tampilkan pesan error
            return back()->withErrors([
                'error' => $response->json('message', 'Logout gagal, coba lagi.'), // Ambil pesan dari response JSON
            ]);
        }
    }
}
