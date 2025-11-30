@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="fw-bold">Product Reviews</h2>
                <span class="badge bg-primary fs-6">{{ $reviews->total() }} Total Reviews</span>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- Statistics Cards -->
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="card bg-primary text-white">
                        <div class="card-body">
                            <h6 class="text-uppercase mb-2">Total Reviews</h6>
                            <h3 class="mb-0">{{ $reviews->total() }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-success text-white">
                        <div class="card-body">
                            <h6 class="text-uppercase mb-2">With Reply</h6>
                            <h3 class="mb-0">{{ $reviews->where('seller_reply', '!=', null)->count() }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-warning text-white">
                        <div class="card-body">
                            <h6 class="text-uppercase mb-2">Pending Reply</h6>
                            <h3 class="mb-0">{{ $reviews->where('seller_reply', null)->count() }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-info text-white">
                        <div class="card-body">
                            <h6 class="text-uppercase mb-2">Avg Rating</h6>
                            <h3 class="mb-0">
                                {{ number_format($reviews->avg('rating'), 1) }}
                                <i class="bi bi-star-fill"></i>
                            </h3>
                        </div>
                    </div>
                </div>
            </div>

            @if($reviews->count() > 0)
                <div class="card shadow-sm">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Product</th>
                                        <th>Customer</th>
                                        <th>Rating</th>
                                        <th>Review</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($reviews as $review)
                                        <tr>
                                            <!-- Product -->
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <img src="{{ asset('storage/' . $review->product->image) }}"
                                                         alt="{{ $review->product->name }}"
                                                         class="rounded me-2"
                                                         style="width: 50px; height: 50px; object-fit: cover;">
                                                    <div>
                                                        <div class="fw-bold">{{ Str::limit($review->product->name, 30) }}</div>
                                                        <small class="text-muted">SKU: {{ $review->product->sku ?? 'N/A' }}</small>
                                                    </div>
                                                </div>
                                            </td>

                                            <!-- Customer -->
                                            <td>
                                                <div class="fw-bold">{{ $review->user->name }}</div>
                                                <small class="text-muted">{{ $review->user->email }}</small>
                                            </td>

                                            <!-- Rating -->
                                            <td>
                                                <div>
                                                    @for($i = 1; $i <= 5; $i++)
                                                        <i class="bi bi-star{{ $i <= $review->rating ? '-fill' : '' }} text-warning"></i>
                                                    @endfor
                                                </div>
                                                <small class="text-muted">{{ $review->rating }}/5</small>
                                            </td>

                                            <!-- Review -->
                                            <td style="max-width: 250px;">
                                                <p class="mb-1">{{ Str::limit($review->comment, 60) }}</p>
                                                @if($review->seller_reply)
                                                    <div class="mt-2 p-2 bg-light rounded small">
                                                        <strong>Your reply:</strong>
                                                        <p class="mb-0 text-muted">{{ Str::limit($review->seller_reply, 50) }}</p>
                                                    </div>
                                                @endif
                                            </td>

                                            <!-- Date -->
                                            <td>
                                                <small>{{ $review->created_at->format('M d, Y') }}</small>
                                                <br>
                                                <small class="text-muted">{{ $review->created_at->diffForHumans() }}</small>
                                            </td>

                                            <!-- Status -->
                                            <td>
                                                @if($review->seller_reply)
                                                    <span class="badge bg-success">
                                                        <i class="bi bi-check-circle me-1"></i>Replied
                                                    </span>
                                                @else
                                                    <span class="badge bg-warning">
                                                        <i class="bi bi-clock me-1"></i>Pending
                                                    </span>
                                                @endif
                                            </td>

                                            <!-- Action -->
                                            <td class="text-center">
                                                <button class="btn btn-sm btn-primary"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#replyModal{{ $review->id }}">
                                                    <i class="bi bi-reply me-1"></i>
                                                    {{ $review->seller_reply ? 'Edit Reply' : 'Reply' }}
                                                </button>
                                            </td>
                                        </tr>

                                        <!-- Reply Modal -->
                                        <div class="modal fade" id="replyModal{{ $review->id }}" tabindex="-1">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">
                                                            {{ $review->seller_reply ? 'Edit Reply' : 'Reply to Review' }}
                                                        </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <!-- Original Review -->
                                                        <div class="mb-3 p-3 bg-light rounded">
                                                            <div class="d-flex justify-content-between mb-2">
                                                                <strong>{{ $review->user->name }}</strong>
                                                                <div>
                                                                    @for($i = 1; $i <= 5; $i++)
                                                                        <i class="bi bi-star{{ $i <= $review->rating ? '-fill' : '' }} text-warning"></i>
                                                                    @endfor
                                                                </div>
                                                            </div>
                                                            <p class="mb-0">{{ $review->comment }}</p>
                                                        </div>

                                                        <!-- Reply Form -->
                                                        <form action="{{ route('seller.reviews.reply', $review->id) }}" method="POST">
                                                            @csrf
                                                            <div class="mb-3">
                                                                <label class="form-label fw-bold">Your Reply</label>
                                                                <textarea name="seller_reply"
                                                                          class="form-control"
                                                                          rows="4"
                                                                          required
                                                                          placeholder="Write your response...">{{ $review->seller_reply }}</textarea>
                                                            </div>
                                                            <div class="d-flex gap-2">
                                                                <button type="submit" class="btn btn-primary">
                                                                    <i class="bi bi-send me-1"></i>Send Reply
                                                                </button>
                                                                @if($review->seller_reply)
                                                                    <button type="button"
                                                                            class="btn btn-outline-danger"
                                                                            onclick="event.preventDefault(); document.getElementById('delete-reply-{{ $review->id }}').submit();">
                                                                        <i class="bi bi-trash me-1"></i>Delete Reply
                                                                    </button>
                                                                @endif
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                                    Cancel
                                                                </button>
                                                            </div>
                                                        </form>

                                                        @if($review->seller_reply)
                                                            <form id="delete-reply-{{ $review->id }}"
                                                                  action="{{ route('seller.reviews.delete-reply', $review->id) }}"
                                                                  method="POST"
                                                                  class="d-none">
                                                                @csrf
                                                                @method('DELETE')
                                                            </form>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $reviews->links() }}
                </div>
            @else
                <div class="card shadow-sm">
                    <div class="card-body text-center py-5">
                        <i class="bi bi-star display-1 text-muted"></i>
                        <h4 class="mt-3 text-muted">No Reviews Yet</h4>
                        <p class="text-muted">Your products don't have any reviews yet.</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
