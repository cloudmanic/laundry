{{--
    File: onboarding-placeholder.blade.php
    Description: Placeholder page for the onboarding flow
    Copyright: 2026 Cloudmanic Labs, LLC
    Date: 2026-01-21
--}}
@extends('layouts.app')

@section('title', 'Welcome - ' . $city['brand'])

@section('content')
<div class="min-h-screen flex items-center justify-center bg-slate-50 px-4">
    <div class="max-w-md w-full text-center">
        <div class="bg-emerald-100 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6">
            <svg class="w-10 h-10 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
        </div>
        <h1 class="text-3xl font-bold text-slate-900 mb-4">Welcome, {{ auth()->user()->first_name }}!</h1>
        <p class="text-slate-600 mb-8">
            Your account has been created successfully. The onboarding flow will be implemented in a future update.
        </p>
        <form action="{{ route('logout') }}" method="POST" class="inline">
            @csrf
            <button type="submit" class="text-emerald-600 hover:text-emerald-700 font-semibold">
                Sign Out
            </button>
        </form>
    </div>
</div>
@endsection
