@extends('layouts.app')
@if ($address->id)
    @section('title', 'Edit Address - '.site_name())
@else
    @section('title', 'Add Address - '.site_name())
@endif

@section('content')
    <div class="container-fluid py-4 px-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                  <li class="breadcrumb-item"><a href="{{ route('accounts.index') }}">Accounts</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('address.index') }}">Addresses</a></li>
                <li class="breadcrumb-item active" aria-current="page">
                    @if ($address->id)
                        Edit Address
                    @else
                        Add Address
                    @endif
                </li>
            </ol>
        </nav>

        <div class="row justify-content-center">
            <h4 class="text-center fw-bold" style="font-family: Arimo, sans-serif;letter-spacing: 1px;">
                @if ($address->id)
                    EDIT ADDRESS
                @else
                    ADD ADDRESS
                @endif
            </h4>
            <a href="{{ route('address.index') }}" class="btn-solid-black nav-link">BACK TO ADDRESSES</a>
            <div class="card p-3 rounded-0 mt-2">
                <form
                    action="{{ $address->id != null ? route('address.update', ['id' => $address->id]) : route('address.save') }}"
                    method="post">
                    @csrf
                    <div class="row">
                        <div class="col-lg-4 col-md-6 col-12 col-sm-12">
                            <label class="custom-font my-2">First Name <span class="text-danger">*</span></label>
                            <input type="text" name="first_name" value="{{ old('first_name', $address->first_name) }}"
                                class="form-control @error('first_name') is-invalid @enderror" placeholder="First Name">
                            @error('first_name')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <div class="col-lg-4 col-md-6 col-12 col-sm-12">
                            <label class="custom-font my-2">Last Name <span class="text-danger">*</span></label>
                            <input type="text" name="last_name" value="{{ old('last_name', $address->last_name) }}"
                                class="form-control @error('last_name') is-invalid @enderror" placeholder="Last Name">
                            @error('last_name')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <div class="col-lg-4 col-md-12 col-12 col-sm-12">
                            <label class="custom-font my-2">Phone <span class="text-danger">*</span></label>
                            <input type="text" name="phone" value="{{ old('phone', $address->phone) }}"
                                placeholder="0300-0000000" maxlength="12"
                                class="form-control @error('phone') is-invalid @enderror" id="phone">
                            @error('phone')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <script>
                            document.addEventListener("DOMContentLoaded", function() {
                                const phoneInput = document.getElementById('phone');
                                if (!phoneInput.value) {
                                    phoneInput.value = '03';
                                }
                                phoneInput.addEventListener('focus', function() {
                                    if (phoneInput.value === '') {
                                        phoneInput.value = '03';
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
                                phoneInput.addEventListener('keydown', function(e) {
                                    if ((phoneInput.selectionStart <= 2 && (e.key === 'Backspace' || e.key === 'Delete'))) {
                                        e.preventDefault();
                                    }
                                });
                            });
                        </script>


                    </div>

                    <div class="row mt-2">
                        <div class="col-lg-8 col-md-6 col-12 col-sm-12">
                            <label class="custom-font my-2">Address <span class="text-danger">*</span></label>
                            <input type="text" name="address" value="{{ old('address', $address->address) }}"
                                class="form-control @error('address') is-invalid @enderror" placeholder="Address">
                            @error('address')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <div class="col-lg-4 col-md-6 col-12 col-sm-12">
                            <label class="custom-font my-2">City <span class="text-danger">*</span></label>
                            <input type="text" name="city" value="{{ old('city', $address->city) }}"
                                class="form-control @error('city') is-invalid @enderror" placeholder="City Name">
                            @error('city')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col-lg-6 col-md-6 col-12 col-sm-12">
                            <label class="custom-font my-2">Landmark (optional)</label>
                            <input type="text" name="landmark" value="{{ old('landmark', $address->landmark) }}"
                                class="form-control @error('landmark') is-invalid @enderror"
                                placeholder="Apartment, suite, etc. (optional)">
                            @error('landmark')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <div class="col-lg-6 col-md-6 col-12 col-sm-12">
                            <label class="custom-font my-2">Postal Code (optional)</label>
                            <input type="text" name="postal_code"
                                value="{{ old('postal_code', $address->postal_code) }}"
                                class="form-control @error('postal_code') is-invalid @enderror"
                                placeholder="Postal Code (optional)">
                            @error('postal_code')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                    </div>



                    <button type="submit" class="btn-outline-black mt-3 w-100">
                        @if ($address->id)
                            UPDATE ADDRESS
                        @else
                            SAVE ADDRESS
                        @endif
                    </button>



                </form>
            </div>
        </div>
    </div>

@endsection
