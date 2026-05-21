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
        // 🛠️ Fetch your categories from the database. 
        // If you don't have a Category Model yet, we use raw DB selection to prevent crashes:
        $categories = DB::table('categories')->get();

        // Looks for a view file named resources/views/admin/categories.blade.php
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

        DB::table('categories')->insert([
            'name' => $request->name,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return back()->with('success', 'Category added successfully!');
    }

    /**
     * Delete an Existing Category
     */
    public function deleteCategory($id)
    {
        DB::table('categories')->where('id', $id)->delete();

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