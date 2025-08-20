<?php

namespace Tests\Unit;

use App\Models\Product;
use PHPUnit\Framework\TestCase;


class ProductTest extends TestCase
{
 /** @test */
    public function test_product_has_a_title()
    {
        $product = new Product([
            'title' => 'Test Product',
            'slug' => 'test-product',
            'price' => 19.99,
            'stock' => 10,
            'description' => 'A test product',
            'image' => null,
        ]);

        $this->assertEquals('Test Product', $product->title);
    }
}