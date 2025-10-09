@extends('layouts.app')

@section('title', 'Checkout - Pearls BY HM')

@section('content')


    <div class="container px-5 py-4 mb-5">
         <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('cart.index') }}">Your Cart</a></li>
                <li class="breadcrumb-item active" aria-current="page">Checkout</li>
            </ol>
        </nav>

        <form action="{{ route('checkout.store') }}" method="POST">
            @csrf
            <div class="row">
                <!-- ===================== LEFT SIDE: FORM ===================== -->
                <div class="col-lg-7">
                    <h4 class="fw-bold" style="font-family: Arial, sans-serif">Delivery</h4>

                    <div class="row mt-4">
                        <div class="col-lg-6 mb-3">
                            <input type="text" class="form-control" autofocus placeholder="First Name" name="first_name"
                                required>
                        </div>
                        <div class="col-lg-6 mb-3">
                            <input type="text" class="form-control" placeholder="Last Name" name="last_name" required>
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col-lg-12 mb-3">
                            <input type="text" class="form-control" placeholder="Address" name="address" required>
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col-lg-12 mb-3">
                            <input type="text" class="form-control" placeholder="Apartment, suite, etc. (optional)"
                                name="landmark">
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col-lg-6 mb-3">
                            <input type="text" class="form-control" placeholder="City Name" name="city" required>
                        </div>
                        <div class="col-lg-6 mb-3">
                            <input type="text" class="form-control" placeholder="Postal Code (optional)"
                                name="postal_code">
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col-lg-12 mb-3">
                            <input type="text" class="form-control" placeholder="Phone" name="phone" required>
                        </div>
                    </div>

                    <h4 class="fw-bold mt-4" style="font-family: Arial, sans-serif">Shipping method</h4>

                    <div class="row mt-4 p-2">
                        <div class="col-lg-12 p-3 border border-dark rounded-3">
                            <div class="row align-items-center">
                                <div class="col-lg-6">
                                    @if ($total < 2000)
                                        <h5 class="mb-0" style="font-family:Arial, sans-serif">
                                            <i class="bi bi-record-circle me-2"></i>
                                            Standard
                                        </h5>
                                    @else
                                        <h5 class="mb-0" style="font-family:Arial, sans-serif">
                                            <i class="bi bi-record-circle me-2"></i>
                                            Free Shipping (Free Delivery)
                                        </h5>
                                    @endif
                                </div>
                                <div class="col-lg-6">
                                    @if ($total < 2000)
                                        <h5 class="float-end fw-bold mb-0" style="font-family:Arial, sans-serif">Rs. 260.00
                                        </h5>
                                    @else
                                        <h5 class="float-end fw-bold mb-0 text-success"
                                            style="font-family:Arial, sans-serif">FREE</h5>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <h4 class="fw-bold mt-4" style="font-family: Arial, sans-serif">Payment Method</h4>

                    <div class="row mt-4 p-2">
                        <div class="col-lg-12 p-3 border border-dark rounded-3">
                            <div class="row align-items-center">
                                <div class="col-lg-6">
                                    <h5 class="mb-0" style="font-family:Arial, sans-serif">
                                        <i class="bi bi-record-circle me-2"></i>
                                        Standard
                                    </h5>
                                </div>
                                <div class="col-lg-6">
                                    <h5 class="float-end mb-0 text-success" style="font-family:Arial, sans-serif">
                                        Cash On Delivery (COD)
                                    </h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ===================== RIGHT SIDE: SUMMARY ===================== -->
                <div class="col-lg-5 bg-light p-4">
                    @foreach ($cartItems as $item)
                        <div class="mt-2">
                            <img src="{{ asset($item->image) }}" height="100px" width="90px" alt="">
                            <span style="font-family:Arial, sans-serif">{{ $item->name }} × {{ $item->qty }}</span>
                            <span class="float-end fw-bold" style="font-family:Arial, sans-serif">
                                {{ 'Rs.' . number_format($item->qty * $item->price, 2) }}
                            </span>
                        </div>
                    @endforeach
                    <hr>
                    <span style="font-family:Arial, sans-serif">Subtotal . {{ $cartItems->count() }} Products</span>
                    <span class="float-end fw-bold" style="font-family:Arial, sans-serif">
                        {{ 'Rs.' . number_format($subtotal, 2) }}
                    </span>
                    <hr>
                    <span style="font-family:Arial, sans-serif">Shipping</span>
                    <span class="float-end fw-bold" style="font-family:Arial, sans-serif">
                        {{ 'Rs.' . number_format($shipping, 2) }}
                    </span>
                    <hr>
                    <span style="font-family:Arial, sans-serif">Total</span>
                    <span class="float-end fw-bold" style="font-family:Arial, sans-serif">
                        {{ 'Rs.' . number_format($total, 2) }}
                    </span>

                    <hr>
                    <!-- Place Order Button -->
                    <button type="submit" class="btn-outline-black nav-link w-100 mt-3"
                        style="font-family:Arial, sans-serif">
                        PLACE ORDER <i class="bi bi-check-circle"></i>
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection
