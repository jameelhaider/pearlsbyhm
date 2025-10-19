@extends('layouts.app')
@section('title', 'Pearls By HM - Online Shopping Store')
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
        <h3 class="text-center mt-4 fw-bold" style="font-family: Arial, sans-serif">Latest Products</h3>
        <div class="text-center">
            <a href="{{ route('products.all') }}">View All Products</a>
        </div>

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




    <div class="mt-5 bg-light py-5">
        <div class="container">
            <div class="row d-none d-md-flex text-center">
                <div class="col-lg-4 col-md-4 mb-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="feature-box p-4 rounded-0 shadow-sm bg-white h-100">
                        <i class="bi bi-truck display-5 text-primary mb-3"></i>
                        <h5 class="fw-bold">Free Shipping</h5>
                        <p class="text-muted small mb-0">Free nationwide delivery on orders above Rs. 2000.</p>
                    </div>
                </div>

                <div class="col-lg-4 col-md-4 mb-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="feature-box p-4 rounded-0 shadow-sm bg-white h-100">
                        <i class="bi bi-headset display-5 text-success mb-3"></i>
                        <h5 class="fw-bold">Support</h5>
                        <p class="text-muted small mb-0">Contact us 09:00 - 18:00 PKT (Mon–Sat) <br> +92315-8425273</p>
                    </div>
                </div>

                <div class="col-lg-4 col-md-4 mb-4" data-aos="fade-up" data-aos-delay="300">
                    <div class="feature-box p-4 rounded-0 shadow-sm bg-white h-100">
                        <i class="bi bi-credit-card-2-front display-5 text-warning mb-3"></i>
                        <h5 class="fw-bold">Payment Methods</h5>
                        <p class="text-muted small mb-0">Cash on Delivery (COD) available.</p>
                    </div>
                </div>
            </div>

            <!-- Mobile View Carousel -->
            <div id="featureCarousel" class="carousel slide d-md-none" data-bs-ride="carousel">
                <div class="carousel-inner">

                    <div class="carousel-item active text-center">
                        <div class="feature-box p-4 rounded-0 shadow-sm bg-white">
                            <i class="bi bi-truck display-5 text-primary mb-3"></i>
                            <h5 class="fw-bold">Free Shipping</h5>
                            <p class="text-muted small mb-0">Free nationwide delivery on orders above Rs. 2000.</p>
                        </div>
                    </div>

                    <div class="carousel-item text-center">
                        <div class="feature-box p-4 rounded-0 shadow-sm bg-white">
                            <i class="bi bi-headset display-5 text-success mb-3"></i>
                            <h5 class="fw-bold">Support</h5>
                            <p class="text-muted small mb-0">Contact us 09:00 - 18:00 PKT (Mon–Sat) <br> +92336-6886889</p>
                        </div>
                    </div>

                    <div class="carousel-item text-center">
                        <div class="feature-box p-4 rounded-0 shadow-sm bg-white">
                            <i class="bi bi-credit-card-2-front display-5 text-warning mb-3"></i>
                            <h5 class="fw-bold">Payment Methods</h5>
                            <p class="text-muted small mb-0">Cash on Delivery (COD) available.</p>
                        </div>
                    </div>

                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#featureCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon bg-dark rounded-circle p-2"></span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#featureCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon bg-dark rounded-circle p-2"></span>
                </button>
            </div>

        </div>
    </div>

    <script>
        AOS.init({
            duration: 800,
            once: true
        });
    </script>

    <style>
        .feature-box {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .feature-box:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
        }

        .carousel-control-prev-icon,
        .carousel-control-next-icon {
            background-size: 60%;
        }
    </style>


@endsection
