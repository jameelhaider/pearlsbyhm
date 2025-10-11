@extends('admin.layouts.app')
@section('admin_title', 'Admin | Products')
@section('content2')

    <div class="container-fluid px-3">
        <div class="card shadow-sm bg-white rounded-0">
            <div class="row">
                <div class="col-lg-3 col-7 col-md-4 col-sm-5">
                    <a href="{{ route('admin.product.create') }}"
                        class="btn btn-primary custom-back-button d-flex align-items-center justify-content-center">
                        <i class="bx bx-plus me-1"></i> Add New Product
                    </a>
                </div>
                <div class="col-lg-9 col-5 col-md-8 col-sm-7 ">

                    <div class="d-flex align-items-center">
                        <h3 class="mt-1 d-none d-lg-block d-md-block" style="font-family: cursive;">Products

                        </h3>
                        <h5 class="mt-1 d-block d-lg-none d-md-none" style="font-family: cursive;">Products</h5>

                    </div>






                </div>
            </div>
        </div>



        <style>
            .custom-back-button {
                font-size: 16px;
                height: 100%;
                width: 100%;
                border-radius: 0;
                text-decoration: none;
                transition: all 0.3s ease;
                font-weight: 500;
            }

            .custom-back-button:hover {
                background-color: #8c0811;
                border: 0px;
            }

            .custom-back-button i {
                font-size: 18px;
            }
        </style>



        <div class="card mb-2 p-2 mt-2">
            <form action="" method="GET">
                <div class="row">
                    <div class="col-lg-10 col-md-9 col-sm-6 col-6 mt-1 mb-1">
                        <input type="number" min="1" class="form-control" value="{{ request()->acc_id }}"
                            placeholder="Acccount ID" name="acc_id">
                    </div>
                    <div class="col-lg-2 col-md-3 col-sm-6 col-6 mt-1 mb-1">
                        <div class="btn-group w-100">
                            <a href="{{ url('admin/products') }}" title="Clear" class="btn btn-outline-danger">Clear</a>
                            <button type="submit" title="Search" class="btn btn-outline-success">Search</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>


        @if ($products->count() > 0 && request()->name)
            <div class="alert bg-primary text-white mt-3">
                <strong>{{ $products->count() }}
                    {{ $products->count() > 0 && $products->count() < 2 ? 'Result' : 'Results' }}
                    Found</strong>
            </div>
        @elseif ($products->count() < 1 && request()->name)
            <div class="alert bg-warning text-white mt-3">
                <strong>No Results Found !</strong>
            </div>
        @endif


        <div class="card p-2 mb-0">

            @if ($products->count() > 0)
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th style="font-size:14px;" class="text-dark fw-bold text-center">#</th>
                                <th style="font-size:14px;" class="text-dark fw-bold">Image</th>
                                <th style="font-size:14px;" class="text-dark fw-bold">Name</th>
                                <th style="font-size:14px;" class="text-dark fw-bold">Category</th>
                                <th style="font-size:14px;" class="text-dark fw-bold">Price</th>
                                <th style="font-size:14px;" class="text-dark fw-bold text-center">Description</th>
                                <th style="font-size:14px" class="text-dark fw-bold text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $key => $product)
                                <tr>
                                    <td class="text-dark text-center">{{ ++$key }}</td>
                                    <td>
                                        <img src="{{ asset($product->image) }}" height="70px" width="60px"
                                            alt="">
                                    </td>
                                    <td class="fw-bold">
                                        <a href="{{ route('admin.product.edit', ['id' => $product->id]) }}">
                                            {{ $product->name }}
                                        </a>
                                    </td>
                                    <td class="text-dark">
                                        @if ($product->category)
                                            @if ($product->category->parent)
                                                {{ $product->category->parent->name . ' / ' . $product->category->name }}
                                            @else
                                                {{ $product->category->name }}
                                            @endif
                                        @else
                                            <span class="text-muted">No Category</span>
                                        @endif
                                    </td>

                                    <td class="text-dark">{{ 'Rs.' . number_format($product->price) }}</td>
                                    <td class="text-center text-dark">{{ $product->description }}</td>
                                    <td class="text-center">
                                        <div class="dropdown ms-auto">
                                            <button class="btn btn-dark btn-sm dropdown-toggle" type="button"
                                                id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                                Actions
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end"
                                                aria-labelledby="dropdownMenuButton">
                                                <li>
                                                    <a class="dropdown-item"
                                                        href="{{ route('admin.product.edit', ['id' => $product->id]) }}">
                                                        Edit
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="float-end mt-2">
                        {{ $products->appends(request()->query())->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            @else
                 <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th style="font-size:14px;" class="text-dark fw-bold text-center">#</th>
                                <th style="font-size:14px;" class="text-dark fw-bold">Name
                                </th>
                                <th style="font-size:14px;" class="text-dark fw-bold">Category</th>
                                <th style="font-size:14px;" class="text-dark fw-bold text-center">Price
                                </th>
                                <th style="font-size:14px;" class="text-dark fw-bold">Qty</th>
                                <th style="font-size:14px" class="text-dark fw-bold text-center">Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>

                <h4 class="h4 text-center fw-normal text-muted mt-2">No Data Found!</h4>
            @endif

        </div>

    </div>


@endsection
