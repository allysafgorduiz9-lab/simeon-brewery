@extends('layouts.admin')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold text-coffee-900">Manage Menu</h1>
</div>

<div class="bg-white p-6 rounded-lg shadow mb-6">
    <h2 class="text-lg font-bold mb-4">Add New Product</h2>
    <form action="{{ route('admin.product.add') }}" method="POST" enctype="multipart/form-data" class="flex flex-wrap gap-4">
        @csrf
        <select name="category_id" class="border p-3 rounded-lg flex-1">
            <option value="">Select Category</option>
            @foreach($categories as $cat)
                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
            @endforeach
        </select>
        <input type="text" name="name" placeholder="Product Name" required class="border p-3 rounded-lg flex-1">
        <input type="number" name="price" placeholder="Price (₱)" required class="border p-3 rounded-lg w-32">
        <input type="text" name="description" placeholder="Description" required class="border p-3 rounded-lg flex-[2]">
        <label class="border p-3 rounded-lg flex-1 cursor-pointer bg-gray-50 hover:bg-gray-100 flex items-center">
            <span class="text-sm text-gray-500">📷 Upload Image</span>
            <input type="file" name="image" accept="image/*" class="hidden">
        </label>
        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg font-bold transition">
            + Add Product
        </button>
    </form>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="w-full text-left">
        <thead class="bg-coffee-900 text-white">
            <tr>
                <th class="p-4">Image</th>
                <th class="p-4">Name</th>
                <th class="p-4">Category</th>
                <th class="p-4">Price</th>
                <th class="p-4">Status</th>
                <th class="p-4">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
            <tr class="border-b hover:bg-gray-50">
                <td class="p-4">
                    @if($product->image_path)
                        <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}" class="w-16 h-16 object-cover rounded">
                    @else
                        <div class="w-16 h-16 bg-gray-100 rounded flex items-center justify-center text-xl">☕</div>
                    @endif
                </td>
                <td class="p-4 font-bold text-coffee-900">{{ $product->name }}</td>
                <td class="p-4">{{ $product->category->name ?? 'Uncategorized' }}</td>
                <td class="p-4 font-bold text-yellow-700">₱{{ number_format($product->price, 2) }}</td>
                <td class="p-4">
                    @if($product->is_available)
                        <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm font-bold">Available</span>
                    @else
                        <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-sm font-bold">Unavailable</span>
                    @endif
                </td>
                <td class="p-4">
                    <div class="flex flex-col gap-2">
                        <div class="flex gap-2">
                            <button type="button" 
        onclick="openEditModal({{ $product->id }}, '{{ addslashes($product->name) }}', '{{ addslashes($product->description) }}', {{ $product->price }}, {{ $product->category_id ?? 'null' }}, '{{ $product->image_path ?? '' }}')" 
        class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded">
    Edit
</button>
                            <form action="{{ route('admin.product.delete', $product->id) }}" method="POST" onsubmit="return confirm('Delete this product?');">
                                @csrf
                                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-2 rounded-lg text-sm font-bold transition">
                                    🗑️
                                </button>
                            </form>
                        </div>
                        
                        <form action="{{ route('admin.product.toggle', $product->id) }}" method="POST">
                            @csrf
                            @if($product->is_available)
                                <button type="submit" class="w-full bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-2 rounded-lg text-sm font-bold transition">
                                    ❌ Mark as Unavailable
                                </button>
                            @else
                                <button type="submit" class="w-full bg-green-500 hover:bg-green-600 text-white px-3 py-2 rounded-lg text-sm font-bold transition">
                                    ✓ Mark as Available
                                </button>
                            @endif
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div id="editModal" class="fixed inset-0 bg-black bg-opacity-60 hidden flex items-center justify-center z-50">
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-lg">
        <div class="bg-coffee-900 text-white p-6 flex justify-between items-center">
            <h2 class="text-xl font-bold">Edit Product</h2>
            <button onclick="closeEditModal()" class="text-white hover:text-gray-300 text-2xl">&times;</button>
        </div>
        <form id="editForm" method="POST" enctype="multipart/form-data" class="p-6">
            @csrf
            <div class="flex justify-center mb-4">
                <div class="relative">
                    <img id="editImagePreview" src="" alt="Preview" class="w-32 h-32 object-cover rounded-lg shadow hidden">
                    <div id="noImagePlaceholder" class="w-32 h-32 bg-gray-200 rounded-lg flex items-center justify-center text-4xl">☕</div>
                </div>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-bold text-gray-700 mb-2">Product Name</label>
                <input type="text" name="name" id="editName" required class="w-full border p-3 rounded-lg">
            </div>
            <div class="mb-4">
                <label class="block text-sm font-bold text-gray-700 mb-2">Description</label>
                <textarea name="description" id="editDescription" required class="w-full border p-3 rounded-lg" rows="3"></textarea>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-bold text-gray-700 mb-2">Price (₱)</label>
                <input type="number" name="price" id="editPrice" required class="w-full border p-3 rounded-lg">
            </div>
            <div class="mb-4">
                <label class="block text-sm font-bold text-gray-700 mb-2">Category</label>
                <select name="category_id" id="editCategory" class="w-full border p-3 rounded-lg">
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-bold text-gray-700 mb-2">Change Image (Optional)</label>
                <input type="file" name="image" accept="image/*" class="w-full border p-3 rounded-lg">
            </div>
            <div class="flex gap-4">
                <button type="submit" class="flex-1 bg-green-600 text-white py-3 rounded-lg font-bold">Save</button>
                <button type="button" onclick="closeEditModal()" class="flex-1 bg-gray-500 text-white py-3 rounded-lg font-bold">Cancel</button>
            </div>
        </form>
    </div>
</div>

<script>
function openEditModal(id, name, description, price, category_id, imagePath) {
    // Fill the hidden inputs inside your modal with the product's data
    document.getElementById('editName').value = name;
    document.getElementById('editDescription').value = description;
    document.getElementById('editPrice').value = price;
    document.getElementById('editCategory').value = category_id;
    
    // Change the form action to point to the correct update route
    document.getElementById('editForm').action = '/admin/product/update/' + id;
    
    // Show the modal
    document.getElementById('editModal').classList.remove('hidden');
}

function closeEditModal() {
    document.getElementById('editModal').classList.add('hidden');
}

function closeEditModal() {
    document.getElementById('editModal').classList.add('hidden');
}

document.getElementById('editModal').addEventListener('click', function(e) {
    if (e.target === this) closeEditModal();
});
</script>
@endsection