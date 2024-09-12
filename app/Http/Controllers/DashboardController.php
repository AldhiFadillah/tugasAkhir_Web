<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Exceptions;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

#[Middleware(AttachApiToken::class)]
class DashboardController extends Controller
{
    public function index(){
        $user = Session::get('user');
        return view('dashboard.index', compact('user'));
    }

    public function user(){
        $user = Session::get('user');

        return view('dashboard.user', compact('user'));
    }

    public function dataUser(Request $request){
        $accessToken = Session::get('api_token');
        try{
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $accessToken
            ])->get('http://127.0.0.1:8000/api/dataUser');

            if ($response->successful()) {
                $result = $response->json()['data'];

                // Ambil draw dari request DataTables
                $draw = $request->input('draw');
                $recordsTotal = count($result); // Total data sebelum filter (bisa disesuaikan sesuai jumlah asli data di server)
                $recordsFiltered = $recordsTotal; // Total data setelah filter (misalnya, setelah pencarian, pagination)
            } else {
                return response()->json([
                    'draw' => $request->input('draw'),
                    'recordsTotal' => 0,
                    'recordsFiltered' => 0,
                    'data' => []
                ]);
            }

        }catch(Exceptions $e){
            dd($e);
        }

        return response()->json([
            'draw' => intval($draw),
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'data' => $result
        ]);
    }

    public function createUser(){
        $accessToken = Session::get('api_token');
        try{
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $accessToken
            ])->get('http://127.0.0.1:8000/api/createUser');

            if ($response->successful()) {
                $result = $response->json()['data'];
            }

        }catch(Exceptions $e){
            dd($e);
        }
        return response()->json(['data' => $result]);
    }

    public function deleteUser(string $id){

    }
}
