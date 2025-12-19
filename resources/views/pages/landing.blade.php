{{--
    File: landing.blade.php
    Description: Main landing page for Sherwood Laundry
    Copyright: 2025 Cloudmanic Labs, LLC
    Date: 2025-12-18
--}}
@extends('layouts.app')

@section('title', $city['brand'] . ' | ' . $city['tagline'])

@section('content')
    @include('components.header')

    <main class="flex-grow">
        @include('components.hero')
        @include('components.service-promise')
        @include('components.features')
        @include('components.educational-callout')
        @include('components.pricing')
        @include('components.faq')
    </main>

    @include('components.footer')
@endsection
