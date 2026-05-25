<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CustomerController extends Controller
{
    public function index()
    {
        // Mengambil Base URL dari file .env (http://127.0.0.1:8000/api)
        $baseUrl = env('API_BASE_URL', 'http://127.0.0.1:8000/api');
        
        // Memanggil endpoint Get All Data
        $response = Http::get($baseUrl . '/customers');
        
        $customers = [];
        
        // Jika request sukses (status 200)
        if ($response->successful()) {
            // Karena respons JSON kita dulu terstruktur, kita ambil properti "data"-nya saja
            $customers = $response->json('data'); 
        }

        // Lempar data ke view blade
        return view('customers.index', compact('customers'));
    }
}