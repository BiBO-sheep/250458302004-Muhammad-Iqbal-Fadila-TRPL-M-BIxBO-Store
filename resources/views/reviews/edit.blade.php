@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Edit Your Review</h4>
                </div>
                <div class="card-body">
                    <!-- Product Info -->
                    <div class="d-flex align-items-center mb-4 pb-3 border-bottom">
                        <img src="{{ asset('storage/' . $review->product->image) }}"
                             alt="{{ $review->product->name }}"
                             class="rounded"
                             style="width: 80px; height: 80px; object-fit: cover;">
                        <div class="ms-3">
                            <h5 class="mb-1">{{ $review->product->name }}</h5>
                            <p class="text-muted mb-0 small">
                                Original review: {{ $review->created_at->format('M d, Y') }}
                            </p>
                        </div>
                    </div>

                    <!-- Edit Form -->
                    <form action="{{ route('reviews.update', $review->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Rating -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">Rating <span class="text-danger">*</span></label>
                            <div class="star-rating">
                                @for ($i = 5; $i >= 1; $i--)
                                    <input type="radio"
                                           id="star{{ $i }}"
                                           name="rating"
                                           value="{{ $i }}"
                                           {{ $review->rating == $i ? 'checked' : '' }}
                                           required>
                                    <label for="star{{ $i }}" title="{{ $i }} stars">
                                        <i class="bi bi-star-fill"></i>
                                    </label>
                                @endfor
                            </div>
                            @error('rating')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- Comment -->
                        <div class="mb-4">
                            <label for="comment" class="form-label fw-bold">Your Review</label>
                            <textarea name="comment"
                                      id="comment"
                                      class="form-control @error('comment') is-invalid @enderror"
                                      rows="5"
                                      placeholder="Share your experience with this product...">{{ old('comment', $review->comment) }}</textarea>
                            @error('comment')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Maximum 1000 characters</small>
                        </div>

                        <!-- Buttons -->
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle me-1"></i> Update Review
                            </button>
                            <a href="{{ route('reviews.my-reviews') }}" class="btn btn-outline-secondary">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Star Rating Styles */
    .star-rating {
        display: flex;
        flex-direction: row-reverse;
        justify-content: flex-end;
        gap: 5px;
    }

    .star-rating input[type="radio"] {
        display: none;
    }

    .star-rating label {
        cursor: pointer;
        font-size: 2rem;
        color: #ddd;
        transition: color 0.2s;
    }

    .star-rating input[type="radio"]:checked ~ label,
    .star-rating label:hover,
    .star-rating label:hover ~ label {
        color: #ffc107;
    }
</style>
@endsection
