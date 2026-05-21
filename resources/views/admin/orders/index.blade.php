@extends('layouts.admin') {{-- Extends your main dashboard template --}}

@section('content')
<div class="container-fluid px-4 py-4" style="font-family: 'Nunito', 'Segoe UI', sans-serif; background-color: #f8f9fa; min-height: 100vh;">
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1 text-gray-900 font-weight-black" style="font-weight: 800; letter-spacing: -0.75px;">Active Orders Queue</h1>
        </div>
        <div>
            <span class="badge border border-gray-200 text-dark px-3 py-2 rounded-lg font-weight-bold" style="font-size: 0.85rem; background-color: #ffffff; box-shadow: 0 1px 3px rgba(0,0,0,0.02); font-weight: 700;">
                <i class="fas fa-shopping-bag text-muted mr-2" style="color: #1d110b !important;"></i> Total: {{ $orders->total() }} Live Orders
            </span>
        </div>
    </div>

    <div class="table-responsive" style="overflow-x: auto; border: none;">
        <table class="table align-middle mb-0" style="width: 100%; border-collapse: separate; border-spacing: 0 12px;">
            <thead class="text-white border-0" style="background-color: #1d110b; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.8px;">
                <tr>
                    <th class="py-3.5 px-4 style-th-first" style="font-weight: 700;">Order ID</th>
                    <th class="py-3.5" style="font-weight: 700;">Customer</th>
                    <th class="py-3.5" style="font-weight: 700;">Phone Number</th>
                    <th class="py-3.5 text-center" style="font-weight: 700; width: 120px;">Fulfillment</th>
                    <th class="py-3.5 text-center" style="font-weight: 700; width: 120px;">Payment</th>
                    <th class="py-3.5 px-3" style="font-weight: 700; width: 280px;">Ordered Items</th>
                    <th class="py-3.5 text-right" style="font-weight: 700;">Total Price</th>
                    <th class="py-3.5 text-center" style="width: 190px; font-weight: 700;">Workflow Status</th>
                    <th class="py-3.5 px-4 style-th-last text-right" style="font-weight: 700;">Timestamp</th>
                </tr>
            </thead>
            
            <tbody style="font-size: 0.88rem;">
                @forelse ($orders as $order)
                    <tr class="order-dashboard-row" style="background-color: #ffffff; box-shadow: 0 2px 12px rgba(0,0,0,0.035); transition: all 0.2s ease;">
                        
                        <td class="px-4 font-weight-bold py-4 style-td-first" style="font-family: SFMono-Regular, Menlo, Monaco, Consolas, monospace; font-size: 0.8rem; font-weight: 700; color: #4a5568;">
                            #ORD-{{ $order->id }}
                        </td>
                        
                        <td class="text-gray-900 font-weight-bold" style="font-weight: 700; font-size: 0.95rem; color: #1a202c;">
                            {{ $order->customer_name }}
                        </td>
                        
                        <td>
                            <span class="text-muted font-weight-medium" style="font-size: 0.85rem;"><i class="fas fa-phone-alt mr-1.5 text-muted small"></i> {{ $order->phone ?? 'N/A' }}</span>
                        </td>
                        
                        <td class="text-center">
                            <span class="badge bg-dark px-2.5 py-1.5 rounded-lg font-weight-black text-xs" 
                                  style="text-transform: uppercase; letter-spacing: 0.5px; font-weight: 800; min-width: 85px; display: inline-block;
                                  {{ $order->order_type === 'dinein' ? 'color: #0dcaf0 !important; background-color: #0f172a !important;' : 'color: #ffc107 !important; background-color: #0f172a !important;' }}">
                                {{ $order->order_type === 'dinein' ? 'Dine In' : 'Pickup' }}
                            </span>
                        </td>
                        
                        <td class="text-center">
                            <span class="text-dark small font-weight-bold bg-light px-2.5 py-1.5 rounded-md border border-gray-200" style="font-size: 0.75rem; font-weight: 700; letter-spacing: 0.2px;">
                                {{ $order->method }}
                            </span>
                        </td>
                        
                        <td class="py-3 px-3">
                            <div class="d-flex flex-column gap-1">
                                @foreach ($order->items as $item)
                                    <div class="d-flex align-items-center justify-content-between p-1 px-2 rounded-sm bg-light-coffee mb-1" style="background-color: #fdfbf7; border-left: 3px solid #8c6d58;">
                                        <span class="text-dark font-weight-medium" style="font-size: 0.82rem; font-weight: 500;">{{ $item->product_name }}</span>
                                        <span class="badge text-white font-weight-bold rounded px-2" style="font-size: 0.7rem; background-color: #8c6d58;">x{{ $item->quantity }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </td>
                        
                        <td class="text-dark font-weight-black text-right" style="font-size: 1.1rem; font-weight: 800; color: #1d110b;">
                            ₱{{ number_format($order->total_price, 2) }}
                        </td>
                        
                        <td class="text-center px-2">
                            <form action="{{ route('admin.orders.update-status', $order->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <select name="status" onchange="this.form.submit()" 
                                    class="form-select form-select-sm font-weight-bold text-center rounded-lg border-0 px-3 py-2 cursor-pointer shadow-sm text-white status-interactive-select"
                                    style="font-size: 0.8rem; letter-spacing: 0.3px; min-width: 145px; background-position: right 12px center; font-weight: 700; border-radius: 8px !important;
                                    @if($order->status === 'Pending') background-color: #d97706 !important; box-shadow: 0 2px 8px rgba(217, 119, 6, 0.2) !important;
                                    @elseif($order->status === 'Preparing') background-color: #2563eb !important; box-shadow: 0 2px 8px rgba(37, 99, 235, 0.2) !important;
                                    @elseif($order->status === 'Completed') background-color: #059669 !important; box-shadow: 0 2px 8px rgba(5, 150, 105, 0.2) !important;
                                    @else background-color: #6b7280 !important; @endif">
                                    <option value="Pending" {{ $order->status === 'Pending' ? 'selected' : '' }}>⏳ Pending</option>
                                    <option value="Preparing" {{ $order->status === 'Preparing' ? 'selected' : '' }}>☕ Preparing</option>
                                    <option value="Completed" {{ $order->status === 'Completed' ? 'selected' : '' }}>✅ Completed</option>
                                </select>
                            </form>
                        </td>
                        
                        <td class="text-muted small px-4 text-right style-td-last" style="font-size: 0.8rem; white-space: nowrap; font-weight: 500;">
                            <div class="text-dark font-weight-semibold" style="font-weight: 700; color: #1a202c;">
                                {{ $order->created_at->timezone('Asia/Manila')->format('M d, Y') }}
                            </div>
                            <div class="text-muted small font-mono" style="font-size: 0.72rem; margin-top: 2px; color: #718096; font-weight: bold;">
                                {{ $order->created_at->timezone('Asia/Manila')->format('h:i A') }}
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr style="background-color: #ffffff; box-shadow: 0 2px 12px rgba(0,0,0,0.035);">
                        <td colspan="9" class="text-center py-5 text-muted style-td-first style-td-last" style="border-radius: 12px;">
                            <div class="py-5">
                                <i class="fas fa-coffee fa-3x mb-3 d-block text-muted" style="opacity: 0.25; color: #8c6d58 !important;"></i>
                                <p class="mb-1 font-weight-bold text-dark" style="font-size: 1.1rem; font-weight: 700;">Your Queue is Empty</p>
                                <p class="small text-secondary mb-0">No active incoming orders are registered inside Simeon Cafe.</p>
                            </div>
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

<style>
    .style-th-first { border-top-left-radius: 8px; border-bottom-left-radius: 8px; }
    .style-th-last { border-top-right-radius: 8px; border-bottom-right-radius: 8px; }
    
    .style-td-first { border-top-left-radius: 12px; border-bottom-left-radius: 12px; border-left: 1px solid #e2e8f0; border-top: 1px solid #e2e8f0; border-bottom: 1px solid #e2e8f0; }
    .style-td-last { border-top-right-radius: 12px; border-bottom-right-radius: 12px; border-right: 1px solid #e2e8f0; border-top: 1px solid #e2e8f0; border-bottom: 1px solid #e2e8f0; }
    
    .order-dashboard-row td:not(.style-td-first):not(.style-td-last) {
        border-top: 1px solid #e2e8f0;
        border-bottom: 1px solid #e2e8f0;
    }
    
    .order-dashboard-row:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(29, 17, 11, 0.06) !important;
        background-color: #fffdfa !important;
    }
    
    .font-weight-black { font-weight: 800 !important; }
    .status-interactive-select { transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1); }
    .status-interactive-select:hover { filter: brightness(1.08); }
</style>
@endsection