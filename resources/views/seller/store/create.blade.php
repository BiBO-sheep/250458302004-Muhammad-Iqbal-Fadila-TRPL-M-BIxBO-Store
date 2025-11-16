@extends('seller.layouts.layout')

@section('seller_page_title')
    Create New Store - Seller Panel
@endsection

@section('seller_layout')


    <div class="row mt-3">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h5 class="card-title mb-0">Create Store</h5>
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




                    <form action="{{ route('create.store') }}" method="POST">
                        @csrf
                        <label for="store_name" class="fw-bold mb-2">Give Name of Your Store</label>
                        <input type="text" name="store_name" class="form-control" placeholder="Minou Creme">

                         <label for="details" class="fw-bold mb-2">Description of Your Store</label>
                        <textarea id="details" name="details" cols="30" rows="10" class="form-control"></textarea>

                         <label for="store_name" class="fw-bold mb-2">Slug</label>
                        <input type="text" name="slug" class="form-control" placeholder="Minou Creme">

                        <button type="submit" class="btn btn-primary w-100 mt-2">Create Store</button>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
