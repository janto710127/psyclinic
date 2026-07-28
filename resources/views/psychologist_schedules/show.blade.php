<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detail Jadwal Praktek
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                <div class="p-6 text-gray-900">

                    <div class="d-flex justify-content-between align-items-center mb-4">

                        <h4>Detail Jadwal Praktek</h4>
                        <a href="{{ route('psychologist_schedules.edit', $schedule) }}"

                        
                        class="btn btn-warning">
                            Edit Jadwal Praktek
                        </a>
                        <form action="{{ route('psychologist_schedules.destroy', $schedule) }}"
                                    method="POST"
                                    class="d-inline"
                                    onsubmit="return confirm('Yakin ingin mengarsipkan jadwal praktek ini?')">

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                            class="btn btn-danger">
                                        Arsipkan
                                    </button>

                        </form>
                        <a href="{{ route('psychologist_schedules.index') }}"
                        class="btn btn-secondary">
                            Kembali
                        </a>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-3 fw-bold">
                            Psikolog
                        </div>

                        <div class="col-md-9">
                            <!-- {{ $schedule->psychologist->name }} -->
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
                            Durasi
                        </div>

                        <div class="col-md-9">
                            {{ $schedule->duration ?? '-' }}
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3 fw-bold">
                            Status
                        </div>

                        <div class="col-md-9">
                            @if($schedule->is_active)

                                <span class="badge bg-success rounded-pill">

                                    Aktif

                                </span>

                            @else

                                <span class="badge bg-secondary rounded-pill">

                                    Non Aktif

                                </span>

                            @endif
                        </div>

                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3 fw-bold">
                            Catatan
                        </div>

                        <div class="col-md-9">
                            {{ $schedule->notes}}
                        </div>
                    </div>

                    <hr>

                </div>

            </div>

        </div>
    </div>

</x-app-layout>