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
                    We offer daily pickups from Monday through Thursday. Anything we pick up in the morning is delivered fresh and folded by the following evening.
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
                    Upon signing up, we'll provide you with our signature Sherwood Laundry bags. Just fill them up and leave them on your porch or designated pickup spot by 8:00 AM on your scheduled day.
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
                    We treat every garment with care. You can use our separate 'delicates' bag for items that need special attention or air drying.
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
                    No! Our family plans are monthly subscriptions, but you can pause or cancel at any time. We want you to stay because you love the service, not because of a contract.
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
                        Are you really in Sherwood?
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
                    Yes! We are 100% locally owned and operated. While our mailing address is in Newberg, we are focused on serving the Sherwood community with local drivers and care.
                </div>
            </div>
        </div>
    </div>
</section>
