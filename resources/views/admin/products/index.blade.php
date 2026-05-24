@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4 py-4" style="font-family: 'Nunito', 'Segoe UI', sans-serif; background-color: #f8f9fa; min-height: 100vh;">
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1 text-gray-900 font-weight-black" style="font-weight: 800; letter-spacing: -0.75px;">Manage Menu</h1>
            
    
        </div>
        <br>
        <br>
        <a href="{{ route('admin.products.create') }}" 
   class="btn text-white px-4 py-2.5 shadow-sm font-weight-bold d-flex align-items-center gap-2" 
   style="background-color: #1d110b; border-radius: 10px; text-decoration: none;">
    <i class="fas fa-plus"></i> Add New Product
</a>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-12 col-md-6">
            <div class="card border-0 shadow-sm p-3" style="border-radius: 14px; background: #ffffff; border-left: 4px solid #1d110b !important;">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="text-muted small text-uppercase font-weight-bold mb-1" style="letter-spacing: 0.5px; font-size: 0.72rem;">Total Menu Items</p>
                        <h3 class="font-weight-black text-dark mb-0" style="font-weight: 800;">{{ count($products ?? []) }} Items</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6">
            <div class="card border-0 shadow-sm p-3" style="border-radius: 14px; background: #ffffff; border-left: 4px solid #d97706 !important;">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="text-muted small text-uppercase font-weight-bold mb-1" style="letter-spacing: 0.5px; font-size: 0.72rem;">Pricing Metrics</p>
                        <h3 class="font-weight-black text-dark mb-0" style="font-weight: 800;">PHP (₱)</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="table-responsive" style="overflow-x: auto; border: none;">
        <table class="table align-middle mb-0" style="width: 100%; border-collapse: separate; border-spacing: 0 12px;">
            <thead class="text-white border-0" style="background-color: #1d110b; font-size: 0.75rem; text-transform: uppercase;">
                <tr>
                    <th class="py-3.5 px-4 style-th-first">Image</th>
                    <th class="py-3.5">Product Name</th>
                    <th class="py-3.5">Category</th>
                    <th class="py-3.5">Base Price</th>
                    <th class="py-3.5 text-center">Menu Status</th>
                    <th class="py-3.5 px-4 style-th-last text-center">Actions</th>
                </tr>
            </thead>
            
            <tbody style="font-size: 0.88rem;">
                @forelse ($products ?? [] as $product)
                <tr class="product-dashboard-row" style="background-color: #ffffff; box-shadow: 0 2px 12px rgba(0,0,0,0.035);">
                    <td class="px-4 py-3 style-td-first">
                        <img src="{{ asset('storage/' . $product->image) }}" style="width: 50px; height: 50px; object-fit: cover; border-radius: 10px;">
                    </td>
                    <td class="font-weight-bold">{{ $product->name }}</td>
                    <td>
    <span class="badge bg-light text-dark border">
        {{ $product->category ? $product->category->name : 'Uncategorized' }}
    </span>
</td>
                    <td class="font-weight-black">₱{{ number_format($product->price ?? 0, 2) }}</td>
                    <td class="text-center">
                        <form action="{{ route('admin.products.update-status', $product->id) }}" method="POST">
                            @csrf @method('PATCH')
                            <select name="status" onchange="this.form.submit()" class="form-select border-0 px-3 py-2 text-white" style="border-radius: 8px; background-color: {{ ($product->stock > 0) ? '#059669' : '#dc2626' }};">
                                <option value="1" {{ $product->stock > 0 ? 'selected' : '' }}>Available</option>
                                <option value="0" {{ $product->stock <= 0 ? 'selected' : '' }}>Unavailable</option>
                            </select>
                        </form>
                    </td>
                    <td class="text-center style-td-last">
                        <button type="button" 
                                onclick="openEditModal({{ json_encode($product) }})" 
                                class="btn btn-sm btn-action-edit text-white" 
                                style="background-color: #8c6d58; border-radius: 6px; width: 100px; height: 36px;">
                            <i class="fas fa-edit"></i> Edit
                        </button>
                        
                        <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this item?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-action-delete text-white" style="background-color: #dc2626; border-radius: 6px; width: 100px; height: 36px;">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center py-5">No items found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Include your new Edit Modal file --}}
@include('admin.products.edit-modal')

<style>
    /* Add this to force modal visibility control */
    .hidden { display: none !important; }
</style>
@endsection