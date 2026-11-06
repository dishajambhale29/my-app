const products = window.aceStoreProducts || [];
const productRows = [...document.querySelectorAll('[data-product-row]')];
const tableBody = document.querySelector('#product-table-body');
const searchInput = document.querySelector('#product-search');
const inventorySearchInput = document.querySelector('#inventory-search');
const categorySelect = document.querySelector('#inventory-category-select');
const sortSelect = document.querySelector('#inventory-sort-select');
const resultCount = document.querySelector('#table-result-count');
const filterEmptyRow = document.querySelector('#table-filter-empty');
const cartCount = document.querySelector('#cart-count');
const cartItems = document.querySelector('#cart-items');
const cartEmpty = document.querySelector('#cart-empty');
const cartSummary = document.querySelector('#cart-summary');
const drawerItemCount = document.querySelector('#drawer-item-count');
const cartSubtotal = document.querySelector('#cart-subtotal');
const cartDrawer = document.querySelector('#cart-drawer');
const cartScrim = document.querySelector('#cart-scrim');
const toast = document.querySelector('#toast');
const productDialog = document.querySelector('#product-dialog');
const productEditDialog = document.querySelector('#product-edit-dialog');
const productEditForm = document.querySelector('#product-edit-form');
const productDeleteDialog = document.querySelector('#product-delete-dialog');
const productDeleteForm = document.querySelector('#product-delete-form');
const cart = new Map();
let activeCategory = 'all';
let toastTimeout;

const formatPrice = (price) => `₹${price.toLocaleString('en-IN', {
    minimumFractionDigits: 2,
    maximumFractionDigits: 2,
})}`;

function escapeHtml(value) {
    return String(value).replace(/[&<>"']/g, (character) => ({
        '&': '&amp;',
        '<': '&lt;',
        '>': '&gt;',
        '"': '&quot;',
        "'": '&#039;',
    })[character]);
}

function showToast(message) {
    window.clearTimeout(toastTimeout);
    toast.textContent = message;
    toast.classList.add('is-visible');
    toastTimeout = window.setTimeout(() => toast.classList.remove('is-visible'), 2600);
}

function sortRows(rows, sortBy) {
    return [...rows].sort((a, b) => {
        if (sortBy === 'latest') {
            const timeA = Number(a.dataset.created || a.dataset.id || 0);
            const timeB = Number(b.dataset.created || b.dataset.id || 0);
            return timeB - timeA;
        }
        if (sortBy === 'oldest') {
            const timeA = Number(a.dataset.created || a.dataset.id || 0);
            const timeB = Number(b.dataset.created || b.dataset.id || 0);
            return timeA - timeB;
        }
        if (sortBy === 'price-asc') {
            return Number(a.dataset.price || 0) - Number(b.dataset.price || 0);
        }
        if (sortBy === 'price-desc') {
            return Number(b.dataset.price || 0) - Number(a.dataset.price || 0);
        }
        if (sortBy === 'name-asc') {
            return (a.dataset.name || '').localeCompare(b.dataset.name || '');
        }
        if (sortBy === 'stock-desc') {
            return Number(b.dataset.stock || 0) - Number(a.dataset.stock || 0);
        }
        return 0;
    });
}

function updateProductTable() {
    const invSearchVal = inventorySearchInput ? inventorySearchInput.value.trim().toLowerCase() : '';
    const topSearchVal = searchInput ? searchInput.value.trim().toLowerCase() : '';
    const searchTerm = invSearchVal || topSearchVal;

    const sortBy = sortSelect ? sortSelect.value : 'latest';
    const sortedRows = sortRows(productRows, sortBy);

    if (tableBody) {
        sortedRows.forEach((row) => {
            if (filterEmptyRow) {
                tableBody.insertBefore(row, filterEmptyRow);
            } else {
                tableBody.appendChild(row);
            }
        });
    }

    let visibleCount = 0;

    sortedRows.forEach((row) => {
        const matchesCategory = activeCategory === 'all' || row.dataset.category === activeCategory;
        const matchesSearch = row.textContent.toLowerCase().includes(searchTerm);
        const isVisible = matchesCategory && matchesSearch;

        row.hidden = !isVisible;
        visibleCount += Number(isVisible);
    });

    if (resultCount) {
        resultCount.textContent = `Showing ${visibleCount} of ${productRows.length} products`;
    }
    if (filterEmptyRow) {
        filterEmptyRow.hidden = visibleCount > 0 || productRows.length === 0;
    }
}

function updateCartView() {
    const items = [...cart.entries()]
        .map(([id, quantity]) => ({ product: products.find((product) => product.id === id), quantity }))
        .filter((item) => item.product);
    const itemCount = items.reduce((total, item) => total + item.quantity, 0);
    const subtotal = items.reduce((total, item) => total + item.product.price * item.quantity, 0);

    cartCount.textContent = String(itemCount);
    drawerItemCount.textContent = `(${itemCount})`;
    cartEmpty.hidden = itemCount > 0;
    cartSummary.hidden = itemCount === 0;
    cartItems.hidden = itemCount === 0;
    cartSubtotal.textContent = formatPrice(subtotal);
    cartItems.innerHTML = items.map(({ product, quantity }) => `
        <div class="cart-line">
            <img src="${escapeHtml(product.image)}" alt="" style="--product-bg:${escapeHtml(product.background)}">
            <div class="cart-line-main">
                <strong>${escapeHtml(product.name)}</strong>
                <small>${formatPrice(product.price)} each</small>
                <div class="quantity-control" aria-label="Quantity for ${escapeHtml(product.name)}">
                    <button type="button" data-cart-action="decrease" data-cart-id="${escapeHtml(product.id)}" aria-label="Remove one ${escapeHtml(product.name)}">−</button>
                    <span>${quantity}</span>
                    <button type="button" data-cart-action="increase" data-cart-id="${escapeHtml(product.id)}" aria-label="Add one ${escapeHtml(product.name)}">+</button>
                </div>
            </div>
            <span class="cart-line-price">${formatPrice(product.price * quantity)}</span>
        </div>`).join('');
}

function addToCart(productId) {
    const product = products.find((item) => String(item.id) === String(productId));
    if (!product) {
        showToast('This product is not available to add to your bag.');
        return;
    }

    if (product.stock <= 0) {
        showToast('This product is out of stock.');
        return;
    }

    const quantity = cart.get(product.id) || 0;
    if (quantity >= product.stock) {
        showToast('There is no more stock available for this product.');
        return;
    }

    cart.set(product.id, quantity + 1);
    updateCartView();
    showToast(`${product.name} added to your bag.`);
    openCart();
}

function openCart() {
    cartDrawer.classList.add('is-open');
    cartScrim.classList.add('is-open');
    cartDrawer.setAttribute('aria-hidden', 'false');
    document.body.classList.add('has-open-drawer');
    document.querySelector('#cart-close').focus();
}

function closeCart() {
    cartDrawer.classList.remove('is-open');
    cartScrim.classList.remove('is-open');
    cartDrawer.setAttribute('aria-hidden', 'true');
    document.body.classList.remove('has-open-drawer');
    document.querySelector('#cart-open').focus();
}

if (inventorySearchInput) {
    inventorySearchInput.addEventListener('input', () => {
        if (searchInput) {
            searchInput.value = inventorySearchInput.value;
        }
        updateProductTable();
    });
}

if (categorySelect) {
    categorySelect.addEventListener('change', () => {
        activeCategory = categorySelect.value;
        updateProductTable();
    });
}

if (sortSelect) {
    sortSelect.addEventListener('change', () => {
        updateProductTable();
    });
}

document.querySelectorAll('[data-category-link]').forEach((link) => {
    link.addEventListener('click', () => {
        activeCategory = link.dataset.categoryLink;
        if (categorySelect) {
            categorySelect.value = activeCategory;
        }
        updateProductTable();
        document.querySelectorAll('.nav-link').forEach((navLink) => navLink.classList.remove('is-active'));
        link.classList.add('is-active');
        closeSidebar();
    });
});

document.querySelectorAll('[data-product-management]').forEach((link) => {
    link.addEventListener('click', () => {
        document.querySelectorAll('.nav-link').forEach((navLink) => navLink.classList.remove('is-active'));
        link.classList.add('is-active');
        document.querySelector('#products').scrollIntoView({ behavior: 'smooth' });
        closeSidebar();
    });
});

if (tableBody) {
    tableBody.addEventListener('click', (event) => {
        if (!(event.target instanceof Element)) {
            return;
        }

        const button = event.target.closest('[data-add-to-cart]');
        if (button instanceof HTMLButtonElement && !button.disabled) {
            addToCart(button.dataset.addToCart);
        }
    });
}

if (searchInput) {
    searchInput.addEventListener('input', () => {
        if (inventorySearchInput) {
            inventorySearchInput.value = searchInput.value;
        }
        updateProductTable();
    });
}

const searchForm = document.querySelector('#search-form');
if (searchForm) {
    searchForm.addEventListener('submit', (event) => {
        event.preventDefault();
        document.querySelector('#products').scrollIntoView({ behavior: 'smooth' });
    });
}

function openProductDialog() {
    productDialog.showModal();
}

function openProductEditDialog(button) {
    if (!productEditDialog || !productEditForm) {
        return;
    }

    const productId = button.dataset.id;
    productEditForm.action = `/products/${productId}`;

    const nameInput = document.querySelector('#edit-product-name');
    const skuInput = document.querySelector('#edit-product-sku');
    const categoryInput = document.querySelector('#edit-product-category');
    const priceInput = document.querySelector('#edit-product-price');
    const compareAtPriceInput = document.querySelector('#edit-product-compare-at-price');
    const stockPriceInput = document.querySelector('#edit-product-stock-price');
    const stockInput = document.querySelector('#edit-product-stock');
    const lowStockThresholdInput = document.querySelector('#edit-product-low-stock-threshold');
    const publicationStatusInput = document.querySelector('#edit-product-publication-status');
    const imageUrlInput = document.querySelector('#edit-product-image-url');
    const descriptionInput = document.querySelector('#edit-product-description');

    if (nameInput) nameInput.value = button.dataset.name || '';
    if (skuInput) skuInput.value = button.dataset.sku || '';
    if (categoryInput) categoryInput.value = button.dataset.category || '';
    if (priceInput) priceInput.value = button.dataset.price || '';
    if (compareAtPriceInput) compareAtPriceInput.value = button.dataset.compareAtPrice || '';
    if (stockPriceInput) stockPriceInput.value = button.dataset.stockPrice || '0';
    if (stockInput) stockInput.value = button.dataset.stock || '0';
    if (lowStockThresholdInput) lowStockThresholdInput.value = button.dataset.lowStockThreshold || '5';
    if (publicationStatusInput) publicationStatusInput.value = button.dataset.publicationStatus || 'active';
    if (imageUrlInput) imageUrlInput.value = button.dataset.imageUrl || '';
    if (descriptionInput) descriptionInput.value = button.dataset.description || '';

    productEditDialog.showModal();
}

document.querySelector('#product-add-open').addEventListener('click', openProductDialog);
document.querySelectorAll('[data-product-add]').forEach((button) => {
    button.addEventListener('click', openProductDialog);
});
document.querySelector('#product-dialog-close').addEventListener('click', () => productDialog.close());
document.querySelector('#product-form-cancel').addEventListener('click', () => productDialog.close());

document.querySelectorAll('[data-product-edit]').forEach((button) => {
    button.addEventListener('click', () => openProductEditDialog(button));
});

document.querySelectorAll('[data-product-delete]').forEach((button) => {
    button.addEventListener('click', () => {
        const productName = button.dataset.name || 'this product';
        const productImage = document.querySelector('#delete-product-image');
        const imagePlaceholder = document.querySelector('#delete-product-image-placeholder');
        const imageUrl = button.dataset.imageUrl || '';

        productDeleteForm.action = button.dataset.deleteUrl;
        document.querySelector('#delete-dialog-title').textContent = `Delete ${productName}?`;
        document.querySelector('#delete-product-name').textContent = productName;
        document.querySelector('#delete-product-price').textContent = formatPrice(Number(button.dataset.price || 0));
        document.querySelector('#delete-product-category').textContent = (button.dataset.category || 'Uncategorized')
            .replace(/[-_]/g, ' ')
            .replace(/\b\w/g, (character) => character.toUpperCase());

        productImage.hidden = !imageUrl;
        imagePlaceholder.hidden = Boolean(imageUrl);
        if (imageUrl) {
            productImage.onerror = () => {
                productImage.hidden = true;
                imagePlaceholder.hidden = false;
            };
            productImage.src = imageUrl;
        } else {
            productImage.removeAttribute('src');
        }

        productDeleteDialog.showModal();
    });
});

document.querySelector('#delete-dialog-cancel').addEventListener('click', () => productDeleteDialog.close());

document.querySelectorAll('[data-generate-sku]').forEach((button) => {
    button.addEventListener('click', () => {
        const skuInput = document.querySelector(button.dataset.generateSku);
        if (!skuInput) {
            return;
        }

        const categoryInput = skuInput.form.querySelector('[name="category"]');
        const category = categoryInput?.value || 'new';
        const suffix = `${Date.now().toString(36)}${Math.random().toString(36).slice(2, 6)}`.toUpperCase();
        skuInput.value = `ACE-${category.slice(0, 3).toUpperCase()}-${suffix}`;
    });
});
const editDialogClose = document.querySelector('#product-edit-dialog-close');
if (editDialogClose) {
    editDialogClose.addEventListener('click', () => productEditDialog.close());
}
const editFormCancel = document.querySelector('#product-edit-form-cancel');
if (editFormCancel) {
    editFormCancel.addEventListener('click', () => productEditDialog.close());
}

document.querySelector('[data-dashboard-link]').addEventListener('click', () => {
    document.querySelectorAll('.nav-link').forEach((navLink) => navLink.classList.remove('is-active'));
    document.querySelector('[data-dashboard-link]').classList.add('is-active');
    closeSidebar();
});

document.querySelectorAll('[data-coming-soon]').forEach((link) => {
    link.addEventListener('click', () => {
        showToast(`${link.dataset.comingSoon} is coming soon.`);
        closeSidebar();
    });
});

const wishlistLink = document.querySelector('#wishlist-link');
if (wishlistLink) {
    wishlistLink.addEventListener('click', () => {
        showToast('Saved items are not available in the catalog dashboard.');
    });
}

cartItems.addEventListener('click', (event) => {
    const actionButton = event.target.closest('[data-cart-action]');
    if (!actionButton) {
        return;
    }

    const product = products.find((item) => item.id === actionButton.dataset.cartId);
    const quantity = cart.get(actionButton.dataset.cartId);
    if (!product || !quantity) {
        return;
    }

    if (actionButton.dataset.cartAction === 'increase') {
        if (quantity >= product.stock) {
            showToast('There is no more stock available for this product.');
            return;
        }

        cart.set(actionButton.dataset.cartId, quantity + 1);
    } else if (quantity === 1) {
        cart.delete(actionButton.dataset.cartId);
    } else {
        cart.set(actionButton.dataset.cartId, quantity - 1);
    }

    updateCartView();
});

document.querySelector('#cart-open').addEventListener('click', openCart);
document.querySelector('#cart-close').addEventListener('click', closeCart);
document.querySelector('#continue-shopping').addEventListener('click', closeCart);
cartScrim.addEventListener('click', closeCart);

document.querySelector('#checkout-button').addEventListener('click', () => {
    showToast('Checkout is a preview and isn’t connected yet.');
});

document.querySelector('#orders-link').addEventListener('click', () => {
    showToast('Your order history will be available here.');
});

document.querySelector('#profile-button').addEventListener('click', () => {
    showToast('Sign in will be available soon.');
});

document.querySelector('.notification-button').addEventListener('click', () => {
    showToast('You’re all caught up.');
});

const sidebar = document.querySelector('#sidebar');
const sidebarScrim = document.querySelector('#sidebar-scrim');

function openSidebar() {
    sidebar.classList.add('is-open');
    sidebarScrim.classList.add('is-open');
    document.body.classList.add('has-open-sidebar');
}

function closeSidebar() {
    sidebar.classList.remove('is-open');
    sidebarScrim.classList.remove('is-open');
    document.body.classList.remove('has-open-sidebar');
}

document.querySelector('#menu-toggle').addEventListener('click', openSidebar);
document.querySelector('#sidebar-close').addEventListener('click', closeSidebar);
sidebarScrim.addEventListener('click', closeSidebar);

document.addEventListener('keydown', (event) => {
    if ((event.metaKey || event.ctrlKey) && event.key.toLowerCase() === 'k') {
        event.preventDefault();
        searchInput.focus();
    }

    if (event.key === 'Escape') {
        if (cartDrawer.classList.contains('is-open')) {
            closeCart();
        }

        if (sidebar.classList.contains('is-open')) {
            closeSidebar();
        }

        if (productEditDialog && productEditDialog.open) {
            productEditDialog.close();
        }
    }
});

updateProductTable();
updateCartView();

if (productDialog.dataset.reopen === 'true') {
    productDialog.showModal();
}

const flashMessage = document.querySelector('#flash-message').dataset.message;
if (flashMessage) {
    showToast(flashMessage);
}
