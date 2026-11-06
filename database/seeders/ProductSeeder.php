<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $defaultProducts = [
            [
                'name' => 'Studio Wireless ANC Headphones',
                'description' => 'Precision audio with active noise cancellation and 40-hour battery life.',
                'category' => 'audio',
                'price' => 7499.00,
                'compare_at_price' => 8999.00,
                'stock' => 18,
                'image_url' => 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?auto=format&fit=crop&w=720&q=80',
            ],
            [
                'name' => 'Horizon Minimalist Smartwatch',
                'description' => 'AMOLED screen, sapphire crystal face, and health tracking in brushed titanium.',
                'category' => 'wearables',
                'price' => 12999.00,
                'compare_at_price' => 14999.00,
                'stock' => 9,
                'image_url' => 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?auto=format&fit=crop&w=720&q=80',
            ],
            [
                'name' => 'Ceramic Aroma Diffuser & Lamp',
                'description' => 'Handcrafted ribbed stoneware diffuser with gentle warm ambient illumination.',
                'category' => 'home',
                'price' => 2899.00,
                'compare_at_price' => null,
                'stock' => 24,
                'image_url' => 'https://images.unsplash.com/photo-1602928321679-560bb453f190?auto=format&fit=crop&w=720&q=80',
            ],
            [
                'name' => 'Canvas Weekender Duffel',
                'description' => 'Heavyweight washed organic canvas with full-grain leather trim and brass hardware.',
                'category' => 'style',
                'price' => 4599.00,
                'compare_at_price' => 5299.00,
                'stock' => 7,
                'image_url' => 'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?auto=format&fit=crop&w=720&q=80',
            ],
        ];

        foreach ($defaultProducts as $product) {
            Product::query()->firstOrCreate(
                ['name' => $product['name']],
                $product
            );
        }
    }
}
