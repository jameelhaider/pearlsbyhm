@extends('layouts.app')
@section('title', 'Your Shopping Cart - '.site_name())
@section('content')

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

        .form-control.qty-input {
            height: 50px;
            border-radius: 0;
            box-shadow: none;
            font-size: 13px;
            text-align: center;
            pointer-events: none;
        }

        .input-group .btn {
            height: 50px;
            width: 40px;
            border-radius: 0;
            box-shadow: none !important;
        }

        .input-group .btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }


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
    <div class="container-fluid px-1 py-1 px-md-5 py-md-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Your Cart</li>
            </ol>
        </nav>
        <h3 class="fw-bold" style="font-family: Arial, sans-serif">Your Cart</h3>

        @if ($cartItems->isEmpty())
            <div class="text-center my-5">
                <i style="font-size: 110px;" class="bi bi-emoji-frown"></i>
                <h2 class="text-dark fw-bold" style="font-family:Arial, sans-serif">Your cart is empty</h2>
                <p class="text-secondary" style="font-family:Arial, sans-serif">Looks like you haven't added any items yet.
                </p>
                <a href="{{ route('products.all') }}" class="btn-outline-black2 nav-link mt-3 w-100 w-lg-50">
                    CONTINUE SHOPPING
                </a>

            </div>
        @else
            <div class="row">
                <div class="col-lg-8 col-md-12 col-sm-12 col-12 mt-4">
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
                    <div class="card p-4 mt-2 rounded-0">
                        @foreach ($cartItems as $item)
                            <div
                                class="d-flex align-items-center justify-content-between border-bottom py-3 flex-wrap gap-3">
                                <a href="{{ route('prduct.details', ['url' => $item->url]) }}" class="nav-link">
                                    <div class="d-flex align-items-center flex-grow-1" style="min-width: 200px;">
                                        <img src="{{ asset($item->image) }}" alt="{{ $item->name }}" class="rounded me-3"
                                            style="width: 100px; height: 130px; object-fit: cover;">
                                        <div>
                                            <span class="d-block fw-semibold" style="font-family: Arial, sans-serif;">
                                                {{ $item->name }}
                                            </span>
                                            <span class="text-muted d-block" style="font-family: Arial, sans-serif;">
                                                {{ 'Rs.' . number_format($item->price, 2) }}
                                            </span>
                                        </div>
                                    </div>
                                </a>
                                <!-- Quantity Controls -->
                                <div class="d-flex align-items-center justify-content-center" style="min-width: 140px;">
                                    <div class="input-group input-group-sm quantity-group"
                                        data-id="{{ $item->cart_item_id }}" style="max-width: 120px;">
                                        <button class="btn btn-outline-dark minus-btn" type="button">−</button>
                                        <input type="text" class="form-control text-center qty-input"
                                            value="{{ $item->qty }}" min="1" readonly>
                                        <button class="btn btn-outline-dark plus-btn" type="button">+</button>
                                    </div>
                                </div>

                                <!-- Total Price -->
                                <div class="text-center fw-bold" style="min-width: 100px; font-family: Arial, sans-serif;">
                                    {{ 'Rs.' . number_format($item->price * $item->qty, 2) }}
                                </div>

                                <!-- Remove Button -->
                                <div class="text-center" style="min-width: 50px;">
                                    <form action="{{ route('cart.remove', $item->cart_item_id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-link text-danger p-0" title="Remove">
                                            <i class="bi bi-x-lg fs-5"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>



                            {{-- <div class="row">
                                <div class="col-lg-2 col-md-2 col-6 col-sm-4">
                                    <img src="{{ asset($item->image) }}" height="130px" width="100px" alt="">
                                </div>
                                <div class="col-lg-3 col-md-2 col-6 col-sm-4">
                                    <span>{{ $item->name }}</span>
                                </div>
                                <div class="col-lg-2 col-md-2 col-3 col-sm-4">
                                    <span>{{ 'Rs.' . number_format($item->price, 2) }}</span>
                                </div>
                                <div class="col-lg-2 col-md-3 col-4 col-sm-4">
                                    <div class="input-group quantity-group" data-id="{{ $item->cart_item_id }}">
                                        <button class="btn btn-outline-dark btn-sm minus-btn" type="button">−</button>
                                        <input type="text" class="form-control qty-input" value="{{ $item->qty }}"
                                            min="1" readonly>
                                        <button class="btn btn-outline-dark btn-sm plus-btn" type="button">+</button>
                                    </div>
                                </div>


                                <div class="col-lg-2 col-md-2 col-4 col-sm-4">
                                    <span>{{ 'Rs.' . number_format($item->price * $item->qty, 2) }}</span>
                                </div>

                                <div class="col-lg-1 col-md-1 col-sm-4 col-1 text-center">
                                    <form action="{{ route('cart.remove', $item->cart_item_id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-icon">
                                            <i class="bi bi-x-lg"></i>
                                        </button>
                                    </form>
                                </div>




                            </div> --}}
                        @endforeach
                    </div>
                </div>

                <div class="col-lg-4 col-md-12 col-12 col-sm-12 mt-4">
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
                    <a href="{{ route('checkout.index') }}" class="btn-solid-black2 w-100 nav-link mt-3">
                        PROCEED TO CHECKOUT
                    </a>

                    <a href="{{ url('/') }}" class="btn-outline-black2 w-100 mt-4 nav-link">CONTINUE SHOPPING</a>
                </div>
            </div>
        @endif
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <script>
        $(document).ready(function() {
            $('.quantity-group').each(function() {
                const group = $(this);
                const minusBtn = group.find('.minus-btn');
                const plusBtn = group.find('.plus-btn');
                const qtyInput = group.find('.qty-input');
                const cartItemId = group.data('id');
                toggleMinusButton(qtyInput, minusBtn);
                plusBtn.on('click', function() {
                    let qty = parseInt(qtyInput.val());
                    qty++;
                    updateQuantity(cartItemId, qty, qtyInput, minusBtn);
                });
                minusBtn.on('click', function() {
                    let qty = parseInt(qtyInput.val());
                    if (qty > 1) {
                        qty--;
                        updateQuantity(cartItemId, qty, qtyInput, minusBtn);
                    }
                });

                function toggleMinusButton(input, btn) {
                    if (parseInt(input.val()) <= 1) {
                        btn.prop('disabled', true);
                    } else {
                        btn.prop('disabled', false);
                    }
                }

                function updateQuantity(itemId, qty, input, minusBtn) {
                    $.ajax({
                        url: "{{ route('cart.updateQty') }}",
                        method: "POST",
                        data: {
                            _token: "{{ csrf_token() }}",
                            item_id: itemId,
                            quantity: qty
                        },
                        success: function(response) {
                            input.val(qty);
                            toggleMinusButton(input, minusBtn);
                            location.reload();
                        },
                        error: function(xhr) {
                            console.error(xhr.responseText);
                            alert('Failed to update quantity');
                        }
                    });
                }
            });
        });
    </script>

@endsection
