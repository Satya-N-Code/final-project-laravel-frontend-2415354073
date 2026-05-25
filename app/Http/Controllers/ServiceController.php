<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ServiceController extends Controller
{
    public function index()
    {
        // Mengambil Base URL dari file .env
        $baseUrl = env('API_BASE_URL', 'http://127.0.0.1:8000/api');
        
        // Memanggil endpoint Get All Services
        $response = Http::get($baseUrl . '/services');
        
        $services = [];
        
        // Jika request sukses
        if ($response->successful()) {
            $services = $response->json('data'); 
        }

        // Lempar data ke view blade
        return view('services.index', compact('services'));
    }
}