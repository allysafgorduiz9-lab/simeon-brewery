@extends('layouts.admin')

@section('content')
<h1 class="text-2xl font-bold mb-6">Active Orders</h1>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="w-full text-left">
        <thead class="bg-coffee-900 text-white">
            <tr>
                <th class="p-4">ID</th>
                <th class="p-4">Customer</th>
                <th class="p-4">Phone</th>
                <th class="p-4">Payment</th>
                <th class="p-4">Total</th>
                <th class="p-4">Status</th>
                <th class="p-4">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
            <tr class="border-b">
                <td class="p-4">#{{ $order->id }}</td>
                <td class="p-4">{{ $order->customer_name }}</td>
                <td class="p-4">{{ $order->phone_number }}</td>
                <td class="p-4">{{ $order->payment_method }}</td>
                <td class="p-4 font-bold">₱{{ $order->total_price }}</td>
                <td class="p-4">
                    <span class="px-2 py-1 rounded text-sm font-bold 
                        @if($order->status == 'Pending') bg-yellow-200 text-yellow-800
                        @elseif($order->status == 'Preparing') bg-blue-200 text-blue-800
                        @else bg-green-200 text-green-800 @endif">
                        {{ $order->status }}
                    </span>
                </td>
                <td class="p-4">
                    <form action="{{ route('admin.order.update', $order->id) }}" method="POST">
                        @csrf
                        <select name="status" onchange="this.form.submit()" class="border p-2 rounded text-sm">
                            <option value="Pending" {{ $order->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                            <option value="Preparing" {{ $order->status == 'Preparing' ? 'selected' : '' }}>Preparing</option>
                            <option value="Completed" {{ $order->status == 'Completed' ? 'selected' : '' }}>Completed</option>
                            <option value="Cancelled" {{ $order->status == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection