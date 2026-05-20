@extends('layouts.admin')

@section('content')
<h1 class="text-2xl font-bold mb-6">Sales Reports</h1>

<!-- Summary Cards -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-white p-6 rounded-lg shadow">
        <h3 class="text-gray-500 text-sm">Total Sales</h3>
        <p class="text-3xl font-bold text-green-600">₱{{ number_format($totalSales, 2) }}</p>
    </div>
    <div class="bg-white p-6 rounded-lg shadow">
        <h3 class="text-gray-500 text-sm">Completed Orders</h3>
        <p class="text-3xl font-bold text-blue-600">{{ $completedCount }}</p>
    </div>
    <div class="bg-white p-6 rounded-lg shadow">
        <h3 class="text-gray-500 text-sm">This Week</h3>
        <p class="text-3xl font-bold text-coffee-700">Last 7 Days</p>
    </div>
</div>

<!-- Daily Sales Chart -->
<div class="bg-white p-6 rounded-lg shadow mb-6">
    <h2 class="text-xl font-bold mb-4">Daily Sales (Last 7 Days)</h2>
    <div class="flex items-end gap-2 h-64">
        @foreach($dailySales as $date => $amount)
        <div class="flex-1 flex flex-col items-center">
            <div class="w-full bg-coffee-700 rounded-t" style="height: {{ $totalSales > 0 ? ($amount / $totalSales) * 100 : 0 }}%"></div>
            <p class="text-xs mt-2 text-gray-600">{{ date('M d', strtotime($date)) }}</p>
            <p class="text-xs font-bold">₱{{ number_format($amount, 0) }}</p>
        </div>
        @endforeach
    </div>
</div>

<!-- All Completed Orders -->
<div class="bg-white p-6 rounded-lg shadow">
    <h2 class="text-xl font-bold mb-4">Completed Orders List</h2>
    <table class="w-full text-left">
        <thead class="border-b">
            <tr>
                <th class="p-2">ID</th>
                <th class="p-2">Customer</th>
                <th class="p-2">Total</th>
                <th class="p-2">Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
            <tr class="border-b">
                <td class="p-2">#{{ $order->id }}</td>
                <td class="p-2">{{ $order->customer_name }}</td>
                <td class="p-2 font-bold">₱{{ $order->total_price }}</td>
                <td class="p-2">{{ $order->created_at->format('M d, Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection