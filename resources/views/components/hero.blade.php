{{--
    File: hero.blade.php
    Description: Hero section with email signup form
    Copyright: 2025 Cloudmanic Labs, LLC
    Date: 2025-12-18
--}}
<section class="relative pt-28 pb-20 lg:pt-36 lg:pb-32 overflow-hidden bg-white" id="signup">
    <div class="container mx-auto px-4">
        <div class="flex flex-col lg:flex-row items-center gap-16">
            {{-- Left Side: Content --}}
            <div class="flex-1 text-left">
                <div class="inline-flex items-center space-x-3 bg-emerald-50 border border-emerald-100 px-4 py-2 rounded-full mb-8">
                    <span class="text-emerald-700 text-xs font-black uppercase tracking-[0.2em]">Locally Owned - {{ $city['name'] }}, {{ $city['contact']['address']['state'] }}</span>
                </div>

                <h1 class="text-5xl md:text-7xl font-black leading-[1] mb-6 text-slate-900 tracking-tighter">
                    YOU'RE BUSY.<br />
                    <span class="text-emerald-600">LET US DO THE WORK.</span>
                </h1>

                <p class="text-xl md:text-2xl font-bold text-slate-600 mb-8 leading-tight">
                    Get weekly laundry service for a family of 4 for only <span class="text-slate-900">{{ $city['pricing']['family']['price_display'] }}/month</span>. <br class="hidden md:block" />
                    We pick up your laundry, wash it, fold it, and deliver it fresh the next day.
                </p>

                <div class="space-y-4 mb-10">
                    <div class="flex items-center space-x-3 text-slate-700 font-semibold">
                        <div class="w-6 h-6 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-600">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" /></svg>
                        </div>
                        <span>4 bags picked up every week (one per person)</span>
                    </div>
                    <div class="flex items-center space-x-3 text-slate-700 font-semibold">
                        <div class="w-6 h-6 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-600">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" /></svg>
                        </div>
                        <span>Next-day turnaround guaranteed</span>
                    </div>
                    <p class="text-sm text-slate-400 font-medium ml-9 italic">
                        Smaller household? 1 bag weekly for {{ $city['pricing']['light']['price_display'] }}/mo.
                    </p>
                </div>

                <form action="{{ route('subscribe') }}" method="POST" class="w-full max-w-xl bg-white p-2 rounded-3xl border-2 border-slate-200 shadow-xl flex flex-col sm:flex-row gap-2">
                    @csrf
                    <input
                        type="email"
                        name="email"
                        placeholder="Enter email to get started..."
                        required
                        class="flex-grow px-6 py-4 rounded-2xl focus:outline-none text-slate-900 font-medium"
                    />
                    <button
                        type="submit"
                        class="bg-emerald-600 text-white px-8 py-4 rounded-2xl font-black hover:bg-emerald-700 transition-all shadow-lg flex items-center justify-center space-x-2 whitespace-nowrap uppercase tracking-wider text-sm"
                    >
                        <span>Free My Weekend</span>
                    </button>
                </form>

                @if(session('error'))
                    <p class="mt-4 text-red-600 text-sm font-medium">{{ session('error') }}</p>
                @endif

                {{-- Social Proof & Call Us --}}
                <div class="mt-8 flex flex-wrap items-center gap-6">
                    <div class="flex items-center space-x-4 bg-white px-5 py-3 rounded-full shadow-lg border border-slate-100">
                        <div class="flex -space-x-2">
                            <img src="https://randomuser.me/api/portraits/women/44.jpg" class="w-8 h-8 rounded-full border-2 border-white" alt="">
                            <img src="https://randomuser.me/api/portraits/men/32.jpg" class="w-8 h-8 rounded-full border-2 border-white" alt="">
                            <img src="https://randomuser.me/api/portraits/women/68.jpg" class="w-8 h-8 rounded-full border-2 border-white" alt="">
                            <img src="https://randomuser.me/api/portraits/men/75.jpg" class="w-8 h-8 rounded-full border-2 border-white" alt="">
                            <img src="https://randomuser.me/api/portraits/women/12.jpg" class="w-8 h-8 rounded-full border-2 border-white" alt="">
                        </div>
                        <p class="text-sm">
                            <span class="text-emerald-600 font-bold">{{ $city['social_proof']['families_joined'] }} local families</span>
                            <span class="text-slate-600">joined this month</span>
                        </p>
                    </div>
                    <div>
                        <p class="text-xs font-black uppercase text-slate-400 tracking-widest mb-1">Call Us</p>
                        <p class="text-base font-bold text-slate-900">{{ $city['contact']['phone'] }}</p>
                    </div>
                </div>
            </div>

            {{-- Right Side: Visual --}}
            <div class="flex-1 w-full relative lg:max-w-md xl:max-w-lg">
                <div class="relative z-10">
                    <img
                        src="/images/sherwood-bag-van.png"
                        alt="{{ $city['brand'] }} service in action"
                        class="aspect-[4/5] lg:aspect-[3/4] shadow-2xl rounded-[50px] object-cover w-full"
                    />
                </div>

                {{-- Decorative blob behind image --}}
                <div class="absolute -top-10 -right-10 w-full h-full bg-emerald-50 rounded-[50px] -z-10 translate-x-4 translate-y-4"></div>

                {{-- Floating Trust Badge --}}
                <div class="absolute -bottom-6 -left-6 bg-white p-6 rounded-3xl shadow-2xl z-20 hidden md:block border border-slate-100">
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 bg-emerald-600 rounded-2xl flex items-center justify-center text-white font-bold text-xl">SL</div>
                        <div>
                            <p class="text-xs font-black uppercase text-slate-400 tracking-widest">Next-Day</p>
                            <p class="text-slate-900 font-bold leading-none">Fresh & Folded</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Background Decorative Elements --}}
    <div class="absolute top-1/4 -left-20 w-64 h-64 bg-emerald-400/10 rounded-full blur-[100px] -z-10"></div>
</section>
