@extends('layouts.app')
@section('title', 'Order Cancel Policy - '.site_name())

@section('content')
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mt-2">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Order Cancel Policy</li>
            </ol>
        </nav>

        <h3 class="mb-4 fw-bold" style="font-family: Arial, sans-serif;">Order Cancel Policy</h3>

        <div class="mb-4" style="font-family: Arial, sans-serif; line-height: 1.7;">
            <p>
                At <strong>{{ site_name() }}</strong>, we understand that sometimes you may need to cancel an order.
                However, to ensure smooth operations and timely deliveries, we have a clear order cancellation policy.
            </p>

            <p>
                Customers can request order cancellation <strong>only before the order is shipped</strong>.
                If your order status is <span class="text-success">Pending</span>, <span class="text-success">In Process</span>
                you may request cancellation by contacting our <strong>Support Team</strong>.
                Please note that customers <u>cannot directly cancel orders</u> through the website;
                cancellation requests must be made via customer support.
            </p>

            <p>
                Once your order status is (status:
                <span class="text-danger">Packed, Ready To Ship</span>,
                <span class="text-danger">Sent To Parcel Delivered Company</span> or
                <span class="text-danger">Delivered</span>), it <strong>cannot be cancelled</strong>.
            </p>
        </div>

        <h5 class="fw-bold mb-3" style="font-family: Arial, sans-serif;">Order Cancellation Eligibility Chart</h5>

        <div class="table-responsive">
            <table class="table table-bordered text-center align-middle" style="font-family: Arial, sans-serif;">
                <thead class="table-dark">
                    <tr>
                        <th>Order Status</th>
                        <th>Can Be Cancelled?</th>
                        <th>Cancellation Method</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Pending</td>
                        <td class="text-success fw-bold">✅ Yes</td>
                        <td>Contact Support Team</td>
                    </tr>
                    <tr>
                        <td>In Process</td>
                        <td class="text-success fw-bold">✅ Yes</td>
                        <td>Contact Support Team</td>
                    </tr>
                    <tr>
                        <td>Packed, Ready To Ship</td>
                        <td class="text-danger fw-bold">❌ No</td>
                        <td>Not Eligible</td>
                    </tr>
                    <tr>
                        <td>Sent To Parcel Delivered Company</td>
                        <td class="text-danger fw-bold">❌ No</td>
                        <td>Not Eligible</td>
                    </tr>
                    <tr>
                        <td>Delivered</td>
                        <td class="text-danger fw-bold">❌ No</td>
                        <td>Not Eligible</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="mt-4" style="font-family: Arial, sans-serif; line-height: 1.7;">
            <p>
                For cancellation requests, please contact
                <a href="https://wa.me/923158425273" target="_BLANK">Start Chat</a>.
            </p>
        </div>
    </div>
@endsection
