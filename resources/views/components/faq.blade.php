{{--
    File: faq.blade.php
    Description: FAQ section with Alpine.js accordion
    Copyright: 2025 Cloudmanic Labs, LLC
    Date: 2025-12-18
--}}
<section class="py-24 bg-white" id="faq">
    <div class="container mx-auto px-4 max-w-3xl">
        <h2 class="text-4xl font-bold mb-12 text-center">Frequently Asked Questions</h2>

        <div class="space-y-4" x-data="{ openIndex: 0 }">
            {{-- FAQ 1 --}}
            <div
                class="border rounded-2xl transition-all"
                :class="openIndex === 0 ? 'border-emerald-600 ring-1 ring-emerald-600' : 'border-slate-200'"
            >
                <button
                    @click="openIndex = openIndex === 0 ? null : 0"
                    class="w-full px-6 py-5 text-left flex justify-between items-center group"
                >
                    <span class="font-semibold text-slate-900 group-hover:text-emerald-600 transition-colors">
                        What days do you pick up and deliver?
                    </span>
                    <svg
                        class="w-5 h-5 transition-transform duration-300"
                        :class="openIndex === 0 ? 'rotate-180' : ''"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div x-show="openIndex === 0" x-collapse class="px-6 pb-5 text-slate-600 leading-relaxed">
                    After signing up, we'll assign you a regular pickup day based on your neighborhood—just like garbage service. Your laundry is picked up in the morning and delivered fresh and folded by the following evening.
                </div>
            </div>

            {{-- FAQ 2 --}}
            <div
                class="border rounded-2xl transition-all"
                :class="openIndex === 1 ? 'border-emerald-600 ring-1 ring-emerald-600' : 'border-slate-200'"
            >
                <button
                    @click="openIndex = openIndex === 1 ? null : 1"
                    class="w-full px-6 py-5 text-left flex justify-between items-center group"
                >
                    <span class="font-semibold text-slate-900 group-hover:text-emerald-600 transition-colors">
                        How do I leave my laundry out?
                    </span>
                    <svg
                        class="w-5 h-5 transition-transform duration-300"
                        :class="openIndex === 1 ? 'rotate-180' : ''"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div x-show="openIndex === 1" x-collapse class="px-6 pb-5 text-slate-600 leading-relaxed">
                    Upon signing up, we'll provide you with our signature {{ $city['brand'] }} bags. Just fill them up and leave them on your porch or designated pickup spot by 8:00 AM on your scheduled day.
                </div>
            </div>

            {{-- FAQ 3 --}}
            <div
                class="border rounded-2xl transition-all"
                :class="openIndex === 2 ? 'border-emerald-600 ring-1 ring-emerald-600' : 'border-slate-200'"
            >
                <button
                    @click="openIndex = openIndex === 2 ? null : 2"
                    class="w-full px-6 py-5 text-left flex justify-between items-center group"
                >
                    <span class="font-semibold text-slate-900 group-hover:text-emerald-600 transition-colors">
                        What if I have delicate items?
                    </span>
                    <svg
                        class="w-5 h-5 transition-transform duration-300"
                        :class="openIndex === 2 ? 'rotate-180' : ''"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div x-show="openIndex === 2" x-collapse class="px-6 pb-5 text-slate-600 leading-relaxed">
                    For now, our service is designed for standard everyday laundry only. We don't currently offer special treatment for delicates, but a delicates service is coming soon!
                </div>
            </div>

            {{-- FAQ 4 --}}
            <div
                class="border rounded-2xl transition-all"
                :class="openIndex === 3 ? 'border-emerald-600 ring-1 ring-emerald-600' : 'border-slate-200'"
            >
                <button
                    @click="openIndex = openIndex === 3 ? null : 3"
                    class="w-full px-6 py-5 text-left flex justify-between items-center group"
                >
                    <span class="font-semibold text-slate-900 group-hover:text-emerald-600 transition-colors">
                        Is there a long-term commitment?
                    </span>
                    <svg
                        class="w-5 h-5 transition-transform duration-300"
                        :class="openIndex === 3 ? 'rotate-180' : ''"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div x-show="openIndex === 3" x-collapse class="px-6 pb-5 text-slate-600 leading-relaxed">
                    No! Our plans are monthly subscriptions, but you can pause or cancel at any time. We want you to stay because you love the service, not because of a contract.
                </div>
            </div>

            {{-- FAQ 5 --}}
            <div
                class="border rounded-2xl transition-all"
                :class="openIndex === 4 ? 'border-emerald-600 ring-1 ring-emerald-600' : 'border-slate-200'"
            >
                <button
                    @click="openIndex = openIndex === 4 ? null : 4"
                    class="w-full px-6 py-5 text-left flex justify-between items-center group"
                >
                    <span class="font-semibold text-slate-900 group-hover:text-emerald-600 transition-colors">
                        Are you really in {{ $city['name'] }}?
                    </span>
                    <svg
                        class="w-5 h-5 transition-transform duration-300"
                        :class="openIndex === 4 ? 'rotate-180' : ''"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div x-show="openIndex === 4" x-collapse class="px-6 pb-5 text-slate-600 leading-relaxed">
                    Yes! We are 100% locally owned and operated. While our mailing address is in {{ $city['contact']['address']['city'] }}, we are focused on serving the {{ $city['name'] }} community with local drivers and care.
                </div>
            </div>

            {{-- FAQ 6 --}}
            <div
                class="border rounded-2xl transition-all"
                :class="openIndex === 5 ? 'border-emerald-600 ring-1 ring-emerald-600' : 'border-slate-200'"
            >
                <button
                    @click="openIndex = openIndex === 5 ? null : 5"
                    class="w-full px-6 py-5 text-left flex justify-between items-center group"
                >
                    <span class="font-semibold text-slate-900 group-hover:text-emerald-600 transition-colors">
                        Do you offer dry cleaning?
                    </span>
                    <svg
                        class="w-5 h-5 transition-transform duration-300"
                        :class="openIndex === 5 ? 'rotate-180' : ''"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div x-show="openIndex === 5" x-collapse class="px-6 pb-5 text-slate-600 leading-relaxed">
                    Sorry, we don't offer dry cleaning at this time. We're focused on everyday laundry for now, but dry cleaning may be something we add in the future!
                </div>
            </div>

            {{-- FAQ 7 --}}
            <div
                class="border rounded-2xl transition-all"
                :class="openIndex === 6 ? 'border-emerald-600 ring-1 ring-emerald-600' : 'border-slate-200'"
            >
                <button
                    @click="openIndex = openIndex === 6 ? null : 6"
                    class="w-full px-6 py-5 text-left flex justify-between items-center group"
                >
                    <span class="font-semibold text-slate-900 group-hover:text-emerald-600 transition-colors">
                        How will I know when my laundry is picked up or delivered?
                    </span>
                    <svg
                        class="w-5 h-5 transition-transform duration-300"
                        :class="openIndex === 6 ? 'rotate-180' : ''"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div x-show="openIndex === 6" x-collapse class="px-6 pb-5 text-slate-600 leading-relaxed">
                    You'll receive both an email and a text message when your laundry has been picked up, and again when it's been dropped off. No guessing—you'll always know exactly where your laundry is.
                </div>
            </div>

            {{-- FAQ 8 --}}
            <div
                class="border rounded-2xl transition-all"
                :class="openIndex === 7 ? 'border-emerald-600 ring-1 ring-emerald-600' : 'border-slate-200'"
            >
                <button
                    @click="openIndex = openIndex === 7 ? null : 7"
                    class="w-full px-6 py-5 text-left flex justify-between items-center group"
                >
                    <span class="font-semibold text-slate-900 group-hover:text-emerald-600 transition-colors">
                        What happens if I forget to leave my laundry out?
                    </span>
                    <svg
                        class="w-5 h-5 transition-transform duration-300"
                        :class="openIndex === 7 ? 'rotate-180' : ''"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div x-show="openIndex === 7" x-collapse class="px-6 pb-5 text-slate-600 leading-relaxed">
                    Just like garbage service, if you forget to put your laundry out, we'll simply be back the next week. Unfortunately, we're unable to provide refunds or credits for missed pickups at this time.
                </div>
            </div>

            {{-- FAQ 9 --}}
            <div
                class="border rounded-2xl transition-all"
                :class="openIndex === 8 ? 'border-emerald-600 ring-1 ring-emerald-600' : 'border-slate-200'"
            >
                <button
                    @click="openIndex = openIndex === 8 ? null : 8"
                    class="w-full px-6 py-5 text-left flex justify-between items-center group"
                >
                    <span class="font-semibold text-slate-900 group-hover:text-emerald-600 transition-colors">
                        What if I'm out of town?
                    </span>
                    <svg
                        class="w-5 h-5 transition-transform duration-300"
                        :class="openIndex === 8 ? 'rotate-180' : ''"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div x-show="openIndex === 8" x-collapse class="px-6 pb-5 text-slate-600 leading-relaxed">
                    No problem! With 48 hours notice, you can pause your service at any time and receive a credit towards your next monthly bill.
                </div>
            </div>
        </div>
    </div>
</section>
