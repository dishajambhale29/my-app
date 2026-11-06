<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('sku', 64)->nullable()->unique();
            $table->decimal('stock_price', 10, 2)->default(0);
            $table->unsignedInteger('low_stock_threshold')->default(5);
            $table->string('publication_status', 20)->default('active');
        });

        DB::table('products')
            ->whereNull('sku')
            ->orderBy('id')
            ->chunkById(100, function ($products): void {
                foreach ($products as $product) {
                    DB::table('products')
                        ->where('id', $product->id)
                        ->update(['sku' => 'ACE-'.str_pad((string) $product->id, 8, '0', STR_PAD_LEFT)]);
                }
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropUnique('products_sku_unique');
            $table->dropColumn(['sku', 'stock_price', 'low_stock_threshold', 'publication_status']);
        });
    }
};
