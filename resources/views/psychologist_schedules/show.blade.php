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

                    @if($schedule->trashed())

                        <form action="{{ route('psychologist_schedules.restore', $schedule->id) }}"
                              method="POST"
                              class="d-inline">

                            @csrf
                            @method('PATCH')

                            <button type="submit"
                                    class="btn btn-success btn-sm"
                                    onclick="return confirm('Pulihkan jadwal ini?')">

                                Restore

                            </button>

                        </form>

                        <a href="{{ route('psychologist_schedules.archived') }}"
                           class="btn btn-secondary btn-sm">

                            Kembali

                        </a>

                    @else

                        <a href="{{ route('psychologist_schedules.edit', $schedule) }}"
                           class="btn btn-warning btn-sm">

                            Edit

                        </a>

                        <form action="{{ route('psychologist_schedules.destroy', $schedule) }}"
                              method="POST"
                              class="d-inline">

                            @csrf
                            @method('DELETE')

                            <button type="submit"
                                    class="btn btn-danger btn-sm"
                                    onclick="return confirm('Arsipkan tarif ini?')">

                                Arsipkan

                            </button>

                        </form>

                        <a href="{{ route('psychologist_schedules.index') }}"
                           class="btn btn-secondary btn-sm">

                            Kembali

                        </a>

                    @endif

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