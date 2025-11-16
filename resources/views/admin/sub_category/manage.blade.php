@extends('admin.layouts.layout')

@section('admin_page_title')
    Manage Sub Category
@endsection

@section('admin_layout')


    <div class="row mt-3">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h5 class="card-title mb-0">All Sub Category</h5>
                </div>

                 @if (session('message'))
                        <div class="alert alert-success my-2">
                            {{ session('message') }}
                    @endif

                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>SubCategory</th>
                                <th>Category</th>
                                <th>Created At</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($subcategories as $subcat)
                             <tr>
                                    <td>{{ $subcat->id }}</td>
                                    <td>{{ $subcat->subcategory_name }}</td>
                                    <td>{{ $subcat->category->category_name }}</td>
                                    <td><a href="{{ route('show.subcat', $subcat->id) }}" class="btn btn-info">Edit</a></td>
                                    <td>
                                        <form action="{{ route('delete.subcat', $subcat->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger" value="Delete">Delete</button>
                                        </form>

                                    </td>
                                </tr>

                            @endforeach


                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
