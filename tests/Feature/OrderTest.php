<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\Cart;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use Tests\TestCase;

class OrderTest extends TestCase
{
   use RefreshDatabase;

    /** @test */
    public function a_logged_in_user_can_view_checkout_page()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/checkout');

        $response->assertStatus(200);
        $response->assertViewIs('checkout');
    }

    /** @test */
    public function a_guest_cannot_view_checkout_page()
    {
        $response = $this->get('/checkout');

        $response->assertRedirect('/login');
    }

    /** @test */
    public function a_logged_in_user_can_place_order()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();

        // Add product to cart
        $this->actingAs($user)->get('/cart/' . $product->id);

        $checkoutData = [
            'address' => '123 Street, City',
            'postcode' => '123456',
            'phone' => '1234567890',
        ];

        $response = $this->actingAs($user)->post('/checkout', $checkoutData);

        $response->assertRedirect(route('cart.show'));
        $response->assertSessionHas('success', 'Order placed successfully!');

        $this->assertDatabaseHas('orders', [
            'user_id' => $user->id,
            'status' => 'pending',
        ]);
    }

    /** @test */
    public function checkout_fails_if_cart_is_empty()
    {
        $user = User::factory()->create();

        $checkoutData = [
            'address' => '123 Street, City',
            'postcode' => '123456',
            'phone' => '1234567890',
        ];

        $response = $this->actingAs($user)->post('/checkout', $checkoutData);

        $response->assertRedirect(route('cart.show'));
        $response->assertSessionHas('error', 'Your cart is empty.');
    }

    /** @test */
    public function a_logged_in_user_can_place_an_order_with_cart_items()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create(['price' => 50]);

        // Add product twice to simulate quantity
        Cart::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
        ]);
        Cart::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
        ]);

        $response = $this->actingAs($user)->post('/checkout', [
            'address' => '123 Main St',
            'postcode' => '123456',
            'phone'   => '9876543210',
        ]);

        $response->assertRedirect(route('cart.show'));
        $response->assertSessionHas('success', 'Order placed successfully!');

        // Ensure order was saved
        $this->assertDatabaseHas('orders', [
            'user_id' => $user->id,
            'status'  => 'pending',
        ]);

        // Ensure cart is cleared
        $this->assertDatabaseMissing('carts', [
            'user_id' => $user->id,
        ]);
    }

    /** @test */
    public function checkout_requires_address_pincode_and_phone()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/checkout', []);

        $response->assertSessionHasErrors(['address', 'postcode', 'phone']);
    }

    /** @test */
    public function order_has_correct_quantities_and_total_price()
    {
        $user = User::factory()->create();
        $product1 = Product::factory()->create(['price' => 50]);
        $product2 = Product::factory()->create(['price' => 30]);

        // Add products to cart multiple times
        $this->actingAs($user)->get('/cart/' . $product1->id);
        $this->actingAs($user)->get('/cart/' . $product1->id);
        $this->actingAs($user)->get('/cart/' . $product2->id);

        $checkoutData = [
            'address' => '456 Avenue, City',
            'postcode' => '654321',
            'phone' => '0987654321',
        ];

        $response = $this->actingAs($user)->post('/checkout', $checkoutData);

        $response->assertRedirect(route('cart.show'));
        $response->assertSessionHas('success', 'Order placed successfully!');

        $order = Order::where('user_id', $user->id)->first();

        $this->assertNotNull($order, 'Order was not created');

        // Decode JSON stored in order
        $productIds = json_decode($order->product_id, true);
        $quantities = json_decode($order->quantity, true);

        // Assert correct products and quantities
        $this->assertEqualsCanonicalizing([$product1->id, $product2->id], $productIds);
        $this->assertEquals([2, 1], $quantities);

        // Assert total price calculation
        $expectedTotal = 2 * $product1->price + 1 * $product2->price;
        $this->assertEquals($expectedTotal, $order->total_price);
    }
}