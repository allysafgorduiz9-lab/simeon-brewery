@extends('layouts.admin') {{-- Extends your main dashboard template --}}

@section('content')
<div class="container-fluid px-4 py-4" style="font-family: 'Nunito', 'Segoe UI', sans-serif; background-color: #f8f9fa; min-height: 100vh;">
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1 text-gray-900 font-weight-black" style="font-weight: 800; letter-spacing: -0.75px;">Manage Menu</h1>
            <p class="text-muted small mb-0 font-weight-medium" style="font-size: 0.85rem; letter-spacing: 0.2px;">Add, modify, and monitor items inside Simeon Cafe pricing loops</p>
        </div>
        <div>
            <button class="btn text-white px-4 py-2.5 shadow-sm font-weight-bold d-flex align-items-center gap-2 transition-all hover-brightness" 
                    style="background-color: #1d110b; border-radius: 10px; font-weight: 700; font-size: 0.88rem; border: none;">
                <i class="fas fa-plus mr-1.5"></i> Add New Product
            </button>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-12 col-md-4">
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
        <div class="col-12 col-md-4">
            <div class="card border-0 shadow-sm p-3" style="border-radius: 14px; background: #ffffff; border-left: 4px solid #059669 !important;">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="text-muted small text-uppercase font-weight-bold mb-1" style="letter-spacing: 0.5px; font-size: 0.72rem;">Available Stock</p>
                        <h3 class="font-weight-black text-dark mb-0" style="font-weight: 800;">In Stock</h3>
                    </div>
                    <div class="p-3 rounded-lg" style="background-color: rgba(5, 150, 105, 0.05); color: #059669;">
                        <i class="fas fa-check-circle fa-lg"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4">
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
                    <th class="py-3.5 px-4 style-th-first" style="font-weight: 700; width: 90px;">Image</th>
                    <th class="py-3.5" style="font-weight: 700;">Product Name</th>
                    <th class="py-3.5" style="font-weight: 700;">Category</th>
                    <th class="py-3.5" style="font-weight: 700;">Base Price</th>
                    <th class="py-3.5 text-center" style="font-weight: 700; width: 140px;">Stock Status</th>
                    <th class="py-3.5 px-4 style-th-last text-center" style="width: 200px; font-weight: 700;">Actions</th>
                </tr>
            </thead>
            
            <tbody style="font-size: 0.88rem;">
                @forelse ($products ?? [] as $product)
                    <tr class="product-dashboard-row" style="background-color: #ffffff; box-shadow: 0 2px 12px rgba(0,0,0,0.035); transition: all 0.2s ease;">
                        
                        <td class="px-4 py-3 style-td-first">
                            <div class="rounded-lg overflow-hidden border border-gray-100 bg-light d-flex align-items-center justify-content-center shadow-2xs" 
                                 style="width: 48px; height: 48px; border-radius: 8px; background-color: #f8f9fa;">
                                @if(isset($product->image) && $product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="Menu Item" style="width: 100%; height: 100%; object-fit: cover;">
                                @else
                                    <i class="fas fa-mug-hot text-muted" style="opacity: 0.4; font-size: 1.1rem;"></i>
                                @endif
                            </div>
                        </td>
                        
                        <td class="text-gray-900 font-weight-bold" style="font-weight: 700; font-size: 0.95rem; color: #1a202c;">
                            {{ $product->name ?? 'Sample Coffee Item' }}
                        </td>
                        
                        <td>
                            <span class="badge px-2.5 py-1.5 rounded-md text-dark font-weight-semibold" 
                                  style="font-size: 0.78rem; background-color: #f1f5f9; border: 1px solid #e2e8f0; font-weight: 600;">
                                <i class="fas fa-tag mr-1 text-muted small"></i> {{ $product->category ?? 'Beverages' }}
                            </span>
                        </td>
                        
                        <td class="text-dark font-weight-black" style="font-size: 1.05rem; font-weight: 800; color: #1d110b;">
                            ₱{{ number_format($product->price ?? 145.00, 2) }}
                        </td>
                        
                        <td class="text-center">
                            <span class="badge px-3 py-1.5 rounded-pill font-weight-bold text-xs"
                                  style="font-weight: 700; letter-spacing: 0.3px;
                                  {{ (isset($product->stock) && $product->stock <= 0) ? 'background-color: rgba(220, 38, 38, 0.1) !important; color: #dc2626 !important;' : 'background-color: rgba(5, 150, 105, 0.1) !important; color: #059669 !important;' }}">
                                {{ (isset($product->stock) && $product->stock <= 0) ? '🔴 Out of Stock' : '🟢 Available' }}
                            </span>
                        </td>
                        
                        <td class="text-center px-4 style-td-last">
                            <div class="d-flex align-items-center justify-content-center gap-2">
                                <button class="btn btn-sm btn-light border text-dark font-weight-semibold px-3 py-1.5 shadow-2xs transition-all" 
                                        style="font-size: 0.8rem; border-radius: 6px; font-weight: 600; background-color: #ffffff;">
                                    <i class="fas fa-edit mr-1 text-muted"></i> Edit
                                </button>
                                <button class="btn btn-sm btn-light border text-danger font-weight-semibold px-2.5 py-1.5 transition-all" 
                                        style="font-size: 0.8rem; border-radius: 6px; font-weight: 600; background-color: #fff5f5; border-color: #fed7d7 !important;">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
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
    
    .font-weight-black { font-weight: 800 !important; }
    .hover-brightness:hover { filter: brightness(1.2); }
</style>
@endsection