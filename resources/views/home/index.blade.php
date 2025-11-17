@extends('layouts.user')
@section('home')
    <<!-- hero -->
      <section id="hero">
        <div class="container">
          <div class="row align-items-center">
            <div class="col-lg-7">
              <div class="card-lg mb-4 mb-lg-0">
                <h2>75%</h2>
                <h4>Flat Discount</h4>
                <p>Because of store opening carnival, Ecipse providing a huge discounted sell</p>

                <div class="float-item">
                  <img src="{{ asset('home_asset/img/shoe.png') }}" alt="">
                </div>
              </div>
            </div>

            <div class="col-lg-5">
              <div class="card-sm purple mb-3">
                <!-- product image -->
                <div class="product">
                  <img src="{{ asset('home_asset/img/beanbag.png') }}" alt="">
                </div>

                <div>
                  <h2>Comfy</h2>
                  <p>Bean Bag Chair</p>
                </div>
              </div>

              <div class="card-sm sky">
                <div>
                  <h2>VR</h2>
                  <p>Glasses</p>
                </div>

                <!-- product image -->
                <div class="product">
                  <img src="{{ asset('home_asset/img/vr-glass.png') }}" alt="">
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      @livewire('HomeProductFilterComponent')
@endsection
