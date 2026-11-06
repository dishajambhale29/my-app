<?php

namespace App\Models;

use Database\Factories\ProductFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['name', 'description', 'category', 'price', 'compare_at_price', 'stock_price', 'stock', 'low_stock_threshold', 'publication_status', 'sku', 'image_url'])]
class Product extends Model
{
    /** @use HasFactory<ProductFactory> */
    use HasFactory;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'compare_at_price' => 'decimal:2',
            'stock_price' => 'decimal:2',
            'stock' => 'integer',
            'low_stock_threshold' => 'integer',
        ];
    }
}
