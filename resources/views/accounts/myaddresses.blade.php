@extends('layouts.app')
@section('title', 'My Addresses - Pearls By HM')
@section('content')
    <div class="container-fluid py-4 px-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Addresses</li>
            </ol>
        </nav>

        <div class="row justify-content-center">
            <h4 class="text-center fw-bold" style="font-family: Arimo, sans-serif;letter-spacing: 1px;">MY ADDRESSES
            </h4>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th class="text-center">#</th>
                        <th>NAME</th>
                        <th>PHONE</th>
                        <th>ADDRESS</th>
                        <th class="text-center">ACTIONS</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($myaddresses as $key => $address)
                        <tr>
                            <th class="text-center" style="font-family: Arial, sans-serif">{{ ++$key }}</th>
                            <td style="font-family: Arial, sans-serif">
                                {{ $address->first_name . ' ' . $address->last_name }}</td>
                            <td style="font-family: Arial, sans-serif">{{ $address->phone }}</td>
                            <td style="font-family: Arial, sans-serif">
                                {{ $address->address }}
                                @if (!empty($address->landmark))
                                    | {{ $address->landmark }}
                                @endif
                                @if (!empty($address->postal_code))
                                    | {{ $address->postal_code }}
                                @endif
                            </td>


                            <td class="text-center"><a href="" class="btn-outline-black nav-link">EDIT ADDRESS</a>
                            </td>


                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>
@endsection
