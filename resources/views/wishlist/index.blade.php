@extends('layouts.app')

@section('title', 'your Wishlist - Pearls By HM')

@section('content')
    <div class="container py-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Your Wishlist</li>
            </ol>
        </nav>

        <h3 class="mb-4 fw-bold" style="font-family: Arial, sans-serif">Your Wishlist</h3>

        @if ($wishlistItems->isEmpty())
            <div class="alert alert-info text-center">
                Your wishlist is empty 😔
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Product</th>
                            <th>Price</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($wishlistItems as $index => $wishlist)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $wishlist->name }}</td>
                                <td>{{ number_format($wishlist->price, 2) }}</td>
                                <td class="d-flex">
                                    <form action="{{ route('cart.add') }}" method="POST" class="me-1">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $wishlist->product_id }}">
                                        <button type="submit" class="btn btn-sm btn-primary">Move to Cart 🛒</button>
                                    </form>

                                    {{-- Remove --}}
                                    <form action="{{ route('wishlist.remove', $wishlist->wishlist_id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Remove</button>
                                    </form>

                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@endsection
