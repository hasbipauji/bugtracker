<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.s0">
    <title>{{ env('APP_NAME') }} | @yield('title')</title>

    <!-- css -->
    <!-- Bootstrap Css -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{ asset('assets/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />

    <link href="{{ asset('assets/libs/toastr/build/toastr.min.css') }}" rel="stylesheet" type="text/css" />

    <link href="{{ asset('assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- datatable -->
    <link href="{{ asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}"
        rel="stylesheet" type="text/css" />

    <style>
        body {
            background-color: #ecf0f1;
        }
    </style>

    @yield('css')
</head>

<body data-sidebar="dark">

    <!-- begin::page -->
    <div id="layout-wrapper">
        <header id="page-topbar">
            <div class="navbar-header">
                <div class="d-flex">
                    <!-- LOGO -->
                    <div class="navbar-brand-box">
                        <a href="{{ route('dasbor') }}" class="logo logo-dark">
                            <span class="logo-sm text-white">
                                <i class='bx bxs-dashboard bx-sm'></i>
                            </span>
                            <span class="logo-lg">
                                <span class="fs-5 text-white text-uppercase">{{ env('APP_NAME') }}</span>
                            </span>
                        </a>

                        <a href="{{ route('dasbor') }}" class="logo logo-light">
                            <span class="logo-sm text-white">
                                <i class='bx bxs-dashboard bx-sm'></i>
                            </span>
                            <span class="logo-lg">
                                <span class="fs-5 text-white text-uppercase">{{ env('APP_NAME') }}</span>
                            </span>
                        </a>
                    </div>

                    <button type="button" class="btn btn-sm px-3 font-size-16 header-item waves-effect"
                        id="vertical-menu-btn">
                        <i class="fa fa-fw fa-bars"></i>
                    </button>

                </div>

                <div class="d-flex">

                    <div class="dropdown d-none d-lg-inline-block ms-1">

                        @if (Auth::user()->access == 'ADMIN')
                        @elseif (Auth::user()->access == 'PROGRAMMER')
                            <button type="button" class="btn header-item noti-icon waves-effect"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="bell">
                                <i class="bx bx-bell"></i>
                                <span class="badge bg-danger rounded-pill" id="nomornotif">

                                    @if (null !== App\Http\Controllers\Controller::gettiketuser())
                                        {{ count(App\Http\Controllers\Controller::gettiketuser()) }}
                                    @endif
                                </span>
                            </button>
                        @elseif (Auth::user()->access == 'TESTER')
                            <button type="button" class="btn header-item noti-icon waves-effect"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="bell">
                                <i class="bx bx-bell"></i>
                                <span class="badge bg-danger rounded-pill" id="nomornotif">

                                    @if (null !== App\Http\Controllers\Controller::gettiketuser())
                                        {{ count(App\Http\Controllers\Controller::gettiketuser()) }}
                                    @endif
                                </span>
                            </button>
                        @endif
                        <div class="dropdown-menu dropdown-menu-end">
                            <!-- Add menu items here -->
                            @if (null !== App\Http\Controllers\Controller::gettiketuser())
                                <div class="alert alert-warning" role="alert" id="notif">
                                    Anda memiliki
                                    <strong>{{ count(App\Http\Controllers\Controller::gettiketuser()) }}</strong>
                                    tiket belum selesai.
                                </div>
                            @endif

                        </div>

                        <div class="dropdown d-none d-lg-inline-block ms-1">
                            <button type="button" class="btn header-item noti-icon waves-effect"
                                data-toggle="fullscreen">
                                <i class="bx bx-fullscreen"></i>
                            </button>
                        </div>

                        <div class="dropdown d-inline-block">
                            <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span
                                    class="d-none d-xl-inline-block ms-1 text-capitalize">{{ Auth::user()->name }}</span>
                                <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end">

                                <!-- item-->
                                <a class="dropdown-item" href="{{ route('profil') }}"><i
                                        class="bx bx-user font-size-16 align-middle me-1"></i> <span>Profil</span></a>
                                <a class="dropdown-item text-danger" href="#" onclick="logout()"><i
                                        class="bx bx-power-off font-size-16 align-middle me-1 text-danger"></i>
                                    <span>Keluar</span></a>
                            </div>
                        </div>

                    </div>
                </div>
        </header>

        <!-- ========== Left Sidebar Start ========== -->
        <div class="vertical-menu">

            <div data-simplebar class="h-100">

                <!--- Sidemenu -->
                <div id="sidebar-menu">
                    <!-- Left Menu Start -->
                    <ul class="metismenu list-unstyled" id="side-menu">

                        <li>
                            <a href="{{ route('dasbor') }}" class="waves-effect">
                                <i class="bx bx-home"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>

                        <li class="menu-title">Menu</li>

                        @if (Auth::user()->access == 'ADMIN' || Auth::user()->access == 'PROJECT_MANAGER')
                            <li>
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <i class="bx bx-user"></i>
                                    <span>Manajemen User</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">

                                    @if (Auth::user()->access == 'ADMIN')
                                        <li><a href="{{ route('dm_admin') }}">Admin</a></li>
                                        <li><a href="{{ route('dm_project_manager') }}">Project Manager</a></li>
                                    @endif

                                    <li><a href="{{ route('dm_programmer') }}">Programmer</a></li>
                                    <li><a href="{{ route('dm_tester') }}">Tester</a></li>
                                </ul>
                            </li>
                        @endif

                        <li>
                            <a href="{{ route('tiket') }}" class="waves-effect">
                                <i class="bx bx-task"></i>
                                <span>Tiket Aplikasi</span>
                            </a>
                        </li>

                    </ul>
                </div>
                <!-- Sidebar -->
            </div>
        </div>
        <!-- Left Sidebar End -->



        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">

            <div class="page-content">
                <div class="container-fluid">

                    <!-- start page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                <h4 class="mb-sm-0 font-size-18">@yield('title')</h4>
                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                    @yield('content')

                </div>
                <!-- container-fluid -->
            </div>
            <!-- End Page-content -->

            <footer class="footer bg-white">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6">
                            ©
                            <script>
                                document.write(new Date().getFullYear())
                            </script> {{ env('APP_NAME') }}.
                        </div>
                        <div class="col-sm-6">
                            <div class="text-sm-end d-none d-sm-block">
                                Dibuat dengan <i class="bx bx-heart text-danger"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
        <!-- end main content-->

    </div>
    <!-- end::page -->

    <!-- script -->
    <script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/libs/metismenu/metisMenu.min.js') }}"></script>
    <script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/libs/node-waves/waves.min.js') }}"></script>
    <script src="{{ asset('assets/libs/toastr/build/toastr.min.js') }}"></script>
    <script src="{{ asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>

    <!-- App js -->
    <script src="{{ asset('assets/js/app.js') }}"></script>

    <script>
        const logout = () => {
            Swal.fire({
                icon: 'question',
                text: 'Keluar dari aplikasi ?',
                showCancelButton: true,
                cancelButtonText: 'Batal',
                confirmButtonText: 'Ya',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-primary',
                    cancelButton: 'btn btn-secondary ms-2'
                }
            }).then(res => {
                if (res.isConfirmed) {
                    $.ajax({
                        url: '../../logout',
                        method: 'get',
                        success: (res) => {
                            window.location.reload();
                        }
                    })
                }
            })
        }



        const bell = document.getElementById('bell');

        bell.addEventListener('click', () => {
            // Select the notification element (adjust selector as needed)
            const notif = document.getElementById('nomornotif');

            // Hide the notification
            notif.style.display = 'none';
        });
    </script>
    @yield('js')
</body>

</html>
