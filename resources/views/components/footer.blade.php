{{--
    File: footer.blade.php
    Description: Footer component with contact info and links
    Copyright: 2025 Cloudmanic Labs, LLC
    Date: 2025-12-18
--}}
<footer class="bg-slate-900 text-slate-400 py-20" id="contact">
    <div class="container mx-auto px-4">
        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-12 mb-16">
            <div class="col-span-1 lg:col-span-2">
                <div class="flex items-center space-x-3 text-white font-bold text-2xl mb-6">
                    <div class="w-10 h-10 bg-emerald-600 rounded-lg flex items-center justify-center text-white font-bold text-xl">
                        SL
                    </div>
                    <span>{{ $city['brand'] }}</span>
                </div>
                <p class="max-w-md mb-8 leading-relaxed">
                    {{ $city['name'] }}'s premier laundry pickup and delivery service. We believe families deserve more time together, and less time in the laundry room.
                </p>
                <div class="flex space-x-4">
                    <a href="{{ $city['social']['facebook'] }}" class="w-10 h-10 bg-slate-800 rounded-full flex items-center justify-center hover:bg-emerald-600 transition-colors">
                        <span class="sr-only">Facebook</span>
                        <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" /></svg>
                    </a>
                    <a href="{{ $city['social']['instagram'] }}" class="w-10 h-10 bg-slate-800 rounded-full flex items-center justify-center hover:bg-emerald-600 transition-colors">
                        <span class="sr-only">Instagram</span>
                        <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259 0.14 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z" /></svg>
                    </a>
                </div>
            </div>

            <div>
                <h4 class="text-white font-bold mb-6">Contact Us</h4>
                <ul class="space-y-4">
                    <li class="flex items-start space-x-3">
                        <svg class="w-5 h-5 text-emerald-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                        <span>{{ $city['contact']['address']['street'] }}, {{ $city['contact']['address']['suite'] }},<br />{{ $city['contact']['address']['city'] }}, {{ $city['contact']['address']['state'] }} {{ $city['contact']['address']['zip'] }}</span>
                    </li>
                    <li class="flex items-center space-x-3">
                        <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" /></svg>
                        <a href="tel:{{ $city['contact']['phone'] }}" class="hover:text-emerald-500 transition-colors">{{ $city['contact']['phone'] }}</a>
                    </li>
                </ul>
            </div>

            <div>
                <h4 class="text-white font-bold mb-6">Service Area</h4>
                <ul class="space-y-2">
                    @foreach($city['service_areas'] as $area)
                        <li>{{ $area }}</li>
                    @endforeach
                </ul>
            </div>
        </div>

        <div class="border-t border-slate-800 pt-8 flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
            <p class="text-sm">&copy; {{ date('Y') }} {{ $city['brand'] }}. Locally owned in Oregon.</p>
            <div class="flex space-x-6 text-sm">
                <a href="{{ route('privacy-policy') }}" class="hover:text-white transition-colors">Privacy Policy</a>
                <a href="{{ route('terms') }}" class="hover:text-white transition-colors">Terms of Service</a>
                <a href="{{ route('refund-policy') }}" class="hover:text-white transition-colors">Refund Policy</a>
            </div>
        </div>
    </div>
</footer>
