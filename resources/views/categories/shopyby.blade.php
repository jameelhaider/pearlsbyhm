@extends('layouts.app')
@section('title', 'Shop By Category - Pearls By HM')

@section('content')
<div class="container py-4">
    <!-- ===== Breadcrumb ===== -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Shop By Category</li>
        </ol>
    </nav>

    <h4 class="text-center fw-bold mb-4" style="font-family: Arimo, sans-serif; letter-spacing: 1px;">
        Shop By Category
    </h4>

    <!-- ===== Category Tree View ===== -->
    <div class="category-tree card bg-white rounded-0 shadow-sm p-3">
        <ul class="tree list-unstyled m-0">
            @foreach (getCategories() as $category)
                <li class="position-relative ps-3 mb-3 border-bottom pb-2">
                    <div class="category-node d-flex align-items-center justify-content-between category-toggle" role="button">
                        <div class="d-flex align-items-center gap-2">
                            @if ($category->children->count() > 0)
                                <i class="bi bi-chevron-right me-1 toggle-icon"></i>
                            @endif
                            <a href="{{ url('category/' . $category->url) }}" class="fw-semibold text-dark text-decoration-none">
                                {{ $category->name }}
                            </a>
                        </div>
                        <a href="{{ url('category/' . $category->url) }}" class="btn btn-outline-dark rounded-0">
                            View Products
                        </a>
                    </div>

                    @if ($category->children->count() > 0)
                        <ul class="tree list-unstyled ms-4 mt-2 border-start ps-3 d-none">
                            @foreach ($category->children as $subcategory)
                                <li class="position-relative mb-2 ps-2">
                                    <div class="subcategory-node d-flex align-items-center justify-content-between category-toggle" role="button">
                                        <div class="d-flex align-items-center gap-2">
                                            @if ($subcategory->children->count() > 0)
                                                <i class="bi bi-chevron-right me-1 toggle-icon"></i>
                                            @endif
                                            <a href="{{ url('category/' . $subcategory->url) }}" class="text-dark text-decoration-none">
                                                {{ $subcategory->name }}
                                            </a>
                                        </div>
                                        <a href="{{ url('category/' . $subcategory->url) }}" class="btn btn-outline-dark rounded-0">
                                            View Products
                                        </a>
                                    </div>

                                    @if ($subcategory->children->count() > 0)
                                        <ul class="tree list-unstyled ms-4 mt-2 border-start ps-3 d-none">
                                            @foreach ($subcategory->children as $subsubcategory)
                                                <li class="ps-2 mb-1 d-flex justify-content-between align-items-center">
                                                    <a href="{{ url('category/' . $subsubcategory->url) }}" class="text-dark text-decoration-none small">
                                                        {{ $subsubcategory->name }}
                                                    </a>
                                                    <a href="{{ url('category/' . $subsubcategory->url) }}" class="btn btn-outline-dark rounded-0">
                                                        View Products
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </li>
            @endforeach
        </ul>
    </div>
</div>

<style>
    .category-tree {
        font-family: 'Arimo', sans-serif;
    }

    .category-toggle {
        cursor: pointer;
        transition: background 0.15s ease;
        padding: 6px 8px;
        border-radius: 6px;
    }

    .category-toggle:hover {
        background-color: #f8f9fa;
    }

    .toggle-icon {
        transition: transform 0.25s ease;
        font-size: 0.9rem;
    }

    .toggle-open .toggle-icon {
        transform: rotate(90deg);
    }

    /* === Tree Lines === */
    .tree ul {
        border-left: 1px dashed #ccc;
    }

    .tree li {
        position: relative;
    }

    .tree li::before {
        content: "";
        position: absolute;
        top: 0.9em;
        left: -1.1rem;
        width: 1rem;
        height: 1px;
        background: #ccc;
    }

    .tree li:last-child::before {
        background: linear-gradient(to right, #ccc 50%, transparent 50%);
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.category-toggle').forEach(row => {
            row.addEventListener('click', function (e) {
                // Avoid toggling when clicking "View Products"
                if (e.target.closest('a.btn')) return;

                const parentLi = this.closest('li');
                const subList = parentLi.querySelector('ul');
                if (subList) {
                    subList.classList.toggle('d-none');
                    this.classList.toggle('toggle-open');
                }
            });
        });
    });
</script>
@endsection
