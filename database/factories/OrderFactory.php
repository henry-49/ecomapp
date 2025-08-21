<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Order;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
     protected $model = Order::class;

    public function definition(): array
    {
        return [
            'user_id'     => User::factory(),
            'address'     => $this->faker->address(),
            'pincode'     => $this->faker->postcode(),
            'phone'       => $this->faker->phoneNumber(),
            'status'      => 'pending',
            'product_id'  => json_encode([$this->faker->numberBetween(1, 10)]), // example product ids
            'quantity'    => json_encode([$this->faker->numberBetween(1, 5)]),  // example quantities
            'total_price' => $this->faker->randomFloat(2, 20, 500),
        ];
    }
}