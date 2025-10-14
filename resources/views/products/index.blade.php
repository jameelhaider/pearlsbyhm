@extends('layouts.app')

@section('title', 'All Products - Pearls By HM')

@section('content')
<style>
        .btn-outline-black2,
        .btn-solid-black2 {
            display: inline-block;
            font-family: 'Montserrat', Arial, sans-serif;
            letter-spacing: 2px;
            padding: 8px 0px;
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
        <div class="row justify-content-around g-2 mt-2">
            @foreach ($products as $product)
                <div class="col-lg-3 col-12 col-md-4 col-sm-6">
                    <a href="{{ route('prduct.details', ['id' => $product->id]) }}" class="nav-link">
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

        /* Hover effect */
        .product-card:hover .image-wrapper .hover-image {
            opacity: 1;
            transform: scale(1.1);
        }

        .product-card:hover .image-wrapper .main-image {
            opacity: 0;
            transform: scale(1.1);
        }
    </style>
@endsection
