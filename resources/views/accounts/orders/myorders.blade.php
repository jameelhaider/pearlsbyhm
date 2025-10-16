@extends('layouts.app')
@section('title', 'My Orders - Pearls By HM')
@section('content')
    <div class="container-fluid py-4 px-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('accounts.index') }}">Accounts</a></li>
                <li class="breadcrumb-item active" aria-current="page">My Orders</li>
            </ol>
        </nav>

        <div class="row justify-content-center">
            <h4 class="text-center fw-bold" style="font-family: Arimo, sans-serif;letter-spacing: 1px;">MY ORDERS
            </h4>
              @if ($myorders->count() > 0)
            <div class="row g-2 justify-content-center">
                @foreach ($myorders as $order)
                    <div class="col-12 col-md-10 col-lg-8">
                        <div class="card border-0 rounded-0 shadow">
                            <div class="card-body py-3 px-3">

                                {{-- Header --}}
                                <div class="d-flex justify-content-between align-items-center flex-wrap mb-2">
                                    <strong style="font-family: Arial, sans-serif;">
                                        #{{ $order->id }} |
                                        {{ \Carbon\Carbon::parse($order->created_at)->format('d M y, h:i A') }}
                                    </strong>

                                    @php
                                        $badgeClass = match ($order->status) {
                                            'Pending' => 'bg-danger',
                                            'In Process' => 'bg-warning text-dark',
                                            'Packed, Ready To Ship' => 'bg-primary',
                                            'Sent To Parcel Delivered Company' => 'bg-info text-dark',
                                            default => 'bg-success',
                                        };
                                    @endphp
                                    <span class="badge {{ $badgeClass }} px-2 rounded-0 py-1">{{ $order->status }}</span>
                                </div>

                                {{-- Summary Row --}}
                                <div class="d-flex justify-content-between flex-wrap small mb-1" style="font-family: Arial, sans-serif;">
                                    <span><strong>Products:</strong> {{ $order->total_products }}</span>
                                    <span><strong>Items:</strong> {{ $order->total_items }}</span>
                                    <span><strong>Subtotal:</strong> Rs.{{ number_format($order->subtotal) }}</span>
                                    <span><strong>Shipping:</strong> Rs.{{ number_format($order->shipping) }}</span>
                                    <span class="fw-bold text-success"><strong>Total:</strong> Rs.{{ number_format($order->total) }}</span>
                                </div>

                                {{-- Address Row --}}
                                <div class="small text-muted" style="font-family: Arial, sans-serif;">
                                    <span class="d-block text-truncate" style="max-width: 100%;">
                                        <strong>Address:</strong>
                                        {{ $order->first_name }} {{ $order->last_name }} |
                                        {{ $order->phone }} |
                                        {{ $order->city }}
                                        @if (!empty($order->postal_code))
                                            | {{ $order->postal_code }}
                                        @endif
                                    </span>
                                    <span class="d-block text-truncate" style="max-width: 100%;">
                                        {{ $order->address }}
                                        @if (!empty($order->landmark))
                                            | {{ $order->landmark }}
                                        @endif
                                    </span>
                                </div>

                                {{-- Actions --}}
                                <div class="text-end mt-2">
                                    <a href="{{ route('myorders.details',['id'=>$order->id]) }}" class="btn-outline-black nav-link px-3 py-1 rounded-0 small">
                                        VIEW DETAILS
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            {{-- Empty State --}}
            <div class="text-center my-5">
                <i class="bi bi-emoji-frown" style="font-size: 100px;"></i>
                <h5 class="text-dark fw-bold" style="font-family: Arial, sans-serif;">No Order Placed Yet!</h5>
                <p class="text-secondary" style="font-family: Arial, sans-serif;">Looks like you haven't placed any order yet.</p>
                <a href="{{ route('welcome') }}" class="btn-solid-black w-50 nav-link mt-3">
                    BROWSE PRODUCTS
                </a>
            </div>
        @endif
        </div>
    </div>
@endsection
