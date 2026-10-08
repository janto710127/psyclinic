<x-app-layout>

    <div class="container-fluid">

        {{-- Header --}}
        <div class="d-flex justify-content-between align-items-center mb-3">

            <h2 class="h4 mb-0">
                Detail Organization
            </h2>

            <div>

                <a href="{{ route('organizations.index') }}"
                   class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i>
                    Kembali
                </a>

                @if ($organization->trashed())

                    <form action="{{ route('organizations.restore', $organization->id) }}"
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

                    <a href="{{ route('organizations.edit', $organization->id) }}"
                       class="btn btn-warning">
                        <i class="fas fa-edit"></i>
                        Edit
                    </a>

                @endif

            </div>

        </div>


        {{-- Informasi Organization --}}
        <div class="card shadow-sm mb-3">

            <div class="card-header">
                <strong>Informasi Organization</strong>
            </div>

            <div class="card-body">

                <div class="row">

                    {{-- Kode --}}
                    <div class="col-md-6 mb-3">

                        <label class="text-muted">
                            Kode Organization
                        </label>

                        <div>
                            <strong>
                                {{ $organization->organization_code }}
                            </strong>
                        </div>

                    </div>


                    {{-- Nama --}}
                    <div class="col-md-6 mb-3">

                        <label class="text-muted">
                            Nama Organization
                        </label>

                        <div>
                            {{ $organization->organization_name }}
                        </div>

                    </div>


                    {{-- Telepon --}}
                    <div class="col-md-6 mb-3">

                        <label class="text-muted">
                            Telepon
                        </label>

                        <div>
                            {{ $organization->phone ?? '-' }}
                        </div>

                    </div>


                    {{-- Email --}}
                    <div class="col-md-6 mb-3">

                        <label class="text-muted">
                            Email
                        </label>

                        <div>
                            {{ $organization->email ?? '-' }}
                        </div>

                    </div>


                    {{-- Status --}}
                    <div class="col-md-6 mb-3">

                        <label class="text-muted">
                            Status
                        </label>

                        <div>

                            @if ($organization->is_active)

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


                    {{-- Alamat --}}
                    <div class="col-md-6 mb-3">

                        <label class="text-muted">
                            Alamat
                        </label>

                        <div>
                            {{ $organization->address ?? '-' }}
                        </div>

                    </div>


                    {{-- Catatan --}}
                    <div class="col-12">

                        <label class="text-muted">
                            Catatan
                        </label>

                        <div>
                            {{ $organization->notes ?? '-' }}
                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- Branch --}}
        <div class="card shadow-sm">

            <div class="card-header d-flex justify-content-between align-items-center">

                <strong>
                    Branch
                </strong>

                @if (! $organization->trashed())

                    <a href="#"
                       class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i>
                        Tambah Branch
                    </a>

                @endif

            </div>

            <div class="card-body p-0">

                <div class="table-responsive">

                    <table class="table table-hover table-striped align-middle mb-0">

                        <thead class="table-light">

                            <tr>
                                <th width="60">No</th>
                                <th>Kode Branch</th>
                                <th>Nama Branch</th>
                                <th>Telepon</th>
                                <th>Status</th>
                            </tr>

                        </thead>

                        <tbody>

                            @forelse ($organization->branches as $branch)

                                <tr>

                                    <td>
                                        {{ $loop->iteration }}
                                    </td>

                                    <td>
                                        <strong>
                                            {{ $branch->branch_code }}
                                        </strong>
                                    </td>

                                    <td>
                                        {{ $branch->branch_name }}
                                    </td>

                                    <td>
                                        {{ $branch->phone ?? '-' }}
                                    </td>

                                    <td>

                                        @if ($branch->is_active)

                                            <span class="badge bg-success">
                                                Aktif
                                            </span>

                                        @else

                                            <span class="badge bg-secondary">
                                                Non Aktif
                                            </span>

                                        @endif

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td colspan="5"
                                        class="text-center py-4 text-muted">

                                        <i class="fas fa-building fa-2x mb-2"></i>

                                        <div>
                                            Belum ada Branch.
                                        </div>

                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>

</x-app-layout>