@extends('layouts.app')
@section('title', 'My Orders - Pearls By HM')
@section('content')
    <div class="container-fluid py-4 px-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Orders</li>
            </ol>
        </nav>

        <div class="row justify-content-center">
            <h4 class="text-center fw-bold" style="font-family: Arimo, sans-serif;letter-spacing: 1px;">MY ORDERS
            </h4>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th class="text-center">#</th>
                        <th class="text-center">ID</th>
                        <th class="text-center">Products / Items</th>
                        <th scope="col">ADDRESS</th>
                        <th class="text-center">BILL</th>
                        <th class="text-center">DATE | TIME</th>
                        <th class="text-center">ACTIONS</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($myorders as $key => $order)
                        <tr>
                            <th class="text-center" style="font-family: Arial, sans-serif">{{ ++$key }}</th>
                            <td class="text-center" style="font-family: Arial, sans-serif">{{ $order->id }}</td>
                            <td style="font-family: Arial, sans-serif">
                                {{ $order->total_products .
                                    ' ' .
                                    ($order->total_products == 1 ? 'Product' : 'Products') .
                                    ' / ' .
                                    $order->total_items .
                                    ' ' .
                                    ($order->total_items == 1 ? 'Item' : 'Items') }}
                                <br>
                                @if ($order->status == 'Pending')
                                    <span class="badge bg-danger rounded-0">{{ $order->status }}</span>
                                @elseif ($order->status == 'In Process')
                                    <span class="badge bg-warning rounded-0">{{ $order->status }}</span>
                                @elseif ($order->status == 'Packed, Ready To Ship')
                                    <span class="badge bg-primary rounded-0">{{ $order->status }}</span>
                                @elseif ($order->status == 'Sent To Parcel Delivered Company')
                                    <span class="badge bg-info rounded-0">{{ $order->status }}</span>
                                @else
                                    <span class="badge bg-success rounded-0">{{ $order->status }}</span>
                                @endif

                            </td>

                            <td>
                                <small>
                                    <span style="font-family: Arial, sans-serif">
                                        {{ $order->first_name . ' ' . $order->last_name . ' | ' . $order->phone . ' | ' . $order->city }}
                                        @if (!empty($order->postal_code))
                                            | {{ $order->postal_code }}
                                        @endif
                                    </span>
                                </small>

                                <br>
                                <small>
                                    <span style="font-family: Arial, sans-serif">{{ $order->address }}
                                        @if (!empty($order->landmark))
                                            | {{ $order->landmark }}
                                        @endif
                                    </span>
                                </small>
                            </td>


                            <td>
                                <small><strong class="fw-bolder" style="font-family: Arial, sans-serif">SUB TOTAL:</strong>
                                    <span class="text-dark float-end">Rs.{{ number_format($order->subtotal) }}</span>
                                </small>
                                <br>
                                <small><strong class="fw-bolder" style="font-family: Arial, sans-serif">SHIPPING:</strong>
                                    <span class="text-dark float-end">Rs.{{ number_format($order->shipping) }}</span>
                                </small>
                                <br>
                                <small>
                                    <strong class="fw-bolder" style="font-family: Arial, sans-serif">TOTAL:</strong>
                                    <span class="text-dark float-end">
                                        Rs.{{ number_format($order->total) }}
                                    </span>
                                </small>
                            </td>



                            <td class="text-center" style="font-family: Arial, sans-serif">
                                {{ \Carbon\Carbon::parse($order->created_at)->format('d F y | h:i A') }}</td>

                            <td class="text-center"><a href="" class="btn-outline-black nav-link">VIEW DETAILS</a>
                            </td>


                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>
@endsection
