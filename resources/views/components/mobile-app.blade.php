{{--
    File: mobile-app.blade.php
    Description: Mobile app promotion section
    Copyright: 2025 Cloudmanic Labs, LLC
    Date: 2025-12-18
--}}
<section class="py-24 bg-slate-900 overflow-hidden">
    <div class="container mx-auto px-4">
        <div class="max-w-6xl mx-auto flex flex-col lg:flex-row items-center gap-16">
            {{-- Content --}}
            <div class="flex-1 text-center lg:text-left">
                <h2 class="text-4xl font-bold mb-6 text-white italic font-serif">Manage Everything From Your Phone</h2>
                <p class="text-slate-400 text-lg mb-10 max-w-lg">
                    Once you sign up, download our mobile app to take full control of your laundry subscription. It's never been easier to manage your account on the go.
                </p>

                <div class="grid sm:grid-cols-2 gap-6 mb-10">
                    <div class="flex items-start space-x-4">
                        <div class="w-10 h-10 bg-emerald-500/20 rounded-xl flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-white font-bold mb-1">Real-Time Notifications</h4>
                            <p class="text-slate-400 text-sm">Get alerts for pickups, deliveries, and account updates.</p>
                        </div>
                    </div>

                    <div class="flex items-start space-x-4">
                        <div class="w-10 h-10 bg-emerald-500/20 rounded-xl flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-white font-bold mb-1">Schedule Changes</h4>
                            <p class="text-slate-400 text-sm">Pause service or skip a week with just a tap.</p>
                        </div>
                    </div>

                    <div class="flex items-start space-x-4">
                        <div class="w-10 h-10 bg-emerald-500/20 rounded-xl flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-white font-bold mb-1">Preferences</h4>
                            <p class="text-slate-400 text-sm">Set detergent preferences, folding style, and more.</p>
                        </div>
                    </div>

                    <div class="flex items-start space-x-4">
                        <div class="w-10 h-10 bg-emerald-500/20 rounded-xl flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-white font-bold mb-1">Billing & Plans</h4>
                            <p class="text-slate-400 text-sm">Update payment info or change your plan anytime.</p>
                        </div>
                    </div>
                </div>

                {{-- App Store buttons - uncomment when app is ready
                <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                    <a href="#" class="inline-flex items-center justify-center px-6 py-3 bg-black rounded-xl hover:bg-slate-800 transition-colors">
                        <svg class="w-8 h-8 mr-3" viewBox="0 0 24 24" fill="white">
                            <path d="M18.71 19.5c-.83 1.24-1.71 2.45-3.05 2.47-1.34.03-1.77-.79-3.29-.79-1.53 0-2 .77-3.27.82-1.31.05-2.3-1.32-3.14-2.53C4.25 17 2.94 12.45 4.7 9.39c.87-1.52 2.43-2.48 4.12-2.51 1.28-.02 2.5.87 3.29.87.78 0 2.26-1.07 3.81-.91.65.03 2.47.26 3.64 1.98-.09.06-2.17 1.28-2.15 3.81.03 3.02 2.65 4.03 2.68 4.04-.03.07-.42 1.44-1.38 2.83M13 3.5c.73-.83 1.94-1.46 2.94-1.5.13 1.17-.34 2.35-1.04 3.19-.69.85-1.83 1.51-2.95 1.42-.15-1.15.41-2.35 1.05-3.11z"/>
                        </svg>
                        <div class="text-left">
                            <div class="text-[10px] text-slate-400 uppercase tracking-wide">Download on the</div>
                            <div class="text-white font-semibold text-lg leading-tight">App Store</div>
                        </div>
                    </a>
                    <a href="#" class="inline-flex items-center justify-center px-6 py-3 bg-black rounded-xl hover:bg-slate-800 transition-colors">
                        <svg class="w-8 h-8 mr-3" viewBox="0 0 24 24" fill="white">
                            <path d="M3,20.5V3.5C3,2.91 3.34,2.39 3.84,2.15L13.69,12L3.84,21.85C3.34,21.6 3,21.09 3,20.5M16.81,15.12L6.05,21.34L14.54,12.85L16.81,15.12M20.16,10.81C20.5,11.08 20.75,11.5 20.75,12C20.75,12.5 20.53,12.9 20.18,13.18L17.89,14.5L15.39,12L17.89,9.5L20.16,10.81M6.05,2.66L16.81,8.88L14.54,11.15L6.05,2.66Z"/>
                        </svg>
                        <div class="text-left">
                            <div class="text-[10px] text-slate-400 uppercase tracking-wide">Get it on</div>
                            <div class="text-white font-semibold text-lg leading-tight">Google Play</div>
                        </div>
                    </a>
                </div>
                --}}
            </div>

            {{-- Phone Mockup --}}
            <div class="flex-1 flex justify-center lg:justify-end">
                <div class="relative">
                    {{-- Phone Frame --}}
                    <div class="w-[280px] h-[580px] bg-slate-800 rounded-[3rem] p-3 shadow-2xl shadow-emerald-500/20 border border-slate-700">
                        {{-- Screen --}}
                        <div class="w-full h-full bg-white rounded-[2.25rem] overflow-hidden relative">
                            {{-- Status Bar --}}
                            <div class="bg-slate-900 text-white text-xs px-6 py-2 flex justify-between items-center">
                                <span>9:41</span>
                                <div class="flex items-center space-x-1">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 3C6.95 3 3 6.95 3 12s3.95 9 9 9c.62 0 1.23-.07 1.83-.17l-.23-.87c-.52.11-1.06.17-1.6.17-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8c0 .54-.06 1.08-.17 1.6l.87.23c.1-.6.17-1.21.17-1.83 0-4.05-3.95-9-9-9z"/></svg>
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M2 22h20V2z"/></svg>
                                </div>
                            </div>
                            {{-- App Content --}}
                            <div class="p-5">
                                <div class="text-center mb-6">
                                    <div class="text-slate-900 font-bold text-lg">{{ $city['brand'] }}</div>
                                    <div class="text-emerald-600 text-sm font-medium">Welcome back!</div>
                                </div>

                                {{-- Next Pickup Card --}}
                                <div class="bg-emerald-50 rounded-2xl p-4 mb-4">
                                    <div class="text-xs text-emerald-600 font-bold uppercase tracking-wide mb-1">Next Pickup</div>
                                    <div class="text-slate-900 font-bold text-lg">Tomorrow, 8:00 AM</div>
                                    <div class="text-slate-500 text-sm">4 bags ready</div>
                                </div>

                                {{-- Quick Actions --}}
                                <div class="grid grid-cols-2 gap-3 mb-4">
                                    <div class="bg-slate-100 rounded-xl p-3 text-center">
                                        <svg class="w-6 h-6 mx-auto mb-1 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 9v6m4-6v6m7-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <div class="text-xs font-semibold text-slate-700">Pause</div>
                                    </div>
                                    <div class="bg-slate-100 rounded-xl p-3 text-center">
                                        <svg class="w-6 h-6 mx-auto mb-1 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        <div class="text-xs font-semibold text-slate-700">Schedule</div>
                                    </div>
                                </div>

                                {{-- History --}}
                                <div class="text-xs font-bold text-slate-400 uppercase tracking-wide mb-2">Recent</div>
                                <div class="space-y-2">
                                    <div class="flex items-center justify-between py-2 border-b border-slate-100">
                                        <div>
                                            <div class="text-sm font-semibold text-slate-900">Delivered</div>
                                            <div class="text-xs text-slate-500">Dec 17, 6:30 PM</div>
                                        </div>
                                        <div class="w-2 h-2 bg-emerald-500 rounded-full"></div>
                                    </div>
                                    <div class="flex items-center justify-between py-2 border-b border-slate-100">
                                        <div>
                                            <div class="text-sm font-semibold text-slate-900">Picked Up</div>
                                            <div class="text-xs text-slate-500">Dec 16, 8:15 AM</div>
                                        </div>
                                        <div class="w-2 h-2 bg-emerald-500 rounded-full"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- Decorative elements --}}
                    <div class="absolute -top-10 -right-10 w-40 h-40 bg-emerald-500/10 rounded-full blur-3xl"></div>
                    <div class="absolute -bottom-10 -left-10 w-32 h-32 bg-emerald-500/10 rounded-full blur-3xl"></div>
                </div>
            </div>
        </div>
    </div>
</section>
