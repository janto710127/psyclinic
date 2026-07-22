<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'PsyClinic') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body class="bg-light">

    <nav class="navbar navbar-dark bg-primary">

        <div class="container-fluid">

            <a class="navbar-brand" href="{{ route('dashboard') }}">
                PsyClinic
            </a>

            <div class="d-flex align-items-center">

                <span class="text-white me-3">
                    {{ auth()->user()->name }}
                </span>

                <form method="POST" action="{{ route('logout') }}">

                    @csrf

                    <button type="submit" class="btn btn-light btn-sm">
                        Logout
                    </button>

                </form>

            </div>

        </div>

    </nav>


    <div class="container-fluid">

        <div class="row">

            <aside class="col-md-2 bg-white border-end min-vh-100 p-3">

                <h5 class="mb-4">
                    Menu
                </h5>

                <div class="list-group">

                    <a href="{{ route('dashboard') }}"
                       class="list-group-item list-group-item-action">

                        Dashboard

                    </a>

                    <a href="{{ route('patients.index') }}"
                      class="list-group-item list-group-item-action">
                        Pasien
                    </a>

                    <a href="{{ route('patients.archived') }}"
                        class="list-group-item list-group-item-action">

                        Arsip Pasien

                    </a>

                    <a href="#" class="list-group-item list-group-item-action">
                        Appointment
                    </a>

                    <a href="#" class="list-group-item list-group-item-action">
                        Timeline Pasien
                    </a>

                </div>

            </aside>


            <main class="col-md-10 p-4">

                {{ $slot }}

            </main>

        </div>

    </div>

</body>

</html>