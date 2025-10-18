@extends('admin.layouts.app')
@section('admin_title', 'Admin | Categories')
@section('content2')
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3>All Categories</h3>
            <a href="{{ route('admin.category.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Add Category
            </a>
        </div>

        @if ($categories->count())
            <ul class="list-group">
                @foreach ($categories as $category)
                    @include('admin.categories.partials.category-item', [
                        'category' => $category,
                        'prefix' => '',
                    ])
                @endforeach
            </ul>
        @else
            <div class="alert alert-info">No categories found.</div>
        @endif
    </div>
@endsection
