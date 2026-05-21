<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display the manage menu / products page.
     */
    public function index()
    {
        // For now, we will just return a simple blank view. 
        // You can pass your products database data here later!
        return view('admin.products.index');
    }
}