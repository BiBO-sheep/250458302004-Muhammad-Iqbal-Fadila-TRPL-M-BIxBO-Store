@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="fw-bold">Review Details</h2>
                <a href="{{ route('admin.reviews.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-2"></i>Back to Reviews
                </a>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- Review Card -->
            <div class="card shadow-sm mb-3">
                <div class="card-header bg-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Review Information</h5>
                        <span class="badge
                            @if($review->status == 'approved') bg-success
                            @elseif($review->status == 'pending') bg-warning
                            @else bg-danger
                            @endif fs-6">
                            {{ ucfirst($review->status) }}
                        </span>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Product Info -->
                    <div class="mb-4 pb-4 border-bottom">
                        <h6 class="text-muted text-uppercase small mb-3">Product Information</h6>
                        <div class="d-flex align-items-center">
                            <img src="{{ asset('storage/' . $review->product->image) }}"
                                 alt="{{ $review->product->name }}"
                                 class="rounded me-3"
                                 style="width: 100px; height: 100px; object-fit: cover;">
                            <div>
                                <h5 class="mb-1">{{ $review->product->name }}</h5>
                                <p class="text-muted mb-1">Category: {{ $review->product->category->name ?? 'N/A' }}</p>
                                <p class="text-muted mb-0">Seller: {{ $review->product->user->name }}</p>
                                <a href="{{ route('products.show', $review->product->id) }}"
                                   class="btn btn-sm btn-outline-primary mt-2" target="_blank">
                                    View Product <i class="bi bi-box-arrow-up-right ms-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Customer Info -->
                    <div class="mb-4 pb-4 border-bottom">
                        <h6 class="text-muted text-uppercase small mb-3">Customer Information</h6>
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Name:</strong> {{ $review->user->name }}</p>
                                <p><strong>Email:</strong> {{ $review->user->email }}</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Order ID:</strong> #{{ $review->order->id }}</p>
                                <p><strong>Order Date:</strong> {{ $review->order->created_at->format('M d, Y') }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Review Content -->
                    <div class="mb-4 pb-4 border-bottom">
                        <h6 class="text-muted text-uppercase small mb-3">Review Content</h6>

                        <div class="mb-3">
                            <strong>Rating:</strong>
                            <div class="mt-2">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="bi bi-star{{ $i <= $review->rating ? '-fill' : '' }} text-warning fs-5"></i>
                                @endfor
                                <span class="ms-2 text-muted">({{ $review->rating }}/5)</span>
                            </div>
                        </div>

                        <div class="mb-3">
                            <strong>Comment:</strong>
                            <div class="mt-2 p-3 bg-light rounded">
                                <p class="mb-0">{{ $review->comment ?: 'No comment provided.' }}</p>
                            </div>
                        </div>

                        <div>
                            <strong>Review Date:</strong>
                            <p class="mb-0">{{ $review->created_at->format('F d, Y \a\t h:i A') }}</p>
                            <small class="text-muted">{{ $review->created_at->diffForHumans() }}</small>
                        </div>
                    </div>

                    <!-- Seller Reply -->
                    @if($review->seller_reply)
                        <div class="mb-4">
                            <h6 class="text-muted text-uppercase small mb-3">Seller Response</h6>
                            <div class="p-3 bg-primary bg-opacity-10 rounded">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="bi bi-shop text-primary me-2"></i>
                                    <strong>{{ $review->product->user->name }}</strong>
                                    <small class="text-muted ms-auto">{{ $review->replied_at->format('M d, Y') }}</small>
                                </div>
                                <p class="mb-0">{{ $review->seller_reply }}</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6 class="mb-3">Admin Actions</h6>
                    <div class="d-flex gap-2 flex-wrap">
                        @if($review->status != 'approved')
                            <form action="{{ route('admin.reviews.approve', $review->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-success">
                                    <i class="bi bi-check-circle me-1"></i>Approve Review
                                </button>
                            </form>
                        @endif

                        @if($review->status != 'rejected')
                            <form action="{{ route('admin.reviews.reject', $review->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-warning">
                                    <i class="bi bi-x-circle me-1"></i>Reject Review
                                </button>
                            </form>
                        @endif

                        <form action="{{ route('admin.reviews.destroy', $review->id) }}"
                              method="POST"
                              onsubmit="return confirm('Are you sure you want to delete this review? This action cannot be undone.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <i class="bi bi-trash me-1"></i>Delete Review
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Di bagian bawah product detail, sebelum @endsection -->

<!-- Reviews Section -->
<div class="container mt-5">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <!-- Review Summary -->
                    <div class="row mb-4">
                        <div class="col-md-4 text-center border-end">
                            <h1 class="display-3 fw-bold text-primary mb-0">
                                {{ number_format($product->averageRating(), 1) }}
                            </h1>
                            <div class="mb-2">
                                @php
                                    $avgRating = $product->averageRating();
                                @endphp
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="bi bi-star{{ $i <= round($avgRating) ? '-fill' : '' }} text-warning fs-5"></i>
                                @endfor
                            </div>
                            <p class="text-muted mb-0">
                                Based on {{ $product->totalReviews() }} review{{ $product->totalReviews() != 1 ? 's' : '' }}
                            </p>
                        </div>

                        <div class="col-md-5">
                            <!-- Rating Breakdown -->
                            @php
                                $ratingCounts = $product->approvedReviews()
                                    ->selectRaw('rating, COUNT(*) as count')
                                    ->groupBy('rating')
                                    ->orderBy('rating', 'desc')
                                    ->pluck('count', 'rating');
                                $totalReviews = $product->totalReviews();
                            @endphp

                            @for($i = 5; $i >= 1; $i--)
                                @php
                                    $count = $ratingCounts->get($i, 0);
                                    $percentage = $totalReviews > 0 ? ($count / $totalReviews) * 100 : 0;
                                @endphp
                                <div class="d-flex align-items-center mb-2">
                                    <span class="me-2" style="width: 60px;">{{ $i }} star</span>
                                    <div class="progress flex-grow-1 me-2" style="height: 8px;">
                                        <div class="progress-bar bg-warning"
                                             role="progressbar"
                                             style="width: {{ $percentage }}%">
                                        </div>
                                    </div>
                                    <span class="text-muted small" style="width: 40px;">{{ $count }}</span>
                                </div>
                            @endfor
                        </div>

                        <div class="col-md-3 text-center">
                            @auth
                                @if(Auth::user()->canReviewProduct($product->id))
                                    <a href="{{ route('reviews.create', $product->id) }}"
                                       class="btn btn-primary btn-lg w-100">
                                        <i class="bi bi-star me-2"></i>Write a Review
                                    </a>
                                    <p class="text-muted small mt-2">Share your experience</p>
                                @else
                                    <button class="btn btn-secondary btn-lg w-100" disabled>
                                        <i class="bi bi-lock me-2"></i>Review Not Available
                                    </button>
                                    <p class="text-muted small mt-2">
                                        @if(Auth::user()->reviews()->where('product_id', $product->id)->exists())
                                            You've already reviewed this product
                                        @else
                                            Purchase this product to leave a review
                                        @endif
                                    </p>
                                @endif
                            @else
                                <a href="{{ route('login') }}" class="btn btn-outline-primary btn-lg w-100">
                                    <i class="bi bi-person me-2"></i>Login to Review
                                </a>
                                <p class="text-muted small mt-2">Sign in to share your experience</p>
                            @endauth
                        </div>
                    </div>

                    <hr>

                    <!-- Reviews List -->
                    <div class="mt-4">
                        <h5 class="mb-4">Customer Reviews</h5>

                        @if($product->approvedReviews()->count() > 0)
                            @foreach($product->approvedReviews()->latest()->get() as $review)
                                <div class="review-item mb-4 pb-4 border-bottom">
                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                        <div class="d-flex align-items-center">
                                            <!-- User Avatar -->
                                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3"
                                                 style="width: 50px; height: 50px; font-size: 1.5rem;">
                                                {{ strtoupper(substr($review->user->name, 0, 1)) }}
                                            </div>
                                            <div>
                                                <h6 class="mb-0">{{ $review->user->name }}</h6>
                                                <div class="mb-1">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        <i class="bi bi-star{{ $i <= $review->rating ? '-fill' : '' }} text-warning"></i>
                                                    @endfor
                                                </div>
                                                <small class="text-muted">
                                                    {{ $review->created_at->format('M d, Y') }}
                                                    <span class="mx-2">•</span>
                                                    <span class="badge bg-success">Verified Purchase</span>
                                                </small>
                                            </div>
                                        </div>

                                        <!-- Edit/Delete for own review -->
                                        @auth
                                            @if(Auth::id() == $review->user_id)
                                                <div class="dropdown">
                                                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle"
                                                            type="button"
                                                            data-bs-toggle="dropdown">
                                                        <i class="bi bi-three-dots"></i>
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <li>
                                                            <a class="dropdown-item" href="{{ route('reviews.edit', $review->id) }}">
                                                                <i class="bi bi-pencil me-2"></i>Edit
                                                            </a>
                                                        </li>
                                                        <li><hr class="dropdown-divider"></li>
                                                        <li>
                                                            <form action="{{ route('reviews.destroy', $review->id) }}"
                                                                  method="POST"
                                                                  onsubmit="return confirm('Delete this review?');">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="dropdown-item text-danger">
                                                                    <i class="bi bi-trash me-2"></i>Delete
                                                                </button>
                                                            </form>
                                                        </li>
                                                    </ul>
                                                </div>
                                            @endif
                                        @endauth
                                    </div>

                                    <!-- Review Comment -->
                                    <div class="mb-3">
                                        <p class="mb-0">{{ $review->comment }}</p>
                                    </div>

                                    <!-- Seller Reply -->
                                    @if($review->seller_reply)
                                        <div class="ms-5 p-3 bg-light rounded">
                                            <div class="d-flex align-items-center mb-2">
                                                <i class="bi bi-shop text-primary me-2"></i>
                                                <strong>Response from Seller</strong>
                                                <small class="text-muted ms-auto">{{ $review->replied_at->format('M d, Y') }}</small>
                                            </div>
                                            <p class="mb-0 text-muted">{{ $review->seller_reply }}</p>
                                        </div>
                                    @endif

                                    <!-- Helpful Section -->
                                    <div class="mt-3">
                                        <small class="text-muted">Was this review helpful?</small>
                                        <button class="btn btn-sm btn-outline-secondary ms-2" disabled>
                                            <i class="bi bi-hand-thumbs-up me-1"></i>Yes
                                        </button>
                                        <button class="btn btn-sm btn-outline-secondary" disabled>
                                            <i class="bi bi-hand-thumbs-down me-1"></i>No
                                        </button>
                                    </div>
                                </div>
                            @endforeach

                            <!-- Load More Button (Optional) -->
                            @if($product->approvedReviews()->count() > 5)
                                <div class="text-center mt-4">
                                    <button class="btn btn-outline-primary" id="loadMoreReviews">
                                        Load More Reviews
                                    </button>
                                </div>
                            @endif
                        @else
                            <div class="text-center py-5">
                                <i class="bi bi-chat-left-text display-1 text-muted"></i>
                                <h5 class="mt-3 text-muted">No Reviews Yet</h5>
                                <p class="text-muted">Be the first to review this product!</p>
                                @auth
                                    @if(Auth::user()->canReviewProduct($product->id))
                                        <a href="{{ route('reviews.create', $product->id) }}"
                                           class="btn btn-primary mt-3">
                                            Write First Review
                                        </a>
                                    @endif
                                @endauth
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .review-item:last-child {
        border-bottom: none !important;
    }
</style>
@endsection
