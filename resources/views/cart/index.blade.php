@extends('layouts.app')
@section('title', 'Your Shopping Cart - Pearls By HM')
@section('content')
    <div class="container-fluid px-5 py-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Your Cart</li>
            </ol>
        </nav>
        <h3 class="mb-4 fw-bold" style="font-family: Arial, sans-serif">Your Cart</h3>

        @if ($items->isEmpty())
            <div class="alert alert-info text-center">
                Your cart is empty 😔
            </div>
        @else
            <div class="row">
                <div class="col-lg-8">
                    <div class="table-responsive">
                        <table class="table">
                            <thead class="table-light table-header">
                                <tr>
                                    <th>PRODUCT</th>
                                    <th>PRICE</th>
                                    <th>QUANTITY</th>
                                    <th>TOTAL</th>
                                </tr>
                                <style>
                                    .table-header th {
                                        padding: 12px 16px;
                                        font-weight: 600;
                                    }
                                </style>
                            </thead>
                        </table>
                    </div>

                    @foreach ($items as $item)
                        <div class="card p-4 mt-2 rounded-0">
                            <div class="row">
                                <div class="col-lg-2">
                                    <img src="{{ asset($item->image) }}" height="130px" width="100px" alt="">
                                </div>
                                <div class="col-lg-3">
                                    <span>{{ $item->name }}</span>
                                </div>
                                <div class="col-lg-2">
                                    <span>{{ 'Rs.' . number_format($item->price, 2) }}</span>
                                </div>
                                <div class="col-lg-2">
                                    <input type="number" min="1" class="form-control" value="{{ $item->qty }}">
                                </div>
                                <div class="col-lg-2">
                                    <span>{{ 'Rs.' . number_format($item->price * $item->qty, 2) }}</span>
                                </div>

                                <div class="col-lg-1 text-center">
                                    <form action="{{ route('cart.remove', $item->cart_item_id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-icon">
                                            <i class="bi bi-x-lg"></i>
                                        </button>
                                    </form>
                                </div>

                                <style>
                                    .btn-icon {
                                        background: none;
                                        border: none;
                                        padding: 0;
                                        margin: 0;
                                        cursor: pointer;
                                    }

                                    .btn-icon i {
                                        font-size: 1.1rem;
                                        color: #000;
                                        transition: color 0.2s ease;
                                    }

                                    .btn-icon:hover i {
                                        color: #dc3545;
                                    }
                                </style>


                            </div>


                        </div>
                    @endforeach
                </div>

                <div class="col-lg-4">
                    <h4 class="mt-1" style="font-family: Arial, sans-serif;letter-spacing: 1px;font-size: 16px;">ORDER
                        SUMMARY</h4>
                    <hr>

                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><span class="fw-bolder" style="font-family: Arial, sans-serif">SUB
                                TOTAL</span> <span class="float-end fw-bold h5"
                                style="font-family: Arial, sans-serif">{{ 'Rs.' . number_format($total, 2) }}</span></li>
                        <li class="list-group-item"><span class="fw-bolder"
                                style="font-family: Arial, sans-serif">TOTAL</span> <span class="float-end fw-bold h5"
                                style="font-family: Arial, sans-serif">{{ 'Rs.' . number_format($total, 2) }}</span></li>
                    </ul>
                    <hr>


                    <style>
                        .btn-outline-black2,
                        .btn-solid-black2 {
                            display: inline-block;
                            font-family: 'Montserrat', Arial, sans-serif;
                            letter-spacing: 2px;
                            padding: 12px 0px;
                            font-size: 15px;
                            text-align: center;
                            cursor: pointer;
                            border-radius: 0;
                            box-shadow: none;
                            transition: all 0.4s ease;
                        }

                        .btn-outline-black2 {
                            background-color: #fff;
                            color: #000;
                            border: 1px solid #000;
                        }

                        .btn-outline-black2:hover {
                            background-color: #000;
                            color: #fff;
                            border-color: #000;
                            opacity: 0.9;
                        }

                        .btn-solid-black2 {
                            background-color: #000;
                            color: #fff;
                            border: 1px solid transparent;
                            text-transform: uppercase;
                        }

                        .btn-solid-black2:hover {
                            background-color: #fff;
                            color: #000;
                            border-color: #000;
                            opacity: 0.9;
                        }
                    </style>


                    <a href="" class="btn-solid-black2 w-100 nav-link mt-3">PROCEED TO CHECKOUT</a>
                    <a href="{{ url('/') }}" class="btn-outline-black2 w-100 mt-4 nav-link">CONTINUE SHOPPING</a>
                </div>



            </div>
        @endif
    </div>
@endsection
