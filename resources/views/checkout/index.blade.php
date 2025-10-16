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
                <div class="col-lg-7 col-md-12 col-12 col-sm-12 mt-4">
                    <h4 class="fw-bold" style="font-family: Arial, sans-serif">Delivery</h4>

                    <div class="accordion" id="accordionExample">

                        {{-- Address Method Dropdown --}}
                        @if (Auth::check() && $addresses->count() > 0)
                            <label for="address_method" class="custom-font my-1">
                                Select Address Method You Want To Use
                                <span class="text-danger">*</span>
                            </label>
                            <select name="address_method" required class="form-control form-select mb-3"
                                id="address_method">
                                <option value="">Select Option</option>
                                <option value="Using Saved Address"
                                    {{ old('address_method') == 'Using Saved Address' ? 'selected' : '' }}>
                                    Using Saved Address
                                </option>
                                <option value="Using Different Address"
                                    {{ old('address_method') == 'Using Different Address' ? 'selected' : '' }}>
                                    Using Different Address
                                </option>
                            </select>
                        @endif

                        {{-- Saved Address Accordion --}}
                        @if (Auth::check() && $addresses->count() > 0)
                            <div class="accordion-item" id="saved-address-section">
                                <h2 class="accordion-header" id="headingOne">
                                    <button
                                        class="accordion-button {{ old('address_method') == 'Using Different Address' ? 'collapsed' : '' }}"
                                        type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne"
                                        aria-expanded="{{ old('address_method') == 'Using Different Address' ? 'false' : 'true' }}"
                                        aria-controls="collapseOne">
                                        Use Saved Addresses
                                    </button>
                                </h2>
                                <div id="collapseOne"
                                    class="accordion-collapse collapse {{ old('address_method') == 'Using Different Address' ? '' : 'show' }}"
                                    aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <form id="select-address-form">
                                            @foreach ($addresses as $address)
                                                <label class="card p-2 rounded-0 mt-2 d-block" style="cursor: pointer;">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio"
                                                            name="selected_address" id="address_{{ $address->id }}"
                                                            value="{{ $address->id }}" {{ $loop->first ? 'checked' : '' }}>
                                                        <div class="ms-2">
                                                            <small>
                                                                <span style="font-family: Arial, sans-serif">
                                                                    {{ $address->first_name . ' ' . $address->last_name . ' | ' . $address->phone . ' | ' . $address->city }}
                                                                    @if (!empty($address->postal_code))
                                                                        | {{ $address->postal_code }}
                                                                    @endif
                                                                </span>
                                                            </small>
                                                            <hr class="my-1">
                                                            <small>
                                                                <span style="font-family: Arial, sans-serif">
                                                                    {{ $address->address }}
                                                                    @if (!empty($address->landmark))
                                                                        | {{ $address->landmark }}
                                                                    @endif
                                                                </span>
                                                            </small>
                                                        </div>
                                                    </div>
                                                </label>
                                            @endforeach
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endif

                        {{-- Different Address Accordion --}}
                        <div class="accordion-item" id="different-address-section">
                            <h2 class="accordion-header" id="headingTwo">
                                @if (Auth::check() && $addresses->count() > 0)
                                    <button
                                        class="accordion-button {{ old('address_method') == 'Using Different Address' ? '' : 'collapsed' }}"
                                        type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo"
                                        aria-expanded="{{ old('address_method') == 'Using Different Address' ? 'true' : 'false' }}"
                                        aria-controls="collapseTwo">
                                        Use Different Address
                                    </button>
                                @else
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                                        Shipping Address
                                    </button>
                                @endif
                            </h2>

                            <div id="collapseTwo"
                                class="accordion-collapse collapse {{ old('address_method') == 'Using Different Address' ? 'show' : (Auth::check() && $addresses->count() > 0 ? '' : 'show') }}"
                                aria-labelledby="headingTwo" data-bs-parent="#accordionExample">

                                <div class="accordion-body">
                                    {{-- Shipping Form --}}
                                    <div class="row mt-3">
                                        <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-3">
                                            <label for="first_name" class="custom-font my-1">First Name <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" name="first_name" placeholder="First Name"
                                                value="{{ old('first_name') }}"
                                                class="form-control @error('first_name') is-invalid @enderror">
                                            @error('first_name')
                                                <span class="invalid-feedback"
                                                    role="alert"><strong>{{ $message }}</strong></span>
                                            @enderror
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-3">
                                            <label for="last_name" class="custom-font my-1">Last Name <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" name="last_name" placeholder="Last Name"
                                                value="{{ old('last_name') }}"
                                                class="form-control @error('last_name') is-invalid @enderror">
                                            @error('last_name')
                                                <span class="invalid-feedback"
                                                    role="alert"><strong>{{ $message }}</strong></span>
                                            @enderror
                                        </div>
                                    </div>
                                    {{-- Email --}}
                                    @if (Auth::check())
                                        <div class="row mt-1">
                                            <div class="col-12 mb-3">
                                                <label for="email" class="custom-font my-1">Email <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" name="email" readonly
                                                    placeholder="Your Email Address" value="{{ Auth::user()->email }}"
                                                    class="form-control @error('email') is-invalid @enderror">
                                                @error('email')
                                                    <span class="invalid-feedback"
                                                        role="alert"><strong>{{ $message }}</strong></span>
                                                @enderror
                                            </div>
                                        </div>
                                    @else
                                        <div class="row mt-1">
                                            <div class="col-12 mb-3">
                                                <label for="email" class="custom-font my-1">Email <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" name="email" placeholder="Your Email Address"
                                                    value="{{ old('email') }}"
                                                    class="form-control @error('email') is-invalid @enderror">
                                                @error('email')
                                                    <span class="invalid-feedback"
                                                        role="alert"><strong>{{ $message }}</strong></span>
                                                @enderror
                                            </div>
                                        </div>
                                    @endif

                                    {{-- Address --}}
                                    <div class="row mt-1">
                                        <div class="col-12 mb-3">
                                            <label for="address" class="custom-font my-1">Address <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" name="address" placeholder="Address"
                                                value="{{ old('address') }}"
                                                class="form-control @error('address') is-invalid @enderror">
                                            @error('address')
                                                <span class="invalid-feedback"
                                                    role="alert"><strong>{{ $message }}</strong></span>
                                            @enderror
                                        </div>
                                    </div>
                                    {{-- Landmark --}}
                                    <div class="row mt-1">
                                        <div class="col-12 mb-3">
                                            <label for="landmark" class="custom-font my-1">Landmark (optional)</label>
                                            <input type="text" name="landmark"
                                                placeholder="Apartment, suite, etc. (optional)"
                                                value="{{ old('landmark') }}"
                                                class="form-control @error('landmark') is-invalid @enderror">
                                            @error('landmark')
                                                <span class="invalid-feedback"
                                                    role="alert"><strong>{{ $message }}</strong></span>
                                            @enderror
                                        </div>
                                    </div>
                                    {{-- City & Postal --}}
                                    <div class="row mt-1">
                                        <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-3">
                                            <label for="city" class="custom-font my-1">City <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" name="city" placeholder="City Name"
                                                value="{{ old('city') }}"
                                                class="form-control @error('city') is-invalid @enderror">
                                            @error('city')
                                                <span class="invalid-feedback"
                                                    role="alert"><strong>{{ $message }}</strong></span>
                                            @enderror
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-3">
                                            <label for="postal_code" class="custom-font my-1">Postal Code
                                                (optional)</label>
                                            <input type="text" name="postal_code" placeholder="Postal Code (optional)"
                                                value="{{ old('postal_code') }}"
                                                class="form-control @error('postal_code') is-invalid @enderror">
                                            @error('postal_code')
                                                <span class="invalid-feedback"
                                                    role="alert"><strong>{{ $message }}</strong></span>
                                            @enderror
                                        </div>
                                    </div>
                                    {{-- Phone --}}
                                    <div class="row mt-1">
                                        <div class="col-12 mb-3">
                                            <label for="phone" class="custom-font my-1">Phone <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" id="phone" name="phone"
                                                placeholder="0300-0000000" value="{{ old('phone') }}" maxlength="12"
                                                class="form-control @error('phone') is-invalid @enderror">
                                            @error('phone')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <script>
                                        document.addEventListener("DOMContentLoaded", function() {
                                            const phoneInput = document.getElementById('phone');
                                            if (!phoneInput.value) {
                                                phoneInput.value = '03';
                                            }
                                            phoneInput.addEventListener('keydown', function(e) {
                                                if ((phoneInput.selectionStart <= 2 && (e.key === 'Backspace' || e.key === 'Delete'))) {
                                                    e.preventDefault();
                                                }
                                            });
                                            phoneInput.addEventListener('input', function(e) {
                                                let value = e.target.value.replace(/\D/g, '');
                                                if (!value.startsWith('03')) {
                                                    value = '03' + value.replace(/^0+/, '');
                                                }
                                                value = value.slice(0, 11);
                                                let formatted = value;
                                                if (value.length > 4) {
                                                    formatted = value.slice(0, 4) + '-' + value.slice(4);
                                                }

                                                e.target.value = formatted;
                                            });
                                        });
                                    </script>


                                    @if (Auth::check())
                                        <div class="row mb-3">
                                            <div class="col-12">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="save_for_later"
                                                        id="save_for_later" {{ old('save_for_later') ? 'checked' : '' }}>
                                                    <label class="form-check-label custom-font" for="save_for_later">
                                                        Save this address for later
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        {{-- JS --}}
                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                const addressMethod = document.getElementById('address_method');
                                const savedSection = document.getElementById('saved-address-section');
                                const differentSection = document.getElementById('different-address-section');
                                const savedCollapseEl = document.getElementById('collapseOne');
                                const diffCollapseEl = document.getElementById('collapseTwo');

                                const savedCollapse = new bootstrap.Collapse(savedCollapseEl, {
                                    toggle: false
                                });
                                const diffCollapse = new bootstrap.Collapse(diffCollapseEl, {
                                    toggle: false
                                });

                                function toggleSections(value) {
                                    if (value === 'Using Saved Address') {
                                        savedSection.style.display = 'block';
                                        differentSection.style.display = 'none';

                                        // Only show if not already shown
                                        if (!savedCollapseEl.classList.contains('show')) {
                                            savedCollapse.show();
                                        }
                                    } else if (value === 'Using Different Address') {
                                        savedSection.style.display = 'none';
                                        differentSection.style.display = 'block';

                                        // Only show if not already shown
                                        if (!diffCollapseEl.classList.contains('show')) {
                                            diffCollapse.show();
                                        }
                                    } else {
                                        savedSection.style.display = 'block';
                                        differentSection.style.display = 'block';
                                    }
                                }

                                if (addressMethod) {
                                    toggleSections(addressMethod.value);
                                    addressMethod.addEventListener('change', function() {
                                        toggleSections(this.value);
                                    });
                                }
                            });
                        </script>



                    </div>



                    <h4 class="fw-bold mt-4" style="font-family: Arial, sans-serif">Shipping method</h4>

                    <div class="row mt-4 p-2">
                        <div class="col-lg-12 p-3 border border-dark rounded-3">
                            <div class="row align-items-center">
                                <div class="col-lg-6 col-8 col-sm-8">
                                    @if ($total < 2000)
                                        <h5 class="mb-0" style="font-family:Arial, sans-serif">
                                            <i class="bi bi-record-circle me-2"></i>
                                            Standard
                                        </h5>
                                    @else
                                        <h5 class="mb-0" style="font-family:Arial, sans-serif">
                                            <i class="bi bi-record-circle me-2"></i>
                                            Free Shipping
                                        </h5>
                                    @endif
                                </div>
                                <div class="col-lg-6 col-4 col-sm-4">
                                    @if ($total < 2000)
                                        <h5 class="float-end fw-bold mb-0" style="font-family:Arial, sans-serif">Rs.
                                            260.00
                                        </h5>
                                    @else
                                        <h5 class="float-end fw-bold mb-0 text-success"
                                            style="font-family:Arial, sans-serif">
                                            FREE</h5>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <h4 class="fw-bold mt-4" style="font-family: Arial, sans-serif">Payment Method</h4>

                    <div class="row mt-4 p-2">
                        <div class="col-lg-12 p-3 border border-dark rounded-3">
                            <div class="row align-items-center">
                                <div class="col-lg-6 col-4 col-sm-4 col-md-5">
                                    <h5 class="mb-0" style="font-family:Arial, sans-serif">
                                        <i class="bi bi-record-circle me-2"></i>
                                        Standard
                                    </h5>
                                </div>
                                <div class="col-lg-6 col-8 col-sm-8 col-md-7">
                                    <h5 class="float-end mb-0 text-success" style="font-family:Arial, sans-serif">
                                        Cash On Delivery (COD)
                                    </h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ===================== RIGHT SIDE: SUMMARY ===================== -->
                <div class="col-lg-5 col-md-12 col-12 col-sm-12 bg-light p-4 mt-4">

                    @foreach ($cartItems as $item)
                        <div class="d-flex align-items-center justify-content-between mb-3 border-bottom pb-2">
                            <div class="d-flex align-items-center">
                                <img src="{{ asset($item->image) }}" alt="{{ $item->name }}" class="rounded me-3"
                                    style="width: 80px; height: 80px; object-fit: cover;">
                                <div>
                                    <span class="d-block fw-semibold" style="font-family: Arial, sans-serif;">
                                        {{ $item->name }}
                                    </span>
                                    <small class="text-muted">Qty: {{ $item->qty }}</small>
                                </div>
                            </div>
                            <div>
                                <span class="fw-bold" style="font-family: Arial, sans-serif;">
                                    {{ 'Rs.' . number_format($item->qty * $item->price, 2) }}
                                </span>
                            </div>
                        </div>
                    @endforeach

                    @php
                        $totalProducts = $cartItems->count();
                        $totalItems = $cartItems->sum('qty');
                    @endphp

                    <!-- Subtotal -->
                    <div class="d-flex justify-content-between py-2 border-bottom">
                        <span style="font-family: Arial, sans-serif;">
                            Subtotal ({{ $totalProducts }} {{ Str::plural('Product', $totalProducts) }} /
                            {{ $totalItems }} {{ Str::plural('Item', $totalItems) }})
                        </span>
                        <span class="fw-bold" style="font-family: Arial, sans-serif;">
                            {{ 'Rs.' . number_format($subtotal, 2) }}
                        </span>
                    </div>

                    <!-- Shipping -->
                    <div class="d-flex justify-content-between py-2 border-bottom">
                        <span style="font-family: Arial, sans-serif;">Shipping</span>
                        <span class="fw-bold" style="font-family: Arial, sans-serif;">
                            {{ 'Rs.' . number_format($shipping, 2) }}
                        </span>
                    </div>

                    <!-- Total -->
                    <div class="d-flex justify-content-between py-2">
                        <span class="fs-5 fw-bold" style="font-family: Arial, sans-serif;">Total</span>
                        <span class="fs-5 fw-bold" style="font-family: Arial, sans-serif;">
                            {{ 'Rs.' . number_format($total, 2) }}
                        </span>
                    </div>

                    <!-- Place Order Button -->
                    <button type="submit" class="btn-outline-black w-100 mt-3" style="font-family:Arial, sans-serif">
                        PLACE ORDER <i class="bi bi-check-circle ms-1"></i>
                    </button>
                </div>



            </div>
        </form>
    </div>


@endsection
