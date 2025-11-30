@extends('customer.layouts.layout')


@section('content')
<div class="row">
    <div class="col-12">
        <!-- Stats Cards -->
        @php
            $totalReviews = $reviews->count();
            $approvedReviews = $reviews->where('status', 'approved')->count();
            $pendingReviews = $reviews->where('status', 'pending')->count();
            $averageRating = $reviews->avg('rating') ?? 0;
        @endphp

        <div class="row">
            <div class="col-xl-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col mt-0">
                                <h5 class="card-title">Total Reviews</h5>
                            </div>
                            <div class="col-auto">
                                <div class="stat text-primary">
                                    <i class="fas fa-star"></i>
                                </div>
                            </div>
                        </div>
                        <h1 class="mt-1 mb-3">{{ $totalReviews }}</h1>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col mt-0">
                                <h5 class="card-title">Approved</h5>
                            </div>
                            <div class="col-auto">
                                <div class="stat text-success">
                                    <i class="fas fa-thumbs-up"></i>
                                </div>
                            </div>
                        </div>
                        <h1 class="mt-1 mb-3">{{ $approvedReviews }}</h1>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col mt-0">
                                <h5 class="card-title">Pending</h5>
                            </div>
                            <div class="col-auto">
                                <div class="stat text-warning">
                                    <i class="fas fa-clock"></i>
                                </div>
                            </div>
                        </div>
                        <h1 class="mt-1 mb-3">{{ $pendingReviews }}</h1>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col mt-0">
                                <h5 class="card-title">Avg Rating</h5>
                            </div>
                            <div class="col-auto">
                                <div class="stat text-danger">
                                    <i class="fas fa-star-half-alt"></i>
                                </div>
                            </div>
                        </div>
                        <h1 class="mt-1 mb-3">{{ number_format($averageRating, 1) }}/5</h1>
                    </div>
                </div>
            </div>
        </div>

        <!-- Reviews List -->
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">My Product Reviews</h5>
                <a href="{{ route('customer.history') }}" class="btn btn-primary">
                    <i class="fas fa-shopping-cart me-1"></i> Review Products
                </a>
            </div>
            <div class="card-body">
                @if($reviews->count() > 0)
                    @foreach($reviews as $review)
                        <div class="border-bottom pb-3 mb-3">
                            <div class="row">
                                <div class="col-auto">
                                    <div class="review-image" style="width: 80px; height: 80px;">
                                        @if($review->product && $review->product->image)
                                            <img src="{{ asset('storage/' . $review->product->image) }}"
                                                 alt="{{ $review->product->name }}"
                                                 class="img-fluid rounded"
                                                 style="width: 100%; height: 100%; object-fit: cover;">
                                        @else
                                            <img src="https://images.unsplash.com/photo-1542291026-7eec264c27ff?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60"
                                                 alt="Product Image"
                                                 class="img-fluid rounded"
                                                 style="width: 100%; height: 100%; object-fit: cover;">
                                        @endif
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <div>
                                            <h6 class="mb-1">{{ $review->product ? $review->product->name : 'Product Not Available' }}</h6>
                                            <div class="rating mb-2">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <i class="fas fa-star{{ $i <= $review->rating ? ' text-warning' : ' text-muted' }}"></i>
                                                @endfor
                                                <small class="text-muted ms-2">({{ $review->rating }}/5)</small>
                                            </div>
                                        </div>
                                        <div class="text-end">
                                            <span class="badge bg-{{ $review->status == 'approved' ? 'success' : 'warning' }} mb-2">
                                                {{ ucfirst($review->status ?? 'pending') }}
                                            </span>
                                            <div class="text-muted small">
                                                {{ $review->created_at->format('M d, Y') }}
                                            </div>
                                        </div>
                                    </div>

                                    <p class="text-muted mb-2">{{ $review->comment ?? 'No comment provided.' }}</p>

                                    @if($review->seller_reply)
                                        <div class="seller-reply bg-light rounded p-3 mt-2">
                                            <strong class="text-primary d-block mb-1">
                                                <i class="fas fa-reply me-1"></i> Seller Reply:
                                            </strong>
                                            <p class="mb-1">{{ $review->seller_reply }}</p>
                                            @if($review->replied_at)
                                                <small class="text-muted">
                                                    Replied on: {{ $review->replied_at->format('M d, Y') }}
                                                </small>
                                            @endif
                                        </div>
                                    @endif

                                    <div class="mt-3">
                                        <a href="{{ route('reviews.edit', $review->id) }}" class="btn btn-outline-primary btn-sm">
                                            <i class="fas fa-edit me-1"></i> Edit
                                        </a>
                                        <form action="{{ route('reviews.destroy', $review->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm"
                                                    onclick="return confirm('Are you sure you want to delete this review?')">
                                                <i class="fas fa-trash me-1"></i> Delete
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="text-center py-5">
                        <div class="mb-4">
                            <i class="fas fa-star fa-4x text-muted opacity-25"></i>
                        </div>
                        <h4 class="text-muted">No Reviews Yet</h4>
                        <p class="text-muted mb-4">You haven't written any reviews yet. Start by reviewing your purchased products.</p>
                        <a href="{{ route('customer.history') }}" class="btn btn-primary">
                            <i class="fas fa-shopping-cart me-1"></i> View My Orders
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Auto-hide alerts after 5 seconds
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(alert => {
            setTimeout(() => {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            }, 5000);
        });

        // Add hover effects to buttons
        const buttons = document.querySelectorAll('.btn');
        buttons.forEach(button => {
            button.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-1px)';
                this.style.transition = 'all 0.2s ease';
            });

            button.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
            });
        });
    });
</script>

<style>
    .stat {
        font-size: 2rem;
        opacity: 0.7;
    }

    .seller-reply {
        border-left: 3px solid #4361ee;
    }

    .rating {
        font-size: 0.9rem;
    }

    .review-image {
        border-radius: 8px;
        overflow: hidden;
    }

    .card {
        box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        border: 1px solid #e3e6f0;
    }

    .card-header {
        background-color: #f8f9fc;
        border-bottom: 1px solid #e3e6f0;
    }
</style>
@endsection
