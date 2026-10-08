<x-app-layout>

    <div class="container-fluid">

        {{-- Header --}}
        <div class="d-flex justify-content-between align-items-center mb-3">

            <div>
                <h4 class="mb-1">
                    Pemakaian Paket Pasien
                </h4>

                <small class="text-muted">
                    Daftar penggunaan layanan dari Patient Package
                </small>
            </div>

            <a href="{{ route('patient_package_usages.create') }}"
               class="btn btn-primary">

                <i class="bi bi-plus-circle"></i>
                Catat Pemakaian
            </a>

        </div>


        {{-- Flash Message --}}
        @if(session('success'))

            <div class="alert alert-success alert-dismissible fade show">

                {{ session('success') }}

                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="alert">
                </button>

            </div>

        @endif


        {{-- Search & Filter --}}
        <div class="card shadow-sm mb-3">

            <div class="card-header">

                <strong>
                    Pencarian & Filter
                </strong>

            </div>

            <div class="card-body">

                <form method="GET"
                      action="{{ route('patient_package_usages.index') }}">

                    <div class="row g-3">

                        {{-- Search --}}
                        <div class="col-md-6">

                            <label class="form-label">
                                Cari
                            </label>

                            <input type="text"
                                   name="search"
                                   class="form-control"
                                   value="{{ request('search') }}"
                                   placeholder="No Paket / Pasien / Layanan / No Appointment">

                        </div>


                        {{-- Used At --}}
                        <div class="col-md-4">

                            <label class="form-label">
                                Tanggal Pemakaian
                            </label>

                            <input type="date"
                                   name="used_at"
                                   class="form-control"
                                   value="{{ request('used_at') }}">

                        </div>


                        {{-- Button --}}
                        <div class="col-md-2 d-flex align-items-end">

                            <div class="d-flex gap-2 w-100">

                                <button type="submit"
                                        class="btn btn-primary w-100">

                                    <i class="bi bi-search"></i>
                                    Cari

                                </button>

                                <a href="{{ route('patient_package_usages.index') }}"
                                   class="btn btn-secondary">
                                    Reset
                                    <i class="bi bi-arrow-clockwise"></i>

                                </a>

                            </div>

                        </div>

                    </div>

                </form>

            </div>

        </div>


        {{-- Summary --}}
        <div class="row mb-3">

            <div class="col-md-4">

                <div class="card shadow-sm">

                    <div class="card-body">

                        <div class="text-muted">
                            Total Pemakaian
                        </div>

                        <h4 class="mb-0">
                            {{ $usages->total() }}
                        </h4>

                    </div>

                </div>

            </div>


            <div class="col-md-4">

                <div class="card shadow-sm">

                    <div class="card-body">

                        <div class="text-muted">
                            Pemakaian Ditampilkan
                        </div>

                        <h4 class="mb-0">
                            {{ $usages->count() }}
                        </h4>

                    </div>

                </div>

            </div>


            <div class="col-md-4">

                <div class="card shadow-sm">

                    <div class="card-body">

                        <div class="text-muted">
                            Quantity Digunakan
                        </div>

                        <h4 class="mb-0">

                            {{ $usages->sum('quantity') }}

                        </h4>

                    </div>

                </div>

            </div>

        </div>


        {{-- Table --}}
        <div class="card shadow-sm">

            <div class="card-header">

                <strong>
                    Riwayat Pemakaian Paket
                </strong>

            </div>

            <div class="card-body p-0">

                <div class="table-responsive">

                    <table class="table table-hover table-striped align-middle mb-0">

                        <thead class="table-light">

                            <tr>

                                <th width="60">
                                    No
                                </th>

                                <th>
                                    Tanggal
                                </th>

                                <th>
                                    No Paket
                                </th>

                                <th>
                                    Pasien
                                </th>

                                <th>
                                    Layanan
                                </th>

                                <th class="text-center">
                                    Qty
                                </th>

                                <th>
                                    Appointment
                                </th>

                                <th>
                                    Harga
                                </th>

                                <th width="100">
                                    Aksi
                                </th>

                            </tr>

                        </thead>

                        <tbody>

                            @forelse($usages as $usage)

                                <tr>

                                    {{-- Nomor --}}
                                    <td>

                                        {{ $usages->firstItem() + $loop->index }}

                                    </td>


                                    {{-- Tanggal --}}
                                    <td>

                                        {{ $usage->used_at?->format('d-m-Y') }}

                                    </td>


                                    {{-- Patient Package --}}
                                    <td>

                                        <strong>
                                            {{ $usage->patientPackage->patient_package_no }}
                                        </strong>

                                    </td>


                                    {{-- Patient --}}
                                    <td>

                                        {{ $usage->patientPackage->patient->name }}

                                    </td>


                                    {{-- Service --}}
                                    <td>

                                        {{ $usage->servicePackageDetail->serviceRate->service_name }}

                                    </td>


                                    {{-- Quantity --}}
                                    <td class="text-center">

                                        <span class="badge bg-primary">

                                            {{ $usage->quantity }}

                                        </span>

                                    </td>


                                    {{-- Appointment --}}
                                    <td>

                                        @if($usage->appointment)

                                            <a href="{{ route(
                                                'appointments.show',
                                                $usage->appointment
                                            ) }}">

                                                {{ $usage->appointment->appointment_no }}

                                            </a>

                                        @else

                                            <span class="text-muted">
                                                -
                                            </span>

                                        @endif

                                    </td>


                                    {{-- Price --}}
                                    <td>

                                        {{ $usage->price_label }}

                                    </td>


                                    {{-- Action --}}
                                    <td>

                                        <a href="{{ route(
                                            'patient_package_usages.show',
                                            $usage
                                        ) }}"
                                           class="btn btn-sm btn-info">

                                            Detail

                                        </a>

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td colspan="9"
                                        class="text-center py-4">

                                        <div class="text-muted">

                                            Belum ada pemakaian paket.

                                        </div>

                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>


            {{-- Pagination --}}
            @if($usages->hasPages())

                <div class="card-footer">

                    {{ $usages->links() }}

                </div>

            @endif

        </div>

    </div>

</x-app-layout>