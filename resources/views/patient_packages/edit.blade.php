<x-app-layout>

    <div class="container-fluid">

        {{-- =========================================================
             HEADER
        ========================================================== --}}
        <div class="d-flex justify-content-between align-items-center mb-3">

            <div>
                <h4 class="mb-1">
                    Edit Patient Package
                </h4>

                <small class="text-muted">
                    {{ $patientPackage->patient_package_no }}
                </small>
            </div>

            <div class="d-flex gap-2">

                <a href="{{ route('patient_packages.show', $patientPackage) }}"
                   class="btn btn-info">

                    <i class="fas fa-eye"></i>
                    Detail

                </a>

                <a href="{{ route('patient_packages.index') }}"
                   class="btn btn-secondary">

                    <i class="fas fa-arrow-left"></i>
                    Kembali

                </a>

            </div>

        </div>


        {{-- =========================================================
             ERROR
        ========================================================== --}}
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


        {{-- =========================================================
             FORM
        ========================================================== --}}
        <form method="POST"
              action="{{ route('patient_packages.update', $patientPackage) }}">

            @csrf
            @method('PUT')


            <div class="row">

                {{-- =================================================
                     FORM
                ================================================== --}}
                <div class="col-md-8">

                    <div class="card shadow-sm">

                        <div class="card-header">

                            <h6 class="mb-0">

                                <i class="fas fa-edit"></i>

                                Informasi Patient Package

                            </h6>

                        </div>


                        <div class="card-body">

                            <div class="row g-3">

                                {{-- Package Number --}}
                                <div class="col-md-6">

                                    <label class="form-label">
                                        No. Package
                                    </label>

                                    <input type="text"
                                           class="form-control"
                                           value="{{ $patientPackage->patient_package_no }}"
                                           readonly>

                                    <small class="text-muted">
                                        Nomor package tidak dapat diubah.
                                    </small>

                                </div>


                                {{-- Patient --}}
                                <div class="col-md-6">

                                    <label class="form-label">

                                        Pasien
                                        <span class="text-danger">*</span>

                                    </label>

                                    <select name="patient_id"
                                            class="form-select @error('patient_id') is-invalid @enderror"
                                            required>

                                        <option value="">
                                            -- Pilih Pasien --
                                        </option>

                                        @foreach($patients as $patient)

                                            <option value="{{ $patient->id }}"
                                                @selected(
                                                    old(
                                                        'patient_id',
                                                        $patientPackage->patient_id
                                                    ) == $patient->id
                                                )>

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


                                {{-- Service Package --}}
                                <div class="col-md-6">

                                    <label class="form-label">

                                        Service Package
                                        <span class="text-danger">*</span>

                                    </label>

                                    <select name="service_package_id"
                                            id="service_package_id"
                                            class="form-select @error('service_package_id') is-invalid @enderror"
                                            required>

                                        <option value="">
                                            -- Pilih Paket --
                                        </option>

                                        @foreach($servicePackages as $servicePackage)

                                            <option value="{{ $servicePackage->id }}"
                                                data-price="{{ $servicePackage->price }}"
                                                data-validity="{{ $servicePackage->validity_days }}"
                                                @selected(
                                                    old(
                                                        'service_package_id',
                                                        $patientPackage->service_package_id
                                                    ) == $servicePackage->id
                                                )>

                                                {{ $servicePackage->package_code }}
                                                -
                                                {{ $servicePackage->package_name }}

                                            </option>

                                        @endforeach

                                    </select>

                                    @error('service_package_id')

                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>

                                    @enderror

                                </div>


                                {{-- Price --}}
                                <div class="col-md-6">

                                    <label class="form-label">

                                        Harga Paket
                                        <span class="text-danger">*</span>

                                    </label>

                                    <div class="input-group">

                                        <span class="input-group-text">
                                            Rp
                                        </span>

                                        <input type="number"
                                               name="price"
                                               id="price"
                                               class="form-control @error('price') is-invalid @enderror"
                                               value="{{ old('price', $patientPackage->price) }}"
                                               min="0"
                                               step="0.01"
                                               required>

                                    </div>

                                    <small class="text-muted">
                                        Harga merupakan snapshot harga saat package dimiliki pasien.
                                    </small>

                                    @error('price')

                                        <div class="text-danger small">
                                            {{ $message }}
                                        </div>

                                    @enderror

                                </div>


                                {{-- Purchased --}}
                                <div class="col-md-6">

                                    <label class="form-label">

                                        Tanggal Pembelian
                                        <span class="text-danger">*</span>

                                    </label>

                                    <input type="date"
                                           name="purchased_at"
                                           id="purchased_at"
                                           class="form-control @error('purchased_at') is-invalid @enderror"
                                           value="{{ old(
                                               'purchased_at',
                                               $patientPackage->purchased_at?->format('Y-m-d')
                                           ) }}"
                                           required>

                                    @error('purchased_at')

                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>

                                    @enderror

                                </div>


                                {{-- Started --}}
                                <div class="col-md-6">

                                    <label class="form-label">
                                        Tanggal Mulai
                                    </label>

                                    <input type="date"
                                           name="started_at"
                                           id="started_at"
                                           class="form-control @error('started_at') is-invalid @enderror"
                                           value="{{ old(
                                               'started_at',
                                               $patientPackage->started_at?->format('Y-m-d')
                                           ) }}">

                                    @error('started_at')

                                        <div class="text-danger small">
                                            {{ $message }}
                                        </div>

                                    @enderror

                                </div>


                                {{-- Expired --}}
                                <div class="col-md-6">

                                    <label class="form-label">
                                        Berlaku Sampai
                                    </label>

                                    <input type="date"
                                           name="expired_at"
                                           id="expired_at"
                                           class="form-control @error('expired_at') is-invalid @enderror"
                                           value="{{ old(
                                               'expired_at',
                                               $patientPackage->expired_at?->format('Y-m-d')
                                           ) }}">

                                    <small class="text-muted">
                                        Dapat disesuaikan sesuai kondisi paket.
                                    </small>

                                    @error('expired_at')

                                        <div class="text-danger small">
                                            {{ $message }}
                                        </div>

                                    @enderror

                                </div>


                                {{-- Status --}}
                                <div class="col-md-6">

                                    <label class="form-label">

                                        Status
                                        <span class="text-danger">*</span>

                                    </label>

                                    <select name="status"
                                            class="form-select @error('status') is-invalid @enderror"
                                            required>

                                        <option value="{{ \App\Models\PatientPackage::STATUS_ACTIVE }}"
                                            @selected(
                                                old(
                                                    'status',
                                                    $patientPackage->status
                                                ) == \App\Models\PatientPackage::STATUS_ACTIVE
                                            )>

                                            Aktif

                                        </option>

                                        <option value="{{ \App\Models\PatientPackage::STATUS_COMPLETED }}"
                                            @selected(
                                                old(
                                                    'status',
                                                    $patientPackage->status
                                                ) == \App\Models\PatientPackage::STATUS_COMPLETED
                                            )>

                                            Selesai

                                        </option>

                                        <option value="{{ \App\Models\PatientPackage::STATUS_EXPIRED }}"
                                            @selected(
                                                old(
                                                    'status',
                                                    $patientPackage->status
                                                ) == \App\Models\PatientPackage::STATUS_EXPIRED
                                            )>

                                            Kadaluarsa

                                        </option>

                                        <option value="{{ \App\Models\PatientPackage::STATUS_CANCELLED }}"
                                            @selected(
                                                old(
                                                    'status',
                                                    $patientPackage->status
                                                ) == \App\Models\PatientPackage::STATUS_CANCELLED
                                            )>

                                            Dibatalkan

                                        </option>

                                    </select>

                                    @error('status')

                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>

                                    @enderror

                                </div>


                                {{-- Notes --}}
                                <div class="col-12">

                                    <label class="form-label">
                                        Catatan
                                    </label>

                                    <textarea name="notes"
                                              rows="3"
                                              class="form-control @error('notes') is-invalid @enderror"
                                              placeholder="Catatan tambahan...">{{ old('notes', $patientPackage->notes) }}</textarea>

                                    @error('notes')

                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>

                                    @enderror

                                </div>

                            </div>

                        </div>


                        <div class="card-footer">

                            <div class="d-flex justify-content-end gap-2">

                                <a href="{{ route('patient_packages.show', $patientPackage) }}"
                                   class="btn btn-secondary">

                                    Batal

                                </a>

                                <button type="submit"
                                        class="btn btn-success">

                                    <i class="fas fa-save"></i>
                                    Simpan Perubahan

                                </button>

                            </div>

                        </div>

                    </div>

                </div>


                {{-- =================================================
                     PACKAGE DETAIL
                ================================================== --}}
                <div class="col-md-4">

                    <div class="card shadow-sm">

                        <div class="card-header">

                            <h6 class="mb-0">

                                <i class="fas fa-list"></i>

                                Isi Paket

                            </h6>

                        </div>


                        <div class="card-body"
                             id="package-details">

                            <div class="text-center text-muted py-4">

                                Memuat detail paket...

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </form>

    </div>


    @push('scripts')

    <script>

        document.addEventListener('DOMContentLoaded', function () {

            const packageSelect =
                document.getElementById('service_package_id');

            const priceInput =
                document.getElementById('price');

            const detailsContainer =
                document.getElementById('package-details');


            /*
            |--------------------------------------------------------------------------
            | Package Data
            |--------------------------------------------------------------------------
            */

            const servicePackages =
                {{ Illuminate\Support\Js::from($servicePackages->map(function ($package) {

                    return [
                        'id' => $package->id,
                        'price' => $package->price,
                        'validity_days' => $package->validity_days,

                        'details' => $package->details->map(function ($detail) {

                            return [
                                'service_name' =>
                                    $detail->serviceRate->service_name,

                                'quantity' =>
                                    $detail->quantity,

                                'price' =>
                                    $detail->price,
                            ];

                        })->values(),
                    ];

                })->values()) }};


            /*
            |--------------------------------------------------------------------------
            | Format Rupiah
            |--------------------------------------------------------------------------
            */

            function formatRupiah(value)
            {
                return new Intl.NumberFormat(
                    'id-ID'
                ).format(value);
            }


            /*
            |--------------------------------------------------------------------------
            | Display Details
            |--------------------------------------------------------------------------
            */

            function displayPackageDetails(packageData)
            {
                if (!packageData) {

                    detailsContainer.innerHTML = `
                        <div class="text-center text-muted py-4">

                            <i class="fas fa-box-open fa-2x mb-2"></i>

                            <div>
                                Pilih Service Package.
                            </div>

                        </div>
                    `;

                    return;
                }


                if (
                    !packageData.details ||
                    packageData.details.length === 0
                ) {

                    detailsContainer.innerHTML = `
                        <div class="alert alert-warning mb-0">

                            Paket belum memiliki detail layanan.

                        </div>
                    `;

                    return;
                }


                let html = `

                    <div class="table-responsive">

                        <table class="table table-sm table-bordered">

                            <thead class="table-light">

                                <tr>

                                    <th>
                                        Layanan
                                    </th>

                                    <th width="60"
                                        class="text-center">

                                        Qty

                                    </th>

                                    <th class="text-end">

                                        Harga

                                    </th>

                                </tr>

                            </thead>

                            <tbody>

                `;


                packageData.details.forEach(function (detail) {

                    html += `

                        <tr>

                            <td>
                                ${detail.service_name}
                            </td>

                            <td class="text-center">
                                ${detail.quantity}x
                            </td>

                            <td class="text-end">
                                Rp ${formatRupiah(detail.price)}
                            </td>

                        </tr>

                    `;

                });


                html += `

                            </tbody>

                        </table>

                    </div>

                `;


                detailsContainer.innerHTML = html;
            }


            /*
            |--------------------------------------------------------------------------
            | Package Changed
            |--------------------------------------------------------------------------
            */

            packageSelect.addEventListener(
                'change',
                function () {

                    const selectedId =
                        parseInt(this.value);


                    if (!selectedId) {

                        priceInput.value = '';

                        displayPackageDetails(null);

                        return;
                    }


                    const packageData =
                        servicePackages.find(
                            function (item) {

                                return item.id === selectedId;

                            }
                        );


                    if (!packageData) {
                        return;
                    }


                    /*
                    |--------------------------------------------------------------------------
                    | Harga Paket
                    |--------------------------------------------------------------------------
                    */

                    priceInput.value =
                        packageData.price;


                    /*
                    |--------------------------------------------------------------------------
                    | Detail Paket
                    |--------------------------------------------------------------------------
                    */

                    displayPackageDetails(
                        packageData
                    );

                }
            );


            /*
            |--------------------------------------------------------------------------
            | Initial Display
            |--------------------------------------------------------------------------
            */

            packageSelect.dispatchEvent(
                new Event('change')
            );

        });

    </script>

    @endpush

</x-app-layout>