<x-app-layout>

    <div class="container-fluid">

        {{-- Header --}}
        <div class="d-flex justify-content-between align-items-center mb-3">

            <div>
                <h4 class="mb-1">Service Package</h4>
                <small class="text-muted">
                    Daftar paket layanan psikologi
                </small>
            </div>

            <a href="{{ route('service_packages.create') }}"
               class="btn btn-primary">
                <i class="fas fa-plus"></i>
                Tambah Package
            </a>

        </div>


        {{-- Search --}}
        <div class="card shadow-sm mb-3">

            <div class="card-header">
                <strong>
                    <i class="fas fa-search"></i>
                    Pencarian
                </strong>
            </div>

            <div class="card-body">

                <form method="GET"
                      action="{{ route('service_packages.index') }}">

                    <div class="row">

                        <div class="col-md-8">

                            <label for="search"
                                   class="form-label">
                                Cari Package
                            </label>

                            <input type="text"
                                   name="search"
                                   id="search"
                                   class="form-control"
                                   value="{{ request('search') }}"
                                   placeholder="Kode atau nama package">

                        </div>

                        <div class="col-md-4 d-flex align-items-end">

                            <button type="submit"
                                    class="btn btn-primary me-2">
                                <i class="fas fa-search"></i>
                                Cari
                            </button>

                            <a href="{{ route('service_packages.index') }}"
                               class="btn btn-secondary">
                                Reset
                            </a>

                        </div>

                    </div>

                </form>

            </div>

        </div>


        {{-- Summary --}}
        <div class="card shadow-sm mb-3">

            <div class="card-body">

                <div class="row">

                    <div class="col-md-4">

                        <div class="border rounded p-3">

                            <small class="text-muted">
                                Total Package
                            </small>

                            <h4 class="mb-0">
                                {{ $servicePackages->total() }}
                            </h4>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- Table --}}
        <div class="card shadow-sm">

            <div class="card-header d-flex justify-content-between align-items-center">

                <strong>
                    Daftar Service Package
                </strong>

            </div>

            <div class="card-body p-0">

                <div class="table-responsive">

                    <table class="table table-hover table-striped align-middle mb-0">

                        <thead class="table-light">

                            <tr>

                                <th width="60">No</th>

                                <th>Kode</th>

                                <th>Nama Package</th>

                                <th>Jumlah Layanan</th>

                                <th>Harga</th>

                                <th>Masa Berlaku</th>

                                <th>Status</th>

                                <th width="120">Aksi</th>

                            </tr>

                        </thead>

                        <tbody>

                            @forelse($servicePackages as $package)

                                <tr>

                                    <td>
                                        {{ $servicePackages->firstItem() + $loop->index }}
                                    </td>

                                    <td>
                                        <strong>
                                            {{ $package->package_code }}
                                        </strong>
                                    </td>

                                    <td>
                                        {{ $package->package_name }}
                                    </td>

                                    <td>
                                        <span class="badge bg-info">
                                            {{ $package->details->count() }}
                                            Layanan
                                        </span>
                                    </td>

                                    <td>
                                        {{ $package->price_label }}
                                    </td>

                                    <td>
                                        {{ $package->validity_label }}
                                    </td>

                                    <td>

                                        @if($package->is_active)

                                            <span class="badge bg-success">
                                                Aktif
                                            </span>

                                        @else

                                            <span class="badge bg-secondary">
                                                Non Aktif
                                            </span>

                                        @endif

                                    </td>

                                    <td>

                                        <a href="{{ route('service_packages.show', $package->id) }}"
                                           class="btn btn-info"
                                           title="Detail">

                                            <i class="fas fa-eye"></i>
                                             <!-- Show -->

                                        </a>

                                        <a href="{{ route('service_packages.edit', $package->id) }}"
                                           class="btn btn-warning"
                                           title="Edit">

                                            <i class="fas fa-edit"></i>
                                             <!-- Edit -->

                                        </a>

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td colspan="8"
                                        class="text-center py-4">

                                        <div class="text-muted">

                                            <i class="fas fa-box-open fa-2x mb-2"></i>

                                            <div>
                                                Belum ada Service Package.
                                            </div>

                                        </div>

                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>


            {{-- Pagination --}}
            @if($servicePackages->hasPages())

                <div class="card-footer">

                    {{ $servicePackages->links() }}

                </div>

            @endif

        </div>

    </div>

</x-app-layout>