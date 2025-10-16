@extends('admin.layouts.app')
@section('admin_title', 'Admin | Slides')
@section('content2')

    <div class="container-fluid px-3">
        <div class="card shadow-sm bg-white rounded-0">
            <div class="row">
                <div class="col-lg-3 col-7 col-md-4 col-sm-5">
                    <a href="{{ route('admin.slide.create') }}"
                        class="btn btn-primary custom-back-button d-flex align-items-center justify-content-center">
                        <i class="bx bx-plus me-1"></i> Add New Slide
                    </a>
                </div>
                <div class="col-lg-9 col-5 col-md-8 col-sm-7 ">

                    <div class="d-flex align-items-center">
                        <h3 class="mt-1 d-none d-lg-block d-md-block" style="font-family: cursive;">Slides

                        </h3>
                        <h5 class="mt-1 d-block d-lg-none d-md-none" style="font-family: cursive;">Slides</h5>

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




        <div class="card p-2 mb-0 mt-2">

            @if ($slides->count() > 0)
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th style="font-size:14px;" class="text-dark fw-bold text-center">#</th>
                                <th style="font-size:14px;" class="text-dark fw-bold">Image</th>
                                <th style="font-size:14px" class="text-dark fw-bold text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($slides as $key => $slide)
                                <tr>
                                    <td class="text-dark text-center">{{ ++$key }}</td>
                                    <td class="fw-bold">
                                        <a href="{{ route('admin.slide.edit', ['id' => $slide->id]) }}">
                                            <img src="{{ asset($slide->image) }}" height="100px" width="250"
                                                alt="">
                                        </a>
                                    </td>
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
                                                        href="{{ route('admin.slide.edit', ['id' => $slide->id]) }}">
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
                        {{ $slides->appends(request()->query())->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th style="font-size:14px;" class="text-dark fw-bold text-center">#</th>
                                <th style="font-size:14px;" class="text-dark fw-bold">Image</th>
                                <th style="font-size:14px" class="text-dark fw-bold text-center">Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>

                <h5 class="text-center fw-normal text-dark mt-3">No Data Found!</h5>
            @endif

        </div>

    </div>


@endsection
