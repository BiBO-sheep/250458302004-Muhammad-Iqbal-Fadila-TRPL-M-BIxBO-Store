@extends('admin.layouts.layout')

@section('admin_page_title', 'Create Discount - Admin Panel')

@section('admin_layout')
    <h3>Create Discount Page</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('homepage_setting.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Discounted Product</label>
            <select name="discounted_product_id" class="form-control">
                @foreach($products as $product)
                    <option value="{{ $product->id }}"
                        @if(isset($setting) && $setting->discounted_product_id == $product->id) selected @endif>
                        {{ $product->product_name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Discount Percent</label>
            <input type="number" name="discount_percent" class="form-control"
                   value="{{ $setting->discount_percent ?? '' }}">
        </div>

        <div class="mb-3">
            <label>Discount Heading</label>
            <input type="text" name="discount_heading" class="form-control"
                   value="{{ $setting->discount_heading ?? '' }}">
        </div>

        <div class="mb-3">
            <label>Discount Subheading</label>
            <input type="text" name="discount_subheading" class="form-control"
                   value="{{ $setting->discount_subheading ?? '' }}">
        </div>

        <div class="mb-3">
            <label>Featured Product 1</label>
            <select name="featured_product_1_id" class="form-control">
                <option value="">-- None --</option>
                @foreach($products as $p)
                    <option value="{{ $p->id }}"
                        @if(isset($setting) && $setting->featured_product_1_id == $p->id) selected @endif>
                        {{ $p->product_name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Featured Product 2</label>
            <select name="featured_product_2_id" class="form-control">
                <option value="">-- None --</option>
                @foreach($products as $p)
                    <option value="{{ $p->id }}"
                        @if(isset($setting) && $setting->featured_product_2_id == $p->id) selected @endif>
                        {{ $p->product_name }}
                    </option>
                @endforeach
            </select>
        </div>

        <button class="btn btn-primary">Save</button>
    </form>
@endsection
