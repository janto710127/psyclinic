<x-app-layout>

    <div class="container-fluid">

        {{-- Header --}}
        <div class="d-flex justify-content-between align-items-center mb-3">

            <div>
                <h4 class="mb-1">
                    Catat Pemakaian Paket
                </h4>

                <small class="text-muted">
                    Mencatat penggunaan layanan dari Patient Package
                </small>
            </div>

            <a href="{{ route('patient_package_usages.index') }}"
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
              action="{{ route('patient_package_usages.store') }}">

            @csrf

            <div class="row">

                {{-- LEFT --}}
                <div class="col-md-8">

                    <div class="card shadow-sm mb-3">

                        <div class="card-header">

                            <strong>
                                Informasi Pemakaian
                            </strong>

                        </div>

                        <div class="card-body">

                            {{-- Patient Package --}}
                            <div class="mb-3">

                                <label class="form-label">
                                    Patient Package
                                    <span class="text-danger">*</span>
                                </label>

                                <select name="patient_package_id"
                                        id="patient_package_id"
                                        class="form-select @error('patient_package_id') is-invalid @enderror">

                                    <option value="">
                                        -- Pilih Patient Package --
                                    </option>

                                    @foreach($patientPackages as $patientPackage)

                                        <option value="{{ $patientPackage->id }}"
                                            {{ old(
                                                'patient_package_id',
                                                $selectedPatientPackage
                                            ) == $patientPackage->id ? 'selected' : '' }}>

                                            {{ $patientPackage->patient_package_no }}
                                            -
                                            {{ $patientPackage->patient->name }}
                                            -
                                            {{ $patientPackage->servicePackage->package_name }}

                                        </option>

                                    @endforeach

                                </select>

                                @error('patient_package_id')

                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>

                                @enderror

                            </div>


                            {{-- Service --}}
                            <div class="mb-3">

                                <label class="form-label">

                                    Layanan

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


                            {{-- Quota Information --}}
                            <div id="quotaInfo"
                                 class="alert alert-info d-none">

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


                            {{-- Quantity --}}
                            <div class="mb-3">

                                <label class="form-label">

                                    Quantity Pemakaian

                                    <span class="text-danger">*</span>

                                </label>

                                <input type="number"
                                       name="quantity"
                                       id="quantity"
                                       class="form-control @error('quantity') is-invalid @enderror"
                                       value="{{ old('quantity', 1) }}"
                                       min="1"
                                       disabled>

                                <small class="text-muted">
                                    Jumlah sesi/unit yang digunakan.
                                </small>

                                @error('quantity')

                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>

                                @enderror

                            </div>


                            {{-- Appointment --}}
                            <div class="mb-3">

                                <label class="form-label">
                                    Appointment
                                </label>

                                <select name="appointment_id"
                                        class="form-select @error('appointment_id') is-invalid @enderror">

                                    <option value="">
                                        -- Tidak dikaitkan dengan Appointment --
                                    </option>

                                    @foreach($appointments as $appointment)

                                        <option value="{{ $appointment->id }}"
                                            {{ old('appointment_id') == $appointment->id ? 'selected' : '' }}>

                                            {{ $appointment->appointment_no }}
                                            -
                                            {{ $appointment->patient->name }}
                                            -
                                            {{ $appointment->appointment_date?->format('d-m-Y') }}

                                        </option>

                                    @endforeach

                                </select>

                                <small class="text-muted">
                                    Appointment bersifat opsional.
                                </small>

                                @error('appointment_id')

                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>

                                @enderror

                            </div>


                            {{-- Used Date --}}
                            <div class="mb-3">

                                <label class="form-label">

                                    Tanggal Pemakaian

                                    <span class="text-danger">*</span>

                                </label>

                                <input type="date"
                                       name="used_at"
                                       class="form-control @error('used_at') is-invalid @enderror"
                                       value="{{ old('used_at', now()->format('Y-m-d')) }}">

                                @error('used_at')

                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>

                                @enderror

                            </div>


                            {{-- Price --}}
                            <div class="mb-3">

                                <label class="form-label">
                                    Harga
                                </label>

                                <input type="number"
                                       name="price"
                                       class="form-control @error('price') is-invalid @enderror"
                                       value="{{ old('price') }}"
                                       min="0"
                                       step="0.01"
                                       placeholder="Kosongkan jika pemakaian paket">

                                <small class="text-muted">

                                    Untuk pemakaian paket biasanya dapat
                                    dikosongkan karena layanan sudah termasuk
                                    dalam paket.

                                </small>

                                @error('price')

                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>

                                @enderror

                            </div>


                            {{-- Notes --}}
                            <div class="mb-3">

                                <label class="form-label">
                                    Catatan
                                </label>

                                <textarea name="notes"
                                          rows="3"
                                          class="form-control @error('notes') is-invalid @enderror"
                                          placeholder="Catatan pemakaian...">{{ old('notes') }}</textarea>

                                @error('notes')

                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>

                                @enderror

                            </div>

                        </div>


                        <div class="card-footer d-flex justify-content-end gap-2">

                            <a href="{{ route('patient_package_usages.index') }}"
                               class="btn btn-secondary">

                                Batal

                            </a>

                            <button type="submit"
                                    id="btnSubmit"
                                    class="btn btn-success"
                                    disabled>

                                <i class="bi bi-save"></i>
                                Simpan Pemakaian

                            </button>

                        </div>

                    </div>

                </div>


                {{-- RIGHT --}}
                <div class="col-md-4">

                    <div class="card shadow-sm">

                        <div class="card-header">

                            <strong>
                                Informasi Paket
                            </strong>

                        </div>

                        <div class="card-body">

                            <div id="packageInfo"
                                 class="text-muted text-center">

                                <i class="bi bi-box-seam fs-1"></i>

                                <p class="mt-2 mb-0">

                                    Pilih Patient Package
                                    untuk melihat informasi paket.

                                </p>

                            </div>

                            <div id="packageDetail"
                                 class="d-none">

                                <p class="mb-1">
                                    <strong>No Paket:</strong>
                                </p>

                                <p id="packageNo"
                                   class="mb-3">
                                </p>


                                <p class="mb-1">
                                    <strong>Pasien:</strong>
                                </p>

                                <p id="patientName"
                                   class="mb-3">
                                </p>


                                <p class="mb-1">
                                    <strong>Nama Paket:</strong>
                                </p>

                                <p id="packageName"
                                   class="mb-3">
                                </p>


                                <p class="mb-1">
                                    <strong>Status:</strong>
                                </p>

                                <p>

                                    <span id="packageStatus"
                                          class="badge bg-success">

                                    </span>

                                </p>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </form>

    </div>


    @push('scripts')

    <script>

        const patientPackages =
              {{ Illuminate\Support\Js::from($packageData) }};


        const packageSelect =
            document.getElementById(
                'patient_package_id'
            );

        const serviceSelect =
            document.getElementById(
                'service_package_detail_id'
            );

        const quantityInput =
            document.getElementById(
                'quantity'
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

        const packageInfo =
            document.getElementById(
                'packageInfo'
            );

        const packageDetail =
            document.getElementById(
                'packageDetail'
            );

        const packageNo =
            document.getElementById(
                'packageNo'
            );

        const patientName =
            document.getElementById(
                'patientName'
            );

        const packageName =
            document.getElementById(
                'packageName'
            );

        const packageStatus =
            document.getElementById(
                'packageStatus'
            );

        const btnSubmit =
            document.getElementById(
                'btnSubmit'
            );


        let selectedDetail = null;


        packageSelect.addEventListener(
            'change',
            function () {

                const packageId =
                    parseInt(this.value);

                serviceSelect.innerHTML =
                    '<option value="">-- Pilih Layanan --</option>';

                serviceSelect.disabled = true;

                quantityInput.disabled = true;

                btnSubmit.disabled = true;

                quotaInfo.classList.add('d-none');

                selectedDetail = null;


                if (!packageId) {

                    packageInfo.classList.remove('d-none');

                    packageDetail.classList.add('d-none');

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
                | Informasi Paket
                |--------------------------------------------------------------------------
                */

                packageNo.textContent =
                    patientPackage.package_no;

                patientName.textContent =
                    patientPackage.patient_name;

                packageName.textContent =
                    patientPackage.package_name;

                packageStatus.textContent =
                    patientPackage.status_label;

                packageInfo.classList.add('d-none');

                packageDetail.classList.remove('d-none');


                /*
                |--------------------------------------------------------------------------
                | Daftar Service
                |--------------------------------------------------------------------------
                */

                patientPackage.details.forEach(
                    detail => {

                        const option =
                            document.createElement(
                                'option'
                            );

                        option.value =
                            detail.id;

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

                        serviceSelect.appendChild(
                            option
                        );

                    }
                );


                serviceSelect.disabled = false;

            }
        );


        serviceSelect.addEventListener(
            'change',
            function () {

                const detailId =
                    parseInt(this.value);

                selectedDetail = null;

                quantityInput.disabled = true;

                btnSubmit.disabled = true;

                quotaInfo.classList.add('d-none');


                if (!detailId) {

                    return;

                }


                const packageId =
                    parseInt(
                        packageSelect.value
                    );

                const patientPackage =
                    patientPackages.find(
                        item =>
                            item.id === packageId
                    );


                if (!patientPackage) {

                    return;

                }


                selectedDetail =
                    patientPackage.details.find(
                        detail =>
                            detail.id === detailId
                    );


                if (!selectedDetail) {

                    return;

                }


                /*
                |--------------------------------------------------------------------------
                | Tampilkan Kuota
                |--------------------------------------------------------------------------
                */

                quotaTotal.textContent =
                    selectedDetail.quota;

                quotaUsed.textContent =
                    selectedDetail.used;

                quotaRemaining.textContent =
                    selectedDetail.remaining;

                quotaInfo.classList.remove(
                    'd-none'
                );


                /*
                |--------------------------------------------------------------------------
                | Quantity
                |--------------------------------------------------------------------------
                */

                quantityInput.disabled = false;

                quantityInput.min = 1;

                quantityInput.max =
                    selectedDetail.remaining;

                quantityInput.value = 1;


                /*
                |--------------------------------------------------------------------------
                | Submit
                |--------------------------------------------------------------------------
                */

                btnSubmit.disabled =
                    selectedDetail.remaining <= 0;

            }
        );


        quantityInput.addEventListener(
            'input',
            function () {

                if (!selectedDetail) {

                    return;

                }


                const quantity =
                    parseInt(this.value) || 0;


                if (
                    quantity < 1
                ) {

                    this.setCustomValidity(
                        'Quantity minimal 1.'
                    );

                    btnSubmit.disabled = true;

                    return;

                }


                if (
                    quantity >
                    selectedDetail.remaining
                ) {

                    this.setCustomValidity(
                        'Quantity melebihi sisa kuota.'
                    );

                    btnSubmit.disabled = true;

                    return;

                }


                this.setCustomValidity('');

                btnSubmit.disabled = false;

            }
        );


        /*
        |--------------------------------------------------------------------------
        | Jika ada old value / selected package
        |--------------------------------------------------------------------------
        */

        if (packageSelect.value) {

            packageSelect.dispatchEvent(
                new Event('change')
            );

        }

    </script>

    @endpush

</x-app-layout>