<!-- Di sidebar seller -->
<li class="nav-item">
    <a class="nav-link {{ request()->routeIs('seller.reviews.*') ? 'active' : '' }}"
       href="{{ route('seller.reviews.index') }}">
        <i class="bi bi-star me-2"></i>
        <span>Reviews</span>
        @php
            $pendingReviews = \App\Models\Review::whereHas('product', function($q) {
                $q->where('user_id', Auth::id());
            })->whereNull('seller_reply')->count();
        @endphp
        @if($pendingReviews > 0)
            <span class="badge bg-warning ms-2">{{ $pendingReviews }}</span>
        @endif
    </a>
</li>
