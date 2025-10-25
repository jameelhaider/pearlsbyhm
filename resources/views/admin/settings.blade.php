@extends('admin.layouts.app')
@section('admin_title', 'Admin | Settings')
@section('content2')

    <div class="container-fluid px-3">
        <div class="card shadow-sm bg-white rounded-0">
            <div class="row">
                <div class="col-lg-3 col-7 col-md-4 col-sm-5">
                    <a href="{{ url('/admin/dashboard') }}"
                        class="btn btn-primary custom-back-button d-flex align-items-center justify-content-center">
                        <i class="bx bx-home me-1"></i> Dashboard
                    </a>
                </div>
                <div class="col-lg-9 col-5 col-md-8 col-sm-7 ">

                    <div class="d-flex align-items-center">
                        <h3 class="mt-1 d-none d-lg-block d-md-block" style="font-family: cursive;">Settings

                        </h3>
                        <h5 class="mt-1 d-block d-lg-none d-md-none" style="font-family: cursive;">Settings</h5>

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



        <div class="card p-2 mt-2">
            <form action="{{ route('admin.settings.update') }}" method="post" enctype="multipart/form-data">
                @csrf
                <h4 class="text-dark text-center">About App</h4>
                <div class="row">
                    <div class="col-lg-12">
                        <img src="{{ asset($settings->site_logo) }}" width="180px" height="150px" alt="">
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-lg-6">

                        <label for="text" class="fw-bold mb-2">App Logo</label>
                        <input type="file" class="form-control" name="site_logo" accept="image/*">
                    </div>
                    <div class="col-lg-6">
                        <label for="text" class="fw-bold mb-2">App Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" required placeholder="App Name" name="site_name"
                            value="{{ $settings->site_name }}">
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col-lg-12">
                        <label for="text" class="fw-bold mb-2">App Description <span
                                class="text-danger">*</span></label>
                        <textarea name="site_description" required class="form-control" id="" cols="30" rows="10">{{ $settings->site_description }}
                    </textarea>
                    </div>
                </div>


                <h4 class="text-dark text-center mt-4">Shipping</h4>
                <div class="row mt-1">
                    <div class="col-lg-6">
                        <label for="text" class="fw-bold mb-2">Shipping Charges <span
                                class="text-danger">*</span></label>
                        <input type="text" class="form-control" required placeholder="Shipping Charges"
                            value="{{ $settings->shipping_charges }}" name="shipping_charges">
                    </div>
                    <div class="col-lg-6">
                        <label for="text" class="fw-bold mb-2">Shipping Free On <span
                                class="text-danger">*</span></label>
                        <input type="text" class="form-control" required placeholder="Shipping Free On"
                            value="{{ $settings->shipping_free_on }}" name="shipping_free_on">
                    </div>
                </div>
                <button type="submit" class="btn btn-primary float-end mt-2">Save <i
                        class="bx bx-check-circle"></i></button>
            </form>
        </div>

    </div>





@endsection
