<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'name' => fake()->words(3, true),
            'quantity' => fake()->numberBetween(1, 1000),
            'description' => fake()->sentence(),
            'price' => fake()->randomFloat(2, 1, 1000),
            'image' => null,
            'status' => 'active',
            'expiry_date' => fake()->optional()->dateTimeBetween('now', '+2 years')?->format('Y-m-d'),
        ];
    }
}
