@extends('layouts.main')

@section('content')
<div class="bg-stone-50 min-h-screen py-10">
    <div class="container mx-auto">
        <h1 class="text-4xl font-bold text-center text-coffee-900 mb-2">Our Menu</h1>
        <p class="text-center text-gray-500 mb-10">Choose your favorite brew</p>

        @foreach($categories as $category)
            <div class="mb-12">
                <h2 class="text-2xl font-bold text-coffee-700 border-l-4 border-yellow-600 pl-4 mb-6">{{ $category->name }}</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($category->products as $product)
                        <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition duration-300 {{ $product->is_available ? '' : 'opacity-60 grayscale' }}">
                            <!-- Image Placeholder -->
                            <div class="h-48 bg-coffee-200 flex items-center justify-center">
                                <span class="text-4xl">☕</span>
                            </div>
                            
                            <div class="p-6">
                                <div class="flex justify-between items-start mb-2">
                                    <h3 class="font-bold text-xl text-coffee-900">{{ $product->name }}</h3>
                                    @if(!$product->is_available)
                                        <span class="bg-red-100 text-red-600 text-xs px-2 py-1 rounded-full font-bold">Sold Out</span>
                                    @endif
                                </div>
                                <p class="text-gray-500 text-sm mb-4">{{ $product->description }}</p>
                                <div class="flex justify-between items-center">
                                    <span class="text-xl font-bold text-yellow-700">₱{{ number_format($product->price, 2) }}</span>
                                    
                                    <form action="{{ route('addCart') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $product->id }}">
                                        <button type="submit" class="bg-coffee-700 hover:bg-coffee-800 text-white px-4 py-2 rounded-lg transition {{ $product->is_available ? '' : 'bg-gray-400 cursor-not-allowed' }}" {{ $product->is_available ? '' : 'disabled' }}>
                                            {{ $product->is_available ? 'Add to Cart' : 'Unavailable' }}
                                        </button>
                                    </form>
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