{{--
    File: forgot-password.blade.php
    Description: Sales-focused forgot password page with Livewire form
    Copyright: 2026 Cloudmanic Labs, LLC
    Date: 2026-01-22
--}}
<div class="min-h-screen flex flex-col lg:flex-row">
    {{-- Left Side: Forgot Password Form --}}
    <div class="flex-1 flex flex-col justify-center px-4 sm:px-6 lg:px-12 xl:px-20 py-12 lg:py-0">
        <div class="w-full max-w-md mx-auto">
            {{-- Logo/Brand --}}
            <a href="{{ route('home') }}" class="inline-flex items-center space-x-2 mb-8">
                <div class="w-10 h-10 bg-emerald-600 rounded-xl flex items-center justify-center text-white font-bold text-lg">
                    {{ substr($city['name'], 0, 1) }}L
                </div>
                <span class="text-xl font-bold text-slate-900">
                    {{ $city['name'] }} <span class="text-emerald-600 font-serif italic">Laundry</span>
                </span>
            </a>

            @if(!$emailSent)
                {{-- Reset Password Indicator --}}
                <div class="mb-8">
                    <div class="flex items-center space-x-2 text-sm text-slate-500 mb-2">
                        <div class="flex items-center justify-center w-8 h-8 rounded-full bg-emerald-100 text-emerald-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                            </svg>
                        </div>
                        <span class="font-medium text-emerald-600">Password Recovery</span>
                    </div>
                </div>

                {{-- Heading --}}
                <div class="mb-8">
                    <h1 class="text-3xl sm:text-4xl font-bold text-slate-900 mb-2">Forgot Your Password?</h1>
                    <p class="text-slate-600">
                        No worries! Enter your email address and we'll send you a secure link to reset your password.
                    </p>
                </div>

                {{-- Forgot Password Form --}}
                <form wire:submit="sendResetLink" class="space-y-5">
                    {{-- Email Field --}}
                    <div>
                        <label for="email" class="block text-sm font-semibold text-slate-700 mb-1.5">
                            Email Address
                        </label>
                        <input
                            type="email"
                            id="email"
                            wire:model.blur="email"
                            placeholder="john@example.com"
                            class="w-full px-4 py-3 rounded-xl border-2 transition-colors focus:outline-none focus:ring-0 {{ $errors->has('email') ? 'border-red-400 focus:border-red-500' : 'border-slate-200 focus:border-emerald-500' }}"
                            autocomplete="email"
                            autofocus
                        />
                        @error('email')
                            <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Submit Button --}}
                    <button
                        type="submit"
                        class="w-full bg-emerald-600 text-white py-4 rounded-xl font-bold text-lg hover:bg-emerald-700 transition-all transform hover:-translate-y-0.5 shadow-lg shadow-emerald-600/30 disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none"
                        wire:loading.attr="disabled"
                        wire:target="sendResetLink"
                        {{ $isSubmitting ? 'disabled' : '' }}
                    >
                        <span wire:loading.remove wire:target="sendResetLink">Send Reset Link</span>
                        <span wire:loading.flex wire:target="sendResetLink" class="items-center justify-center gap-2">
                            <svg class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <span>Sending...</span>
                        </span>
                    </button>

                    {{-- Back to Login Link --}}
                    <p class="text-center text-sm text-slate-600 mt-6">
                        Remember your password?
                        <a href="{{ route('login') }}" class="text-emerald-600 hover:text-emerald-700 font-semibold">Sign in</a>
                    </p>
                </form>
            @else
                {{-- Success State --}}
                <div class="text-center">
                    {{-- Success Icon --}}
                    <div class="mb-6">
                        <div class="w-20 h-20 bg-emerald-100 rounded-full flex items-center justify-center mx-auto">
                            <svg class="w-10 h-10 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                    </div>

                    {{-- Success Heading --}}
                    <h1 class="text-3xl sm:text-4xl font-bold text-slate-900 mb-4">Check Your Email</h1>
                    <p class="text-slate-600 mb-6">
                        If an account exists with <span class="font-semibold text-slate-900">{{ $email }}</span>, you will receive a password reset link shortly.
                    </p>

                    {{-- Email Info Box --}}
                    <div class="bg-emerald-50 border border-emerald-200 rounded-xl p-4 mb-6 text-left">
                        <div class="flex items-start space-x-3">
                            <svg class="w-5 h-5 text-emerald-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <div class="text-sm text-emerald-800">
                                <p class="font-semibold mb-1">The link will expire in 60 minutes</p>
                                <p>Check your spam folder if you don't see the email in your inbox.</p>
                            </div>
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="space-y-3">
                        <a
                            href="{{ route('login') }}"
                            class="block w-full bg-emerald-600 text-white py-4 rounded-xl font-bold text-lg hover:bg-emerald-700 transition-all transform hover:-translate-y-0.5 shadow-lg shadow-emerald-600/30 text-center"
                        >
                            Return to Sign In
                        </a>
                        <button
                            type="button"
                            wire:click="$set('emailSent', false)"
                            class="w-full text-slate-600 hover:text-slate-800 font-medium py-2 text-sm"
                        >
                            Didn't receive the email? Try again
                        </button>
                    </div>
                </div>
            @endif

            {{-- Trust Signals --}}
            <div class="mt-8 pt-8 border-t border-slate-200">
                <div class="flex items-center justify-center space-x-6 text-slate-400 text-sm">
                    <div class="flex items-center space-x-1.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                        <span>Secure reset</span>
                    </div>
                    <div class="flex items-center space-x-1.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                        <span>Privacy protected</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Right Side: Value Proposition (hidden on mobile) --}}
    <div class="hidden lg:flex lg:flex-1 bg-slate-900 text-white p-12 xl:p-20 flex-col justify-center relative overflow-hidden">
        {{-- Background Pattern --}}
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-0 right-0 w-96 h-96 bg-emerald-500 rounded-full blur-[120px]"></div>
            <div class="absolute bottom-0 left-0 w-96 h-96 bg-emerald-600 rounded-full blur-[120px]"></div>
        </div>

        <div class="relative z-10 max-w-lg">
            {{-- Security Message --}}
            <div class="bg-white/10 backdrop-blur rounded-2xl p-6 mb-8 border border-white/20">
                <div class="flex items-center space-x-4 mb-4">
                    <div class="w-12 h-12 rounded-full bg-emerald-500 flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-emerald-400 text-sm font-semibold uppercase tracking-wider">Secure Process</p>
                        <h3 class="text-xl font-bold">Your Account is Protected</h3>
                    </div>
                </div>
                <p class="text-slate-300 text-sm">
                    We take your security seriously. Password reset links are single-use and expire after 60 minutes for your protection.
                </p>
            </div>

            {{-- Password Reset Steps --}}
            <h2 class="text-3xl font-bold mb-6">How It Works:</h2>
            <ul class="space-y-4 mb-10">
                <li class="flex items-start space-x-3">
                    <div class="flex-shrink-0 w-8 h-8 rounded-full bg-emerald-500 flex items-center justify-center mt-0.5 text-sm font-bold">
                        1
                    </div>
                    <div>
                        <p class="font-semibold">Enter Your Email</p>
                        <p class="text-slate-400 text-sm">Provide the email address linked to your account</p>
                    </div>
                </li>
                <li class="flex items-start space-x-3">
                    <div class="flex-shrink-0 w-8 h-8 rounded-full bg-emerald-500 flex items-center justify-center mt-0.5 text-sm font-bold">
                        2
                    </div>
                    <div>
                        <p class="font-semibold">Check Your Inbox</p>
                        <p class="text-slate-400 text-sm">We'll send you a secure password reset link</p>
                    </div>
                </li>
                <li class="flex items-start space-x-3">
                    <div class="flex-shrink-0 w-8 h-8 rounded-full bg-emerald-500 flex items-center justify-center mt-0.5 text-sm font-bold">
                        3
                    </div>
                    <div>
                        <p class="font-semibold">Create New Password</p>
                        <p class="text-slate-400 text-sm">Choose a strong, unique password for your account</p>
                    </div>
                </li>
                <li class="flex items-start space-x-3">
                    <div class="flex-shrink-0 w-8 h-8 rounded-full bg-emerald-500 flex items-center justify-center mt-0.5 text-sm font-bold">
                        4
                    </div>
                    <div>
                        <p class="font-semibold">Get Back to Your Laundry</p>
                        <p class="text-slate-400 text-sm">You'll be signed in automatically after resetting</p>
                    </div>
                </li>
            </ul>

            {{-- Help Section --}}
            <div class="bg-white/5 rounded-2xl p-6 border border-white/10">
                <div class="flex items-center space-x-3 mb-3">
                    <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <p class="font-semibold">Need Help?</p>
                </div>
                <p class="text-slate-400 text-sm">
                    If you're having trouble accessing your account, contact us at
                    <a href="mailto:{{ $city['contact']['support_email'] }}" class="text-emerald-400 hover:text-emerald-300 underline">{{ $city['contact']['support_email'] }}</a>
                </p>
            </div>
        </div>
    </div>
</div>
