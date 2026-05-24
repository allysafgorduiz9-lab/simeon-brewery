<?php
 
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartController extends Controller
{
    // ... your existing methods like viewCart or addCart ...

    public function remove(Request $request)
    {
        // 1. Verify that an item ID was passed
        if ($request->id) {
            
            // 2. Grab the current cart array out of the session
            $cart = session()->get('cart');

            // 3. Check if the product item exists in the array, then remove it
            if (isset($cart[$request->id])) {
                unset($cart[$request->id]);
                
                // 4. Overwrite the session with the updated cart array
                session()->put('cart', $cart);
            }

            // 5. Send the user back to the cart page with a sleek success notification
            return redirect()->back()->with('success', 'Item removed from your basket successfully!');
        }
        
        return redirect()->back();
    }
    public function addToCart(Request $request)
{
    // 🛠️ Backend Security Guard
    $storeStatus = \DB::table('store_settings')->where('key', 'store_status')->value('value') ?? 'open';
    
    if ($storeStatus !== 'open') {
        return back()->with('error', 'Orders are currently closed by the administrator.');
    }

    // ... your original add to cart logic continues below ...
}
//public function cart()
//{
    // Fetch settings here
  //  $gcashNum = \App\Models\Setting::where('key', 'gcash_number')->first();
  //  $mayaNum = \App\Models\Setting::where('key', 'paymaya_number')->first();

    // Use the actual column name here (e.g., 'content' or whatever you found)
  //  $gcashNumber = $gcashNum ? $gcashNum->your_actual_column_name : 'N/A';
//    $mayaNumber = $mayaNum ? $mayaNum->your_actual_column_name : 'N/A';

   // return view('customer.cart', compact('gcashNumber', 'mayaNumber'));
//}

}