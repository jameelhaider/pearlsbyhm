@extends('layouts.app')
@section('title', 'Pearls By HM - Online Shopping Store')
@section('content')

    <div class="container-fluid">
        <div class="row g-2 mt-2">
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


    <div class="mt-5 bg-light" style="height: 280px;padding:50px 10px">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-4 mb-lg-0">
                    <div class="d-flex align-items-start">
                        <i class="bi bi-truck display-5 me-3"></i>
                        <div>
                            <h5 class="mb-1">Free Shipping</h5>
                            <p class="mb-0 small text-muted">Free Nationwide delivery on orders above Rs. 2000.</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 mb-4 mb-lg-0">
                    <div class="d-flex align-items-start">
                        <i class="bi bi-headset display-5 me-3"></i>
                        <div>
                            <h5 class="mb-1">SUPPORT</h5>
                            <p class="mb-0 small text-muted">
                                Contact us 09:00 - 18:00 PKT, (Monday to Saturday)
                                Contact : +92336-6886889
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 mb-4 mb-lg-0">
                    <div class="d-flex align-items-start">
                        <i class="bi bi-credit-card-2-front display-5 me-3"></i>
                        <div>
                            <h5 class="mb-1">Payment Methods</h5>
                            <p class="mb-0 small text-muted">COD Payment Method</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
