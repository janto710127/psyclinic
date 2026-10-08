<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'PsyClinic') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Bootstrap Icons --}}
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>

        body {
            background: #f5f7fb;
            font-family: "Inter", "Segoe UI", sans-serif;
        }

        /* =========================
           TOPBAR
        ========================= */

        .topbar {
            height: 70px;
            background: linear-gradient(135deg, #4f46e5, #6366f1);
            box-shadow: 0 4px 15px rgba(0, 0, 0, .08);
        }

        .brand {
            font-size: 22px;
            font-weight: 700;
            letter-spacing: .3px;
        }

        .brand-icon {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(255,255,255,.15);
            border-radius: 12px;
            font-size: 21px;
        }

        .user-name {
            font-weight: 600;
            font-size: 14px;
        }

        .user-avatar {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: #fff;
            color: #4f46e5;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
        }

        /* =========================
           SIDEBAR
        ========================= */

        .sidebar {
            width: 260px;
            background: #ffffff;
            border-right: 1px solid #e9edf5;
            min-height: calc(100vh - 70px);
            padding: 22px 15px;
        }

        .sidebar-title {
            font-size: 11px;
            font-weight: 700;
            color: #9ca3af;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 0 12px;
            margin-bottom: 10px;
        }

        .menu-item {
            display: flex;
            align-items: center;
            gap: 12px;

            padding: 11px 13px;
            margin-bottom: 4px;

            border-radius: 10px;

            color: #4b5563;
            text-decoration: none;

            font-size: 14px;
            font-weight: 500;

            transition: all .2s ease;
        }

        .menu-item i {
            width: 22px;
            font-size: 18px;
            text-align: center;
        }

        .menu-item:hover {
            background: #f1f3ff;
            color: #4f46e5;
            transform: translateX(2px);
        }

        .menu-item.active {
            background: linear-gradient(
                135deg,
                #4f46e5,
                #6366f1
            );

            color: white;

            box-shadow: 0 5px 12px rgba(79,70,229,.2);
        }

        .menu-item.active i {
            color: white;
        }

        .archive-item {
            color: #6b7280;
        }

        /* =========================
           MAIN CONTENT
        ========================= */

        .main-content {
            padding: 30px;
            width: calc(100% - 260px);
        }

        /* =========================
           ALERT
        ========================= */

        .custom-alert {
            border: none;
            border-radius: 12px;
            padding: 14px 18px;
        }

        /* =========================
           MOBILE
        ========================= */

        @media (max-width: 768px) {

            .sidebar {
                width: 100%;
                min-height: auto;
            }

            .main-content {
                width: 100%;
                padding: 20px;
            }

            .layout-wrapper {
                flex-direction: column;
            }

        }

    </style>

</head>


<body>

    {{-- =========================
         TOPBAR
    ========================= --}}

    <nav class="topbar navbar navbar-dark">

        <div class="container-fluid px-4">

            {{-- BRAND --}}

            <div class="d-flex align-items-center gap-3">

                <div class="brand-icon">
                    <i class="bi bi-heart-pulse-fill"></i>
                </div>

                <span class="brand text-white">
                    PsyClinic
                </span>

            </div>


            {{-- USER --}}

            <div class="d-flex align-items-center gap-3">

                <div class="text-end d-none d-sm-block">

                    <div class="user-name text-white">
                        {{ auth()->user()->name }}
                    </div>

                    <small class="text-white-50">
                        Administrator
                    </small>

                </div>


                <div class="user-avatar">

                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}

                </div>


                <form method="POST"
                      action="{{ route('logout') }}">

                    @csrf

                    <button type="submit"
                            class="btn btn-light btn-sm rounded-pill px-3">

                        <i class="bi bi-box-arrow-right me-1"></i>

                        Logout

                    </button>

                </form>

            </div>

        </div>

    </nav>


    {{-- =========================
         PAGE LAYOUT
    ========================= --}}

    <div class="d-flex layout-wrapper">


        {{-- =========================
             SIDEBAR
        ========================= --}}

        <aside class="sidebar">

            <div class="sidebar-title">
                Main Menu
            </div>


            {{-- Dashboard --}}

            <a href="{{ route('dashboard') }}"
               class="menu-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">

                <i class="bi bi-grid-1x2-fill"></i>

                <span>Dashboard</span>

            </a>


            {{-- Organization --}}

            <a href="{{ route('organizations.index') }}"
               class="menu-item {{ request()->routeIs('organizations.*') ? 'active' : '' }}">

                <i class="bi bi-building"></i>

                <span>Organization</span>

            </a>


            {{-- Branch --}}

            <a href="{{ route('branches.index') }}"
               class="menu-item {{ request()->routeIs('branches.*') ? 'active' : '' }}">

                <i class="bi bi-diagram-3"></i>

                <span>Branch</span>

            </a>


            <div class="sidebar-title mt-4">
                Patient Management
            </div>


            {{-- Pasien --}}

            <a href="{{ route('patients.index') }}"
               class="menu-item {{ request()->routeIs('patients.index') ? 'active' : '' }}">

                <i class="bi bi-people-fill"></i>

                <span>Pasien</span>

            </a>


            {{-- Arsip Pasien --}}

            <a href="{{ route('patients.archived') }}"
               class="menu-item archive-item {{ request()->routeIs('patients.archived') ? 'active' : '' }}">

                <i class="bi bi-archive-fill"></i>

                <span>Arsip Pasien</span>

            </a>


            <div class="sidebar-title mt-4">
                Psychology
            </div>


            {{-- Psikolog --}}

            <a href="{{ route('psychologists.index') }}"
               class="menu-item {{ request()->routeIs('psychologists.index') ? 'active' : '' }}">

                <i class="bi bi-person-badge-fill"></i>

                <span>Psikolog</span>

            </a>


            {{-- Arsip Psikolog --}}

            <a href="{{ route('psychologists.archived') }}"
               class="menu-item archive-item {{ request()->routeIs('psychologists.archived') ? 'active' : '' }}">

                <i class="bi bi-person-x-fill"></i>

                <span>Arsip Psikolog</span>

            </a>


            {{-- Jadwal Praktek --}}

            <a href="{{ route('psychologist_schedules.index') }}"
               class="menu-item {{ request()->routeIs('psychologist_schedules.index') ? 'active' : '' }}">

                <i class="bi bi-calendar-week-fill"></i>

                <span>Jadwal Praktek</span>

            </a>


            {{-- Arsip Jadwal --}}

            <a href="{{ route('psychologist_schedules.archived') }}"
               class="menu-item archive-item {{ request()->routeIs('psychologist_schedules.archived') ? 'active' : '' }}">

                <i class="bi bi-calendar-x-fill"></i>

                <span>Arsip Jadwal</span>

            </a>


            <div class="sidebar-title mt-4">
                Services
            </div>


            {{-- Tarif Layanan --}}

            <a href="{{ route('service_rates.index') }}"
               class="menu-item {{ request()->routeIs('service_rates.index') ? 'active' : '' }}">

                <i class="bi bi-cash-stack"></i>

                <span>Tarif Layanan</span>

            </a>


            {{-- Arsip Tarif --}}

            <a href="{{ route('service_rates.archived') }}"
               class="menu-item archive-item {{ request()->routeIs('service_rates.archived') ? 'active' : '' }}">

                <i class="bi bi-wallet2"></i>

                <span>Arsip Tarif</span>

            </a>


            {{-- Paket Layanan --}}

            <a href="{{ route('service_packages.index') }}"
               class="menu-item {{ request()->routeIs('service_packages.*') ? 'active' : '' }}">

                <i class="bi bi-box-seam-fill"></i>

                <span>Paket Layanan</span>

            </a>


            <div class="sidebar-title mt-4">
                Clinical
            </div>


            {{-- Appointment --}}

            <a href="{{ route('appointments.index') }}"
               class="menu-item {{ request()->routeIs('appointments.*') ? 'active' : '' }}">

                <i class="bi bi-calendar-check-fill"></i>

                <span>Appointment</span>

            </a>


            {{-- Timeline --}}

            <a href="#"
               class="menu-item">

                <i class="bi bi-clock-history"></i>

                <span>Timeline Pasien</span>

            </a>

        </aside>


        {{-- =========================
             MAIN CONTENT
        ========================= --}}

        <main class="main-content">


            {{-- SUCCESS ALERT --}}

            @if(session('success'))

                <div class="alert alert-success custom-alert alert-dismissible fade show shadow-sm"
                     role="alert">

                    <div class="d-flex align-items-center">

                        <i class="bi bi-check-circle-fill fs-5 me-2"></i>

                        <div>

                            {{ session('success') }}

                        </div>

                    </div>


                    <button type="button"
                            class="btn-close"
                            data-bs-dismiss="alert">
                    </button>

                </div>

            @endif


            {{-- ERROR ALERT --}}

            @if(session('error'))

                <div class="alert alert-danger custom-alert alert-dismissible fade show shadow-sm"
                     role="alert">

                    <div class="d-flex align-items-center">

                        <i class="bi bi-exclamation-triangle-fill fs-5 me-2"></i>

                        <div>

                            {{ session('error') }}

                        </div>

                    </div>


                    <button type="button"
                            class="btn-close"
                            data-bs-dismiss="alert">
                    </button>

                </div>

            @endif


            {{-- PAGE CONTENT --}}

            {{ $slot }}

        </main>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')

</body>

</html>