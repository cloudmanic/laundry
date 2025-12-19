{{--
    File: pricing.blade.php
    Description: Pricing section with 3 tiers
    Copyright: 2025 Cloudmanic Labs, LLC
    Date: 2025-12-18
--}}
<section class="py-24 bg-white" id="pricing">
    <div class="container mx-auto px-4">
        <div class="text-center mb-20">
            <h2 class="text-4xl font-bold mb-4 text-slate-900 italic font-serif">Simplicity in every bag.</h2>
            <p class="text-slate-600 max-w-2xl mx-auto text-lg">
                Choose the plan that fits your family's pace. All subscriptions are flexible and locally managed.
            </p>
        </div>

        <div class="grid lg:grid-cols-3 gap-10 max-w-6xl mx-auto">
            {{-- Light Household --}}
            <div class="relative p-10 rounded-[40px] transition-all duration-500 border-2 bg-white text-slate-900 border-slate-100 shadow-xl shadow-slate-100 hover:border-emerald-200">
                <h3 class="text-2xl font-bold mb-4">Light Household</h3>
                <div class="flex items-baseline space-x-2 mb-6">
                    <span class="text-5xl font-black">$65</span>
                    <span class="text-slate-500 font-bold">/bag</span>
                </div>
                <p class="text-sm mb-10 font-medium leading-relaxed text-slate-500">
                    Ideal for singles, couples, or anyone wanting a one-time relief from the laundry pile.
                </p>

                <ul class="space-y-5 mb-12">
                    <li class="flex items-start space-x-4 text-sm font-semibold">
                        <div class="mt-0.5 w-5 h-5 rounded-full flex items-center justify-center flex-shrink-0 bg-emerald-100 text-emerald-600">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <span>1 Signature Sherwood Bag</span>
                    </li>
                    <li class="flex items-start space-x-4 text-sm font-semibold">
                        <div class="mt-0.5 w-5 h-5 rounded-full flex items-center justify-center flex-shrink-0 bg-emerald-100 text-emerald-600">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <span>Next-day delivery included</span>
                    </li>
                    <li class="flex items-start space-x-4 text-sm font-semibold">
                        <div class="mt-0.5 w-5 h-5 rounded-full flex items-center justify-center flex-shrink-0 bg-emerald-100 text-emerald-600">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <span>Expert Wash & Fold</span>
                    </li>
                    <li class="flex items-start space-x-4 text-sm font-semibold">
                        <div class="mt-0.5 w-5 h-5 rounded-full flex items-center justify-center flex-shrink-0 bg-emerald-100 text-emerald-600">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <span>Fragrance-free options</span>
                    </li>
                    <li class="flex items-start space-x-4 text-sm font-semibold">
                        <div class="mt-0.5 w-5 h-5 rounded-full flex items-center justify-center flex-shrink-0 bg-emerald-100 text-emerald-600">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <span>Pick your pickup date</span>
                    </li>
                </ul>

                <button class="w-full py-5 rounded-2xl font-black transition-all transform hover:-translate-y-1 bg-slate-900 text-white hover:bg-slate-800">
                    Order Individual Bags
                </button>
            </div>

            {{-- The Family Plan (Highlighted) --}}
            <div class="relative p-10 rounded-[40px] transition-all duration-500 border-2 bg-slate-900 text-white border-slate-900 shadow-2xl scale-105 z-10">
                <div class="absolute -top-5 left-1/2 -translate-x-1/2 bg-emerald-500 text-white text-xs font-black px-6 py-2 rounded-full uppercase tracking-[0.2em] shadow-lg">
                    Most Popular
                </div>

                <h3 class="text-2xl font-bold mb-4">The Family Plan</h3>
                <div class="flex items-baseline space-x-2 mb-6">
                    <span class="text-5xl font-black">$200</span>
                    <span class="text-slate-400 font-bold">/mo</span>
                </div>
                <p class="text-sm mb-10 font-medium leading-relaxed text-slate-400">
                    Our core service. Designed specifically for the typical Sherwood family of four.
                </p>

                <ul class="space-y-5 mb-12">
                    <li class="flex items-start space-x-4 text-sm font-semibold">
                        <div class="mt-0.5 w-5 h-5 rounded-full flex items-center justify-center flex-shrink-0 bg-emerald-500 text-white">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <span>4 Large Bags per month</span>
                    </li>
                    <li class="flex items-start space-x-4 text-sm font-semibold">
                        <div class="mt-0.5 w-5 h-5 rounded-full flex items-center justify-center flex-shrink-0 bg-emerald-500 text-white">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <span>Next-day delivery included</span>
                    </li>
                    <li class="flex items-start space-x-4 text-sm font-semibold">
                        <div class="mt-0.5 w-5 h-5 rounded-full flex items-center justify-center flex-shrink-0 bg-emerald-500 text-white">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <span>Priority scheduling</span>
                    </li>
                    <li class="flex items-start space-x-4 text-sm font-semibold">
                        <div class="mt-0.5 w-5 h-5 rounded-full flex items-center justify-center flex-shrink-0 bg-emerald-500 text-white">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <span>Dedicated account manager</span>
                    </li>
                    <li class="flex items-start space-x-4 text-sm font-semibold">
                        <div class="mt-0.5 w-5 h-5 rounded-full flex items-center justify-center flex-shrink-0 bg-emerald-500 text-white">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <span>Extra bags only $50/ea</span>
                    </li>
                </ul>

                <button class="w-full py-5 rounded-2xl font-black transition-all transform hover:-translate-y-1 bg-emerald-600 text-white hover:bg-emerald-500 shadow-emerald-900/40 shadow-xl">
                    Join the Family
                </button>
            </div>

            {{-- Grand Household --}}
            <div class="relative p-10 rounded-[40px] transition-all duration-500 border-2 bg-white text-slate-900 border-slate-100 shadow-xl shadow-slate-100 hover:border-emerald-200">
                <h3 class="text-2xl font-bold mb-4">Grand Household</h3>
                <div class="flex items-baseline space-x-2 mb-6">
                    <span class="text-5xl font-black">$250+</span>
                    <span class="text-slate-500 font-bold">/mo</span>
                </div>
                <p class="text-sm mb-10 font-medium leading-relaxed text-slate-500">
                    For households of 5+. We scale the convenience so you never fall behind.
                </p>

                <ul class="space-y-5 mb-12">
                    <li class="flex items-start space-x-4 text-sm font-semibold">
                        <div class="mt-0.5 w-5 h-5 rounded-full flex items-center justify-center flex-shrink-0 bg-emerald-100 text-emerald-600">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <span>5+ Bags per month</span>
                    </li>
                    <li class="flex items-start space-x-4 text-sm font-semibold">
                        <div class="mt-0.5 w-5 h-5 rounded-full flex items-center justify-center flex-shrink-0 bg-emerald-100 text-emerald-600">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <span>Next-day delivery included</span>
                    </li>
                    <li class="flex items-start space-x-4 text-sm font-semibold">
                        <div class="mt-0.5 w-5 h-5 rounded-full flex items-center justify-center flex-shrink-0 bg-emerald-100 text-emerald-600">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <span>VIP Laundry treatment</span>
                    </li>
                    <li class="flex items-start space-x-4 text-sm font-semibold">
                        <div class="mt-0.5 w-5 h-5 rounded-full flex items-center justify-center flex-shrink-0 bg-emerald-100 text-emerald-600">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <span>Special item care</span>
                    </li>
                    <li class="flex items-start space-x-4 text-sm font-semibold">
                        <div class="mt-0.5 w-5 h-5 rounded-full flex items-center justify-center flex-shrink-0 bg-emerald-100 text-emerald-600">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <span>Flexible volume billing</span>
                    </li>
                </ul>

                <button class="w-full py-5 rounded-2xl font-black transition-all transform hover:-translate-y-1 bg-slate-900 text-white hover:bg-slate-800">
                    Request Custom Quote
                </button>
            </div>
        </div>

        {{-- Testimonial --}}
        <div class="mt-20 max-w-3xl mx-auto bg-slate-50 p-8 rounded-[32px] text-center">
            <p class="text-slate-600 font-medium italic">
                "As a mom of three in Sherwood, Sherwood Laundry didn't just clean my clothes—they gave me my Sundays back."
                <span class="block mt-2 text-slate-900 font-bold not-italic">— Sarah J., Sherwood Resident</span>
            </p>
        </div>
    </div>
</section>
