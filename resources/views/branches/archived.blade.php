<x-app-layout>
    <div class="container-fluid">

        {{-- Header --}}
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="h4 mb-0">Arsip Branch</h2>

            <a href="{{ route('branches.index') }}"
               class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i>
                Kembali ke Branch
            </a>
        </div>

        {{-- Success Message --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}

                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- Summary --}}
        <div class="card shadow-sm mb-3">
            <div class="card-body">
                <strong>Total Branch Diarsipkan:</strong>
                {{ $branches->total() }}
            </div>
        </div>

        {{-- Table --}}
        <div class="card shadow-sm">

            <div class="card-header">
                <strong>Daftar Branch yang Diarsipkan</strong>
            </div>

            <div class="card-body p-0">

                <div class="table-responsive">

                    <table class="table table-hover table-striped align-middle mb-0">

                        <thead class="table-light">
                            <tr>
                                <th width="60">No</th>
                                <th>Kode Branch</th>
                                <th>Nama Branch</th>
                                <th>Organization</th>
                                <th>Status</th>
                                <th>Diarsipkan</th>
                                <th width="150">Aksi</th>
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
                                        <span class="badge bg-danger">
                                            Diarsipkan
                                        </span>
                                    </td>

                                    <td>
                                        {{ $branch->deleted_at?->format('d-m-Y H:i') ?? '-' }}
                                    </td>

                                    <td>

                                        {{-- Detail --}}
                                        <a href="{{ route('branches.show', $branch->id) }}"
                                           class="btn btn-info btn-sm"
                                           title="Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>

                                        {{-- Restore --}}
                                        <form
                                            action="{{ route('branches.restore', $branch->id) }}"
                                            method="POST"
                                            class="d-inline"
                                        >
                                            @csrf
                                            @method('PATCH')

                                            <button
                                                type="submit"
                                                class="btn btn-success btn-sm"
                                                title="Restore" 
                                           		onclick="return confirm('Pulihkan Branch {{ $branch->branch_name }} ini?')"
                                            >
                                                <i class="fas fa-undo"></i>
                                            </button>

                                        </form>

                                    </td>

                                </tr>

                            @empty

                                <tr>
                                    <td colspan="7"
                                        class="text-center py-4 text-muted">

                                        <i class="fas fa-archive fa-2x mb-2"></i>

                                        <div>
                                            Tidak ada Branch yang diarsipkan.
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