@extends('layouts.main')

@section('content')
<div class="bg-white p-8 rounded shadow-lg border-t-4 border-coffee-700 max-w-md mx-auto text-center mt-10">
    <h1 class="text-3xl font-bold text-coffee-900 mb-2">Order Confirmed!</h1>
    <p class="text-gray-500 mb-6">Thank you for ordering.</p>
    
    <div class="bg-gray-100 p-4 rounded mb-6 text-left">
        <p><strong>Receipt ID:</strong> {{ $receiptId }}</p>
        <p><strong>Name:</strong> {{ $name }}</p>
        <p><strong>Total:</strong> ₱{{ number_format($total, 2) }}</p>
        <p><strong>Method:</strong> {{ $method }}</p>
    </div>

    <a href="/" class="block w-full bg-coffee-700 text-white py-2 rounded">Back to Home</a>
</div>
@endsection