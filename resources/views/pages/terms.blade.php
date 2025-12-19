{{--
    File: terms.blade.php
    Description: Terms of service page
    Copyright: 2025 Cloudmanic Labs, LLC
    Date: 2025-12-18
--}}
@extends('layouts.app')

@section('title', 'Terms of Service | ' . $city['brand'])

@section('content')
    @include('components.header')

    <main class="pt-32 pb-20">
        <div class="container mx-auto px-4 max-w-3xl">
            <h1 class="text-4xl font-bold mb-4 text-slate-900">Terms of Service</h1>
            <p class="text-slate-500 mb-12">Last Updated: December 18, 2025</p>

            <div class="prose prose-slate max-w-none">
                <p class="text-lg text-slate-600 mb-8">
                    Welcome to {{ $city['brand'] }}. These Terms of Service ("Terms") govern your use of our website and laundry pickup and delivery services operated by Cloudmanic Labs, LLC ("we," "our," or "us"). By accessing or using our services, you agree to be bound by these Terms.
                </p>

                <h2 class="text-2xl font-bold mt-10 mb-4 text-slate-900">1. Service Description</h2>
                <p class="text-slate-600 mb-6">
                    {{ $city['brand'] }} provides residential laundry pickup, washing, folding, and delivery services in the {{ $city['name'] }} area and surrounding communities. We offer both individual bag services and monthly subscription plans.
                </p>

                <h2 class="text-2xl font-bold mt-10 mb-4 text-slate-900">2. User Accounts</h2>
                <p class="text-slate-600 mb-6">
                    When you create an account with us, you must provide accurate and complete information. You are responsible for maintaining the confidentiality of your account credentials and for all activities that occur under your account. Please notify us immediately of any unauthorized use of your account.
                </p>

                <h2 class="text-2xl font-bold mt-10 mb-4 text-slate-900">3. Subscription Plans</h2>
                <p class="text-slate-600 mb-4">Our subscription plans are billed monthly. By subscribing, you agree to:</p>
                <ul class="list-disc pl-6 text-slate-600 space-y-2 mb-6">
                    <li>Pay the applicable monthly fee for your selected plan</li>
                    <li>Provide valid payment information that will be charged automatically each billing cycle</li>
                    <li>Understand that subscriptions continue until cancelled</li>
                </ul>
                <p class="text-slate-600 mb-6">
                    You may cancel your subscription at any time. See our <a href="/refund-policy" class="text-emerald-600 hover:text-emerald-700 underline">Refund Policy</a> for details on cancellations.
                </p>

                <h2 class="text-2xl font-bold mt-10 mb-4 text-slate-900">4. Service Guidelines</h2>
                <p class="text-slate-600 mb-4">When using our services, you agree to:</p>
                <ul class="list-disc pl-6 text-slate-600 space-y-2 mb-6">
                    <li>Place your laundry in the provided bags at the designated pickup location by the scheduled time</li>
                    <li>Not include prohibited items (hazardous materials, heavily soiled items, items requiring dry cleaning unless specified)</li>
                    <li>Ensure pickup and delivery locations are accessible</li>
                    <li>Provide accurate service preferences and special instructions</li>
                </ul>

                <h2 class="text-2xl font-bold mt-10 mb-4 text-slate-900">5. Liability for Items</h2>
                <p class="text-slate-600 mb-6">
                    While we take great care with your laundry, we are not responsible for damage to delicate items not placed in designated delicates bags, items with pre-existing damage, color bleeding from improperly sorted items, or items left in pockets. Please check all pockets and remove valuable items before pickup.
                </p>

                <h2 class="text-2xl font-bold mt-10 mb-4 text-slate-900">6. Service Modifications</h2>
                <p class="text-slate-600 mb-6">
                    We reserve the right to modify, suspend, or discontinue any aspect of our services at any time, with or without notice. We may also modify pricing with reasonable advance notice to subscribers.
                </p>

                <h2 class="text-2xl font-bold mt-10 mb-4 text-slate-900">7. Intellectual Property</h2>
                <p class="text-slate-600 mb-6">
                    All content on our website, including text, graphics, logos, and images, is the property of Cloudmanic Labs, LLC and is protected by intellectual property laws. You may not copy, reproduce, or distribute our content without prior written permission.
                </p>

                <h2 class="text-2xl font-bold mt-10 mb-4 text-slate-900">8. Disclaimer of Warranties</h2>
                <p class="text-slate-600 mb-6">
                    Our services are provided "as is" and "as available" without warranties of any kind, either express or implied. We do not guarantee that our services will be uninterrupted, error-free, or meet your specific requirements.
                </p>

                <h2 class="text-2xl font-bold mt-10 mb-4 text-slate-900">9. Limitation of Liability</h2>
                <p class="text-slate-600 mb-6">
                    To the fullest extent permitted by law, Cloudmanic Labs, LLC shall not be liable for any indirect, incidental, special, consequential, or punitive damages arising from your use of our services. Our total liability shall not exceed the amount you paid for services in the preceding twelve months.
                </p>

                <h2 class="text-2xl font-bold mt-10 mb-4 text-slate-900">10. Account Termination</h2>
                <p class="text-slate-600 mb-6">
                    We reserve the right to suspend or terminate your account at any time for violation of these Terms or for any other reason at our discretion. You may also close your account at any time by contacting us.
                </p>

                <h2 class="text-2xl font-bold mt-10 mb-4 text-slate-900">11. Governing Law</h2>
                <p class="text-slate-600 mb-6">
                    These Terms shall be governed by and construed in accordance with the laws of the State of Oregon, without regard to its conflict of law provisions. Any disputes arising from these Terms shall be resolved exclusively in the courts of Oregon.
                </p>

                <h2 class="text-2xl font-bold mt-10 mb-4 text-slate-900">12. Changes to Terms</h2>
                <p class="text-slate-600 mb-6">
                    We may update these Terms from time to time. We will notify you of any material changes by posting the new Terms on this page and updating the "Last Updated" date. Your continued use of our services after such changes constitutes acceptance of the new Terms.
                </p>

                <h2 class="text-2xl font-bold mt-10 mb-4 text-slate-900">13. Contact Us</h2>
                <p class="text-slate-600 mb-2">If you have questions about these Terms, please contact us:</p>
                <ul class="list-none text-slate-600 space-y-1">
                    <li><strong>Email:</strong> {{ 'support@' . $city['domain'] }}</li>
                    <li><strong>Phone:</strong> {{ $city['contact']['phone'] }}</li>
                </ul>
            </div>
        </div>
    </main>

    @include('components.footer')
@endsection
