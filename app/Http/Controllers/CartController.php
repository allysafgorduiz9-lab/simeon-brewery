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
}