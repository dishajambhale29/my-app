<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#f7f7f3">
    <meta name="description" content="Discover everyday essentials and thoughtful finds at Ace 360° — a better way to shop the things you love.">
    <title>Ace 360° — Good things, found here.</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div class="store-shell">
        <aside class="sidebar" id="sidebar">
            <a class="brand" href="#" aria-label="Ace 360 degrees home">
                <span class="brand-mark">A<span>+</span></span>
                <span class="brand-name">ace<span>360°degree</span></span>
            </a>

            <button class="sidebar-close icon-button" id="sidebar-close" type="button" aria-label="Close menu">
                <svg viewBox="0 0 24 24" aria-hidden="true"><path d="m6 6 12 12M18 6 6 18"/></svg>
            </button>

            <nav class="side-nav" aria-label="Main navigation">
                <a class="nav-link" href="#home" data-dashboard-link>
                    <svg viewBox="0 0 24 24" aria-hidden="true"><path d="m3 10 9-7 9 7v10a1 1 0 0 1-1 1h-5v-7H9v7H4a1 1 0 0 1-1-1z"/></svg>
                    <span>Dashboard</span>
                </a>
                <button class="nav-link nav-action is-active" type="button" data-product-management>
                    <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M3 7h18l-1.5 14h-15z"/><path d="M8 7a4 4 0 0 1 8 0M8 12h.01M16 12h.01"/></svg>
                    <span>Product management</span>
                </button>
                <button class="nav-link nav-action" type="button" data-coming-soon="Store management">
                    <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M3 10h18l-2-7H5z"/><path d="M5 10v11h14V10M9 21v-7h6v7M3 10a3 3 0 0 0 6 0 3 3 0 0 0 6 0 3 3 0 0 0 6 0"/></svg>
                    <span>Store management</span>
                </button>
                <button class="nav-link nav-action" id="orders-link" type="button">
                    <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M6 3h12l2 4H4z"/><path d="M5 7v13h14V7M9 11h6"/></svg>
                    <span>Orders</span>
                </button>
                <button class="nav-link nav-action" type="button" data-coming-soon="Venders management">
                    <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                    <span>Venders management</span>
                </button>
                <button class="nav-link nav-action" type="button" data-coming-soon="Promotions">
                    <svg viewBox="0 0 24 24" aria-hidden="true"><line x1="19" y1="5" x2="5" y2="19"/><circle cx="6.5" cy="6.5" r="2.5"/><circle cx="17.5" cy="17.5" r="2.5"/></svg>
                    <span>Promotions</span>
                </button>
                <button class="nav-link nav-action" type="button" data-coming-soon="Marketing management">
                    <svg viewBox="0 0 24 24" aria-hidden="true"><path d="m3 11 18-5v12L3 14v-3z"/><path d="M11.6 16.8a3 3 0 1 1-5.8-1.6"/></svg>
                    <span>Marketing management</span>
                </button>
                <button class="nav-link nav-action" type="button" data-coming-soon="POS">
                    <svg viewBox="0 0 24 24" aria-hidden="true"><rect x="2" y="4" width="20" height="16" rx="2"/><line x1="2" y1="10" x2="22" y2="10"/><circle cx="6" cy="15" r="1"/><circle cx="10" cy="15" r="1"/><circle cx="14" cy="15" r="1"/></svg>
                    <span>POS</span>
                </button>
            </nav>

            <div class="sidebar-bottom">
                <form class="logout-form" method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="logout-button is-red" type="submit">
                        <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M10 17l5-5-5-5m5 5H3"/><path d="M12 3h6a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-6"/></svg>
                        <span>Log out</span>
                    </button>
                </form>
            </div>
        </aside>

        <div class="page-content" id="home">
            <header class="topbar">
                <button class="menu-toggle icon-button" id="menu-toggle" type="button" aria-label="Open menu">
                    <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
                <div class="mobile-brand">ace<span>360°</span></div>
                <form class="search-form" id="search-form" role="search">
                    <svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="11" cy="11" r="7"/><path d="m20 20-4-4"/></svg>
                    <input id="product-search" type="search" placeholder="Search products..." autocomplete="off" aria-label="Search products">
                    <kbd>⌘ K</kbd>
                </form>
                <div class="topbar-actions">
                    <button class="icon-button notification-button" type="button" aria-label="Notifications">
                        <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M18 8a6 6 0 0 0-12 0c0 7-3 7-3 9h18c0-2-3-2-3-9m-8 12h4"/></svg>
                        <span class="notification-dot"></span>
                    </button>
                    <span class="topbar-divider"></span>
                    <button class="profile-button" id="profile-button" type="button">
                        <span class="profile-avatar">A</span>
                        <span class="profile-copy"><strong>Welcome!</strong><small>Guest shopper</small></span>
                        <svg class="profile-chevron" viewBox="0 0 24 24" aria-hidden="true"><path d="m7 10 5 5 5-5"/></svg>
                    </button>
                    <button class="cart-button" id="cart-open" type="button" aria-label="Open shopping bag">
                        <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M5 8h14l1 13H4L5 8Z"/><path d="M9 9V6a3 3 0 0 1 6 0v3"/></svg>
                        <span>Bag</span>
                        <span class="cart-count" id="cart-count">0</span>
                    </button>
                </div>
            </header>

            <main class="main-content">
                <section class="pm-page" id="dashboard">
                    @if (session('success'))
                        <div class="dashboard-flash" role="status">{{ session('success') }}</div>
                    @endif

                    {{-- Four stat cards --}}
                    <div class="pm-stats-grid">
                        <article class="pm-stat-card">
                            <div class="pm-stat-icon pm-stat-icon--blue">
                                <svg viewBox="0 0 24 24" aria-hidden="true" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>
                            </div>
                            <div class="pm-stat-body">
                                <span class="pm-stat-label">Total Products</span>
                                <strong class="pm-stat-value">{{ number_format($catalogStats['total']) }}</strong>
                                <small class="pm-stat-sub">Across all categories</small>
                            </div>
                        </article>

                        <article class="pm-stat-card">
                            <div class="pm-stat-icon pm-stat-icon--green">
                                <svg viewBox="0 0 24 24" aria-hidden="true" fill="none" stroke="currentColor" stroke-width="2"><path d="m5 12 4 4L19 6"/></svg>
                            </div>
                            <div class="pm-stat-body">
                                <span class="pm-stat-label">Active Products</span>
                                <strong class="pm-stat-value">{{ number_format($catalogStats['active']) }}</strong>
                                <small class="pm-stat-sub">In stock &amp; available</small>
                            </div>
                        </article>

                        <article class="pm-stat-card pm-stat-card--alert">
                            <div class="pm-stat-icon pm-stat-icon--red">
                                <svg viewBox="0 0 24 24" aria-hidden="true" fill="none" stroke="currentColor" stroke-width="2"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                            </div>
                            <div class="pm-stat-body">
                                <span class="pm-stat-label pm-stat-label--red">Low Stock Alert</span>
                                <strong class="pm-stat-value pm-stat-value--red">{{ number_format($catalogStats['low_stock']) }}</strong>
                                <small class="pm-stat-sub">Items with 1–5 units left</small>
                            </div>
                        </article>

                        <article class="pm-stat-card pm-stat-card--danger">
                            <div class="pm-stat-icon pm-stat-icon--darkred">
                                <svg viewBox="0 0 24 24" aria-hidden="true" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                            </div>
                            <div class="pm-stat-body">
                                <span class="pm-stat-label pm-stat-label--darkred">Out of Stock</span>
                                <strong class="pm-stat-value pm-stat-value--darkred">{{ number_format($catalogStats['out_of_stock']) }}</strong>
                                <small class="pm-stat-sub">Products unavailable</small>
                            </div>
                        </article>
                    </div>

                    {{-- Three insight panels (moved below product inventory) --}}
                </section>

                <section class="products-section" id="products" aria-labelledby="products-title">
                    <div class="section-heading">
                        <div>
                            <p class="eyebrow"><span class="eyebrow-line"></span> CATALOG</p>
                            <h2 id="products-title">Product inventory</h2>
                            <p class="table-description">Manage your catalog, pricing, and stock from one place.</p>
                        </div>
                    </div>
                    <div class="table-toolbar">
                        <div class="table-controls">
                            <div class="table-search-box">
                                <svg viewBox="0 0 24 24" aria-hidden="true" width="15" height="15"><circle cx="11" cy="11" r="7"/><path d="m20 20-4-4"/></svg>
                                <input id="inventory-search" type="search" placeholder="Search inventory..." autocomplete="off" aria-label="Search products in inventory">
                            </div>
                            <div class="table-select-wrapper">
                                <select id="inventory-category-select" class="table-select" aria-label="Filter by category">
                                    <option value="all">All categories</option>
                                    <option value="audio">Audio</option>
                                    <option value="wearables">Wearables</option>
                                    <option value="home">Home & living</option>
                                    <option value="style">Style</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>
                            <div class="table-select-wrapper">
                                <select id="inventory-sort-select" class="table-select" aria-label="Sort products">
                                    <option value="latest" selected>Sort by: Latest</option>
                                    <option value="oldest">Sort by: Oldest</option>
                                    <option value="price-asc">Sort by: Price (Low to High)</option>
                                    <option value="price-desc">Sort by: Price (High to Low)</option>
                                    <option value="name-asc">Sort by: Name (A to Z)</option>
                                    <option value="stock-desc">Sort by: Stock (High to Low)</option>
                                </select>
                            </div>
                            <button class="add-product-button add-product-button--inline" id="product-add-open" type="button">
                                <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 5v14M5 12h14"/></svg>
                                Add new product
                            </button>
                        </div>
                        <span class="table-result-count" id="table-result-count">{{ $catalogStats['total'] }} products</span>
                    </div>
                    <div class="product-table-wrap">
                        <table class="product-table">
                            <thead>
                                <tr>
                                    <th scope="col">Product</th>
                                    <th scope="col">Category</th>
                                    <th scope="col">Price</th>
                                    <th scope="col">Stock</th>
                                    <th scope="col">Status</th>
                                    <th scope="col"><span class="visually-hidden">Actions</span></th>
                                </tr>
                            </thead>
                            <tbody id="product-table-body">
                                @forelse ($catalogProducts as $product)
                                    <tr data-product-row
                                        data-id="{{ $product->id }}"
                                        data-category="{{ $product->category }}"
                                        data-name="{{ strtolower($product->name) }}"
                                        data-price="{{ (float) $product->price }}"
                                        data-stock="{{ (int) $product->stock }}"
                                        data-created="{{ $product->created_at->timestamp }}">
                                        <td>
                                            <div class="table-product">
                                                @if ($product->image_url)
                                                    <img class="table-product-image" src="{{ $product->image_url }}" alt="" loading="lazy">
                                                @else
                                                    <span class="table-product-placeholder">{{ mb_substr($product->name, 0, 1) }}</span>
                                                @endif
                                                <span class="table-product-copy">
                                                    <strong>{{ $product->name }}</strong>
                                                    <small>{{ $product->sku }} · Added {{ $product->created_at->format('M j, Y') }}</small>
                                                </span>
                                            </div>
                                        </td>
                                        <td><span class="table-category">{{ match ($product->category) { 'audio' => 'Audio', 'wearables' => 'Wearables', 'home' => 'Home & living', 'style' => 'Style', default => 'Other' } }}</span></td>
                                        <td>
                                            <span class="table-price">₹{{ number_format((float) $product->price, 2) }}</span>
                                            @if ($product->compare_at_price)
                                                <small class="table-old-price">₹{{ number_format((float) $product->compare_at_price, 2) }}</small>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="table-stock-level {{ $product->stock === 0 ? 'is-out' : ($product->stock <= $product->low_stock_threshold ? 'is-low' : 'is-healthy') }}">
                                                <div class="table-stock-quantity">
                                                    <span class="table-stock">{{ number_format($product->stock) }}</span>
                                                    <small>of {{ number_format($stockRangeMaximum) }} max</small>
                                                </div>
                                                <div class="table-stock-track"
                                                     role="meter"
                                                     aria-label="Stock level in inventory range"
                                                     aria-valuemin="0"
                                                     aria-valuemax="{{ $stockRangeMaximum }}"
                                                     aria-valuenow="{{ $product->stock }}">
                                                    <span style="--stock-level: {{ round(($product->stock / $stockRangeMaximum) * 100, 1) }}%"></span>
                                                </div>
                                                @if ($product->stock === 0)
                                                    <small class="table-low-stock">Out of stock</small>
                                                @elseif ($product->stock <= $product->low_stock_threshold)
                                                    <small class="table-low-stock">Low stock</small>
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            <span class="publication-status publication-status--{{ $product->publication_status }}">
                                                {{ ucfirst($product->publication_status) }}
                                            </span>
                                        </td>
                                        <td class="table-actions">
                                            <div class="table-actions-group">
                                                <button class="table-action-button table-edit-btn"
                                                        type="button"
                                                        data-product-edit
                                                        data-id="{{ $product->id }}"
                                                        data-name="{{ $product->name }}"
                                                        data-sku="{{ $product->sku }}"
                                                        data-category="{{ $product->category }}"
                                                        data-price="{{ $product->price }}"
                                                        data-compare-at-price="{{ $product->compare_at_price }}"
                                                        data-stock-price="{{ $product->stock_price }}"
                                                        data-stock="{{ $product->stock }}"
                                                        data-low-stock-threshold="{{ $product->low_stock_threshold }}"
                                                        data-publication-status="{{ $product->publication_status }}"
                                                        data-image-url="{{ $product->image_url }}"
                                                        data-description="{{ $product->description }}"
                                                        title="Edit {{ $product->name }}">
                                                    <svg viewBox="0 0 24 24" aria-hidden="true" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                                    <span>Edit</span>
                                                </button>
                                                <button class="table-action-button table-delete-btn"
                                                        type="button"
                                                        data-product-delete
                                                        data-delete-url="{{ route('products.destroy', $product) }}"
                                                        data-name="{{ $product->name }}"
                                                        data-price="{{ $product->price }}"
                                                        data-category="{{ $product->category }}"
                                                        data-image-url="{{ $product->image_url }}"
                                                        title="Delete {{ $product->name }}">
                                                    <svg viewBox="0 0 24 24" aria-hidden="true" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/><line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/></svg>
                                                    <span>Delete</span>
                                                </button>
                                                <button class="table-add-to-bag" type="button" data-add-to-cart="catalog-{{ $product->id }}" @disabled($product->stock === 0 || $product->publication_status !== 'active')>
                                                    {{ $product->stock === 0 ? 'Unavailable' : ($product->publication_status !== 'active' ? 'Not active' : 'Add to bag') }}
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr class="table-empty-row" id="table-empty-row">
                                        <td colspan="6">
                                            <strong>Your catalog is empty</strong>
                                            <span>Add your first product to see it listed here.</span>
                                            <button type="button" data-product-add>Add your first product</button>
                                        </td>
                                    </tr>
                                @endforelse
                                <tr class="table-empty-row" id="table-filter-empty" hidden>
                                    <td colspan="6">
                                        <strong>No products found</strong>
                                        <span>Try a different search or category.</span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </section>

                {{-- Three insight panels --}}
                <div class="pm-panels-grid">
                    {{-- Critical Stock Replenishment --}}
                    <section class="pm-panel" aria-labelledby="csr-title">
                        <div class="pm-panel-header">
                            <div class="pm-panel-title-row">
                                <span class="pm-panel-icon pm-panel-icon--red">
                                    <svg viewBox="0 0 24 24" aria-hidden="true" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2 7m12-7l2 7M9 21h6"/></svg>
                                </span>
                                <h2 id="csr-title">Critical Stock Replenishment</h2>
                            </div>
                            <p class="pm-panel-desc">Products needing urgent restock</p>
                        </div>
                        <div class="pm-panel-body">
                            @forelse ($criticalStockItems as $item)
                                <div class="pm-csr-row">
                                    <span class="pm-csr-name">{{ $item->name }}</span>
                                    <span class="pm-csr-badge {{ $item->stock <= 2 ? 'pm-csr-badge--critical' : 'pm-csr-badge--low' }}">
                                        {{ $item->stock }} left
                                    </span>
                                </div>
                            @empty
                                <div class="pm-panel-empty">
                                    <svg viewBox="0 0 24 24" aria-hidden="true" fill="none" stroke="currentColor" stroke-width="2"><path d="m5 12 4 4L19 6"/></svg>
                                    <span>All products are well stocked</span>
                                </div>
                            @endforelse
                        </div>
                    </section>

                    {{-- Catalog SKU Breakdown --}}
                    <section class="pm-panel" aria-labelledby="sku-title">
                        <div class="pm-panel-header">
                            <div class="pm-panel-title-row">
                                <span class="pm-panel-icon pm-panel-icon--blue">
                                    <svg viewBox="0 0 24 24" aria-hidden="true" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                                </span>
                                <h2 id="sku-title">Catalog SKU Breakdown</h2>
                            </div>
                            <p class="pm-panel-desc">Products per category</p>
                        </div>
                        <div class="pm-panel-body">
                            @php
                                $catLabels = ['audio' => 'Audio', 'wearables' => 'Wearables', 'home' => 'Home & Living', 'style' => 'Style', 'other' => 'Other'];
                                $catColors = ['audio' => '#3b82f6', 'wearables' => '#8b5cf6', 'home' => '#10b981', 'style' => '#f59e0b', 'other' => '#6b7280'];
                                $total = max(1, array_sum($categoryBreakdown));
                            @endphp
                            @forelse ($catLabels as $key => $label)
                                @php $count = $categoryBreakdown[$key] ?? 0; $pct = round($count / $total * 100); @endphp
                                <div class="pm-sku-row">
                                    <span class="pm-sku-dot" style="background: {{ $catColors[$key] }}"></span>
                                    <span class="pm-sku-label">{{ $label }}</span>
                                    <div class="pm-sku-bar-wrap">
                                        <div class="pm-sku-bar" style="width: {{ $pct }}%; background: {{ $catColors[$key] }}"></div>
                                    </div>
                                    <span class="pm-sku-count">{{ $count }}</span>
                                </div>
                            @empty
                                <div class="pm-panel-empty">No products yet</div>
                            @endforelse
                        </div>
                    </section>

                    {{-- Store Channel Sync --}}
                    <section class="pm-panel" aria-labelledby="scs-title">
                        <div class="pm-panel-header">
                            <div class="pm-panel-title-row">
                                <span class="pm-panel-icon pm-panel-icon--violet">
                                    <svg viewBox="0 0 24 24" aria-hidden="true" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2L2 7l10 5 10-5-10-5z"/><path d="M2 17l10 5 10-5"/><path d="M2 12l10 5 10-5"/></svg>
                                </span>
                                <h2 id="scs-title">Store Channel Sync</h2>
                            </div>
                            <p class="pm-panel-desc">Connected storefront channels</p>
                        </div>
                        <div class="pm-panel-body">
                            <div class="pm-channel-row">
                                <span class="pm-channel-icon">🌐</span>
                                <div class="pm-channel-info">
                                    <strong>Web Store</strong>
                                    <small>{{ number_format($catalogStats['active']) }} products synced</small>
                                </div>
                                <span class="pm-channel-status pm-channel-status--live">Live</span>
                            </div>
                            <div class="pm-channel-row">
                                <span class="pm-channel-icon">📱</span>
                                <div class="pm-channel-info">
                                    <strong>Mobile App</strong>
                                    <small>{{ number_format($catalogStats['total']) }} products indexed</small>
                                </div>
                                <span class="pm-channel-status pm-channel-status--live">Live</span>
                            </div>
                            <div class="pm-channel-row">
                                <span class="pm-channel-icon">🏪</span>
                                <div class="pm-channel-info">
                                    <strong>POS Terminal</strong>
                                    <small>Sync pending</small>
                                </div>
                                <span class="pm-channel-status pm-channel-status--pending">Pending</span>
                            </div>
                            <div class="pm-channel-row">
                                <span class="pm-channel-icon">🛒</span>
                                <div class="pm-channel-info">
                                    <strong>Marketplace</strong>
                                    <small>Not connected</small>
                                </div>
                                <span class="pm-channel-status pm-channel-status--offline">Offline</span>
                            </div>
                        </div>
                    </section>
                </div>

                <footer class="page-footer">
                    <span>Ace 360° store dashboard</span>
                    <span>© 2025 Ace 360°</span>
                </footer>
            </main>
        </div>
    </div>

    <div class="sidebar-scrim" id="sidebar-scrim"></div>
    <div class="toast" id="toast" role="status" aria-live="polite"></div>
    <div id="flash-message" data-message="{{ session('success') }}" hidden></div>

    <dialog class="product-dialog" id="product-dialog" @if ($errors->any()) data-reopen="true" @endif>
        <form class="product-form" method="POST" action="{{ route('products.store') }}">
            @csrf
            <div class="product-dialog-heading">
                <div>
                    <p class="eyebrow"><span class="eyebrow-line"></span> CATALOG</p>
                    <h2>Add new product</h2>
                    <p>Add an item to your catalog and storefront.</p>
                </div>
                <button class="icon-button" id="product-dialog-close" type="button" aria-label="Close form">
                    <svg viewBox="0 0 24 24" aria-hidden="true"><path d="m6 6 12 12M18 6 6 18"/></svg>
                </button>
            </div>
            @if ($errors->any())
                <div class="form-errors" role="alert">Please review the highlighted fields and try again.</div>
            @endif
            <label class="form-field form-field-wide">
                <span>Product name</span>
                <input type="text" name="name" value="{{ old('name') }}" maxlength="150" required placeholder="e.g. Studio wireless headphones">
                @error('name') <small class="field-error">{{ $message }}</small> @enderror
            </label>
            <div class="form-row">
                <label class="form-field">
                    <span>SKU (Stock Keeping Unit)</span>
                    <span class="sku-input-row">
                        <input id="product-sku" type="text" name="sku" value="{{ old('sku') }}" maxlength="64" required placeholder="Generate or enter SKU">
                        <button class="sku-generate-button" type="button" data-generate-sku="#product-sku">Generate</button>
                    </span>
                    @error('sku') <small class="field-error">{{ $message }}</small> @enderror
                </label>
                <label class="form-field">
                    <span>Category</span>
                    <select name="category" required>
                        <option value="">Choose category</option>
                        <option value="audio" @selected(old('category') === 'audio')>Audio</option>
                        <option value="wearables" @selected(old('category') === 'wearables')>Wearables</option>
                        <option value="home" @selected(old('category') === 'home')>Home & living</option>
                        <option value="style" @selected(old('category') === 'style')>Style</option>
                        <option value="other" @selected(old('category') === 'other')>Other</option>
                    </select>
                    @error('category') <small class="field-error">{{ $message }}</small> @enderror
                </label>
            </div>
            <div class="form-row">
                <label class="form-field">
                    <span>Regular price (₹)</span>
                    <input type="number" name="price" value="{{ old('price') }}" min="0.01" step="0.01" required placeholder="0.00">
                    @error('price') <small class="field-error">{{ $message }}</small> @enderror
                </label>
                <label class="form-field">
                    <span>Stock price (₹)</span>
                    <input type="number" name="stock_price" value="{{ old('stock_price', 0) }}" min="0" step="0.01" required placeholder="0.00">
                    @error('stock_price') <small class="field-error">{{ $message }}</small> @enderror
                </label>
            </div>
            <div class="form-row">
                <label class="form-field">
                    <span>Stock quantity</span>
                    <input type="number" name="stock" value="{{ old('stock', 0) }}" min="0" step="1" required placeholder="0">
                    @error('stock') <small class="field-error">{{ $message }}</small> @enderror
                </label>
                <label class="form-field">
                    <span>Low stock threshold</span>
                    <input type="number" name="low_stock_threshold" value="{{ old('low_stock_threshold', 5) }}" min="0" step="1" required placeholder="5">
                    @error('low_stock_threshold') <small class="field-error">{{ $message }}</small> @enderror
                </label>
            </div>
            <label class="form-field form-field-wide">
                <span>Publication status</span>
                <select name="publication_status" required>
                    <option value="active" @selected(old('publication_status', 'active') === 'active')>Active</option>
                    <option value="draft" @selected(old('publication_status') === 'draft')>Draft</option>
                    <option value="inactive" @selected(old('publication_status') === 'inactive')>Inactive</option>
                </select>
                @error('publication_status') <small class="field-error">{{ $message }}</small> @enderror
            </label>
            <label class="form-field form-field-wide">
                <span>Compare-at price (₹) <small>Optional</small></span>
                <input type="number" name="compare_at_price" value="{{ old('compare_at_price') }}" min="0.01" step="0.01" placeholder="0.00">
                @error('compare_at_price') <small class="field-error">{{ $message }}</small> @enderror
            </label>
            <label class="form-field form-field-wide">
                <span>Image URL <small>Optional</small></span>
                <input type="url" name="image_url" value="{{ old('image_url') }}" maxlength="2048" placeholder="https://example.com/product-image.jpg">
                @error('image_url') <small class="field-error">{{ $message }}</small> @enderror
            </label>
            <label class="form-field form-field-wide">
                <span>Short summary <small>Optional</small></span>
                <textarea name="description" rows="3" maxlength="1000" placeholder="A short summary for shoppers">{{ old('description') }}</textarea>
                @error('description') <small class="field-error">{{ $message }}</small> @enderror
            </label>
            <div class="product-form-actions">
                <button class="form-cancel" id="product-form-cancel" type="button">Cancel</button>
                <button class="add-product-button" type="submit">Save product</button>
            </div>
        </form>
    </dialog>

    <dialog class="product-dialog" id="product-edit-dialog">
        <form class="product-form" id="product-edit-form" method="POST" action="">
            @csrf
            @method('PUT')
            <div class="product-dialog-heading">
                <div>
                    <p class="eyebrow"><span class="eyebrow-line"></span> CATALOG</p>
                    <h2>Edit product</h2>
                    <p>Update product pricing, stock, or details.</p>
                </div>
                <button class="icon-button" id="product-edit-dialog-close" type="button" aria-label="Close edit form">
                    <svg viewBox="0 0 24 24" aria-hidden="true"><path d="m6 6 12 12M18 6 6 18"/></svg>
                </button>
            </div>
            <label class="form-field form-field-wide">
                <span>Product name</span>
                <input type="text" id="edit-product-name" name="name" maxlength="150" required placeholder="e.g. Studio wireless headphones">
            </label>
            <div class="form-row">
                <label class="form-field">
                    <span>SKU (Stock Keeping Unit)</span>
                    <span class="sku-input-row">
                        <input id="edit-product-sku" type="text" name="sku" maxlength="64" required>
                        <button class="sku-generate-button" type="button" data-generate-sku="#edit-product-sku">Generate</button>
                    </span>
                </label>
                <label class="form-field">
                    <span>Category</span>
                    <select id="edit-product-category" name="category" required>
                        <option value="">Choose category</option>
                        <option value="audio">Audio</option>
                        <option value="wearables">Wearables</option>
                        <option value="home">Home & living</option>
                        <option value="style">Style</option>
                        <option value="other">Other</option>
                    </select>
                </label>
            </div>
            <div class="form-row">
                <label class="form-field">
                    <span>Regular price (₹)</span>
                    <input type="number" id="edit-product-price" name="price" min="0.01" step="0.01" required placeholder="0.00">
                </label>
                <label class="form-field">
                    <span>Stock price (₹)</span>
                    <input type="number" id="edit-product-stock-price" name="stock_price" min="0" step="0.01" required placeholder="0.00">
                </label>
            </div>
            <div class="form-row">
                <label class="form-field">
                    <span>Stock quantity</span>
                    <input type="number" id="edit-product-stock" name="stock" min="0" step="1" required placeholder="0">
                </label>
                <label class="form-field">
                    <span>Low stock threshold</span>
                    <input type="number" id="edit-product-low-stock-threshold" name="low_stock_threshold" min="0" step="1" required placeholder="5">
                </label>
            </div>
            <label class="form-field form-field-wide">
                <span>Publication status</span>
                <select id="edit-product-publication-status" name="publication_status" required>
                    <option value="active">Active</option>
                    <option value="draft">Draft</option>
                    <option value="inactive">Inactive</option>
                </select>
            </label>
            <label class="form-field form-field-wide">
                <span>Compare-at price (₹) <small>Optional</small></span>
                <input type="number" id="edit-product-compare-at-price" name="compare_at_price" min="0.01" step="0.01" placeholder="0.00">
            </label>
            <label class="form-field form-field-wide">
                <span>Image URL <small>Optional</small></span>
                <input type="url" id="edit-product-image-url" name="image_url" maxlength="2048" placeholder="https://example.com/product-image.jpg">
            </label>
            <label class="form-field form-field-wide">
                <span>Short summary <small>Optional</small></span>
                <textarea id="edit-product-description" name="description" rows="3" maxlength="1000" placeholder="A short summary for shoppers"></textarea>
            </label>
            <div class="product-form-actions">
                <button class="form-cancel" id="product-edit-form-cancel" type="button">Cancel</button>
                <button class="add-product-button" type="submit">Update product</button>
            </div>
        </form>
    </dialog>

    <dialog class="delete-confirmation-dialog" id="product-delete-dialog" aria-labelledby="delete-dialog-title" aria-describedby="delete-dialog-description">
        <div class="delete-dialog-content">
            <div class="delete-dialog-icon" aria-hidden="true">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                    <path d="M4 7h16M10 11v6m4-6v6M5 7l1 14h12l1-14M9 7V4h6v3"/>
                </svg>
            </div>
            <p class="delete-dialog-eyebrow">Destructive action</p>
            <h2 id="delete-dialog-title">Delete product?</h2>
            <p class="delete-dialog-description" id="delete-dialog-description">This action cannot be undone. The product will be permanently removed from your catalog.</p>

            <div class="delete-product-preview">
                <div class="delete-product-image-wrap">
                    <img id="delete-product-image" alt="" hidden>
                    <div class="delete-product-image-placeholder" id="delete-product-image-placeholder" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <path d="M4 7.5 12 3l8 4.5v9L12 21l-8-4.5z"/>
                            <path d="m4.5 7.8 7.5 4.3 7.5-4.3M12 12v8.5"/>
                        </svg>
                    </div>
                </div>
                <div class="delete-product-details">
                    <strong id="delete-product-name"></strong>
                    <span class="delete-product-price" id="delete-product-price"></span>
                    <span class="delete-product-category" id="delete-product-category"></span>
                </div>
            </div>

            <form id="product-delete-form" method="POST" action="">
                @csrf
                @method('DELETE')
                <div class="delete-dialog-actions">
                    <button class="delete-dialog-cancel" id="delete-dialog-cancel" type="button">Cancel</button>
                    <button class="delete-dialog-confirm" type="submit">Yes, Delete Product</button>
                </div>
            </form>
        </div>
    </dialog>

    <div class="cart-scrim" id="cart-scrim"></div>
    <aside class="cart-drawer" id="cart-drawer" aria-label="Shopping bag" aria-hidden="true">
        <div class="drawer-header">
            <div><p class="eyebrow"><span class="eyebrow-line"></span> YOUR PICKS</p><h2>Your bag <span id="drawer-item-count">(0)</span></h2></div>
            <button class="icon-button" id="cart-close" type="button" aria-label="Close shopping bag">
                <svg viewBox="0 0 24 24" aria-hidden="true"><path d="m6 6 12 12M18 6 6 18"/></svg>
            </button>
        </div>
        <div class="cart-items" id="cart-items"></div>
        <div class="cart-empty" id="cart-empty">
            <span class="empty-bag-icon">♡</span>
            <strong>Your bag is taking a little break.</strong>
            <p>Pop in something you love and it’ll be waiting here.</p>
            <button class="hero-cta" id="continue-shopping" type="button">Find something lovely <span aria-hidden="true">↗</span></button>
        </div>
        <div class="cart-summary" id="cart-summary" hidden>
            <div class="summary-row"><span>Subtotal</span><strong id="cart-subtotal">₹0</strong></div>
            <p>Shipping and taxes calculated at checkout.</p>
            <button class="checkout-button" id="checkout-button" type="button">Continue to checkout <span aria-hidden="true">→</span></button>
            <div class="secure-note"><svg viewBox="0 0 24 24" aria-hidden="true"><rect x="4" y="10" width="16" height="11" rx="2"/><path d="M8 10V7a4 4 0 0 1 8 0v3"/></svg> Secure checkout, always.</div>
        </div>
    </aside>
    <script>
        window.aceStoreProducts = {{ Illuminate\Support\Js::from($storeProducts) }};
    </script>
</body>
</html>
