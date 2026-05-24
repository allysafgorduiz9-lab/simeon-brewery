@extends('layouts.admin') {{-- Extends your main dashboard template --}}

@section('content')
<div class="container-fluid px-4 py-4" style="font-family: 'Nunito', 'Segoe UI', sans-serif; background-color: #f8f9fa; min-height: 100vh;">
    
    <div class="mb-3">
        <a href="{{ route('admin.products.index') }}" class="text-decoration-none small font-weight-bold" style="color: #8c6d58;">
            <i class="fas fa-arrow-left me-1"></i> Back to Manage Menu
        </a>
    </div>

    <div class="mb-4">
        <h1 class="h3 mb-1 text-gray-900 font-weight-black" style="font-weight: 800; letter-spacing: -0.75px;">Add New Product</h1>
        <p class="text-muted small mb-0 font-weight-medium" style="font-size: 0.85rem; letter-spacing: 0.2px;">Introduce a premium beverage, pastry, or addition to the customer store catalog</p>
    </div>

    <div class="card border-0 shadow-sm" style="border-radius: 16px; background-color: #ffffff;">
        <div class="card-body p-4">
            
            <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row g-4">
                    <div class="col-12 col-lg-8">
                        
                        <div class="mb-4">
                            <label class="form-label text-dark font-weight-bold mb-1" style="font-weight: 700; font-size: 0.9rem;">Product Name</label>
                            <input type="text" name="name" class="form-control px-3 py-2.5 rounded-lg border-gray-200" 
                                   placeholder="e.g., Caramel Macchiato, Dark Chocolate Croissant" required
                                   style="font-size: 0.9rem; border-radius: 8px;">
                        </div>

                        <div class="row">
                            <div class="col-12 col-md-6 mb-4">
                                <label class="form-label text-dark font-weight-bold mb-1" style="font-weight: 700; font-size: 0.9rem;">Category</label>

<select name="category_id" class="form-control form-select">
    
    @foreach($categories as $category)
        <option value="{{ $category->id }}">{{ $category->name }}</option>
    @endforeach
</select>

                            </div>

                            <div class="col-12 col-md-6 mb-4">
                                <label class="form-label text-dark font-weight-bold mb-1" style="font-weight: 700; font-size: 0.9rem;">Base Price (PHP)</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-gray-200 text-dark font-weight-bold px-3" style="border-radius: 8px 0 0 8px;">₱</span>
                                    <input type="number" step="0.01" name="price" class="form-control px-3 py-2.5 border-gray-200" 
                                           placeholder="145.00" required style="font-size: 0.9rem; border-radius: 0 8px 8px 0;">
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label text-dark font-weight-bold mb-1" style="font-weight: 700; font-size: 0.9rem;">Initial Availability Status</label>
                            <select name="stock" class="form-select px-3 py-2.5 rounded-lg border-gray-200" style="font-size: 0.9rem; border-radius: 8px;">
                                <option value="1" selected>🟢 Available (Instantly visible to customers)</option>
                                <option value="0">🔴 Unavailable (Hidden/Disabled inside store catalogs)</option>
                            </select>
                        </div>

                    </div>

                    <div class="col-12 col-lg-4 d-flex flex-column align-items-stretch">
                        <label class="form-label text-dark font-weight-bold mb-1" style="font-weight: 700; font-size: 0.9rem;">Product Thumbnail Image</label>
                        
                        <div class="border border-dashed border-gray-300 rounded-lg p-4 text-center d-flex flex-column align-items-center justify-content-center flex-grow-1" 
                             style="border-radius: 12px; background-color: #fdfbf9; min-height: 220px; border-style: dashed !important; border-width: 2px !important;">
                            <i class="fas fa-image fa-3x mb-3 text-muted" style="color: #8c6d58 !important; opacity: 0.4;"></i>
                            <p class="small text-muted mb-3 font-weight-medium">Upload a square image file (.png, .jpg) to save to the database storage link</p>
                            
                            <input type="file" name="image" id="productImageInput" class="form-control form-control-sm border-0 bg-transparent cursor-pointer text-muted" style="font-size: 0.8rem;">
                        </div>
                    </div>
                </div>

                <hr class="my-4 text-gray-200">

                <div class="d-flex align-items-center justify-content-end gap-2">
                    <a href="{{ route('admin.products.index') }}" class="btn btn-light border font-weight-bold px-4 d-inline-flex align-items-center justify-content-center text-dark" 
                       style="font-size: 0.85rem; border-radius: 8px; font-weight: 700; width: 120px; height: 40px; background-color: #ffffff;">
                        Cancel
                    </a>
                    
                    <button type="submit" class="btn text-white font-weight-bold px-4 d-inline-flex align-items-center justify-content-center transition-all hover-brightness" 
                            style="font-size: 0.85rem; border-radius: 8px; font-weight: 700; background-color: #1d110b; border: none; width: 140px; height: 40px;">
                        <i class="fas fa-save me-1.5 small"></i>Save Product
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>

<style>
    .font-weight-black { font-weight: 800 !important; }
    .hover-brightness:hover { filter: brightness(1.2); }
    input:focus, select:focus {
        border-color: #8c6d58 !important;
        box-shadow: 0 0 0 3px rgba(140, 109, 88, 0.15) !important;
    }
</style>
@endsection