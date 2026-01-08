<!DOCTYPE html>

<html lang="en" class="light-style layout-menu-fixed layout-compact" dir="ltr" data-theme="theme-default"
    data-assets-path="../assets/" data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    
    <link rel="stylesheet" href="{{ asset('css/custom-admin.css') }}">
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <title>POST | SMK PI</title>

    <meta name="description" content="" />

    <link rel="icon" type="image/x-icon" href="{{ asset('pi_blue.png') }}" />

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet" />

    <link rel="stylesheet" href="{{ asset('dashboard-admin/assets/vendor/fonts/boxicons.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard-admin/assets/vendor/css/core.css') }}"
        class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ asset('dashboard-admin/assets/vendor/css/theme-default.css') }}"
        class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{ asset('dashboard-admin/assets/css/demo.css') }}" />

    <link rel="stylesheet"
        href="{{ asset('dashboard-admin/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
    <link rel="stylesheet" href="{{ asset('dashboard-admin/assets/vendor/libs/apex-charts/apex-charts.css') }}" />

    <script src="{{ asset('dashboard-admin/assets/vendor/js/helpers.js') }}"></script>
    <script src="{{ asset('dashboard-admin/assets/js/config.js') }}"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
                <div class="app-brand demo">
                    <a href="{{ url('dashboard') }}" class="app-brand-link">
                        <img src="{{ asset('pi_blue.png') }}" alt="Logo" width="25%" style="margin-left: -30px">
                        <span class="app-brand-text demo menu-text fw-bold ms-2"
                            style="text-transform: uppercase;">SMK PI</span>
                    </a>

                    <a href="javascript:void(0);"
                        class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
                        <i class="align-middle bx bx-chevron-left bx-sm"></i>
                    </a>
                </div>

                <div class="menu-inner-shadow"></div>

                <ul class="py-1 menu-inner">
                    <x-nav-link class="menu-item" :active="request()->routeIs('dashboard')">
                        <a href="{{ route('dashboard') }}" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-home-circle"></i>
                            <div data-i18n="Dashboards">Dashboards</div>
                        </a>
                    </x-nav-link>

                    <li class="menu-header small text-uppercase">
                        <span class="menu-header-text">Apps &amp; Pages</span>
                    </li>

                    <x-nav-link class="menu-item" :active="request()->routeIs('siswa.index')">
                        <a href="{{ route('siswa.index') }}" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-group"></i>
                            <div data-i18n="Siswa">Siswa</div>
                        </a>
                    </x-nav-link>

                    <x-nav-link class="menu-item" :active="request()->routeIs('kelas.index')">
                        <a href="{{ route('kelas.index') }}" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-chalkboard"></i>
                            <div data-i18n="Kelas">Kelas</div>
                        </a>
                    </x-nav-link>

                    <x-nav-link class="menu-item" :active="request()->routeIs('users.index')">
                        <a href="{{ route('users.index') }}" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-user"></i>
                            <div data-i18n="users">Users</div>
                        </a>
                    </x-nav-link>

                    <li class="menu-item {{ request()->routeIs('master.*') ? 'active open' : '' }}">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class='menu-icon tf-icons bx bx-data'></i>
                            <div data-i18n="Master Data">Master Data</div>
                        </a>
                        <ul class="menu-sub">
                            <li class="menu-item {{ request()->routeIs('master.jurusan') ? 'active' : '' }}">
                                <a href="{{ route('master.jurusan') }}" class="menu-link">
                                    <div data-i18n="Jurusan">Jurusan</div>
                                </a>
                            </li>
                            <li class="menu-item {{ request()->routeIs('master.mapel') ? 'active' : '' }}">
                                <a href="{{ route('master.mapel') }}" class="menu-link">
                                    <div data-i18n="Mata Pelajaran">Mata Pelajaran</div>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="menu-item {{ request()->routeIs('tracking.*') ? 'active' : '' }}">
                        <a href="{{ route('tracking.index') }}" class="menu-link">
                            <i class='menu-icon tf-icons bx bx-map-pin'></i>
                            <div data-i18n="Tracking">Tracking Siswa</div>
                        </a>
                    </li>

                    <x-nav-link class="menu-item" :active="request()->routeIs(['data.index', 'data.terlambat', 'data.guest'])">
                        <a href="{{ route('data.index') }}" class="menu-link">
                            <i class='menu-icon tf-icons bx bx- cabinet'></i>
                            <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="0 0 24 24">
                                <path fill="currentColor"
                                    d="M20 17V7c0-2.168-3.663-4-8-4S4 4.832 4 7v10c0 2.168 3.663 4 8 4s8-1.832 8-4M12 5c3.691 0 5.931 1.507 6 1.994C17.931 7.493 15.691 9 12 9S6.069 7.493 6 7.006C6.069 6.507 8.309 5 12 5M6 9.607C7.479 10.454 9.637 11 12 11s4.521-.546 6-1.393v2.387c-.069.499-2.309 2.006-6 2.006s-5.931-1.507-6-2zM6 17v-2.393C7.479 15.454 9.637 16 12 16s4.521-.546 6-1.393v2.387c-.069.499-2.309 2.006-6 2.006s-5.931-1.507-6-2" />
                            </svg>
                            <div data-i18n="Data" class="ms-2">Data</div>
                        </a>
                    </x-nav-link>

                    <li class="menu-item">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <a href="{{ route('logout') }}" class="menu-link"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                                <i class="menu-icon tf-icons bx bx-log-out"></i>
                                <div data-i18n="Log Out">Log Out</div>
                            </a>
                        </form>
                    </li>
                </ul>
            </aside>
            <div class="layout-page">
                <div class="mt-3 content-wrapper mb-5">
                    @yield('content')
                </div>

                <div class="content-backdrop fade"></div>
            </div>
        </div>
    </div>

    <div class="layout-overlay layout-menu-toggle"></div>

    <script src="{{ asset('dashboard-admin/assets/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('dashboard-admin/assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('dashboard-admin/assets/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('dashboard-admin/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('dashboard-admin/assets/vendor/js/menu.js') }}"></script>

    <script src="{{ asset('dashboard-admin/assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>
    <script src="{{ asset('dashboard-admin/assets/js/main.js') }}"></script>
    <script src="{{ asset('dashboard-admin/assets/js/dashboards-analytics.js') }}"></script>

    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
        // Toastr Flash Messages
        @if (session()->has('success'))
            toastr.success('{{ session('success') }}', 'BERHASIL!');
        @elseif (session()->has('error'))
            toastr.error('{{ session('error') }}', 'GAGAL!');
        @endif

        // Default DataTable Init
        $(document).ready(function() {
            if ($('#myTable').length) {
                $('#myTable').DataTable();
            }
        });
    </script>

    @stack('scripts')
</body>

</html>