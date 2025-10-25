@extends('layouts.app')
@section('title', 'Create Account - '.site_name())
@section('content')
    <div class="container py-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Sign Up</li>
            </ol>
        </nav>
        <div class="row justify-content-center">
            <h4 class="text-center fw-bold" style="font-family: Arimo, sans-serif;letter-spacing: 1px;">CREATE ACCOUNT</h4>
            <p class="text-center mt-4" style="font-family: Arimo, sans-serif">Please register below to create an account
            </p>
            <div class="col-md-8 col-lg-5 mt-2 col-12 col-sm-11 col-xl-5">
                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="row mb-3">
                        <div class="col-lg-12">
                            <label for="" class="custom-font my-2">Your Name <span
                                    class="text-danger">*</span></label>
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                                name="name" value="{{ old('name') }}" required autocomplete="name">
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-lg-12">
                            <label for="" class="custom-font my-2">Your Email Address <span
                                    class="text-danger">*</span></label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                name="email" value="{{ old('email') }}" required autocomplete="email">
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-lg-12">
                            <label for="" class="custom-font my-2">Password <span
                                    class="text-danger">*</span></label>
                            <input id="password" type="password"
                                class="form-control @error('password') is-invalid @enderror" name="password" required
                                autocomplete="new-password">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-lg-12">
                            <label for="" class="custom-font my-2">Confirm Password <span
                                    class="text-danger">*</span></label>
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation"
                                required autocomplete="new-password">
                        </div>
                    </div>

                    <div class="row mb-0">
                        <div class="col-lg-12">

                            <style>
                                .btn-create-account {
                                    display: inline-block;
                                    background-color: #000;
                                    color: #fff;
                                    font-family: 'Montserrat', Arial, sans-serif;
                                    letter-spacing: 2px;
                                    text-transform: uppercase;
                                    padding: 12px 45px;
                                    border: 1px solid transparent;
                                    border-radius: 0;
                                    font-size: 15px;
                                    box-shadow: none;
                                    text-align: center;
                                    cursor: pointer;
                                    transition: background-color 0.4s ease, color 0.4s ease, border-color 0.4s ease;
                                }

                                .btn-create-account:hover {
                                    background-color: #fff;
                                    color: #000;
                                    border-color: #000;
                                    opacity: 0.9;
                                }
                            </style>


                            <button type="submit" class="btn-create-account mt-2">
                                CREATE AN ACCOUNT
                            </button>

                            <a href="{{ route('login') }}" class="text-dark ms-2 custom-font">Already Have An Account?</a>

                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
