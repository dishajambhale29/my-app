<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Unique;
use Illuminate\View\View;

class ProductController extends Controller
{
    /**
     * Display product management page with catalog stats and inventory.
     */
    public function index(): View
    {
        $products = Product::query()->latest()->get();

        $totalProducts = $products->count();
        $stockRangeMaximum = max(1, (int) $products->max('stock'));
        $activeProducts = $products->where('publication_status', 'active')->count();
        $lowStockProducts = $products->filter(fn (Product $p): bool => $p->stock > 0 && $p->stock <= $p->low_stock_threshold)->count();
        $outOfStockProducts = $products->where('stock', 0)->count();

        /** @var array<string, int> $categoryBreakdown */
        $categoryBreakdown = $products->groupBy('category')->map(fn ($group) => $group->count())->toArray();

        /** @var Collection<int, Product> $criticalStockItems */
        $criticalStockItems = $products->filter(fn (Product $p): bool => $p->stock > 0 && $p->stock <= $p->low_stock_threshold)
            ->sortBy('stock')
            ->take(5);

        $storeProducts = $products->where('publication_status', 'active')->map(fn (Product $product): array => [
            'id' => 'catalog-'.$product->id,
            'name' => $product->name,
            'subtitle' => $product->description ?: 'A thoughtful find from Ace 360°.',
            'category' => $product->category,
            'categoryLabel' => $this->categoryLabel($product->category),
            'price' => (float) $product->price,
            'oldPrice' => $product->compare_at_price ? (float) $product->compare_at_price : null,
            'stock' => $product->stock,
            'rating' => null,
            'reviews' => 0,
            'badge' => 'NEW',
            'isBestseller' => false,
            'isNew' => true,
            'image' => $product->image_url ?: 'https://images.unsplash.com/photo-1490312278390-ab64016e0aa9?auto=format&fit=crop&w=720&q=82',
            'background' => '#eaf0f8',
            'imageAlt' => $product->name,
        ])->all();

        return view('welcome', [
            'catalogStats' => [
                'total' => $totalProducts,
                'active' => $activeProducts,
                'low_stock' => $lowStockProducts,
                'out_of_stock' => $outOfStockProducts,
            ],
            'categoryBreakdown' => $categoryBreakdown,
            'criticalStockItems' => $criticalStockItems,
            'catalogProducts' => $products,
            'stockRangeMaximum' => $stockRangeMaximum,
            'storeProducts' => $storeProducts,
        ]);
    }

    /**
     * Store a newly created product in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate($this->productRules());

        Product::query()->create($validated);

        return redirect()->to(route('home').'#products')
            ->with('success', 'Product added to your catalog.');
    }

    /**
     * Display the specified product.
     */
    public function show(Request $request, Product $product): JsonResponse|RedirectResponse
    {
        if ($request->wantsJson()) {
            return response()->json($product);
        }

        return redirect()->to(route('home').'#products');
    }

    /**
     * Show the form for editing the specified product or return JSON.
     */
    public function edit(Request $request, Product $product): JsonResponse|RedirectResponse
    {
        if ($request->wantsJson()) {
            return response()->json($product);
        }

        return redirect()->to(route('home').'#products');
    }

    /**
     * Update the specified product in storage.
     */
    public function update(Request $request, Product $product): RedirectResponse
    {
        $validated = $request->validate($this->productRules($product));

        $product->update($validated);

        return redirect()->to(route('home').'#products')
            ->with('success', 'Product updated successfully.');
    }

    /**
     * Remove the specified product from storage.
     */
    public function destroy(Product $product): RedirectResponse
    {
        $name = $product->name;
        $product->delete();

        return redirect()->to(route('home').'#products')
            ->with('success', 'Product "'.$name.'" removed from your catalog.');
    }

    /**
     * Get validation rules for product attributes.
     *
     * @return array<string, array<int, Unique|string>>
     */
    private function productRules(?Product $product = null): array
    {
        return [
            'name' => ['required', 'string', 'max:150'],
            'sku' => ['required', 'string', 'max:64', 'alpha_dash', Rule::unique('products', 'sku')->ignore($product?->id)],
            'description' => ['nullable', 'string', 'max:1000'],
            'category' => ['required', 'in:audio,wearables,home,style,other'],
            'price' => ['required', 'numeric', 'gt:0', 'max:99999999.99'],
            'compare_at_price' => ['nullable', 'numeric', 'gt:price', 'max:99999999.99'],
            'stock_price' => ['required', 'numeric', 'min:0', 'max:99999999.99'],
            'stock' => ['required', 'integer', 'min:0', 'max:1000000'],
            'low_stock_threshold' => ['required', 'integer', 'min:0', 'max:1000000'],
            'publication_status' => ['required', 'in:active,draft,inactive'],
            'image_url' => ['nullable', 'url', 'max:2048'],
        ];
    }

    /**
     * Get human-readable label for product categories.
     */
    private function categoryLabel(string $category): string
    {
        return match ($category) {
            'audio' => 'Audio',
            'wearables' => 'Wearables',
            'home' => 'Home & living',
            'style' => 'Style',
            default => 'Other',
        };
    }
}
