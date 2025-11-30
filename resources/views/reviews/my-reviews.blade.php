@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="fw-bold">My Reviews</h2>
                <span class="badge bg-primary fs-6">{{ $reviews->total() }} Reviews</span>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if($reviews->count() > 0)
                <div class="row">
                    @foreach($reviews as $review)
                        <div class="col-12 mb-3">
                            <div class="card shadow-sm hover-shadow">
                                <div class="card-body">
                                    <div class="row">
                                        <!-- Product Image -->
                                        <div class="col-md-2 text-center">
                                            <img src="{{ asset('storage/' . $review->product->image) }}"
                                                 alt="{{ $review->product->name }}"
                                                 class="img-fluid rounded"
                                                 style="max-height: 120px; object-fit: cover;">
                                        </div>

                                        <!-- Review Content -->
                                        <div class="col-md-10">
                                            <div class="d-flex justify-content-between align-items-start mb-2">
                                                <div>
                                                    <h5 class="mb-1">
                                                        <a href="{{ route('products.show', $review->product->id) }}"
                                                           class="text-decoration-none text-dark">
                                                            {{ $review->product->name }}
                                                        </a>
                                                    </h5>
                                                    <div class="mb-2">
                                                        @for($i = 1; $i <= 5; $i++)
                                                            <i class="bi bi-star{{ $i <= $review->rating ? '-fill' : '' }} text-warning"></i>
                                                        @endfor
                                                        <span class="text-muted small ms-2">{{ $review->created_at->format('M d, Y') }}</span>
                                                    </div>
                                                </div>

                                                <!-- Action Buttons -->
                                                <div class="dropdown">
                                                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle"
                                                            type="button"
                                                            data-bs-toggle="dropdown">
                                                        Actions
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
                                                                  onsubmit="return confirm('Are you sure you want to delete this review?');">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="dropdown-item text-danger">
                                                                    <i class="bi bi-trash me-2"></i>Delete
                                                                </button>
                                                            </form>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>

                                            <!-- Review Comment -->
                                            @if($review->comment)
                                                <p class="text-muted mb-3">{{ $review->comment }}</p>
                                            @endif

                                            <!-- Status Badge -->
                                            <span class="badge
                                                @if($review->status == 'approved') bg-success
                                                @elseif($review->status == 'pending') bg-warning
                                                @else bg-danger
                                                @endif">
                                                {{ ucfirst($review->status) }}
                                            </span>

                                            <!-- Seller Reply -->
                                            @if($review->seller_reply)
                                                <div class="mt-3 p-3 bg-light rounded">
                                                    <div class="d-flex align-items-center mb-2">
                                                        <i class="bi bi-shop text-primary me-2"></i>
                                                        <strong>Seller Response:</strong>
                                                        <small class="text-muted ms-auto">
                                                            {{ $review->replied_at->format('M d, Y') }}
                                                        </small>
                                                    </div>
                                                    <p class="mb-0 text-muted">{{ $review->seller_reply }}</p>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $reviews->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="bi bi-star display-1 text-muted"></i>
                    <h4 class="mt-3 text-muted">No Reviews Yet</h4>
                    <p class="text-muted">You haven't written any reviews yet. Purchase products and share your experience!</p>
                    <a href="{{ route('products.index') }}" class="btn btn-primary mt-3">
                        <i class="bi bi-shop me-2"></i>Browse Products
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

<style>
    .hover-shadow {
        transition: all 0.3s ease;
    }
    .hover-shadow:hover {
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
        transform: translateY(-2px);
    }
</style>
@endsection
