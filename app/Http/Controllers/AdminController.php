<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // Optional fallback if using query builder

class AdminController extends Controller
{
    /**
     * Show the Admin Categories Dashboard
     */
   public function categories()
    {
        // 🛠️ FIX: Use the Eloquent model and eager-load ('with') the products relationship count!
        $categories = Category::with('products')->get();

        return view('admin.categories', compact('categories'));
    }

    /**
     * Add a New Category
     */
    public function addCategory(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // Clean Eloquent Insert
        Category::create([
            'name' => $request->name
        ]);

        return back()->with('success', 'Category added successfully!');
    }

    /**
     * Delete an Existing Category
     */
    public function deleteCategory($id)
    {
        // Clean Eloquent Delete
        Category::findOrFail($id)->delete();

        return back()->with('success', 'Category deleted successfully!');
    }

    /**
     * Placeholder Login View Method
     */
    public function login()
    {
        return view('admin.login');
    }
}