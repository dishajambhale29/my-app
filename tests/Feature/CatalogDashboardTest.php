<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CatalogDashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_dashboard_displays_catalog_analytics(): void
    {
        Product::query()->create([
            'name' => 'Blue headphones',
            'category' => 'audio',
            'price' => 1499,
            'stock' => 2,
        ]);

        $response = $this->get(route('home'));

        $response->assertOk()
            ->assertSee('Total Products')
            ->assertSee('Active Products')
            ->assertSee('Low Stock Alert')
            ->assertSee('Out of Stock')
            ->assertSee('Critical Stock Replenishment')
            ->assertSee('Catalog SKU Breakdown')
            ->assertSee('Store Channel Sync')
            ->assertSee('Blue headphones')
            ->assertSee('Product inventory')
            ->assertSee('publication-status--active', false)
            ->assertSee('Stock compared with low-stock threshold')
            ->assertSee('data-add-to-cart="catalog-1"', false)
            ->assertSee('Add to bag')
            ->assertSee('id="inventory-search"', false)
            ->assertSee('id="inventory-category-select"', false)
            ->assertSee('id="inventory-sort-select"', false)
            ->assertSee('id="product-table-body"', false)
            ->assertSee('Dashboard')
            ->assertSee('Product management')
            ->assertSee('Store management')
            ->assertSee('Orders')
            ->assertSee('Venders management')
            ->assertSee('Promotions')
            ->assertSee('Marketing management')
            ->assertSee('POS')
            ->assertSee('logout-button is-red', false)
            ->assertSee('data-product-management', false)
            ->assertSee('SKU (Stock Keeping Unit)')
            ->assertSee('Regular price (₹)')
            ->assertSee('Stock price (₹)')
            ->assertSee('Low stock threshold')
            ->assertSee('Publication status')
            ->assertSee('Short summary')
            ->assertDontSee('<p class="nav-label">MENU</p>', false)
            ->assertDontSee('Browse products')
            ->assertDontSee('Saved items')
            ->assertDontSee('THE WEEKEND EDIT');
    }

    public function test_inventory_stock_ranges_use_a_shared_maximum(): void
    {
        Product::query()->create([
            'name' => 'Low stock item',
            'sku' => 'ACE-AUD-LOWRANGE',
            'category' => 'audio',
            'price' => 100,
            'stock' => 2,
        ]);
        Product::query()->create([
            'name' => 'Maximum stock item',
            'sku' => 'ACE-AUD-MAXRANGE',
            'category' => 'audio',
            'price' => 100,
            'stock' => 8,
        ]);

        $this->get(route('home'))
            ->assertOk()
            ->assertSee('aria-valuemax="8"', false)
            ->assertSee('aria-valuenow="2"', false)
            ->assertSee('aria-valuenow="8"', false)
            ->assertSee('style="--stock-level: 25%"', false)
            ->assertSee('style="--stock-level: 100%"', false);
    }

    public function test_product_can_be_added_to_the_catalog(): void
    {
        $response = $this->post(route('products.store'), [
            'name' => 'Wireless speaker',
            'sku' => 'ACE-AUD-TEST0001',
            'description' => 'Portable Bluetooth speaker',
            'category' => 'audio',
            'price' => '2499.00',
            'compare_at_price' => '2999.00',
            'stock_price' => '1299.00',
            'stock' => 5,
            'low_stock_threshold' => 8,
            'publication_status' => 'active',
            'image_url' => 'https://example.com/speaker.jpg',
        ]);

        $response->assertRedirect(route('home').'#products')
            ->assertSessionHas('success', 'Product added to your catalog.');

        $this->assertDatabaseHas('products', [
            'name' => 'Wireless speaker',
            'sku' => 'ACE-AUD-TEST0001',
            'category' => 'audio',
            'price' => 2499,
            'compare_at_price' => 2999,
            'stock_price' => 1299,
            'stock' => 5,
            'low_stock_threshold' => 8,
            'publication_status' => 'active',
        ]);

        $this->get(route('home'))
            ->assertOk()
            ->assertSee('Wireless speaker')
            ->assertSee('Low stock')
            ->assertSee('ACE-AUD-TEST0001');
    }

    public function test_product_sku_must_be_unique(): void
    {
        Product::query()->create([
            'name' => 'Existing item',
            'sku' => 'ACE-AUD-DUPLICATE',
            'category' => 'audio',
            'price' => 1200,
            'stock' => 1,
        ]);

        $response = $this->from(route('home'))->post(route('products.store'), [
            'name' => 'Duplicate item',
            'sku' => 'ACE-AUD-DUPLICATE',
            'category' => 'audio',
            'price' => 1500,
            'stock_price' => 800,
            'stock' => 2,
            'low_stock_threshold' => 5,
            'publication_status' => 'active',
        ]);

        $response->assertRedirect(route('home'))
            ->assertSessionHasErrors(['sku' => 'The sku has already been taken.']);

        $this->assertDatabaseCount('products', 1);
    }

    public function test_product_is_not_saved_when_required_fields_are_invalid(): void
    {
        $response = $this->from(route('home'))->post(route('products.store'), [
            'name' => '',
            'category' => 'unknown',
            'price' => '-1',
            'stock' => '-2',
        ]);

        $response->assertRedirect(route('home'))
            ->assertSessionHasErrors(['name', 'sku', 'category', 'price', 'stock_price', 'stock', 'low_stock_threshold', 'publication_status']);

        $this->assertDatabaseCount('products', 0);
    }

    public function test_product_can_be_updated(): void
    {
        $product = Product::query()->create([
            'name' => 'Original Headphones',
            'sku' => 'ACE-AUD-ORIGINAL1',
            'description' => 'Original description',
            'category' => 'audio',
            'price' => 1999.00,
            'compare_at_price' => 2499.00,
            'stock' => 10,
            'image_url' => 'https://example.com/headphones.jpg',
        ]);

        $response = $this->put(route('products.update', $product), [
            'name' => 'Updated Studio Headphones',
            'sku' => 'ACE-AUD-ORIGINAL1',
            'description' => 'Upgraded with ANC and titanium drivers',
            'category' => 'audio',
            'price' => 2999.00,
            'compare_at_price' => 3499.00,
            'stock_price' => 1800.00,
            'stock' => 15,
            'low_stock_threshold' => 10,
            'publication_status' => 'draft',
            'image_url' => 'https://example.com/updated-headphones.jpg',
        ]);

        $response->assertRedirect(route('home').'#products')
            ->assertSessionHas('success', 'Product updated successfully.');

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'name' => 'Updated Studio Headphones',
            'sku' => 'ACE-AUD-ORIGINAL1',
            'sku' => 'ACE-AUD-UPDATED01',
            'price' => 2999.00,
            'compare_at_price' => 3499.00,
            'stock_price' => 1800.00,
            'stock' => 15,
            'low_stock_threshold' => 10,
            'publication_status' => 'draft',
        ]);
    }

    public function test_product_update_fails_with_invalid_data(): void
    {
        $product = Product::query()->create([
            'name' => 'Smart Watch',
            'category' => 'wearables',
            'price' => 4999.00,
            'stock' => 5,
        ]);

        $response = $this->from(route('home'))->put(route('products.update', $product), [
            'name' => '',
            'sku' => '',
            'category' => 'invalid-category',
            'price' => -50,
            'stock_price' => -1,
            'stock' => -1,
            'low_stock_threshold' => -1,
            'publication_status' => 'published',
        ]);

        $response->assertRedirect(route('home'))
            ->assertSessionHasErrors(['name', 'category', 'price', 'stock']);

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'name' => 'Smart Watch',
        ]);
    }

    public function test_product_can_be_deleted(): void
    {
        $product = Product::query()->create([
            'name' => 'Product To Remove',
            'category' => 'home',
            'price' => 899.00,
            'stock' => 3,
        ]);

        $response = $this->delete(route('products.destroy', $product));

        $response->assertRedirect(route('home').'#products')
            ->assertSessionHas('success', 'Product "Product To Remove" removed from your catalog.');

        $this->assertDatabaseMissing('products', [
            'id' => $product->id,
        ]);
    }

    public function test_product_show_and_edit_endpoints(): void
    {
        $product = Product::query()->create([
            'name' => 'Ceramic Mug',
            'category' => 'home',
            'price' => 499.00,
            'stock' => 20,
        ]);

        $jsonShow = $this->getJson(route('products.show', $product));
        $jsonShow->assertOk()
            ->assertJsonPath('name', 'Ceramic Mug');

        $jsonEdit = $this->getJson(route('products.edit', $product));
        $jsonEdit->assertOk()
            ->assertJsonPath('id', $product->id);

        $htmlShow = $this->get(route('products.show', $product));
        $htmlShow->assertRedirect(route('home').'#products');
    }
}
