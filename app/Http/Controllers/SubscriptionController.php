<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SubscriptionController extends Controller
{
    public function index()
    {
        $baseUrl = env('API_BASE_URL', 'http://127.0.0.1:8000/api');
        
        $response = Http::get($baseUrl . '/subscriptions');
        $subscriptions = $response->successful() ? $response->json('data') : [];

        $customers = Http::get($baseUrl . '/customers')->successful() ? Http::get($baseUrl . '/customers')->json('data') : [];
        $services = Http::get($baseUrl . '/services')->successful() ? Http::get($baseUrl . '/services')->json('data') : [];

        return view('subscriptions.index', compact('subscriptions', 'customers', 'services'));
    }

    public function store(Request $request)
    {
        $baseUrl = env('API_BASE_URL', 'http://127.0.0.1:8000/api');
        
        $response = Http::acceptJson()->post($baseUrl . '/subscriptions', $request->except('_token'));

        if ($response->status() === 422) {
            $validationErrors = $response->json('errors') ?? $response->json('data') ?? [];
            return back()->withErrors($validationErrors)->withInput();
        }

        if ($response->successful() && $response->json('success') === true) {
            return redirect()->route('subscriptions.index')->with('success', 'Subscription added successfully!');
        }

        $errorMessage = $response->json('message') ?? 'Backend Error (Status: ' . $response->status() . ') - Failed to add subscription.';
        return back()->with('error', $errorMessage)->withInput();
    }

    public function update(Request $request, $id)
    {
        $baseUrl = env('API_BASE_URL', 'http://127.0.0.1:8000/api');
        
        $response = Http::acceptJson()->put($baseUrl . '/subscriptions/' . $id, $request->except(['_token', '_method']));

        if ($response->status() === 422) {
            $validationErrors = $response->json('errors') ?? $response->json('data') ?? [];
            return back()->withErrors($validationErrors)->withInput();
        }

        if ($response->successful() && $response->json('success') === true) {
            return redirect()->route('subscriptions.index')->with('success', 'Subscription updated successfully!');
        }

        $errorMessage = $response->json('message') ?? 'Backend Error (Status: ' . $response->status() . ') - Failed to update subscription.';
        return back()->with('error', $errorMessage)->withInput();
    }

    public function updateStatus(Request $request, $id)
    {
        $baseUrl = env('API_BASE_URL', 'http://127.0.0.1:8000/api');
        $response = Http::acceptJson()->put($baseUrl . '/subscriptions/' . $id, [
            'status' => $request->status
        ]);

        if ($response->successful()) {
            return back()->with('success', 'Subscription status updated successfully!');
        }

        $errorMessage = $response->json('message') ?? 'Failed to update status.';
        return back()->with('error', $errorMessage);
    }

    public function destroy($id)
    {
        $baseUrl = env('API_BASE_URL', 'http://127.0.0.1:8000/api');
        
        $response = Http::acceptJson()->delete($baseUrl . '/subscriptions/' . $id);

        if ($response->successful()) {
            return back()->with('success', 'Subscription deleted successfully!');
        }

        $errorMessage = $response->json('message') ?? 'Failed to delete subscription.';
        return back()->with('error', $errorMessage);
    }
}