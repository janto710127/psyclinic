<x-app-layout>

    <div class="container-fluid">

        {{-- Header --}}
        <div class="d-flex justify-content-between align-items-center mb-3">

            <div>
                <h4 class="mb-1">Tambah Service Package</h4>

                <small class="text-muted">
                    Membuat paket layanan baru
                </small>
            </div>

            <a href="{{ route('service_packages.index') }}"
               class="btn btn-secondary">

                <i class="fas fa-arrow-left"></i>
                Kembali

            </a>

        </div>


        {{-- Form --}}
        <form method="POST"
              action="{{ route('service_packages.store') }}">

            @csrf

            <div class="card shadow-sm">

                <div class="card-header">

                    <strong>
                        Informasi Service Package
                    </strong>

                </div>


                <div class="card-body">

                    <div class="row">

                        {{-- Kode --}}
                        {{-- Ini Kode Paket Manual}}
                        <!-- <div class="col-md-6 mb-3">

                            <label for="package_code"
                                   class="form-label">

                                Kode Package
                                <span class="text-danger">*</span>

                            </label>

                            <input type="text"
                                   name="package_code"
                                   id="package_code"
                                   class="form-control @error('package_code') is-invalid @enderror"
                                   value="{{ old('package_code') }}"
                                   placeholder="Contoh: PKG0001">

                            @error('package_code')

                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>

                            @enderror

                        </div> -->

                    <label class="form-label">
                        Kode Package
                    </label>

                    <input type="text"
                        class="form-control"
                        value="Otomatis oleh sistem"
                        readonly>

                    <small class="text-muted">
                        Kode Package akan dibuat otomatis oleh sistem,
                        contoh: PKG0001, PKG0002, dan seterusnya.
                    </small>

                        {{-- Nama --}}
                        <div class="col-md-6 mb-3">

                            <label for="package_name"
                                   class="form-label">

                                Nama Package
                                <span class="text-danger">*</span>

                            </label>

                            <input type="text"
                                   name="package_name"
                                   id="package_name"
                                   class="form-control @error('package_name') is-invalid @enderror"
                                   value="{{ old('package_name') }}"
                                   placeholder="Contoh: Paket Psikologi Anak">

                            @error('package_name')

                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>

                            @enderror

                        </div>


                        {{-- Harga --}}
                        <div class="col-md-4 mb-3">

                            <label for="price"
                                   class="form-label">

                                Harga Package
                                <span class="text-danger">*</span>

                            </label>

                            <input type="number"
                                   name="price"
                                   id="price"
                                   class="form-control @error('price') is-invalid @enderror"
                                   value="{{ old('price') }}"
                                   min="0"
                                   step="0.01">

                            @error('price')

                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>

                            @enderror

                        </div>


                        {{-- Validity --}}
                        <div class="col-md-4 mb-3">

                            <label for="validity_days"
                                   class="form-label">

                                Masa Berlaku

                            </label>

                            <div class="input-group">

                                <input type="number"
                                       name="validity_days"
                                       id="validity_days"
                                       class="form-control @error('validity_days') is-invalid @enderror"
                                       value="{{ old('validity_days') }}"
                                       min="1">

                                <span class="input-group-text">
                                    Hari
                                </span>

                            </div>

                            @error('validity_days')

                                <div class="text-danger small mt-1">
                                    {{ $message }}
                                </div>

                            @enderror

                            <small class="text-muted">
                                Kosongkan jika tidak memiliki batas waktu.
                            </small>

                        </div>


                        {{-- Status --}}
                        <div class="col-md-4 mb-3">

                            <label for="is_active"
                                   class="form-label">

                                Status

                            </label>

                            <select name="is_active"
                                    id="is_active"
                                    class="form-select">

                                <option value="1"
                                    {{ old('is_active', 1) == 1 ? 'selected' : '' }}>

                                    Aktif

                                </option>

                                <option value="0"
                                    {{ old('is_active') === '0' ? 'selected' : '' }}>

                                    Non Aktif

                                </option>

                            </select>

                        </div>


                        {{-- Notes --}}
                        <div class="col-md-12 mb-3">

                            <label for="notes"
                                   class="form-label">

                                Catatan

                            </label>

                            <textarea name="notes"
                                      id="notes"
                                      rows="3"
                                      class="form-control"
                                      placeholder="Catatan package...">{{ old('notes') }}</textarea>

                        </div>

                        {{-- Detail Layanan --}}
                        <div class="card shadow-sm mb-3">
                            <div class="card-header">
                                <h5 class="mb-0">
                                    <i class="fas fa-list"></i>
                                    Detail Layanan Package
                                </h5>
                            </div>

                            <div class="card-body">

                                <div class="table-responsive">

                                    <table class="table table-bordered align-middle"
                                        id="package-detail-table">

                                        <thead class="table-light">
                                            <tr>
                                                <th width="35%">Layanan</th>
                                                <th width="12%">Qty</th>
                                                <th width="18%">Harga</th>
                                                <th width="20%">Subtotal</th>
                                                <th width="10%">Aksi</th>
                                            </tr>
                                        </thead>

                                        <tbody id="package-detail-body">

                                            {{-- Baris pertama --}}
                                            <tr class="package-detail-row">

                                                <td>
                                                    <select name="details[0][service_rate_id]"
                                                            class="form-select service-rate-select"
                                                            required>

                                                        <option value="">
                                                            -- Pilih Layanan --
                                                        </option>

                                                        @foreach ($serviceRates as $serviceRate)
                                                            <option
                                                                value="{{ $serviceRate->id }}"
                                                                data-price="{{ $serviceRate->price }}">

                                                                {{ $serviceRate->service_code }}
                                                                -
                                                                {{ $serviceRate->service_name }}

                                                            </option>
                                                        @endforeach

                                                    </select>
                                                </td>

                                                <td>
                                                    <input type="number"
                                                        name="details[0][quantity]"
                                                        class="form-control quantity"
                                                        value="1"
                                                        min="1"
                                                        required>
                                                </td>

                                                <td>
                                                    <input type="text"
                                                        class="form-control price-display"
                                                        value="Rp 0"
                                                        readonly>

                                                    <input type="hidden"
                                                        name="details[0][price]"
                                                        class="price">
                                                </td>

                                                <td>
                                                    <input type="text"
                                                        class="form-control subtotal-display"
                                                        value="Rp 0"
                                                        readonly>
                                                </td>

                                                <td class="text-center">

                                                    <button type="button"
                                                            class="btn btn-danger btn-sm remove-row">

                                                        <i class="fas fa-trash"></i>

                                                    </button>

                                                </td>

                                            </tr>

                                        </tbody>

                                    </table>

                                </div>

                                <button type="button"
                                        class="btn btn-primary btn-sm"
                                        id="add-detail">

                                    <i class="fas fa-plus"></i>
                                    Tambah Layanan

                                </button>

                                <hr>

                                <div class="row justify-content-end">

                                    <div class="col-md-4">

                                        <div class="d-flex justify-content-between">

                                            <strong>
                                                Total Nilai Layanan
                                            </strong>

                                            <strong id="grand-total">
                                                Rp 0
                                            </strong>

                                        </div>

                                    </div>

                                </div>

                            </div>
                        </div>

                    </div>

                </div>


                <div class="card-footer text-end">

                    <a href="{{ route('service_packages.index') }}"
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

        </form>

    </div>

@push('scripts')

<script>

let detailIndex = 1;

function formatRupiah(number)
{
    return 'Rp ' + Number(number).toLocaleString('id-ID');
}


function calculateRow(row)
{
    const select = row.querySelector('.service-rate-select');
    const quantity = row.querySelector('.quantity');
    const priceInput = row.querySelector('.price');
    const priceDisplay = row.querySelector('.price-display');
    const subtotalDisplay = row.querySelector('.subtotal-display');

    const selectedOption = select.options[select.selectedIndex];

    if (!selectedOption || selectedOption.value === '') {

        priceInput.value = 0;
        priceDisplay.value = 'Rp 0';
        subtotalDisplay.value = 'Rp 0';

        calculateGrandTotal();

        return;
    }

    // Ambil harga dari option yang dipilih
    const price = Number(
        selectedOption.getAttribute('data-price')
    );

    const qty = Number(quantity.value) || 1;

    const subtotal = price * qty;

    priceInput.value = price;

    priceDisplay.value = formatRupiah(price);

    subtotalDisplay.value = formatRupiah(subtotal);

    calculateGrandTotal();
}


function calculateGrandTotal()
{
    let total = 0;

    document
        .querySelectorAll('.package-detail-row')
        .forEach(function(row)
        {
            const select =
                row.querySelector('.service-rate-select');

            const quantity =
                row.querySelector('.quantity');

            const selectedOption =
                select.options[select.selectedIndex];

            if (
                !selectedOption ||
                selectedOption.value === ''
            ) {
                return;
            }

            const price = Number(
                selectedOption.getAttribute('data-price')
            );

            const qty =
                Number(quantity.value) || 1;

            total += price * qty;
        });

    document.getElementById('grand-total')
        .innerText = formatRupiah(total);
}


document.addEventListener('change', function(e)
{
    if (
        e.target.classList.contains(
            'service-rate-select'
        )
    ) {
        calculateRow(
            e.target.closest('.package-detail-row')
        );
    }
});


document.addEventListener('input', function(e)
{
    if (
        e.target.classList.contains('quantity')
    ) {
        calculateRow(
            e.target.closest('.package-detail-row')
        );
    }
});


document.getElementById('add-detail')
    .addEventListener('click', function()
    {

        const tbody =
            document.getElementById(
                'package-detail-body'
            );

        const row =
            document.createElement('tr');

        row.classList.add(
            'package-detail-row'
        );

        row.innerHTML = `

            <td>

                <select
                    name="details[${detailIndex}][service_rate_id]"
                    class="form-select service-rate-select"
                    required>

                    <option value="">
                        -- Pilih Layanan --
                    </option>

                    @foreach ($serviceRates as $serviceRate)

                        <option
                            value="{{ $serviceRate->id }}"
                            data-price="{{ $serviceRate->price }}">

                            {{ $serviceRate->service_code }}
                            -
                            {{ $serviceRate->service_name }}

                        </option>

                    @endforeach

                </select>

            </td>

            <td>

                <input
                    type="number"
                    name="details[${detailIndex}][quantity]"
                    class="form-control quantity"
                    value="1"
                    min="1"
                    required>

            </td>

            <td>

                <input
                    type="text"
                    class="form-control price-display"
                    value="Rp 0"
                    readonly>

                <input
                    type="hidden"
                    name="details[${detailIndex}][price]"
                    class="price">

            </td>

            <td>

                <input
                    type="text"
                    class="form-control subtotal-display"
                    value="Rp 0"
                    readonly>

            </td>

            <td class="text-center">

                <button
                    type="button"
                    class="btn btn-danger btn-sm remove-row">

                    <i class="fas fa-trash"></i>

                </button>

            </td>

        `;

        tbody.appendChild(row);

        detailIndex++;

    });


document.addEventListener('click', function(e)
{
    if (
        e.target.closest('.remove-row')
    ) {

        const rows =
            document.querySelectorAll(
                '.package-detail-row'
            );

        if (rows.length <= 1) {
            alert(
                'Minimal harus ada satu layanan.'
            );
            return;
        }

        e.target
            .closest('.package-detail-row')
            .remove();

        calculateGrandTotal();
    }
});


</script>

@endpush

</x-app-layout>

