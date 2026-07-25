<x-app-layout>

    <div class="container-fluid">

        <div class="d-flex justify-content-between align-items-center mb-4">

            <h3 class="mb-0">
                Daftar Jadwal Psikolog
            </h3>

            <a href="{{ route('psychologist_schedules.create') }}" class="btn btn-primary">
                <i class="bi bi-plus"></i>
                Tambah Jadwal Psikolog
            </a>
        </div>


        <div class="card shadow-sm">

            <div class="card-header">

                <h5 class="mb-0">
                    Data Jadwal Psikolog
                </h5>

            </div>


            <div class="card-body">

                <form method="GET" action="{{ route('psychologist_schedules.index') }}" class="row g-2 mb-3">

                    <div class="col-md-8">
                        <input type="text"
                            name="search"
                            class="form-control"
                            placeholder="Cari Nama"
                            value="{{ $search }}">
                    </div>

                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">
                            Cari
                        </button>
                    </div>

                    <div class="col-md-2">
                        <a href="{{ route('psychologist_schedules.index') }}" class="btn btn-secondary w-100">
                            Reset
                        </a>
                    </div>

                </form>

                <div class="table-responsive">

                    <table class="table table-bordered table-hover">

                        <thead class="table-light">

                            <tr>

                                <th width="60">
                                    No
                                </th>

                                <th>
                                    Psikolog
                                </th>

                                <th>
                                    Hari 
                                </th>

                                <th>
                                    Jam Praktek
                                </th>

                                <th>
                                    Durasi
                                </th>
                                <th>
                                    Status
                                </th>
                                <th width="150">
                                    Aksi
                                </th>

                            </tr>

                        </thead>


                        <tbody>

                            @forelse ($schedules as $schedule)

                                <tr>

                                    <td>
                                        {{ $loop->iteration }}
                                    </td>

                                    <td>
                                        {{ $schedule->name }}
                                    </td>

                                    <!-- ambil dari accessor di model psi_sche -->
                                    <td>
                                        {{ $schedule->dayname }}
                                    </td>

                                    <td>
                                        {{ $schedule->shcedule }}
                                    </td>

                                    <td>
                                        {{ $schedule->duration }}
                                    </td>

                                    <td class="text-center">

                                        @if($psychologist->is_active)

                                            <span class="badge bg-success rounded-pill">

                                                Aktif

                                            </span>

                                        @else

                                            <span class="badge bg-secondary rounded-pill">

                                                Non Aktif

                                            </span>

                                        @endif

                                    </td>

                                    <td>

                                        <a href="{{ route('psychologist_schedules.show', $patient) }}"
                                        class="btn btn-sm btn-info">
                                            Lihat
                                        </a>
                                   </td>

                                </tr>

                            @empty

                                <tr>

                                    <td colspan="6"
                                        class="text-center text-muted">

                                        Belum ada data jadwal psikolog

                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>
 
                </div>
               <div class="mt-3">
                    {{ $schedules->links() }}
                </div>
 
            </div>

        </div>

    </div>

</x-app-layout>