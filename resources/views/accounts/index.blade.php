@extends('layouts.app')
@section('title', 'Accounts - Pearls By HM')
@section('content')
    <div class="container-fluid py-4 px-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Accounts</li>
            </ol>
        </nav>

        <div class="row justify-content-center">
            <h4 class="text-center fw-bold" style="font-family: Arial, sans-serif;letter-spacing: 1px;">ACCOUNTS
            </h4>
            <h5 style="font-family: Arial, sans-serif">Hi! {{ auth()->user()->name }}</h5>
            <div class="mt-2 d-flex">
                <a href="{{ route('address.index') }}" class="btn-outline-black nav-link w-50">VIEW ADDRESSES</a>
                <a href="{{ route('myorders.index') }}" class="btn-outline-black nav-link w-50">VIEW ORDERS</a>
            </div>
            <div class="mt-2 d-flex">
                <a href="{{ route('change.password') }}" class="btn-outline-black nav-link w-50">CHANGE PASSWORD</a>
                <a href="{{ route('password.request') }}" class="btn-outline-black nav-link w-50">RESET PASSWORD</a>
            </div>

        </div>
    </div>
@endsection
