@extends('layouts.app')
@section('title', 'Product | ' . $product->name)

@section('content')
    <div class="container-fluid px-5 py-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ url('/') }}">Home</a>
                </li>

                <li class="breadcrumb-item">
                    <a href="{{ route('products.all') }}">All Products</a>
                </li>

                @foreach ($breadcrumbs as $cat)
                    <li class="breadcrumb-item">
                        <a href="{{ route('category.show', ['url' => $cat->url]) }}">{{ $cat->name }}</a>
                    </li>
                @endforeach

                <li class="breadcrumb-item active" aria-current="page">
                    {{ $product->name }}
                </li>
            </ol>
        </nav>



        <div class="row justify-content-center align-items-start">
            <div class="col-md-5 text-center mb-4 mb-md-0">

                <!-- ✅ PRODUCT IMAGE CAROUSEL -->
                <div id="productCarousel" class="carousel slide" data-bs-ride="carousel">

                    <div class="carousel-inner">

                        <div class="carousel-item active">
                            <div class="image-zoom-container">
                                <img src="{{ asset($product->image) }}" class="d-block w-100 img-fluid rounded shadow-sm">
                            </div>
                        </div>

                        @if (!empty($product->hover_image))
                            <div class="carousel-item">
                                <div class="image-zoom-container">
                                    <img src="{{ asset($product->hover_image) }}"
                                        class="d-block w-100 img-fluid rounded shadow-sm">
                                </div>
                            </div>
                        @endif

                        @foreach ($product_images as $image)
                            <div class="carousel-item">
                                <div class="image-zoom-container">
                                    <img src="{{ asset($image->image_path) }}"
                                        class="d-block w-100 img-fluid rounded shadow-sm">
                                </div>
                            </div>
                        @endforeach


                    </div>

                    <!-- ✅ Controls -->
                    <button class="carousel-control-prev" type="button" data-bs-target="#productCarousel"
                        data-bs-slide="prev">
                        <span class="carousel-control-prev-icon"></span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#productCarousel"
                        data-bs-slide="next">
                        <span class="carousel-control-next-icon"></span>
                    </button>

                </div>

                <!-- ✅ Thumbnail Indicators -->
                <div class="mt-3 d-flex justify-content-center gap-2 flex-wrap">

                    <!-- Main Thumbnail -->
                    <img src="{{ asset($product->image) }}" data-bs-target="#productCarousel" data-bs-slide-to="0"
                        class="img-thumbnail rounded"
                        style="width: 70px; height: 70px; object-fit: cover; cursor: pointer;">

                    @php $thumbIndex = 1; @endphp

                    <!-- Hover Thumbnail -->
                    @if (!empty($product->hover_image))
                        <img src="{{ asset($product->hover_image) }}" data-bs-target="#productCarousel"
                            data-bs-slide-to="{{ $thumbIndex++ }}" class="img-thumbnail rounded"
                            style="width: 70px; height: 70px; object-fit: cover; cursor: pointer;">
                    @endif

                    <!-- Loop Extra Thumbnails -->
                    @foreach ($product_images as $image)
                        <img src="{{ asset($image->image_path) }}" data-bs-target="#productCarousel"
                            data-bs-slide-to="{{ $thumbIndex++ }}" class="img-thumbnail rounded"
                            style="width: 70px; height: 70px; object-fit: cover; cursor: pointer;">
                    @endforeach

                </div>
            </div>


            <div class="col-md-6">
                <h3 class="fw-bold" style="font-family: Arimo, sans-serif;">{{ $product->name }}</h3>

                <div class="my-3">
                    <span class="text-dark fs-4 fw-bold">Rs. {{ number_format($product->price) }}</span>
                </div>

                <div class="mt-4">
                    <form action="{{ route('cart.add') }}" method="POST">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">

                        <div class="input-group mb-3" style="max-width: 200px;">
                            <button type="button" class="btn btn-outline-dark rounded-0" id="decreaseQty"
                                disabled>-</button>
                            <input type="text" name="qty" id="qtyInput" class="form-control text-center"
                                value="1" readonly min="1">
                            <button type="button" class="btn btn-outline-dark rounded-0" id="increaseQty">+</button>
                        </div>

                        <button type="submit" class="btn-solid-black w-100">
                            <i class="bi bi-cart-plus"></i> Add to Cart
                        </button>
                    </form>
                </div>

                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const qtyInput = document.getElementById('qtyInput');
                        const decreaseBtn = document.getElementById('decreaseQty');
                        const increaseBtn = document.getElementById('increaseQty');

                        increaseBtn.addEventListener('click', function() {
                            let value = parseInt(qtyInput.value);
                            value++;
                            qtyInput.value = value;
                            if (value > 1) decreaseBtn.disabled = false;
                        });

                        decreaseBtn.addEventListener('click', function() {
                            let value = parseInt(qtyInput.value);
                            if (value > 1) {
                                value--;
                                qtyInput.value = value;
                            }
                            if (value === 1) decreaseBtn.disabled = true;
                        });
                    });
                </script>

                <!-- ✅ PRODUCT DESCRIPTION ACCORDION -->
                <div class="mt-4">
                    <div class="accordion" id="productDetailsAccordion">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingDescription">
                                <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseDescription" aria-expanded="false"
                                    aria-controls="collapseDescription">
                                    Product Description
                                </button>
                            </h2>
                            <div id="collapseDescription" class="accordion-collapse collapse"
                                aria-labelledby="headingDescription" data-bs-parent="#productDetailsAccordion">
                                <div class="accordion-body">
                                    {!! nl2br(e($product->description)) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ✅ END DESCRIPTION ACCORDION -->

            </div>
        </div>
    </div>


    <div class="container-fluid">
        <h3 class="text-center mt-4 fw-bold" style="font-family: Arial, sans-serif">Related Products</h3>
        @if ($related_products->count() > 0)
            <div class="row justify-content-around g-2 mt-2">
                @foreach ($related_products as $product)
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
        @else
            <div class="text-center my-5">
                <i style="font-size: 110px;" class="bi bi-emoji-frown"></i>
                <h2 class="text-dark fw-bold" style="font-family:Arial, sans-serif">No Related Products Found...</h2>
                <p class="text-secondary" style="font-family:Arial, sans-serif">Looks like no products there.
                </p>
                <a href="{{ route('products.all') }}" class="btn-solid-black w-75 nav-link mt-3">
                    BROWSE OTHERS
                </a>
            </div>

        @endif

    </div>



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

    <style>
        .image-zoom-container {
            position: relative;
            overflow: hidden;
        }

        .image-zoom-container img {
            width: 100%;
            transition: transform 0.1s ease-in-out;
        }

        .image-zoom-container.zoom-active img {
            transform: scale(2);
            /* Zoom Level — increase if needed */
            cursor: crosshair;
        }
    </style>


    <script>
        document.querySelectorAll('.image-zoom-container').forEach(container => {
            const img = container.querySelector('img');

            container.addEventListener('mousemove', function(e) {
                const rect = container.getBoundingClientRect();
                const x = (e.clientX - rect.left) / rect.width * 100;
                const y = (e.clientY - rect.top) / rect.height * 100;

                container.classList.add('zoom-active');
                img.style.transformOrigin = `${x}% ${y}%`;
            });

            container.addEventListener('mouseleave', function() {
                container.classList.remove('zoom-active');
                img.style.transformOrigin = 'center';
            });
        });
    </script>

@endsection
