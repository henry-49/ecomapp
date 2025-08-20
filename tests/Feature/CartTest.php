<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\User;
use App\Models\Product;
use App\Models\Cart;
use Tests\TestCase;

class CartTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_logged_in_user_can_add_a_product_to_cart()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();

        $response = $this->actingAs($user)->get('/cart/'.$product->id);

        $response->assertRedirect();
        $response->assertSessionHas('success', 'Product added to cart successfully!');

        $this->assertDatabaseHas('cart', [
            'user_id' => $user->id,
            'product_id' => $product->id,
        ]);
    }

    /** @test */
    public function guest_users_cannot_add_products_to_cart()
    {
        $product = Product::factory()->create();

        $response = $this->get('/cart/'.$product->id);

        $response->assertRedirect('/login');

        $this->assertDatabaseMissing('cart', [
            'product_id' => $product->id,
        ]);
    }


    /** @test */
    public function a_logged_in_user_can_view_cart_items()
    {
        // Arrange
        $user = User::factory()->create();

        $product = Product::factory()->create([
            'title' => 'Test Product',
            'price' => 99.99,
        ]);

        // Add product to cart for this user
        Cart::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
        ]);

        // Act
        $response = $this->actingAs($user)->get('/cart');

        // Assert
        $response->assertStatus(200);
        $response->assertViewIs('cart');
        $response->assertSeeText('Test Product');
        $response->assertSeeText('99.99');
    }

    /** @test */
    public function guest_users_cannot_view_cart()
    {
        // Act
        $response = $this->get('/cart');

        // Assert
        $response->assertRedirect('/login');
    }

    /** @test */
    public function cart_shows_correct_quantity_when_same_product_added_multiple_times()
    {
        // Arrange
        $user = User::factory()->create();
        $product = Product::factory()->create(['title' => 'Laptop']);

        // Add product 3 times for same user
        for ($i = 0; $i < 3; $i++) {
            Cart::create([
                'user_id' => $user->id,
                'product_id' => $product->id,
            ]);
        }

        // Act
        $response = $this->actingAs($user)->get('/cart');

        // Assert
        $response->assertStatus(200);
        $response->assertSeeText('Laptop');
        $response->assertSeeText('3'); // quantity from DB::raw('count(*) as quantity')
    }
}