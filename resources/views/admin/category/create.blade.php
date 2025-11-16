@extends('admin.layouts.layout')

@section('admin_page_title')
    Create Category - Admin Panel
@endsection

@section('admin_layout')
    <h3>Create Category</h3>

    <div class="row mt-3">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h5 class="card-title mb-0">Create Category</h5>
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
                        <label for="category_name" class="form-label fw-bold mb-2">Give Name of Your Category</label>
                        <input type="text" name="category_name" class="form-control" placeholder="computer">

                        <button type="submit" class="btn btn-primary w-100 mt-2">Save Category</button>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
