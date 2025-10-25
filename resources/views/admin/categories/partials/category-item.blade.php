<li class="tree-item">
    <div class="tree-row">
        <span class="tree-name">{{ $category->name }}</span>

        <div>
            <a href="{{ route('admin.category.edit', $category->id) }}" class="btn btn-sm btn-outline-secondary">Edit</a>
            <a href="{{ route('admin.category.delete', $category->id) }}" class="btn btn-sm btn-outline-danger"
               onclick="return confirm('Delete this category?')">
               Delete
            </a>
        </div>
    </div>

    @if($category->children->count())
        <ul class="tree-list">
            @foreach($category->children as $child)
                @include('admin.categories.partials.category-item', ['category' => $child])
            @endforeach
        </ul>
    @endif
</li>
