@extends('layouts.main')

@section('content')
<div class="bg-stone-50 min-h-screen py-10">
    <div class="container mx-auto px-6 max-w-7xl">
        
        <div class="flex flex-col md:flex-row md:items-center md:justify-between border-b border-stone-200 pb-6 mb-8">
            <div>
                <h1 class="text-2xl md:text-3xl font-black text-coffee-900 tracking-tight">Business Reports & Analytics</h1>
                <p class="text-sm text-gray-500 mt-1">Track your cafe's daily performance, sales volumes, and product velocity.</p>
            </div>
            <div class="mt-4 md:mt-0">
                <button onclick="window.print()" class="bg-white hover:bg-stone-100 text-stone-700 font-bold text-sm py-2 px-4 rounded-xl border border-stone-300 shadow-sm transition duration-150 inline-flex items-center gap-2">
                    🖨️ Print Report
                </button>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
            
            <div class="bg-white p-6 rounded-2xl border border-stone-200/80 shadow-sm flex items-center justify-between">
                <div>
                    <span class="text-xs font-bold uppercase tracking-wider text-gray-400 block mb-1">Total Gross Revenue</span>
                    <h3 class="text-2xl font-black text-coffee-900">₱{{ number_format($totalSales ?? 124500.00, 2) }}</h3>
                    <span class="text-xs font-semibold text-emerald-600 inline-flex items-center gap-1 mt-2">
                        ↑ 12% <span class="text-gray-400 font-normal">vs last month</span>
                    </span>
                </div>
                <div class="w-12 h-12 rounded-xl bg-amber-50 flex items-center justify-center text-xl shadow-inner text-amber-600">💰</div>
            </div>

            <div class="bg-white p-6 rounded-2xl border border-stone-200/80 shadow-sm flex items-center justify-between">
                <div>
                    <span class="text-xs font-bold uppercase tracking-wider text-gray-400 block mb-1">Total Orders Placed</span>
                    <h3 class="text-2xl font-black text-coffee-900">{{ $totalOrders ?? 842 }}</h3>
                    <span class="text-xs font-semibold text-emerald-600 inline-flex items-center gap-1 mt-2">
                        ↑ 4.3% <span class="text-gray-400 font-normal">vs last week</span>
                    </span>
                </div>
                <div class="w-12 h-12 rounded-xl bg-coffee-50 flex items-center justify-center text-xl shadow-inner text-coffee-700">🛒</div>
            </div>

            <div class="bg-white p-6 rounded-2xl border border-stone-200/80 shadow-sm flex items-center justify-between">
                <div>
                    <span class="text-xs font-bold uppercase tracking-wider text-gray-400 block mb-1">Avg. Ticket Size</span>
                    <h3 class="text-2xl font-black text-coffee-900">₱{{ number_format($avgOrderValue ?? 147.85, 2) }}</h3>
                    <span class="text-xs font-semibold text-rose-600 inline-flex items-center gap-1 mt-2">
                        ↓ 1.2% <span class="text-gray-400 font-normal">vs yesterday</span>
                    </span>
                </div>
                <div class="w-12 h-12 rounded-xl bg-blue-50 flex items-center justify-center text-xl shadow-inner text-blue-600">📊</div>
            </div>

            <div class="bg-white p-6 rounded-2xl border border-stone-200/80 shadow-sm flex items-center justify-between">
                <div>
                    <span class="text-xs font-bold uppercase tracking-wider text-gray-400 block mb-1">Active Menu Items</span>
                    <h3 class="text-2xl font-black text-coffee-900">{{ $activeProductsCount ?? 24 }}</h3>
                    <span class="text-xs text-gray-400 font-normal inline-block mt-2">Across all active categories</span>
                </div>
                <div class="w-12 h-12 rounded-xl bg-stone-100 flex items-center justify-center text-xl shadow-inner text-stone-600">☕</div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-10">
            
            <div class="bg-white p-6 rounded-2xl border border-stone-200/80 shadow-sm lg:col-span-2">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h2 class="font-bold text-lg text-coffee-900">Daily Sales Performance</h2>
                        <p class="text-xs text-gray-400">Gross revenue generation tracked over the past 7 days</p>
                    </div>
                </div>
                <div class="h-80 relative w-full">
                    <canvas id="dailySalesChart"></canvas>
                </div>
            </div>

            <div class="bg-white p-6 rounded-2xl border border-stone-200/80 shadow-sm">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h2 class="font-bold text-lg text-coffee-900">Best Selling Products</h2>
                        <p class="text-xs text-gray-400">Volume breakdown by item category popularity</p>
                    </div>
                </div>
                <div class="h-80 relative w-full flex items-center justify-center">
                    <canvas id="bestSellersChart"></canvas>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-stone-200/80 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-stone-100">
                <h2 class="font-bold text-lg text-coffee-900">Recent Sales Checklist</h2>
                <p class="text-xs text-gray-400">Live feed monitoring the last successful customer conversions</p>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-gray-500">
                    <thead class="bg-stone-50 text-xs font-bold uppercase text-stone-600 border-b border-stone-200">
                        <tr>
                            <th class="px-6 py-4">Order ID</th>
                            <th class="px-6 py-4">Timestamp</th>
                            <th class="px-6 py-4">Items Ordered</th>
                            <th class="px-6 py-4 text-right">Total Charges</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-stone-100">
                        <tr class="hover:bg-stone-50/50 transition">
                            <td class="px-6 py-4 font-bold text-stone-900">#10823</td>
                            <td class="px-6 py-4 text-xs">Just Now</td>
                            <td class="px-6 py-4">2x Macho Latte, 1x Espresso Block</td>
                            <td class="px-6 py-4 text-right font-black text-amber-600">₱420.00</td>
                        </tr>
                        <tr class="hover:bg-stone-50/50 transition">
                            <td class="px-6 py-4 font-bold text-stone-900">#10822</td>
                            <td class="px-6 py-4 text-xs">14 mins ago</td>
                            <td class="px-6 py-4">1x Cream Matcha Blend</td>
                            <td class="px-6 py-4">₱165.00</td>
                        </tr>
                        <tr class="hover:bg-stone-50/50 transition">
                            <td class="px-6 py-4 font-bold text-stone-900">#10821</td>
                            <td class="px-6 py-4 text-xs">1 hour ago</td>
                            <td class="px-6 py-4">3x Americano Cold Brew</td>
                            <td class="px-6 py-4 text-right font-black text-amber-600">₱360.00</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        
        // 🛠️ CHART 1: LINE GRAPH (Daily Revenue Vectors)
        const ctxDaily = document.getElementById('dailySalesChart').getContext('2d');
        new Chart(ctxDaily, {
            type: 'line',
            data: {
                labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'], // X-Axis Timeline
                datasets: [{
                    label: 'Gross Sales (₱)',
                    data: [12000, 15000, 14200, 18500, 22000, 29000, 24000], // 💡 Replace with your database query outputs later
                    borderColor: '#b45309', // Warm Amber 700 Accent
                    backgroundColor: 'rgba(217, 119, 6, 0.08)',
                    fill: true,
                    tension: 0.35, // Smooth curves
                    borderWidth: 3,
                    pointRadius: 4,
                    pointBackgroundColor: '#b45309'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: { grid: { color: '#f5f5f4' }, ticks: { font: { size: 11 } } },
                    x: { grid: { display: false }, ticks: { font: { size: 11 } } }
                }
            }
        });

        // 🛠️ CHART 2: DOUGHNUT CHART (Best Selling Inventory Volume Distribution)
        const ctxBest = document.getElementById('bestSellersChart').getContext('2d');
        new Chart(ctxBest, {
            type: 'doughnut',
            data: {
                labels: ['Coffee-Based', 'Non-Coffee', 'Pastries', 'Merchandise'],
                datasets: [{
                    data: [65, 20, 10, 5], // Percentages or Raw Order Volume Counts
                    backgroundColor: ['#78350f', '#d97706', '#fcd34d', '#e7e5e4'], // Dynamic Cafe Color Matrix
                    borderWidth: 2,
                    borderColor: '#ffffff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: { boxWidth: 12, font: { size: 12, weight: 'bold' }, padding: 20 }
                    }
                },
                cutout: '70%' // Makes the inner ring look modern and thin
            }
        });
    });
</script>
@endsection