<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        Product::factory()->count(10)->create();
        
        // Product::create([
        //     'title'       => 'MacBook Pro 14"',
        //     'slug'        => 'macbook-pro-14',
        //     'price'       => 1999.99,
        //     'stock'       => 10,
        //     'description' => 'Apple MacBook Pro 14-inch with M2 Pro chip.',
        //     'image'       => 'macbook-pro-14.jpg',
        // ]);

        // Product::create([
        //     'title'       => 'Samsung Galaxy S23',
        //     'slug'        => 'samsung-galaxy-s23',
        //     'price'       => 799.99,
        //     'stock'       => 25,
        //     'description' => 'Flagship Android smartphone with high-end camera system.',
        //     'image'       => 'galaxy-s23.jpg',
        // ]);

        // Product::create([
        //     'title'       => 'Sony WH-1000XM5 Headphones',
        //     'slug'        => 'sony-wh-1000xm5',
        //     'price'       => 349.99,
        //     'stock'       => 15,
        //     'description' => 'Noise-cancelling wireless headphones with superior sound quality.',
        //     'image'       => 'sony-headphones.jpg',
        // ]);
        
    }
}