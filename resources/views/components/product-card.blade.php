<!-- Di dalam product card, tambahkan setelah product name -->
<div class="mb-2">
    @if($product->totalReviews() > 0)
        <div class="d-flex align-items-center">
            <div class="me-2">
                @for($i = 1; $i <= 5; $i++)
                    <i class="bi bi-star{{ $i <= round($product->averageRating()) ? '-fill' : '' }} text-warning small"></i>
                @endfor
            </div>
            <small class="text-muted">
                {{ number_format($product->averageRating(), 1) }}
                ({{ $product->totalReviews() }})
            </small>
        </div>
    @else
        <small class="text-muted">No reviews yet</small>
    @endif
</div>
