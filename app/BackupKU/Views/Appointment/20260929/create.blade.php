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
        @if($errors->any())

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

        @endif


        <form method="POST"
              action="{{ route('appointments.store') }}">

            @csrf

            <div class="row">

                {{-- LEFT --}}
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
                                    <span class="text-danger">*</span>
                                </label>

                                <select name="branch_id"
                                        class="form-select @error('branch_id') is-invalid @enderror">

                                    <option value="">
                                        -- Pilih Branch --
                                    </option>

                                    @foreach($branches as $branch)

                                        <option value="{{ $branch->id }}"
                                            {{ old('branch_id') == $branch->id ? 'selected' : '' }}>

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

                                <label class="form-label">
                                    Pasien
                                    <span class="text-danger">*</span>
                                </label>

                                <select name="patient_id"
                                        id="patient_id"
                                        class="form-select @error('patient_id') is-invalid @enderror">

                                    <option value="">
                                        -- Pilih Pasien --
                                    </option>

                                    @foreach($patients as $patient)

                                        <option value="{{ $patient->id }}"
                                            {{ old('patient_id') == $patient->id ? 'selected' : '' }}>

                                            {{ $patient->name }}

                                        </option>

                                    @endforeach

                                </select>

                                 @error('patient_id')

                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>

                                @enderror

                            </div>


                            {{-- Source Type --}}
                            <div class="mb-3">

                                <label class="form-label">

                                    Sumber Layanan

                                    <span class="text-danger">*</span>

                                </label>

                                <select name="source_type"
                                        id="source_type"
                                        class="form-select @error('source_type') is-invalid @enderror">

                                    <option value="">
                                        -- Pilih Sumber Layanan --
                                    </option>

                                    <option value="{{ \App\Models\Appointment::SOURCE_NORMAL }}"
                                        {{ old(
                                            'source_type',
                                            \App\Models\Appointment::SOURCE_NORMAL
                                        ) == \App\Models\Appointment::SOURCE_NORMAL
                                            ? 'selected'
                                            : '' }}>

                                        Tarif Normal

                                    </option>

                                    <option value="{{ \App\Models\Appointment::SOURCE_PACKAGE }}"
                                        {{ old('source_type')
                                            == \App\Models\Appointment::SOURCE_PACKAGE
                                            ? 'selected'
                                            : '' }}>

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
                            <div id="patientPackageContainer"
                                 class="mb-3 d-none">

                                <label class="form-label">

                                    Patient Package

                                    <span class="text-danger">*</span>

                                </label>

                                <select name="patient_package_id"
                                        id="patient_package_id"
                                        class="form-select @error('patient_package_id') is-invalid @enderror"
                                         disabled>

                                    <option value="">
                                        -- Pilih PASIEN terlebih dahulu --
                                    </option>

                                    <!-- dibawah ini harus di disabled biar load paket nggak semua -->

                                    <!-- @foreach($patientPackages as $patientPackage)

                                        <option value="{{ $patientPackage->id }}"
                                            {{ old('patient_package_id') == $patientPackage->id
                                                ? 'selected'
                                                : '' }}>

                                            {{ $patientPackage->patient_package_no }}
                                            -
                                            {{ $patientPackage->patient->name }}
                                            -
                                            {{ $patientPackage->servicePackage->package_name }}

                                        </option>

                                    @endforeach -->

                                </select>

                                @error('patient_package_id')

                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>

                                @enderror

                            </div>


                            {{-- Package Service --}}
                            <div id="packageServiceContainer"
                                 class="mb-3 d-none">

                                <label class="form-label">

                                    Layanan Paket

                                    <span class="text-danger">*</span>

                                </label>

                                <select name="service_package_detail_id"
                                        id="service_package_detail_id"
                                        class="form-select @error('service_package_detail_id') is-invalid @enderror"
                                        disabled>

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
                            <div id="normalServiceContainer"
                                 class="mb-3">

                                <label class="form-label">

                                    Layanan

                                    <span class="text-danger">*</span>

                                </label>

                                <select name="service_rate_id"
                                        id="service_rate_id"
                                        class="form-select @error('service_rate_id') is-invalid @enderror">

                                    <option value="">
                                        -- Pilih Layanan --
                                    </option>

                                    @foreach($serviceRates as $serviceRate)

                                        <option value="{{ $serviceRate->id }}"
                                            {{ old('service_rate_id') == $serviceRate->id
                                                ? 'selected'
                                                : '' }}>

                                            {{ $serviceRate->service_name }}
                                            -
                                            Rp {{ number_format(
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
                            <div id="quotaInfo"
                                 class="alert alert-info d-none mb-3">

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

                                <select name="psychologist_id"
                                        id="psychologist_id"
                                        class="form-select @error('psychologist_id') is-invalid @enderror">

                                    <option value="">
                                        -- Tidak ditentukan --
                                    </option>

                                    @foreach($psychologists as $psychologist)

                                        <option value="{{ $psychologist->id }}"
                                            {{ old('psychologist_id') == $psychologist->id
                                                ? 'selected'
                                                : '' }}>

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

                                <select name="psychologist_schedule_id"
                                        id="psychologist_schedule_id"
                                        class="form-select @error('psychologist_schedule_id') is-invalid @enderror">

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

                                            <span class="text-danger">*</span>

                                        </label>

                                        <input type="date"
                                               name="appointment_date"
                                               class="form-control @error('appointment_date') is-invalid @enderror"
                                               value="{{ old(
                                                   'appointment_date',
                                                   now()->format('Y-m-d')
                                               ) }}">

                                        @error('appointment_date')

                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>

                                        @enderror

                                    </div>

                                </div>


                                <div class="col-md-6">

                                    <div class="mb-3">

                                        <label class="form-label">

                                            Jam

                                            <span class="text-danger">*</span>

                                        </label>

                                        <input type="time"
                                               name="appointment_time"
                                               class="form-control @error('appointment_time') is-invalid @enderror"
                                               value="{{ old('appointment_time') }}">

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

                                    <span class="text-danger">*</span>

                                </label>

                                <select name="status"
                                        class="form-select @error('status') is-invalid @enderror">

                                    <option value="{{ \App\Models\Appointment::STATUS_DRAFT }}"
                                        {{ old(
                                            'status',
                                            \App\Models\Appointment::STATUS_DRAFT
                                        ) == \App\Models\Appointment::STATUS_DRAFT
                                            ? 'selected'
                                            : '' }}>

                                        Draft

                                    </option>

                                    <option value="{{ \App\Models\Appointment::STATUS_RESERVED }}"
                                        {{ old('status')
                                            == \App\Models\Appointment::STATUS_RESERVED
                                            ? 'selected'
                                            : '' }}>

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

                                <textarea name="notes"
                                          rows="3"
                                          class="form-control @error('notes') is-invalid @enderror"
                                          placeholder="Catatan untuk appointment...">{{ old('notes') }}</textarea>

                                @error('notes')

                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>

                                @enderror

                            </div>

                        </div>


                        <div class="card-footer d-flex justify-content-end gap-2">

                            <a href="{{ route('appointments.index') }}"
                               class="btn btn-secondary">

                                Batal

                            </a>

                            <button type="submit"
                                    class="btn btn-success">

                                <i class="bi bi-save"></i>
                                Simpan Appointment

                            </button>

                        </div>

                    </div>

                </div>


                {{-- RIGHT --}}
                <div class="col-md-4">

                    <div class="card shadow-sm">

                        <div class="card-header">

                            <strong>
                                Informasi Layanan
                            </strong>

                        </div>

                        <div class="card-body">

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


                            <div id="packageInfo"
                                 class="d-none">

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

    </div>


    @push('scripts')

    <script>

        /*
        |--------------------------------------------------------------------------
        | Data Patient Package
        |--------------------------------------------------------------------------
        */

        const patientPackages =
            {{ Illuminate\Support\Js::from(
                $patientPackages->map(
                    function ($patientPackage) {

                        return [

                            'id' =>
                                $patientPackage->id,

                            'patient_id' =>
                                $patientPackage->patient_id,

                            'package_no' =>
                                $patientPackage->patient_package_no,

                            'package_name' =>
                                $patientPackage
                                    ->servicePackage
                                    ->package_name,

                            'details' =>
                                $patientPackage
                                    ->servicePackage
                                    ->details
                                    ->map(
                                        function ($detail) use (
                                            $patientPackage
                                        ) {

                                            $used =
                                                $patientPackage
                                                    ->usages
                                                    ->where(
                                                        'service_package_detail_id',
                                                        $detail->id
                                                    )
                                                    ->sum('quantity');

                                            $remaining =
                                                max(
                                                    0,
                                                    $detail->quantity
                                                    - $used
                                                );

                                            return [

                                                'id' =>
                                                    $detail->id,

                                                'service_rate_id' =>
                                                    $detail->service_rate_id,

                                                'service_name' =>
                                                    $detail
                                                        ->serviceRate
                                                        ->service_name,

                                                'quota' =>
                                                    $detail->quantity,

                                                'used' =>
                                                    $used,

                                                'remaining' =>
                                                    $remaining,

                                            ];
                                        }
                                    )
                                    ->values(),

                        ];
                    }
                )->values()
            ) }};


        /*
        |--------------------------------------------------------------------------
        | Elements
        |--------------------------------------------------------------------------
        */

        const sourceType =
            document.getElementById(
                'source_type'
            );

        const patientSelect =
            document.getElementById(
                'patient_id'
            );

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
            document.getElementById('psychologist_id');

        const scheduleSelect =
            document.getElementById('psychologist_schedule_id');

        /*
        |--------------------------------------------------------------------------
        | Source Type
        |--------------------------------------------------------------------------
        */

        function updateSourceType()
        {
            const source =
                parseInt(
                    sourceType.value
                );


            if (
                source
                === {{ \App\Models\Appointment::SOURCE_PACKAGE }}
            ) {

                patientPackageContainer
                    .classList
                    .remove('d-none');

                packageServiceContainer
                    .classList
                    .remove('d-none');

                normalServiceContainer
                    .classList
                    .add('d-none');

                serviceRateSelect.value = '';

                normalInfo
                    .classList
                    .add('d-none');

                packageInfo
                    .classList
                    .remove('d-none');

            } else {

                patientPackageContainer
                    .classList
                    .add('d-none');

                packageServiceContainer
                    .classList
                    .add('d-none');

                normalServiceContainer
                    .classList
                    .remove('d-none');

                packageServiceSelect.value = '';
                packageServiceSelect.disabled = true;

                quotaInfo
                    .classList
                    .add('d-none');

                normalInfo
                    .classList
                    .remove('d-none');

                packageInfo
                    .classList
                    .add('d-none');

            }
        }


        sourceType.addEventListener(
            'change',
            updateSourceType
        );


        /*
        |--------------------------------------------------------------------------
        | Patient Package
        |--------------------------------------------------------------------------
        */

        patientPackageSelect.addEventListener(
            'change',
            function () {

                const packageId =
                    parseInt(
                        this.value
                    );

                packageServiceSelect.innerHTML =
                    '<option value="">-- Pilih Layanan Paket --</option>';

                packageServiceSelect.disabled =
                    true;

                quotaInfo
                    .classList
                    .add('d-none');


                if (!packageId) {

                    return;

                }


                const patientPackage =
                    patientPackages.find(
                        item =>
                            item.id === packageId
                    );


                if (!patientPackage) {

                    return;

                }


                /*
                |--------------------------------------------------------------------------
                | Pastikan package milik pasien
                |--------------------------------------------------------------------------
                */

                if (
                    patientSelect.value
                    &&
                    parseInt(
                        patientSelect.value
                    )
                    !== patientPackage.patient_id
                ) {

                    alert(
                        'Patient Package ini bukan milik pasien yang dipilih.'
                    );

                    this.value = '';

                    return;

                }


                patientPackage.details
                    .forEach(
                        detail => {

                            const option =
                                document.createElement(
                                    'option'
                                );

                            option.value =
                                detail.id;

                            option.dataset.serviceRateId =
                                detail.service_rate_id;

                            option.textContent =
                                detail.service_name
                                + ' | Sisa: '
                                + detail.remaining;


                            if (
                                detail.remaining <= 0
                            ) {

                                option.disabled = true;

                                option.textContent +=
                                    ' (Kuota Habis)';

                            }


                            packageServiceSelect
                                .appendChild(option);

                        }
                    );


                packageServiceSelect.disabled =
                    false;

            }
        );


        /*
        |--------------------------------------------------------------------------
        | Package Service
        |--------------------------------------------------------------------------
        */

        packageServiceSelect.addEventListener(
            'change',
            function () {

                const detailId =
                    parseInt(
                        this.value
                    );


                quotaInfo
                    .classList
                    .add('d-none');


                if (!detailId) {

                    serviceRateSelect.value = '';

                    return;

                }


                const packageId =
                    parseInt(
                        patientPackageSelect.value
                    );


                const patientPackage =
                    patientPackages.find(
                        item =>
                            item.id === packageId
                    );


                if (!patientPackage) {

                    return;

                }


                const detail =
                    patientPackage.details.find(
                        item =>
                            item.id === detailId
                    );


                if (!detail) {

                    return;

                }


                /*
                |--------------------------------------------------------------------------
                | Set Service Rate
                |--------------------------------------------------------------------------
                */

                serviceRateSelect.value =
                    detail.service_rate_id;


                /*
                |--------------------------------------------------------------------------
                | Quota
                |--------------------------------------------------------------------------
                */

                quotaTotal.textContent =
                    detail.quota;

                quotaUsed.textContent =
                    detail.used;

                quotaRemaining.textContent =
                    detail.remaining;

                quotaInfo
                    .classList
                    .remove('d-none');


                /*
                |--------------------------------------------------------------------------
                | Informasi
                |--------------------------------------------------------------------------
                */

                infoPackageName.textContent =
                    patientPackage.package_name;

                infoServiceName.textContent =
                    detail.service_name;

            }
        );


        /*
        |--------------------------------------------------------------------------
        | Patient berubah
        |--------------------------------------------------------------------------
        */

        patientSelect.addEventListener(
            'change',
            function () {

                const patientId =
                    parseInt(this.value);


                /*
                |--------------------------------------------------------------------------
                | Reset Patient Package
                |--------------------------------------------------------------------------
                */

                patientPackageSelect.innerHTML =
                    '<option value="">-- Pilih Patient Package --</option>';

                patientPackageSelect.disabled = true;


                /*
                |--------------------------------------------------------------------------
                | Reset Service Paket
                |--------------------------------------------------------------------------
                */

                packageServiceSelect.innerHTML =
                    '<option value="">-- Pilih Patient Package terlebih dahulu --</option>';

                packageServiceSelect.disabled = true;


                /*
                |--------------------------------------------------------------------------
                | Reset Quota
                |--------------------------------------------------------------------------
                */

                quotaInfo.classList.add('d-none');


                /*
                |--------------------------------------------------------------------------
                | Jika pasien belum dipilih
                |--------------------------------------------------------------------------
                */

                if (!patientId) {

                    return;

                }


                /*
                |--------------------------------------------------------------------------
                | Ambil Patient Package milik pasien
                |--------------------------------------------------------------------------
                */

                patientPackages
                    .filter(
                        patientPackage =>
                            patientPackage.patient_id
                            === patientId
                    )
                    .forEach(
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
                                .appendChild(option);

                        }
                    );


                /*
                |--------------------------------------------------------------------------
                | Aktifkan dropdown
                |--------------------------------------------------------------------------
                */

                patientPackageSelect.disabled = false;

            }
        );


        /*
        |--------------------------------------------------------------------------
        | Initial State
        |--------------------------------------------------------------------------
        */

        updateSourceType();


 /*
|--------------------------------------------------------------------------
| Initial Patient Filter
|--------------------------------------------------------------------------
*/

if (patientSelect.value) {

    patientSelect.dispatchEvent(
        new Event('change')
    );
}


/*
|--------------------------------------------------------------------------
| Restore old Patient Package
|--------------------------------------------------------------------------
*/

@if(old('patient_package_id'))

    setTimeout(function () {

        patientPackageSelect.value =
            '{{ old('patient_package_id') }}';

        patientPackageSelect.dispatchEvent(
            new Event('change')
        );

    }, 100);

@endif


/*
|--------------------------------------------------------------------------
| Restore old Package Service
|--------------------------------------------------------------------------
*/

@if(old('service_package_detail_id'))

    setTimeout(function () {

        packageServiceSelect.value =
            '{{ old('service_package_detail_id') }}';

        packageServiceSelect.dispatchEvent(
            new Event('change')
        );

    }, 200);

@endif

/*
|--------------------------------------------------------------------------
| Pilih psikolog dan Jadwalnya
|--------------------------------------------------------------------------
*/
psychologistSelect.addEventListener(
    'change',
    function () {

        const psychologistId =
            this.value;

        scheduleSelect.innerHTML =
            '<option value="">-- Pilih Jadwal --</option>';

        if (!psychologistId) {
            return;
        }

        fetch(
            // `/appointments/psychologist-schedules/${psychologistId}`
           
            `/psychologist-schedules/by-psychologist/${psychologistId}`
        )
            .then(response => response.json())
            .then(schedules => {

                schedules.forEach(schedule => {

                    const option =
                        document.createElement('option');

                    option.value =
                        schedule.id;

                    option.textContent =
                        schedule.day_name
                        + ' | '
                        + schedule.start_time
                        + ' - '
                        + schedule.end_time;


                    scheduleSelect.appendChild(
                        option
                    );
                });

            })
            .catch(error => {

                console.error(
                    'Gagal mengambil schedule:',
                    error
                );

            });
    }
);

    </script>

    @endpush

</x-app-layout>