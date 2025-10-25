@extends('layouts.app')
@section('title', 'Terms & Conditions - '.site_name())

@section('content')
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mt-2">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Terms & Conditions</li>
            </ol>
        </nav>

        <h3 class="mb-4 fw-bold" style="font-family: Arial, sans-serif">Terms & Conditions</h3>
        <p style="font-family: Arial, sans-serif; line-height: 1.7;"> Welcome to <strong>{{ site_name() }}</strong>. By accessing
            or making a purchase through our website, you agree to comply with and be bound by the following Terms and
            Conditions. Our platform is dedicated to offering high-quality handmade bracelets and jewelry items. All
            products displayed are subject to availability and may vary slightly in color or design due to the nature of
            materials used. Prices, promotions, and product details may change without prior notice. By placing an order,
            you confirm that all information provided is accurate and complete. Payments must be made through the secure
            methods provided on our website. {{ site_name() }} reserves the right to cancel or refuse any order at our
            discretion. We are not responsible for delays or damages caused by third-party shipping carriers. Please review
            our <a href="/privacy-policy">Privacy Policy</a> for details on how we handle your personal data. Your continued
            use of our website constitutes acceptance of these Terms and any future updates. </p>
    </div>
@endsection
