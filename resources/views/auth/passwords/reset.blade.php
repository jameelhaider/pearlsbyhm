@extends('layouts.app')
@section('title', 'Reset Password - Pearls By HM')
@section('content')
    <div class="container py-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Reset Password</li>
            </ol>
        </nav>

        <div class="row justify-content-center">
            <h4 class="text-center fw-bold" style="font-family: Arimo, sans-serif;letter-spacing: 1px;">SET YOUR NEW PASSWORD
            </h4>
            <p class="text-center mt-4" style="font-family: Arimo, sans-serif">Enter your new password and confirm it to
                change your password</p>

            <div class="col-md-8 col-lg-5 mt-2 col-12 col-sm-11 col-xl-5">

                <form method="POST" action="{{ route('password.update') }}">
                    @csrf

                    <input type="hidden" name="token" value="{{ $token }}">

                    <div class="row mb-3">

                        <div class="col-lg-12">
                            <label for="" class="custom-font my-2">Your Email Address <span
                                    class="text-danger">*</span></label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">

                        <div class="col-lg-12">
                            <label for="" class="custom-font my-2">New Password <span
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
                            <label for="" class="custom-font my-2">Confirm New Password <span
                                    class="text-danger">*</span></label>
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation"
                                required autocomplete="new-password">
                        </div>
                    </div>

                    <div class="row mb-0">
                        <div class="col-lg-12">
                            <button type="submit" class="btn-outline-black w-100">
                                Reset Password
                            </button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection
