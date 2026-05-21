@extends('layouts.admin') {{-- Change this to match your admin layout template name if different --}}

@block('content')
<div class="container-fluid px-4 py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Simeon Cafe — All Orders Queue</h1>
        <span class="badge bg-dark text-white px-3 py-2">Total: {{ $orders->total() }} Orders</span>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle" width="100%" cellspacing="0">
                    <thead class="table-dark">
                        <tr>
                            <th>Order ID</th>
                            <th>Customer Name</th>
                            <th>Phone</th>
                            <th>Type</th>
                            <th>Payment</th>
                            <th>Ordered Items</th>
                            <th>Total Price</th>
                            <th>Status</th>
                            <th>Date & Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($orders as $order)
                            <tr>
                                <td><strong>#ORD-{{ $order->id }}</strong></td>
                                <td>{{ $order->customer_name }}</td>
                                <td>{{ $order->phone ?? 'N/A' }}</td>
                                <td>
                                    <span class="badge {{ $order->order_type === 'dinein' ? 'bg-info' : 'bg-warning text-dark' }}">
                                        {{ ucfirst($order->order_type) }}
                                    </span>
                                </td>
                                <td><span class="text-muted">{{ $order->method }}</span></td>
                                <td>
                                    <ul class="list-unstyled mb-0 sm-text">
                                        @foreach ($order->items as $item)
                                            <li>• {{ $item->product_name }} <span class="text-muted">x{{ $item->quantity }}</span></li>
                                        @endforeach
                                    </ul>
                                </td>
                                <td><strong>₱{{ number_format($order->total_price, 2) }}</strong></td>
                                <td>
                                    <span class="badge 
                                        {{ $order->status === 'Pending' ? 'bg-secondary' : '' }}
                                        {{ $order->status === 'Preparing' ? 'bg-primary' : '' }}
                                        {{ $order->status === 'Completed' ? 'bg-success' : '' }}">
                                        {{ $order->status }}
                                    </span>
                                </td>
                                <td>{{ $order->created_at->format('M d, Y - h:i A') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center py-4 text-muted">
                                    No orders have been recorded in the system yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-center mt-4">
                {{ $orders->links() }}
            </div>
        </div>
    </div>
</div>
@endblock