<x-app-layout>

    <div class="container-fluid">

        {{-- =========================================================
             HEADER
        ========================================================== --}}
        <div class="d-flex justify-content-between align-items-center mb-3">

            <div>
                <h4 class="mb-1">
                    Patient Package
                </h4>

                <small class="text-muted">
                    Daftar paket layanan yang dimiliki pasien
                </small>
            </div>

            <div class="d-flex gap-2">

                <a href="{{ route('patient_packages.archived') }}"
                   class="btn btn-secondary">
                    <i class="fas fa-archive"></i>
                    Arsip
                </a>

                <a href="{{ route('patient_packages.create') }}"
                   class="btn btn-primary">
                    <i class="fas fa-plus"></i>
                    Tambah Patient Package
                </a>

            </div>

        </div>


        {{-- =========================================================
             FLASH MESSAGE
        ========================================================== --}}
        @if(session('success'))

            <div class="alert alert-success alert-dismissible fade show"
                 role="alert">

                <i class="fas fa-check-circle"></i>
                {{ session('success') }}

                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="alert">
                </button>

            </div>

        @endif


        {{-- =========================================================
             SEARCH & FILTER
        ========================================================== --}}
        <div class="card shadow-sm mb-3">

            <div class="card-header">

                <h6 class="mb-0">
                    <i class="fas fa-search"></i>
                    Pencarian & Filter
                </h6>

            </div>

            <div class="card-body">

                <form method="GET"
                      action="{{ route('patient_packages.index') }}">

                    <div class="row g-3">

                        {{-- Search --}}
                        <div class="col-md-5">

                            <label class="form-label">
                                Cari
                            </label>

                            <input type="text"
                                   name="search"
                                   class="form-control"
                                   value="{{ request('search') }}"
                                   placeholder="No. package, nama pasien, atau nama paket">

                        </div>


                        {{-- Status --}}
                        <div class="col-md-3">

                            <label class="form-label">
                                Status
                            </label>

                            <select name="status"
                                    class="form-select">

                                <option value="">
                                    Semua Status
                                </option>

                                <option value="{{ \App\Models\PatientPackage::STATUS_ACTIVE }}"
                                    @selected(request('status') == \App\Models\PatientPackage::STATUS_ACTIVE)>
                                    Aktif
                                </option>

                                <option value="{{ \App\Models\PatientPackage::STATUS_COMPLETED }}"
                                    @selected(request('status') == \App\Models\PatientPackage::STATUS_COMPLETED)>
                                    Selesai
                                </option>

                                <option value="{{ \App\Models\PatientPackage::STATUS_EXPIRED }}"
                                    @selected(request('status') == \App\Models\PatientPackage::STATUS_EXPIRED)>
                                    Kadaluarsa
                                </option>

                                <option value="{{ \App\Models\PatientPackage::STATUS_CANCELLED }}"
                                    @selected(request('status') == \App\Models\PatientPackage::STATUS_CANCELLED)>
                                    Dibatalkan
                                </option>

                            </select>

                        </div>


                        {{-- Purchased Date --}}
                        <div class="col-md-2">

                            <label class="form-label">
                                Tanggal Pembelian
                            </label>

                            <input type="date"
                                   name="purchased_at"
                                   class="form-control"
                                   value="{{ request('purchased_at') }}">

                        </div>


                        {{-- Buttons --}}
                        <div class="col-md-2 d-flex align-items-end">

                            <div class="d-flex gap-2 w-100">

                                <button type="submit"
                                        class="btn btn-primary flex-fill">

                                    <i class="fas fa-search"></i>
                                    Cari

                                </button>

                                <a href="{{ route('patient_packages.index') }}"
                                   class="btn btn-secondary">
Reset
                                    <i class="fas fa-sync-alt"></i>

                                </a>

                            </div>

                        </div>

                    </div>

                </form>

            </div>

        </div>


        {{-- =========================================================
             SUMMARY
        ========================================================== --}}
        <div class="row mb-3">

            {{-- Total --}}
            <div class="col-md-2">

                <div class="card shadow-sm">

                    <div class="card-body">

                        <div class="text-muted small">
                            Total
                        </div>

                        <h4 class="mb-0">
                            {{ $summary['total'] }}
                        </h4>

                    </div>

                </div>

            </div>


            {{-- Active --}}
            <div class="col-md-2">

                <div class="card shadow-sm">

                    <div class="card-body">

                        <div class="text-muted small">
                            Aktif
                        </div>

                        <h4 class="mb-0 text-success">
                            {{ $summary['active'] }}
                        </h4>

                    </div>

                </div>

            </div>


            {{-- Completed --}}
            <div class="col-md-2">

                <div class="card shadow-sm">

                    <div class="card-body">

                        <div class="text-muted small">
                            Selesai
                        </div>

                        <h4 class="mb-0 text-primary">
                            {{ $summary['completed'] }}
                        </h4>

                    </div>

                </div>

            </div>


            {{-- Expired --}}
            <div class="col-md-2">

                <div class="card shadow-sm">

                    <div class="card-body">

                        <div class="text-muted small">
                            Kadaluarsa
                        </div>

                        <h4 class="mb-0 text-secondary">
                            {{ $summary['expired'] }}
                        </h4>

                    </div>

                </div>

            </div>


            {{-- Cancelled --}}
            <div class="col-md-2">

                <div class="card shadow-sm">

                    <div class="card-body">

                        <div class="text-muted small">
                            Dibatalkan
                        </div>

                        <h4 class="mb-0 text-danger">
                            {{ $summary['cancelled'] }}
                        </h4>

                    </div>

                </div>

            </div>

        </div>


        {{-- =========================================================
             TABLE
        ========================================================== --}}
        <div class="card shadow-sm">

            <div class="card-header">

                <div class="d-flex justify-content-between align-items-center">

                    <h6 class="mb-0">
                        Daftar Patient Package
                    </h6>

                    <span class="text-muted small">
                        Menampilkan {{ $patientPackages->firstItem() ?? 0 }}
                        -
                        {{ $patientPackages->lastItem() ?? 0 }}
                        dari {{ $patientPackages->total() }}
                    </span>

                </div>

            </div>


            <div class="card-body p-0">

                <div class="table-responsive">

                    <table class="table table-hover table-striped align-middle mb-0">

                        <thead class="table-light">

                            <tr>

                                <th width="60">
                                    #
                                </th>

                                <th>
                                    No. Package
                                </th>

                                <th>
                                    Pasien
                                </th>

                                <th>
                                    Paket
                                </th>

                                <th>
                                    Harga
                                </th>

                                <th>
                                    Pembelian
                                </th>

                                <th>
                                    Berlaku Sampai
                                </th>

                                <th>
                                    Status
                                </th>

                                <th width="150">
                                    Aksi
                                </th>

                            </tr>

                        </thead>


                        <tbody>

                            @forelse($patientPackages as $index => $patientPackage)

                                <tr>

                                    {{-- No --}}
                                    <td>
                                        {{ $patientPackages->firstItem() + $index }}
                                    </td>


                                    {{-- Package Number --}}
                                    <td>

                                        <strong>
                                            {{ $patientPackage->patient_package_no }}
                                        </strong>

                                    </td>


                                    {{-- Patient --}}
                                    <td>

                                        @if($patientPackage->patient)

                                            {{ $patientPackage->patient->name }}

                                        @else

                                            <span class="text-muted">
                                                -
                                            </span>

                                        @endif

                                    </td>


                                    {{-- Service Package --}}
                                    <td>

                                        @if($patientPackage->servicePackage)

                                            <div>
                                                <strong>
                                                    {{ $patientPackage->servicePackage->package_name }}
                                                </strong>
                                            </div>

                                            <small class="text-muted">
                                                {{ $patientPackage->servicePackage->package_code }}
                                            </small>

                                        @else

                                            <span class="text-muted">
                                                -
                                            </span>

                                        @endif

                                    </td>


                                    {{-- Price --}}
                                    <td>

                                        {{ $patientPackage->price_label }}

                                    </td>


                                    {{-- Purchased --}}
                                    <td>

                                        {{ $patientPackage->purchased_at?->format('d-m-Y') }}

                                    </td>


                                    {{-- Expired --}}
                                    <td>

                                        @if($patientPackage->expired_at)

                                            {{ $patientPackage->expired_at->format('d-m-Y') }}

                                        @else

                                            <span class="text-muted">
                                                Tidak terbatas
                                            </span>

                                        @endif

                                    </td>


                                    {{-- Status --}}
                                    <td>

                                        <span class="badge bg-{{ $patientPackage->status_badge }}">

                                            {{ $patientPackage->status_label }}

                                        </span>

                                    </td>


                                    {{-- Action --}}
                                    <td>

                                        <div class="d-flex gap-1">

                                            {{-- Detail --}}
                                            <a href="{{ route('patient_packages.show', $patientPackage) }}"
                                               class="btn btn-sm btn-info"
                                               title="Detail">

                                                <i class="fas fa-eye"></i>

                                            </a>


                                            {{-- Edit --}}
                                            <a href="{{ route('patient_packages.edit', $patientPackage) }}"
                                               class="btn btn-sm btn-warning"
                                               title="Edit">

                                                <i class="fas fa-edit"></i>

                                            </a>


                                            {{-- Archive --}}
                                            <form method="POST"
                                                  action="{{ route('patient_packages.destroy', $patientPackage) }}"
                                                  class="d-inline">

                                                @csrf
                                                @method('DELETE')

                                                <button type="submit"
                                                        class="btn btn-sm btn-danger"
                                                        title="Arsipkan"
                                                        onclick="return confirm('Arsipkan Patient Package ini?')">

                                                    <i class="fas fa-archive"></i>

                                                </button>

                                            </form>

                                        </div>

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td colspan="9"
                                        class="text-center py-4">

                                        <div class="text-muted">

                                            <i class="fas fa-box-open fa-2x mb-2"></i>

                                            <div>
                                                Belum ada Patient Package.
                                            </div>

                                        </div>

                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>


            {{-- =====================================================
                 PAGINATION
            ====================================================== --}}
            @if($patientPackages->hasPages())

                <div class="card-footer">

                    {{ $patientPackages->links() }}

                </div>

            @endif

        </div>

    </div>

</x-app-layout>