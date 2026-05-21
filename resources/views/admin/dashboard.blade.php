@extends('layouts.admin')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <!-- Total Sales -->
    <div class="bg-white p-6 rounded-lg shadow">
        <h3 class="text-gray-500 text-sm">Total Sales</h3>
        <p class="text-2xl font-bold text-green-600">₱{{ number_format($totalSales, 2) }}</p>
    </div>
    
    <!-- Pending Orders -->
    <div class="bg-white p-6 rounded-lg shadow">
        <h3 class="text-gray-500 text-sm">Pending Orders</h3>
        <p class="text-2xl font-bold text-yellow-600">{{ $pendingCount }}</p>
    </div>
    
    <!-- Completed Orders -->
    <div class="bg-white p-6 rounded-lg shadow">
        <h3 class="text-gray-500 text-sm">Completed Orders</h3>
        <p class="text-2xl font-bold text-green-600">{{ $completedCount }}</p>
    </div>
    
    <!-- Store Status -->
    <!-- Store Status -->
<!-- Store Status -->
<div class="bg-white p-6 rounded-lg shadow">
    <h3 class="text-gray-500 text-sm mb-2">Store Status</h3>

    @php
        $setting = \App\Models\Setting::first();
        $storeStatus = optional($setting)->store_status ?? 'open';
    @endphp

    <div class="flex items-center gap-3">

        <!-- Status Dot -->
        <div class="w-4 h-4 rounded-full 
            {{ $storeStatus == 'open' ? 'bg-green-500' : 'bg-red-500' }}">
        </div>

        <!-- Status Text -->
        <p class="text-2xl font-bold 
            {{ $storeStatus == 'open' ? 'text-green-600' : 'text-red-600' }}">

            {{ $storeStatus == 'open' ? 'OPEN' : 'CLOSED' }}

        </p>
    </div>
</div>

<!-- Recent Orders -->
<div class="bg-white p-6 rounded-lg shadow">
    <h2 class="text-xl font-bold mb-4">Recent Orders</h2>
    <table class="w-full text-left">
        <thead class="border-b">
            <tr>
                <th class="p-2">ID</th>
                <th class="p-2">Customer</th>
                <th class="p-2">Total</th>
                <th class="p-2">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
            <tr class="border-b">
                <td class="p-2">#{{ $order->id }}</td>
                <td class="p-2">{{ $order->customer_name }}</td>
                <td class="p-2">₱{{ $order->total_price }}</td>
                <td class="p-2">
                    <span class="px-2 py-1 rounded text-xs font-bold 
                        @if($order->status == 'Pending') bg-yellow-200 text-yellow-800
                        @elseif($order->status == 'Preparing') bg-blue-200 text-blue-800
                        @else bg-green-200 text-green-800 @endif">
                        {{ $order->status }}
                    </span>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection