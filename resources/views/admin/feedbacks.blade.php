@extends('layouts.admin')

@section('content')
<h1 class="text-2xl font-bold mb-6">Customer Feedbacks</h1>

<div class="grid gap-6">
    @forelse($feedbacks as $feedback)
    <div class="bg-white p-6 rounded-lg shadow border-l-4 border-yellow-500">
        <div class="flex justify-between items-start mb-2">
            <h3 class="font-bold text-lg">{{ $feedback->customer_name }}</h3>
            <div class="flex">
                @for($i = 1; $i <= 5; $i++)
                    <span class="{{ $i <= $feedback->rating ? 'text-yellow-500' : 'text-gray-300' }}">★</span>
                @endfor
            </div>
        </div>
        <p class="text-gray-600">{{ $feedback->message }}</p>
        <p class="text-sm text-gray-400 mt-2">{{ $feedback->created_at->format('M d, Y - h:i A') }}</p>
    </div>
    @empty
    <div class="bg-white p-8 rounded-lg shadow text-center text-gray-500">
        <p>No feedbacks yet.</p>
    </div>
    @endforelse
</div>
@endsection