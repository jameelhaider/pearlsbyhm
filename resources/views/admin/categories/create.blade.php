@extends('admin.layouts.app')

@section('title', 'Add Category')

@section('content2')
<div class="container mt-4">
    <h3>Add New Category</h3>

    <form action="{{ route('admin.category.submit') }}" method="POST" class="mt-3">
        @csrf
        <div class="mb-3">
            <label class="form-label">Category Name</label>
            <input type="text" name="name" class="form-control" required>
            @error('name') <div class="text-danger small">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Parent Category (optional)</label>
            <select name="parent_id" class="form-select">
                <option value="">None</option>
                @foreach($categories as $category)
                    @include('admin.categories.partials.option', ['category' => $category, 'prefix' => ''])
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Save Category</button>
        <a href="{{ route('admin.category.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
