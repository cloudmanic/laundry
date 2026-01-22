{{--
    File: reset-password-placeholder.blade.php
    Description: Placeholder page for reset password functionality
    Copyright: 2026 Cloudmanic Labs, LLC
    Date: 2026-01-22
--}}
@extends('layouts.app')

@section('title', 'Reset Password')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-slate-50 px-4">
    <div class="max-w-md w-full text-center">
        <div class="bg-white rounded-2xl shadow-lg p-8">
            <div class="w-16 h-16 bg-emerald-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-8 h-8 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                </svg>
            </div>
            <h1 class="text-2xl font-bold text-slate-900 mb-4">Reset Password</h1>
            <p class="text-slate-600 mb-6">
                This feature is coming soon. Please contact support at
                <a href="mailto:{{ $city['contact']['support_email'] }}" class="text-emerald-600 hover:text-emerald-700 font-medium">
                    {{ $city['contact']['support_email'] }}
                </a>
                if you need to reset your password.
            </p>
            <a href="{{ route('login') }}" class="inline-flex items-center text-emerald-600 hover:text-emerald-700 font-medium">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to login
            </a>
        </div>
    </div>
</div>
@endsection
