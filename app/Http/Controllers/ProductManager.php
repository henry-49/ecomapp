<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductManager extends Controller
{
    //
    function index()
    {
        // Logic to fetch and return products
        $products = Product::paginate(8);
        return view('products', compact('products'));
    }

    function details($slug)
    {
        // Logic to fetch and return a single product by slug
        $product = Product::where('slug', $slug)->first();
        return view('details', compact('product'));
    }

    function addToCart(Request $request, $id)
    {
        // Logic to add a product to the cart
        $product = Product::find($id);
        // Add the product to the cart (session or database)
        return redirect()->back()->with('success', 'Product added to cart!');
    }
}