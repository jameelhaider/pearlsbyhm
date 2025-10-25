<option value="{{ $category->id }}"
    {{ isset($selected) && $selected == $category->id ? 'selected' : '' }}>
    {{ $prefix ?? '' }}{{ $category->name }}
</option>

@if($category->children->count())
    @foreach($category->children as $child)
        @include('admin.categories.partials.option', [
            'category' => $child,
            'prefix' => ($prefix ?? '') . '— ',
            'selected' => $selected ?? null
        ])
    @endforeach
@endif
