@extends('layouts.main')

@section('content')
<div class="bg-stone-50 min-h-screen py-16">
    <div class="container mx-auto px-6 max-w-6xl">
        
        <div class="text-center mb-16">
            <span class="text-xs font-bold uppercase tracking-widest text-amber-600 block mb-2">Artisan Batches</span>
            <h1 class="text-3xl md:text-5xl font-black text-coffee-900 tracking-tight">Our Menu (TEST MODE)</h1>
        </div>

        @forelse($categories as $category)
            <div class="mb-16">
                <div class="flex items-center gap-4 mb-8">
                    <h2 class="text-xl md:text-2xl font-black text-coffee-700 tracking-wide uppercase">{{ $category->name }}</h2>
                    <div class="h-px bg-coffee-200 flex-grow"></div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @forelse($category->products as $product)
                        <div class="bg-white rounded-2xl overflow-hidden shadow-sm border border-coffee-200/60 flex flex-col transition-all duration-300">
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
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-stone-400 text-sm col-span-3">⚠️ This category has no products linked to it in the database.</p>
                    @endforelse
                </div>
            </div>
        @empty
            <div class="bg-amber-50 border border-amber-200 rounded-xl p-6 text-center">
                <p class="text-amber-800 font-bold">🚨 Database Verification Error</p>
                <p class="text-amber-700 text-sm mt-1">Laravel successfully connected to the cluster but the 'categories' table contains 0 rows.</p>
            </div>
        @endforelse

    </div>
</div>
@endsection