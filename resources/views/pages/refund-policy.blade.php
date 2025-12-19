{{--
    File: refund-policy.blade.php
    Description: Refund policy page
    Copyright: 2025 Cloudmanic Labs, LLC
    Date: 2025-12-18
--}}
@extends('layouts.app')

@section('title', 'Refund Policy | ' . $city['brand'])

@section('content')
    @include('components.header')

    <main class="pt-32 pb-20">
        <div class="container mx-auto px-4 max-w-3xl">
            <h1 class="text-4xl font-bold mb-4 text-slate-900">Refund Policy</h1>
            <p class="text-slate-500 mb-12">Last Updated: December 18, 2025</p>

            <div class="prose prose-slate max-w-none">
                <p class="text-lg text-slate-600 mb-8">
                    At {{ $city['brand'] }}, we believe in simple, fair policies. We want you to stay because you love our service, not because you're locked into a contract.
                </p>

                <h2 class="text-2xl font-bold mt-10 mb-4 text-slate-900">Month-to-Month Subscriptions</h2>
                <p class="text-slate-600 mb-6">
                    All of our subscription plans are <strong>month-to-month with no long-term commitments</strong>. You can cancel your subscription at any time, for any reason. There are no cancellation fees or penalties.
                </p>

                <h2 class="text-2xl font-bold mt-10 mb-4 text-slate-900">How Cancellations Work</h2>
                <ul class="list-disc pl-6 text-slate-600 space-y-2 mb-6">
                    <li>You may cancel your subscription at any time by contacting us via email or phone</li>
                    <li>Your service will continue through the end of your current billing period</li>
                    <li>You will not be charged for any future billing periods after cancellation</li>
                    <li>Any scheduled pickups within your paid period will still be honored</li>
                </ul>

                <h2 class="text-2xl font-bold mt-10 mb-4 text-slate-900">Refunds for Subscription Plans</h2>
                <p class="text-slate-600 mb-6">
                    Since our subscriptions are month-to-month and you can cancel at any time, we generally do not offer refunds for partial months. However, we understand that circumstances vary. If you have a special situation, please contact us and we'll do our best to work with you.
                </p>

                <h2 class="text-2xl font-bold mt-10 mb-4 text-slate-900">Individual Bag Purchases</h2>
                <p class="text-slate-600 mb-6">
                    Individual bag purchases are non-refundable once laundry has been picked up, as processing begins immediately. If you need to cancel a scheduled pickup before it occurs, please contact us as soon as possible and we will issue a full refund.
                </p>

                <h2 class="text-2xl font-bold mt-10 mb-4 text-slate-900">Service Issues</h2>
                <p class="text-slate-600 mb-4">
                    If we fail to deliver on our service promise, we will make it right. This includes:
                </p>
                <ul class="list-disc pl-6 text-slate-600 space-y-2 mb-6">
                    <li><strong>Missed pickups:</strong> We'll reschedule at your convenience or provide a credit</li>
                    <li><strong>Late deliveries:</strong> Contact us and we'll provide a service credit</li>
                    <li><strong>Damaged items:</strong> We'll work with you to resolve the issue fairly</li>
                    <li><strong>Lost items:</strong> We'll compensate you for the reasonable value of lost items</li>
                </ul>

                <h2 class="text-2xl font-bold mt-10 mb-4 text-slate-900">Pausing Your Subscription</h2>
                <p class="text-slate-600 mb-6">
                    Going on vacation or just need a break? Instead of cancelling, you can pause your subscription. Contact us to pause your service, and we'll hold your spot without charging you until you're ready to resume.
                </p>

                <h2 class="text-2xl font-bold mt-10 mb-4 text-slate-900">Contact Us</h2>
                <p class="text-slate-600 mb-2">To cancel, pause, or discuss any refund-related questions:</p>
                <ul class="list-none text-slate-600 space-y-1">
                    <li><strong>Email:</strong> {{ $city['contact']['email'] }}</li>
                    <li><strong>Phone:</strong> {{ $city['contact']['phone'] }}</li>
                </ul>
                <p class="text-slate-600 mt-4">
                    We typically respond within one business day and will process your request promptly.
                </p>
            </div>
        </div>
    </main>

    @include('components.footer')
@endsection
