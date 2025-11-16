@extends('seller.layouts.layout')

@section('seller_page_title')
    Manage Store
@endsection

@section('seller_layout')


    <div class="row mt-3">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h5 class="card-title mb-0">All Store Created By Your</h5>
                </div>

                 @if (session('message'))
                        <div class="alert alert-success my-2">
                            {{ session('message') }}
                    @endif

                <div class="card-body">
                    <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Store Name</th>
                                <th scope="col">Slug</th>
                                <th scope="col">Description</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($stores as $store)
                             <tr>
                                    <td>{{ $store->id }}</td>
                                    <td>{{ $store->store_name }}</td>
                                    <td>{{ $store->slug }}</td>
                                    <td>{{ $store->details }}</td>
                                    <td>
                                        <form action="" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Delete</button>
                                        </form>
                                        <a href="" class="btn btn-info">Edit</a>
                                    </td>
                                </tr>

                            @endforeach


                        </tbody>
                    </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
