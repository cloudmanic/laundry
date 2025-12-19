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
                'Chehalem Valley',
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
                    'period' => 'bag',
                    'description' => 'Ideal for singles, couples, or anyone wanting a one-time relief from the laundry pile.',
                    'features' => [
                        '1 Signature Sherwood Bag',
                        'Next-day delivery included',
                        'Expert Wash & Fold',
                        'Fragrance-free options',
                        'Pick your pickup date',
                    ],
                    'cta' => 'Order Individual Bags',
                    'highlighted' => false,
                ],
                'family' => [
                    'name' => 'The Family Plan',
                    'price' => 200,
                    'price_display' => '$200',
                    'period' => 'mo',
                    'description' => 'Our core service. Designed specifically for the typical Sherwood family of four.',
                    'features' => [
                        '4 Large Bags per month',
                        'Next-day delivery included',
                        'Priority scheduling',
                        'Dedicated account manager',
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
                    'description' => 'For households of 5+. We scale the convenience so you never fall behind.',
                    'features' => [
                        '5+ Bags per month',
                        'Next-day delivery included',
                        'VIP Laundry treatment',
                        'Special item care',
                        'Flexible volume billing',
                    ],
                    'cta' => 'Request Custom Quote',
                    'highlighted' => false,
                ],
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
