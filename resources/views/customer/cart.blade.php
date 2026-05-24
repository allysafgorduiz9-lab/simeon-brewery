@extends('layouts.main')

@section('content')
<div class="bg-stone-50 min-h-screen py-12">
    <div class="container mx-auto px-6 max-w-5xl">
        
        <div class="mb-10 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 border-b border-coffee-200 pb-6">
            <div>
                <h1 class="text-3xl font-black text-coffee-900 tracking-tight">Your Order Basket</h1>
                <p class="text-gray-500 text-sm mt-1">Review your selection before finalizing your order</p>
            </div>
            <a href="/menu" class="text-sm font-bold text-amber-600 hover:text-amber-700 transition flex items-center gap-1.5 group self-start sm:self-auto">
                <span class="group-hover:-translate-x-0.5 transition-transform">←</span> Continue Browsing Menu
            </a>
        </div>

        @if(Session::has('cart') && count(Session::get('cart')) > 0)
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-10 items-start">
                
                <div class="lg:col-span-2 bg-white rounded-2xl border border-coffee-200/60 shadow-sm overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-coffee-900 text-coffee-300 text-xs font-bold uppercase tracking-wider border-b border-coffee-800">
                                    <th class="p-4 pl-6">Item Description</th>
                                    <th class="p-4 text-center">Price</th>
                                    <th class="p-4 text-center">Qty</th>
                                    <th class="p-4 text-right">Total</th>
                                    <th class="p-4 pr-6 text-center">Remove</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-stone-100 text-sm text-coffee-800">
                                @php $total = 0; @endphp
                                @foreach(Session::get('cart') as $id => $item)
                                    <tr class="cart-item-row hover:bg-stone-50/60 transition duration-150" 
                                        data-id="{{ $id }}" 
                                        data-price="{{ $item['price'] }}">
                                        
                                        <td class="p-4 pl-6">
                                            <div class="flex items-center gap-3">
                                                <span class="w-8 h-8 rounded-lg bg-coffee-100 flex items-center justify-center text-sm shadow-inner">☕</span>
                                                <span class="font-bold text-coffee-900">{{ $item['name'] }}</span>
                                            </div>
                                        </td>
                                        
                                        <td class="p-4 text-center font-medium text-stone-500">
                                            ₱{{ number_format($item['price'], 2) }}
                                        </td>
                                        
                                        <td class="p-4 text-center">
                                            <div class="inline-flex items-center border border-stone-200 rounded-lg bg-stone-50 overflow-hidden shadow-sm">
                                                <button type="button" onclick="changeQuantity('{{ $id }}', -1)" class="px-2.5 py-1 text-stone-500 hover:bg-stone-200 hover:text-stone-800 transition font-bold select-none">-</button>
                                                <span id="qty-{{ $id }}" class="item-qty-display px-3 py-1 bg-white font-semibold text-coffee-900 text-xs border-x border-stone-200 min-w-[35px] text-center">
                                                    {{ $item['quantity'] }}
                                                </span>
                                                <button type="button" onclick="changeQuantity('{{ $id }}', 1)" class="px-2.5 py-1 text-stone-500 hover:bg-stone-200 hover:text-stone-800 transition font-bold select-none">+</button>
                                            </div>
                                        </td>
                                        
                                        <td class="p-4 text-right font-black text-coffee-900">
                                            ₱<span id="row-total-{{ $id }}">{{ number_format($item['price'] * $item['quantity'], 2) }}</span>
                                        </td>
                                        
                                        <td class="p-4 text-center">
                                            <form action="{{ route('removeCart') }}" method="POST" class="inline-block">
                                                @csrf
                                                <input type="hidden" name="id" value="{{ $id }}">
                                                <button type="submit" class="w-8 h-8 rounded-lg bg-rose-50 hover:bg-rose-100 border border-rose-200/40 text-rose-600 flex items-center justify-center transition shadow-sm active:scale-95" title="Remove Item">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18M6 6l12 12"/></svg>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @php $total += $item['price'] * $item['quantity']; @endphp
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="bg-white border border-coffee-200/80 rounded-2xl p-6 shadow-sm sticky top-28">
                    <h2 class="text-lg font-black text-coffee-900 mb-6 flex items-center gap-2 border-b border-stone-100 pb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-amber-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                        Checkout Details
                    </h2>
                    
                    <form action="{{ route('placeOrder') }}" method="POST" class="space-y-5">
                        @csrf
                        
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-zinc-500 mb-2">Full Name</label>
                            <input type="text" name="name" required placeholder="Juan Dela Cruz" class="w-full text-sm bg-stone-50 border border-coffee-200 rounded-xl p-3 focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition placeholder:text-zinc-400">
                        </div>

                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-zinc-500 mb-2">Phone Number</label>
                            <input type="text" name="phone" required placeholder="0912 345 6789" class="w-full text-sm bg-stone-50 border border-coffee-200 rounded-xl p-3 focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition placeholder:text-zinc-400">
                        </div>

                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-zinc-500 mb-2">Dining Choice</label>
                            <div class="grid grid-cols-2 gap-3">
                                <label class="border border-stone-200 rounded-xl p-2.5 flex items-center justify-center gap-2 cursor-pointer text-xs font-semibold text-coffee-900 transition hover:bg-stone-50/50 has-[:checked]:border-amber-500 has-[:checked]:bg-amber-50/30">
                                    <input type="radio" name="order_type" value="pickup" checked class="accent-amber-600">
                                    🛻 Pickup
                                </label>
                                <label class="border border-stone-200 rounded-xl p-2.5 flex items-center justify-center gap-2 cursor-pointer text-xs font-semibold text-coffee-900 transition hover:bg-stone-50/50 has-[:checked]:border-amber-500 has-[:checked]:bg-amber-50/30">
                                    <input type="radio" name="order_type" value="dinein" class="accent-amber-600">
                                    🍽️ Dine-In
                                </label>
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-zinc-500 mb-2">Special Instructions</label>
                            <textarea name="notes" rows="2" placeholder="e.g., Less sugar, extra ice, warm milk..." class="w-full text-xs bg-stone-50 border border-coffee-200 rounded-xl p-3 focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition placeholder:text-zinc-400"></textarea>
                        </div>

                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-zinc-500 mb-2">Payment Method</label>
                            <div class="relative">
                                <select name="method" class="w-full text-sm bg-stone-50 border border-coffee-200 rounded-xl p-3 focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition appearance-none cursor-pointer">
                                    <option value="Cash">💵 Cash on Pickup</option>
                                    <option value="GCash">🔵 GCash</option>
                                    <option value="PayMaya">🟢 PayMaya</option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-stone-500">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M7 10l5 5 5-5H7z"/></svg>
                                </div>

                                <div id="payment-details-container" class="mt-4 border border-stone-200 rounded-xl p-4 bg-stone-50 hidden">
    <h3 class="font-bold text-xs uppercase tracking-wider text-stone-500 mb-4">Payment Details</h3>
    
    <div id="gcash-info" class="payment-info hidden">
        <div class="flex flex-col items-center">
            <img src="{{ asset('storage/payments/Gcash.jpg') }}" class="w-40 h-40 object-cover rounded-lg border shadow-sm">
            <p class="text-xs font-bold text-blue-800 mt-3">GCash Number: 0912 544 9746</p>
        </div>
    </div>
    
    <div id="paymaya-info" class="payment-info hidden">
        <div class="flex flex-col items-center">
            <img src="{{ asset('storage/payments/Maya.jpg') }}" class="w-40 h-40 object-cover rounded-lg border shadow-sm">
            <p class="text-xs font-bold text-green-800 mt-3">Maya Number: 0912 544 9746</p>
        </div>
    </div>

    <div class="mt-4 pt-4 border-t border-stone-200">
        <label class="block text-[10px] font-bold uppercase tracking-wider text-stone-500 mb-1">Enter Reference No. (Required)</label>
        <input type="text" name="reference_number" id="reference_number" placeholder="Enter reference number here" class="w-full text-sm bg-white border border-stone-300 rounded-lg p-3 z-50 relative focus:ring-2 focus:ring-amber-500/20">
    </div>
                            </div>
                        </div>

                        <div class="pt-5 border-t border-stone-200">
                            <div class="flex justify-between items-end">
                                <span class="font-bold text-coffee-900 text-sm">Total Bill</span>
                                <span id="grand-total-display" class="text-2xl font-black text-amber-600">₱{{ number_format($total, 2) }}</span>
                            </div>
                        </div>

                        <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-500 text-white font-bold py-3.5 px-4 rounded-xl text-sm transition shadow-sm hover:shadow active:scale-[0.98] flex items-center justify-center gap-2">
                            Confirm & Place Order
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                        </button>
                    </form>
                </div>

            </div>
        @else
            <div class="text-center py-20 bg-white border border-dashed border-coffee-200 rounded-3xl p-8 max-w-md mx-auto shadow-sm">
                <div class="w-16 h-16 rounded-full bg-coffee-100 flex items-center justify-center mx-auto mb-5 text-2xl">
                    🛒
                </div>
                <h3 class="text-xl font-bold text-coffee-900 mb-1">Your Basket is Empty</h3>
                <p class="text-sm text-gray-400 max-w-xs mx-auto mb-8">Looks like you haven't selected a premium beverage blend yet.</p>
                <a href="/menu" class="inline-flex items-center gap-2 bg-coffee-700 hover:bg-coffee-800 text-white text-xs font-bold px-6 py-3 rounded-xl shadow-sm transition active:scale-95">
                    Browse Our Menu
                </a>
            </div>
        @endif

    </div>
</div>

<script>
    // Existing quantity function remains here...
    function changeQuantity(itemId, change) { /* ... existing code ... */ }

    // New Payment Toggle Logic
    document.querySelector('select[name="method"]').addEventListener('change', function(e) {
        const method = e.target.value;
        const container = document.getElementById('payment-details-container');
        const refInput = document.getElementById('reference_number');
        
        document.querySelectorAll('.payment-info').forEach(el => el.classList.add('hidden'));
        
        if (method === 'GCash' || method === 'PayMaya') {
            container.classList.remove('hidden');
            refInput.setAttribute('required', 'true');
            if (method === 'GCash') document.getElementById('gcash-info').classList.remove('hidden');
            else document.getElementById('paymaya-info').classList.remove('hidden');
        } else {
            container.classList.add('hidden');
            refInput.removeAttribute('required');
        }
    });
</script>
@endsection