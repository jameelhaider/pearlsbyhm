@extends('layouts.app')
@section('title', 'Forgot Password - Pearls By HM')
@section('content')
    <div class="container py-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Forgot Password</li>
            </ol>
        </nav>

        <div class="row justify-content-center">
            <h4 class="text-center fw-bold" style="font-family: Arimo, sans-serif;letter-spacing: 1px;">RESET YOUR PASSWORD
            </h4>
            <p class="text-center mt-4" style="font-family: Arimo, sans-serif">We will send you an email to reset your
                password enter email to get your account back</p>

            <div class="col-md-8 col-lg-5 mt-2 col-12 col-sm-11 col-xl-5">
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}">
                    @csrf

                    <div class="row mb-3">
                        <div class="col-lg-12">
                            <label for="" class="custom-font my-2">Your Email Address <span
                                    class="text-danger">*</span></label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-0">
                        <div class="col-lg-12">

                            <style>
                                .btn-create-account {
                                    display: inline-block;
                                    background-color: #fff;
                                    color: #000;
                                    font-family: 'Montserrat', Arial, sans-serif;
                                    letter-spacing: 2px;
                                    padding: 12px 45px;
                                    border: 1px solid #000;
                                    border-radius: 0;
                                    font-size: 15px;
                                    box-shadow: none;
                                    text-align: center;
                                    cursor: pointer;
                                    transition:
                                        background-color 0.4s ease,
                                        color 0.4s ease,
                                        border-color 0.4s ease,
                                        opacity 0.4s ease;
                                }

                                .btn-create-account:hover {
                                    background-color: #000;
                                    color: #fff;
                                    border-color: #000;
                                    opacity: 0.9;
                                }
                            </style>


                            <button type="submit" class="btn-create-account mt-2">
                                Send Password Reset Link
                            </button>
                            @if (Auth::check())
<a class="text-dark ms-3 custom-font" href="{{ route('accounts.index') }}">
                                {{ __('Cancel') }}
                            </a>
                            @else
                            <a class="text-dark ms-3 custom-font" href="{{ route('login') }}">
                                {{ __('Cancel') }}
                            </a>
                            @endif

                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection
