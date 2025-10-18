@extends('admin.layouts.app')
@php
    $title = $slide->id != null ? 'Edit Slide' : 'Add New Slide';
@endphp
@section('admin_title', $title)
@section('content2')
    <div class="container-fluid px-3">

        <div class="card shadow-sm bg-white rounded-0">
            <div class="row">
                <div class="col-lg-2 col-md-3 col-6 col-sm-4">
                    <a href="{{ url('admin/slides') }}"
                        class="btn btn-dark custom-back-button d-flex align-items-center justify-content-center">
                        <i class="bx bx-chevron-left me-1"></i> Back
                    </a>
                </div>
                <div class="col-lg-10 col-md-9 col-6 col-sm-8">
                    <h3 class="mt-1 d-none d-md-bloack d-lg-block" style="font-family:cursive">
                        {{ $slide->id != null ? 'Edit Slide' : 'Add New Slide' }}</h3>

                    <h5 class="mt-1 d-block d-md-none d-lg-none" style="font-family:cursive">
                        {{ $slide->id != null ? 'Edit Slide' : 'Add New Slide' }}</h5>
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
                background-color: #314861;
            }

            .custom-back-button i {
                font-size: 18px;
            }
        </style>

        <div class="card p-3 mt-3">
            <form
                action="{{ $slide->id != null ? route('admin.slide.update', ['id' => $slide->id]) : route('admin.slide.submit') }}"
                method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-lg-12 col-md-12">
                        <label for="" class="fw-bold mb-2">Slide Image <span class="text-danger">*</span></label>
                        @if ($slide->id && $slide->image)
                            <div class="mb-2">
                                <img src="{{ asset($slide->image) }}" height="100px" width="250" alt="Slide Image">
                            </div>
                        @endif
                        <input type="file" accept="image/*" class="form-control @error('image') is-invalid @enderror"
                            name="image">
                        @error('image')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>


                <div class="row mt-2">
                    <div class="col-lg-6 col-md-6">
                        <div class="mb-3">
                            <label for="text" class="fw-bold mb-2">Any Text (optional)</label>
                            <input type="text" id="text" name="text" value="{{ old('text', $slide->text) }}
"
                                class="form-control @error('text') is-invalid @enderror"
                                placeholder="Enter any optional text">
                            @error('text')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="mb-3">
                            <label for="link" class="fw-bold mb-2">Any Link (optional)</label>
                            <input type="text" id="link" name="link" value="{{ old('link', $slide->link) }}"
                                class="form-control @error('link') is-invalid @enderror"
                                placeholder="Enter any optional link">
                            @error('link')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>




                <button type="submit" name="action" value="save" class="btn btn-primary mt-3 float-end ms-2"
                    title="Save">
                    {{ $slide->id != null ? 'Update' : 'Save' }} <i class="bx bx-check-circle"></i>
                </button>

                @if ($slide->id == null)
                    <button type="submit" name="action" value="save_add_new" class="btn btn-dark mt-3 float-end"
                        title="Save and Add New">
                        Save & Add New <i class="bx bx-plus-circle"></i>
                    </button>
                @endif

            </form>
        </div>
    </div>
@endsection
