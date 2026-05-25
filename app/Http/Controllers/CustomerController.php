<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CustomerController extends Controller
{
    public function index()
    {
        $baseUrl = env('API_BASE_URL', 'http://127.0.0.1:8000/api');
        $response = Http::get($baseUrl . '/customers');
        
        $customers = $response->successful() ? $response->json('data') : [];

        return view('customers.index', compact('customers'));
    }

    public function store(Request $request)
    {
        $baseUrl = env('API_BASE_URL', 'http://127.0.0.1:8000/api');
        
        $response = Http::acceptJson()->post($baseUrl . '/customers', $request->except('_token'));

        if ($response->status() === 422) {
            $validationErrors = $response->json('errors') ?? $response->json('data') ?? [];
            return back()->withErrors($validationErrors)->withInput();
        }

        if ($response->successful() && $response->json('success') === true) {
            return redirect()->route('customers.index')->with('success', 'Customer added successfully!');
        }

        $errorMessage = $response->json('message') ?? 'Backend Error (Status: ' . $response->status() . ') - Failed to add customer.';
        return back()->with('error', $errorMessage)->withInput();
    }

    public function update(Request $request, $id)
    {
        $baseUrl = env('API_BASE_URL', 'http://127.0.0.1:8000/api');
        
        $response = Http::acceptJson()->put($baseUrl . '/customers/' . $id, $request->except(['_token', '_method']));

        if ($response->status() === 422) {
            $validationErrors = $response->json('errors') ?? $response->json('data') ?? [];
            return back()->withErrors($validationErrors)->withInput();
        }

        if ($response->successful() && $response->json('success') === true) {
            return redirect()->route('customers.index')->with('success', 'Customer updated successfully!');
        }

        $errorMessage = $response->json('message') ?? 'Backend Error (Status: ' . $response->status() . ') - Failed to update customer.';
        return back()->with('error', $errorMessage)->withInput();
        }

        public function updateStatus(Request $request, $id)
    {
        $baseUrl = env('API_BASE_URL', 'http://127.0.0.1:8000/api');
        
        $response = Http::acceptJson()->put($baseUrl . '/customers/' . $id, [
            'status' => $request->status
        ]);

        if ($response->successful()) {
            return back()->with('success', 'Customer status updated successfully!');
        }

        $errorMessage = $response->json('message') ?? 'Failed to update status.';
        return back()->with('error', $errorMessage);
    }

    public function destroy($id)
    {
        $baseUrl = env('API_BASE_URL', 'http://127.0.0.1:8000/api');
        
        $response = Http::acceptJson()->delete($baseUrl . '/customers/' . $id);

        if ($response->successful()) {
            return back()->with('success', 'Customer deleted successfully!');
        }

        $errorMessage = $response->json('message') ?? 'Failed to delete customer.';
        return back()->with('error', $errorMessage);
    }
}