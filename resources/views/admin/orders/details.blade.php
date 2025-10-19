@extends('admin.layouts.app')
@section('admin_title', 'Details | Order # ' . $order->tracking_id)
@section('content2')
    <div class="container-fluid px-3">
        <div class="card shadow-sm bg-white rounded-0">
            <div class="row">
                <div class="col-lg-2 col-md-3 col-6 col-sm-4">
                    <a @if ($order->status == 'Pending') href="{{ url('admin/orders/pending') }}"
@elseif ($order->status == 'In Process')
   href="{{ url('admin/orders/in-process') }}"
@elseif ($order->status == 'Packed, Ready To Ship')
    href="{{ url('admin/orders/packed') }}"
@elseif ($order->status == 'Sent To Parcel Delivered Company')
  href="{{ url('admin/orders/sent') }}"
  @elseif ($order->status == 'Cancelled')
  href="{{ url('admin/orders/cancelled') }}"
@else
    href="{{ url('admin/orders/delivered') }}" @endif
                        class="btn btn-dark custom-back-button d-flex align-items-center justify-content-center">
                        <i class="bx bx-chevron-left me-1"></i> Back
                    </a>
                </div>
                <div class="col-lg-10 col-md-9 col-6 col-sm-8">
                    <h3 class="mt-1 d-none d-md-bloack d-lg-block" style="font-family:cursive">Details | Order #
                        {{ $order->tracking_id }}</h3>

                    <h5 class="mt-1 d-block d-md-none d-lg-none" style="font-family:cursive">Details | Order #
                        {{ $order->tracking_id }}</h5>
                </div>
            </div>
        </div>


        <style>
            .custom-back-button {
                font-size: 16px;
                height: 100%;
                width: 100%;
                border-radius: 0;
                text-decoration: none;
                transition: all 0.3s ease;
                font-weight: 500;
            }

            .custom-back-button:hover {
                background-color: #314861;
            }

            .custom-back-button i {
                font-size: 18px;
            }
        </style>

        <div class="card p-3 mt-3">
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
                                            <a class="nav-link" target="_Blank" href="{{ route('prduct.details', ['url' => $item->url]) }}">
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
