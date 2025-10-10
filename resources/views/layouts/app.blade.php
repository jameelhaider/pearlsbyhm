<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('uploads/c2.png') }}" />
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>


    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
</head>

<style>
    .custom-font {
        font-family: Arial, sans-serif;
        letter-spacing: 1px;
        font-size: 13px;
    }

    .form-control {
        height: 50px;
        border-radius: 0;
        box-shadow: none;
        font-size: 13px;
        padding: 16px;
    }

    .form-control:focus {
        border-color: #000;
        box-shadow: none;
    }
</style>

<body>
    <style>
        .loader-wrapper {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(255, 255, 255, 0.8);
            /* Semi-transparent white background */
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            /* Ensure it appears above other elements */
        }

        .loader {
            width: 50px;
            aspect-ratio: 1;
            display: grid;
            border-radius: 50%;
            background: linear-gradient(0deg, rgb(0 0 0/50%) 30%, #0000 0 70%, rgb(0 0 0/100%) 0) 50%/8% 100%,
                linear-gradient(90deg, rgb(0 0 0/25%) 30%, #0000 0 70%, rgb(0 0 0/75%) 0) 50%/100% 8%;
            background-repeat: no-repeat;
            animation: l23 1s infinite steps(12);
        }

        .loader::before,
        .loader::after {
            content: "";
            grid-area: 1/1;
            border-radius: 50%;
            background: inherit;
            opacity: 0.915;
            transform: rotate(30deg);
        }

        .loader::after {
            opacity: 0.83;
            transform: rotate(60deg);
        }

        @keyframes l23 {
            100% {
                transform: rotate(1turn);
            }
        }
    </style>
    {{-- //loader --}}
    <div class="loader-wrapper">
        <div class="loader"></div>
    </div>
    <script>
        function hideLoader() {
            document.querySelector('.loader-wrapper').style.display = 'none';
        }
        setTimeout(function() {
            if (document.readyState === 'complete') {
                hideLoader();
            } else {
                document.onreadystatechange = function() {
                    if (document.readyState === 'complete') {
                        hideLoader();
                    }
                };
            }
        }, 700);
    </script>
    {{-- loader --}}


    <div id="app">
        <div class="py-1" style="background-color: #000;color:white">
            <h5 class="text-center mt-1" style="font-family: Arial, sans-serif">Free delivery on order above 2000.</h5>
        </div>
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container-fluid">
                <a class="navbar-brand" href="{{ url('/') }}">Pearls By HM</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto"></ul>
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link mt-2" style="font-size: 1.2rem;"
                                href="{{ route('track.order') }}">{{ __('Track My Order') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link mt-2" style="font-size: 1.2rem;"
                                href="{{ route('wishlist.index') }}">{{ __('Wish List') }}</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="#" data-bs-toggle="offcanvas"
                                data-bs-target="#offcanvasLogin" aria-controls="offcanvasLogin">
                                <i class="bi bi-person" style="font-size: 1.7rem;"></i>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('cart.index') }}">
                                <i class="bi bi-cart" style="font-size: 1.7rem;"></i>
                                <span class="badge bg-dark rounded-0">{{ getCartItemCount() }}</span>
                            </a>
                        </li>

                        {{-- @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="#" data-bs-toggle="offcanvas"
                                        data-bs-target="#offcanvasLogin" aria-controls="offcanvasLogin">
                                        {{ __('Login') }}
                                    </a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest --}}

                    </ul>
                </div>
            </div>
        </nav>

        <main>
            @if (session('success'))
                <div class="alert alert-success text-center">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger text-center">{{ session('error') }}</div>
            @endif

            @yield('content')
        </main>
    </div>






    <style>
        .btn-outline-black,
        .btn-solid-black {
            display: inline-block;
            font-family: 'Montserrat', Arial, sans-serif;
            letter-spacing: 2px;
            padding: 12px 45px;
            font-size: 15px;
            text-align: center;
            cursor: pointer;
            border-radius: 0;
            box-shadow: none;
            transition: all 0.4s ease;
        }

        .btn-outline-black {
            background-color: #fff;
            color: #000;
            border: 1px solid #000;
        }

        .btn-outline-black:hover {
            background-color: #000;
            color: #fff;
            border-color: #000;
            opacity: 0.9;
        }

        .btn-solid-black {
            background-color: #000;
            color: #fff;
            border: 1px solid transparent;
            text-transform: uppercase;
        }

        .btn-solid-black:hover {
            background-color: #fff;
            color: #000;
            border-color: #000;
            opacity: 0.9;
        }
    </style>
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasLogin" aria-labelledby="offcanvasLoginLabel">
        <div class="offcanvas-header">
            @guest
                <h5 class="offcanvas-title custom-font" id="offcanvasLoginLabel">Login</h5>
            @else
                <h5 class="offcanvas-title fw-bold" style="font-family:Arial, sans-serif" id="offcanvasLoginLabel">
                    Hi, {{ Auth::user()->name }}
                </h5>
            @endguest



            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>

        <div class="offcanvas-body p-3">

            @guest
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="custom-font my-2">Your Email Address <span
                                class="text-danger">*</span></label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                            name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                        @error('email')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="password" class="custom-font my-2">Password <span class="text-danger">*</span></label>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                            name="password" required autocomplete="current-password">
                        @error('password')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
                    <div class="mb-3 form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember2"
                            {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label custom-font" for="remember2">{{ __('Remember Me') }}</label>
                    </div>
                    <button type="submit" class="w-100 btn-solid-black">Log In</button>
                    @if (Route::has('password.request'))
                        <div class="mt-3 text-center">
                            <a class="small text-dark custom-font" href="{{ route('password.request') }}">
                                {{ __('Forgot Your Password?') }}
                            </a>
                        </div>
                    @endif
                </form>
                <a class="btn-outline-black btn mt-3 w-100" href="{{ route('register') }}">
                    Create Account
                </a>
            @else
                <ul class="list-group list-group-flush">
                    <li class="list-group-item" style="font-family:Arial, sans-serif">
                        <a href="{{ route('accounts.index') }}" class="text-decoration-none text-dark d-block">Account Details</a>
                    </li>
                    <li class="list-group-item" style="font-family:Arial, sans-serif">
                        <a href="{{ route('address.index') }}" class="text-decoration-none text-dark d-block">My Addresses</a>
                    </li>
                     <li class="list-group-item" style="font-family:Arial, sans-serif">
                        <a href="{{ route('myorders.index') }}" class="text-decoration-none text-dark d-block">My Orders</a>
                    </li>
                    <li class="list-group-item" style="font-family:Arial, sans-serif">
                        <a href="{{ route('password.request') }}" class="text-decoration-none text-dark d-block">Reset
                            Your Password</a>
                    </li>
                     <li class="list-group-item" style="font-family:Arial, sans-serif">
                        <a href="{{ route('change.password') }}" class="text-decoration-none text-dark d-block">Change
                            Your Password</a>
                    </li>
                    <li class="list-group-item" style="font-family:Arial, sans-serif">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit"
                                class="btn btn-link text-decoration-none text-dark p-0 m-0 d-block text-start">
                                Log Out
                            </button>
                        </form>
                    </li>
                </ul>

            @endguest



        </div>
    </div>


</body>

</html>
