<div id="editModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white p-6 rounded-2xl shadow-2xl" style="width: 450px; max-width: 90%;">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="h5 font-weight-black m-0" style="color: #1d110b;">Edit Menu Item</h2>
            <button type="button" onclick="document.getElementById('editModal').classList.add('hidden')" class="btn-close"></button>
        </div>
        
        <form id="editProductForm" action="" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT') <div class="mb-3">
                <label class="small font-weight-bold text-muted">Product Name</label>
                <input type="text" name="name" id="edit_name" class="form-control rounded-lg" required>
            </div>
            
            <div class="mb-3">
                <label class="small font-weight-bold text-muted">Price (₱)</label>
                <input type="number" name="price" id="edit_price" class="form-control rounded-lg" step="0.01" required>
            </div>
            
            <div class="d-flex justify-content-end gap-2 mt-4">
                <button type="button" 
                        onclick="document.getElementById('editModal').classList.add('hidden')" 
                        class="btn btn-light font-weight-bold px-4">Cancel</button>
                <button type="submit" 
                        class="btn text-white font-weight-bold px-4" 
                        style="background-color: #1d110b;">Save Changes</button>
            </div>
        </form>
    </div>
</div>

<script>
    /**
     * This function is called by the button in your index.blade.php
     * It dynamically updates the form action and populates the inputs.
     */
    function openEditModal(product) {
        // 1. Update the form URL to point to the specific product ID
        document.getElementById('editProductForm').action = "/admin/products/" + product.id;
        
        // 2. Populate the input fields
        document.getElementById('edit_name').value = product.name;
        document.getElementById('edit_price').value = product.price;
        
        // 3. Reveal the modal
        document.getElementById('editModal').classList.remove('hidden');
    }
</script>

<style>
    /* Ensure the modal overlay covers everything correctly */
    .hidden { display: none !important; }
    .fixed { position: fixed; }
    .inset-0 { top: 0; right: 0; bottom: 0; left: 0; }
    .flex { display: flex; }
    .items-center { align-items: center; }
    .justify-center { justify-content: center; }
    .z-50 { z-index: 1050; } /* Matches Bootstrap modal z-index */
</style>