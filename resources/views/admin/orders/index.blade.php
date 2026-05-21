@extends('layouts.admin') {{-- Extends your main dashboard template --}}

@section('content')
<div class="container-fluid px-4 py-4" style="font-family: 'Nunito', 'Segoe UI', sans-serif;">
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1 text-gray-800 font-weight-bold" style="font-weight: 700;">Simeon Cafe</h1>
            <p class="text-muted small mb-0">All Orders Queue Management</p>
        </div>
        <span class="badge bg-dark text-white px-3 py-2 rounded-pill">Total: {{ $orders->total() }} Orders</span>
    </div>

    <div class="card border-0 shadow-sm rounded-lg mb-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" style="width: 100%;">
                    <thead class="text-white" style="background-color: #1a0f0a;"> {{-- Styled dark coffee palette to match your sidebar --}}
                        <tr>
                            <th class="py-3 px-4">Order ID</th>
                            <th class="py-3">Customer Name</th>
                            <th class="py-3">Phone</th>
                            <th class="py-3">Type</th>
                            <th class="py-3">Payment</th>
                            <th class="py-3">Ordered Items</th>
                            <th class="py-3">Total Price</th>
                            <th class="py-3 text-center" style="width: 180px;">Status / Action</th>
                            <th class="py-3 px-4">Date & Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($orders as $order)
                            <tr class="border-bottom">
                                <td class="px-4"><strong>#ORD-{{ $order->id }}</strong></td>
                                <td class="font-weight-bold" style="font-weight: 600;">{{ $order->customer_name }}</td>
                                <td><span class="text-secondary">{{ $order->phone ?? 'N/A' }}</span></td>
                                <td>
                                    <span class="badge {{ $order->order_type === 'dinein' ? 'bg-info text-white' : 'bg-warning text-dark' }} px-2 py-1 small rounded">
                                        {{ ucfirst($order->order_type) }}
                                    </span>
                                </td>
                                <td><span class="text-muted small">{{ $order->method }}</span></td>
                                <td>
                                    <ul class="list-unstyled mb-0" style="font-size: 0.9rem;">
                                        @foreach ($order->items as $item)
                                            <li><i class="fas fa-coffee text-muted mr-1"></i> {{ $item->product_name }} <strong class="text-dark">x{{ $item->quantity }}</strong></li>
                                        @endforeach
                                    </ul>
                                </td>
                                <td class="text-dark"><strong>₱{{ number_format($order->total_price, 2) }}</strong></td>
                                <td class="text-center">
                                    <form action="{{ route('admin.orders.update-status', $order->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <select name="status" onchange="this.form.submit()" class="form-select form-select-sm font-weight-bold text-center btn-sm text-white rounded-pill border-0 px-2 py-1
                                            {{ $order->status === 'Pending' ? 'bg-secondary' : '' }}
                                            {{ $order->status === 'Preparing' ? 'bg-primary' : '' }}
                                            {{ $order->status === 'Completed' ? 'bg-success' : '' }}">
                                            <option value="Pending" {{ $order->status === 'Pending' ? 'selected' : '' }}>⏳ Pending</option>
                                            <option value="Preparing" {{ $order->status === 'Preparing' ? 'selected' : '' }}>☕ Preparing</option>
                                            <option value="Completed" {{ $order->status === 'Completed' ? 'selected' : '' }}>✅ Completed</option>
                                        </select>
                                    </form>
                                </td>
                                <td class="text-muted small px-4">{{ $order->created_at->format('M d, Y - h:i A') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center py-5 text-muted">
                                    <i class="fas fa-inbox fa-2x mb-2 d-block text-gray-300"></i>
                                    No active orders inside the Simeon queue.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-center mt-3">
        {{ $orders->links() }}
    </div>
</div>
@endsection