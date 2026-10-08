<x-app-layout>

    <div class="container-fluid">

        {{-- Header --}}
        <div class="d-flex justify-content-between align-items-center mb-3">

            <h2 class="h4 mb-0">
                Arsip Organization
            </h2>

            <a href="{{ route('organizations.index') }}"
               class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i>
                Kembali
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


        {{-- Table --}}
        <div class="card shadow-sm">

            <div class="card-header">
                <strong>Daftar Organization yang Diarsipkan</strong>
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
                                <th>Diarsipkan</th>
                                <th width="150">Aksi</th>
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
                                        {{ $organization->deleted_at->format('d-m-Y H:i') }}
                                    </td>

                                    <td>

                                        {{-- Detail --}}
                                        <a href="{{ route('organizations.show', $organization->id) }}"
                                           class="btn btn-info btn-sm"
                                           title="Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>

                                        {{-- Restore --}}
                                        <form action="{{ route('organizations.restore', $organization->id) }}"
                                              method="POST"
                                              class="d-inline">

                                            @csrf
                                            @method('PATCH')

                                            <button type="submit"
                                                    class="btn btn-success btn-sm"
                                                    title="Restore"
                                                    onclick="return confirm('Pulihkan organisasi {{ $organization->organization_name }} ini?')"
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
                                            Belum ada Organization yang diarsipkan.
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