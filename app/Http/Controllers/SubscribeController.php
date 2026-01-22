<?php

/**
 * File: SubscribeController.php
 * Description: Handles email subscription via Sendy API
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
     * Store a new email subscription via Sendy API.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $sendyUrl = config('services.sendy.url');
        $apiKey = config('services.sendy.api_key');
        $listId = config('services.sendy.list_id');

        // If Sendy is not configured, just redirect to success
        if (empty($sendyUrl) || empty($apiKey) || empty($listId)) {
            Log::warning('Sendy not configured. Skipping subscription.');

            return redirect()->route('success');
        }

        try {
            $response = Http::asForm()->post("{$sendyUrl}/subscribe", [
                'api_key' => $apiKey,
                'email' => $request->email,
                'list' => $listId,
                'boolean' => 'true',
            ]);

            $result = $response->body();

            // Check for success
            if ($result === 'true' || $result === '1' || str_contains($result, 'Already subscribed')) {
                return redirect()->route('success');
            }

            // Log the error and redirect back with error message
            Log::error('Sendy subscription failed: '.$result);

            return redirect()->back()->with('error', 'Unable to subscribe. Please try again later.');

        } catch (\Exception $e) {
            Log::error('Sendy API error: '.$e->getMessage());

            return redirect()->back()->with('error', 'Unable to subscribe. Please try again later.');
        }
    }
}
