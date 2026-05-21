@extends('layouts.admin') {{-- Extends your main dashboard template --}}

@section('content')
<div class="container-fluid px-4 py-4" style="font-family: 'Nunito', 'Segoe UI', sans-serif;">
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1 text-gray-900 font-weight-black" style="font-weight: 800; letter-spacing: -0.75px;">Active Orders Queue</h1>
            <p class="text-muted small mb-0 font-weight-medium" style="font-size: 0.85rem; letter-spacing: 0.2px;">Real-time order management for Simeon Cafe</p>
        </div>
        <div class="d-flex align-items-center">
            <span class="badge border border-gray-200 text-dark px-3 py-2 rounded-lg font-weight-bold" style="font-size: 0.85rem; background-color: #ffffff; box-shadow: 0 1px 3px rgba(0,0,0,0.02); font-weight: 700;">
                <i class="fas fa-list-ol text-muted mr-1"></i> Total: {{ $orders->total() }} Orders
            </span>
        </div>
    </div>

    <div class="card border-0 shadow-sm overflow-hidden mb-4" style="border-radius: 16px; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05) !important;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" style="width: 100%; border-collapse: separate;">
                    <thead class="text-white border-0" style="background-color: #1d110b; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.8px;">
                        <tr>
                            <th class="py-3.5 px-4 border-0" style="font-weight: 700; opacity: 0.95;">Order ID</th>
                            <th class="py-3.5 border-0" style="font-weight: 700; opacity: 0.95;">Customer</th>
                            <th class="py-3.5 border-0" style="font-weight: 700; opacity: 0.95;">Phone</th>
                            <th class="py-3.5 border-0 text-center" style="font-weight: 700; opacity: 0.95; width: 110px;">Type</th>
                            <th class="py-3.5 border-0" style="font-weight: 700; opacity: 0.95;">Payment</th>
                            <th class="py-3.5 border-0" style="font-weight: 700; opacity: 0.95;">Ordered Items</th>
                            <th class="py-3.5 border-0" style="font-weight: 700; opacity: 0.95;">Total Price</th>
                            <th class="py-3.5 border-0 text-center" style="width: 190px; font-weight: 700; opacity: 0.95;">Status / Action</th>
                            <th class="py-3.5 px-4 border-0 text-right" style="font-weight: 700; opacity: 0.95;">Date & Time</th>
                        </tr>
                    </thead>
                    <tbody style="font-size: 0.88rem; background-color: #ffffff;">
                        @forelse ($orders as $order)
                            <tr class="border-bottom" style="transition: all 0.2s ease;">
                                <td class="px-4 font-weight-bold text-secondary" style="font-family: SFMono-Regular, Menlo, Monaco, Consolas, monospace; font-size: 0.8rem; font-weight: 700;">
                                    #ORD-{{ $order->id }}
                                </td>
                                
                                <td class="text-gray-900" style="font-weight: 700; font-size: 0.95rem; color: #2d3748;">
                                    {{ $order->customer_name }}
                                </td>
                                
                                <td>
                                    <span class="text-muted font-weight-medium" style="font-size: 0.85rem;">{{ $order->phone ?? 'N/A' }}</span>
                                </td>
                                
                                <td class="text-center">
                                    <span class="badge bg-dark px-2.5 py-1.5 rounded-lg font-weight-black text-xs" 
                                          style="text-transform: uppercase; letter-spacing: 0.5px; font-weight: 800; min-width: 80px; display: inline-block;
                                          {{ $order->order_type === 'dinein' ? 'color: #0dcaf0 !important;' : 'color: #ffc107 !important;' }}">
                                        {{ $order->order_type === 'dinein' ? 'Dine In' : 'Pickup' }}
                                    </span>
                                </td>
                                
                                <td>
                                    <span class="text-dark small font-weight-bold bg-light px-2.5 py-1 rounded border" style="font-size: 0.78rem; font-weight: 600;">
                                        {{ $order->method }}
                                    </span>
                                </td>
                                
                                <td class="py-3">
                                    <ul class="list-unstyled mb-0" style="font-size: 0.85rem; line-height: 1.6;">
                                        @foreach ($order->items as $item)
                                            <li class="text-dark mb-1 d-flex align-items-center" style="font-weight: 500;">
                                                <i class="fas fa-circle text-muted mr-2" style="font-size: 0.4rem; color: #c4a484 !important;"></i> 
                                                <span>{{ $item->product_name }}</span>
                                                <span class="badge bg-light text-dark border ml-1.5 px-1.5 py-0.5 rounded font-weight-bold" style="font-size: 0.7rem; font-weight: 700;">x{{ $item->quantity }}</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                </td>
                                
                                <td class="text-dark font-weight-black" style="font-size: 1.05rem; font-weight: 800; color: #1a0f0a;">
                                    ₱{{ number_format($order->total_price, 2) }}
                                </td>
                                
                                <td class="text-center px-2">
                                    <form action="{{ route('admin.orders.update-status', $order->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <select name="status" onchange="this.form.submit()" 
                                            class="form-select form-select-sm font-weight-bold text-center rounded-pill border-0 px-3 py-2 cursor-pointer shadow-sm text-white transition-all"
                                            style="font-size: 0.8rem; letter-spacing: 0.3px; min-width: 140px; background-position: right 12px center; box-shadow: 0 2px 6px rgba(0,0,0,0.08) !important; font-weight: 700;
                                            @if($order->status === 'Pending') background-color: #d97706 !important;
                                            @elseif($order->status === 'Preparing') background-color: #2563eb !important;
                                            @elseif($order->status === 'Completed') background-color: #059669 !important;
                                            @else background-color: #6b7280 !important; @endif">
                                            <option value="Pending" {{ $order->status === 'Pending' ? 'selected' : '' }}>⏳ Pending</option>
                                            <option value="Preparing" {{ $order->status === 'Preparing' ? 'selected' : '' }}>☕ Preparing</option>
                                            <option value="Completed" {{ $order->status === 'Completed' ? 'selected' : '' }}>✅ Completed</option>
                                        </select>
                                    </form>
                                </td>
                                
                                <td class="text-muted small px-4 text-right" style="font-size: 0.8rem; white-space: nowrap; font-weight: 500;">
                                    <div class="text-dark font-weight-semibold" style="font-weight: 600;">{{ $order->created_at->format('M d, Y') }}</div>
                                    <div class="text-muted" style="font-size: 0.72rem; margin-top: 2px;">{{ $order->created_at->format('h:i A') }}</div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center py-5 text-muted bg-white">
                                    <div class="py-5">
                                        <i class="fas fa-coffee fa-3x mb-3 d-block text-muted" style="opacity: 0.25;"></i>
                                        <p class="mb-1 font-weight-bold text-dark" style="font-size: 1.1rem;">Your Queue is Empty</p>
                                        <p class="small text-secondary mb-0">No active orders are registered inside the Simeon system right now.</p>
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
        background-color: rgba(29, 17, 11, 0.02) !important;
    }
    .font-weight-black {
        font-weight: 800 !important;
    }
</style>
@endsection