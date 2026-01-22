{{--
    File: reset-password.blade.php
    Description: Sales-focused reset password page with Livewire form and password strength indicator
    Copyright: 2026 Cloudmanic Labs, LLC
    Date: 2026-01-22
--}}
<div class="min-h-screen flex flex-col lg:flex-row">
    {{-- Left Side: Reset Password Form --}}
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

            {{-- Reset Password Indicator --}}
            <div class="mb-8">
                <div class="flex items-center space-x-2 text-sm text-slate-500 mb-2">
                    <div class="flex items-center justify-center w-8 h-8 rounded-full bg-emerald-100 text-emerald-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                        </svg>
                    </div>
                    <span class="font-medium text-emerald-600">Create New Password</span>
                </div>
            </div>

            {{-- Heading --}}
            <div class="mb-8">
                <h1 class="text-3xl sm:text-4xl font-bold text-slate-900 mb-2">Reset Your Password</h1>
                <p class="text-slate-600">
                    Create a strong, secure password for your account. You'll be signed in automatically after resetting.
                </p>
            </div>

            {{-- Reset Password Form --}}
            <form wire:submit="resetPassword" class="space-y-5">
                {{-- Hidden Token Field --}}
                <input type="hidden" wire:model="token" />

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
                    <label for="password" class="block text-sm font-semibold text-slate-700 mb-1.5">
                        New Password
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
                        Confirm New Password
                    </label>
                    <input
                        type="{{ $showPassword ? 'text' : 'password' }}"
                        id="password_confirmation"
                        wire:model.blur="password_confirmation"
                        placeholder="Confirm your new password"
                        class="w-full px-4 py-3 rounded-xl border-2 transition-colors focus:outline-none focus:ring-0 {{ $errors->has('password_confirmation') ? 'border-red-400 focus:border-red-500' : 'border-slate-200 focus:border-emerald-500' }}"
                        autocomplete="new-password"
                    />
                    @error('password_confirmation')
                        <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Submit Button --}}
                <button
                    type="submit"
                    class="w-full bg-emerald-600 text-white py-4 rounded-xl font-bold text-lg hover:bg-emerald-700 transition-all transform hover:-translate-y-0.5 shadow-lg shadow-emerald-600/30 disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none"
                    wire:loading.attr="disabled"
                    wire:target="resetPassword"
                    {{ $isSubmitting ? 'disabled' : '' }}
                >
                    <span wire:loading.remove wire:target="resetPassword">Reset Password & Sign In</span>
                    <span wire:loading.flex wire:target="resetPassword" class="items-center justify-center gap-2">
                        <svg class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span>Resetting password...</span>
                    </span>
                </button>

                {{-- Link expired notice --}}
                <div class="bg-slate-50 border border-slate-200 rounded-xl p-4 mt-4">
                    <div class="flex items-start space-x-3">
                        <svg class="w-5 h-5 text-slate-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <div class="text-sm text-slate-600">
                            <p>This link expires in <span class="font-semibold">60 minutes</span> for your security.</p>
                            <p class="mt-1">
                                Link expired?
                                <a href="{{ route('password.request') }}" class="text-emerald-600 hover:text-emerald-700 font-medium">Request a new one</a>
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Back to Login Link --}}
                <p class="text-center text-sm text-slate-600 mt-6">
                    Remember your password?
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
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-emerald-400 text-sm font-semibold uppercase tracking-wider">Almost There!</p>
                        <h3 class="text-xl font-bold">One More Step</h3>
                    </div>
                </div>
                <p class="text-slate-300 text-sm">
                    Choose a strong password to keep your account secure. Once reset, you'll be automatically signed in.
                </p>
            </div>

            {{-- Password Tips --}}
            <h2 class="text-3xl font-bold mb-6">Password Tips:</h2>
            <ul class="space-y-4 mb-10">
                <li class="flex items-start space-x-3">
                    <div class="flex-shrink-0 w-6 h-6 rounded-full bg-emerald-500 flex items-center justify-center mt-0.5">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <div>
                        <p class="font-semibold">At Least 8 Characters</p>
                        <p class="text-slate-400 text-sm">Longer passwords are harder to crack</p>
                    </div>
                </li>
                <li class="flex items-start space-x-3">
                    <div class="flex-shrink-0 w-6 h-6 rounded-full bg-emerald-500 flex items-center justify-center mt-0.5">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <div>
                        <p class="font-semibold">Mix Upper & Lowercase</p>
                        <p class="text-slate-400 text-sm">Combine capital and lowercase letters</p>
                    </div>
                </li>
                <li class="flex items-start space-x-3">
                    <div class="flex-shrink-0 w-6 h-6 rounded-full bg-emerald-500 flex items-center justify-center mt-0.5">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <div>
                        <p class="font-semibold">Include Numbers</p>
                        <p class="text-slate-400 text-sm">Add some digits for extra security</p>
                    </div>
                </li>
                <li class="flex items-start space-x-3">
                    <div class="flex-shrink-0 w-6 h-6 rounded-full bg-emerald-500 flex items-center justify-center mt-0.5">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <div>
                        <p class="font-semibold">Use Special Characters</p>
                        <p class="text-slate-400 text-sm">Symbols like !@#$% make it stronger</p>
                    </div>
                </li>
            </ul>

            {{-- Back to Service Soon --}}
            <div class="bg-white/5 rounded-2xl p-6 border border-white/10">
                <div class="flex items-center space-x-3 mb-3">
                    <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                    <p class="font-semibold">Almost Back!</p>
                </div>
                <p class="text-slate-400 text-sm">
                    Once you reset your password, you'll be signed in and can get back to managing your laundry schedule right away.
                </p>
            </div>
        </div>
    </div>
</div>
