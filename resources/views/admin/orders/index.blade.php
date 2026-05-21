@extends('layouts.admin') {{-- Extends your main dashboard template --}}

@section('content')
<div class="container-fluid px-4 py-4" style="font-family: 'Nunito', 'Segoe UI', sans-serif;">
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1 text-gray-800 font-weight-bold" style="font-weight: 700; letter-spacing: -0.5px;">Simeon Cafe</h1>
            <p class="text-muted small mb-0 font-weight-medium">All Orders Queue Management</p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <span class="badge bg-dark text-white px-3 py-2 rounded-pill font-weight-bold" style="font-size: 0.85rem; box-shadow: 0 2px 4px rgba(0,0,0,0.08);">
                Total: {{ $orders->total() }} Orders
            </span>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-lg overflow-hidden mb-4" style="border-radius: 12px;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" style="width: 100%;">
                    <thead class="text-white border-0" style="background-color: #1d110b; font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.5px;">
                        <tr>
                            <th class="py-3 px-4 border-0" style="font-weight: 600;">Order ID</th>
                            <th class="py-3 border-0" style="font-weight: 600;">Customer</th>
                            <th class="py-3 border-0" style="font-weight: 600;">Phone</th>
                            <th class="py-3 border-0" style="font-weight: 600;">Type</th>
                            <th class="py-3 border-0" style="font-weight: 600;">Payment</th>
                            <th class="py-3 border-0" style="font-weight: 600;">Ordered Items</th>
                            <th class="py-3 border-0" style="font-weight: 600;">Total Price</th>
                            <th class="py-3 border-0 text-center" style="width: 190px; font-weight: 600;">Status / Action</th>
                            <th class="py-3 px-4 border-0 text-right" style="font-weight: 600;">Date & Time</th>
                        </tr>
                    </thead>
                    <tbody style="font-size: 0.9rem; background-color: #ffffff;">
                        @forelse ($orders as $order)
                            <tr class="border-bottom" style="transition: background-color 0.15s ease;">
                                <td class="px-4 font-weight-bold text-secondary" style="font-family: SFMono-Regular, Menlo, Monaco, Consolas, monospace; font-size: 0.85rem;">
                                    <strong>#ORD-{{ $order->id }}</strong>
                                </td>
                                
                                <td class="font-weight-bold text-gray-900" style="font-weight: 600;">
                                    {{ $order->customer_name }}
                                </td>
                                
                                <td>
                                    <span class="text-secondary font-weight-medium" style="font-size: 0.85rem;">{{ $order->phone ?? 'N/A' }}</span>
                                </td>
                                
                                <td>
                                    <span class="badge {{ $order->order_type === 'dinein' ? 'bg-info text-white' : 'bg-warning text-dark' }} px-2.5 py-1.5 rounded font-weight-bold text-xs" style="text-transform: uppercase; letter-spacing: 0.3px;">
                                        {{ ucfirst($order->order_type ?? 'pickup') }}
                                    </span>
                                </td>
                                
                                <td>
                                    <span class="text-muted small font-weight-semibold bg-light px-2 py-1 rounded border">
                                        {{ $order->method }}
                                    </span>
                                </td>
                                
                                <td class="py-3">
                                    <ul class="list-unstyled mb-0" style="font-size: 0.85rem; line-height: 1.5;">
                                        @foreach ($order->items as $item)
                                            <li class="text-gray-800 mb-1 d-flex align-items-center">
                                                <i class="fas fa-coffee text-muted mr-2" style="font-size: 0.75rem; color: #8c6d58 !important;"></i> 
                                                <span>{{ $item->product_name }}</span>
                                                <span class="badge bg-light text-dark border ml-1 px-1.5 py-0.5 rounded font-weight-bold" style="font-size: 0.7rem;">x{{ $item->quantity }}</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                </td>
                                
                                <td class="text-dark font-weight-bold" style="font-size: 1rem; font-weight: 700;">
                                    ₱{{ number_format($order->total_price, 2) }}
                                </td>
                                
                                <td class="text-center px-2">
                                    <form action="{{ route('admin.orders.update-status', $order->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <select name="status" onchange="this.form.submit()" 
                                            class="form-select form-select-sm font-weight-bold text-center rounded-pill border-0 px-3 py-2 cursor-pointer shadow-sm text-white transition-all
                                            {{ $order->status === 'Pending' ? 'bg-secondary' : '' }}
                                            {{ $order->status === 'Preparing' ? 'bg-primary' : '' }}
                                            {{ $order->status === 'Completed' ? 'bg-success' : '' }}"
                                            style="font-size: 0.8rem; letter-spacing: 0.3px; min-width: 140px; background-position: right 12px center; box-shadow: 0 2px 4px rgba(0,0,0,0.05) !important;">
                                            <option value="Pending" {{ $order->status === 'Pending' ? 'selected' : '' }}>⏳ Pending</option>
                                            <option value="Preparing" {{ $order->status === 'Preparing' ? 'selected' : '' }}>☕ Preparing</option>
                                            <option value="Completed" {{ $order->status === 'Completed' ? 'selected' : '' }}>✅ Completed</option>
                                        </select>
                                    </form>
                                </td>
                                
                                <td class="text-muted small px-4 text-right" style="font-size: 0.8rem; white-space: nowrap;">
                                    {{ $order->created_at->format('M d, Y') }}
                                    <div class="text-muted text-[10px] style='font-size: 0.7rem;'">{{ $order->created_at->format('h:i A') }}</div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center py-5 text-muted bg-white">
                                    <div class="py-4">
                                        <i class="fas fa-inbox fa-3x mb-3 d-block text-muted" style="opacity: 0.4;"></i>
                                        <p class="mb-1 font-weight-bold text-dark">Your Queue is Empty</p>
                                        <p class="small text-secondary mb-0">No active coffee or kitchen orders are registered inside Simeon system loop.</p>
                                    </div>
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

<style>
    .table-hover tbody tr:hover {
        background-color: rgba(140, 109, 88, 0.04) !important;
    }
</style>
@endsection