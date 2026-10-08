<x-app-layout>

    <div class="container-fluid">

        {{-- Header --}}
        <div class="d-flex justify-content-between align-items-center mb-3">

            <div>
                <h4 class="mb-1">
                    Tambah Appointment
                </h4>

                <small class="text-muted">
                    Membuat jadwal pelayanan pasien
                </small>
            </div>

            <a href="{{ route('appointments.index') }}"
               class="btn btn-secondary">

                <i class="bi bi-arrow-left"></i>
                Kembali

            </a>

        </div>


        {{-- Validation Error --}}
        {{--ini yang alert merah kita tutup dulu--}}
        <!-- @if($errors->any())

            <div class="alert alert-danger">

                <strong>
                    Terdapat kesalahan:
                </strong>

                <ul class="mb-0 mt-2">

                    @foreach($errors->all() as $error)

                        <li>
                            {{ $error }}
                        </li>

                    @endforeach

                </ul>

            </div>

         @endif -->

        {{-- ================================================= --}}
        {{-- MODAL ERROR VALIDASI --}}
        {{-- ================================================= --}}

        @if ($errors->any())
            <div class="modal fade"
                id="validationErrorModal"
                tabindex="-1"
                aria-labelledby="validationErrorModalLabel"
                aria-hidden="true">

                <div class="modal-dialog modal-dialog-centered">

                    <div class="modal-content">

                        <div class="modal-header bg-danger text-white">

                            <h5 class="modal-title"
                                id="validationErrorModalLabel">
                                Appointment Tidak Dapat Disimpan
                            </h5>

                            <button type="button"
                                    class="btn-close btn-close-white"
                                    data-bs-dismiss="modal"
                                    aria-label="Close">
                            </button>

                        </div>

                        <div class="modal-body">

                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>

                        </div>

                        <div class="modal-footer">

                            <button type="button"
                                    class="btn btn-secondary"
                                    data-bs-dismiss="modal">
                                Tutup
                            </button>

                        </div>

                    </div>

                </div>

            </div>
        @endif

        <form method="POST"
              action="{{ route('appointments.store') }}">

            @csrf

            <div class="row">


                {{-- =====================================================
                     LEFT
                ====================================================== --}}

                <div class="col-md-8">

                    <div class="card shadow-sm mb-3">

                        <div class="card-header">

                            <strong>
                                Informasi Appointment
                            </strong>

                        </div>


                        <div class="card-body">


                            {{-- Branch --}}
                            <div class="mb-3">

                                <label class="form-label">

                                    Branch

                                    <span class="text-danger">
                                        *
                                    </span>

                                </label>


                                <select
                                    name="branch_id"
                                    class="form-select @error('branch_id') is-invalid @enderror"
                                >

                                    <option value="">
                                        -- Pilih Branch --
                                    </option>


                                    @foreach($branches as $branch)

                                        <option
                                            value="{{ $branch->id }}"
                                            {{ old('branch_id') == $branch->id
                                                ? 'selected'
                                                : '' }}
                                        >

                                            {{ $branch->branch_code }}

                                            -

                                            {{ $branch->branch_name }}

                                        </option>

                                    @endforeach

                                </select>


                                @error('branch_id')

                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>

                                @enderror

                            </div>



                            {{-- Patient --}}
                            <div class="mb-3">

                                <label
                                    for="patient_search"
                                    class="form-label"
                                >

                                    Pasien

                                    <span class="text-danger">
                                        *
                                    </span>

                                </label>


                                <input
                                    type="text"
                                    id="patient_search"
                                    class="form-control"
                                    placeholder="Ketik nama, nomor pasien, atau nomor HP..."
                                    autocomplete="off"
                                    value="{{ $selectedPatient?->name }}"
                                >


                                <div
                                    id="patient_search_loading"
                                    class="text-muted small mt-1 d-none"
                                >

                                    Mencari pasien...

                                </div>


                                <div
                                    id="patient_search_results"
                                    class="list-group mt-1"
                                >
                                </div>


                                <input
                                    type="hidden"
                                    name="patient_id"
                                    id="patient_id"
                                    value="{{ old('patient_id', $selectedPatient?->id) }}"
                                >


                                <div
                                    id="selected_patient_info"
                                    class="alert alert-info mt-2
                                        {{ $selectedPatient ? '' : 'd-none' }}"
                                >

                                    @if($selectedPatient)

                                        <strong>
                                            Pasien terpilih:
                                        </strong>

                                        {{ $selectedPatient->name }}

                                        <br>

                                        <small>

                                            No. Pasien:

                                            {{ $selectedPatient->patient_number }}


                                            @if($selectedPatient->phone)

                                                |

                                                HP:

                                                {{ $selectedPatient->phone }}

                                            @endif

                                        </small>

                                    @endif

                                </div>


                                @error('patient_id')

                                    <div class="text-danger small mt-1">
                                        {{ $message }}
                                    </div>

                                @enderror

                            </div>



                            {{-- Source Type --}}
                            <div class="mb-3">

                                <label class="form-label">

                                    Sumber Layanan

                                    <span class="text-danger">
                                        *
                                    </span>

                                </label>


                                <select
                                    name="source_type"
                                    id="source_type"
                                    class="form-select @error('source_type') is-invalid @enderror"
                                >

                                    <option value="">
                                        -- Pilih Sumber Layanan --
                                    </option>


                                    <option
                                        value="{{ \App\Models\Appointment::SOURCE_NORMAL }}"

                                        {{ old(
                                            'source_type',
                                            \App\Models\Appointment::SOURCE_NORMAL
                                        ) == \App\Models\Appointment::SOURCE_NORMAL
                                            ? 'selected'
                                            : '' }}
                                    >

                                        Tarif Normal

                                    </option>


                                    <option
                                        value="{{ \App\Models\Appointment::SOURCE_PACKAGE }}"

                                        {{ old('source_type') ==
                                            \App\Models\Appointment::SOURCE_PACKAGE
                                                ? 'selected'
                                                : '' }}
                                    >

                                        Patient Package

                                    </option>

                                </select>


                                @error('source_type')

                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>

                                @enderror


                                <small class="text-muted">

                                    Setiap Appointment tetap memiliki
                                    layanan. Yang berbeda adalah sumber
                                    layanannya.

                                </small>

                            </div>



                            {{-- Patient Package --}}
                            <div
                                id="patientPackageContainer"
                                class="mb-3 d-none"
                            >

                                <label class="form-label">

                                    Patient Package

                                    <span class="text-danger">
                                        *
                                    </span>

                                </label>


                                <select
                                    name="patient_package_id"
                                    id="patient_package_id"
                                    class="form-select @error('patient_package_id') is-invalid @enderror"
                                    disabled
                                >

                                    <option value="">
                                        -- Pilih PASIEN terlebih dahulu --
                                    </option>

                                </select>


                                <div
                                    id="patient_package_loading"
                                    class="text-muted small mt-1 d-none"
                                >

                                    Memuat paket pasien...

                                </div>


                                @error('patient_package_id')

                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>

                                @enderror

                            </div>



                            {{-- Package Service --}}
                            <div
                                id="packageServiceContainer"
                                class="mb-3 d-none"
                            >

                                <label class="form-label">

                                    Layanan Paket

                                    <span class="text-danger">
                                        *
                                    </span>

                                </label>


                                <select
                                    name="service_package_detail_id"
                                    id="service_package_detail_id"
                                    class="form-select @error('service_package_detail_id') is-invalid @enderror"
                                    disabled
                                >

                                    <option value="">
                                        -- Pilih Patient Package terlebih dahulu --
                                    </option>

                                </select>


                                @error('service_package_detail_id')

                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>

                                @enderror

                            </div>



                            {{-- Normal Service --}}
                            <div
                                id="normalServiceContainer"
                                class="mb-3"
                            >

                                <label class="form-label">

                                    Layanan

                                    <span class="text-danger">
                                        *
                                    </span>

                                </label>


                                <select
                                    name="service_rate_id"
                                    id="service_rate_id"
                                    class="form-select @error('service_rate_id') is-invalid @enderror"
                                >

                                    <option value="">
                                        -- Pilih Layanan --
                                    </option>


                                    @foreach($serviceRates as $serviceRate)

                                        <option
                                            value="{{ $serviceRate->id }}"

                                            {{ old('service_rate_id') ==
                                                $serviceRate->id
                                                    ? 'selected'
                                                    : '' }}
                                        >

                                            {{ $serviceRate->service_name }}

                                            -

                                            Rp

                                            {{ number_format(
                                                $serviceRate->price,
                                                0,
                                                ',',
                                                '.'
                                            ) }}

                                        </option>

                                    @endforeach

                                </select>


                                @error('service_rate_id')

                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>

                                @enderror

                            </div>



                            {{-- Package Quota --}}
                            <div
                                id="quotaInfo"
                                class="alert alert-info d-none mb-3"
                            >

                                <div class="row text-center">


                                    <div class="col-md-4">

                                        <small class="text-muted d-block">
                                            Kuota
                                        </small>

                                        <strong id="quotaTotal">
                                            0
                                        </strong>

                                    </div>


                                    <div class="col-md-4">

                                        <small class="text-muted d-block">
                                            Terpakai
                                        </small>

                                        <strong id="quotaUsed">
                                            0
                                        </strong>

                                    </div>


                                    <div class="col-md-4">

                                        <small class="text-muted d-block">
                                            Sisa
                                        </small>

                                        <strong id="quotaRemaining">
                                            0
                                        </strong>

                                    </div>


                                </div>

                            </div>



                            {{-- Psychologist --}}
                            <div class="mb-3">

                                <label class="form-label">
                                    Psikolog
                                </label>


                                <select
                                    name="psychologist_id"
                                    id="psychologist_id"
                                    class="form-select @error('psychologist_id') is-invalid @enderror"
                                >

                                    <option value="">
                                        -- Tidak ditentukan --
                                    </option>


                                    @foreach($psychologists as $psychologist)

                                        <option
                                            value="{{ $psychologist->id }}"

                                            {{ old('psychologist_id') ==
                                                $psychologist->id
                                                    ? 'selected'
                                                    : '' }}
                                        >

                                            {{ $psychologist->name }}

                                        </option>

                                    @endforeach

                                </select>


                                @error('psychologist_id')

                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>

                                @enderror

                            </div>



                            {{-- Schedule --}}
                            <div class="mb-3">

                                <label class="form-label">
                                    Jadwal Psikolog
                                </label>


                                <select
                                    name="psychologist_schedule_id"
                                    id="psychologist_schedule_id"
                                    class="form-select @error('psychologist_schedule_id') is-invalid @enderror"
                                >

                                    <option value="">
                                        -- Pilih Jadwal --
                                    </option>

                                </select>


                                @error('psychologist_schedule_id')

                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>

                                @enderror


                                <small class="text-muted">

                                    Jadwal akan digunakan untuk membantu
                                    pengecekan bentrok pelayanan.

                                </small>

                            </div>



                            {{-- Date --}}
                            <div class="row">

                                <div class="col-md-6">

                                    <div class="mb-3">

                                        <label class="form-label">

                                            Tanggal

                                            <span class="text-danger">
                                                *
                                            </span>

                                        </label>


                                        <input
                                            type="date"
                                            name="appointment_date"
                                            class="form-control @error('appointment_date') is-invalid @enderror"

                                            value="{{ old(
                                                'appointment_date',
                                                now()->format('Y-m-d')
                                            ) }}"
                                        >


                                        @error('appointment_date')

                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>

                                        @enderror

                                    </div>

                                </div>



                                {{-- Time --}}
                                <div class="col-md-6">

                                    <div class="mb-3">

                                        <label class="form-label">

                                            Jam

                                            <span class="text-danger">
                                                *
                                            </span>

                                        </label>


                                        <input
                                            type="time"
                                            name="appointment_time"
                                            class="form-control @error('appointment_time') is-invalid @enderror"

                                            value="{{ old('appointment_time') }}"
                                        >


                                        @error('appointment_time')

                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>

                                        @enderror

                                    </div>

                                </div>

                            </div>



                            {{-- Status --}}
                            <div class="mb-3">

                                <label class="form-label">

                                    Status

                                    <span class="text-danger">
                                        *
                                    </span>

                                </label>


                                <select
                                    name="status"
                                    class="form-select @error('status') is-invalid @enderror"
                                >

                                    <option
                                        value="{{ \App\Models\Appointment::STATUS_DRAFT }}"

                                        {{ old(
                                            'status',
                                            \App\Models\Appointment::STATUS_DRAFT
                                        ) == \App\Models\Appointment::STATUS_DRAFT
                                            ? 'selected'
                                            : '' }}
                                    >
                                        Draft
                                    </option>


                                    <option
                                        value="{{ \App\Models\Appointment::STATUS_RESERVED }}"

                                        {{ old('status') ==
                                            \App\Models\Appointment::STATUS_RESERVED
                                                ? 'selected'
                                                : '' }}
                                    >
                                        Reserved
                                    </option>

                                </select>


                                @error('status')

                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>

                                @enderror

                            </div>



                            {{-- Notes --}}
                            <div class="mb-3">

                                <label class="form-label">
                                    Catatan Operasional
                                </label>


                                <textarea
                                    name="notes"
                                    rows="3"
                                    class="form-control @error('notes') is-invalid @enderror"
                                    placeholder="Catatan untuk appointment..."
                                >{{ old('notes') }}</textarea>


                                @error('notes')

                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>

                                @enderror

                            </div>


                        </div>


                        {{-- Footer --}}
                        <div class="card-footer d-flex justify-content-end gap-2">

                            <a
                                href="{{ route('appointments.index') }}"
                                class="btn btn-secondary"
                            >
                                Batal
                            </a>


                            <button
                                type="submit"
                                class="btn btn-success"
                            >

                                <i class="bi bi-save"></i>

                                Simpan Appointment

                            </button>

                        </div>

                    </div>

                </div>



                {{-- =====================================================
                     RIGHT
                ====================================================== --}}

                <div class="col-md-4">

                    <div class="card shadow-sm">

                        <div class="card-header">

                            <strong>
                                Informasi Layanan
                            </strong>

                        </div>


                        <div class="card-body">


                            {{-- Normal --}}
                            <div id="normalInfo">

                                <div class="alert alert-primary mb-0">

                                    <strong>
                                        Tarif Normal
                                    </strong>

                                    <p class="mb-0 mt-2">

                                        Layanan akan menggunakan
                                        tarif normal dari Service Rate.

                                    </p>

                                </div>

                            </div>



                            {{-- Package --}}
                            <div
                                id="packageInfo"
                                class="d-none"
                            >

                                <div class="alert alert-success mb-0">

                                    <strong>
                                        Patient Package
                                    </strong>


                                    <p class="mb-2 mt-2">

                                        Appointment ini akan menggunakan
                                        jatah layanan dari Patient Package.

                                    </p>


                                    <hr>


                                    <div>

                                        <small class="text-muted">
                                            Paket
                                        </small>

                                        <div id="infoPackageName">
                                            -
                                        </div>

                                    </div>


                                    <div class="mt-2">

                                        <small class="text-muted">
                                            Layanan
                                        </small>

                                        <div id="infoServiceName">
                                            -
                                        </div>

                                    </div>


                                </div>

                            </div>


                        </div>

                    </div>

                </div>

            </div>

        </form>

        <div class="card shadow-sm mt-4">

            <div class="card-header">
                <strong>
                    Jadwal Appointment Psikolog
                </strong>
            </div>

            <div class="card-body">

                <div
                    id="psychologist_appointments_empty"
                    class="text-muted"
                >
                    Pilih psikolog dan tanggal appointment
                    untuk melihat jadwal.
                </div>

                <div
                    id="psychologist_appointments_loading"
                    class="text-muted d-none"
                >
                    <div
                        class="spinner-border spinner-border-sm me-2"
                    ></div>

                    Memuat appointment...
                </div>

                <div
                    id="psychologist_appointments_table_wrapper"
                    class="table-responsive d-none"
                >

                    <table
                        class="table table-hover table-striped align-middle"
                    >

                        <thead class="table-light">

                            <tr>
                                <th>Tanggal</th>
                                <th>Jam</th>
                                <th>Pasien</th>
                                <th>Layanan</th>
                                <th>Status</th>
                            </tr>

                        </thead>

                        <tbody
                            id="psychologist_appointments_table"
                        ></tbody>

                    </table>

                </div>

                <div
                    id="psychologist_appointments_none"
                    class="alert alert-success d-none"
                >
                    Tidak ada appointment yang sedang berjalan
                    pada tanggal tersebut.
                </div>

            </div>

        </div>

    </div>

    


    
    @push('scripts')

    <script>

        document.addEventListener('DOMContentLoaded', function () {

            const modalElement = document.getElementById('validationErrorModal');

            if (modalElement) {

                const modal = new bootstrap.Modal(modalElement);

                modal.show();
            }

        });
        


        /*
        |--------------------------------------------------------------------------
        | ELEMENTS
        |--------------------------------------------------------------------------
        */

        const sourceType =
            document.getElementById('source_type');

        const patientPackageContainer =
            document.getElementById(
                'patientPackageContainer'
            );

        const packageServiceContainer =
            document.getElementById(
                'packageServiceContainer'
            );

        const normalServiceContainer =
            document.getElementById(
                'normalServiceContainer'
            );

        const patientPackageSelect =
            document.getElementById(
                'patient_package_id'
            );

        const patientPackageLoading =
            document.getElementById(
                'patient_package_loading'
            );

        const packageServiceSelect =
            document.getElementById(
                'service_package_detail_id'
            );

        const serviceRateSelect =
            document.getElementById(
                'service_rate_id'
            );

        const quotaInfo =
            document.getElementById(
                'quotaInfo'
            );

        const quotaTotal =
            document.getElementById(
                'quotaTotal'
            );

        const quotaUsed =
            document.getElementById(
                'quotaUsed'
            );

        const quotaRemaining =
            document.getElementById(
                'quotaRemaining'
            );

        const normalInfo =
            document.getElementById(
                'normalInfo'
            );

        const packageInfo =
            document.getElementById(
                'packageInfo'
            );

        const infoPackageName =
            document.getElementById(
                'infoPackageName'
            );

        const infoServiceName =
            document.getElementById(
                'infoServiceName'
            );

        const psychologistSelect =
            document.getElementById(
                'psychologist_id'
            );

        const scheduleSelect =
            document.getElementById(
                'psychologist_schedule_id'
            );

        const appointmentDateInput =
            document.querySelector(
                'input[name="appointment_date"]'
            );

        const patientSearch =
            document.getElementById(
                'patient_search'
            );

        const patientId =
            document.getElementById(
                'patient_id'
            );

        const patientSearchResults =
            document.getElementById(
                'patient_search_results'
            );

        const patientSearchLoading =
            document.getElementById(
                'patient_search_loading'
            );

        const selectedPatientInfo =
            document.getElementById(
                'selected_patient_info'
            );


        /*
        |--------------------------------------------------------------------------
        | OLD INPUT
        |--------------------------------------------------------------------------
        */

        const oldPatientPackageId =
            {{ Illuminate\Support\Js::from(
                old('patient_package_id')
            ) }};

        const oldPackageDetailId =
            {{ Illuminate\Support\Js::from(
                old('service_package_detail_id')
            ) }};

        const oldPsychologistScheduleId =
            {{ Illuminate\Support\Js::from(
                old('psychologist_schedule_id')
            ) }};


        /*
        |--------------------------------------------------------------------------
        | RESET PACKAGE
        |--------------------------------------------------------------------------
        */

        function resetPackageFields()
        {
            patientPackageSelect.innerHTML = `
                <option value="">
                    -- Pilih PASIEN terlebih dahulu --
                </option>
            `;

            patientPackageSelect.disabled = true;


            packageServiceSelect.innerHTML = `
                <option value="">
                    -- Pilih Patient Package terlebih dahulu --
                </option>
            `;

            packageServiceSelect.disabled = true;


            quotaTotal.textContent = '0';
            quotaUsed.textContent = '0';
            quotaRemaining.textContent = '0';

            quotaInfo.classList.add('d-none');


            infoPackageName.textContent = '-';
            infoServiceName.textContent = '-';

        }


        /*
        |--------------------------------------------------------------------------
        | LOAD PATIENT PACKAGE
        |--------------------------------------------------------------------------
        */

        function loadPatientPackages(
            selectedPatientId
        )
        {
            resetPackageFields();


            if (!selectedPatientId) {

                return;

            }


            patientPackageLoading
                .classList
                .remove('d-none');


            fetch(
                `/patient-packages/by-patient/${selectedPatientId}`
            )

                .then(response => {

                    if (!response.ok) {

                        throw new Error(
                            'Gagal mengambil Patient Package.'
                        );

                    }

                    return response.json();

                })


                .then(packages => {

                    patientPackageSelect.innerHTML = `
                        <option value="">
                            -- Pilih Patient Package --
                        </option>
                    `;


                    if (packages.length === 0) {

                        patientPackageSelect.innerHTML = `
                            <option value="">
                                -- Pasien tidak memiliki Patient Package aktif --
                            </option>
                        `;

                        return;

                    }


                    packages.forEach(
                        patientPackage => {

                            const option =
                                document.createElement(
                                    'option'
                                );


                            option.value =
                                patientPackage.id;


                            option.textContent =
                                patientPackage.package_no
                                + ' - '
                                + patientPackage.package_name;


                            patientPackageSelect
                                .appendChild(
                                    option
                                );

                        }
                    );


                    patientPackageSelect.disabled =
                        false;


                    /*
                    |--------------------------------------------------------------------------
                    | Restore package setelah validation error
                    |--------------------------------------------------------------------------
                    */

                    if (
                        oldPatientPackageId
                    ) {

                        patientPackageSelect.value =
                            oldPatientPackageId;


                        if (
                            patientPackageSelect.value ==
                            oldPatientPackageId
                        ) {

                            patientPackageSelect
                                .dispatchEvent(
                                    new Event('change')
                                );

                        }

                    }

                })


                .catch(error => {

                    console.error(error);


                    patientPackageSelect.innerHTML = `
                        <option value="">
                            -- Gagal mengambil Patient Package --
                        </option>
                    `;

                })


                .finally(() => {

                    patientPackageLoading
                        .classList
                        .add('d-none');

                });

        }


        /*
        |--------------------------------------------------------------------------
        | PATIENT PACKAGE CHANGED
        |--------------------------------------------------------------------------
        */

        patientPackageSelect.addEventListener(
            'change',
            function ()
            {

                const packageId =
                    parseInt(
                        this.value
                    );


                packageServiceSelect.innerHTML = `
                    <option value="">
                        -- Memuat Layanan Paket... --
                    </option>
                `;


                packageServiceSelect.disabled =
                    true;


                quotaInfo
                    .classList
                    .add('d-none');


                serviceRateSelect.value =
                    '';


                infoPackageName.textContent =
                    '-';

                infoServiceName.textContent =
                    '-';


                if (!packageId) {

                    packageServiceSelect.innerHTML = `
                        <option value="">
                            -- Pilih Patient Package terlebih dahulu --
                        </option>
                    `;

                    return;

                }


                fetch(
                    `/patient-packages/${packageId}/details`
                )

                    .then(response => {

                        if (!response.ok) {

                            throw new Error(
                                'Gagal mengambil detail Patient Package.'
                            );

                        }

                        return response.json();

                    })


                    .then(details => {

                        packageServiceSelect.innerHTML = `
                            <option value="">
                                -- Pilih Layanan Paket --
                            </option>
                        `;


                        if (
                            details.length === 0
                        ) {

                            packageServiceSelect.innerHTML = `
                                <option value="">
                                    -- Tidak ada layanan dalam paket --
                                </option>
                            `;

                            return;

                        }


                        details.forEach(
                            detail => {

                                const option =
                                    document.createElement(
                                        'option'
                                    );


                                option.value =
                                    detail.id;


                                option.dataset.serviceRateId =
                                    detail.service_rate_id;


                                option.dataset.quantity =
                                    detail.quantity;


                                option.dataset.used =
                                    detail.used;


                                option.dataset.remaining =
                                    detail.remaining;


                                option.dataset.serviceName =
                                    detail.service_name;


                                option.textContent =
                                    detail.service_name
                                    + ' | Sisa: '
                                    + detail.remaining;


                                if (
                                    detail.remaining <= 0
                                ) {

                                    option.disabled =
                                        true;


                                    option.textContent +=
                                        ' (Kuota Habis)';

                                }


                                packageServiceSelect
                                    .appendChild(
                                        option
                                    );

                            }
                        );


                        packageServiceSelect.disabled =
                            false;


                        /*
                        |--------------------------------------------------------------------------
                        | Restore old detail
                        |--------------------------------------------------------------------------
                        */

                        if (
                            oldPackageDetailId
                        ) {

                            packageServiceSelect.value =
                                oldPackageDetailId;


                            if (
                                packageServiceSelect.value ==
                                oldPackageDetailId
                            ) {

                                packageServiceSelect
                                    .dispatchEvent(
                                        new Event('change')
                                    );

                            }

                        }

                    })


                    .catch(error => {

                        console.error(error);


                        packageServiceSelect.innerHTML = `
                            <option value="">
                                -- Gagal mengambil layanan paket --
                            </option>
                        `;

                    });

            }
        );


        /*
        |--------------------------------------------------------------------------
        | PACKAGE SERVICE CHANGED
        |--------------------------------------------------------------------------
        */

        packageServiceSelect.addEventListener(
            'change',
            function ()
            {

                const option =
                    this.options[
                        this.selectedIndex
                    ];


                const detailId =
                    this.value;


                quotaInfo
                    .classList
                    .add('d-none');


                serviceRateSelect.value =
                    '';


                if (
                    !detailId ||
                    !option
                ) {

                    return;

                }


                const serviceRateId =
                    option.dataset.serviceRateId;


                const quantity =
                    option.dataset.quantity;


                const used =
                    option.dataset.used;


                const remaining =
                    option.dataset.remaining;


                const serviceName =
                    option.dataset.serviceName;


                /*
                | Service Rate
                */

                serviceRateSelect.value =
                    serviceRateId;


                /*
                | Quota
                */

                quotaTotal.textContent =
                    quantity;


                quotaUsed.textContent =
                    used;


                quotaRemaining.textContent =
                    remaining;


                quotaInfo
                    .classList
                    .remove('d-none');


                /*
                | Information
                */

                const packageOption =
                    patientPackageSelect
                        .options[
                            patientPackageSelect.selectedIndex
                        ];


                infoPackageName.textContent =
                    packageOption
                        ? packageOption.textContent
                        : '-';


                infoServiceName.textContent =
                    serviceName;

            }
        );


        /*
        |--------------------------------------------------------------------------
        | PATIENT SEARCH
        |--------------------------------------------------------------------------
        */

        let patientSearchTimer =
            null;


        patientSearch.addEventListener(
            'input',
            function ()
            {

                const keyword =
                    this.value.trim();


                clearTimeout(
                    patientSearchTimer
                );


                patientSearchResults.innerHTML =
                    '';


                /*
                | User mengganti pasien.
                */

                patientId.value =
                    '';


                selectedPatientInfo
                    .classList
                    .add('d-none');


                resetPackageFields();


                if (
                    keyword.length < 2
                ) {

                    patientSearchLoading
                        .classList
                        .add('d-none');

                    return;

                }


                patientSearchTimer =
                    setTimeout(
                        function ()
                        {

                            patientSearchLoading
                                .classList
                                .remove('d-none');


                            fetch(
                                `/patients/search?q=${encodeURIComponent(keyword)}`
                            )

                                .then(response => {

                                    if (!response.ok) {

                                        throw new Error(
                                            'Gagal mencari pasien.'
                                        );

                                    }

                                    return response.json();

                                })


                                .then(patients => {

                                    patientSearchResults
                                        .innerHTML = '';


                                    if (
                                        patients.length === 0
                                    ) {

                                        patientSearchResults.innerHTML = `
                                            <div class="list-group-item text-muted">
                                                Pasien tidak ditemukan.
                                            </div>
                                        `;

                                        return;

                                    }


                                    patients.forEach(
                                        patient => {

                                            const item =
                                                document.createElement(
                                                    'button'
                                                );


                                            item.type =
                                                'button';


                                            item.className =
                                                'list-group-item list-group-item-action';


                                            item.innerHTML = `
                                                <strong>
                                                    ${patient.name}
                                                </strong>

                                                <br>

                                                <small class="text-muted">

                                                    No. Pasien:
                                                    ${patient.patient_number}

                                                    ${
                                                        patient.phone
                                                            ? ' | HP: ' + patient.phone
                                                            : ''
                                                    }

                                                </small>
                                            `;


                                            item.addEventListener(
                                                'click',
                                                function ()
                                                {

                                                    patientId.value =
                                                        patient.id;


                                                    patientSearch.value =
                                                        patient.name;


                                                    patientSearchResults
                                                        .innerHTML =
                                                            '';


                                                    selectedPatientInfo
                                                        .classList
                                                        .remove(
                                                            'd-none'
                                                        );


                                                    selectedPatientInfo.innerHTML = `
                                                        <strong>
                                                            Pasien terpilih:
                                                        </strong>

                                                        ${patient.name}

                                                        <br>

                                                        <small>

                                                            No. Pasien:
                                                            ${patient.patient_number}

                                                            ${
                                                                patient.phone
                                                                    ? ' | HP: ' + patient.phone
                                                                    : ''
                                                            }

                                                        </small>
                                                    `;


                                                    /*
                                                    |--------------------------------------------------------------------------
                                                    | Ambil package pasien
                                                    |--------------------------------------------------------------------------
                                                    */

                                                    loadPatientPackages(
                                                        patient.id
                                                    );

                                                }
                                            );


                                            patientSearchResults
                                                .appendChild(
                                                    item
                                                );

                                        }
                                    );

                                })


                                .catch(error => {

                                    console.error(
                                        error
                                    );


                                    patientSearchResults.innerHTML = `
                                        <div class="list-group-item text-danger">
                                            Gagal mencari pasien.
                                        </div>
                                    `;

                                })


                                .finally(() => {

                                    patientSearchLoading
                                        .classList
                                        .add('d-none');

                                });


                        },
                        300
                    );

            }
        );


        /*
        |--------------------------------------------------------------------------
        | PSYCHOLOGIST -> SCHEDULE
        |--------------------------------------------------------------------------
        */

        psychologistSelect.addEventListener(
            'change',
            function ()
            {

                const psychologistId =
                    this.value;


                scheduleSelect.innerHTML = `
                    <option value="">
                        -- Pilih Jadwal --
                    </option>
                `;


                if (
                    !psychologistId
                ) {

                    return;

                }


                fetch(
                    `/psychologist-schedules/by-psychologist/${psychologistId}`
                )

                    .then(response => {

                        if (!response.ok) {

                            throw new Error(
                                'Gagal mengambil schedule.'
                            );

                        }

                        return response.json();

                    })


                    .then(schedules => {

                        schedules.forEach(
                            schedule => {

                                const option =
                                    document.createElement(
                                        'option'
                                    );


                                option.value =
                                    schedule.id;


                                option.textContent =
                                    schedule.day_name
                                    + ' | '
                                    + schedule.start_time
                                    + ' - '
                                    + schedule.end_time;


                                scheduleSelect
                                    .appendChild(
                                        option
                                    );

                            }
                        );


                        /*
                        |--------------------------------------------------------------------------
                        | Restore schedule setelah validation error
                        |--------------------------------------------------------------------------
                        */

                        if (
                            oldPsychologistScheduleId
                        ) {

                            scheduleSelect.value =
                                oldPsychologistScheduleId;

                        }

                    })


                    .catch(error => {

                        console.error(
                            'Gagal mengambil schedule:',
                            error
                        );

                    });

            }
        );

        function updateSourceType()
        {
            const source = sourceType.value;

            if (source == '{{ \App\Models\Appointment::SOURCE_PACKAGE }}') {

                patientPackageContainer.classList.remove('d-none');
                packageServiceContainer.classList.remove('d-none');
                normalServiceContainer.classList.add('d-none');

                normalInfo.classList.add('d-none');
                packageInfo.classList.remove('d-none');

            } else {

                patientPackageContainer.classList.add('d-none');
                packageServiceContainer.classList.add('d-none');
                normalServiceContainer.classList.remove('d-none');

                normalInfo.classList.remove('d-none');
                packageInfo.classList.add('d-none');

                resetPackageFields();
            }
        }
        sourceType.addEventListener('change', function () {
            updateSourceType();
        });
        /*
        |--------------------------------------------------------------------------
        | INITIAL STATE
        |--------------------------------------------------------------------------
        */

        updateSourceType();


        /*
        |--------------------------------------------------------------------------
        | RESTORE OLD PATIENT
        |--------------------------------------------------------------------------
        */

        @if($selectedPatient)

            loadPatientPackages(
                {{ $selectedPatient->id }}
            );

        @endif

        function loadPsychologistAppointments() {

            const psychologistId =
                psychologistSelect.value;

            const appointmentDate =
                appointmentDateInput.value;

            const empty =
                document.getElementById(
                    'psychologist_appointments_empty'
                );

            const loading =
                document.getElementById(
                    'psychologist_appointments_loading'
                );

            const wrapper =
                document.getElementById(
                    'psychologist_appointments_table_wrapper'
                );

            const tbody =
                document.getElementById(
                    'psychologist_appointments_table'
                );

            const none =
                document.getElementById(
                    'psychologist_appointments_none'
                );

            tbody.innerHTML = '';

            wrapper.classList.add('d-none');
            none.classList.add('d-none');

            if (!psychologistId || !appointmentDate) {

                empty.classList.remove('d-none');

                return;
            }

            empty.classList.add('d-none');
            loading.classList.remove('d-none');

            fetch(
                `/appointments/by-psychologist/${psychologistId}/${appointmentDate}`
            )
                .then(response => {

                    if (!response.ok) {
                        throw new Error(
                            'Gagal mengambil appointment.'
                        );
                    }

                    return response.json();
                })
                .then(appointments => {

                    loading.classList.add('d-none');

                    if (appointments.length === 0) {

                        none.classList.remove('d-none');

                        return;
                    }

                    appointments.forEach(appointment => {

                        const row =
                            document.createElement('tr');

                        row.innerHTML = `
                            <td>
                                ${appointment.date}
                            </td>

                            <td>
                                <strong>
                                    ${appointment.start_time}
                                    -
                                    ${appointment.end_time}
                                </strong>
                            </td>

                            <td>
                                ${appointment.patient_name}
                            </td>

                            <td>
                                ${appointment.service_name}
                            </td>

                            <td>
                                <span class="badge bg-info">
                                    ${appointment.status}
                                </span>
                            </td>
                        `;

                        tbody.appendChild(row);
                    });

                    wrapper.classList.remove('d-none');
                })
                .catch(error => {

                    loading.classList.add('d-none');

                    console.error(error);

                    none.classList.remove('d-none');

                    none.classList.remove('alert-success');

                    none.classList.add('alert-danger');

                    none.textContent =
                        'Gagal mengambil jadwal appointment.';
                });
        }



    </script>

    

    @endpush

</x-app-layout>