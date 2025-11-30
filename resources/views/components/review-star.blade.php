@props(['rating', 'size' => 'md'])

@php
    $sizeClass = match($size) {
        'sm' => 'small',
        'lg' => 'fs-5',
        'xl' => 'fs-4',
        default => ''
    };
@endphp

<div class="review-stars {{ $sizeClass }}">
    @for($i = 1; $i <= 5; $i++)
        <i class="bi bi-star{{ $i <= $rating ? '-fill' : '' }} text-warning"></i>
    @endfor
</div>
