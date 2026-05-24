@extends('layouts.main')

@section('content')
<div class="bg-stone-50 min-h-screen py-16">
    <div class="container mx-auto px-6 max-w-6xl">
        
        <div class="text-center mb-16">
            <span class="text-xs font-bold uppercase tracking-widest text-amber-600 block mb-2">Artisan Batches</span>
            <h1 class="text-3xl md:text-5xl font-black text-coffee-900 tracking-tight">Our Menu</h1>
        </div>

        <form action="{{ route('menu') }}" method="GET" class="mb-8">
    <input type="text" name="search" value="{{ request('search') }}" 
           placeholder="Search our menu..." 
           class="w-full p-4 rounded-xl border border-coffee-200 shadow-sm focus:ring-2 focus:ring-amber-500 outline-none">
</form>

        <div class="flex flex-col md:flex-row gap-8">
            
            <aside class="w-full md:w-64 flex-shrink-0">
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-coffee-200/60 sticky top-24">
                    <h2 class="font-bold text-coffee-900 mb-4 uppercase text-sm tracking-wider">Categories</h2>
                    <ul class="space-y-2">
    <li>
        <a href="{{ route('menu') }}" class="block font-medium {{ !request('category') ? 'text-amber-600' : 'text-coffee-700' }}">
            All Items
        </a>
    </li>
    @foreach($categories as $category)
        <li>
            <a href="{{ route('menu', ['category' => $category->id]) }}" 
               class="block {{ request('category') == $category->id ? 'text-amber-600 font-bold' : 'text-stone-600 hover:text-amber-600' }}">
                {{ $category->name }}
            </a>
        </li>
    @endforeach
</ul>
                </div>
            </aside>

            <div class="flex-grow">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @forelse($products as $product)
                        <div class="bg-white rounded-2xl overflow-hidden shadow-sm border border-coffee-200/60 flex flex-col transition-all duration-300 hover:shadow-md hover:-translate-y-1">
                            <div class="h-44 bg-stone-100 flex items-center justify-center relative overflow-hidden">
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-12 h-12 rounded-full bg-white flex items-center justify-center shadow-sm text-coffee-700 text-xl font-bold">☕</div>
                                @endif
                            </div>
                                
                            <div class="p-6 flex flex-col flex-grow">
                                <div class="flex justify-between items-start mb-2 gap-2">
                                    <h3 class="font-bold text-lg text-coffee-900 tracking-tight leading-tight">{{ $product->name }}</h3>
                                    <span class="text-lg font-black text-amber-600 shrink-0">₱{{ number_format($product->price, 2) }}</span>
                                </div>
                                
                                <p class="text-gray-500 text-xs md:text-sm leading-relaxed mb-6 flex-grow line-clamp-2">
                                    {{ $product->description }}
                                </p>
                                
                                <div class="mt-auto">
                                    @if($isStoreOpen)
                                        <form action="{{ route('addCart') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                                            <button type="submit" class="w-full bg-amber-600 hover:bg-amber-700 text-white font-bold text-sm py-2.5 px-4 rounded-xl transition duration-200 shadow-sm">
                                                Add to Cart
                                            </button>
                                        </form>
                                    @else
                                        <button type="button" disabled class="w-full bg-stone-200 text-stone-400 font-bold text-sm py-2.5 px-4 rounded-xl cursor-not-allowed text-center">
                                            🚫 Store Closed
                                        </button>
                                        <p class="text-[10px] text-stone-400 text-center mt-1">Ordering temporarily unavailable</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-3 text-center py-12">
                            <p class="text-stone-500 text-lg">No products found.</p>
                        </div>
                    @endforelse
                    </div>
            </div>

        </div>
    </div>
</div>
@endsection