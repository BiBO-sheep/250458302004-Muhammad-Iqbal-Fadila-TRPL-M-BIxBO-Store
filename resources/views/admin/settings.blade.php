@extends('admin.layouts.layout')
@section('admin_page_title')
Settings - Admin Panel
@endsection

@section('admin_layout')
    <<div class="row mt-3">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h5 class="card-title mb-0">Home Page Setting</h5>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if (session('massage'))
    <div class="alert alert-success">
        {{ session('massage') }}
                    @endif




                    <form action="{{ route('store.cat') }}" method="POST">
                        @csrf
                        <label for="discounted_product_id" class="fw-bold mb-2">Select Discounted Product</label>
<select name="discounted_product_id" id="discounted_product_id" class="form-control">
    @foreach($products as $product)
        <option value="{{ $product->id }}">{{ $product->product_name }}</option>
    @endforeach
</select>

<label for="discount_percent" class="fw-bold mb-2">Discount Percent</label>
<input type="number" class="form-control" name="discount_percent">

<label for="discount_heading" class="fw-bold mb-2">Provide Discount Heading</label>
<input type="text" class="form-control" name="discount_heading">

<label for="discount_subheading" class="fw-bold mb-2">Provide Discount Sub Text</label>
<input type="text" class="form-control" name="discount_subheading">

<label for="featured_product_1_id" class="fw-bold mb-2">Select Featured Product 1</label>
<select name="featured_product_1_id" id="featured_product_1_id" class="form-control">
    @foreach($products as $product)
        <option value="{{ $product->id }}">{{ $product->product_name }}</option>
    @endforeach
</select>

<label for="featured_product_2_id" class="fw-bold mb-2">Select Featured Product 2</label>
<select name="featured_product_2_id" id="featured_product_2_id" class="form-control">
    @foreach($products as $product)
        <option value="{{ $product->id }}">{{ $product->product_name }}</option>
    @endforeach
</select>

<button type="submit" class="btn btn-primary w-100 mt-2">Update Homepage Setting</button>


                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
