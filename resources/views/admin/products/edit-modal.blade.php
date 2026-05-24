<div id="editModal" class="hidden fixed inset-0 bg-dark bg-opacity-50 backdrop-blur-sm d-flex align-items-center justify-content-center z-50 p-4">
    <div class="bg-white rounded-4 shadow-lg w-100 overflow-hidden border-0" style="max-width: 550px; animation: slideDown 0.4s cubic-bezier(0.16, 1, 0.3, 1);">
        
        <div class="px-4 py-3 bg-light border-bottom d-flex justify-content-between align-items-center">
            <h6 class="m-0 fw-bold text-uppercase text-secondary" style="letter-spacing: 1px;">Edit Product Details</h6>
            <button type="button" onclick="document.getElementById('editModal').classList.add('hidden')" class="btn-close opacity-50"></button>
        </div>

        <form id="editProductForm" action="" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="p-4">
                <div class="row g-4 align-items-center">
                    <div class="col-auto">
                        <label for="edit_image_input" class="position-relative cursor-pointer">
                            <img id="edit_image_preview" src="" class="rounded-3 border shadow-sm" style="width: 100px; height: 100px; object-fit: cover;">
                            <div class="position-absolute bottom-0 start-0 w-100 bg-dark bg-opacity-75 text-white text-center rounded-bottom-3" style="font-size: 0.65rem; padding: 2px;">CHANGE</div>
                        </label>
                        <input type="file" name="image" id="edit_image_input" class="d-none" accept="image/*" onchange="previewImage(event)">
                    </div>
                    <div class="col">
                        <h5 class="fw-bold mb-1" id="display_name">Product Name</h5>
                        <p class="text-muted small mb-0">Update item information for the menu.</p>
                    </div>
                </div>

                <hr class="my-4 opacity-25">

                <div class="row g-3">
                    <div class="col-12">
                        <label class="small fw-bold text-muted mb-1">Product Name</label>
                        <input type="text" name="name" id="edit_name" class="form-control form-control-sm py-2" required oninput="document.getElementById('display_name').innerText = this.value">
                    </div>
                    <div class="col-md-6">
                        <label class="small fw-bold text-muted mb-1">Category</label>
                       <select name="category_id" id="edit_category" class="form-select form-select-sm py-2">
    @foreach($categories ?? [] as $category)
        <option value="{{ $category->id }}">{{ $category->name }}</option>
    @endforeach
</select>
                    </div>
                    <div class="col-md-6">
                        <label class="small fw-bold text-muted mb-1">Price (₱)</label>
                        <div class="input-group input-group-sm">
                            <span class="input-group-text bg-light border-end-0">₱</span>
                            <input type="number" name="price" id="edit_price" class="form-control py-2 border-start-0" step="0.01" required>
                        </div>
                    </div>
                </div>
            </div>

            <div class="px-4 py-3 bg-light d-flex justify-content-end gap-2">
                <button type="button" onclick="document.getElementById('editModal').classList.add('hidden')" class="btn btn-sm btn-outline-secondary px-3">Discard</button>
                <button type="submit" class="btn btn-sm px-4" style="background-color: #1d110b; color: white;">Save Updates</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openEditModal(product) {
        document.getElementById('editProductForm').action = "/admin/products/" + product.id;
        document.getElementById('edit_name').value = product.name;
        document.getElementById('display_name').innerText = product.name; // Live title update
        document.getElementById('edit_price').value = product.price;
        document.getElementById('edit_category').value = product.category_id;
        document.getElementById('edit_image_preview').src = "/storage/" + product.image;
        document.getElementById('editModal').classList.remove('hidden');
    }

    function previewImage(event) {
        if(event.target.files && event.target.files[0]) {
            const reader = new FileReader();
            reader.onload = (e) => document.getElementById('edit_image_preview').src = e.target.result;
            reader.readAsDataURL(event.target.files[0]);
        }
    }
</script>

<style>
    @keyframes slideDown { from { opacity: 0; transform: translateY(-20px); } to { opacity: 1; transform: translateY(0); } }
    .hidden { display: none !important; }
    .cursor-pointer { cursor: pointer; }
</style>