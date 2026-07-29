<x-app-layout>

    <x-slot name="header">
        <h2 class="fw-bold">
            Detail Jadwal Praktek
        </h2>
    </x-slot>

    <div class="container-fluid">

        <div class="card shadow-sm">

            <div class="card-header d-flex justify-content-between align-items-center">

                <h5 class="mb-0">
                    Informasi Jadwal Praktek
                </h5>

                <div class="d-flex gap-2">

                    <a href="{{ route('psychologist_schedules.edit', $schedule) }}"
                       class="btn btn-warning">
                        <i class="bi bi-pencil-square"></i>
                        Edit
                    </a>

                    <form action="{{ route('psychologist_schedules.destroy', $schedule) }}"
                          method="POST"
                          onsubmit="return confirm('Yakin ingin mengarsipkan jadwal praktek ini?')">

                        @csrf
                        @method('DELETE')

                        <button class="btn btn-danger">
                            <i class="bi bi-archive"></i>
                            Arsipkan
                        </button>

                    </form>

                    <a href="{{ route('psychologist_schedules.index') }}"
                       class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i>
                        Kembali
                    </a>

                </div>

            </div>

            <div class="card-body">

                <div class="row mb-3">

                    <div class="col-md-3 fw-bold">
                        <!-- dd{{$schedule}} -->
                        Psikolog
                    </div>

                    <div class="col-md-9">
                        {{ $schedule->psychologist?->name ?? '-' }}
                    </div>

                </div>

                <div class="row mb-3">

                    <div class="col-md-3 fw-bold">
                        Hari
                    </div>

                    <div class="col-md-9">
                        {{ $schedule->dayname }}
                    </div>

                </div>

                <div class="row mb-3">

                    <div class="col-md-3 fw-bold">
                        Jam Praktek
                    </div>

                    <div class="col-md-9">
                        {{ $schedule->schedule }}
                    </div>

                </div>

                <div class="row mb-3">

                    <div class="col-md-3 fw-bold">
                        Durasi Slot
                    </div>

                    <div class="col-md-9">
                        {{ $schedule->duration }}
                    </div>

                </div>

                <div class="row mb-3">

                    <div class="col-md-3 fw-bold">
                        Status
                    </div>

                    <div class="col-md-9">

                        @if($schedule->is_active)
                            <span class="badge bg-success">
                                Aktif
                            </span>
                        @else
                            <span class="badge bg-secondary">
                                Non Aktif
                            </span>
                        @endif

                    </div>

                </div>

                <div class="row">

                    <div class="col-md-3 fw-bold">
                        Catatan
                    </div>

                    <div class="col-md-9">
                        {{ $schedule->notes ?: '-' }}
                    </div>

                </div>

            </div>

        </div>

    </div>

</x-app-layout>