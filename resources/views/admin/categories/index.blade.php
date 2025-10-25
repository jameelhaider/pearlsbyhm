@extends('admin.layouts.app')
@section('admin_title', 'Admin | Categories')

@section('content2')
<style>
    .tree-list {
        list-style: none;
        padding-left: 25px;
        position: relative;
    }

    .tree-item {
        position: relative;
        padding: 6px 0;
        margin-left: 15px;
    }

    .tree-item::before {
        content: "";
        position: absolute;
        top: -10px;
        left: -15px;
        border-left: 1px solid #999;
        height: calc(100% + 20px);
    }

    .tree-item::after {
        content: "";
        position: absolute;
        top: 12px;
        left: -15px;
        width: 15px;
        border-top: 1px solid #999;
    }

    .tree-item:last-child::before {
        height: 12px;
    }

    .tree-row {
        display: flex;
        justify-content: space-between;
        width: 100%;
        border-bottom: 1px dashed #ccc;
        padding-bottom: 4px;
    }

    .tree-name {
        font-weight: 500;
        white-space: nowrap;
    }
</style>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>All Categories</h3>
        <a href="{{ route('admin.category.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Add Category
        </a>
    </div>

    @if($categories->count())
        <ul class="tree-list">
            @foreach($categories as $category)
                @include('admin.categories.partials.category-item', ['category' => $category])
            @endforeach
        </ul>
    @else
        <div class="alert alert-info">No categories found.</div>
    @endif
</div>
@endsection
