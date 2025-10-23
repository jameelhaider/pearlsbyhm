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

                        <!-- ✅ Main Image -->
                        <div class="carousel-item active">
                            <img src="{{ asset($product->image) }}" class="d-block w-100 img-fluid rounded shadow-sm"
                                style="max-height: 100%; object-fit: cover;">
                        </div>

                        <!-- ✅ Hover Image (if available) -->
                        @if (!empty($product->hover_image))
                            <div class="carousel-item">
                                <img src="{{ asset($product->hover_image) }}"
                                    class="d-block w-100 img-fluid rounded shadow-sm"
                                    style="max-height: 100%; object-fit: cover;">
                            </div>
                        @endif

                        <!-- ✅ Additional Images ($product_images) -->
                        @foreach ($product_images as $image)
                            <div class="carousel-item">
                                <img src="{{ asset($image->image_path) }}" class="d-block w-100 img-fluid rounded shadow-sm"
                                    style="max-height: 100%; object-fit: cover;">
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
@endsection
