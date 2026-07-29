<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Arsip Jadwal Praktek
        </h2>
    </x-slot>

    <div class="container-fluid">

        <div class="card">

            <div class="card-header">

                Data Jadwal Praktek Diarsipkan

            </div>

            <div class="card-body">

                <form method="GET"
                        action="{{ route('psychologist_schedules.archived') }}"
                        class="row mb-3">

                        <div class="col-md-8">

                            <input type="text"
                                name="search"
                                class="form-control"
                                placeholder="Cari Nama"
                                value="{{ request('search') }}">

                        </div>

                        <div class="col-md-2">

                            <button class="btn btn-primary w-100">

                                Cari

                            </button>

                        </div>

                        <div class="col-md-2">

                            <a href="{{ route('psychologist_schedules.archived') }}"
                            class="btn btn-secondary w-100">

                                Reset

                            </a>

                        </div>

                    </form>

                <table class="table table-bordered table-striped">

                    <thead>

                        <tr>
                            <th>No</th>
                            <th>Psikolog</th>
                            <th>Hari</th>
                            <th>Jam Praktek</th>
                            <th>Durasi</th>
                            <th>Di Hapus</th>
                            <th>Aksi</th>
                        </tr>

                    </thead>

                    <tbody>

                        @forelse($schedules as $schedule)

                            <tr>

                                <td>
                                    {{ $loop->iteration }}
                                </td>

                                <td>
                                    {{ $schedule->psychologist?->name ?? '-' }}                                        
                                </td>

                                    <!-- ambil dari accessor di model psi_sche -->
                                <td>
                                   {{ $schedule->dayname }}
                                </td>

                                <td>
                                   {{ $schedule->schedule }}
                                </td>

                                <td>
                                   {{ $schedule->duration }}
                                </td>

                                

                                <td>
                                    {{ $schedule->deleted_at->format('d-m-Y H:i') }}
                                </td>

                                <td>

                                    <form method="POST"
                                        action="{{ route('psychologist_schedules.restore', $schedule->id) }}"
                                        style="display:inline">

                                        @csrf
                                        @method('PATCH')

                                        <button type="submit"
                                                class="btn btn-success btn-sm"
                                                onclick="return confirm('Pulihkan jadwal praktek ini?')">

                                            Restore

                                        </button>

                                    </form>
                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="5"
                                    class="text-center">

                                    Tidak ada data arsip.

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

                {{ $schedules->links() }}

                <div class="mt-3">

    <a href="{{ route('psychologist_schedules.index') }}"
       class="btn btn-secondary">

        Kembali ke Data Jadwal Praktek

    </a>

</div>

            </div>

        </div>

    </div>

</x-app-layout>