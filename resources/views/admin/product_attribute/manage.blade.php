@extends('admin.layouts.layout')

@section('admin_page_title')
    Manage Default attribute - Admin Panel
@endsection

@section('admin_layout')


    <div class="row mt-3">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h5 class="card-title mb-0">All Defaul Attribute</h5>
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
                                <th scope="col">Attribute</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($allattributes as $attribute)
                             <tr>
                                    <td>{{ $attribute->id }}</td>
                                    <td>{{ $attribute->attribute_value }}</td>
                                    <td>
                                        <form action="{{ route('delete.attribute', $attribute->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Delete</button>
                                        </form>
                                        <a href="{{ route('show.attribute', $attribute->id) }}" class="btn btn-info">Edit</a>
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
