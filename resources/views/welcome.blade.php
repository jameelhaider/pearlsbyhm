@extends('layouts.app')
@section('title', 'Pearls By HM - Online Shopping Store')
@section('content')

    <div class="container-fluid">
        <div class="row g-2">
            @foreach ($products as $product)
                <div class="col-lg-3">
                    <div class="card p-2">
                        <h5 class="text-center">{{ $product->name }}</h5>
                        <span class="text-center d-block">Available Qty:
                            <strong>{{ $product->stock ?? $product->qty }}</strong></span>
                        <h6 class="text-center mb-2">Price: {{ $product->price }}</h6>

                        <div class="d-flex justify-content-between">
                            {{-- Add to Cart --}}
                            <form action="{{ route('cart.add') }}" method="POST">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <button type="submit" class="btn btn-sm btn-primary w-100 me-1">🛒 Add to Cart</button>
                            </form>

                            {{-- Add to Wishlist --}}
                            <form action="{{ route('wishlist.add') }}" method="POST">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <button type="submit" class="btn btn-sm btn-outline-danger w-100">❤️ Wishlist</button>
                            </form>
                        </div>

                    </div>
                </div>
            @endforeach
        </div>
    </div>

@endsection
