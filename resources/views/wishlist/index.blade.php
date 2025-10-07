@extends('layouts.app')

@section('title', 'Your Wishlist - Pearls By HM')

@section('content')
    <div class="container-fluid px-5 py-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Your Wishlist</li>
            </ol>
        </nav>

        <h3 class="mb-4 fw-bold" style="font-family: Arial, sans-serif">Your Wishlist</h3>

        @if ($wishlistItems->isEmpty())
            <div class="alert alert-info text-center">
                Your wishlist is empty 😔
            </div>
        @else
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
                    @foreach ($wishlistItems as $product)
                        <div class="col-lg-3 col-12 col-md-4 col-sm-6">
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
                                        <input type="hidden" name="product_id" value="{{ $product->product_id }}">
                                        <button type="submit" class="btn-solid-black2 w-100">Move to Cart</button>
                                    </form>

                                      <form action="{{ route('wishlist.remove', $product->wishlist_id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-outline-black2 w-100 mt-1">REMOVE FROM WISHLIST</button>
                                    </form>
                                </div>

                            </div>
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



            {{-- <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Price</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($wishlistItems as $index => $wishlist)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td><img height="70px" width="60px" src="{{ asset($wishlist->image) }}" alt="">
                                </td>
                                <td>{{ $wishlist->name }}</td>
                                <td>{{ number_format($wishlist->price, 2) }}</td>
                                <td class="d-flex">
                                    <form action="{{ route('cart.add') }}" method="POST" class="me-1">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $wishlist->product_id }}">
                                        <button type="submit" class="btn btn-sm btn-primary">Move to Cart</button>
                                    </form>
                                    <form action="{{ route('wishlist.remove', $wishlist->wishlist_id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Remove</button>
                                    </form>

                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div> --}}


        @endif
    </div>
@endsection
