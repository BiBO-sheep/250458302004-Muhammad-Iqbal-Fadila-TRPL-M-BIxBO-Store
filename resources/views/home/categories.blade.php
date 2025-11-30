@extends('layouts.user')
@section('home')
    <!-- breadcrumb -->
    <div class="container">
        <div class="row">
            <div class="col-12">
                <p class="breadcrumb-title">Home > <span>{{ $category->category_name }}</span></p>
            </div>
        </div>
    </div>

    <!-- main contents -->
    <main>
        <!-- product filter -->
        <section>
            <div class="container">
                <div class="row">

                    <div class="col-12 d-block d-lg-none">
                        <a class="filter-btn" href="#!">
                            <span>Filters</span>
                            <i class="fa-solid fa-sliders"></i>
                        </a>
                    </div>

                    <!-- filters -->
                    <div class="col-lg-4 filters-wrap">
                        <a class="d-block d-lg-none filter-close" href="#!">
                            <i class="fa-regular fa-rectangle-xmark"></i>
                        </a>

                        <!-- category filter -->
                        <div class="filter-card">
                            <h5 class="mb-3">Product Category</h5>

                            @foreach ($categories as $cat)
                                <div class="form-check mb-2">
                                    <input class="form-check-input category-filter" type="checkbox"
                                        value="{{ $cat->id }}" id="category-{{ $cat->id }}"
                                        {{ in_array($cat->id, request('categories', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="category-{{ $cat->id }}">
                                        {{ $cat->category_name }}
                                        <small class="text-muted">({{ $cat->products_count ?? 0 }})</small>
                                    </label>
                                </div>
                            @endforeach
                        </div>

                        <!-- price range -->
                        <div class="filter-card">
                            <h5 class="mb-3">Price Filter</h5>

                            <input type="range" class="form-range mb-2" id="priceRange" min="0"
                                max="{{ $maxPrice }}" step="10" value="{{ $maxPrice }}">

                            <div class="d-flex align-items-center justify-content-between gap-3">
                                <p class="mb-0">Price: $0 - $<span
                                        id="priceValue">{{ number_format($maxPrice, 0) }}</span></p>
                            </div>
                        </div>

                        <!-- product status -->
                        <div class="filter-card">
                            <h5 class="mb-3">Product Status</h5>

                            <div class="form-check mb-2">
                                <input class="form-check-input status-filter" type="checkbox" value="in-stock"
                                    id="in-stock" checked>
                                <label class="form-check-label" for="in-stock">
                                    In Stock
                                </label>
                            </div>

                            <div class="form-check mb-2">
                                <input class="form-check-input status-filter" type="checkbox" value="on-sale" id="on-sale"
                                    checked>
                                <label class="form-check-label" for="on-sale">
                                    On Sale
                                </label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input status-filter" type="checkbox" value="discontinued"
                                    id="discontinued" checked>
                                <label class="form-check-label" for="discontinued">
                                    Discontinued
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- products -->
                    <div class="col-lg-8 mb-5">
                        <div class="row" id="productsContainer">
                            @foreach ($products as $product)
                                <div class="col-md-6 col-lg-4 mb-4 product-item"
                                    data-category="{{ $product->category_id }}"
                                    data-price="{{ $product->discounted_price }}"
                                    data-stock="{{ $product->stock_quantity }}"
                                    data-original-price="{{ $product->original_price }}"
                                    data-discounted-price="{{ $product->discounted_price }}">
                                    <div class="card-md">
                                        <!-- image -->
                                        <div class="product-img">
                                            @if ($product->images->isNotEmpty())
                                                <img class="object-fit-contain" style="height: 200px;"
                                                    src="{{ asset('storage/' . $product->images->first()->img_path) }}"
                                                    alt="{{ $product->product_name }}">
                                            @else
                                                <img class="object-fit-contain" style="height: 200px;"
                                                    src="{{ asset('storage/product_images/default.png') }}"
                                                    alt="Default Image">
                                            @endif
                                        </div>

                                        <h4 class="fw-semibold mb-2">{{ $product->product_name }}</h4>
                                        <h4 class="fw-light mb-4">${{ number_format($product->discounted_price, 2) }}</h4>

                                        <!-- add to cart -->
                                        <div class="add-cart-wrap" x-data="{ quantity: 1 }">
                                            <input type="number" min="1" max="{{ $product->stock_quantity }}"
                                                x-model="quantity" value="1">
                                            <a class="btn-md shadow-none" href="javascript:void(0)"
                                                @click="$dispatch('addToCartFromAnywhere', {productId: {{ $product->id }}, quantity: quantity})">
                                                Add to Cart
                                            </a>
                                        </div>

                                        <!-- cta -->
                                        <div class="card-md-cta">
                                            <a href="#!">
                                                <i class="fas fa-heart active"></i>
                                            </a>
                                            <a href="#!">
                                                <i class="fa-solid fa-code-compare active"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- No products message -->
                        <div id="noProductsMessage" class="col-12 text-center" style="display: none;">
                            <h5>No Products Found</h5>
                            <p class="text-muted">Try adjusting your filters</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const categoryCheckboxes = document.querySelectorAll('.category-filter');
                const statusCheckboxes = document.querySelectorAll('.status-filter');
                const priceRange = document.getElementById('priceRange');
                const priceValue = document.getElementById('priceValue');
                const productItems = document.querySelectorAll('.product-item');
                const noProductsMessage = document.getElementById('noProductsMessage');
                const productsContainer = document.getElementById('productsContainer');

                // Update price display
                priceRange.addEventListener('input', function() {
                    priceValue.textContent = parseInt(this.value).toLocaleString();
                });

                priceRange.addEventListener('change', function() {
                    filterProducts();
                });

                // Category filter
                categoryCheckboxes.forEach(checkbox => {
                    checkbox.addEventListener('change', filterProducts);
                });

                // Status filter
                statusCheckboxes.forEach(checkbox => {
                    checkbox.addEventListener('change', filterProducts);
                });

                function filterProducts() {
                    // Get selected categories
                    const selectedCategories = Array.from(categoryCheckboxes)
                        .filter(cb => cb.checked)
                        .map(cb => cb.value);

                    // Get selected statuses
                    const selectedStatuses = Array.from(statusCheckboxes)
                        .filter(cb => cb.checked)
                        .map(cb => cb.value);

                    // Get price range value
                    const maxPrice = parseFloat(priceRange.value);

                    let visibleCount = 0;

                    productItems.forEach(item => {
                        const categoryId = item.dataset.category;
                        const price = parseFloat(item.dataset.price);
                        const stock = parseInt(item.dataset.stock);
                        const originalPrice = parseFloat(item.dataset.originalPrice);
                        const discountedPrice = parseFloat(item.dataset.discountedPrice);

                        let show = true;

                        // Check category filter - HANYA tampil jika kategorinya dicentang
                        if (selectedCategories.length > 0) {
                            show = selectedCategories.includes(categoryId);
                        } else {
                            // Kalau tidak ada kategori yang dicentang, sembunyikan semua
                            show = false;
                        }

                        // Check price filter
                        if (show && price > maxPrice) {
                            show = false;
                        }

                        // Check status filter
                        if (show && selectedStatuses.length > 0) {
                            let statusMatch = false;

                            selectedStatuses.forEach(status => {
                                if (status === 'in-stock' && stock > 0) {
                                    statusMatch = true;
                                }
                                if (status === 'on-sale' && discountedPrice < originalPrice) {
                                    statusMatch = true;
                                }
                                if (status === 'discontinued' && stock === 0) {
                                    statusMatch = true;
                                }
                            });

                            if (!statusMatch) {
                                show = false;
                            }
                        }

                        // Show or hide product with smooth transition
                        if (show) {
                            item.style.display = 'block';
                            setTimeout(() => {
                                item.style.opacity = '1';
                                item.style.transform = 'scale(1)';
                            }, 10);
                            visibleCount++;
                        } else {
                            item.style.opacity = '0';
                            item.style.transform = 'scale(0.95)';
                            setTimeout(() => {
                                item.style.display = 'none';
                            }, 300);
                        }
                    });

                    // Show/hide no products message
                    setTimeout(() => {
                        if (visibleCount === 0) {
                            noProductsMessage.style.display = 'block';
                            productsContainer.style.minHeight = '300px';
                        } else {
                            noProductsMessage.style.display = 'none';
                            productsContainer.style.minHeight = 'auto';
                        }
                    }, 350);
                }

                // Add smooth transition CSS
                productItems.forEach(item => {
                    item.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
                });

                // Initial filter on page load - Set current category as checked
                const currentCategoryId = '{{ $category->id }}';
                categoryCheckboxes.forEach(checkbox => {
                    if (checkbox.value === currentCategoryId) {
                        checkbox.checked = true;
                    } else {
                        checkbox.checked = false;
                    }
                });

                // Set all status as checked by default
                statusCheckboxes.forEach(checkbox => {
                    checkbox.checked = true;
                });

                filterProducts();
            });
        </script>
    @endpush
@endsection
