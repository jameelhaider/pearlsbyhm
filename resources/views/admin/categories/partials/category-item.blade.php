<li class="list-group-item">
    <div class="d-flex justify-content-between align-items-center">
        <span>{{ $prefix . $category->name }}</span>
        <div>
            <a href="{{ route('admin.category.edit', $category->id) }}" class="btn btn-sm btn-outline-secondary">Edit</a>
            <a href="{{ route('admin.category.delete', $category->id) }}" class="btn btn-sm btn-outline-danger"
                onclick="return confirm('Are you sure you want to delete this category?')">Delete</a>
        </div>
    </div>

    @if($category->children->count())
        <ul class="list-group mt-2">
            @foreach($category->children as $child)
                @include('admin.categories.partials.category-item', ['category' => $child, 'prefix' => $prefix . '— '])
            @endforeach
        </ul>
    @endif
</li>
