<x-app-layout>

    <div class="container-fluid">

        {{-- Header --}}
        <div class="d-flex justify-content-between align-items-center mb-3">

            <div>
                <h4 class="mb-1">
                    Edit Service Package
                </h4>

                <small class="text-muted">
                    Mengubah informasi service package
                </small>
            </div>

            <a href="{{ route('service_packages.show', $servicePackage->id) }}"
               class="btn btn-secondary">

                <i class="fas fa-arrow-left"></i>
                Kembali

            </a>

        </div>


        {{-- Form --}}
        <form method="POST"
              action="{{ route('service_packages.update', $servicePackage->id) }}">

            @csrf
            @method('PUT')


            {{-- Informasi Package --}}
            <div class="card shadow-sm mb-3">

                <div class="card-header">

                    <strong>
                        <i class="fas fa-box"></i>
                        Informasi Service Package
                    </strong>

                </div>


                <div class="card-body">

                    <div class="row">

                        {{-- Kode --}}
                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Kode Package
                            </label>

                            <input type="text"
                                   class="form-control"
                                   value="{{ $servicePackage->package_code }}"
                                   readonly>

                        </div>


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
                                   value="{{ old('package_name', $servicePackage->package_name) }}">

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
                                   value="{{ old('price', $servicePackage->price) }}"
                                   min="0"
                                   step="0.01">

                            @error('price')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>


                        {{-- Masa Berlaku --}}
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
                                       value="{{ old('validity_days', $servicePackage->validity_days) }}"
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
                                    {{ old('is_active', $servicePackage->is_active) == 1 ? 'selected' : '' }}>

                                    Aktif

                                </option>

                                <option value="0"
                                    {{ old('is_active', $servicePackage->is_active) == 0 ? 'selected' : '' }}>

                                    Non Aktif

                                </option>

                            </select>

                        </div>


                        {{-- Catatan --}}
                        <div class="col-md-12 mb-3">

                            <label for="notes"
                                   class="form-label">

                                Catatan

                            </label>

                            <textarea name="notes"
                                      id="notes"
                                      rows="3"
                                      class="form-control">{{ old('notes', $servicePackage->notes) }}</textarea>

                        </div>

                    </div>

                </div>

            </div>


            {{-- Detail Layanan --}}
            <div class="card shadow-sm mb-3">

                <div class="card-header">

                    <strong>
                        <i class="fas fa-list"></i>
                        Detail Layanan Package
                    </strong>

                </div>


                <div class="card-body">

                    <div class="table-responsive">

                        <table class="table table-bordered align-middle">

                            <thead class="table-light">

                                <tr>

                                    <th width="35%">
                                        Layanan
                                    </th>

                                    <th width="12%">
                                        Qty
                                    </th>

                                    <th width="18%">
                                        Harga
                                    </th>

                                    <th width="20%">
                                        Subtotal
                                    </th>

                                    <th width="10%">
                                        Aksi
                                    </th>

                                </tr>

                            </thead>


                            <tbody id="package-detail-body">

                                @foreach ($servicePackage->details as $index => $detail)

                                    <tr class="package-detail-row">

                                        <td>

                                            <select
                                                name="details[{{ $index }}][service_rate_id]"
                                                class="form-select service-rate-select"
                                                required>

                                                <option value="">
                                                    -- Pilih Layanan --
                                                </option>

                                                @foreach ($serviceRates as $serviceRate)

                                                    <option
                                                        value="{{ $serviceRate->id }}"
                                                        data-price="{{ $serviceRate->price }}"
                                                        {{ $detail->service_rate_id == $serviceRate->id ? 'selected' : '' }}>

                                                        {{ $serviceRate->service_code }}
                                                        -
                                                        {{ $serviceRate->service_name }}

                                                    </option>

                                                @endforeach

                                            </select>

                                        </td>


                                        <td>

                                            <input type="number"
                                                   name="details[{{ $index }}][quantity]"
                                                   class="form-control quantity"
                                                   value="{{ $detail->quantity }}"
                                                   min="1"
                                                   required>

                                        </td>


                                        <td>

                                            <input type="text"
                                                   class="form-control price-display"
                                                   value="{{ $detail->price_label }}"
                                                   readonly>

                                            <input type="hidden"
                                                   name="details[{{ $index }}][price]"
                                                   class="price"
                                                   value="{{ $detail->price }}">

                                        </td>


                                        <td>

                                            <input type="text"
                                                   class="form-control subtotal-display"
                                                   value="{{ $detail->subtotal_label }}"
                                                   readonly>

                                        </td>


                                        <td class="text-center">

                                            <button type="button"
                                                    class="btn btn-danger btn-sm remove-row">

                                                <i class="fas fa-trash"></i>

                                            </button>

                                        </td>

                                    </tr>

                                @endforeach

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


            {{-- Footer --}}
            <div class="card shadow-sm">

                <div class="card-footer text-end">

                    <a href="{{ route('service_packages.show', $servicePackage->id) }}"
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

        </form>

    </div>


    @push('scripts')

    <script>

        let detailIndex = {{ $servicePackage->details->count() }};


        function formatRupiah(number)
        {
            return 'Rp ' +
                Number(number).toLocaleString('id-ID');
        }


        function calculateRow(row)
        {
            const select =
                row.querySelector('.service-rate-select');

            const quantity =
                row.querySelector('.quantity');

            const priceInput =
                row.querySelector('.price');

            const priceDisplay =
                row.querySelector('.price-display');

            const subtotalDisplay =
                row.querySelector('.subtotal-display');


            const selectedOption =
                select.options[select.selectedIndex];


            if (
                !selectedOption ||
                selectedOption.value === ''
            ) {

                priceInput.value = 0;

                priceDisplay.value = 'Rp 0';

                subtotalDisplay.value = 'Rp 0';

                calculateGrandTotal();

                return;
            }


            const price = Number(
                selectedOption.getAttribute('data-price')
            );


            const qty =
                Number(quantity.value) || 1;


            const subtotal =
                price * qty;


            priceInput.value = price;

            priceDisplay.value =
                formatRupiah(price);

            subtotalDisplay.value =
                formatRupiah(subtotal);


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
                .innerText =
                formatRupiah(total);
        }


        document.addEventListener('change', function(e)
        {

            if (
                e.target.classList.contains(
                    'service-rate-select'
                )
            ) {

                calculateRow(
                    e.target.closest(
                        '.package-detail-row'
                    )
                );

            }

        });


        document.addEventListener('input', function(e)
        {

            if (
                e.target.classList.contains('quantity')
            ) {

                calculateRow(
                    e.target.closest(
                        '.package-detail-row'
                    )
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


        // Hitung total saat halaman pertama kali dibuka
        document.querySelectorAll('.package-detail-row')
            .forEach(function(row)
            {
                calculateRow(row);
            });

    </script>

    @endpush

</x-app-layout>