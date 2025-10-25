@extends('admin.layouts.app')
@section('admin_title', 'Admin | FAQs')
@section('content2')

    <div class="container-fluid px-3">
        <div class="card shadow-sm bg-white rounded-0">
            <div class="row">
                <div class="col-lg-3 col-7 col-md-4 col-sm-5">
                    <a href="{{ route('admin.faq.create') }}"
                        class="btn btn-primary custom-back-button d-flex align-items-center justify-content-center">
                        <i class="bx bx-plus me-1"></i> Add New FAQ
                    </a>
                </div>
                <div class="col-lg-9 col-5 col-md-8 col-sm-7 ">

                    <div class="d-flex align-items-center">
                        <h3 class="mt-1 d-none d-lg-block d-md-block" style="font-family: cursive;">FAQs

                        </h3>
                        <h5 class="mt-1 d-block d-lg-none d-md-none" style="font-family: cursive;">FAQs</h5>

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

            @if ($faqs->count() > 0)
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th style="font-size:14px;" class="text-dark fw-bold text-center">#</th>
                                <th style="font-size:14px;width:37%" class="text-dark fw-bold">Question</th>
                                <th style="font-size:14px;width:45%" class="text-dark fw-bold">Answer</th>
                                <th style="font-size:14px" class="text-dark fw-bold text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($faqs as $key => $faq)
                                <tr>
                                    <td class="text-dark text-center">{{ ++$key }}</td>
                                    <td class="text-dark">
                                        <a class="text-dark" href="{{ route('admin.faq.edit', ['id' => $faq->id]) }}">
                                            {{ $faq->question }}
                                        </a>
                                    </td>
                                    <td class="text-dark">
                                        <a class="text-dark" href="{{ route('admin.faq.edit', ['id' => $faq->id]) }}">
                                            {{ $faq->answer }}
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
                                                        href="{{ route('admin.faq.edit', ['id' => $faq->id]) }}">
                                                        Edit
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item"
                                                        onclick="confirmDelete('{{ route('admin.faq.delete', ['id' => $faq->id]) }}')">
                                                        Delete
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
                        {{ $faqs->appends(request()->query())->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th style="font-size:14px;" class="text-dark fw-bold text-center">#</th>
                                <th style="font-size:14px;" class="text-dark fw-bold">Question</th>
                                <th style="font-size:14px;" class="text-dark fw-bold">Answer</th>
                                <th style="font-size:14px" class="text-dark fw-bold text-center">Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>

                <h5 class="text-center fw-normal text-dark mt-3">No Data Found!</h5>
            @endif

        </div>

    </div>




    <script>
        function confirmAction(url, action) {
            Swal.fire({
                title: `Are you sure you want to ${action} this FAQ?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: `Yes, ${action} it!`,
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = url;
                }
            })
        }


        function confirmDelete(url) {
            Swal.fire({
                title: 'Are you sure you want to delete this FAQ?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = url;
                }
            })
        }
    </script>


@endsection
