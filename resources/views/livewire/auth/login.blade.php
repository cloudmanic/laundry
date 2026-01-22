{{--
    File: login.blade.php
    Description: Sales-focused login page with Livewire form
    Copyright: 2026 Cloudmanic Labs, LLC
    Date: 2026-01-22
--}}
<div class="min-h-screen flex flex-col lg:flex-row">
    {{-- Left Side: Login Form --}}
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

            {{-- Welcome Back Indicator --}}
            <div class="mb-8">
                <div class="flex items-center space-x-2 text-sm text-slate-500 mb-2">
                    <div class="flex items-center justify-center w-8 h-8 rounded-full bg-emerald-100 text-emerald-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <span class="font-medium text-emerald-600">Welcome Back</span>
                </div>
            </div>

            {{-- Heading --}}
            <div class="mb-8">
                <h1 class="text-3xl sm:text-4xl font-bold text-slate-900 mb-2">Sign In to Your Account</h1>
                <p class="text-slate-600">
                    Access your laundry schedule, manage pickups, and view your history.
                </p>
            </div>

            {{-- Login Form --}}
            <form wire:submit="login" class="space-y-5">
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
                    />
                    @error('email')
                        <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Password Field --}}
                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <label for="password" class="block text-sm font-semibold text-slate-700">
                            Password
                        </label>
                        <a href="{{ route('password.request') }}" class="text-sm text-emerald-600 hover:text-emerald-700 font-medium">
                            Forgot password?
                        </a>
                    </div>
                    <div class="relative">
                        <input
                            type="{{ $showPassword ? 'text' : 'password' }}"
                            id="password"
                            wire:model="password"
                            placeholder="Enter your password"
                            class="w-full px-4 py-3 pr-12 rounded-xl border-2 transition-colors focus:outline-none focus:ring-0 {{ $errors->has('password') ? 'border-red-400 focus:border-red-500' : 'border-slate-200 focus:border-emerald-500' }}"
                            autocomplete="current-password"
                        />
                        <button
                            type="button"
                            wire:click="togglePasswordVisibility"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 focus:outline-none"
                            tabindex="-1"
                        >
                            @if($showPassword)
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                </svg>
                            @else
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            @endif
                        </button>
                    </div>
                    @error('password')
                        <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Remember Me Checkbox --}}
                <div class="flex items-center space-x-3">
                    <div class="flex items-center h-5">
                        <input
                            type="checkbox"
                            id="remember"
                            wire:model="remember"
                            class="w-4 h-4 rounded border-slate-300 text-emerald-600 focus:ring-emerald-500 focus:ring-offset-0"
                        />
                    </div>
                    <label for="remember" class="text-sm text-slate-600">
                        Keep me signed in for 30 days
                    </label>
                </div>

                {{-- Submit Button --}}
                <button
                    type="submit"
                    class="w-full bg-emerald-600 text-white py-4 rounded-xl font-bold text-lg hover:bg-emerald-700 transition-all transform hover:-translate-y-0.5 shadow-lg shadow-emerald-600/30 disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none"
                    wire:loading.attr="disabled"
                    wire:target="login"
                    {{ $isSubmitting ? 'disabled' : '' }}
                >
                    <span wire:loading.remove wire:target="login">Sign In</span>
                    <span wire:loading.flex wire:target="login" class="items-center justify-center gap-2">
                        <svg class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span>Signing in...</span>
                    </span>
                </button>

                {{-- Social Login Buttons (Placeholder) --}}
                <div class="relative my-6">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-slate-200"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-4 bg-slate-50 text-slate-500">Or continue with</span>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    {{-- Google Button (Placeholder) --}}
                    <button
                        type="button"
                        class="flex items-center justify-center gap-2 px-4 py-3 border-2 border-slate-200 rounded-xl text-slate-700 font-medium hover:bg-slate-50 hover:border-slate-300 transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
                        disabled
                        title="Coming soon"
                    >
                        <svg class="w-5 h-5" viewBox="0 0 24 24">
                            <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                            <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                            <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                            <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                        </svg>
                        <span>Google</span>
                    </button>

                    {{-- Apple Button (Placeholder) --}}
                    <button
                        type="button"
                        class="flex items-center justify-center gap-2 px-4 py-3 border-2 border-slate-200 rounded-xl text-slate-700 font-medium hover:bg-slate-50 hover:border-slate-300 transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
                        disabled
                        title="Coming soon"
                    >
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M18.71 19.5c-.83 1.24-1.71 2.45-3.05 2.47-1.34.03-1.77-.79-3.29-.79-1.53 0-2 .77-3.27.82-1.31.05-2.3-1.32-3.14-2.53C4.25 17 2.94 12.45 4.7 9.39c.87-1.52 2.43-2.48 4.12-2.51 1.28-.02 2.5.87 3.29.87.78 0 2.26-1.07 3.81-.91.65.03 2.47.26 3.64 1.98-.09.06-2.17 1.28-2.15 3.81.03 3.02 2.65 4.03 2.68 4.04-.03.07-.42 1.44-1.38 2.83M13 3.5c.73-.83 1.94-1.46 2.94-1.5.13 1.17-.34 2.35-1.04 3.19-.69.85-1.83 1.51-2.95 1.42-.15-1.15.41-2.35 1.05-3.11z"/>
                        </svg>
                        <span>Apple</span>
                    </button>
                </div>

                {{-- Register Link --}}
                <p class="text-center text-sm text-slate-600 mt-6">
                    Don't have an account?
                    <a href="{{ route('register') }}" class="text-emerald-600 hover:text-emerald-700 font-semibold">Create one now</a>
                </p>
            </form>

            {{-- Trust Signals --}}
            <div class="mt-8 pt-8 border-t border-slate-200">
                <div class="flex items-center justify-center space-x-6 text-slate-400 text-sm">
                    <div class="flex items-center space-x-1.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                        <span>Secure login</span>
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
            {{-- Welcome Back Message --}}
            <div class="bg-white/10 backdrop-blur rounded-2xl p-6 mb-8 border border-white/20">
                <div class="flex items-center space-x-4 mb-4">
                    <div class="w-12 h-12 rounded-full bg-emerald-500 flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-emerald-400 text-sm font-semibold uppercase tracking-wider">Welcome Back</p>
                        <h3 class="text-xl font-bold">We've Missed You!</h3>
                    </div>
                </div>
                <p class="text-slate-300 text-sm">
                    Your laundry schedule and preferences are just a sign-in away. Let's get you back to enjoying your weekends.
                </p>
            </div>

            {{-- Benefits Reminder --}}
            <h2 class="text-3xl font-bold mb-6">Your Benefits Await:</h2>
            <ul class="space-y-4 mb-10">
                <li class="flex items-start space-x-3">
                    <div class="flex-shrink-0 w-6 h-6 rounded-full bg-emerald-500 flex items-center justify-center mt-0.5">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <div>
                        <p class="font-semibold">Manage Your Schedule</p>
                        <p class="text-slate-400 text-sm">View, skip, or reschedule pickups anytime</p>
                    </div>
                </li>
                <li class="flex items-start space-x-3">
                    <div class="flex-shrink-0 w-6 h-6 rounded-full bg-emerald-500 flex items-center justify-center mt-0.5">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <div>
                        <p class="font-semibold">Track Your Orders</p>
                        <p class="text-slate-400 text-sm">Real-time updates on your laundry status</p>
                    </div>
                </li>
                <li class="flex items-start space-x-3">
                    <div class="flex-shrink-0 w-6 h-6 rounded-full bg-emerald-500 flex items-center justify-center mt-0.5">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <div>
                        <p class="font-semibold">Update Preferences</p>
                        <p class="text-slate-400 text-sm">Customize detergent, folding, and more</p>
                    </div>
                </li>
                <li class="flex items-start space-x-3">
                    <div class="flex-shrink-0 w-6 h-6 rounded-full bg-emerald-500 flex items-center justify-center mt-0.5">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <div>
                        <p class="font-semibold">View Billing History</p>
                        <p class="text-slate-400 text-sm">Access invoices and manage payment methods</p>
                    </div>
                </li>
            </ul>

            {{-- Testimonial --}}
            <div class="bg-white/5 rounded-2xl p-6 border border-white/10">
                <div class="flex items-center space-x-3 mb-4">
                    <div class="flex -space-x-2">
                        <img src="https://randomuser.me/api/portraits/women/44.jpg" class="w-10 h-10 rounded-full border-2 border-slate-800" alt="">
                        <img src="https://randomuser.me/api/portraits/men/32.jpg" class="w-10 h-10 rounded-full border-2 border-slate-800" alt="">
                        <img src="https://randomuser.me/api/portraits/women/68.jpg" class="w-10 h-10 rounded-full border-2 border-slate-800" alt="">
                    </div>
                    <p class="text-sm text-slate-400">
                        <span class="text-emerald-400 font-bold">{{ $city['social_proof']['families_joined'] }}+</span> families trust us
                    </p>
                </div>
                <p class="text-slate-300 italic leading-relaxed">
                    "{{ $city['testimonial']['quote'] }}"
                </p>
                <p class="mt-3 text-sm font-semibold text-white">
                    &mdash; {{ $city['testimonial']['author'] }}, {{ $city['testimonial']['location'] }}
                </p>
            </div>
        </div>
    </div>
</div>
