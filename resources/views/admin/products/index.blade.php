@extends('layouts.admin') {{-- Extends your main dashboard template --}}

@section('content')
<div class="container-fluid px-4 py-4" style="font-family: 'Nunito', 'Segoe UI', sans-serif; background-color: #f8f9fa; min-height: 100vh;">
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1 text-gray-900 font-weight-black" style="font-weight: 800; letter-spacing: -0.75px;">Manage Menu</h1>
            <p class="text-muted small mb-0 font-weight-medium" style="font-size: 0.85rem; letter-spacing: 0.2px;">Add, modify, and monitor items inside Simeon Cafe pricing loops</p>
        </div>
        <div>
            <button class="btn text-white px-4 py-2.5 shadow-sm font-weight-bold d-flex align-items-center gap-2 transition-all hover-brightness" ...>
    <i class="fas fa-plus"></i> Add New Product
</button>

<a href="{{ route('admin.products.create') }}" 
   class="btn text-white px-4 py-2.5 shadow-sm font-weight-bold d-inline-flex align-items-center gap-2 transition-all hover-brightness" 
   style="background-color: #1d110b; border-radius: 10px; font-weight: 700; font-size: 0.88rem; border: none; text-decoration: none;">
    <i class="fas fa-plus"></i> Add New Product
</a>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-12 col-md-6">
            <div class="card border-0 shadow-sm p-3" style="border-radius: 14px; background: #ffffff; border-left: 4px solid #1d110b !important;">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="text-muted small text-uppercase font-weight-bold mb-1" style="letter-spacing: 0.5px; font-size: 0.72rem;">Total Menu Items</p>
                        <h3 class="font-weight-black text-dark mb-0" style="font-weight: 800;">
                            {{ count($products ?? []) }} Items
                        </h3>
                    </div>
                    <div class="p-3 rounded-lg" style="background-color: rgba(29, 17, 11, 0.05); color: #1d110b;">
                        <i class="fas fa-coffee fa-lg"></i>
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
                    <div class="p-3 rounded-lg" style="background-color: rgba(217, 119, 6, 0.05); color: #d97706;">
                        <i class="fas fa-wallet fa-lg"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="table-responsive" style="overflow-x: auto; border: none;">
        <table class="table align-middle mb-0" style="width: 100%; border-collapse: separate; border-spacing: 0 12px;">
            <thead class="text-white border-0" style="background-color: #1d110b; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.8px;">
                <tr>
                    <th class="py-3.5 px-4 style-th-first" style="font-weight: 700; width: 100px;">Image</th>
                    <th class="py-3.5" style="font-weight: 700;">Product Name</th>
                    <th class="py-3.5" style="font-weight: 700;">Category</th>
                    <th class="py-3.5" style="font-weight: 700;">Base Price</th>
                    <th class="py-3.5 text-center" style="font-weight: 700; width: 180px;">Menu Status</th>
                    <th class="py-3.5 px-4 style-th-last text-center" style="width: 220px; font-weight: 700;">Actions</th>
                </tr>
            </thead>
            
            <tbody style="font-size: 0.88rem;">
                @forelse ($products ?? [] as $product)
                    <tr class="product-dashboard-row" style="background-color: #ffffff; box-shadow: 0 2px 12px rgba(0,0,0,0.035); transition: all 0.2s ease;">
                        
                        <td class="px-4 py-3 style-td-first">
                            <div class="rounded-lg overflow-hidden border border-gray-200 bg-light d-flex align-items-center justify-content-center shadow-2xs position-relative" 
                                 style="width: 56px; height: 56px; border-radius: 10px; background-color: #fcfaf7;">
                                @if(isset($product->image) && $product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="Menu Item" style="width: 100%; height: 100%; object-fit: cover;">
                                @else
                                    <div class="w-100 h-100 d-flex flex-column align-items-center justify-content-center" style="background: linear-gradient(135deg, #fdfbf7 0%, #f5efe6 100%);">
                                        <i class="fas fa-mug-hot" style="color: #8c6d58; opacity: 0.65; font-size: 1.2rem;"></i>
                                        <span style="font-size: 0.55rem; color: #8c6d58; font-weight: 700; text-transform: uppercase; margin-top: 1px;">Simeon</span>
                                    </div>
                                @endif
                            </div>
                        </td>
                        
                        <td class="text-gray-900 font-weight-bold" style="font-weight: 700; font-size: 0.95rem; color: #1a202c;">
                            {{ $product->name ?? 'Sample Coffee Item' }}
                        </td>
                        
                        <td>
                            <span class="badge px-2.5 py-1.5 rounded-md text-dark font-weight-semibold" 
                                  style="font-size: 0.78rem; background-color: #f1f5f9; border: 1px solid #e2e8f0; font-weight: 600;">
                                <i class="fas fa-tag mr-1 text-muted small"></i> 
                                {{ is_object($product->category) ? ($product->category->name ?? 'Beverages') : ($product->category ?? 'Beverages') }}
                            </span>
                        </td>
                        
                        <td class="text-dark font-weight-black" style="font-size: 1.05rem; font-weight: 800; color: #1d110b;">
                            ₱{{ number_format($product->price ?? 145.00, 2) }}
                        </td>
                        
                        <td class="text-center px-2">
                            <form action="{{ route('admin.products.update-status', $product->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <select name="status" onchange="this.form.submit()" 
                                    class="form-select form-select-sm font-weight-bold text-center rounded-lg border-0 px-3 py-2 cursor-pointer shadow-sm text-white status-interactive-select"
                                    style="font-size: 0.8rem; letter-spacing: 0.3px; min-width: 150px; background-position: right 12px center; font-weight: 700; border-radius: 8px !important;
                                    @if(!isset($product->stock) || $product->stock > 0) background-color: #059669 !important; box-shadow: 0 2px 8px rgba(5, 150, 105, 0.2) !important;
                                    @else background-color: #dc2626 !important; box-shadow: 0 2px 8px rgba(220, 38, 38, 0.2) !important; @endif">
                                    <option value="1" {{ (!isset($product->stock) || $product->stock > 0) ? 'selected' : '' }}>🟢 Available</option>
                                    <option value="0" {{ (isset($product->stock) && $product->stock <= 0) ? 'selected' : '' }}>🔴 Unavailable</option>
                                </select>
                            </form>
                        </td>
                        
                        <td class="text-center px-4 style-td-last">
    <div class="d-flex align-items-center justify-content-center gap-2">
        
        <a href="{{ route('admin.products.edit', $product->id) }}" 
           class="btn btn-sm btn-action-edit text-white font-weight-semibold d-inline-flex align-items-center justify-content-center transition-all shadow-2xs" 
           style="font-size: 0.8rem; border-radius: 6px; font-weight: 700; background-color: #8c6d58; border: none; text-decoration: none; width: 100px; height: 36px;">
            <i class="fas fa-edit me-1 small"></i>Edit
        </a>
        
        <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="d-inline-block mb-0" style="margin: 0;" onsubmit="return confirm('Are you sure you want to delete this menu item?')">
            @csrf
            @method('DELETE')
            <button type="submit" 
                    class="btn btn-sm btn-action-delete text-white font-weight-semibold d-inline-flex align-items-center justify-content-center transition-all shadow-2xs" 
                    style="font-size: 0.8rem; border-radius: 6px; font-weight: 700; background-color: #dc2626; border: none; width: 100px; height: 36px;">
                <i class="fas fa-trash-alt me-1 small"></i>Delete
            </button>
        </form>
        
    </div>
</td>
                    </tr>
                @empty
                    <tr style="background-color: #ffffff; box-shadow: 0 2px 12px rgba(0,0,0,0.035);">
                        <td colspan="6" class="text-center py-5 text-muted style-td-first style-td-last" style="border-radius: 12px;">
                            <div class="py-5">
                                <i class="fas fa-layer-group fa-3x mb-3 d-block text-muted" style="opacity: 0.25; color: #8c6d58 !important;"></i>
                                <p class="mb-1 font-weight-bold text-dark" style="font-size: 1.1rem; font-weight: 700;">No Menu Items Found</p>
                                <p class="small text-secondary mb-0">Your menu catalog is empty. Click "Add New Product" to populate your store listings.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<style>
    /* Table Rounded Header Corners Maps */
    .style-th-first { border-top-left-radius: 8px; border-bottom-left-radius: 8px; }
    .style-th-last { border-top-right-radius: 8px; border-bottom-right-radius: 8px; }
    
    /* Elegant Custom Card Border curves for individual dataset items loops */
    .style-td-first { border-top-left-radius: 12px; border-bottom-left-radius: 12px; border-left: 1px solid #e2e8f0; border-top: 1px solid #e2e8f0; border-bottom: 1px solid #e2e8f0; }
    .style-td-last { border-top-right-radius: 12px; border-bottom-right-radius: 12px; border-right: 1px solid #e2e8f0; border-top: 1px solid #e2e8f0; border-bottom: 1px solid #e2e8f0; }
    
    /* Connect structural outer limits borders to inner properties mapping rows */
    .product-dashboard-row td:not(.style-td-first):not(.style-td-last) {
        border-top: 1px solid #e2e8f0;
        border-bottom: 1px solid #e2e8f0;
    }
    
    /* Elevates catalog cards cleanly upon interactive mouse hover interactions */
    .product-dashboard-row:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(29, 17, 11, 0.06) !important;
        background-color: #fffdfa !important;
    }

    /* Polished Action Buttons Styling Interaction Modifiers */
    .btn-action-edit {
        background-color: #8c6d58 !important;
        box-shadow: 0 2px 4px rgba(140, 109, 88, 0.2);
        transition: all 0.2s ease;
    }
    .btn-action-edit:hover {
        background-color: #735643 !important;
        transform: translateY(-1px);
    }

    .btn-action-delete {
        background-color: #dc2626 !important;
        box-shadow: 0 2px 4px rgba(220, 38, 38, 0.2);
        transition: all 0.2s ease;
    }
    .btn-action-delete:hover {
        background-color: #b91c1c !important;
        transform: translateY(-1px);
    }
    
    .font-weight-black { font-weight: 800 !important; }
    .hover-brightness:hover { filter: brightness(1.2); }
    .status-interactive-select { transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1); }
    .status-interactive-select:hover { filter: brightness(1.08); }
</style>
@endsection