{{--
    File: pricing.blade.php
    Description: Pricing section with 3 tiers and email signup modal
    Copyright: 2026 Cloudmanic Labs, LLC
    Date: 2026-03-17
--}}
<section class="py-24 bg-white" id="pricing" x-data="{ showModal: false, selectedPlan: '' }">
    <div class="container mx-auto px-4">
        <div class="text-center mb-20">
            <h2 class="text-4xl font-bold mb-4 text-slate-900 italic font-serif">Weekly service. Monthly pricing.</h2>
            <p class="text-slate-600 max-w-2xl mx-auto text-lg">
                We pick up your laundry <span class="font-semibold text-slate-900 border-b-2 border-emerald-500">every week</span>—you pay one simple monthly price. Cancel anytime.
            </p>
        </div>

        <div class="grid lg:grid-cols-3 gap-10 max-w-6xl mx-auto">
            @foreach(['light', 'family', 'grand'] as $planKey)
                @php $plan = $city['pricing'][$planKey]; @endphp
                <div class="relative p-10 rounded-[40px] transition-all duration-500 border-2 {{ $plan['highlighted'] ? 'bg-slate-900 text-white border-slate-900 shadow-2xl scale-105 z-10' : 'bg-white text-slate-900 border-slate-100 shadow-xl shadow-slate-100 hover:border-emerald-200' }}">
                    @if($plan['highlighted'])
                        <div class="absolute -top-5 left-1/2 -translate-x-1/2 bg-emerald-500 text-white text-xs font-black px-6 py-2 rounded-full uppercase tracking-[0.2em] shadow-lg">
                            Most Popular
                        </div>
                    @endif

                    <h3 class="text-2xl font-bold mb-4">{{ $plan['name'] }}</h3>
                    <div class="flex items-baseline space-x-2 mb-6">
                        <span class="text-5xl font-black">{{ $plan['price_display'] }}</span>
                        <span class="{{ $plan['highlighted'] ? 'text-slate-400' : 'text-slate-500' }} font-bold">/{{ $plan['period'] }}</span>
                    </div>
                    <p class="text-sm mb-10 font-medium leading-relaxed {{ $plan['highlighted'] ? 'text-slate-400' : 'text-slate-500' }}">
                        {{ $plan['description'] }}
                    </p>

                    <ul class="space-y-5 mb-12">
                        @foreach($plan['features'] as $feature)
                            <li class="flex items-start space-x-4 text-sm font-semibold">
                                <div class="mt-0.5 w-5 h-5 rounded-full flex items-center justify-center flex-shrink-0 {{ $plan['highlighted'] ? 'bg-emerald-500 text-white' : 'bg-emerald-100 text-emerald-600' }}">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                                    </svg>
                                </div>
                                <span>{!! $feature !!}</span>
                            </li>
                        @endforeach
                    </ul>

                    <button
                        @click="selectedPlan = '{{ $plan['name'] }}'; showModal = true"
                        class="w-full py-5 rounded-2xl font-black transition-all transform hover:-translate-y-1 {{ $plan['highlighted'] ? 'bg-emerald-600 text-white hover:bg-emerald-500 shadow-emerald-900/40 shadow-xl' : 'bg-slate-900 text-white hover:bg-slate-800' }}"
                    >
                        {{ $plan['cta'] }}
                    </button>
                </div>
            @endforeach
        </div>

        {{-- Testimonial --}}
        <div class="mt-20 max-w-3xl mx-auto bg-slate-50 p-8 rounded-[32px] text-center">
            <p class="text-slate-600 font-medium italic">
                "{{ $city['testimonial']['quote'] }}"
                <span class="block mt-2 text-slate-900 font-bold not-italic">— {{ $city['testimonial']['author'] }}, {{ $city['testimonial']['location'] }}</span>
            </p>
        </div>
    </div>

    {{-- Email Signup Modal --}}
    <div
        x-show="showModal"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-50 flex items-center justify-center p-4"
        @keydown.escape.window="showModal = false"
        x-cloak
    >
        {{-- Backdrop --}}
        <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" @click="showModal = false"></div>

        {{-- Modal Content --}}
        <div
            x-show="showModal"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-95 translate-y-4"
            x-transition:enter-end="opacity-100 scale-100 translate-y-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 scale-100 translate-y-0"
            x-transition:leave-end="opacity-0 scale-95 translate-y-4"
            class="relative bg-white rounded-[32px] shadow-2xl max-w-md w-full p-10 z-10"
        >
            {{-- Close Button --}}
            <button @click="showModal = false" class="absolute top-5 right-5 text-slate-400 hover:text-slate-600 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            {{-- Modal Header --}}
            <div class="text-center mb-8">
                <div class="w-16 h-16 bg-emerald-100 rounded-full flex items-center justify-center mx-auto mb-5">
                    <svg class="w-8 h-8 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-slate-900 mb-2" style="font-family: 'Playfair Display', serif;">Get Started with <span x-text="selectedPlan"></span></h3>
                <p class="text-slate-500 text-sm font-medium">Enter your email and we'll reach out to get you set up with weekly laundry service.</p>
            </div>

            {{-- Email Form --}}
            <form action="{{ route('subscribe') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <input
                        type="email"
                        name="email"
                        placeholder="Enter your email address..."
                        required
                        class="w-full px-6 py-4 rounded-2xl border-2 border-slate-200 focus:border-emerald-500 focus:outline-none text-slate-900 font-medium transition-colors"
                    />
                </div>
                <button
                    type="submit"
                    class="w-full bg-emerald-600 text-white py-4 rounded-2xl font-black hover:bg-emerald-700 transition-all shadow-lg uppercase tracking-wider text-sm"
                >
                    Free My Weekend
                </button>
            </form>

            {{-- Trust Note --}}
            <p class="text-center text-xs text-slate-400 mt-5 font-medium">No spam, ever. We'll just reach out to schedule your first pickup.</p>
        </div>
    </div>
</section>
