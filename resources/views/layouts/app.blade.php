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











    <!-- ================= Floating Action Buttons ================= -->

    <!-- WhatsApp Button (Bottom Left) -->
    <a href="https://wa.me/923001234567" target="_blank"
        class="btn btn-success shadow-lg d-flex align-items-center justify-content-center floating-btn whatsapp-btn">
        <i class="bi bi-whatsapp fs-3"></i>
    </a>

    <!-- Cart Button (Bottom Right) -->
    @if (!request()->routeIs('cart.index'))
        <a href="{{ route('cart.index') }}"
            class="btn btn-dark shadow-lg d-flex align-items-center justify-content-center floating-btn cart-btn position-fixed">
            <i class="bi bi-cart fs-4"></i>

            @php $cartCount = getCartItemCount(); @endphp
            @if ($cartCount > 0)
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                    {{ $cartCount }}
                </span>
            @endif
        </a>
    @endif


    <!-- ================= Styles ================= -->
    <style>
        /* Common Floating Button Style */
        .floating-btn {
            width: 56px;
            height: 56px;
            border-radius: 50%;
            z-index: 1055;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .floating-btn:hover {
            transform: scale(1.1);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.25);
        }

        /* WhatsApp Button (Bottom Left) */
        .whatsapp-btn {
            position: fixed;
            bottom: 20px;
            left: 20px;
            background-color: #25D366;
            border: none;
        }

        /* Cart Button (Bottom Right) */
        .cart-btn {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background-color: #000;
            border: none;
        }

        /* Badge Styling */
        .cart-btn .badge {
            font-size: 0.7rem;
            padding: 0.3em 0.5em;
        }
    </style>








    <div id="app">
        <div class="py-1" style="background-color: #000;color:white">
            <h5 class="text-center mt-1" style="font-family: Arial, sans-serif">Free delivery on order above 2000.</h5>
        </div>
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container-fluid">
                <a class="navbar-brand" href="{{ url('/') }}">Pearls By HM</a>

                {{-- <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button> --}}

                <!-- Offcanvas Toggler Button -->
                <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas"
                    data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
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

        <div class="offcanvas-body p-0">

            @guest
                <div class="p-3">
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
                            <label for="password" class="custom-font my-2">Password <span
                                    class="text-danger">*</span></label>
                            <input id="password" type="password"
                                class="form-control @error('password') is-invalid @enderror" name="password" required
                                autocomplete="current-password">
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
                </div>
            @else
                <ul class="list-group list-group-flush">

                    <li class="list-group-item {{ request()->routeIs('accounts.index') ? 'active' : '' }}"
                        style="font-family: Arial, sans-serif;">
                        <a href="{{ route('accounts.index') }}"
                            class="text-decoration-none d-block {{ request()->routeIs('accounts.index') ? 'text-white' : 'text-dark' }}">
                            Account Details
                        </a>
                    </li>

                    <li class="list-group-item {{ request()->routeIs('address.index') ? 'active' : '' }}"
                        style="font-family: Arial, sans-serif;">
                        <a href="{{ route('address.index') }}"
                            class="text-decoration-none d-block {{ request()->routeIs('address.index') ? 'text-white' : 'text-dark' }}">
                            My Addresses
                        </a>
                    </li>

                    <li class="list-group-item {{ request()->routeIs('myorders.index') ? 'active' : '' }}"
                        style="font-family: Arial, sans-serif;">
                        <a href="{{ route('myorders.index') }}"
                            class="text-decoration-none d-block {{ request()->routeIs('myorders.index') ? 'text-white' : 'text-dark' }}">
                            My Orders
                        </a>
                    </li>

                    <li class="list-group-item {{ request()->routeIs('password.request') ? 'active' : '' }}"
                        style="font-family: Arial, sans-serif;">
                        <a href="{{ route('password.request') }}"
                            class="text-decoration-none d-block {{ request()->routeIs('password.request') ? 'text-white' : 'text-dark' }}">
                            Reset Your Password
                        </a>
                    </li>

                    <li class="list-group-item {{ request()->routeIs('change.password') ? 'active' : '' }}"
                        style="font-family: Arial, sans-serif;">
                        <a href="{{ route('change.password') }}"
                            class="text-decoration-none d-block {{ request()->routeIs('change.password') ? 'text-white' : 'text-dark' }}">
                            Change Your Password
                        </a>
                    </li>

                    <li class="list-group-item" style="font-family: Arial, sans-serif;">
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














    <!-- ================= Offcanvas Sidebar ================= -->
    <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasNavbar"
        aria-labelledby="offcanvasNavbarLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Menu</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>

        <div class="offcanvas-body p-0">

            <!-- ===== Public Links ===== -->
            <ul class="list-group list-group-flush">

                <li class="list-group-item {{ request()->routeIs('welcome') ? 'active' : '' }}">
                    <a href="{{ route('welcome') }}"
                        class="text-decoration-none d-block {{ request()->routeIs('welcome') ? 'text-white' : 'text-dark' }}">
                        Home
                    </a>
                </li>

                <li class="list-group-item {{ request()->routeIs('track.order') ? 'active' : '' }}">
                    <a href="{{ route('track.order') }}"
                        class="text-decoration-none d-block {{ request()->routeIs('track.order') ? 'text-white' : 'text-dark' }}">
                        Track My Order
                    </a>
                </li>

                <li class="list-group-item {{ request()->routeIs('wishlist.index') ? 'active' : '' }}">
                    <a href="{{ route('wishlist.index') }}"
                        class="text-decoration-none d-block {{ request()->routeIs('wishlist.index') ? 'text-white' : 'text-dark' }}">
                        My Wishlist
                    </a>
                </li>

                <li class="list-group-item {{ request()->routeIs('cart.index') ? 'active' : '' }}">
                    <a href="{{ route('cart.index') }}"
                        class="text-decoration-none d-block {{ request()->routeIs('cart.index') ? 'text-white' : 'text-dark' }}">
                        My Cart
                        <span
                            class="badge float-end rounded-0 {{ request()->routeIs('cart.index') ? 'bg-white text-dark' : 'bg-dark text-white' }}">
                            {{ getCartItemCount() }}
                        </span>
                    </a>
                </li>

                @guest
                    <li class="list-group-item {{ request()->routeIs('login') ? 'active' : '' }}">
                        <a href="{{ route('login') }}"
                            class="text-decoration-none d-block {{ request()->routeIs('login') ? 'text-white' : 'text-dark' }}">
                            Login
                        </a>
                    </li>

                    <li class="list-group-item {{ request()->routeIs('register') ? 'active' : '' }}">
                        <a href="{{ route('register') }}"
                            class="text-decoration-none d-block {{ request()->routeIs('register') ? 'text-white' : 'text-dark' }}">
                            Register
                        </a>
                    </li>
                @else
                    <li class="list-group-item {{ request()->routeIs('accounts.index') ? 'active' : '' }}">
                        <a href="{{ route('accounts.index') }}"
                            class="text-decoration-none d-block {{ request()->routeIs('accounts.index') ? 'text-white' : 'text-dark' }}">
                            Account Details
                        </a>
                    </li>

                    <li class="list-group-item {{ request()->routeIs('address.index') ? 'active' : '' }}">
                        <a href="{{ route('address.index') }}"
                            class="text-decoration-none d-block {{ request()->routeIs('address.index') ? 'text-white' : 'text-dark' }}">
                            My Addresses
                        </a>
                    </li>

                    <li class="list-group-item {{ request()->routeIs('myorders.index') ? 'active' : '' }}">
                        <a href="{{ route('myorders.index') }}"
                            class="text-decoration-none d-block {{ request()->routeIs('myorders.index') ? 'text-white' : 'text-dark' }}">
                            My Orders
                        </a>
                    </li>

                    <li class="list-group-item {{ request()->routeIs('password.request') ? 'active' : '' }}">
                        <a href="{{ route('password.request') }}"
                            class="text-decoration-none d-block {{ request()->routeIs('password.request') ? 'text-white' : 'text-dark' }}">
                            Reset Your Password
                        </a>
                    </li>

                    <li class="list-group-item {{ request()->routeIs('change.password') ? 'active' : '' }}">
                        <a href="{{ route('change.password') }}"
                            class="text-decoration-none d-block {{ request()->routeIs('change.password') ? 'text-white' : 'text-dark' }}">
                            Change Your Password
                        </a>
                    </li>

                    <li class="list-group-item">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit"
                                class="btn btn-link text-decoration-none text-dark p-0 m-0 d-block text-start">
                                Log Out
                            </button>
                        </form>
                    </li>
                @endguest
            </ul>


        </div>
    </div>

    <!-- ================= Styles ================= -->
    <style>
        .list-group-item {
            font-family: Arial, sans-serif;
            transition: background-color 0.2s ease, color 0.2s ease;
        }

        .list-group-item:hover {
            background-color: #f8f9fa;
        }

        .list-group-item.active {
            background-color: #000 !important;
            color: #fff !important;
            border-color: #000 !important;
        }

        .list-group-item.active a {
            color: #fff !important;
        }

        .offcanvas {
            width: 280px;
        }
    </style>


</body>

</html>
