{{--
    File: educational-callout.blade.php
    Description: Educational callout section explaining the bag system
    Copyright: 2025 Cloudmanic Labs, LLC
    Date: 2025-12-18
--}}
<section class="py-24 bg-emerald-50">
    <div class="container mx-auto px-4">
        <div class="max-w-5xl mx-auto bg-white rounded-[40px] shadow-2xl overflow-hidden flex flex-col md:flex-row">
            <div class="flex-1 p-12 lg:p-16">
                <h2 class="text-3xl font-bold text-slate-900 mb-6">Why the Bag System?</h2>
                <p class="text-slate-600 text-lg leading-relaxed mb-8">
                    We don't do complex weighing or confusing itemized lists. Our signature bags are large, durable, and hold everything a family of four needs for the week. If you can fit it in the bag, we wash it. It's that simple.
                </p>
                <div class="space-y-4">
                    <div class="flex items-center space-x-3 text-emerald-700 font-bold">
                        <div class="w-6 h-6 rounded-full bg-emerald-100 flex items-center justify-center">1</div>
                        <span>No hidden weighing fees</span>
                    </div>
                    <div class="flex items-center space-x-3 text-emerald-700 font-bold">
                        <div class="w-6 h-6 rounded-full bg-emerald-100 flex items-center justify-center">2</div>
                        <span>Signature high-density fabric bags</span>
                    </div>
                    <div class="flex items-center space-x-3 text-emerald-700 font-bold">
                        <div class="w-6 h-6 rounded-full bg-emerald-100 flex items-center justify-center">3</div>
                        <span>Eco-friendly laundry care</span>
                    </div>
                </div>
            </div>
            <div class="flex-1 bg-emerald-600 relative overflow-hidden flex items-center justify-center min-h-[300px]">
                <img
                    src="https://images.unsplash.com/photo-1545173168-9f1947eeba01?auto=format&fit=crop&q=80&w=1000"
                    class="absolute inset-0 w-full h-full object-cover opacity-30 mix-blend-overlay"
                    alt="laundry bag background"
                />
                <div class="relative z-10 text-center text-white px-8">
                    <p class="text-6xl font-bold mb-4">4</p>
                    <p class="text-xl font-bold uppercase tracking-widest">Bags Per Family</p>
                </div>
            </div>
        </div>
    </div>
</section>
