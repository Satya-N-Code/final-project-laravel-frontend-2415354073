<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ServiceController extends Controller
{
    public function index()
    {
        $baseUrl = env('API_BASE_URL', 'http://127.0.0.1:8000/api');
        $response = Http::get($baseUrl . '/services');
        $services = $response->successful() ? $response->json('data') : [];

        return view('services.index', compact('services'));
    }

    public function store(Request $request)
    {
        $baseUrl = env('API_BASE_URL', 'http://127.0.0.1:8000/api');
        
        $response = Http::acceptJson()->post($baseUrl . '/services', $request->except('_token'));

        if ($response->status() === 422) {
            $validationErrors = $response->json('errors') ?? $response->json('data') ?? [];
            return back()->withErrors($validationErrors)->withInput();
        }

        if ($response->successful() && $response->json('success') === true) {
            return redirect()->route('services.index')->with('success', 'Service added successfully!');
        }

        $errorMessage = $response->json('message') ?? 'Backend Error (Status: ' . $response->status() . ') - Failed to add service.';
        return back()->with('error', $errorMessage)->withInput();
    }

    public function update(Request $request, $id)
    {
        $baseUrl = env('API_BASE_URL', 'http://127.0.0.1:8000/api');
        
        $response = Http::acceptJson()->put($baseUrl . '/services/' . $id, $request->except(['_token', '_method']));

        if ($response->status() === 422) {
            $validationErrors = $response->json('errors') ?? $response->json('data') ?? [];
            return back()->withErrors($validationErrors)->withInput();
        }

        if ($response->successful() && $response->json('success') === true) {
            return redirect()->route('services.index')->with('success', 'Service updated successfully!');
        }

        $errorMessage = $response->json('message') ?? 'Backend Error (Status: ' . $response->status() . ') - Failed to update service.';
        return back()->with('error', $errorMessage)->withInput();
    }

    public function updateStatus(Request $request, $id)
    {
        $baseUrl = env('API_BASE_URL', 'http://127.0.0.1:8000/api');
        
        $response = Http::acceptJson()->put($baseUrl . '/services/' . $id, [
            'status' => $request->status
        ]);

        if ($response->successful()) {
            return back()->with('success', 'Service status updated successfully!');
        }

        $errorMessage = $response->json('message') ?? 'Failed to update status.';
        return back()->with('error', $errorMessage);
    }

    public function destroy($id)
    {
        $baseUrl = env('API_BASE_URL', 'http://127.0.0.1:8000/api');
        
        $response = Http::acceptJson()->delete($baseUrl . '/services/' . $id);

        if ($response->successful()) {
            return back()->with('success', 'Service deleted successfully!');
        }

        $errorMessage = $response->json('message') ?? 'Failed to delete service.';
        return back()->with('error', $errorMessage);
    }
}