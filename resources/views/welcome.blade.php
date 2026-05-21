@extends('layouts.main')

@section('content')
<!-- Hero Section -->
<div class="hero-bg h-screen flex items-center justify-center relative">
    <!-- Dark Overlay -->
    <div class="absolute inset-0 bg-black opacity-60"></div>
    
    <!-- Content -->
    <div class="relative z-10 text-center text-white px-4">
        <h1 class="text-5xl md:text-7xl font-bold mb-4 text-coffee-300 drop-shadow-lg">Simeon Brewers</h1>
        <p class="text-xl md:text-2xl mb-8 font-light text-gray-200">Premium roasted coffee for the perfect morning.</p>
        
       @php
    $storeStatus = \App\Models\Setting::first()->store_status;
@endphp

@if($storeStatus == 'open')
    <a href="/menu" class="inline-block bg-yellow-600 hover:bg-yellow-700 text-white font-bold py-4 px-10 rounded-full text-lg transition transform hover:scale-105 shadow-xl">
        Order Now
    </a>
@else
    <div class="bg-red-600 inline-block px-8 py-3 rounded font-bold text-white">Store is Currently Closed</div>
@endif
    </div>
</div>

<!-- About Preview -->
<section class="bg-coffee-100 py-16">
    <div class="container mx-auto text-center">
        <h2 class="text-3xl font-bold text-coffee-900 mb-4">Our Coffee</h2>
        <p class="text-gray-600 max-w-2xl mx-auto">We serve freshly roasted beans sourced from the best local farms. Experience the rich taste of Simeon Brewers.</p>
    </div>
</section>
@endsection