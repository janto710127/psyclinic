<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detail Psikolog
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                <div class="p-6 text-gray-900">

                    <div class="d-flex justify-content-between align-items-center mb-4">

                        <h4>Profil Pasien</h4>
                        <a href="{{ route('patients.edit', $patient) }}"
                        class="btn btn-warning">
                            Edit Pasien
                        </a>
                        <form action="{{ route('patients.destroy', $patient) }}"
                                    method="POST"
                                    class="d-inline"
                                    onsubmit="return confirm('Yakin ingin mengarsipkan pasien ini?')">

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                            class="btn btn-danger">
                                        Arsipkan
                                    </button>

                        </form>
                        <a href="{{ route('patients.index') }}"
                        class="btn btn-secondary">
                            Kembali
                        </a>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-3 fw-bold">
                            No. Pasien
                        </div>

                        <div class="col-md-9">
                            {{ $patient->patient_number }}
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-3 fw-bold">
                            Nama
                        </div>

                        <div class="col-md-9">
                            {{ $patient->name }}
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-3 fw-bold">
                            Jenis Kelamin
                        </div>

                        <div class="col-md-9">
                            {{ $patient->gender }}
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-3 fw-bold">
                            No. HP
                        </div>

                        <div class="col-md-9">
                            {{ $patient->phone ?? '-' }}
                        </div>
                    </div>

                    <hr>

<div class="d-flex justify-content-between align-items-center mt-4 mb-3">

    <h4 class="mb-0">
        Timeline Pasien
    </h4>

    <a href="{{ route('patients.timelines.create', $patient) }}"
       class="btn btn-primary">

        <i class="bi bi-plus-circle"></i>
        Tambah Timeline

    </a>

</div>

@if($patient->timelines->count())

    <div class="list-group">

        @foreach($patient->timelines->sortByDesc('occurred_at') as $timeline)

            <div class="list-group-item">

                <div class="d-flex justify-content-between">

                    <h5 class="mb-1">
                        {{ $timeline->title }}
                    </h5>

                    <small class="text-muted">

                        {{ $timeline->occurred_at->format('d M Y H:i') }}

                    </small>

                </div>

                <p class="mb-1">

                    {{ $timeline->description ?? '-' }}

                </p>

                <small class="badge bg-secondary">

                    {{ $timeline->type }}

                </small>

            </div>

        @endforeach

    </div>

@else

    <div class="alert alert-info">

        Belum ada timeline pasien.

    </div>

@endif






                </div>

            </div>

        </div>
    </div>

</x-app-layout>