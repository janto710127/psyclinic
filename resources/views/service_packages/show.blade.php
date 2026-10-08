<x-app-layout>

    <div class="container-fluid">

        {{-- Header --}}
        <div class="d-flex justify-content-between align-items-center mb-3">

            <div>
                <h4 class="mb-1">
                    Detail Service Package
                </h4>

                <small class="text-muted">
                    Informasi lengkap service package
                </small>
            </div>

            <a href="{{ route('service_packages.index') }}"
               class="btn btn-secondary">

                <i class="fas fa-arrow-left"></i>
                Kembali

            </a>

        </div>


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

                        <label class="form-label text-muted">
                            Kode Package
                        </label>

                        <div class="fw-bold">
                            {{ $servicePackage->package_code }}
                        </div>

                    </div>


                    {{-- Nama --}}
                    <div class="col-md-6 mb-3">

                        <label class="form-label text-muted">
                            Nama Package
                        </label>

                        <div class="fw-bold">
                            {{ $servicePackage->package_name }}
                        </div>

                    </div>


                    {{-- Harga --}}
                    <div class="col-md-4 mb-3">

                        <label class="form-label text-muted">
                            Harga Package
                        </label>

                        <div class="fw-bold text-success">
                            {{ $servicePackage->price_label }}
                        </div>

                    </div>


                    {{-- Masa Berlaku --}}
                    <div class="col-md-4 mb-3">

                        <label class="form-label text-muted">
                            Masa Berlaku
                        </label>

                        <div>
                            {{ $servicePackage->validity_label }}
                        </div>

                    </div>


                    {{-- Status --}}
                    <div class="col-md-4 mb-3">

                        <label class="form-label text-muted">
                            Status
                        </label>

                        <div>

                            @if ($servicePackage->is_active)

                                <span class="badge bg-success">
                                    Aktif
                                </span>

                            @else

                                <span class="badge bg-secondary">
                                    Non Aktif
                                </span>

                            @endif

                        </div>

                    </div>


                    {{-- Catatan --}}
                    <div class="col-md-12 mb-3">

                        <label class="form-label text-muted">
                            Catatan
                        </label>

                        <div>

                            @if ($servicePackage->notes)

                                {{ $servicePackage->notes }}

                            @else

                                <span class="text-muted">
                                    Tidak ada catatan.
                                </span>

                            @endif

                        </div>

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

                    <table class="table table-hover table-striped align-middle">

                        <thead class="table-light">

                            <tr>

                                <th width="5%">
                                    No
                                </th>

                                <th>
                                    Kode Layanan
                                </th>

                                <th>
                                    Nama Layanan
                                </th>

                                <th class="text-center">
                                    Qty
                                </th>

                                <th class="text-end">
                                    Harga
                                </th>

                                <th class="text-end">
                                    Subtotal
                                </th>

                            </tr>

                        </thead>


                        <tbody>

                            @forelse ($servicePackage->details as $index => $detail)

                                <tr>

                                    <td>
                                        {{ $index + 1 }}
                                    </td>

                                    <td>
                                        {{ $detail->serviceRate->service_code }}
                                    </td>

                                    <td>
                                        {{ $detail->serviceRate->service_name }}
                                    </td>

                                    <td class="text-center">
                                        {{ $detail->quantity }}
                                    </td>

                                    <td class="text-end">
                                        {{ $detail->price_label }}
                                    </td>

                                    <td class="text-end">
                                        {{ $detail->subtotal_label }}
                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td colspan="6"
                                        class="text-center text-muted py-4">

                                        Belum ada layanan dalam package.

                                    </td>

                                </tr>

                            @endforelse

                        </tbody>


                        @if ($servicePackage->details->count() > 0)

                            <tfoot>

                                <tr>

                                    <th colspan="5"
                                        class="text-end">

                                        Total Nilai Layanan

                                    </th>

                                    <th class="text-end">

                                        Rp
                                        {{ number_format(
                                            $servicePackage->details->sum('subtotal'),
                                            0,
                                            ',',
                                            '.'
                                        ) }}

                                    </th>

                                </tr>

                                <tr>

                                    <th colspan="5"
                                        class="text-end">

                                        Harga Package

                                    </th>

                                    <th class="text-end text-success">

                                        {{ $servicePackage->price_label }}

                                    </th>

                                </tr>

                            </tfoot>

                        @endif

                    </table>

                </div>

            </div>

        </div>


        {{-- Action --}}
        <div class="card shadow-sm">

            <div class="card-footer text-end">

                <a href="{{ route('service_packages.index') }}"
                   class="btn btn-secondary">

                    <i class="fas fa-arrow-left"></i>
                    Kembali

                </a>

                <!-- <a href="{{ route('service_packages.edit', $servicePackage->id) }}"
                   class="btn btn-warning">

                    <i class="fas fa-edit"></i>
                    Edit
                </a> -->

                @if ($servicePackage->trashed())

                    <form
                        action="{{ route('service_packages.restore', $servicePackage->id) }}"
                        method="POST"
                        class="d-inline">

                        @csrf
                        @method('PATCH')

                        <button type="submit"
                                class="btn btn-success">

                            <i class="fas fa-undo"></i>
                            Restore

                        </button>

                    </form>

                @else

                    <a href="{{ route('service_packages.edit', $servicePackage->id) }}"
                    class="btn btn-warning">

                        <i class="fas fa-edit"></i>
                        Edit

                    </a>

                @endif

            </div>

        </div>

    </div>

</x-app-layout>