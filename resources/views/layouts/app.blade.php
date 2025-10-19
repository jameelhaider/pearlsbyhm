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
    * {
        font-family: 'Arimo', sans-serif !important;
    }

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

<style>
    .breadcrumb {
        background: transparent;
        margin-bottom: 1rem;
        font-size: 15px;
    }

    .breadcrumb-item+.breadcrumb-item::before {
        content: "›";
        color: #6c757d;
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
    <a href="https://wa.me/923158425273" target="_blank"
        class="btn btn-success shadow-lg d-flex align-items-center justify-content-center rounded-0 floating-btn whatsapp-btn">
        <i class="bi bi-whatsapp fs-3"></i>
    </a>

    <!-- Cart Button (Bottom Right) -->
    @if (!request()->routeIs('cart.index'))
        <a href="{{ route('cart.index') }}"
            class="btn btn-dark shadow-lg d-flex align-items-center justify-content-center rounded-0 floating-btn cart-btn position-fixed">
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
                <a class="navbar-brand" href="{{ url('/') }}"><img src="{{ asset('uploads/c2.png') }}" height="60px" width="70px" alt=""> <span style="font-size: 20px" class="fw-bold">Pearls By HM</span></a>

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
                            <a class="nav-link mt-2 {{ Route::is('welcome') ? 'active text-dark' : '' }}"
                                style="font-size: 1.2rem;" href="{{ route('welcome') }}">
                                {{ __('Home') }}
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link mt-2 {{ Route::is('track.order') ? 'active text-dark' : '' }}"
                                style="font-size: 1.2rem;" href="{{ route('track.order') }}">
                                {{ __('Track My Order') }}
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link mt-2 {{ Route::is('wishlist.index') ? 'active text-dark' : '' }}"
                                style="font-size: 1.2rem;" href="{{ route('wishlist.index') }}">
                                {{ __('Wish List') }}
                            </a>
                        </li>


                        <li class="nav-item">
                            <a class="nav-link" href="#" data-bs-toggle="offcanvas"
                                data-bs-target="#offcanvasLogin" aria-controls="offcanvasLogin">
                                <i class="bi bi-person" style="font-size: 1.7rem;"></i>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ Route::is('cart.index') ? 'active text-dark' : '' }}"
                                href="{{ route('cart.index') }}">
                                <i class="bi bi-cart" style="font-size: 1.7rem;"></i>
                                <span class="badge bg-dark rounded-0">{{ getCartItemCount() }}</span>
                            </a>
                        </li>


                    </ul>
                </div>
            </div>
        </nav>



        {{-- //categories --}}
        <div class="d-none d-lg-block d-xl-block d-md-block">
            <div class="p-2 bg-light d-flex justify-content-center gap-5 position-relative">
                <div>
                    <a href="{{ route('products.all') }}" class="category-link">
                        All Products
                    </a>
                </div>
                @foreach (getCategories() as $category)
                    <div class="dropdown">
                        <a href="{{ url('category/' . $category->url) }}" class="category-link">
                            {{ $category->name }}
                        </a>
                        @if ($category->children->count() > 0)
                            <ul class="dropdown-menu p-2">
                                @foreach ($category->children as $subcategory)
                                    <li class="dropdown-submenu position-relative">
                                        <a class="dropdown-item d-flex justify-content-between align-items-center"
                                            href="{{ url('category/' . $subcategory->url) }}">
                                            <span>{{ $subcategory->name }}</span>
                                            @if ($subcategory->children->count() > 0)
                                                <span class="submenu-arrow">›</span>
                                            @endif
                                        </a>
                                        @if ($subcategory->children->count() > 0)
                                            <ul class="dropdown-menu p-2 sub-submenu">
                                                @foreach ($subcategory->children as $subsubcategory)
                                                    <li>
                                                        <a class="dropdown-item"
                                                            href="{{ url('category/' . $subsubcategory->url) }}">
                                                            {{ $subsubcategory->name }}
                                                        </a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>



        <style>
            /* ===== GENERAL STYLING ===== */
            .category-link {
                text-decoration: none;
                color: #000;
                font-weight: 600;
                cursor: pointer;
                padding: 8px 12px;
                display: inline-block;
                transition: color 0.2s ease;
            }

            .category-link:hover {
                color: #007bff;
            }

            /* ===== DROPDOWN CORE BEHAVIOR ===== */
            .dropdown:hover>.dropdown-menu {
                display: block;
            }

            .dropdown-submenu:hover>.dropdown-menu {
                display: flex;
            }

            .dropdown-menu {
                display: none;
                position: absolute;
                top: 100%;
                left: 0;
                min-width: 220px;
                background: #fff;
                box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
                border-radius: 6px;
                z-index: 1000;
                padding: 8px 0;
                flex-direction: column;
                flex-wrap: wrap;
                /* makes long lists wrap instead of overflow */
                white-space: normal !important;
            }

            .dropdown-item {
                cursor: pointer;
                padding: 6px 12px;
                white-space: normal;
                word-break: break-word;
                transition: background-color 0.2s;
            }

            .dropdown-item:hover {
                background-color: #f8f9fa;
            }

            /* ===== REMOVE DEFAULT BOOTSTRAP TOGGLE ARROW ===== */
            .dropdown-toggle::after {
                display: none !important;
            }

            /* ===== SUB-SUBMENU OPENING TO RIGHT ===== */
            .dropdown-submenu>.dropdown-menu {
                top: 0;
                left: 100%;
                margin-left: 2px;
                min-width: 220px;
            }

            /* ===== ARROW FOR SUBCATEGORIES WITH CHILDREN ===== */
            .submenu-arrow {
                font-size: 14px;
                color: #888;
                transition: transform 0.2s ease, color 0.2s ease;
            }

            .dropdown-submenu:hover>a>.submenu-arrow {
                transform: translateX(2px);
                color: #007bff;
            }

            /* ===== OPTIONAL STYLING FOR RESPONSIVE WRAP ===== */
            @media (max-width: 768px) {

                .dropdown-menu,
                .sub-submenu {
                    position: static;
                    box-shadow: none;
                    flex-wrap: wrap;
                }
            }
        </style>



        <main>
            @if (session('success'))
                <div class="alert alert-success text-center">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger text-center">{{ session('error') }}</div>
            @endif







            @if (Request::is('/') && getslides()->count() > 0)
                <div class="carousel slide mt-1" id="slider" data-bs-ride="carousel">
                    <ul class="carousel-indicators">
                        @foreach (getslides() as $key => $slide)
                            <li class="@if ($loop->first) active @endif"
                                data-bs-slide-to="{{ $key }}" data-bs-target="#slider"></li>
                        @endforeach
                    </ul>
                    <div class="carousel-inner carousel-fade">
                        @foreach (getslides() as $slide)
                            <div class="carousel-item @if ($loop->first) active @endif">
                                @if ($slide->link)
                                    <a href="{{ $slide->link }}" class="nav-link">
                                        <img class="d-block w-100 img-fluid" src="{{ $slide->image }}"
                                            alt="Slide Image">
                                    </a>
                                @else
                                    <img class="d-block w-100 img-fluid" src="{{ $slide->image }}" alt="Slide Image">
                                @endif




                                @if ($slide->text || $slide->link)
                                    <div class="carousel-caption">
                                        @if ($slide->text)
                                            <h5 class="text-white mb-2">{{ $slide->text }}</h5>
                                        @endif


                                    </div>
                                @endif


                            </div>
                        @endforeach
                    </div>

                    <button class="carousel-control-next" data-bs-slide="next" data-bs-target="#slider">
                        <span class="carousel-control-next-icon"></span>
                    </button>
                    <button class="carousel-control-prev" data-bs-slide="prev" data-bs-target="#slider">
                        <span class="carousel-control-prev-icon"></span>
                    </button>
                </div>
            @endif

            <style>
                .carousel-item img {
                    pointer-events: none;
                    user-drag: none;
                    -webkit-user-drag: none;
                }
            </style>

            <script>
                document.addEventListener('contextmenu', function(e) {
                    if (e.target.tagName === 'IMG' && e.target.closest('.carousel-item')) {
                        e.preventDefault();
                    }
                });
            </script>



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



            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                aria-label="Close"></button>
        </div>

        <div class="offcanvas-body p-0">

            @guest
                <div class="p-3">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="email" class="custom-font my-2">Your Email Address <span
                                    class="text-danger">*</span></label>
                            <input id="email" type="email"
                                class="form-control @error('email') is-invalid @enderror" name="email"
                                value="{{ old('email') }}" required autocomplete="email" autofocus>
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
                        CREATE ACCOUNT
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

                <li class="list-group-item {{ request()->routeIs('products.all') ? 'active' : '' }}">
                    <a href="{{ route('products.all') }}"
                        class="text-decoration-none d-block {{ request()->routeIs('products.all') ? 'text-white' : 'text-dark' }}">
                        All Products
                    </a>
                </li>

                <li class="list-group-item {{ request()->routeIs('shop.category') ? 'active' : '' }}">
                    <a href="{{ route('shop.category') }}"
                        class="text-decoration-none d-block {{ request()->routeIs('shop.category') ? 'text-white' : 'text-dark' }}">
                        Shop By Category
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












    <!-- Footer -->
    <footer class="bg-dark text-light pt-5 pb-4">
        <div class="container text-center text-md-start">
            <div class="row">

                <!-- Brand / About -->
                <div class="col-md-4 mb-4">
                    <h5 class="fw-bold text-uppercase mb-3">Pearls By HM</h5>
                    <p class="small text-light">
                        We bring you premium quality products with fast delivery and reliable customer service across
                        Pakistan.
                    </p>
                    <div>
                        <a href="#" class="text-light me-3 fs-5"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="text-light me-3 fs-5"><i class="bi bi-instagram"></i></a>
                        <a href="https://wa.me/923158425273" target="_BLANK" class="text-light fs-5"><i class="bi bi-whatsapp"></i></a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div class="col-md-3 mb-4">
                    <h6 class="fw-bold text-uppercase mb-3">Quick Links</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="{{ route('welcome') }}" class="footer-link">Home</a></li>
                        <li class="mb-2"><a href="{{ route('cart.index') }}" class="footer-link">My Cart</a></li>
                        <li class="mb-2"><a href="{{ route('wishlist.index') }}" class="footer-link">My
                                Wishlist</a></li>
                        <li class="mb-2"><a href="{{ route('track.order') }}" class="footer-link">Track My
                                Order</a></li>
                    </ul>
                </div>

                <!-- Customer Support -->
                <div class="col-md-3 mb-4">
                    <h6 class="fw-bold text-uppercase mb-3">Customer Support</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#" class="footer-link">FAQs</a></li>
                        <li class="mb-2"><a href="#" class="footer-link">Return Policy</a></li>
                        <li class="mb-2"><a href="#" class="footer-link">Shipping Info</a></li>
                        <li class="mb-2"><a href="#" class="footer-link">Privacy Policy</a></li>
                    </ul>
                </div>

                <!-- Contact -->
                <div class="col-md-2 mb-4">
                    <h6 class="fw-bold text-uppercase mb-3">Contact</h6>
                    <p class="small mb-1"><i class="bi bi-geo-alt-fill me-2"></i>Gujranwala, Pakistan</p>
                    <p class="small mb-1"><i class="bi bi-telephone-fill me-2"></i>+92 315 8425273</p>
                </div>

            </div>
        </div>

        <hr class="border-light opacity-25">

        <!-- Bottom -->
        <div class="text-center small text-light">
            © <span id="year"></span> Pearls By HM. All Rights Reserved. <br>
            Developed by
            <a href="https://wa.me/923366886889" target="_blank"
                class="text-success text-decoration-none fw-semibold">
                JH Developers
            </a>
        </div>
    </footer>


    <style>
        .footer-link {
            color: #bbb;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .footer-link:hover {
            color: #fff;
            text-decoration: underline;
        }

        footer .bi {
            transition: color 0.3s ease, transform 0.3s ease;
        }

        footer .bi:hover {
            color: #0d6efd;
            transform: translateY(-3px);
        }

        footer hr {
            margin-top: 1rem;
            margin-bottom: 1rem;
        }
    </style>

    <script>
        // Auto-update copyright year
        document.getElementById("year").textContent = new Date().getFullYear();
    </script>

</body>

</html>
