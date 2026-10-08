<x-app-layout>

    <div class="container-fluid">

        {{-- Header --}}
        <div class="d-flex justify-content-between align-items-center mb-3">

            <h2 class="h4 mb-0">
                Branch
            </h2>

            <a href="{{ route('branches.create') }}"
               class="btn btn-primary">
                <i class="fas fa-plus"></i>
                Tambah Branch
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


        {{-- Search & Filter --}}
        <div class="card shadow-sm mb-3">

            <div class="card-body">

                <form method="GET"
                      action="{{ route('branches.index') }}">

                    <div class="row g-2">

                        {{-- Search --}}
                        <div class="col-md-5">

                            <input type="text"
                                   name="search"
                                   class="form-control"
                                   placeholder="Cari kode atau nama branch..."
                                   value="{{ request('search') }}">

                        </div>


                        {{-- Organization --}}
                        <div class="col-md-4">

                            <select name="organization_id"
                                    class="form-select">

                                <option value="">
                                    -- Semua Organization --
                                </option>

                                @foreach ($organizations as $organization)

                                    <option value="{{ $organization->id }}"
                                        {{ request('organization_id') == $organization->id ? 'selected' : '' }}>

                                        {{ $organization->organization_code }}
                                        -
                                        {{ $organization->organization_name }}

                                    </option>

                                @endforeach

                            </select>

                        </div>


                        {{-- Cari --}}
                        <div class="col-md-1">

                            <button type="submit"
                                    class="btn btn-primary w-100">
                                <i class="fas fa-search"></i>
                                Cari
                            </button>

                        </div>


                        {{-- Reset --}}
                        <div class="col-md-1">

                            <a href="{{ route('branches.index') }}"
                               class="btn btn-secondary w-100">
                                <i class="fas fa-sync"></i>
                                Reset
                            </a>

                        </div>


                        {{-- Arsip --}}
                        <div class="col-md-1">

                            <a href="{{ route('branches.archived') }}"
                               class="btn btn-secondary w-100"
                               title="Arsip">
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
                    Total Branch:
                </strong>

                {{ $branches->total() }}

            </div>

        </div>


        {{-- Table --}}
        <div class="card shadow-sm">

            <div class="card-header">

                <strong>
                    Daftar Branch
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
                                    Kode Branch
                                </th>

                                <th>
                                    Nama Branch
                                </th>

                                <th>
                                    Organization
                                </th>

                                <th>
                                    Telepon
                                </th>

                                <th>
                                    Status
                                </th>

                                <th width="160">
                                    Aksi
                                </th>

                            </tr>

                        </thead>


                        <tbody>

                            @forelse ($branches as $branch)

                                <tr>

                                    <td>
                                        {{ $branches->firstItem() + $loop->index }}
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

                                        {{ $branch->organization->organization_code }}
                                        -
                                        {{ $branch->organization->organization_name }}

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


                                    <td>

                                        {{-- Detail --}}
                                        <a href="{{ route('branches.show', $branch->id) }}"
                                           class="btn btn-info btn-sm"
                                           title="Detail">

                                            <i class="fas fa-eye"></i>

                                        </a>


                                        {{-- Edit --}}
                                        <a href="{{ route('branches.edit', $branch->id) }}"
                                           class="btn btn-warning btn-sm"
                                           title="Edit">

                                            <i class="fas fa-edit"></i>

                                        </a>


                                        {{-- Arsipkan --}}
                                        <form action="{{ route('branches.destroy', $branch->id) }}"
                                              method="POST"
                                              class="d-inline">

                                            @csrf

                                            @method('DELETE')

                                            <button type="submit"
                                                    class="btn btn-danger btn-sm"
                                                    title="Arsipkan"
                                               		onclick="return confirm('Arsipkan Branch {{ $branch->branch_name }} ini?')"
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
                                            Belum ada Branch.
                                        </div>

                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>


            {{-- Pagination --}}
            @if ($branches->hasPages())

                <div class="card-footer">

                    {{ $branches->links() }}

                </div>

            @endif

        </div>

    </div>

</x-app-layout>