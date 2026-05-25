@extends('layouts.admin')

@section('content')
<div class="p-6">
    <h1 class="text-2xl font-black mb-6 text-stone-900">Active Orders</h1>

    <div class="bg-white rounded-xl shadow-sm border border-stone-200 overflow-hidden">
        <table class="w-full text-left">
            <thead class="bg-coffee-900 text-white text-xs uppercase font-bold">
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
            <tbody class="divide-y divide-stone-100 text-sm">
                @foreach($orders as $order)
                <tr class="hover:bg-stone-50 transition">
                    <td class="p-4 font-bold">#{{ $order->id }}</td>
                    <td class="p-4">{{ $order->customer_name }}</td>
                    <td class="p-4">{{ $order->phone_number }}</td>
                    <td class="p-4">{{ $order->payment_method }}</td>
                    <td class="p-4 font-bold">₱{{ number_format($order->total_price, 2) }}</td>
                    <td class="p-4">
                        <span class="px-2.5 py-1 rounded-full text-xs font-black 
                            @if($order->status == 'Pending') bg-yellow-100 text-yellow-700
                            @elseif($order->status == 'Preparing') bg-blue-100 text-blue-700
                            @elseif($order->status == 'Cancelled') bg-rose-100 text-rose-700
                            @else bg-emerald-100 text-emerald-700 @endif">
                            {{ $order->status }}
                        </span>
                    </td>
                    <td class="p-4">
                        <form action="{{ route('admin.order.update', $order->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <select name="status" onchange="this.form.submit()" class="border border-stone-300 p-1.5 rounded-lg text-xs font-bold focus:ring-2 focus:ring-amber-500">
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
</div>

<script>
    let lastOrderCount = {{ \App\Models\Order::count() }};
    const audio = new Audio("{{ asset('sounds/new-order.mp3') }}");

    setInterval(function() {
        fetch('/admin/check-new-orders')
            .then(response => response.json())
            .then(data => {
                if (data.count > lastOrderCount) {
                    audio.play().catch(e => console.log("Audio awaiting user interaction"));
                    alert("🔔 New order received!");
                    location.reload(); 
                }
            });
    }, 15000); 
</script>
@endsection