@extends('layouts.main')

@section('content')
<div class="max-w-4xl mx-auto py-10">
    <h1 class="text-3xl font-bold text-coffee-900 mb-8 border-b pb-4">Shopping Cart</h1>

    @if(Session::has('cart') && count(Session::get('cart')) > 0)
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <table class="w-full text-left">
                <thead class="bg-coffee-800 text-white">
                    <tr>
                        <th class="p-4">Item</th>
                        <th class="p-4">Price</th>
                        <th class="p-4">Quantity</th>
                        <th class="p-4">Total</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @php $total = 0; @endphp
                    @foreach(Session::get('cart') as $id => $item)
                    <tr>
                        <td class="p-4 font-bold">{{ $item['name'] }}</td>
                        <td class="p-4">₱{{ number_format($item['price'], 2) }}</td>
                        <td class="p-4">{{ $item['quantity'] }}</td>
                        <td class="p-4 font-bold">₱{{ number_format($item['price'] * $item['quantity'], 2) }}</td>
                    </tr>
                    @php $total += $item['price'] * $item['quantity']; @endphp
                    @endforeach
                </tbody>
                <tfoot class="bg-gray-50">
                    <tr>
                        <td colspan="3" class="p-4 text-right font-bold">Total:</td>
                        <td class="p-4 font-bold text-xl text-yellow-700">₱{{ number_format($total, 2) }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <!-- Checkout Form -->
        <div class="bg-white rounded-lg shadow-lg p-8 mt-8">
            <h2 class="text-xl font-bold mb-6">Customer Details</h2>
            <form action="{{ route('placeOrder') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="block text-sm font-bold mb-2">Full Name</label>
                        <input type="text" name="name" required class="w-full border p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-600">
                    </div>
                    <div>
                        <label class="block text-sm font-bold mb-2">Phone Number</label>
                        <input type="text" name="phone" required class="w-full border p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-600">
                    </div>
                </div>
                <div class="mb-6">
                    <label class="block text-sm font-bold mb-2">Payment Method</label>
                    <select name="method" class="w-full border p-3 rounded-lg">
                        <option value="Cash">Cash on Pickup</option>
                        <option value="GCash">GCash</option>
                        <option value="PayMaya">PayMaya</option>
                    </select>
                </div>
                <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-4 rounded-lg text-lg transition">
                    Place Order
                </button>
            </form>
        </div>
    @else
        <div class="text-center py-20">
            <div class="text-6xl mb-4">☕</div>
            <h2 class="text-2xl font-bold text-gray-600 mb-4">Your cart is empty</h2>
            <a href="/menu" class="inline-block bg-coffee-700 text-white px-8 py-3 rounded-lg hover:bg-coffee-800">Browse Menu</a>
        </div>
    @endif
</div>
@endsection