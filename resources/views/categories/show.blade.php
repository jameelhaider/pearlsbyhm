@extends('layouts.app')
@php
    $title = $category->name . ' - '.site_name();
@endphp
@section('title', $title)
@section('content')
    <style>
        .btn-outline-black2,
        .btn-solid-black2 {
            display: inline-block;
            font-family: 'Montserrat', Arial, sans-serif;
            letter-spacing: 2px;
            padding: 12px 0px;
            font-size: 15px;
            text-align: center;
            cursor: pointer;
            border-radius: 0;
            box-shadow: none;
            transition: all 0.4s ease;
        }

        .custom-font2 {
            font-family: Arial, sans-serif;
            letter-spacing: 1px;
            font-size: 18px;
        }

        .btn-outline-black2 {
            background-color: #fff;
            color: #000;
            border: 1px solid #000;
        }

        .btn-outline-black2:hover {
            background-color: #000;
            color: #fff;
            border-color: #000;
            opacity: 0.9;
        }

        .btn-solid-black2 {
            background-color: #000;
            color: #fff;
            border: 1px solid transparent;
            text-transform: uppercase;
        }

        .btn-solid-black2:hover {
            background-color: #fff;
            color: #000;
            border-color: #000;
            opacity: 0.9;
        }
    </style>
    <div class="container-fluid">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ url('/') }}">Home</a>
                </li>

                   <li class="breadcrumb-item">
                            <a href="{{ route('products.all') }}">All Products</a>
                        </li>
                @foreach ($breadcrumbs as $crumb)
                    @if (!$loop->last)
                        <li class="breadcrumb-item">
                            <a href="{{ route('category.show', $crumb->url) }}">{{ $crumb->name }}</a>
                        </li>
                    @else
                        <li class="breadcrumb-item active" aria-current="page">{{ $crumb->name }}</li>
                    @endif
                @endforeach
            </ol>
        </nav>


        <h3 class="mb-4 fw-bold" style="font-family: Arial, sans-serif">Products in {{ $category->name }}</h3>

        @if ($products->isEmpty())
            <div class="text-center my-5">
                <i style="font-size: 110px;" class="bi bi-emoji-frown"></i>
                <h2 class="text-dark fw-bold" style="font-family:Arial, sans-serif">No Products Found For Category
                    {{ $category->name }}</h2>
                <p class="text-secondary" style="font-family:Arial, sans-serif">Looks like no products there.
                </p>
                <a href="{{ route('welcome') }}" class="btn-solid-black w-75 nav-link mt-3">
                    BROWSE OTHER PRODUCTS
                </a>
            </div>
        @else
            <div class="row justify-content-around g-2 mt-2">
                @foreach ($products as $product)
                    <div class="col-lg-3 col-12 col-md-4 col-sm-6">
                        <a href="{{ route('prduct.details', ['url' => $product->url]) }}" class="nav-link">
                            <div class="card rounded-0 product-card">
                                <div class="image-wrapper">
                                    <img class="main-image img-fluid" src="{{ asset($product->image) }}"
                                        alt="{{ $product->name }}">
                                    <img class="hover-image img-fluid" src="{{ asset($product->hover_image) }}"
                                        alt="{{ $product->name }}">
                                </div>
                                <h5 class="text-center mt-2 custom-font2">{{ $product->name }}</h5>

                                <div class="d-flex justify-content-center gap-4">
                                    <h6 class="text-center mb-2 custom-font2">
                                        <del>{{ 'Rs.' . number_format($product->actual_price, 2) }}</del>
                                    </h6>
                                    <h6 class="text-center mb-2 custom-font2" style="color: rgb(224, 7, 7)">
                                        {{ 'Rs.' . number_format($product->price, 2) }}</h6>
                                </div>

                                <div class="p-2">
                                    <form action="{{ route('cart.add') }}" method="POST" class="me-1 w-100">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        <input type="hidden" name="qty" value="1">
                                        <button type="submit" class="btn-solid-black2 w-100">Add to Cart</button>
                                    </form>

                                    <form action="{{ route('wishlist.add') }}" method="POST" class="w-100 mt-1">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        <button type="submit" class="btn-outline-black2 w-100">ADD TO WISHLIST</button>
                                    </form>
                                </div>

                            </div>
                        </a>
                    </div>
                @endforeach
            </div>

            <div class="mt-4 d-flex justify-content-center">
                {{ $products->appends(request()->query())->links('pagination::bootstrap-5') }}
            </div>

            <style>
                .product-card .image-wrapper {
                    position: relative;
                    overflow: hidden;
                }

                .product-card .image-wrapper img {
                    width: 100%;
                    display: block;
                    transition: opacity 0.5s ease, transform 0.6s ease;
                    transform: scale(1);
                }

                .product-card .image-wrapper .hover-image {
                    position: absolute;
                    top: 0;
                    left: 0;
                    opacity: 0;
                }

                .product-card:hover .image-wrapper .hover-image {
                    opacity: 1;
                    transform: scale(1.1);
                }

                .product-card:hover .image-wrapper .main-image {
                    opacity: 0;
                    transform: scale(1.1);
                }
            </style>
        @endif
    </div>
@endsection
