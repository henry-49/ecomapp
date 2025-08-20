<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart;
use Illuminate\Support\Facades\DB;

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

    function addToCart($id)
    {
        // Logic to add a product to the cart
        $cart = new Cart();
        $cart->user_id = auth()->user()->id;
        $cart->product_id = $id;
        if($cart->save()) {
            return redirect()->back()->with('success', 'Product added to cart successfully!');
        } else {
            return redirect()->back()->with('error', 'Failed to add product to cart.');
        }

    }

    function showCart()
    {
        // Logic to show the cart items
        $cartItems = DB::table('cart')
        ->join('products', 'cart.product_id', '=', 'products.id')
        ->select(
            'cart.product_id', 
            DB::raw('count(*) as quantity'), 
            'products.title', 
            'products.image', 
            'products.slug', 
            'products.price')
        ->where('cart.user_id', auth()->user()->id)
        ->groupBy(
            'cart.product_id',
            'products.title', 
            'products.image', 
            'products.slug', 
            'products.price')
        ->paginate(10);

        return view('cart', compact('cartItems'));
    }
}