@extends('layouts.admin')

@section('content')
<div class="p-6 bg-stone-50 min-h-screen">
    <div class="max-w-7xl mx-auto">
        
        <div class="flex flex-col md:flex-row md:items-center md:justify-between border-b border-stone-200 pb-5 mb-6">
            <div>
                <div class="flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-amber-700 bg-amber-50 px-2.5 py-1 rounded-md w-max mb-2">
                    🔒 Secure Admin Portal
                </div>
                <h1 class="text-2xl font-black text-stone-900 tracking-tight">Management Analytics & Reports</h1>
            </div>
            <div class="mt-4 md:mt-0 flex gap-3">
                <button onclick="window.print()" class="bg-white hover:bg-stone-100 text-stone-700 font-bold text-xs py-2 px-4 rounded-lg border border-stone-300 shadow-sm transition inline-flex items-center gap-2">
                    🖨️ Export PDF / Print
                </button>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-5 mb-8">
            <div class="bg-white p-5 rounded-xl border border-stone-200 shadow-sm flex items-center justify-between">
                <div>
                    <span class="text-[11px] font-bold uppercase tracking-wider text-stone-400 block mb-1">Gross Revenue</span>
                    <h3 class="text-xl font-black text-stone-900">₱{{ number_format($totalSales ?? 0, 2) }}</h3>
                </div>
                <div class="w-10 h-10 rounded-lg bg-stone-100 flex items-center justify-center text-lg shadow-inner text-amber-700 font-bold">₱</div>
            </div>
            <div class="bg-white p-5 rounded-xl border border-stone-200 shadow-sm flex items-center justify-between">
                <div>
                    <span class="text-[11px] font-bold uppercase tracking-wider text-stone-400 block mb-1">Orders Placed</span>
                    <h3 class="text-xl font-black text-stone-900">{{ $totalOrders ?? 0 }}</h3>
                </div>
                <div class="w-10 h-10 rounded-lg bg-stone-100 flex items-center justify-center text-lg shadow-inner">🛒</div>
            </div>
            <div class="bg-white p-5 rounded-xl border border-stone-200 shadow-sm flex items-center justify-between">
                <div>
                    <span class="text-[11px] font-bold uppercase tracking-wider text-stone-400 block mb-1">Avg Ticket Size</span>
                    <h3 class="text-xl font-black text-stone-900">₱{{ number_format($avgOrderValue ?? 0, 2) }}</h3>
                </div>
                <div class="w-10 h-10 rounded-lg bg-stone-100 flex items-center justify-center text-lg shadow-inner">📊</div>
            </div>
            <div class="bg-white p-5 rounded-xl border border-stone-200 shadow-sm flex items-center justify-between">
                <div>
                    <span class="text-[11px] font-bold uppercase tracking-wider text-stone-400 block mb-1">Active Menu Items</span>
                    <h3 class="text-xl font-black text-stone-900">{{ $activeProductsCount ?? 0 }}</h3>
                </div>
                <div class="w-10 h-10 rounded-lg bg-stone-100 flex items-center justify-center text-lg shadow-inner">☕</div>
            </div>
            <div class="bg-white p-5 rounded-xl border border-stone-200 shadow-sm flex items-center justify-between">
                <div>
                    <span class="text-[11px] font-bold uppercase tracking-wider text-stone-400 block mb-1">Top Item Sold</span>
                    <h3 class="text-lg font-black text-stone-900 truncate" title="{{ $mostBoughtProduct->product_name ?? 'N/A' }}">
                        {{ $mostBoughtProduct->product_name ?? 'N/A' }}
                    </h3>
                    <p class="text-[10px] text-amber-700 font-bold uppercase">{{ $mostBoughtProduct->count ?? 0 }} sales</p>
                </div>
                <div class="w-10 h-10 rounded-lg bg-amber-50 flex items-center justify-center text-lg shadow-inner">🏆</div>
            </div>
        </div>

        <div class="bg-white p-5 rounded-xl border border-stone-200 shadow-sm mb-8">
            <h2 class="font-bold text-base text-stone-900 mb-1">Daily Sales Performance</h2>
            <div class="h-96 relative w-full mt-4">
                <canvas id="dailySalesChart"></canvas>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-stone-200 shadow-sm overflow-hidden">
            <div class="p-5 border-b border-stone-100">
                <h2 class="font-bold text-base text-stone-900">Backend System Audit Log</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-stone-600">
                    <thead class="bg-stone-50 text-xs font-bold uppercase text-stone-500 border-b border-stone-200">
                        <tr>
                            <th class="px-6 py-3.5">Order ID</th>
                            <th class="px-6 py-3.5">Date</th>
                            <th class="px-6 py-3.5 text-right">Total Charges</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-stone-100 font-medium">
                        @forelse($recentOrders as $order)
                        <tr class="hover:bg-stone-50/60 transition">
                            <td class="px-6 py-3.5 font-bold text-stone-900">#{{ $order->id }}</td>
                            <td class="px-6 py-3.5 text-xs text-stone-400">
                                {{ \Carbon\Carbon::parse($order->created_at)->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-3.5 text-right font-bold text-stone-900">
                                ₱{{ number_format($order->total_price, 2) }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="px-6 py-8 text-center text-xs text-stone-400 italic">No system orders registered yet.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="p-4 bg-gray-200">
 
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const ctxDaily = document.getElementById('dailySalesChart').getContext('2d');
        new Chart(ctxDaily, {
            type: 'line',
            data: {
                labels: {!! json_encode($weeklyLabels) !!}, 
                datasets: [{
                    label: 'Sales (₱)',
                    data: {!! json_encode($weeklySalesValues) !!},
                    borderColor: '#78350f',
                    backgroundColor: 'rgba(120, 53, 15, 0.04)',
                    fill: true,
                    tension: 0.3,
                    borderWidth: 3,
                    pointRadius: 5,
                    pointBackgroundColor: '#78350f'
                }]
            },
            options: { 
                responsive: true, 
                maintainAspectRatio: false, 
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true, grid: { color: '#f5f5f4' } },
                    x: { grid: { display: false } }
                }
            }
        });
    });
</script>
@endsection