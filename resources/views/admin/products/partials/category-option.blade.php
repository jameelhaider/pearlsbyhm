<option value="{{ $category->id }}"
    @if(isset($selected) && $selected == $category->id) selected @endif>
    {{ $prefix . $category->name }}
</option>

@if ($category->children && $category->children->count())
    @foreach ($category->children as $child)
        @include('admin.products.partials.category-option', [
            'category' => $child,
            'prefix' => $prefix . '-- ',
            'selected' => $selected ?? null
        ])
    @endforeach
@endif
