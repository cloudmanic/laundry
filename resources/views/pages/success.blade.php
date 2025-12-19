{{--
    File: success.blade.php
    Description: Success/Thank you page after email signup
    Copyright: 2025 Cloudmanic Labs, LLC
    Date: 2025-12-18
--}}
@extends('layouts.app')

@section('title', 'Thank You | Sherwood Laundry')

@section('content')
    <div class="min-h-screen bg-slate-50 flex flex-col">
        <header class="container mx-auto px-4 py-8">
            <a href="/" class="flex items-center space-x-2 group">
                <div class="w-10 h-10 bg-emerald-600 rounded-lg flex items-center justify-center text-white font-bold text-xl">
                    SL
                </div>
                <span class="text-2xl font-bold tracking-tight text-slate-900">
                    Sherwood <span class="text-emerald-600 font-serif italic">Laundry</span>
                </span>
            </a>
        </header>

        <main class="flex-grow flex items-center justify-center px-4 py-12">
            <div class="max-w-2xl w-full bg-white rounded-[40px] shadow-2xl shadow-slate-200 p-8 md:p-16 text-center">
                <div class="w-20 h-20 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center mx-auto mb-8">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                    </svg>
                </div>

                <h1 class="text-4xl md:text-5xl font-bold mb-6 text-slate-900">Thank You!</h1>
                <p class="text-xl text-slate-600 mb-10 leading-relaxed">
                    We've received your email address. You're officially on our priority list!
                </p>

                <div class="bg-emerald-50 rounded-3xl p-8 mb-10 text-left border border-emerald-100">
                    <h3 class="text-emerald-800 font-bold text-lg mb-2">Launching February 1st, 2026</h3>
                    <p class="text-emerald-700">
                        Sherwood Laundry is putting the finishing touches on our premium Sherwood facility. You'll be the very first to know when our vans hit the road. Keep an eye on your inbox for a special "Founding Family" discount.
                    </p>
                </div>

                <a
                    href="/"
                    class="inline-block bg-slate-900 text-white px-10 py-4 rounded-2xl font-bold hover:bg-slate-800 transition-all"
                >
                    Back to Home
                </a>

                <div class="mt-12 pt-12 border-t border-slate-100">
                    <p class="text-sm text-slate-400">
                        Questions? Call us at <a href="tel:503-451-0062" class="text-emerald-600 font-semibold">503-451-0062</a>
                    </p>
                </div>
            </div>
        </main>

        <footer class="py-8 text-center text-slate-400 text-sm">
            &copy; {{ date('Y') }} Sherwood Laundry. Sherwood, Oregon.
        </footer>
    </div>
@endsection
