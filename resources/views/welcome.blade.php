@extends('layouts.main')

@section('content')

<!-- HERO CONTENT ONLY (NO BRAND, NO BUTTON, NO STATUS) -->
<div class="relative flex items-center justify-center py-32 md:py-40 text-center">

    <!-- Background Overlay -->
    <div class="absolute inset-0 bg-gradient-to-b from-coffee-900/80 to-coffee-900/90"></div>

    <div class="relative z-10 container mx-auto px-6 max-w-4xl">

        <!-- ONLY TAGLINE (NO BRANDING) -->
        <p class="text-amber-200/80 text-lg md:text-xl font-medium max-w-xl mx-auto">
            Premium roasted coffee for the perfect morning.
        </p>

    </div>
</div>

<!-- INFO SECTION -->
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