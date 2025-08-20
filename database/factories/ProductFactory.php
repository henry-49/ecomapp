<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Products>
 */
class ProductFactory extends Factory
{
     protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
   public function definition(): array
    {

        return [
            'title' => $this->faker->words(3, true),
            'slug' => Str::slug($this->faker->unique()->words(3, true)),
            'price' => $this->faker->randomFloat(2, 5, 200), // price between 5.00 and 200.00
            'stock' => $this->faker->numberBetween(0, 100),
            'description' => $this->faker->sentence(10),
            'image' => $this->faker->imageUrl(640, 480, 'products', true),
        ];
    }
}