@extends('admin.layouts.app')

@section('title', 'Edit Category')

@section('content2')
<div class="container mt-4">
    <h3>Edit Category</h3>

    <form action="{{ route('admin.category.update', $category->id) }}" method="POST" class="mt-3">
        @csrf
        <div class="mb-3">
            <label class="form-label">Category Name</label>
            <input type="text" name="name" class="form-control" value="{{ $category->name }}" required>
            @error('name') <div class="text-danger small">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Parent Category (optional)</label>
            <select name="parent_id" class="form-select">
                <option value="">None</option>
                @foreach($categories as $cat)
                    @include('admin.categories.partials.option', [
                        'category' => $cat,
                        'prefix' => '',
                        'selected' => $category->parent_id
                    ])
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('admin.category.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
