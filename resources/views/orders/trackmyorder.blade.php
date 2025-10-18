@extends('layouts.app')
@section('title', 'Track My Order - Pearls By HM')

@section('content')
    <div class="container py-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Track My Order</li>
            </ol>
        </nav>

        <div class="row justify-content-center mb-4">
            <div class="col-lg-8 text-center">
                <h4 class="fw-bold" style="font-family: Arimo, sans-serif; letter-spacing: 1px;">
                    Track My Order
                </h4>
                <p class="text-muted">Enter your tracking ID below to check your order status.</p>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-6">
                <form action="{{ route('track.order') }}" method="GET" class="card rounded-0 p-4">
                    <div class="mb-3">
                        <label for="tracking_id" class="form-label fw-bold">Tracking ID</label>
                        <input type="text" name="tracking_id" id="tracking_id" value="{{ request('tracking_id') }}"
                            class="form-control" placeholder="Enter your tracking ID (e.g. TRK-A9X3LZ)" required>
                    </div>

                    <button type="submit" class="btn-solid-black w-100">
                        <i class="bi bi-search me-1"></i> Track Order
                    </button>

                    <a href="{{ route('track.order') }}" class="btn-outline-black nav-link w-100 mt-2">CLEAR | TRACK NEW</a>

                </form>


            </div>
        </div>

        {{-- Show order details only if an order exists --}}
        @if ($order)
            <div class="row justify-content-center mt-5">
                <div class="col-lg-8">
                    <div class="card rounded-0">
                        <div class="card-header rounded-0 bg-dark text-white fw-bold">
                            Order Details
                        </div>
                        <div class="card-body">
                            <p><strong>Tracking ID:</strong> {{ $order->tracking_id }}</p>
                            <p><strong>Status:</strong>
                                <span
                                    class="badge
                                @if ($order->status === 'Pending') bg-danger
                                @elseif ($order->status === 'In Process') bg-warning text-dark
                                @elseif ($order->status === 'Packed, Ready To Ship') bg-primary
                                @elseif ($order->status === 'Sent To Parcel Delivered Company') bg-info text-dark
                                @else bg-success @endif">
                                    {{ $order->status }}
                                </span>
                            </p>
                            @php
                                $maskedPhone = $order->phone
                                    ? substr($order->phone, 0, 2) . '**-*****' . substr($order->phone, -2)
                                    : 'N/A';
                            @endphp

                            <p><strong>Phone:</strong> {{ $maskedPhone }}</p>

                            <p><strong>Placed On:</strong>
                                {{ \Carbon\Carbon::parse($order->created_at)->format('d M Y, h:i A') }}</p>
                            <p><strong>Total Amount:</strong> Rs. {{ number_format($order->total, 2) }}</p>
                        </div>
                    </div>
                </div>
            </div>
        @elseif(request('tracking_id'))
            <div class="row justify-content-center mt-4">
                <div class="col-lg-6 text-center">
                    <div class="alert alert-danger rounded-0">
                        No order found for the tracking ID: <strong>{{ request('tracking_id') }}</strong>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
