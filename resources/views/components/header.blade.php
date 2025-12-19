{{--
    File: header.blade.php
    Description: Fixed header navigation component
    Copyright: 2025 Cloudmanic Labs, LLC
    Date: 2025-12-18
--}}
<header class="fixed top-0 left-0 right-0 z-50 bg-white/90 backdrop-blur-md border-b border-slate-100">
    <div class="container mx-auto px-4 h-20 flex items-center justify-between">
        <a href="/" class="flex items-center group">
            <span class="text-2xl font-bold tracking-tight text-slate-900">
                {{ $city['name'] }} <span class="text-emerald-600 font-serif italic">Laundry</span>
            </span>
        </a>

        <nav class="hidden lg:flex items-center space-x-8 text-sm font-bold text-slate-600 uppercase tracking-widest">
            <a href="{{ url('/#how-it-works') }}" class="hover:text-emerald-600 transition-colors">Process</a>
            <a href="{{ url('/#pricing') }}" class="hover:text-emerald-600 transition-colors">Pricing</a>
            <a href="{{ url('/#faq') }}" class="hover:text-emerald-600 transition-colors">FAQ</a>
        </nav>

        <div class="flex items-center space-x-4">
            <div class="hidden md:block text-right mr-4">
                <p class="text-[10px] font-black uppercase tracking-tighter text-slate-400 leading-none">{{ $city['pricing']['family']['name'] }}</p>
                <p class="text-emerald-600 font-bold">{{ $city['pricing']['family']['price_display'] }} / Month</p>
            </div>
            <a
                href="{{ url('/#signup') }}"
                class="bg-slate-900 text-white px-6 py-2.5 rounded-full font-bold hover:bg-emerald-600 transition-all shadow-lg text-sm"
            >
                Get Started
            </a>
        </div>
    </div>
</header>
