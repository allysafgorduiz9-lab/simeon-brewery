<div id="editModal" class="hidden fixed inset-0 bg-black bg-opacity-60 flex items-center justify-center z-50">
    <div class="bg-white rounded-2xl shadow-2xl overflow-hidden" style="width: 480px; max-width: 95%;">
        <div class="px-6 py-4 border-b border-gray-100 d-flex justify-content-between align-items-center bg-gray-50">
            <h2 class="h6 font-weight-black m-0" style="color: #1d110b;">Update Menu Item</h2>
            <button type="button" onclick="document.getElementById('editModal').classList.add('hidden')" class="btn-close opacity-50"></button>
        </div>
        
        <form id="editProductForm" action="" method="POST" enctype="multipart/form-data" class="p-6">
            @csrf
            @method('PUT')
            
            <div class="text-center mb-4">
                <div class="position-relative d-inline-block">
                    <img id="edit_image_preview" src="" alt="Product" 
                         style="width: 120px; height: 120px; object-fit: cover; border-radius: 12px; border: 2px solid #e2e8f0;">
                    <label for="edit_image_input" class="position-absolute bottom-0 end-0 bg-dark text-white rounded-circle d-flex align-items-center justify-content-center" 
                           style="width: 32px; height: 32px; cursor: pointer; border: 2px solid white;">
                        <i class="fas fa-camera small"></i>
                    </label>
                </div>
                <input type="file" name="image" id="edit_image_input" class="hidden" accept="image/*" onchange="previewImage(event)">
            </div>

            <div class="mb-3">
                <label class="small font-weight-bold text-muted">Product Name</label>
                <input type="text" name="name" id="edit_name" class="form-control rounded-lg shadow-none border-gray-200" required>
            </div>
            
            <div class="mb-3">
                <label class="small font-weight-bold text-muted">Base Price (₱)</label>
                <input type="number" name="price" id="edit_price" class="form-control rounded-lg shadow-none border-gray-200" step="0.01" required>
            </div>
            
            <div class="d-flex justify-content-end gap-2 mt-4">
                <button type="button" onclick="document.getElementById('editModal').classList.add('hidden')" class="btn btn-light px-4 font-weight-bold">Cancel</button>
                <button type="submit" class="btn text-white px-4 font-weight-bold" style="background-color: #1d110b;">Save Changes</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openEditModal(product) {
        document.getElementById('editProductForm').action = "/admin/products/" + product.id;
        document.getElementById('edit_name').value = product.name;
        document.getElementById('edit_price').value = product.price;
        
        // Load existing image
        document.getElementById('edit_image_preview').src = "/storage/" + product.image;
        
        document.getElementById('editModal').classList.remove('hidden');
    }

    // Professional Image Preview Logic
    function previewImage(event) {
        const reader = new FileReader();
        reader.onload = function(){
            const output = document.getElementById('edit_image_preview');
            output.src = reader.result;
        };
        reader.readAsDataURL(event.target.files[0]);
    }
</script>

<style>
    .hidden { display: none !important; }
</style>