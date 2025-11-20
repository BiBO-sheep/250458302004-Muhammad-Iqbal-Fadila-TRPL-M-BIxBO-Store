@extends('layouts.user')
@section('home')
    <<!-- hero -->
        <section id="hero">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-7">
                        <div class="card-lg mb-4 mb-lg-0">
                            <h2>{{ $homepagesetting->discount_percent }}</h2>
                            <h4>{{ $homepagesetting->discount_heading }}</h4>
                            <p>{{ $homepagesetting->discount_subheading }}</p>

                            <div class="float-item">
                                <img src="{{ asset('storage/product_images/LGTsFNGZWk0yugHmJw0GuD6mdK01PkxHKzlrYhoR.png') }}"
                                    alt="">

                            </div>
                        </div>
                    </div>

                    <div class="col-lg-5">
                        <div class="card-sm purple mb-3">
                            <!-- product image -->
                            <div class="product">
                                <img src="{{ asset('storage/product_images/Gc1fczJjvGWUs8UVxgduTf2fW635MJ23zcFGiBcg.png') }}"
                                    alt="">

                            </div>

                            <div>
                                <h2>{{ $homepagesetting->featuredProduct1->product_name }}</h2>
                                <p>{{ $homepagesetting->featuredProduct1->regular_price }}$</p>
                            </div>
                        </div>

                        <div class="card-sm sky">
                            <div>
                                <h2>{{ $homepagesetting->featuredProduct2->product_name }}</h2>
                                <p>{{ $homepagesetting->featuredProduct2->regular_price }}$</p>
                            </div>

                            <!-- product image -->
                            <div class="product">
                                <img src="{{ asset('storage/product_images/LjoIZu1nAQ48XysKgRYB4yBs4cBgfKdU6q87ZB46.png') }}"
                                    alt="">
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        @livewire('HomeProductFilterComponent')
    @endsection
