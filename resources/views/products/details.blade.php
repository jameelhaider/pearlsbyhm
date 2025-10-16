@extends('layouts.app')
@section('title', 'Track My Order - Pearls By HM')

@section('content')
    <div class="container-fluid px-5 py-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-decoration-none">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('products.all') }}" class="text-decoration-none">All Products</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
            </ol>
        </nav>

        <div class="row justify-content-center align-items-start">
            <div class="col-md-5 text-center mb-4 mb-md-0">
                <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="img-fluid rounded shadow-sm"
                    style="max-height: 400px; object-fit: cover;">
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
                            <button type="button" class="btn btn-outline-dark rounded-0" id="decreaseQty" disabled>-</button>
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
                            if (value > 1) {
                                decreaseBtn.disabled = false;
                            }
                        });

                        decreaseBtn.addEventListener('click', function() {
                            let value = parseInt(qtyInput.value);
                            if (value > 1) {
                                value--;
                                qtyInput.value = value;
                            }
                            if (value === 1) {
                                decreaseBtn.disabled = true;
                            }
                        });
                    });
                </script>




            </div>
        </div>
    </div>
@endsection
