<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $categories = ['audio', 'wearables', 'home', 'style', 'other'];
        $price = fake()->randomFloat(2, 299, 14999);
        $hasDiscount = fake()->boolean(40);

        return [
            'name' => fake()->words(3, true),
            'description' => fake()->sentence(12),
            'category' => fake()->randomElement($categories),
            'price' => $price,
            'compare_at_price' => $hasDiscount ? round($price * fake()->randomFloat(2, 1.15, 1.5), 2) : null,
            'stock' => fake()->numberBetween(0, 100),
            'image_url' => 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?auto=format&fit=crop&w=720&q=80',
        ];
    }
}
