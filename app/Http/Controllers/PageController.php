<?php

/**
 * File: PageController.php
 * Description: Handles page rendering for the Sherwood Laundry website
 * Copyright: 2025 Cloudmanic Labs, LLC
 * Date: 2025-12-18
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * Display the landing page.
     *
     * @return \Illuminate\View\View
     */
    public function landing()
    {
        return view('pages.landing');
    }

    /**
     * Display the success page after email signup.
     *
     * @return \Illuminate\View\View
     */
    public function success()
    {
        return view('pages.success');
    }

    /**
     * Display the privacy policy page.
     *
     * @return \Illuminate\View\View
     */
    public function privacyPolicy()
    {
        return view('pages.privacy-policy');
    }

    /**
     * Display the terms of service page.
     *
     * @return \Illuminate\View\View
     */
    public function terms()
    {
        return view('pages.terms');
    }

    /**
     * Display the refund policy page.
     *
     * @return \Illuminate\View\View
     */
    public function refundPolicy()
    {
        return view('pages.refund-policy');
    }
}
