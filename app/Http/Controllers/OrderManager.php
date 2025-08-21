<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

class OrderManager extends Controller
{
    //
    function showCheckout()
    {

        return view('checkout');
    }

    function processCheckout(Request $request)
    {
        // Logic to process the checkout
        // Validate the request data
        $request->validate([
            'address' => 'required|string|max:255',
            'pincode' => 'required',
            'phone' => 'required',
        ]);

        $cartItems = DB::table('cart')
        ->join('products', 'cart.product_id', '=', 'products.id')
        ->select(
            'cart.product_id', 
            DB::raw('count(*) as quantity'), 
            'products.price')
        ->where('cart.user_id', auth()->user()->id)
        ->groupBy(
            'cart.product_id',   
            'products.price')
        ->get();
        
        // Check if the cart is empty
        if ($cartItems->isEmpty()) {
            return redirect(route('cart.show'))->with('error', 'Your cart is empty.');
        }

        // Calculate total price based on cart items
        $productIds = [];
        $quantities = [];
        $totalPrice = 0;

        foreach ($cartItems as $item) {
            $productIds[] = $item->product_id;
            $quantities[] = $item->quantity;
            $totalPrice += $item->quantity * $item->price;
        }

        // Create a new order
        $order = new Order();
        $order->user_id = auth()->user()->id;
        $order->address = $request->address;
        $order->postcode = $request->postcode;
        $order->phone = $request->phone;
        $order->status = $request->status ?? 'pending'; // Default status to 'pending' if not provided
        $order->product_id = json_encode($productIds); // Store product IDs as JSON
        $order->quantity = json_encode($quantities); // Store quantities as JSON
        $order->total_price = $totalPrice; // Calculate total price based on cart items

        // Save the order
        if ($order->save()) {
            // Clear the cart after successful order creation
            DB::table('cart')->where('user_id', auth()->user()->id)->delete();
            
            // Logic to handle successful order creation, e.g., redirecting to a success page
            return redirect()->route('cart.show')->with('success', 'Order placed successfully!');
        } else {
            return redirect()->route('cart.show')->with('error', 'Failed to place order.');
        }
    }
}