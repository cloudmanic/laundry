<?php

/**
 * File: city.php
 * Description: City-specific configuration for multi-city laundry service
 * Copyright: 2025 Cloudmanic Labs, LLC
 * Date: 2025-12-18
 *
 * This configuration supports multiple cities/domains. Each city has its own
 * branding, contact info, pricing, and service areas. The active city is
 * determined by the CITY_KEY environment variable.
 */

return [

    /*
    |--------------------------------------------------------------------------
    | Active City
    |--------------------------------------------------------------------------
    |
    | The currently active city configuration. This determines which city's
    | settings are used throughout the application.
    |
    */

    'active' => env('CITY_KEY', 'sherwood'),

    /*
    |--------------------------------------------------------------------------
    | City Configurations
    |--------------------------------------------------------------------------
    |
    | Each city has its own configuration including branding, contact info,
    | pricing plans, and service areas. Add new cities here as the business
    | expands to new markets.
    |
    */

    'cities' => [

        'sherwood' => [
            'name' => 'Sherwood',
            'brand' => 'Sherwood Laundry',
            'tagline' => 'Premium Pickup & Delivery',
            'domain' => 'sherwoodlaundry.com',
            'launch_date' => 'February 1st, 2026',

            'contact' => [
                'email' => 'help@sherwoodlaundry.com',
                'phone' => '503-451-0062',
                'address' => [
                    'street' => '901 Brutscher Street',
                    'suite' => 'D112',
                    'city' => 'Newberg',
                    'state' => 'OR',
                    'zip' => '97132',
                ],
                'address_display' => '901 Brutscher St, Newberg',
                'address_full' => '901 Brutscher Street, D112, Newberg, OR 97132',
            ],

            'service_areas' => [
                'Sherwood',
                'Newberg',
                'Dundee',
            ],

            'social' => [
                'facebook' => '#',
                'instagram' => '#',
            ],

            'pricing' => [
                'light' => [
                    'name' => 'Light Household',
                    'price' => 65,
                    'price_display' => '$65',
                    'period' => 'mo',
                    'description' => 'Perfect for singles or couples. One bag picked up and delivered every week.',
                    'features' => [
                        '1 bag picked up <span class="border-b-2 border-emerald-500">weekly</span>',
                        'Next-day delivery included',
                        'Expert Wash & Fold',
                        'Fragrance-free options',
                        '4 <span class="border-b-2 border-emerald-500">weekly</span> pickups per month',
                    ],
                    'cta' => 'Get Started',
                    'highlighted' => false,
                ],
                'family' => [
                    'name' => 'The Family Plan',
                    'price' => 200,
                    'price_display' => '$200',
                    'period' => 'mo',
                    'description' => 'Our most popular plan. Four bags picked up and delivered every week for your whole family.',
                    'features' => [
                        '4 bags picked up <span class="border-b-2 border-emerald-500">weekly</span>',
                        'Next-day delivery included',
                        'Priority scheduling',
                        '4 <span class="border-b-2 border-emerald-500">weekly</span> pickups per month',
                        'Extra bags only $50/ea',
                    ],
                    'cta' => 'Join the Family',
                    'highlighted' => true,
                    'extra_bag_price' => 50,
                ],
                'grand' => [
                    'name' => 'Grand Household',
                    'price' => 250,
                    'price_display' => '$250+',
                    'period' => 'mo',
                    'description' => 'For larger households of 5+. Five or more bags picked up and delivered every week.',
                    'features' => [
                        '5+ bags picked up <span class="border-b-2 border-emerald-500">weekly</span>',
                        'Next-day delivery included',
                        'VIP Laundry treatment',
                        '4 <span class="border-b-2 border-emerald-500">weekly</span> pickups per month',
                        'Flexible volume billing',
                    ],
                    'cta' => 'Request Custom Quote',
                    'highlighted' => false,
                ],
            ],

            'social_proof' => [
                'families_joined' => 142,
            ],

            'testimonial' => [
                'quote' => "As a mom of three in Sherwood, Sherwood Laundry didn't just clean my clothes—they gave me my Sundays back.",
                'author' => 'Sarah J.',
                'location' => 'Sherwood Resident',
            ],
        ],

        // Future cities can be added here:
        // 'bend' => [...],
        // 'newberg' => [...],

    ],

];
