<?php

namespace Tests\Feature;

use App\Models\Product;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductTest extends TestCase
{
    use RefreshDatabase;
    
        use RefreshDatabase;

    /** @test */
    public function it_can_list_products()
    {
        // Arrange: create products
        $products = Product::factory()->count(10)->create();

        // Act: visit the products page
        $response = $this->get('/');

        // Assert
        $response->assertStatus(200);
        $response->assertViewIs('products'); // checks correct Blade view
        
    }

    /** @test */
    public function it_can_show_a_single_product_by_slug()
    {
        // Arrange: create one product
        $product = Product::factory()->create([
            'slug' => 'test-product',
            'title' => 'Test Product'
        ]);

        // Act: visit the product details page
        $response = $this->get('/product/test-product');

        // Assert
        $response->assertStatus(200);
        $response->assertViewIs('details'); // checks correct Blade view
        $response->assertSee('Test Product');
    }

    /** @test */
    public function it_can_show_product_details()
    {
        // Arrange: create a single product
        $product = Product::factory()->create(['title' => 'Laptop']);

        // Act: visit the product details page
        $response = $this->get('/product/' . $product->slug);

        // Assert
        $response->assertStatus(200);
        $response->assertSeeText('Laptop');
        $response->assertSeeText($product->description); // if you have description in your view
    }
}