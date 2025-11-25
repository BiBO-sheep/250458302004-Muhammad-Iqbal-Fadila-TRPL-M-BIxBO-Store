<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings - Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary: #4361ee;
            --primary-light: #4895ef;
            --secondary: #3f37c9;
            --success: #4cc9f0;
            --light-bg: #f8f9fa;
            --card-bg: #ffffff;
            --text: #212529;
            --text-light: #6c757d;
            --border: #e9ecef;
        }

        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: var(--text);
            min-height: 100vh;
            padding: 20px 0;
        }

        .settings-card {
            background-color: var(--card-bg);
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            border: none;
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .settings-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.12);
        }

        .card-header {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            color: white;
            border-bottom: none;
            padding: 20px 25px;
        }

        .card-title {
            font-weight: 600;
            font-size: 1.4rem;
            display: flex;
            align-items: center;
        }

        .card-title i {
            margin-right: 10px;
            font-size: 1.6rem;
        }

        .card-body {
            padding: 30px;
        }

        .form-section {
            margin-bottom: 30px;
            padding-bottom: 25px;
            border-bottom: 1px solid var(--border);
        }

        .form-section:last-of-type {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }

        .section-title {
            font-weight: 600;
            color: var(--primary);
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid var(--primary-light);
            display: flex;
            align-items: center;
        }

        .section-title i {
            margin-right: 10px;
            font-size: 1.2rem;
        }

        .form-label {
            font-weight: 600;
            color: var(--text);
            margin-bottom: 8px;
            display: flex;
            align-items: center;
        }

        .form-label i {
            margin-right: 8px;
            color: var(--primary);
            font-size: 0.9rem;
        }

        .form-control, .form-select {
            border-radius: 10px;
            padding: 12px 15px;
            border: 2px solid var(--border);
            transition: all 0.3s;
            font-size: 0.95rem;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--primary-light);
            box-shadow: 0 0 0 0.25rem rgba(67, 97, 238, 0.15);
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            border: none;
            border-radius: 10px;
            padding: 12px 30px;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.3s;
            box-shadow: 0 4px 15px rgba(67, 97, 238, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(67, 97, 238, 0.4);
            background: linear-gradient(135deg, var(--secondary) 0%, var(--primary) 100%);
        }

        .alert {
            border-radius: 10px;
            border: none;
            padding: 15px 20px;
        }

        .alert-danger {
            background-color: rgba(220, 53, 69, 0.1);
            color: #721c24;
        }

        .alert-success {
            background-color: rgba(40, 167, 69, 0.1);
            color: #155724;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .help-text {
            font-size: 0.85rem;
            color: var(--text-light);
            margin-top: 5px;
        }

        .settings-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            background: rgba(67, 97, 238, 0.1);
            border-radius: 10px;
            margin-right: 12px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-10">
                <div class="settings-card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <div class="settings-icon">
                                <i class="fas fa-cog"></i>
                            </div>
                            Home Page Settings
                        </h5>
                    </div>
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <h6><i class="fas fa-exclamation-triangle me-2"></i>Please fix the following errors:</h6>
                                <ul class="mb-0 mt-2">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if (session('success'))
                            <div class="alert alert-success">
                                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                            </div>
                        @endif

                        <form action="{{ route('admin.homepagesetting.update') }}" method="POST">
                            @csrf
                            @method('PUT')

                            <!-- Discount Section -->
                            <div class="form-section">
                                <h5 class="section-title">
                                    <i class="fas fa-tag"></i>Discount Settings
                                </h5>

                                <div class="form-group">
                                    <label for="discounted_product_id" class="form-label">
                                        <i class="fas fa-shopping-bag"></i>Discounted Product
                                    </label>
                                    <select name="discounted_product_id" id="discounted_product_id" class="form-select">
                                        @foreach($products as $product)
                                            <option value="{{ $product->id }}" {{ $homepagesetting->discounted_product_id == $product->id ? 'selected' : '' }}>
                                                {{ $product->product_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="help-text">Select which product will be featured with a discount on the homepage.</div>
                                </div>

                                <div class="form-group">
                                    <label for="discount_percent" class="form-label">
                                        <i class="fas fa-percentage"></i>Discount Percentage
                                    </label>
                                    <input type="number" value="{{ $homepagesetting->discount_percent }}" class="form-control" name="discount_percent" min="0" max="100">
                                    <div class="help-text">Enter the discount percentage (0-100).</div>
                                </div>

                                <div class="form-group">
                                    <label for="discount_heading" class="form-label">
                                        <i class="fas fa-heading"></i>Discount Heading
                                    </label>
                                    <input type="text" value="{{ $homepagesetting->discount_heading }}" class="form-control" name="discount_heading" placeholder="e.g., Special Offer">
                                    <div class="help-text">This text will appear as the main heading for the discount section.</div>
                                </div>

                                <div class="form-group">
                                    <label for="discount_subheading" class="form-label">
                                        <i class="fas fa-text-height"></i>Discount Subheading
                                    </label>
                                    <input type="text" value="{{ $homepagesetting->discount_subheading }}" class="form-control" name="discount_subheading" placeholder="e.g., Limited time only">
                                    <div class="help-text">This text will appear below the main heading.</div>
                                </div>
                            </div>

                            <!-- Featured Products Section -->
                            <div class="form-section">
                                <h5 class="section-title">
                                    <i class="fas fa-star"></i>Featured Products
                                </h5>

                                <div class="form-group">
                                    <label for="featured_product_1_id" class="form-label">
                                        <i class="fas fa-gem"></i>Featured Product 1
                                    </label>
                                    <select name="featured_product_1_id" id="featured_product_1_id" class="form-select">
                                        @foreach($products as $product)
                                            <option value="{{ $product->id }}" {{ $homepagesetting->featured_product_1_id == $product->id ? 'selected' : '' }}>
                                                {{ $product->product_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="help-text">Select the first product to feature on the homepage.</div>
                                </div>

                                <div class="form-group">
                                    <label for="featured_product_2_id" class="form-label">
                                        <i class="fas fa-gem"></i>Featured Product 2
                                    </label>
                                    <select name="featured_product_2_id" id="featured_product_2_id" class="form-select">
                                        @foreach($products as $product)
                                            <option value="{{ $product->id }}" {{ $homepagesetting->featured_product_2_id == $product->id ? 'selected' : '' }}>
                                                {{ $product->product_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="help-text">Select the second product to feature on the homepage.</div>
                                </div>
                            </div>

                            <div class="d-grid gap-2 mt-4">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="fas fa-save me-2"></i>Update Homepage Settings
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
