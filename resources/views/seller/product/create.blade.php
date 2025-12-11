@extends('seller.layouts.layout')

@section('seller_page_title', 'Create Product')

@section('seller_layout')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-md-flex align-items-center justify-content-between mb-4">
        <div>
            <h4 class="mb-0">Create New Product</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="">Products</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Create</li>
                </ol>
            </nav>
        </div>
        <div class="mt-3 mt-md-0">
            <a href="" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Back to List
            </a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-light">
                    <h5 class="card-title mb-0">Product Information</h5>
                </div>
                <div class="card-body">
                    <!-- Alert Messages -->
                    @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <h6 class="alert-heading"><i class="fas fa-exclamation-triangle me-2"></i>Validation Errors</h6>
                        <ul class="mb-0 ps-3">
                            @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif

                    @if(session('message'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>{{ session('message') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif

                    <!-- Product Form -->
                    <form action="{{ route('vendor.product.store') }}" method="POST" enctype="multipart/form-data" id="productForm">
                        @csrf

                        <!-- Basic Information Card -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h6 class="mb-0"><i class="fas fa-info-circle me-2"></i>Basic Information</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="product_name" class="form-label required">Product Name</label>
                                        <input type="text" name="product_name" id="product_name"
                                               class="form-control @error('product_name') is-invalid @enderror"
                                               placeholder="e.g., Acer Nitro V15 Gaming Laptop"
                                               value="{{ old('product_name') }}" required>
                                        @error('product_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="sku" class="form-label required">SKU Code</label>
                                        <input type="text" name="sku" id="sku"
                                               class="form-control @error('sku') is-invalid @enderror"
                                               placeholder="e.g., ACNV15-2024-GM"
                                               value="{{ old('sku') }}" required>
                                        @error('sku')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="description" class="form-label required">Description</label>
                                    <textarea name="description" id="description"
                                              class="form-control @error('description') is-invalid @enderror"
                                              rows="5" placeholder="Enter detailed product description" required>{{ old('description') }}</textarea>
                                    @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Category & Store Card -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h6 class="mb-0"><i class="fas fa-folder me-2"></i>Category & Store</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label required">Category & Subcategory</label>
                                        <livewire:category-subcategory />
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="store_id" class="form-label required">Select Store</label>
                                        <select name="store_id" id="store_id"
                                                class="form-select @error('store_id') is-invalid @enderror" required>
                                            <option value="">Choose Store...</option>
                                            @foreach($stores as $store)
                                            <option value="{{ $store->id }}" {{ old('store_id') == $store->id ? 'selected' : '' }}>
                                                {{ $store->store_name }}
                                            </option>
                                            @endforeach
                                        </select>
                                        @error('store_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pricing & Stock Card -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h6 class="mb-0"><i class="fas fa-tag me-2"></i>Pricing & Stock</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label for="regular_price" class="form-label required">Regular Price</label>
                                        <div class="input-group">
                                            <span class="input-group-text">$</span>
                                            <input type="number" name="regular_price" id="regular_price"
                                                   class="form-control @error('regular_price') is-invalid @enderror"
                                                   step="0.01" min="0" value="{{ old('regular_price') }}" required>
                                        </div>
                                        @error('regular_price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="discounted_price" class="form-label">Discounted Price</label>
                                        <div class="input-group">
                                            <span class="input-group-text">$</span>
                                            <input type="number" name="discounted_price" id="discounted_price"
                                                   class="form-control @error('discounted_price') is-invalid @enderror"
                                                   step="0.01" min="0" value="{{ old('discounted_price') }}">
                                        </div>
                                        @error('discounted_price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="tax_rate" class="form-label">Tax Rate (%)</label>
                                        <div class="input-group">
                                            <input type="number" name="tax_rate" id="tax_rate"
                                                   class="form-control @error('tax_rate') is-invalid @enderror"
                                                   step="0.01" min="0" max="100" value="{{ old('tax_rate', 0) }}">
                                            <span class="input-group-text">%</span>
                                        </div>
                                        @error('tax_rate')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label for="stock_quantity" class="form-label required">Stock Quantity</label>
                                        <input type="number" name="stock_quantity" id="stock_quantity"
                                               class="form-control @error('stock_quantity') is-invalid @enderror"
                                               min="0" value="{{ old('stock_quantity', 0) }}" required>
                                        @error('stock_quantity')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Images Card -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h6 class="mb-0"><i class="fas fa-images me-2"></i>Product Images</h6>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="images" class="form-label required">Upload Product Images</label>
                                    <input type="file" name="images[]" id="images"
                                           class="form-control @error('images') is-invalid @enderror"
                                           multiple accept="image/*" required>
                                    <div class="form-text">You can select multiple images. Supported formats: JPG, PNG, GIF</div>
                                    @error('images')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Image Preview Container -->
                                <div class="row mt-3" id="imagePreview"></div>
                            </div>
                        </div>

                        <!-- SEO Card -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h6 class="mb-0"><i class="fas fa-search me-2"></i>SEO Settings</h6>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="slug" class="form-label required">Product Slug (URL)</label>
                                    <input type="text" name="slug" id="slug"
                                           class="form-control @error('slug') is-invalid @enderror"
                                           placeholder="e.g., acer-nitro-v15-gaming-laptop"
                                           value="{{ old('slug') }}" required>
                                    <div class="form-text">Used in the product URL. Use hyphens between words.</div>
                                    @error('slug')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="meta_title" class="form-label">Meta Title</label>
                                    <input type="text" name="meta_title" id="meta_title"
                                           class="form-control @error('meta_title') is-invalid @enderror"
                                           placeholder="Maximum 60 characters recommended"
                                           value="{{ old('meta_title') }}" maxlength="60">
                                    <div class="form-text" id="metaTitleCounter">0/60 characters</div>
                                    @error('meta_title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="meta_description" class="form-label">Meta Description</label>
                                    <textarea name="meta_description" id="meta_description"
                                              class="form-control @error('meta_description') is-invalid @enderror"
                                              rows="3" placeholder="Maximum 160 characters recommended"
                                              maxlength="160">{{ old('meta_description') }}</textarea>
                                    <div class="form-text" id="metaDescCounter">0/160 characters</div>
                                    @error('meta_description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="d-flex justify-content-between">
                            <button type="reset" class="btn btn-outline-secondary">
                                <i class="fas fa-redo me-2"></i>Reset Form
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-plus-circle me-2"></i>Create Product
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Image preview functionality
    document.getElementById('images').addEventListener('change', function(e) {
        const previewContainer = document.getElementById('imagePreview');
        previewContainer.innerHTML = '';

        Array.from(this.files).forEach((file, index) => {
            if (file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const col = document.createElement('div');
                    col.className = 'col-md-3 col-sm-4 col-6 mb-3';
                    col.innerHTML = `
                        <div class="card">
                            <img src="${e.target.result}" class="card-img-top" style="height: 150px; object-fit: cover;" alt="Preview ${index + 1}">
                            <div class="card-body p-2 text-center">
                                <small class="text-muted">Image ${index + 1}</small>
                            </div>
                        </div>
                    `;
                    previewContainer.appendChild(col);
                }
                reader.readAsDataURL(file);
            }
        });
    });

    // Character counters for SEO fields
    const metaTitle = document.getElementById('meta_title');
    const metaTitleCounter = document.getElementById('metaTitleCounter');
    const metaDesc = document.getElementById('meta_description');
    const metaDescCounter = document.getElementById('metaDescCounter');

    if (metaTitle) {
        metaTitle.addEventListener('input', function() {
            metaTitleCounter.textContent = `${this.value.length}/60 characters`;
        });
        // Trigger initial count
        metaTitle.dispatchEvent(new Event('input'));
    }

    if (metaDesc) {
        metaDesc.addEventListener('input', function() {
            metaDescCounter.textContent = `${this.value.length}/160 characters`;
        });
        // Trigger initial count
        metaDesc.dispatchEvent(new Event('input'));
    }

    // Auto-generate slug from product name
    const productName = document.getElementById('product_name');
    const slugField = document.getElementById('slug');

    if (productName && slugField) {
        productName.addEventListener('blur', function() {
            if (!slugField.value) {
                const slug = this.value
                    .toLowerCase()
                    .replace(/[^a-z0-9\s-]/g, '')
                    .replace(/\s+/g, '-')
                    .replace(/-+/g, '-')
                    .trim();
                slugField.value = slug;
            }
        });
    }

    // Form validation
    document.getElementById('productForm').addEventListener('submit', function(e) {
        const requiredFields = this.querySelectorAll('[required]');
        let isValid = true;

        requiredFields.forEach(field => {
            if (!field.value.trim()) {
                isValid = false;
                field.classList.add('is-invalid');
            } else {
                field.classList.remove('is-invalid');
            }
        });

        if (!isValid) {
            e.preventDefault();
            alert('Please fill in all required fields marked with *');
        }
    });
</script>
@endpush

<style>
    .required:after {
        content: " *";
        color: #dc3545;
    }
    .card {
        border: 1px solid #e0e0e0;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    }
    .card-header {
        background-color: #f8f9fa;
        border-bottom: 1px solid #e0e0e0;
    }
    .form-text {
        font-size: 0.85rem;
    }
</style>
@endsection
