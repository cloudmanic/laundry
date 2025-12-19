{{--
    File: privacy-policy.blade.php
    Description: Privacy policy page
    Copyright: 2025 Cloudmanic Labs, LLC
    Date: 2025-12-18
--}}
@extends('layouts.app')

@section('title', 'Privacy Policy | ' . $city['brand'])

@section('content')
    @include('components.header')

    <main class="pt-32 pb-20">
        <div class="container mx-auto px-4 max-w-3xl">
            <h1 class="text-4xl font-bold mb-4 text-slate-900">Privacy Policy</h1>
            <p class="text-slate-500 mb-12">Last Updated: December 18, 2025</p>

            <div class="prose prose-slate max-w-none">
                <p class="text-lg text-slate-600 mb-8">
                    {{ $city['brand'] }} ("we," "our," or "us") is committed to protecting your privacy. This Privacy Policy explains how we collect, use, and safeguard your information when you use our laundry pickup and delivery services.
                </p>

                <h2 class="text-2xl font-bold mt-10 mb-4 text-slate-900">1. Information We Collect</h2>
                <p class="text-slate-600 mb-4">We may collect the following types of information:</p>
                <ul class="list-disc pl-6 text-slate-600 space-y-2 mb-6">
                    <li><strong>Personal identification information:</strong> Name, email address, phone number, and home address for pickup and delivery.</li>
                    <li><strong>Billing information:</strong> Payment card details and billing address (processed securely through our payment processor).</li>
                    <li><strong>Service preferences:</strong> Laundry preferences, special instructions, and scheduling information.</li>
                    <li><strong>Usage data:</strong> Information about how you interact with our website and services.</li>
                    <li><strong>Technical data:</strong> IP address, browser type, and device information.</li>
                </ul>

                <h2 class="text-2xl font-bold mt-10 mb-4 text-slate-900">2. How We Use Your Information</h2>
                <p class="text-slate-600 mb-4">We use the information we collect to:</p>
                <ul class="list-disc pl-6 text-slate-600 space-y-2 mb-6">
                    <li>Process and fulfill your laundry pickup and delivery requests</li>
                    <li>Manage your account and subscription</li>
                    <li>Communicate with you about your orders and service updates</li>
                    <li>Provide customer support</li>
                    <li>Improve our website and services</li>
                    <li>Send marketing communications (with your consent)</li>
                    <li>Comply with legal obligations</li>
                </ul>

                <h2 class="text-2xl font-bold mt-10 mb-4 text-slate-900">3. Data Security</h2>
                <p class="text-slate-600 mb-6">
                    We implement appropriate security measures to protect your personal information, including encryption, secure socket layer technology, and regular security practices. However, no method of transmission over the internet or electronic storage is 100% secure, and we cannot guarantee absolute security.
                </p>

                <h2 class="text-2xl font-bold mt-10 mb-4 text-slate-900">4. Third-Party Services</h2>
                <p class="text-slate-600 mb-6">
                    We may share your information with trusted third-party service providers who assist us in operating our business, such as payment processors and analytics providers. These third parties are obligated to maintain the confidentiality of your information and may only use it to perform services on our behalf.
                </p>

                <h2 class="text-2xl font-bold mt-10 mb-4 text-slate-900">5. Cookies</h2>
                <p class="text-slate-600 mb-6">
                    Our website may use cookies and similar tracking technologies to enhance your experience. You can configure your browser settings to refuse cookies, though this may affect your ability to use some portions of our website.
                </p>

                <h2 class="text-2xl font-bold mt-10 mb-4 text-slate-900">6. Children's Privacy</h2>
                <p class="text-slate-600 mb-6">
                    Our services are not intended for individuals under 18 years of age. We do not knowingly collect personal information from children.
                </p>

                <h2 class="text-2xl font-bold mt-10 mb-4 text-slate-900">7. Your Privacy Rights</h2>
                <p class="text-slate-600 mb-6">
                    Depending on your location, you may have the right to request access to, correction of, or deletion of your personal information. You may also request restrictions on processing or data portability. To exercise these rights, please contact us using the information below.
                </p>

                <h2 class="text-2xl font-bold mt-10 mb-4 text-slate-900">8. Policy Changes</h2>
                <p class="text-slate-600 mb-6">
                    We may update this Privacy Policy from time to time. Any changes will be posted on this page with a revised "Last Updated" date. We encourage you to review this policy periodically.
                </p>

                <h2 class="text-2xl font-bold mt-10 mb-4 text-slate-900">9. Contact Us</h2>
                <p class="text-slate-600 mb-2">If you have questions about this Privacy Policy, please contact us:</p>
                <ul class="list-none text-slate-600 space-y-1">
                    <li><strong>Email:</strong> {{ $city['contact']['support_email'] }}</li>
                    <li><strong>Phone:</strong> {{ $city['contact']['phone'] }}</li>
                </ul>
            </div>
        </div>
    </main>

    @include('components.footer')
@endsection
