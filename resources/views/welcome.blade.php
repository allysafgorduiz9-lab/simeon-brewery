@extends('layouts.main')

@section('content')

<!-- HERO SECTION -->
<div class="relative flex items-center justify-center py-32 md:py-40 text-center">

    <!-- Background Overlay (match main design style) -->
    <div class="absolute inset-0 bg-gradient-to-b from-coffee-900/80 to-coffee-900/90"></div>

    <div class="relative z-10 container mx-auto px-6 max-w-4xl">

        <h1 class="text-5xl md:text-7xl font-black text-white tracking-tight mb-4">
            Simeon Brewers
        </h1>

        <p class="text-amber-200/80 text-lg md:text-xl font-medium max-w-xl mx-auto mb-10">
            Premium roasted coffee for the perfect morning.
        </p>

        @php
            $setting = \App\Models\Setting::first();
            $storeStatus = optional($setting)->store_status ?? 'open';
        @endphp

        @if($storeStatus == 'open')
            <a href="/menu"
               class="inline-flex items-center gap-2 bg-amber-600 hover:bg-amber-500 text-white font-bold px-8 py-4 rounded-lg transition shadow-lg hover:shadow-xl active:scale-95">
                Order Now
            </a>
        @else
            <div class="inline-flex items-center gap-2 bg-red-500/10 border border-red-500/30 text-red-300 px-6 py-3 rounded-full font-semibold">
                Store is Currently Closed
            </div>
        @endif

        <!-- ABOUT CARD (MATCHES MAIN DESIGN) -->
        <div class="mt-12 bg-white/5 backdrop-blur-xl border border-white/10 rounded-2xl p-8 md:p-10 max-w-2xl mx-auto">
            <h2 class="text-2xl font-bold text-amber-400 mb-3">
                Our Coffee
            </h2>
            <p class="text-gray-300 text-sm md:text-base leading-relaxed">
                We serve freshly roasted beans sourced from the best local farms.
                Experience the rich taste of Simeon Brewers.
            </p>
        </div>

    </div>
</div>

<!-- OPTIONAL CONTENT AREA -->
<section class="bg-coffee-100 py-16">
    <div class="container mx-auto text-center">
        <h2 class="text-3xl font-bold text-coffee-900 mb-4">
            Welcome to Simeon Brewers
        </h2>
        <p class="text-gray-600 max-w-2xl mx-auto">
            Enjoy premium coffee, freshly brewed and served with passion.
        </p>
    </div>
</section>

@endsection