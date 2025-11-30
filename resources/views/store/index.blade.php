@extends('layouts.user')

@section('home')
    <!-- main contents -->
    <main> <!-- seller profile -->
        <section>
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="profile-card">
                            <div class="row align-items-center">
                                <div class="col-lg-4 mb-5 mb-lg-0">
                                    <div class="profile-img mx-0 mx-lg-auto"></div>
                                </div>
                                <div class="col-lg-8">
                                    <!-- Nama user dinamis -->
                                    <h2 class="fw-bold mb-3">{{ $user->name }}</h2>

                                    <!-- Seller level dan verified dinamis (asumsi field ada di user) -->
                                    <p class="text-secondary mb-3">
                                        User level {{ $user->seller_level ?? '1' }} |
                                        @if($user->is_verified ?? false) Verified @else Not Verified @endif
                                    </p>

                                    <div class="flex flex-wrap align-items-center gap-4">
                                        <!-- Jumlah stores dinamis -->
                                        <p> <i class="fa-solid fa-shop"></i> <span>{{ $totalStores }} Stores</span> </p>

                                        <!-- Jumlah produk dinamis -->
                                        <p> <i class="fa-solid fa-circle-dot"></i> <span>{{ $totalProducts }} Products</span> </p>

                                        <!-- Rating dinamis -->
                                        <p> <i class="fas fa-star"></i> <span>{{ number_format($averageRating, 2) }} Rated Out of 5 ({{ $totalReviews }})</span> </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="store">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <!-- Judul dinamis berdasarkan nama user -->
                        <h3 class="fw-bold mb-4">Store Own By {{ $user->name }}</h3>
                    </div>

                    <!-- Loop stores dinamis -->
                    @foreach($stores as $store)
                        <div class="col-md-6 col-lg-4">
                            <div class="card-xs">
                                <h5 class="fw-semibold mb-2">{{ $store->name }}</h5>
                                <!-- Jumlah produk per store (asumsi ada field atau hitung) -->
                                <p class="mb-2">{{ $store->products()->count() }} Product</p>
                                <a class="text-primary" href="{{ route('store.show', $store->id) }}">Visit Now</a> <!-- Ganti route sesuai -->
                            </div>
                        </div>
                    @endforeach

                    <!-- Jika tidak ada stores, tampilkan pesan -->
                    @if($stores->isEmpty())
                        <div class="col-12">
                            <p>No stores found.</p>
                        </div>
                    @endif
                </div>
            </div>
        </section>
    </main>
@endsection
