@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="fw-bold">Manage Reviews</h2>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- Filter & Search -->
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <form action="{{ route('admin.reviews.index') }}" method="GET">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label small fw-bold">Search</label>
                                <input type="text"
                                       name="search"
                                       class="form-control"
                                       placeholder="Search by user, product, or comment..."
                                       value="{{ request('search') }}">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label small fw-bold">Status</label>
                                <select name="status" class="form-select">
                                    <option value="">All Status</option>
                                    <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                </select>
                            </div>
                            <div class="col-md-3 d-flex align-items-end">
                                <button type="submit" class="btn btn-primary me-2">
                                    <i class="bi bi-search me-1"></i>Filter
                                </button>
                                <a href="{{ route('admin.reviews.index') }}" class="btn btn-outline-secondary">
                                    Reset
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            @if($reviews->count() > 0)
                <!-- Bulk Actions -->
                <div class="card shadow-sm mb-3">
                    <div class="card-body py-2">
                        <form action="{{ route('admin.reviews.bulk-action') }}" method="POST" id="bulkActionForm">
                            @csrf
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <input type="checkbox" id="selectAll" class="form-check-input">
                                    <label for="selectAll" class="form-check-label ms-2">Select All</label>
                                </div>
                                <div class="col-auto">
                                    <select name="action" class="form-select form-select-sm" required>
                                        <option value="">Bulk Actions</option>
                                        <option value="approve">Approve</option>
                                        <option value="reject">Reject</option>
                                        <option value="delete">Delete</option>
                                    </select>
                                </div>
                                <div class="col-auto">
                                    <button type="submit" class="btn btn-sm btn-primary">Apply</button>
                                </div>
                                <div class="col-auto ms-auto">
                                    <span class="text-muted small">Total: {{ $reviews->total() }} reviews</span>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Reviews Table -->
                <div class="card shadow-sm">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th width="30">
                                            <input type="checkbox" class="form-check-input" disabled>
                                        </th>
                                        <th>Product</th>
                                        <th>Customer</th>
                                        <th>Rating</th>
                                        <th>Review</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($reviews as $review)
                                        <tr>
                                            <!-- Checkbox -->
                                            <td>
                                                <input type="checkbox"
                                                       name="review_ids[]"
                                                       value="{{ $review->id }}"
                                                       class="form-check-input review-checkbox"
                                                       form="bulkActionForm">
                                            </td>

                                            <!-- Product -->
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <img src="{{ asset('storage/' . $review->product->image) }}"
                                                         alt="{{ $review->product->name }}"
                                                         class="rounded me-2"
                                                         style="width: 50px; height: 50px; object-fit: cover;">
                                                    <div>
                                                        <div class="fw-bold small">{{ Str::limit($review->product->name, 25) }}</div>
                                                        <small class="text-muted">By: {{ $review->product->user->name }}</small>
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
                                            <td style="max-width: 200px;">
                                                <p class="mb-0 small">{{ Str::limit($review->comment, 80) }}</p>
                                                @if($review->seller_reply)
                                                    <div class="mt-2 p-2 bg-light rounded small">
                                                        <strong>Seller:</strong>
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
                                                @if($review->status == 'approved')
                                                    <span class="badge bg-success">Approved</span>
                                                @elseif($review->status == 'pending')
                                                    <span class="badge bg-warning">Pending</span>
                                                @else
                                                    <span class="badge bg-danger">Rejected</span>
                                                @endif
                                            </td>

                                            <!-- Actions -->
                                            <td class="text-center">
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('admin.reviews.show', $review->id) }}"
                                                       class="btn btn-sm btn-info"
                                                       title="View Details">
                                                        <i class="bi bi-eye"></i>
                                                    </a>

                                                    @if($review->status != 'approved')
                                                        <form action="{{ route('admin.reviews.approve', $review->id) }}"
                                                              method="POST"
                                                              class="d-inline">
                                                            @csrf
                                                            @method('PATCH')
                                                            <button type="submit"
                                                                    class="btn btn-sm btn-success"
                                                                    title="Approve">
                                                                <i class="bi bi-check-circle"></i>
                                                            </button>
                                                        </form>
                                                    @endif

                                                    @if($review->status != 'rejected')
                                                        <form action="{{ route('admin.reviews.reject', $review->id) }}"
                                                            method="POST"
                                                          class="d-inline">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit"
                                                                class="btn btn-sm btn-warning"
                                                                title="Reject">
                                                            <i class="bi bi-x-circle"></i>
                                                        </button>
                                                    </form>
                                                @endif

                                                <form action="{{ route('admin.reviews.destroy', $review->id) }}"
                                                      method="POST"
                                                      class="d-inline"
                                                      onsubmit="return confirm('Are you sure you want to delete this review?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            class="btn btn-sm btn-danger"
                                                            title="Delete">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
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
                    <h4 class="mt-3 text-muted">No Reviews Found</h4>
                    <p class="text-muted">There are no reviews matching your criteria.</p>
                </div>
            </div>
        @endif
    </div>
</div>
</div>
<script>
    // Select All Checkbox
    document.getElementById('selectAll')?.addEventListener('change', function() {
        const checkboxes = document.querySelectorAll('.review-checkbox');
        checkboxes.forEach(checkbox => checkbox.checked = this.checked);
    });

    // Bulk Action Form Validation
    document.getElementById('bulkActionForm')?.addEventListener('submit', function(e) {
        const checkedBoxes = document.querySelectorAll('.review-checkbox:checked');
        if (checkedBoxes.length === 0) {
            e.preventDefault();
            alert('Please select at least one review.');
            return false;
        }

        const action = this.querySelector('select[name="action"]').value;
        if (!action) {
            e.preventDefault();
            alert('Please select an action.');
            return false;
        }

        if (action === 'delete') {
            if (!confirm(`Are you sure you want to delete ${checkedBoxes.length} review(s)?`)) {
                e.preventDefault();
                return false;
            }
        }
    });
</script>
@endsection
