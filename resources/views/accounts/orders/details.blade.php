@extends('layouts.app')
@php
    $title = 'Order Details # ' . $order->tracking_id . ' - '.site_name();
@endphp
@section('title', $title)

@section('content')
    <style>
        * {
            font-family: 'Arimo', sans-serif !important;
        }

        .order-details-card h5 {
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        .table th,
        .table td {
            vertical-align: middle;
            font-size: 0.95rem;
            word-break: break-word;
        }

        .table img {
            border-radius: 6px;
            object-fit: cover;
        }

        @media (max-width: 768px) {

            .table th,
            .table td {
                font-size: 0.85rem;
            }

            .btn-solid-black {
                width: 100%;
                text-align: center;
                margin-top: 8px;
            }

            .list-group-item strong {
                width: 40%;
            }

            .list-group-item span {
                width: 55%;
                text-align: right;
            }
        }
    </style>

    <div class="container-fluid py-4 px-3 px-md-4">
        {{-- Breadcrumb --}}
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('myorders.index') }}">My Orders</a></li>
                <li class="breadcrumb-item active" aria-current="page">Order Details # {{ $order->tracking_id }}</li>
            </ol>
        </nav>

        {{-- Header --}}
        <div class="text-center">
            <h4 class="fw-bold mb-2" style="letter-spacing: 1px;">ORDER DETAILS # {{ $order->tracking_id }}</h4>
            <a href="{{ route('myorders.index') }}" class="btn-solid-black nav-link w-100">Back to Orders</a>
        </div>

        {{-- Order Info + Items --}}
        <div class="card order-details-card rounded-0 p-3 p-md-4 mt-2">
            <div class="row g-4">
                {{-- LEFT COLUMN --}}
                <div class="col-lg-6 col-md-12">
                    <h5 class="mb-3">Order Information</h5>
                    <ul class="list-group list-group-flush small">
                        <li class="list-group-item px-0 d-flex justify-content-between">
                            <strong>Order Placed:</strong>
                            <span>{{ \Carbon\Carbon::parse($order->created_at)->format('d M y, h:i A') }}</span>
                        </li>
                        <li class="list-group-item px-0 d-flex justify-content-between">
                            <strong>Tracking ID:</strong>
                            <span>{{ $order->tracking_id }}</span>
                        </li>

                        @php
                            $statusClasses = [
                                'Pending' => 'bg-danger',
                                'In Process' => 'bg-warning text-dark',
                                'Packed, Ready To Ship' => 'bg-primary',
                                'Sent To Parcel Delivered Company' => 'bg-info text-dark',
                                'default' => 'bg-success',
                            ];

                            $badgeClass = $statusClasses[$order->status] ?? $statusClasses['default'];
                        @endphp

                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <strong>Status:</strong>
                            <span class="badge {{ $badgeClass }} rounded-0 px-3 py-1">
                                {{ $order->status }}
                            </span>
                        </li>


                        <li class="list-group-item px-0 d-flex justify-content-between">
                            <strong>Total Products:</strong> <span>{{ $order->total_products }}</span>
                        </li>
                        <li class="list-group-item px-0 d-flex justify-content-between">
                            <strong>Total Items:</strong> <span>{{ $order->total_items }}</span>
                        </li>
                        <li class="list-group-item px-0 d-flex justify-content-between">
                            <strong>Full Name:</strong> <span>{{ $order->first_name . ' ' . $order->last_name }}</span>
                        </li>
                        <li class="list-group-item px-0 d-flex justify-content-between">
                            <strong>Phone:</strong> <span>{{ $order->phone }}</span>
                        </li>
                        <li class="list-group-item px-0 d-flex justify-content-between">
                            <strong>Address:</strong> <span>{{ $order->address }}</span>
                        </li>
                        @if (!empty($order->landmark))
                            <li class="list-group-item px-0 d-flex justify-content-between">
                                <strong>Landmark:</strong> <span>{{ $order->landmark }}</span>
                            </li>
                        @endif
                        <li class="list-group-item px-0 d-flex justify-content-between">
                            <strong>City:</strong> <span>{{ $order->city }}</span>
                        </li>
                        <li class="list-group-item px-0 d-flex justify-content-between">
                            <strong>Postal Code:</strong> <span>{{ $order->postal_code }}</span>
                        </li>
                    </ul>
                </div>

                {{-- RIGHT COLUMN --}}
                <div class="col-lg-6 col-md-12">
                    <h5 class="mb-3">Order Items</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Product</th>
                                    <th class="text-center">Qty</th>
                                    <th>Price</th>
                                    <th class="text-end">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($order_items as $item)
                                    <tr>
                                        <td class="d-flex align-items-center gap-2">
                                            <a class="nav-link" href="{{ route('prduct.details', ['url' => $item->url]) }}">
                                                <img src="{{ asset($item->product_image) }}" height="70" width="70"
                                                    alt="{{ $item->name }}">
                                                <span>{{ $item->name ?? 'N/A' }}</span>
                                            </a>

                                        </td>
                                        <td class="text-center">{{ $item->qty }}</td>
                                        <td>Rs. {{ number_format($item->price, 2) }}</td>
                                        <td class="text-end">Rs. {{ number_format($item->total, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- Totals --}}
                    <div class="mt-3">
                        <ul class="list-group list-group-flush small">
                            <li class="list-group-item px-0 d-flex justify-content-between">
                                <strong>Subtotal:</strong>
                                <span>Rs. {{ number_format($order->subtotal, 2) }}</span>
                            </li>
                            <li class="list-group-item px-0 d-flex justify-content-between">
                                <strong>Shipping:</strong>
                                <span>Rs. {{ number_format($order->shipping, 2) }}</span>
                            </li>
                            <li class="list-group-item px-0 d-flex justify-content-between fw-bold border-top pt-2">
                                <strong>Total Bill:</strong>
                                <span>Rs. {{ number_format($order->total, 2) }}</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
