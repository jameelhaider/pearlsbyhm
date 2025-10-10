@extends('layouts.app')
@section('title', 'My Addresses - Pearls By HM')

@section('content')
    <div class="container-fluid py-4 px-4">
        {{-- Breadcrumb --}}
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Addresses</li>
            </ol>
        </nav>

        {{-- Page Heading --}}
        <div class="text-center mb-4">
            <h4 class="fw-bold" style="font-family: Arimo, sans-serif; letter-spacing: 1px;">MY ADDRESSES</h4>
        </div>



        @if ($myaddresses->count() > 0)
            {{-- Address Section --}}
            <div class="d-flex justify-content-center mb-3">
                <a href="{{ route('address.create') }}" class="btn-solid-black nav-link w-100 px-4">ADD NEW ADDRESS</a>
            </div>
            <div class="row g-3 justify-content-center">
                @foreach ($myaddresses as $key => $address)
                    <div class="col-lg-4 col-md-6 col-sm-10">
                        <div class="card border-0 rounded-0 shadow h-100">
                            <div class="card-body">
                                <h5 class="fw-bold mb-2" style="font-family: Arial, sans-serif">
                                    {{ $address->first_name }} {{ $address->last_name }}
                                </h5>
                                <p class="mb-1 text-muted" style="font-family: Arial, sans-serif">
                                    <strong class="text-dark">Phone:</strong> {{ $address->phone }}
                                </p>
                                <p class="mb-1 text-muted" style="font-family: Arial, sans-serif">
                                    <strong class="text-dark">Address:</strong> {{ $address->address }}
                                    @if (!empty($address->landmark))
                                        , {{ $address->landmark }}
                                    @endif
                                    @if (!empty($address->postal_code))
                                        , {{ $address->postal_code }}
                                    @endif
                                </p>

                                <div class="d-flex justify-content-between align-items-center mt-3">
                                    <a href="{{ route('address.edit', ['id' => $address->id]) }}"
                                        class="btn-outline-black nav-link px-3 py-1 rounded-0">EDIT</a>

                                    <form action="{{ route('address.delete', ['id' => $address->id]) }}" method="post"
                                        onsubmit="return confirm('Are you sure you want to delete this address?');">
                                        @csrf
                                        <button type="submit" class="btn-solid-black px-3 py-1 rounded-0">DELETE</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            {{-- Empty State --}}
            <div class="text-center my-5">
                <i class="bi bi-emoji-frown" style="font-size: 110px;"></i>
                <h2 class="text-dark fw-bold" style="font-family: Arial, sans-serif;">Your Address Book is empty</h2>
                <p class="text-secondary" style="font-family: Arial, sans-serif;">
                    Looks like you haven't added any address yet.
                </p>
                <a href="{{ route('address.create') }}" class="btn-solid-black w-50 nav-link mt-3">
                    ADD ADDRESS
                </a>
            </div>
        @endif
    </div>
@endsection
