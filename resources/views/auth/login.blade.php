<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <title>Login - PsyClinic</title>

</head>

<body class="bg-light">

<div class="container">

    <div class="row justify-content-center align-items-center min-vh-100">

        <div class="col-md-5">

            <div class="card shadow">

                <div class="card-header text-center bg-primary text-white">

                    <h4 class="mb-0">
                        PsyClinic
                    </h4>

                    <small>Login Admin</small>

                </div>

                <div class="card-body">

                    <form method="POST" action="{{ route('login') }}">

                        @csrf

                        <div class="mb-3">

                            <label for="email" class="form-label">
                                Email
                            </label>

                            <input
                                id="email"
                                type="email"
                                name="email"
                                class="form-control @error('email') is-invalid @enderror"
                                value="{{ old('email') }}"
                                required
                                autofocus
                            >

                            @error('email')

                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>

                            @enderror

                        </div>


                        <div class="mb-3">

                            <label for="password" class="form-label">
                                Password
                            </label>

                            <input
                                id="password"
                                type="password"
                                name="password"
                                class="form-control @error('password') is-invalid @enderror"
                                required
                            >

                            @error('password')

                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>

                            @enderror

                        </div>


                        <div class="d-flex justify-content-between align-items-center">

                            <a href="{{ route('register') }}">
                                Register
                            </a>

                            <button type="submit" class="btn btn-primary">
                                Login
                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

</body>

</html>