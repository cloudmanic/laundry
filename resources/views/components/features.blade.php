{{--
    File: features.blade.php
    Description: How it works section with 3-step process
    Copyright: 2025 Cloudmanic Labs, LLC
    Date: 2025-12-18
--}}
<section class="py-24 bg-white" id="how-it-works">
    <div class="container mx-auto px-4 text-center">
        <h2 class="text-4xl font-bold mb-4 text-slate-900">How It Works</h2>
        <p class="text-slate-600 mb-16 max-w-2xl mx-auto text-lg">
            We've simplified laundry day so you never have to think about sorting, washing, or folding again.
        </p>

        <div class="grid md:grid-cols-3 gap-12">
            {{-- Step 1 --}}
            <div class="relative group">
                <div class="w-20 h-20 bg-emerald-50 text-emerald-600 rounded-3xl flex items-center justify-center mx-auto mb-8 group-hover:bg-emerald-600 group-hover:text-white transition-all duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                </div>
                <h3 class="text-2xl font-bold mb-4">Leave it Out</h3>
                <p class="text-slate-600 leading-relaxed px-4">
                    Place your dirty laundry in your Sherwood bags outside your door in the morning.
                </p>
                <div class="hidden lg:block absolute top-10 -right-4 w-12 h-0.5 bg-slate-100"></div>
            </div>

            {{-- Step 2 --}}
            <div class="relative group">
                <div class="w-20 h-20 bg-emerald-50 text-emerald-600 rounded-3xl flex items-center justify-center mx-auto mb-8 group-hover:bg-emerald-600 group-hover:text-white transition-all duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0" />
                    </svg>
                </div>
                <h3 class="text-2xl font-bold mb-4">We Pick Up</h3>
                <p class="text-slate-600 leading-relaxed px-4">
                    Our local Newberg team swings by and whisk your laundry away to our premium facility.
                </p>
                <div class="hidden lg:block absolute top-10 -right-4 w-12 h-0.5 bg-slate-100"></div>
            </div>

            {{-- Step 3 --}}
            <div class="relative group">
                <div class="w-20 h-20 bg-emerald-50 text-emerald-600 rounded-3xl flex items-center justify-center mx-auto mb-8 group-hover:bg-emerald-600 group-hover:text-white transition-all duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <h3 class="text-2xl font-bold mb-4">Next-Day Delivery</h3>
                <p class="text-slate-600 leading-relaxed px-4">
                    By tomorrow evening, your laundry is back—clean, perfectly folded, and ready for the drawer.
                </p>
            </div>
        </div>
    </div>
</section>
