@extends('admin.layouts.app')
@php
    $title = $faq->id != null ? 'Edit FAQ' : 'Add New FAQ';
@endphp
@section('admin_title', $title)
@section('content2')
    <div class="container-fluid px-3">

        <div class="card shadow-sm bg-white rounded-0">
            <div class="row">
                <div class="col-lg-2 col-md-3 col-6 col-sm-4">
                    <a href="{{ url('admin/faqs') }}"
                        class="btn btn-dark custom-back-button d-flex align-items-center justify-content-center">
                        <i class="bx bx-chevron-left me-1"></i> Back
                    </a>
                </div>
                <div class="col-lg-10 col-md-9 col-6 col-sm-8">
                    <h3 class="mt-1 d-none d-md-bloack d-lg-block" style="font-family:cursive">
                        {{ $faq->id != null ? 'Edit FAQ' : 'Add New FAQ' }}</h3>

                    <h5 class="mt-1 d-block d-md-none d-lg-none" style="font-family:cursive">
                        {{ $faq->id != null ? 'Edit FAQ' : 'Add New FAQ' }}</h5>
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
                action="{{ $faq->id != null ? route('admin.faq.update', ['id' => $faq->id]) : route('admin.faq.submit') }}"
                method="POST">
                @csrf
                <div class="row mt-2">
                    <div class="col-lg-12 col-md-12">
                        <div class="mb-3">
                            <label for="text" class="fw-bold mb-2">Question</label>
                            <input type="text" id="text" name="question"
                                value="{{ old('question', $faq->question) }}
"
                                class="form-control @error('question') is-invalid @enderror" placeholder="Enter Question">
                            @error('question')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                </div>


                <div class="row mt-1">
                    <div class="col-lg-12 col-md-12">
                        <div class="mb-3">
                            <label for="link" class="fw-bold mb-2">Answer</label>
                            <textarea name="answer" placeholder="Enter Answer" class="form-control @error('answer') is-invalid @enderror"
                                cols="30" rows="10">{{ $faq->answer }}</textarea>
                            @error('answer')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>


                <button type="submit" name="action" value="save" class="btn btn-primary mt-3 float-end ms-2"
                    title="Save">
                    {{ $faq->id != null ? 'Update' : 'Save' }} <i class="bx bx-check-circle"></i>
                </button>

                @if ($faq->id == null)
                    <button type="submit" name="action" value="save_add_new" class="btn btn-dark mt-3 float-end"
                        title="Save and Add New">
                        Save & Add New <i class="bx bx-plus-circle"></i>
                    </button>
                @endif

            </form>
        </div>
    </div>
@endsection
