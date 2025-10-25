@extends('layouts.app')
@section('title', 'Shipping Policy - '.site_name())

@section('content')
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mt-2">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Shipping Policy</li>
            </ol>
        </nav>


        <h3 class="mb-4 fw-bold" style="font-family: Arial, sans-serif">Shipping Policy</h3>
        <p style="font-family: Arial, sans-serif; line-height: 1.7;">“Cash On Delivery” orders will be processed after
            successful telephonic verification. However, Pearls By HM holds the right
            to process “Cash on Delivery” orders without telephonic verification for verified customers and/or during a
            period of high volume that includes sales, season launches, and other promotions.
            Shipping The customer usually gets an order in 7 business days after the order has shipped out. This is just an
            estimate and does not include weekends and holidays.</p>
        <h4 class="mb-4 fw-normal" style="font-family: Arial, sans-serif">Order Tracking</h4>
        <p style="font-family: Arial, sans-serif; line-height: 1.7;">Shortly after placing your order, you will receive an
            email with your
            order number and an order tracking number (if a valid email address was supplied). During the transit of your
            package, you may enter that number into our Order Tracking section to check your order status.</p>
    </div>
@endsection
