<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default"
    data-assets-path="../assets/" data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>@yield('admin_title')</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset(site_logo()) }}" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet" />


    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="{{ asset('newdash/assets/vendor/fonts/boxicons.css') }}" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('newdash/assets/vendor/css/core.css') }}"
        class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ asset('newdash/assets/vendor/css/theme-default.css') }}"
        class="template-customizer-theme-css" />

    {{-- //js pdf + js img --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>


    <link rel="stylesheet" href="{{ asset('newdash/assets/css/demo.css') }}" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('newdash/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
    <link rel="stylesheet" href="{{ asset('newdash/assets/vendor/libs/apex-charts/apex-charts.css') }}" />
    <!-- Helpers -->
    <script src="{{ asset('newdash/assets/vendor/js/helpers.js') }}"></script>
    <script src="{{ asset('newdash/assets/js/config.js') }}"></script>

    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>


    {{-- mask the field --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/3/jquery.inputmask.bundle.js"></script>





    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <style>
        .menu-item.active.badge {
            border: 2px solid rgb(255, 255, 255);
        }
    </style>

</head>

<body>


    <style>
        .loader-wrapper {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(255, 255, 255, 0.7);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        .loader {
            border: 4px solid rgba(255, 255, 255, 0.3);
            border-top: 4px solid #75060d;
            ;
            border-radius: 50%;
            width: 170px;
            height: 170px;
            animation: spin 1s linear infinite;
        }

        .loader-wrapper img {
            position: absolute;
            z-index: 1;
            height: 140px;
            width: auto;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        /* Hide loader after animation ends */
        .loader-wrapper.hidden {
            display: none;
        }
    </style>

    <div class="loader-wrapper" id="loader">
        <img src="{{ asset(site_logo()) }}" alt="Loader Image">
        <div class="loader"></div>
    </div>


    <script>
        // Wait for the window to load fully
        window.addEventListener("load", () => {
            setTimeout(() => {
                const loader = document.getElementById("loader");
                if (loader) {
                    loader.classList.add("hidden");
                }
            }, 600); // Display loader for at least 2 seconds
        });
    </script>





    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <!-- Menu -->

            <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
                <div class="app-brand demo">
                    <a href="{{ url('/admin') }}" target="_BLANK" class="app-brand-link">

                        <img src="{{ asset(site_logo()) }}" height="41px" width="48px" alt="">
                        <span class="fw-bolder ms-2 small text-dark">{{ site_name() }}</span>
                    </a>

                    <a href="javascript:void(0);"
                        class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
                        <i class="bx bx-chevron-left bx-sm align-middle"></i>
                    </a>
                </div>

                <div class="menu-inner-shadow"></div>

                <ul class="menu-inner py-1">
                    <!-- Dashboard -->
                    <li class="menu-item {{ Request::is('admin/dashboard') ? 'active' : '' }}">
                        <a href="{{ url('/admin/dashboard') }}"
                            class="menu-link {{ !Request::is('admin/dashboard') ? 'text-dark' : '' }}">
                            <i class="menu-icon tf-icons bx bx-home-circle"></i>
                            <div data-i18n="Analytics">Dashboard</div>
                        </a>
                    </li>




                    <li class="menu-header small text-uppercase fw-bold text-dark">
                        <span class="menu-header-text">Manage Orders</span>
                    </li>

                    <li class="menu-item {{ Request::is('admin/orders/pending') ? 'active' : '' }}">
                        <a href="{{ url('admin/orders/pending') }}"
                            class="menu-link d-flex align-items-center {{ Request::is('admin/orders/pending') ? '' : 'text-dark' }}">
                            <i class="menu-icon tf-icons bx bx-time-five"></i>
                            <div class="flex-grow-1">Pending</div>
                        </a>
                    </li>

                    <li class="menu-item {{ Request::is('admin/orders/in-process') ? 'active' : '' }}">
                        <a href="{{ url('admin/orders/in-process') }}"
                            class="menu-link d-flex align-items-center {{ Request::is('admin/orders/in-process') ? '' : 'text-dark' }}">
                            <i class="menu-icon tf-icons bx bx-loader-circle"></i>
                            <div class="flex-grow-1">In Process</div>
                        </a>
                    </li>

                    <li class="menu-item {{ Request::is('admin/orders/packed') ? 'active' : '' }}">
                        <a href="{{ url('admin/orders/packed') }}"
                            class="menu-link d-flex align-items-center {{ Request::is('admin/orders/packed') ? '' : 'text-dark' }}">
                            <i class="menu-icon tf-icons bx bx-box"></i>
                            <div class="flex-grow-1">Packed</div>
                        </a>
                    </li>

                    <li class="menu-item {{ Request::is('admin/orders/sent') ? 'active' : '' }}">
                        <a href="{{ url('admin/orders/sent') }}"
                            class="menu-link d-flex align-items-center {{ Request::is('admin/orders/sent') ? '' : 'text-dark' }}">
                            <i class="menu-icon tf-icons bx bx-car"></i>
                            <div class="flex-grow-1">Sent</div>
                        </a>
                    </li>

                    <li class="menu-item {{ Request::is('admin/orders/delivered') ? 'active' : '' }}">
                        <a href="{{ url('admin/orders/delivered') }}"
                            class="menu-link d-flex align-items-center {{ Request::is('admin/orders/delivered') ? '' : 'text-dark' }}">
                            <i class="menu-icon tf-icons bx bx-check-circle"></i>
                            <div class="flex-grow-1">Delivered</div>
                        </a>
                    </li>

                       <li class="menu-item {{ Request::is('admin/orders/cancelled') ? 'active' : '' }}">
                        <a href="{{ url('admin/orders/cancelled') }}"
                            class="menu-link d-flex align-items-center {{ Request::is('admin/orders/cancelled') ? '' : 'text-dark' }}">
                            <i class="menu-icon tf-icons bx bx-x"></i>
                            <div class="flex-grow-1">Cancelled</div>
                        </a>
                    </li>





                    <li
                        class="menu-header small text-uppercase fw-bold {{ Request::is('admin/slides') || Request::is('admin/slides/create') ? '' : 'text-dark' }}">
                        <span class="menu-header-text">Slides</span>
                    </li>
                    <li
                        class="menu-item {{ Request::is('admin/slides') || Request::is('admin/slides/create') ? 'active' : '' }}">
                        <a href="{{ url('admin/slides') }}"
                            class="menu-link {{ Request::is('admin/slides') || Request::is('admin/slides/create') ? '' : 'text-dark' }} d-flex align-items-center">
                            <i class="menu-icon tf-icons bx bx-slideshow"></i>
                            <div data-i18n="Support" class="flex-grow-1">Slides</div>
                        </a>
                    </li>



                    <li
                        class="menu-header small text-uppercase fw-bold {{ Request::is('admin/products') || Request::is('admin/products/create') ? '' : 'text-dark' }}">
                        <span class="menu-header-text">Products</span>
                    </li>
                    <li
                        class="menu-item {{ Request::is('admin/products') || Request::is('admin/products/create') ? 'active' : '' }}">
                        <a href="{{ url('admin/products') }}"
                            class="menu-link {{ Request::is('admin/products') || Request::is('admin/products/create') ? '' : 'text-dark' }} d-flex align-items-center">
                            <i class="menu-icon tf-icons bx bx-package"></i>
                            <div data-i18n="Support" class="flex-grow-1">Products</div>
                        </a>
                    </li>




                    <li
                        class="menu-header small text-uppercase fw-bold {{ Request::is('admin/categories') || Request::is('admin/categories/create') ? '' : 'text-dark' }}">
                        <span class="menu-header-text">Categories</span>
                    </li>
                    <li
                        class="menu-item {{ Request::is('admin/categories') || Request::is('admin/categories/create') ? 'active' : '' }}">
                        <a href="{{ url('admin/categories') }}"
                            class="menu-link {{ Request::is('admin/categories') || Request::is('admin/categories/create') ? '' : 'text-dark' }} d-flex align-items-center">
                            <i class="menu-icon tf-icons bx bx-category"></i>
                            <div data-i18n="Support" class="flex-grow-1">Categories</div>
                        </a>
                    </li>



                     <li
                        class="menu-header small text-uppercase fw-bold {{ Request::is('admin/faqs') || Request::is('admin/faqs/create') ? '' : 'text-dark' }}">
                        <span class="menu-header-text">FAQs</span>
                    </li>
                    <li
                        class="menu-item {{ Request::is('admin/faqs') || Request::is('admin/faqs/create') ? 'active' : '' }}">
                        <a href="{{ url('admin/faqs') }}"
                            class="menu-link {{ Request::is('admin/faqs') || Request::is('admin/faqs/create') ? '' : 'text-dark' }} d-flex align-items-center">
                            <i class="menu-icon tf-icons bx bx-help-circle"></i>
                            <div data-i18n="Support" class="flex-grow-1">FAQs</div>
                        </a>
                    </li>

                     <li
                        class="menu-header small text-uppercase fw-bold {{ Request::is('admin/settings') ? '' : 'text-dark' }}">
                        <span class="menu-header-text">Settings</span>
                    </li>
                    <li
                        class="menu-item {{ Request::is('admin/settings') ? 'active' : '' }}">
                        <a href="{{ url('admin/settings') }}"
                            class="menu-link {{ Request::is('admin/settings') ? '' : 'text-dark' }} d-flex align-items-center">
                            <i class="menu-icon tf-icons bx bx-cog"></i>
                            <div data-i18n="Support" class="flex-grow-1">Settings</div>
                        </a>
                    </li>





                </ul>
            </aside>
            <!-- / Menu -->

            <!-- Layout container -->
            <div class="layout-page">
                <!-- Navbar -->

                <nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
                    id="layout-navbar">
                    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
                        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                            <i class="bx bx-menu bx-sm"></i>
                        </a>
                    </div>

                    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
                        <!-- Search -->
                        <div class="navbar-nav align-items-center">
                            <div class="nav-item d-flex align-items-center">
                                <i class="bx bx-search fs-4 lh-0"></i>
                                <input type="text" class="form-control border-0 shadow-none"
                                    placeholder="Search..." aria-label="Search..." />
                            </div>
                        </div>
                        <!-- /Search -->

                        <ul class="navbar-nav flex-row align-items-center ms-auto">

                            <!-- User -->
                            <li class="nav-item navbar-dropdown dropdown-user dropdown">
                                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);"
                                    data-bs-toggle="dropdown">
                                    <div class="avatar avatar-online">
                                        <img src="{{ asset(site_logo()) }}" alt
                                            class="w-px-40 h-auto rounded-circle" />
                                    </div>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <a class="dropdown-item" href="#">
                                            <div class="d-flex">
                                                <div class="flex-shrink-0 me-3">
                                                    <div class="avatar avatar-online">
                                                        <img src="{{ asset(site_logo()) }}" alt
                                                            class="w-px-40 h-auto rounded-circle" />
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <span class="fw-semibold d-block">
                                                        {{ auth('admin')->user()->name }}
                                                    </span>

                                                    <small class="text-muted">Admin</small>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <div class="dropdown-divider"></div>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ url('admin/change-password') }}">
                                            <i class="bx bx-key me-2"></i>
                                            <span class="align-middle">Change Password</span>
                                        </a>
                                    </li>
                                    <li>
                                        <div class="dropdown-divider"></div>
                                    </li>
                                    <li>
                                        <form action="{{ route('admin.logout') }}" method="POST"
                                            style="display: inline;">
                                            @csrf
                                            <button type="submit" class="dropdown-item">
                                                <i class="bx bx-power-off me-2"></i>
                                                <span class="align-middle">Log Out</span>
                                            </button>
                                        </form>
                                    </li>


                                </ul>
                            </li>
                            <!--/ User -->
                        </ul>
                    </div>
                </nav>

                <!-- / Navbar -->

                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <div class="py-2 px-0">
                        @include('alert')
                        @yield('content2')
                    </div>

                    <!-- Footer -->
                    <footer class="content-footer footer bg-footer-theme">
                        <div
                            class="container-xxl d-flex flex-wrap justify-content-between py-2 flex-md-row flex-column">
                            <div class="mb-2 mb-md-0">
                                © {{ site_name() }}
                                <script>
                                    document.write(new Date().getFullYear());
                                </script>
                                , Developed By
                                <a href="https://wa.link/ehud9w" target="_blank"
                                    class="footer-link fw-bolder text-dark">JH
                                    Developers</a>
                            </div>
                            <div>


                                <div class="d-none d-lg-block">
                                    <a href="{{ url('/admin') }}" class="footer-link me-4">Dashboard</a>

                                    <a href="{{ url('admin/invoice/make') }}" class="footer-link me-4">Make
                                        Sale Invoice</a>
                                    <a href="{{ url('admin/invoices') }}" class="footer-link me-4">List Sale
                                        Invoices</a>

                                    <a href="{{ url('admin/change-password') }}" class="footer-link me-4">Change
                                        Password</a>
                                </div>

                            </div>
                        </div>
                    </footer>
                    <!-- / Footer -->

                    <div class="content-backdrop fade"></div>
                </div>
                <!-- Content wrapper -->
            </div>
            <!-- / Layout page -->
        </div>

        <!-- Overlay -->
        <div class="layout-overlay layout-menu-toggle"></div>
    </div>
    <!-- / Layout wrapper -->


    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="{{ asset('newdash/assets/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('newdash/assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('newdash/assets/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('newdash/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>

    <script src="{{ asset('newdash/assets/vendor/js/menu.js') }}"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="{{ asset('newdash/assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>

    <!-- Main JS -->
    <script src="{{ asset('newdash/assets/js/main.js') }}"></script>

    <!-- Page JS -->
    <script src="{{ asset('newdash/assets/js/dashboards-analytics.js') }}"></script>


    <!-- Place this tag in your head or just before your close body tag. -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
</body>

</html>
