<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <title>PsyClinic</title>
</head>

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">

<div class="app-wrapper">

    <!-- Navbar -->
    <nav class="app-header navbar navbar-expand bg-body">
        <div class="container-fluid">

            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        PsyClinic
                    </a>
                </li>
            </ul>

        </div>
    </nav>

    <!-- Sidebar -->
    <aside class="app-sidebar bg-body-secondary shadow">
        <div class="sidebar-brand">
            <a href="#" class="brand-link">
                <span class="brand-text fw-light">PsyClinic</span>
            </a>
        </div>

        <div class="sidebar-wrapper">
            <nav class="mt-2">

                <ul class="nav sidebar-menu flex-column">

                    <li class="nav-item">
                        <a href="#" class="nav-link active">
                            <p>Dashboard</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <p>Pasien</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <p>Appointment</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <p>Timeline Pasien</p>
                        </a>
                    </li>

                </ul>

            </nav>
        </div>
    </aside>

    <!-- Content -->
    <main class="app-main">

        <div class="app-content-header">
            <div class="container-fluid">

                <h3 class="mb-0">Dashboard</h3>

            </div>
        </div>

        <div class="app-content">

            <div class="container-fluid">

                <div class="row">

                    <div class="col-lg-3 col-6">

                        <div class="small-box text-bg-primary">

                            <div class="inner">
                                <h3>0</h3>
                                <p>Pasien</p>
                            </div>

                        </div>

                    </div>

                    <div class="col-lg-3 col-6">

                        <div class="small-box text-bg-success">

                            <div class="inner">
                                <h3>0</h3>
                                <p>Appointment</p>
                            </div>

                        </div>

                    </div>

                    <div class="col-lg-3 col-6">

                        <div class="small-box text-bg-warning">

                            <div class="inner">
                                <h3>0</h3>
                                <p>Rekam Psikologi</p>
                            </div>

                        </div>

                    </div>

                    <div class="col-lg-3 col-6">

                        <div class="small-box text-bg-danger">

                            <div class="inner">
                                <h3>Rp 0</h3>
                                <p>Pendapatan</p>
                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </main>

</div>

</body>
</html>