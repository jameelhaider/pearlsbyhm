@extends('admin.layouts.app')

@if (request()->status == 'pending')
    @section('admin_title', 'Admin | Pending Orders')
@elseif (request()->status == 'in-process')
    @section('admin_title', 'Admin | In Process Orders')
@elseif (request()->status == 'packed')
    @section('admin_title', 'Admin | Packed Orders')
@elseif (request()->status == 'sent')
    @section('admin_title', 'Admin | Sent Orders')
@elseif (request()->status == 'cancelled')
    @section('admin_title', 'Admin | Cancelled Orders')
@else
    @section('admin_title', 'Admin | Delivered Orders')
@endif

@section('content2')

    <div class="container-fluid px-3">
        <div class="card shadow-sm bg-white rounded-0">
            <div class="row">
                <div class="col-lg-3 col-7 col-md-4 col-sm-5">
                    <a href="{{ route('admin.dashboard') }}"
                        class="btn btn-primary custom-back-button d-flex align-items-center justify-content-center">
                        <i class="bx bx-home me-1"></i> Dashboard
                    </a>

                </div>
                <div class="col-lg-9 col-5 col-md-8 col-sm-7 ">

                    <div class="d-flex align-items-center">
                        <h3 class="mt-1 d-none d-lg-block d-md-block" style="font-family: cursive;">
                            @if (request()->status == 'pending')
                                Pending
                            @elseif (request()->status == 'in-process')
                                In Process
                            @elseif (request()->status == 'packed')
                                Packed
                            @elseif (request()->status == 'sent')
                                Sent
                            @elseif (request()->status == 'cancelled')
                                Cancelled
                            @else
                                Delivered
                            @endif
                            Orders
                        </h3>
                        <h5 class="mt-1 d-block d-lg-none d-md-none" style="font-family: cursive;">
                            @if (request()->status == 'pending')
                                Pending
                            @elseif (request()->status == 'in-process')
                                In Process
                            @elseif (request()->status == 'packed')
                                Packed
                            @elseif (request()->status == 'sent')
                                Sent
                            @elseif (request()->status == 'cancelled')
                                Cancelled
                            @else
                                Delivered
                            @endif
                            Orders
                        </h5>
                    </div>






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
                background-color: #8c0811;
                border: 0px;
            }

            .custom-back-button i {
                font-size: 18px;
            }
        </style>




        <div class="card p-2 mb-0 mt-2">

            @if ($orders->count() > 0)
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th style="font-size:14px;" class="text-dark fw-bold text-center">#</th>
                                <th style="font-size:14px;" class="text-dark fw-bold">Customer</th>
                                <th style="font-size:14px;" class="text-dark fw-bold">Status</th>
                                <th style="font-size:14px;" class="text-dark fw-bold">Placed On</th>
                                <th style="font-size:14px;" class="text-dark fw-bold">Tracking ID</th>
                                <th style="font-size:14px;" class="text-dark fw-bold">Products / Items</th>
                                <th style="font-size:14px;" class="text-dark fw-bold">Bill Summary</th>
                                <th style="font-size:14px;" class="text-dark fw-bold">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $key => $order)
                                <tr>
                                    <td class="text-dark text-center">{{ ++$key }}</td>
                                    <td class="text-dark">
                                        {{ $order->first_name . ' ' . $order->last_name }}<br>
                                        {{ $order->phone }}<br>
                                        {{ $order->city }}
                                    </td>

                                    <td class="text-dark">
                                        @if (request()->status == 'pending')
                                            <span class="badge bg-danger rounded-0">{{ $order->status }}</span>
                                        @elseif (request()->status == 'in-process')
                                            <span class="badge bg-warning text-dark rounded-0">{{ $order->status }}</span>
                                        @elseif (request()->status == 'packed')
                                            <span class="badge rounded-0"
                                                style="background-color: rgb(34, 82, 240)">{{ $order->status }}</span>
                                        @elseif (request()->status == 'sent')
                                            <span class="badge bg-info rounded-0">{{ $order->status }}</span>
                                        @elseif (request()->status == 'cancelled')
                                            <span class="badge bg-secondary rounded-0">{{ $order->status }}</span>
                                        @else
                                            <span class="badge rounded-0"
                                                style="background-color: rgb(9, 163, 9)">{{ $order->status }}</span>
                                        @endif


                                    </td>
                                    <td class="text-dark">
                                        {{ \Carbon\Carbon::parse($order->created_at)->format('d M y, h:i A') }}</td>

                                    <td class="text-dark">{{ $order->tracking_id }}</td>
                                    <td class="text-dark">{{ $order->total_products . ' / ' . $order->total_items }}</td>
                                    <td class="text-dark">
                                        <div class="mb-1">
                                            Subtotal:
                                            <strong class="text-secondary float-end">Rs.
                                                {{ number_format($order->subtotal, 2) }}</strong>
                                        </div>
                                        <div class="mb-1">
                                            Shipping:
                                            <strong class="text-info float-end">Rs.
                                                {{ number_format($order->shipping, 2) }}</strong>
                                        </div>
                                        <div>
                                            Total:
                                            <strong style="color: rgb(9, 163, 9)" class="fw-bold float-end">Rs.
                                                {{ number_format($order->total, 2) }}</strong>
                                        </div>
                                    </td>

                                    <td class="text-center">
                                        <div class="dropdown ms-auto">
                                            <button class="btn btn-dark btn-sm dropdown-toggle" type="button"
                                                id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                                Actions
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end"
                                                aria-labelledby="dropdownMenuButton">
                                                <li>
                                                    <a class="dropdown-item"
                                                        href="{{ route('admin.order.details', ['id' => $order->id]) }}">
                                                        View Details
                                                    </a>
                                                </li>

                                                @if ($order->status == 'Pending')
                                                    <li>
                                                        <a class="dropdown-item"
                                                            onclick="confirmAction('{{ route('admin.order.status.update', ['id' => $order->id, 'status' => 'In Process']) }}','Update the status as In Process of')">
                                                            Move To In Process
                                                        </a>
                                                    </li>
                                                @endif

                                                @if ($order->status == 'In Process' || $order->status == 'Pending')
                                                    <li>
                                                        <a class="dropdown-item"
                                                            onclick="confirmAction('{{ route('admin.order.status.update', ['id' => $order->id, 'status' => 'Packed, Ready To Ship']) }}','Update the status as Packed of')">
                                                            Move To Packed
                                                        </a>
                                                    </li>
                                                @endif


                                                @if ($order->status == 'Packed, Ready To Ship' || $order->status == 'Pending' || $order->status == 'In Process')
                                                    <li>
                                                        <a class="dropdown-item"
                                                            onclick="confirmAction('{{ route('admin.order.status.update', ['id' => $order->id, 'status' => 'Sent To Parcel Delivered Company']) }}','Update the status as Sent of')">
                                                            Move To Sent
                                                        </a>
                                                    </li>
                                                @endif


                                                @if (
                                                    $order->status == 'Sent To Parcel Delivered Company' ||
                                                        $order->status == 'Pending' ||
                                                        $order->status == 'In Process' ||
                                                        $order->status == 'Packed, Ready To Ship')
                                                    <li>
                                                        <a class="dropdown-item"
                                                            onclick="confirmAction('{{ route('admin.order.status.update', ['id' => $order->id, 'status' => 'Delivered']) }}','Update the status as Delivered of')">
                                                            Move To Delivered
                                                        </a>
                                                    </li>
                                                @endif





                                                @if (
                                                    $order->status != 'Cancelled' &&
                                                        $order->status != 'Sent To Parcel Delivered Company' &&
                                                        $order->status != 'Delivered')
                                                    <li>
                                                        <a class="dropdown-item"
                                                             onclick="confirmAction('{{ route('admin.order.status.update', ['id' => $order->id, 'status' => 'Cancelled']) }}','Cancell')">
                                                            Cancel Order
                                                        </a>
                                                    </li>
                                                @endif


                                            </ul>
                                        </div>
                                    </td>




                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="float-end mt-2">
                        {{ $orders->appends(request()->query())->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th style="font-size:14px;" class="text-dark fw-bold text-center">#</th>
                                <th style="font-size:14px;" class="text-dark fw-bold">Customer</th>
                                <th style="font-size:14px;" class="text-dark fw-bold">Status</th>
                                <th style="font-size:14px;" class="text-dark fw-bold">Placed On</th>
                                <th style="font-size:14px;" class="text-dark fw-bold">Tracking ID</th>
                                <th style="font-size:14px;" class="text-dark fw-bold">Products / Items</th>
                                <th style="font-size:14px;" class="text-dark fw-bold">Bill Summary</th>
                                <th style="font-size:14px;" class="text-dark fw-bold">Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>

                <h5 class="text-center fw-normal text-dark mt-4">No Data Found!</h5>
            @endif

        </div>

    </div>




    <script>
        function confirmAction(url, action) {
            Swal.fire({
                title: `Are you sure you want to ${action} this Order?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: `Yes, ${action} it!`,
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = url;
                }
            })
        }


        function confirmDelete(url) {
            Swal.fire({
                title: 'Are you sure you want to delete this Order?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = url;
                }
            })
        }
    </script>
@endsection
