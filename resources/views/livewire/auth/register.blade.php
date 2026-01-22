{{--
    File: register.blade.php
    Description: Sales-focused registration page with Livewire form
    Copyright: 2026 Cloudmanic Labs, LLC
    Date: 2026-01-21
--}}
<div class="min-h-screen flex flex-col lg:flex-row">
    {{-- Left Side: Registration Form --}}
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

            {{-- Progress Indicator --}}
            <div class="mb-8">
                <div class="flex items-center space-x-2 text-sm text-slate-500 mb-2">
                    <span class="flex items-center justify-center w-6 h-6 rounded-full bg-emerald-600 text-white text-xs font-bold">1</span>
                    <span class="font-medium text-slate-900">Create Account</span>
                    <svg class="w-4 h-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                    <span class="flex items-center justify-center w-6 h-6 rounded-full bg-slate-200 text-slate-500 text-xs font-bold">2</span>
                    <span>Choose Pickup Day</span>
                    <svg class="w-4 h-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                    <span class="flex items-center justify-center w-6 h-6 rounded-full bg-slate-200 text-slate-500 text-xs font-bold">3</span>
                    <span>Payment</span>
                </div>
            </div>

            {{-- Heading --}}
            <div class="mb-8">
                <h1 class="text-3xl sm:text-4xl font-bold text-slate-900 mb-2">Create Your Account</h1>
                <p class="text-slate-600">
                    Join {{ $city['social_proof']['families_joined'] }}+ families in {{ $city['name'] }} who are getting their weekends back.
                </p>
            </div>

            {{-- Registration Form --}}
            <form wire:submit="register" class="space-y-5">
                {{-- Name Fields --}}
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="first_name" class="block text-sm font-semibold text-slate-700 mb-1.5">
                            First Name
                        </label>
                        <input
                            type="text"
                            id="first_name"
                            wire:model.blur="first_name"
                            placeholder="John"
                            class="w-full px-4 py-3 rounded-xl border-2 transition-colors focus:outline-none focus:ring-0 {{ $errors->has('first_name') ? 'border-red-400 focus:border-red-500' : 'border-slate-200 focus:border-emerald-500' }}"
                            autocomplete="given-name"
                        />
                        @error('first_name')
                            <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="last_name" class="block text-sm font-semibold text-slate-700 mb-1.5">
                            Last Name
                        </label>
                        <input
                            type="text"
                            id="last_name"
                            wire:model.blur="last_name"
                            placeholder="Smith"
                            class="w-full px-4 py-3 rounded-xl border-2 transition-colors focus:outline-none focus:ring-0 {{ $errors->has('last_name') ? 'border-red-400 focus:border-red-500' : 'border-slate-200 focus:border-emerald-500' }}"
                            autocomplete="family-name"
                        />
                        @error('last_name')
                            <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

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

                {{-- Phone Field --}}
                <div>
                    <label for="phone" class="block text-sm font-semibold text-slate-700 mb-1.5">
                        Phone Number
                    </label>
                    <input
                        type="tel"
                        id="phone"
                        wire:model.blur="phone"
                        placeholder="(503) 555-1234"
                        class="w-full px-4 py-3 rounded-xl border-2 transition-colors focus:outline-none focus:ring-0 {{ $errors->has('phone') ? 'border-red-400 focus:border-red-500' : 'border-slate-200 focus:border-emerald-500' }}"
                        autocomplete="tel"
                    />
                    @error('phone')
                        <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Password Field --}}
                <div>
                    <label for="password" class="block text-sm font-semibold text-slate-700 mb-1.5">
                        Password
                    </label>
                    <div class="relative">
                        <input
                            type="{{ $showPassword ? 'text' : 'password' }}"
                            id="password"
                            wire:model.live.debounce.300ms="password"
                            placeholder="Create a secure password"
                            class="w-full px-4 py-3 pr-12 rounded-xl border-2 transition-colors focus:outline-none focus:ring-0 {{ $errors->has('password') ? 'border-red-400 focus:border-red-500' : 'border-slate-200 focus:border-emerald-500' }}"
                            autocomplete="new-password"
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

                    {{-- Password Strength Indicator --}}
                    @if(strlen($password) > 0)
                        <div class="mt-2">
                            <div class="flex items-center space-x-2">
                                <div class="flex-1 h-1.5 bg-slate-100 rounded-full overflow-hidden">
                                    <div
                                        class="h-full transition-all duration-300 {{ $this->passwordStrengthColor }}"
                                        style="width: {{ $this->passwordStrength * 25 }}%"
                                    ></div>
                                </div>
                                <span class="text-xs font-medium {{ $this->passwordStrength >= 3 ? 'text-emerald-600' : ($this->passwordStrength >= 2 ? 'text-yellow-600' : 'text-red-500') }}">
                                    {{ $this->passwordStrengthLabel }}
                                </span>
                            </div>
                        </div>
                    @endif

                    @error('password')
                        <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Password Confirmation Field --}}
                <div>
                    <label for="password_confirmation" class="block text-sm font-semibold text-slate-700 mb-1.5">
                        Confirm Password
                    </label>
                    <input
                        type="{{ $showPassword ? 'text' : 'password' }}"
                        id="password_confirmation"
                        wire:model.blur="password_confirmation"
                        placeholder="Confirm your password"
                        class="w-full px-4 py-3 rounded-xl border-2 transition-colors focus:outline-none focus:ring-0 {{ $errors->has('password_confirmation') ? 'border-red-400 focus:border-red-500' : 'border-slate-200 focus:border-emerald-500' }}"
                        autocomplete="new-password"
                    />
                    @error('password_confirmation')
                        <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Terms Checkbox --}}
                <div class="flex items-start space-x-3">
                    <div class="flex items-center h-5 mt-0.5">
                        <input
                            type="checkbox"
                            id="terms"
                            wire:model.live="terms"
                            class="w-4 h-4 rounded border-slate-300 text-emerald-600 focus:ring-emerald-500 focus:ring-offset-0"
                        />
                    </div>
                    <label for="terms" class="text-sm text-slate-600">
                        I agree to the
                        <a href="{{ route('terms') }}" target="_blank" class="text-emerald-600 hover:text-emerald-700 underline">Terms of Service</a>
                        and
                        <a href="{{ route('privacy-policy') }}" target="_blank" class="text-emerald-600 hover:text-emerald-700 underline">Privacy Policy</a>
                    </label>
                </div>
                @error('terms')
                    <p class="text-sm text-red-600 -mt-3">{{ $message }}</p>
                @enderror

                {{-- Submit Button --}}
                <button
                    type="submit"
                    class="w-full bg-emerald-600 text-white py-4 rounded-xl font-bold text-lg hover:bg-emerald-700 transition-all transform hover:-translate-y-0.5 shadow-lg shadow-emerald-600/30 disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none"
                    wire:loading.attr="disabled"
                    wire:target="register"
                    {{ $isSubmitting ? 'disabled' : '' }}
                >
                    <span wire:loading.remove wire:target="register">Create Account & Continue</span>
                    <span wire:loading.flex wire:target="register" class="items-center justify-center gap-2">
                        <svg class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span>Creating your account...</span>
                    </span>
                </button>

                {{-- Login Link --}}
                <p class="text-center text-sm text-slate-600">
                    Already have an account?
                    <a href="{{ route('login') }}" class="text-emerald-600 hover:text-emerald-700 font-semibold">Sign in</a>
                </p>
            </form>

            {{-- Trust Signals --}}
            <div class="mt-8 pt-8 border-t border-slate-200">
                <div class="flex items-center justify-center space-x-6 text-slate-400 text-sm">
                    <div class="flex items-center space-x-1.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                        <span>Secure checkout</span>
                    </div>
                    <div class="flex items-center space-x-1.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>Cancel anytime</span>
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
            {{-- Selected Plan Highlight --}}
            @if($selectedPlan && isset($city['pricing'][$selectedPlan]))
                @php $plan = $city['pricing'][$selectedPlan]; @endphp
                <div class="bg-white/10 backdrop-blur rounded-2xl p-6 mb-8 border border-white/20">
                    <p class="text-emerald-400 text-sm font-semibold uppercase tracking-wider mb-2">Your Selected Plan</p>
                    <h3 class="text-2xl font-bold mb-1">{{ $plan['name'] }}</h3>
                    <p class="text-4xl font-black text-emerald-400 mb-3">{{ $plan['price_display'] }}<span class="text-lg font-normal text-slate-400">/{{ $plan['period'] }}</span></p>
                    <p class="text-slate-300 text-sm">{{ $plan['description'] }}</p>
                </div>
            @else
                <div class="bg-white/10 backdrop-blur rounded-2xl p-6 mb-8 border border-white/20">
                    <p class="text-emerald-400 text-sm font-semibold uppercase tracking-wider mb-2">Most Popular</p>
                    <h3 class="text-2xl font-bold mb-1">{{ $city['pricing']['family']['name'] }}</h3>
                    <p class="text-4xl font-black text-emerald-400 mb-3">{{ $city['pricing']['family']['price_display'] }}<span class="text-lg font-normal text-slate-400">/{{ $city['pricing']['family']['period'] }}</span></p>
                    <p class="text-slate-300 text-sm">{{ $city['pricing']['family']['description'] }}</p>
                </div>
            @endif

            {{-- Benefits List --}}
            <h2 class="text-3xl font-bold mb-6">What you'll get:</h2>
            <ul class="space-y-4 mb-10">
                <li class="flex items-start space-x-3">
                    <div class="flex-shrink-0 w-6 h-6 rounded-full bg-emerald-500 flex items-center justify-center mt-0.5">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <div>
                        <p class="font-semibold">Get Your Sundays Back</p>
                        <p class="text-slate-400 text-sm">No more spending hours on laundry each week</p>
                    </div>
                </li>
                <li class="flex items-start space-x-3">
                    <div class="flex-shrink-0 w-6 h-6 rounded-full bg-emerald-500 flex items-center justify-center mt-0.5">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <div>
                        <p class="font-semibold">Next-Day Turnaround</p>
                        <p class="text-slate-400 text-sm">Picked up today, delivered fresh tomorrow</p>
                    </div>
                </li>
                <li class="flex items-start space-x-3">
                    <div class="flex-shrink-0 w-6 h-6 rounded-full bg-emerald-500 flex items-center justify-center mt-0.5">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <div>
                        <p class="font-semibold">Professional Care</p>
                        <p class="text-slate-400 text-sm">Expert wash, dry, and fold service</p>
                    </div>
                </li>
                <li class="flex items-start space-x-3">
                    <div class="flex-shrink-0 w-6 h-6 rounded-full bg-emerald-500 flex items-center justify-center mt-0.5">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <div>
                        <p class="font-semibold">Flexible & No Commitment</p>
                        <p class="text-slate-400 text-sm">Skip weeks or cancel anytime</p>
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
                        <span class="text-emerald-400 font-bold">{{ $city['social_proof']['families_joined'] }}+</span> families joined
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
