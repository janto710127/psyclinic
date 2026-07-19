<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detail Pasien
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

                </div>

            </div>

        </div>
    </div>

</x-app-layout>