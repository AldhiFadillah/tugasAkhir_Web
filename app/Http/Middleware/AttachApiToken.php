<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;

class AttachApiToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        if (!Session::has('api_token')) {
            return redirect()->route('login'); // jika tidak ada token, redirect ke login
        } else {
            try {
                $accessToken = Session::get('api_token');
                $refreshToken = Session::get('refresh_token');

                // Cek jika token masih valid
                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $accessToken
                ])->get('http://127.0.0.1:8000/api/user'); // Ganti dengan endpoint yang memeriksa token

                if ($response->successful()) {
                    // Token masih valid
                    return $next($request);
                }

                // Jika token expired atau tidak valid, coba refresh token
                if ($response->status() == 401) {
                    if (!$refreshToken) {
                        return response()->json(['message' => 'Refresh token not provided.'], 401);
                    }

                    // Refresh token
                    $refreshResponse = Http::withHeaders([
                        'Authorization' => 'Bearer ' . $accessToken
                    ])->post('http://127.0.0.1:8000/api/refresh-token', [
                        'refresh_token' => $refreshToken
                    ]);

                    if ($refreshResponse->successful()) {
                        $newAccessToken = $refreshResponse->json('access_token');
                        $newRefreshToken = $refreshResponse->json('refresh_token');

                        // Simpan token baru di session
                        Session::put('api_token', $newAccessToken);
                        // Coba lagi dengan token yang baru
                        $response = Http::withHeaders([
                            'Authorization' => 'Bearer ' . $newAccessToken
                        ])->get('http://127.0.0.1:8000/api/user');

                        if ($response->successful()) {
                            return $next($request);
                        }
                    }

                    // Jika refresh token gagal, logout
                    Session::forget('api_token');
                    Session::forget('refresh_token');

                    return redirect()->route('login');
                }
            } catch (TokenExpiredException $e) {
                // Jika token expired atau exception lainnya, logout
                Session::forget('api_token');
                Session::forget('refresh_token');

                return redirect()->route('login');
            }

            // Jika ada masalah lain
            return response()->json(['message' => 'Unauthorized.'], 401);
        }
    }
}
