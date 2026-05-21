@extends('layouts.main')

@section('content')
<div class="bg-stone-50 min-h-screen py-16">
    <div class="container mx-auto px-6 max-w-6xl">
        
        <div class="text-center mb-16">
            <span class="text-xs font-bold uppercase tracking-widest text-amber-600 block mb-2">Artisan Batches</span>
            <h1 class="text-3xl md:text-5xl font-black text-coffee-900 tracking-tight">Our Menu</h1>
        </div>

        @foreach($categories as $category)
            <div class="mb-16">
                <div class="flex items-center gap-4 mb-8">
                    <h2 class="text-xl md:text-2xl font-black text-coffee-700 tracking-wide uppercase">{{ $category->name }}</h2>
                    <div class="h-px bg-coffee-200 flex-grow"></div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($category->products as $product)
                        
                        <div class="bg-white rounded-2xl overflow-hidden shadow-sm border border-coffee-200/60 flex flex-col transition-all duration-300 {{ $product->stock ? 'hover:shadow-md hover:-translate-y-1' : 'opacity-60 grayscale bg-zinc-50' }}">

                            <div class="h-44 bg-stone-100 flex items-center justify-center relative overflow-hidden">
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" 
                                         alt="{{ $product->name }}" 
                                         class="w-full h-full object-cover">
                                @else
                                    <div class="w-12 h-12 rounded-full bg-white flex items-center justify-center shadow-sm text-coffee-700 text-xl font-bold">
                                        ☕
                                    </div>
                                @endif

                                @if(!$product->stock)
                                    <div class="absolute inset-0 bg-black/40 flex items-center justify-center backdrop-blur-[1px]">
                                        <span class="bg-rose-600 text-white text-xs px-3 py-1.5 rounded-full font-bold uppercase tracking-wider shadow-md">Sold Out</span>
                                    </div>
                                @endif
                            </div>
                               
                            <div class="p-6 flex flex-col flex-grow">
                                <div class="flex justify-between items-start mb-2 gap-2">
                                    <h3 class="font-bold text-lg text-coffee-900 tracking-tight leading-tight">{{ $product->name }}</h3>
                                    
                                    @if($product->stock)
                                        <span class="text-lg font-black text-amber-600 shrink-0">₱{{ number_format($product->price, 2) }}</span>
                                    @else
                                        <span class="text-lg font-bold text-zinc-400 shrink-0 line-through">₱{{ number_format($product->price, 2) }}</span>
                                    @endif
                                </div>
                                
                                <p class="text-gray-500 text-xs md:text-sm leading-relaxed mb-6 flex-grow line-clamp-2">
                                    {{ $product->description }}
                                </p>
                                
                                <div class="mt-auto">
                                    @if(!$product->stock)
                                        <button type="button" disabled class="w-full bg-zinc-300 text-zinc-500 font-bold text-sm py-2.5 px-4 rounded-xl cursor-not-allowed">
                                            Sold Out
                                        </button>
                                    @elseif(!$isStoreOpen)
                                        <button type="button" disabled class="w-full bg-stone-200 text-stone-400 font-bold text-sm py-2.5 px-4 rounded-xl cursor-not-allowed text-center">
                                            🚫 Store Closed
                                        </button>
                                        <p class="text-[10px] text-stone-400 text-center mt-1">Ordering temporarily unavailable</p>
                                    @else
                                        <form action="{{ route('addCart') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                                            <button type="submit" class="w-full bg-amber-600 hover:bg-amber-700 text-white font-bold text-sm py-2.5 px-4 rounded-xl transition duration-200 shadow-sm">
                                                Add to Cart
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>

                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach

    </div>
</div>
@endsection