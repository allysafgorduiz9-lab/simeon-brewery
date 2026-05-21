@extends('layouts.admin')

@section('content')
<div class="p-6 bg-stone-50 min-h-screen">
    
    <div class="mb-8">
        <h1 class="text-3xl font-black text-stone-900 tracking-tight">Management Dashboard</h1>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        
        <div class="bg-white p-6 rounded-2xl border border-stone-200/80 shadow-sm flex items-center justify-between">
            <div>
                <h3 class="text-stone-400 text-xs font-bold uppercase tracking-wider mb-1">Total Sales</h3>
                <p class="text-2xl font-black text-stone-900 tracking-tight">₱{{ number_format($totalSales, 2) }}</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shadow-inner">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
        </div>
        
        <div class="bg-white p-6 rounded-2xl border border-stone-200/80 shadow-sm flex items-center justify-between">
            <div>
                <h3 class="text-stone-400 text-xs font-bold uppercase tracking-wider mb-1">Pending Orders</h3>
                <p class="text-2xl font-black text-stone-900 tracking-tight">{{ $pendingCount }}</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center shadow-inner">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
        </div>
        
        <div class="bg-white p-6 rounded-2xl border border-stone-200/80 shadow-sm flex items-center justify-between">
            <div>
                <h3 class="text-stone-400 text-xs font-bold uppercase tracking-wider mb-1">Completed Orders</h3>
                <p class="text-2xl font-black text-stone-900 tracking-tight">{{ $completedCount }}</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shadow-inner">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 002-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
            </div>
        </div>
        
        <div class="bg-white p-6 rounded-2xl border border-stone-200/80 shadow-sm flex items-center justify-between">
            @php
                $setting = \App\Models\Setting::first();
                $storeStatus = optional($setting)->store_status ?? 'open';
            @endphp
            <div>
                <h3 class="text-stone-400 text-xs font-bold uppercase tracking-wider mb-1">Store Status</h3>
                <div class="flex items-center gap-2 mt-1">
                    <span class="relative flex h-2.5 w-2.5">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full opacity-75 {{ $storeStatus == 'open' ? 'bg-emerald-400' : 'bg-rose-400' }}"></span>
                        <span class="relative inline-flex rounded-full h-2.5 w-2.5 {{ $storeStatus == 'open' ? 'bg-emerald-500' : 'bg-rose-500' }}"></span>
                    </span>
                    <p class="text-xl font-black uppercase tracking-wide {{ $storeStatus == 'open' ? 'text-emerald-600' : 'text-rose-600' }}">
                        {{ $storeStatus == 'open' ? 'OPEN' : 'CLOSED' }}
                    </p>
                </div>
            </div>
            <div class="w-12 h-12 rounded-xl flex items-center justify-center shadow-inner {{ $storeStatus == 'open' ? 'bg-emerald-50 text-emerald-600' : 'bg-rose-50 text-rose-600' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 0 0-2-2H7a2 2 0 0 0-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v5m-4 0h4"/></svg>
            </div>
        </div>
    </div>

    <div class="bg-white border border-stone-200/80 rounded-2xl shadow-sm overflow-hidden">
    
    <div class="p-5 border-b border-stone-100 flex items-center justify-between">
        <div>
            <h2 class="text-lg font-black text-stone-900 tracking-tight">
                Recent Orders Queue
            </h2>

            <p class="text-xs text-stone-400 mt-1">
                Real-time customer order monitoring
            </p>
        </div>

        <span class="bg-emerald-100 text-emerald-700 text-xs font-bold px-3 py-1 rounded-full">
            Live Queue
        </span>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">

            <thead>
                <tr class="bg-stone-50 text-stone-400 text-xs font-bold uppercase tracking-wider border-b border-stone-100">

                    <th class="p-4 pl-6">Order ID</th>
                    <th class="p-4">Customer</th>
                    <th class="p-4">Products Ordered</th>
                    <th class="p-4">Total</th>
                    <th class="p-4">Date & Time (PH)</th>
                    <th class="p-4 pr-6 text-center">Status</th>

                </tr>
            </thead>

            <tbody class="divide-y divide-stone-100 text-sm text-stone-700">

                @forelse($orders as $order)

                    <tr class="hover:bg-stone-50/70 transition duration-200">

                        <!-- ORDER ID -->
                        <td class="p-4 pl-6">
                            <span class="bg-stone-100 text-stone-700 px-3 py-1 rounded-lg text-xs font-bold border border-stone-200">
                                #{{ $order->id }}
                            </span>
                        </td>

                        <!-- CUSTOMER -->
                        <td class="p-4">
                            <div class="font-bold text-stone-900">
                                {{ $order->customer_name }}
                            </div>
                        </td>

                        <!-- PRODUCTS -->
                        <td class="p-4">
                            <div class="flex flex-col gap-1">

                                @foreach($order->items as $item)
                                    <span class="inline-flex items-center gap-2 bg-amber-50 text-amber-700 border border-amber-100 text-xs font-semibold px-2 py-1 rounded-lg w-fit">
                                        ☕ {{ $item->product_name }}
                                        <span class="text-stone-400">
                                            x{{ $item->quantity }}
                                        </span>
                                    </span>
                                @endforeach

                            </div>
                        </td>

                        <!-- TOTAL -->
                        <td class="p-4 font-black text-stone-900">
                            ₱{{ number_format($order->total_price, 2) }}
                        </td>

                        <!-- DATE & TIME -->
                        <td class="p-4">
                            <div class="font-semibold text-stone-800">
                                {{ \Carbon\Carbon::parse($order->created_at)->timezone('Asia/Manila')->format('M d, Y') }}
                            </div>

                            <div class="text-xs text-stone-400">
                                {{ \Carbon\Carbon::parse($order->created_at)->timezone('Asia/Manila')->format('h:i A') }}
                            </div>
                        </td>

                        <!-- STATUS -->
                        <td class="p-4 pr-6 text-center">

                            @if($order->status == 'Pending')

                                <span class="inline-block bg-amber-50 text-amber-700 border border-amber-200 text-[11px] font-bold px-3 py-1 rounded-full uppercase tracking-wider">
                                    Pending
                                </span>

                            @elseif($order->status == 'Preparing')

                                <span class="inline-block bg-blue-50 text-blue-700 border border-blue-200 text-[11px] font-bold px-3 py-1 rounded-full uppercase tracking-wider animate-pulse">
                                    Preparing
                                </span>

                            @else

                                <span class="inline-block bg-emerald-50 text-emerald-700 border border-emerald-200 text-[11px] font-bold px-3 py-1 rounded-full uppercase tracking-wider">
                                    Completed
                                </span>

                            @endif

                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="6" class="p-12 text-center text-stone-400">

                            <div class="text-4xl mb-3">
                                ☕
                            </div>

                            <p class="font-semibold">
                                No recent orders found.
                            </p>

                            <p class="text-xs mt-1">
                                Waiting for new customer orders...
                            </p>

                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>
    </div>
</div>
</div>
@endsection