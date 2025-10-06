<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
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
                            <a class="nav-link" href="{{ route('wishlist.index') }}">{{ __('Wishlist') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('cart.index') }}">{{ __('Cart') }}</a>
                        </li>

                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    {{-- 🔹 Instead of route link, trigger offcanvas --}}
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
                        @endguest
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
            <h5 class="offcanvas-title custom-font" id="offcanvasLoginLabel">Login</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>

        <div class="offcanvas-body p-3">
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
        </div>
    </div>


</body>

</html>
