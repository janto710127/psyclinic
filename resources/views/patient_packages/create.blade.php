<x-app-layout>

    <div class="container-fluid">

        {{-- =========================================================
             HEADER
        ========================================================== --}}
        <div class="d-flex justify-content-between align-items-center mb-3">

            <div>
                <h4 class="mb-1">
                    Tambah Patient Package
                </h4>

                <small class="text-muted">
                    Mendaftarkan paket layanan untuk pasien
                </small>
            </div>

            <a href="{{ route('patient_packages.index') }}"
               class="btn btn-secondary">

                <i class="fas fa-arrow-left"></i>
                Kembali

            </a>

        </div>


        {{-- =========================================================
             VALIDATION ERROR
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
              action="{{ route('patient_packages.store') }}">

            @csrf

            <div class="row">

                {{-- =================================================
                     LEFT COLUMN
                ================================================== --}}
                <div class="col-md-8">

                    <div class="card shadow-sm mb-3">

                        <div class="card-header">

                            <h6 class="mb-0">
                                <i class="fas fa-box"></i>
                                Informasi Patient Package
                            </h6>

                        </div>


                        <div class="card-body">

                            <div class="row g-3">

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
                                                @selected(old('patient_id') == $patient->id)>

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
                                                @selected(old('service_package_id') == $servicePackage->id)>

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
                                               value="{{ old('price') }}"
                                               min="0"
                                               step="0.01"
                                               required>

                                    </div>

                                    <small class="text-muted">
                                        Harga disimpan sebagai snapshot saat paket dibeli.
                                    </small>

                                    @error('price')

                                        <div class="text-danger small">
                                            {{ $message }}
                                        </div>

                                    @enderror

                                </div>


                                {{-- Purchased At --}}
                                <div class="col-md-6">

                                    <label class="form-label">
                                        Tanggal Pembelian
                                        <span class="text-danger">*</span>
                                    </label>

                                    <input type="date"
                                           name="purchased_at"
                                           id="purchased_at"
                                           class="form-control @error('purchased_at') is-invalid @enderror"
                                           value="{{ old('purchased_at', date('Y-m-d')) }}"
                                           required>

                                    @error('purchased_at')

                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>

                                    @enderror

                                </div>


                                {{-- Started At --}}
                                <div class="col-md-6">

                                    <label class="form-label">
                                        Tanggal Mulai
                                    </label>

                                    <input type="date"
                                           name="started_at"
                                           id="started_at"
                                           class="form-control @error('started_at') is-invalid @enderror"
                                           value="{{ old('started_at') }}">

                                    <small class="text-muted">
                                        Kosongkan jika paket belum mulai digunakan.
                                    </small>

                                    @error('started_at')

                                        <div class="text-danger small">
                                            {{ $message }}
                                        </div>

                                    @enderror

                                </div>


                                {{-- Expired At --}}
                                <div class="col-md-6">

                                    <label class="form-label">
                                        Berlaku Sampai
                                    </label>

                                    <input type="date"
                                           name="expired_at"
                                           id="expired_at"
                                           class="form-control @error('expired_at') is-invalid @enderror"
                                           value="{{ old('expired_at') }}">

                                    <small class="text-muted">
                                        Otomatis berdasarkan masa berlaku paket.
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
                                            @selected(old('status', \App\Models\PatientPackage::STATUS_ACTIVE) == \App\Models\PatientPackage::STATUS_ACTIVE)>
                                            Aktif
                                        </option>

                                        <option value="{{ \App\Models\PatientPackage::STATUS_COMPLETED }}"
                                            @selected(old('status') == \App\Models\PatientPackage::STATUS_COMPLETED)>
                                            Selesai
                                        </option>

                                        <option value="{{ \App\Models\PatientPackage::STATUS_EXPIRED }}"
                                            @selected(old('status') == \App\Models\PatientPackage::STATUS_EXPIRED)>
                                            Kadaluarsa
                                        </option>

                                        <option value="{{ \App\Models\PatientPackage::STATUS_CANCELLED }}"
                                            @selected(old('status') == \App\Models\PatientPackage::STATUS_CANCELLED)>
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
                                              placeholder="Catatan tambahan...">{{ old('notes') }}</textarea>

                                    @error('notes')

                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>

                                    @enderror

                                </div>

                            </div>

                        </div>


                        {{-- Footer --}}
                        <div class="card-footer">

                            <div class="d-flex justify-content-end gap-2">

                                <a href="{{ route('patient_packages.index') }}"
                                   class="btn btn-secondary">

                                    Batal

                                </a>

                                <button type="submit"
                                        class="btn btn-success">

                                    <i class="fas fa-save"></i>
                                    Simpan

                                </button>

                            </div>

                        </div>

                    </div>

                </div>


                {{-- =================================================
                     RIGHT COLUMN
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

                                <i class="fas fa-box-open fa-2x mb-2"></i>

                                <div>
                                    Pilih Service Package untuk melihat
                                    isi paket.
                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </form>

    </div>


    {{-- =============================================================
         JAVASCRIPT
    ============================================================== --}}
    @push('scripts')

    <script>

        document.addEventListener('DOMContentLoaded', function () {

            const packageSelect =
                document.getElementById('service_package_id');

            const priceInput =
                document.getElementById('price');

            const startedInput =
                document.getElementById('started_at');

            const expiredInput =
                document.getElementById('expired_at');

            const purchasedInput =
                document.getElementById('purchased_at');

            const detailsContainer =
                document.getElementById('package-details');


            /*
            |--------------------------------------------------------------------------
            | Service Package Data
            |--------------------------------------------------------------------------
            */
            const servicePackages = {{ Illuminate\Support\Js::from($packageData) }};

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
            | Add Days
            |--------------------------------------------------------------------------
            */

            function addDays(dateString, days)
            {
                const date =
                    new Date(dateString + 'T00:00:00');

                date.setDate(
                    date.getDate() + parseInt(days)
                );

                const year =
                    date.getFullYear();

                const month =
                    String(
                        date.getMonth() + 1
                    ).padStart(2, '0');

                const day =
                    String(
                        date.getDate()
                    ).padStart(2, '0');

                return `${year}-${month}-${day}`;
            }


            /*
            |--------------------------------------------------------------------------
            | Display Package Details
            |--------------------------------------------------------------------------
            */

            function displayPackageDetails(packageData)
            {
                if (!packageData) {

                    detailsContainer.innerHTML = `
                        <div class="text-center text-muted py-4">

                            <i class="fas fa-box-open fa-2x mb-2"></i>

                            <div>
                                Pilih Service Package untuk melihat
                                isi paket.
                            </div>

                        </div>
                    `;

                    return;
                }


                let html = '';


                if (
                    !packageData.details ||
                    packageData.details.length === 0
                ) {

                    html = `
                        <div class="alert alert-warning mb-0">

                            <i class="fas fa-exclamation-triangle"></i>

                            Paket ini belum memiliki detail layanan.

                        </div>
                    `;

                    detailsContainer.innerHTML = html;

                    return;
                }


                html += `
                    <div class="mb-3">

                        <strong>
                            Layanan dalam paket
                        </strong>

                    </div>

                    <div class="table-responsive">

                        <table class="table table-sm table-bordered align-middle">

                            <thead class="table-light">

                                <tr>

                                    <th>
                                        Layanan
                                    </th>

                                    <th width="70"
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

                        expiredInput.value = '';

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
                    | Set Price
                    |--------------------------------------------------------------------------
                    */

                    priceInput.value =
                        packageData.price;


                    /*
                    |--------------------------------------------------------------------------
                    | Display Details
                    |--------------------------------------------------------------------------
                    */

                    displayPackageDetails(
                        packageData
                    );


                    /*
                    |--------------------------------------------------------------------------
                    | Calculate Expired Date
                    |--------------------------------------------------------------------------
                    */

                    if (
                        purchasedInput.value &&
                        packageData.validity_days
                    ) {

                        expiredInput.value =
                            addDays(
                                purchasedInput.value,
                                packageData.validity_days
                            );

                    }

                }
            );


            /*
            |--------------------------------------------------------------------------
            | Purchased Date Changed
            |--------------------------------------------------------------------------
            */

            purchasedInput.addEventListener(
                'change',
                function () {

                    const selectedId =
                        parseInt(
                            packageSelect.value
                        );

                    if (!selectedId) {
                        return;
                    }


                    const packageData =
                        servicePackages.find(
                            function (item) {

                                return item.id === selectedId;

                            }
                        );


                    if (
                        packageData &&
                        packageData.validity_days
                    ) {

                        expiredInput.value =
                            addDays(
                                this.value,
                                packageData.validity_days
                            );

                    }

                }
            );


            /*
            |--------------------------------------------------------------------------
            | Initial Load
            |--------------------------------------------------------------------------
            */

            if (packageSelect.value) {

                packageSelect.dispatchEvent(
                    new Event('change')
                );

            }

        });

    </script>

    @endpush

</x-app-layout>