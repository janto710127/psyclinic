<x-app-layout>

    <div class="container-fluid py-4">

        <div class="row">

            <div class="col-12">

                <div class="card shadow-sm">

                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">
                            Dashboard
                        </h4>
                    </div>

                    <div class="card-body">

                        <h5>
                            Selamat datang di PsyClinic
                        </h5>

                        <p class="mb-0">
                            Anda berhasil login sebagai
                            <strong>{{ auth()->user()->name }}</strong>.
                        </p>

                    </div>

                </div>

            </div>

        </div>

    </div>

</x-app-layout>