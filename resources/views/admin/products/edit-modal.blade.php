<div id="editModal" class="hidden fixed inset-0 bg-stone-900 bg-opacity-40 backdrop-blur-sm d-flex align-items-center justify-content-center z-50 p-3">
    <div class="bg-white rounded-3xl shadow-2xl border border-stone-100 overflow-hidden w-100" style="max-width: 500px; animation: modalFadeIn 0.3s ease;">
        
        <div class="p-4 border-bottom border-stone-100 d-flex justify-content-between align-items-center">
            <h5 class="m-0 font-weight-black text-stone-800">Edit Product</h5>
            <button type="button" onclick="document.getElementById('editModal').classList.add('hidden')" class="btn-close shadow-none"></button>
        </div>

        <form id="editProductForm" action="" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="p-4">
                <div class="mb-4 text-center">
                    <label for="edit_image_input" class="d-block mx-auto position-relative" style="width: 140px; height: 140px; cursor: pointer;">
                        <img id="edit_image_preview" src="" class="w-100 h-100 object-fit-cover rounded-3 border border-2 border-stone-200" style="transition: 0.3s;">
                        <div class="position-absolute bottom-0 w-100 bg-black bg-opacity-50 text-white py-1 rounded-bottom-3 small">Change Photo</div>
                    </label>
                    <input type="file" name="image" id="edit_image_input" class="d-none" accept="image/*" onchange="previewImage(event)">
                </div>

                <div class="form-group mb-3">
                    <label class="small text-uppercase font-weight-bold text-stone-500 mb-1">Product Name</label>
                    <input type="text" name="name" id="edit_name" class="form-control form-control-lg bg-stone-50 border-0 rounded-3 shadow-none">
                </div>

                <div class="form-group">
                    <label class="small text-uppercase font-weight-bold text-stone-500 mb-1">Price (PHP)</label>
                    <div class="input-group">
                        <span class="input-group-text bg-stone-50 border-0 rounded-start-3 font-weight-bold text-stone-400">₱</span>
                        <input type="number" name="price" id="edit_price" class="form-control form-control-lg bg-stone-50 border-0 rounded-end-3 shadow-none" step="0.01">
                    </div>
                </div>
            </div>

            <div class="p-4 bg-stone-50 d-flex justify-content-end gap-2">
                <button type="button" onclick="document.getElementById('editModal').classList.add('hidden')" class="btn btn-link text-stone-500 font-weight-bold shadow-none text-decoration-none">Cancel</button>
                <button type="submit" class="btn btn-dark px-4 py-2 rounded-3 font-weight-bold shadow-sm" style="background: #1d110b;">Update Changes</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openEditModal(product) {
        document.getElementById('editProductForm').action = "/admin/products/" + product.id;
        document.getElementById('edit_name').value = product.name;
        document.getElementById('edit_price').value = product.price;
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
    @keyframes modalFadeIn { from { opacity: 0; transform: scale(0.95); } to { opacity: 1; transform: scale(1); } }
    .hidden { display: none !important; }
    .object-fit-cover { object-fit: cover; }
</style>