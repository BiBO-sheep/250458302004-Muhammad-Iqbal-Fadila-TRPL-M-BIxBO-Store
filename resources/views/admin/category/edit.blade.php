@extends('admin.layouts.layout')

@section('admin_page_title')
    Edit Category
@endsection

@section('admin_layout')

    <div class="row mt-3">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h5 class="card-title mb-0">Edit Category</h5>
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

                    @if (session('message'))
                        <div class="alert alert-success">
                            {{ session('message') }}
                    @endif

                    <form action="{{ route('update.cat', $category_info->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <label for="category_name" class="form-label fw-bold mb-2">Give Name of Your Category</label>
                        <input type="text" name="category_name" class="form-control"
                            value="{{ $category_info->category_name }}">

                        <button type="submit" class="btn btn-primary w-100 mt-2">Update Category</button>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
