<x-app-layout>

        <div class="container-fluid">

            <div class="d-flex justify-content-between align-items-center mb-3">

                <h2 class="h4 mb-0">
                    Organization
                </h2>

                <a href="{{ route('organizations.create') }}"
                class="btn btn-primary">
                    <i class="fas fa-plus"></i>
                    Tambah Organization
                </a>

            </div>
        {{-- Pesan sukses --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}

                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="alert">
                </button>
            </div>
        @endif

        {{-- Search dan Arsip --}}
        <div class="card shadow-sm mb-3">
            <div class="card-body">

                <form method="GET"
                      action="{{ route('organizations.index') }}">

                    <div class="row g-2">

                        <div class="col-md-8">
                            <input type="text"
                                   name="search"
                                   class="form-control"
                                   placeholder="Cari kode atau nama organization..."
                                   value="{{ request('search') }}">
                        </div>

                        <div class="col-md-2">
                            <button type="submit"
                                    class="btn btn-primary w-100">
                                <i class="fas fa-search"></i>
                                Cari
                            </button>
                        </div>

                        <div class="col-md-2">
                            <a href="{{ route('organizations.archived') }}"
                               class="btn btn-secondary w-100">
                                <i class="fas fa-archive"></i>
                                Arsip
                            </a>
                        </div>

                    </div>

                </form>

            </div>
        </div>

        {{-- Summary --}}
        <div class="card shadow-sm mb-3">
            <div class="card-body">

                <strong>
                    Total Organization:
                </strong>

                {{ $organizations->total() }}

            </div>
        </div>

        {{-- Table --}}
        <div class="card shadow-sm">

            <div class="card-header">
                <strong>Daftar Organization</strong>
            </div>

            <div class="card-body p-0">

                <div class="table-responsive">

                    <table class="table table-hover table-striped align-middle mb-0">

                        <thead class="table-light">

                            <tr>
                                <th width="60">No</th>
                                <th>Kode</th>
                                <th>Nama Organization</th>
                                <th>Telepon</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th width="180">Aksi</th>
                            </tr>

                        </thead>

                        <tbody>

                            @forelse ($organizations as $organization)

                                <tr>

                                    <td>
                                        {{ $organizations->firstItem() + $loop->index }}
                                    </td>

                                    <td>
                                        <strong>
                                            {{ $organization->organization_code }}
                                        </strong>
                                    </td>

                                    <td>
                                        {{ $organization->organization_name }}
                                    </td>

                                    <td>
                                        {{ $organization->phone ?? '-' }}
                                    </td>

                                    <td>
                                        {{ $organization->email ?? '-' }}
                                    </td>

                                    <td>

                                        @if ($organization->is_active)

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

                                        {{-- Detail --}}
                                        <a href="{{ route('organizations.show', $organization->id) }}"
                                           class="btn btn-info btn-sm"
                                           title="Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>

                                        {{-- Edit --}}
                                        <a href="{{ route('organizations.edit', $organization->id) }}"
                                           class="btn btn-warning btn-sm"
                                           title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        {{-- Arsipkan --}}
                                        <form action="{{ route('organizations.destroy', $organization->id) }}"
                                              method="POST"
                                              class="d-inline">

                                            @csrf

                                            @method('DELETE')

                                            <button type="submit"
                                                    class="btn btn-danger btn-sm"
                                                    title="Arsipkan" 
                                                    onclick="return confirm('Arsipkan organisasi {{ $organization->organization_name }} ini?')"
                                                    >
                                                <i class="fas fa-archive"></i>
                                            </button>

                                        </form>

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td colspan="7"
                                        class="text-center py-4 text-muted">

                                        <i class="fas fa-building fa-2x mb-2"></i>

                                        <div>
                                            Belum ada Organization.
                                        </div>

                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

            {{-- Pagination --}}
            @if ($organizations->hasPages())

                <div class="card-footer">

                    {{ $organizations->links() }}

                </div>

            @endif

        </div>

    </div>

</x-app-layout>