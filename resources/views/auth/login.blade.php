@extends('layouts.app')
@section('title', 'Sign In - '.site_name())
@section('content')
    <div class="container py-4">
           <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Sign In</li>
            </ol>
        </nav>

        <div class="row justify-content-center">
            <h4 class="text-center fw-bold" style="font-family: Arimo, sans-serif;letter-spacing: 1px;">SIGN IN TO YOUR
                ACCOUNT</h4>
            <p class="text-center mt-4" style="font-family: Arimo, sans-serif">Please enter your email and password below to
                access your account</p>
            <div class="col-md-8 col-lg-5 mt-2 col-12 col-sm-11 col-xl-5">
                <form method="POST" action="{{ route('login') }}">
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

                    <div class="row mb-3">

                        <div class="col-lg-12">
                            <label for="" class="custom-font my-2">Password <span
                                    class="text-danger">*</span></label>
                            <input id="password" type="password"
                                class="form-control @error('password') is-invalid @enderror" name="password" required
                                autocomplete="current-password">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-lg-12">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                    {{ old('remember') ? 'checked' : '' }}>

                                <label class="form-check-label custom-font" for="remember">
                                   Remember Me
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-0">
                        <div class="col-lg-12 text-center">
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

                                /* ✅ Style for the links under the button */
                                .auth-links {
                                    display: flex;
                                    justify-content: center;
                                    gap: 20px;
                                    margin-top: 10px;
                                    flex-wrap: wrap;
                                    /* makes it responsive on small screens */
                                }

                                .auth-links a {
                                    color: #000;
                                    text-decoration: none;
                                    font-family: 'Arimo', sans-serif;
                                    font-size: 14px;
                                    transition: color 0.3s ease;
                                }

                                .auth-links a:hover {
                                    color: #555;
                                    text-decoration: underline;
                                }
                            </style>

                            <button type="submit" class="btn-create-account mt-2">
                                SIGN IN
                            </button>

                            <div class="auth-links">
                                @if (Route::has('password.request'))
                                    <a href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                                <a href="{{ route('register') }}">
                                    {{ __("Don't Have An Account?") }}
                                </a>
                            </div>
                        </div>
                    </div>


                </form>
            </div>
        </div>
    </div>
@endsection
