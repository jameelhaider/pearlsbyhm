@extends('admin.layouts.app')
@php
    $title = $product->id != null ? 'Edit Product' : 'Add New Product';
@endphp
@section('admin_title', $title)
@section('content2')
    <div class="container-fluid px-3">

        <div class="card shadow-sm bg-white rounded-0">
            <div class="row">
                <div class="col-lg-2 col-md-3 col-6 col-sm-4">
                    <a href="{{ url('admin/products') }}"
                        class="btn btn-dark custom-back-button d-flex align-items-center justify-content-center">
                        <i class="bx bx-chevron-left me-1"></i> Back
                    </a>
                </div>
                <div class="col-lg-10 col-md-9 col-6 col-sm-8">
                    <h3 class="mt-1 d-none d-md-bloack d-lg-block" style="font-family:cursive">
                        {{ $product->id != null ? 'Edit Product' : 'Add New Product' }}</h3>

                    <h5 class="mt-1 d-block d-md-none d-lg-none" style="font-family:cursive">
                        {{ $product->id != null ? 'Edit Account' : 'Add New Product' }}</h5>
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
                action="{{ $product->id != null ? route('admin.product.update', ['id' => $product->id]) : route('admin.product.submit') }}"
                method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">

                    <div class="col-lg-6 col-md-6">
                        <label for="" class="fw-bold mb-2">Product Image <span class="text-danger">*</span></label>
                        @if ($product->id && $product->image)
                            <div class="mb-2">
                                <img src="{{ asset($product->image) }}" alt="Product Image" class="img-thumbnail"
                                    style="width: 120px; height: 120px; object-fit: cover;">
                            </div>
                        @endif

                        <input type="file" class="form-control @error('image') is-invalid @enderror" name="image">
                        @error('image')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="col-lg-6 col-md-6">
                        <label for="" class="fw-bold mb-2">Product Hover Image <span
                                class="text-danger">*</span></label>
                        @if ($product->id && $product->hover_image)
                            <div class="mb-2">
                                <img src="{{ asset($product->hover_image) }}" alt="Product Hover Image"
                                    class="img-thumbnail" style="width: 120px; height: 120px; object-fit: cover;">
                            </div>
                        @endif

                        <input type="file" class="form-control @error('hover_image') is-invalid @enderror"
                            name="hover_image">
                        @error('hover_image')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>





                </div>





                @if ($product->id != null && $product_images->isNotEmpty())
                    <div class="row mt-2">
                        <div class="col-lg-3 col-md-4">
                            <div id="vehicleImagesCarousel" class="carousel slide" data-bs-ride="carousel">
                                <div class="carousel-indicators">
                                    @foreach ($product_images as $index => $product_image)
                                        <button type="button" data-bs-target="#vehicleImagesCarousel"
                                            data-bs-slide-to="{{ $index }}" class="{{ $index == 0 ? 'active' : '' }}"
                                            aria-current="{{ $index == 0 ? 'true' : '' }}"
                                            aria-label="Slide {{ $index + 1 }}"></button>
                                    @endforeach
                                </div>
                                <div class="carousel-inner">
                                    @foreach ($product_images as $index => $product_image)
                                        <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                            <img style="height: 250px;width:100%;"
                                                src="{{ asset($product_image->image_path) }}"
                                                alt="Vehicle Image {{ $index + 1 }}">
                                            @if ($product_images->count() > 1)
                                                <div class="delete-icon-container text-end"
                                                    style="position: absolute; bottom:40px; right: 120px;">
                                                    <a class="btn btn-primary btn-sm rounded-0" href="{{ route('admin.product.deleteimage',['id'=>$product_image->id]) }}">
                                                        <i class="bx bx-trash"></i></a>
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                                <button class="carousel-control-prev" type="button" data-bs-target="#vehicleImagesCarousel"
                                    data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#vehicleImagesCarousel"
                                    data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>
                            </div>
                        </div>
                    </div>
                @endif



                <div class="row mt-2">
                    <div class="col-lg-12 col-md-12">
                        <label for="" class="fw-bold mb-2">Product Multiple Images <span
                                class="text-danger">*</span></label>
                        <input type="file" accept="image/*" multiple
                            class="form-control @error('images') is-invalid @enderror" name="images[]" id="images">
                        @error('images')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col-lg-12 col-md-12">
                        <label for="" class="fw-bold mb-2">Select Category <span
                                class="text-danger">*</span></label>
                        <select name="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                            <option value="">-- Select Category --</option>
                            @foreach ($categories as $category)
                                @include('admin.products.partials.category-option', [
                                    'category' => $category,
                                    'prefix' => '',
                                    'selected' => old('category_id', $product->category_id),
                                ])
                            @endforeach
                        </select>
                        @error('category_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>


                <div class="row mt-2">
                    <div class="col-lg-4 col-md-4">
                        <label for="" class="fw-bold mb-2">Product Name<span class="text-danger">*</span></label>
                        <input type="text" placeholder="Product Name" required
                            value="{{ old('name', $product->name) }}"
                            class="form-control @error('name') is-invalid @enderror" name="name">
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="col-lg-4 col-md-4">
                        <label for="" class="fw-bold mb-2">Actual Price<span class="text-danger">*</span></label>
                        <input type="number" min="2" placeholder="Actual Price" required
                            value="{{ old('actual_price', $product->actual_price) }}"
                            class="form-control @error('actual_price') is-invalid @enderror" name="actual_price">
                        @error('actual_price')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="col-lg-4 col-md-4">
                        <label for="" class="fw-bold mb-2">Sale Price<span class="text-danger">*</span></label>
                        <input type="number" min="1" placeholder="Sale Price" required
                            value="{{ old('price', $product->price) }}"
                            class="form-control @error('price') is-invalid @enderror" name="price">
                        @error('price')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>





                </div>


                <div class="row mt-2">
                    <div class="col-lg-12 col-md-12">
                        <label for="" class="fw-bold mb-2">Product Description<span
                                class="text-danger">*</span></label>
                        <input type="text" placeholder="Product Description" required
                            value="{{ old('description', $product->description) }}"
                            class="form-control @error('description') is-invalid @enderror" name="description">
                        @error('description')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>






                <button type="submit" name="action" value="save" class="btn btn-primary mt-3 float-end ms-2"
                    title="Save">
                    {{ $product->id != null ? 'Update' : 'Save' }} <i class="bx bx-check-circle"></i>
                </button>

                @if ($product->id == null)
                    <button type="submit" name="action" value="save_add_new" class="btn btn-dark mt-3 float-end"
                        title="Save and Add New">
                        Save & Add New <i class="bx bx-plus-circle"></i>
                    </button>
                @endif

            </form>
        </div>
    </div>
@endsection
