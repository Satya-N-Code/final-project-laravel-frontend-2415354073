<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http; // Pastikan ini di-import

class SubscriptionController extends Controller
{
    public function index()
    {
        // Mengambil Base URL dari file .env
        $baseUrl = env('API_BASE_URL', 'http://127.0.0.1:8000/api');
        
        // Memanggil endpoint Get All Subscriptions
        $response = Http::get($baseUrl . '/subscriptions');
        
        $subscriptions = [];
        
        if ($response->successful()) {
            $subscriptions = $response->json('data'); 
        }

        // Lempar data ke view blade
        return view('subscriptions.index', compact('subscriptions'));
    }
}