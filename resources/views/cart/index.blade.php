@extends('layouts.app')

@section('title', 'My Cart - Pearls By HM')

@section('content')
<div class="container py-4">
    <h3 class="mb-4">🛒 My Cart</h3>

    @if ($items->isEmpty())
        <div class="alert alert-info text-center">
            Your cart is empty 😔
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-bordered align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($items as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ number_format($item->price, 2) }}</td>
                            <td>{{ $item->qty }}</td>
                            <td>{{ number_format($item->price * $item->qty, 2) }}</td>
                            <td>
                                <form action="{{ route('cart.remove', $item->cart_item_id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Remove</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="4" class="text-end">Total:</th>
                        <th colspan="2">{{ number_format($total, 2) }}</th>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div class="text-end">
            <a href="#" class="btn btn-success">Proceed to Checkout</a>
        </div>
    @endif
</div>
@endsection
