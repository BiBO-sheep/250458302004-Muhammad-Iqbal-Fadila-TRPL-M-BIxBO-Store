@extends('layouts.user')
@section('home')
    <!-- breadcrumb -->
    <div class="container">
      <div class="row">
        <div class="col-12">
          <p class="breadcrumb-title">Home > <span>Shoe</span></p>
        </div>
      </div>
    </div>

    <!-- main contents -->
    <main>
      <!-- product filter -->
      <section>
        <div class="container">
          <div class="row">

            <div class="col-12 d-block d-lg-none">
              <a class="filter-btn" href="#!">
                <span>Filters</span>
                <i class="fa-solid fa-sliders"></i>
              </a>
            </div>

            <!-- filters -->
            <div class="col-lg-4 filters-wrap">

              <a class="d-block d-lg-none filter-close" href="#!">
                <i class="fa-regular fa-rectangle-xmark"></i>
              </a>

              <!-- category -->
              <div class="filter-card">
                <h5 class="mb-3">Product Category</h5>

                <div class="form-check mb-2">
                  <input class="form-check-input" type="checkbox" value="" id="accessories">
                  <label class="form-check-label" for="accessories">
                    Accessories
                  </label>
                </div>

                <div class="form-check mb-2">
                  <input class="form-check-input" type="checkbox" value="" id="beauty">
                  <label class="form-check-label" for="beauty">
                    Beauty
                  </label>
                </div>

                <div class="form-check mb-2">
                  <input class="form-check-input" type="checkbox" value="" id="electronics">
                  <label class="form-check-label" for="electronics">
                    Electronics
                  </label>
                </div>

                <div class="form-check mb-2">
                  <input class="form-check-input" type="checkbox" value="" id="fashion">
                  <label class="form-check-label" for="fashion">
                    Fashion
                  </label>
                </div>

                <div class="form-check mb-2">
                  <input class="form-check-input" type="checkbox" value="" id="kids">
                  <label class="form-check-label" for="kids">
                    Kids
                  </label>
                </div>

                <div class="form-check mb-2">
                  <input class="form-check-input" type="checkbox" value="" id="shoe">
                  <label class="form-check-label" for="shoe">
                    Shoes
                  </label>
                </div>

                <div class="form-check mb-2">
                  <input class="form-check-input" type="checkbox" value="" id="sports">
                  <label class="form-check-label" for="sports">
                    Sports
                  </label>
                </div>

                <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="" id="watches">
                  <label class="form-check-label" for="watches">
                    Watches
                  </label>
                </div>
              </div>

              <!-- price range -->
              <div class="filter-card">
                <h5 class="mb-3">Price Filter</h5>

                <!-- range -->
                <input type="range" class="form-range mb-2" id="">

                <!-- button -->
                <div class="flex flex-wrap align-items-center justify-content-between gap-3">
                  <a class="btn-sm" href="#!">Filter</a>

                  <p>Price: $0 - $1,040</p>
                </div>
              </div>

              <!-- product status -->
              <div class="filter-card">
                <h5 class="mb-3">Product Status</h5>

                <div class="form-check mb-2">
                  <input class="form-check-input" type="checkbox" value="" id="in-stock">
                  <label class="form-check-label" for="in-stock">
                    In Stock
                  </label>
                </div>

                <div class="form-check mb-2">
                  <input class="form-check-input" type="checkbox" value="" id="on-sale">
                  <label class="form-check-label" for="on-sale">
                    On Sale
                  </label>
                </div>

                <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="" id="discontinued">
                  <label class="form-check-label" for="discontinued">
                    Discontinued
                  </label>
                </div>
              </div>

              <!-- By Shop -->
              <div class="filter-card">
                <h5 class="mb-3">Product Status</h5>

                <div class="form-check mb-2">
                  <input class="form-check-input" type="checkbox" value="" id="">
                  <label class="form-check-label" for="">
                    Asib's Shop
                  </label>
                </div>

                <div class="form-check mb-2">
                  <input class="form-check-input" type="checkbox" value="" id="">
                  <label class="form-check-label" for="">
                    Shakib's Shop
                  </label>
                </div>

                <div class="form-check mb-2">
                  <input class="form-check-input" type="checkbox" value="" id="">
                  <label class="form-check-label" for="">
                    XYZ Shop
                  </label>
                </div>

                <div class="form-check mb-2">
                  <input class="form-check-input" type="checkbox" value="" id="">
                  <label class="form-check-label" for="">
                    Asib's Shop
                  </label>
                </div>

                <div class="form-check mb-2">
                  <input class="form-check-input" type="checkbox" value="" id="">
                  <label class="form-check-label" for="">
                    Shakib's Shop
                  </label>
                </div>

                <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="" id="">
                  <label class="form-check-label" for="">
                    XYZ Shop
                  </label>
                </div>
              </div>
            </div>

            <!-- products -->
            <div class="col-lg-8 mb-5">
              <div class="row">
               @forelse ($products as $product)
                    <!-- products -->
                    <div class="col-md-6 col-lg-4">
                        <div class="card-md">
                            <!-- image -->
                            <div class="product-img">
                                <img class="object-fit-contain" style="height: 200px;"
                                    src="{{ asset('storage/product_images/LGTsFNGZWk0yugHmJw0GuD6mdK01PkxHKzlrYhoR.png') }}"
                                    alt="">
                            </div>

                            <h4 class="fw-semibold mb-2">{{ $product->product_name }}</h4>
                            <h4 class="fw-light mb-4">${{ number_format($product->discounted_price, 2) }}</h4>

                            <!-- add to cart -->
                            <div class="add-cart-wrap" x-data="{quantity: 1}">
                                <input type="number" min="1" max="{{ $product->stock_quantity }}" x-model="quantity" value="1">
                                <a class="btn-md shadow-none" href="javascript:void(0)" @click="$dispatch('addToCartFromAnywhere', {productId: {{ $product->id }}, quantity: quantity})">Add to Cart</a>
                            </div>

                            <!-- cta -->
                            <div class="card-md-cta">
                                <a href="#!">
                                    <i class="fas fa-heart active"></i>
                                </a>

                                <a href="#!">
                                    <i class="fa-solid fa-code-compare active"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                @empty

                    <div class="col-12 text-center">
                        <h5>No Product Found for this category</h5>
                    </div>
                @endforelse
              </div>
            </div>
          </div>
        </div>
      </section>


        @livewire('HomeProductFilterComponent')
    @endsection
