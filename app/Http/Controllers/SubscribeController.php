<?php

/**
 * File: SubscribeController.php
 * Description: Handles email subscription via Brevo API
 * Copyright: 2025 Cloudmanic Labs, LLC
 * Date: 2025-12-18
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SubscribeController extends Controller
{
    /**
     * Store a new email subscription via Brevo API.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $apiKey = config('services.brevo.api_key');
        $listId = config('services.brevo.list_id');

        // If Brevo is not configured, just redirect to success
        if (empty($apiKey) || empty($listId)) {
            Log::warning('Brevo not configured. Skipping subscription.');
            return redirect()->route('success');
        }

        try {
            $response = Http::withHeaders([
                'api-key' => $apiKey,
                'Content-Type' => 'application/json',
            ])->post('https://api.brevo.com/v3/contacts', [
                'email' => $request->email,
                'listIds' => [(int) $listId],
                'updateEnabled' => true,
            ]);

            // Check for success (201 Created or 204 No Content for existing contact)
            if ($response->successful() || $response->status() === 204) {
                return redirect()->route('success');
            }

            // Handle duplicate contact (already subscribed)
            if ($response->status() === 400) {
                $body = $response->json();
                if (isset($body['code']) && $body['code'] === 'duplicate_parameter') {
                    return redirect()->route('success');
                }
            }

            // Log the error and redirect back with error message
            Log::error('Brevo subscription failed: ' . $response->body());
            return redirect()->back()->with('error', 'Unable to subscribe. Please try again later.');

        } catch (\Exception $e) {
            Log::error('Brevo API error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Unable to subscribe. Please try again later.');
        }
    }
}
