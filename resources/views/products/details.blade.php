@extends('layouts.app')
@section('title', 'Track My Order - Pearls By HM')

@section('content')
<div class="container-fluid px-5 py-4">
    {{-- Breadcrumb --}}
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-decoration-none">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ url('/products') }}" class="text-decoration-none">Products</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
        </ol>
    </nav>

    {{-- Heading --}}
    {{-- Product Details Section --}}
    <div class="row justify-content-center align-items-start">
        {{-- Product Image --}}
        <div class="col-md-5 text-center mb-4 mb-md-0">
            <img src="{{ asset($product->image) }}"
                 alt="{{ $product->name }}"
                 class="img-fluid rounded shadow-sm"
                 style="max-height: 400px; object-fit: cover;">
        </div>

        {{-- Product Info --}}
        <div class="col-md-6">
            <h3 class="fw-bold" style="font-family: Arimo, sans-serif;">{{ $product->name }}</h3>

            <div class="my-3">
                    <span class="text-dark fs-4 fw-bold">Rs {{ number_format($product->price) }}</span>
            </div>

            <p class="text-muted" style="font-size: 15px; line-height: 1.6;">
                {!! nl2br(e($product->description)) !!}
            </p>

            <div class="mt-4">
                <form action="{{ route('cart.add', $product->id) }}" method="POST">
                    @csrf
                    <div class="input-group mb-3" style="max-width: 150px;">
                        <input type="number" name="quantity" class="form-control text-center" value="1" min="1">
                    </div>
                    <button type="submit" class="btn btn-dark px-4 py-2 rounded-0">
                        <i class="bi bi-cart-plus"></i> Add to Cart
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
