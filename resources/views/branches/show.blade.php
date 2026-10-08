<x-app-layout>
    <div class="container-fluid">

        {{-- Header --}}
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="h4 mb-0">Detail Branch</h2>

            <div>
                <a href="{{ route('branches.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i>
                    Kembali
                </a>

                @if (!$branch->trashed())
                    <a href="{{ route('branches.edit', $branch->id) }}"
                       class="btn btn-warning">
                        <i class="fas fa-edit"></i>
                        Edit
                    </a>
                @endif
            </div>
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

        {{-- Informasi Branch --}}
        <div class="card shadow-sm mb-3">

            <div class="card-header">
                <strong>Informasi Branch</strong>
            </div>

            <div class="card-body">

                <div class="table-responsive">
                    <table class="table table-bordered align-middle mb-0">

                        <tbody>

                            {{-- Organization --}}
                            <tr>
                                <th width="220">
                                    Organization
                                </th>

                                <td>
                                    {{ $branch->organization->organization_code }}
                                    -
                                    {{ $branch->organization->organization_name }}
                                </td>
                            </tr>

                            {{-- Branch Code --}}
                            <tr>
                                <th>
                                    Kode Branch
                                </th>

                                <td>
                                    <strong>
                                        {{ $branch->branch_code }}
                                    </strong>
                                </td>
                            </tr>

                            {{-- Branch Name --}}
                            <tr>
                                <th>
                                    Nama Branch
                                </th>

                                <td>
                                    {{ $branch->branch_name }}
                                </td>
                            </tr>

                            {{-- Address --}}
                            <tr>
                                <th>
                                    Alamat
                                </th>

                                <td>
                                    {!! nl2br(e($branch->address ?? '-')) !!}
                                </td>
                            </tr>

                            {{-- Phone --}}
                            <tr>
                                <th>
                                    Telepon
                                </th>

                                <td>
                                    {{ $branch->phone ?? '-' }}
                                </td>
                            </tr>

                            {{-- Email --}}
                            <tr>
                                <th>
                                    Email
                                </th>

                                <td>
                                    {{ $branch->email ?? '-' }}
                                </td>
                            </tr>

                            {{-- Status --}}
                            <tr>
                                <th>
                                    Status
                                </th>

                                <td>
                                    @if ($branch->trashed())
                                        <span class="badge bg-danger">
                                            Diarsipkan
                                        </span>
                                    @elseif ($branch->is_active)
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

                            {{-- Notes --}}
                            <tr>
                                <th>
                                    Catatan
                                </th>

                                <td>
                                    {!! nl2br(e($branch->notes ?? '-')) !!}
                                </td>
                            </tr>

                            {{-- Created --}}
                            <tr>
                                <th>
                                    Dibuat
                                </th>

                                <td>
                                    {{ $branch->created_at?->format('d-m-Y H:i') ?? '-' }}
                                </td>
                            </tr>

                            {{-- Updated --}}
                            <tr>
                                <th>
                                    Terakhir Diubah
                                </th>

                                <td>
                                    {{ $branch->updated_at?->format('d-m-Y H:i') ?? '-' }}
                                </td>
                            </tr>

                            {{-- Deleted --}}
                            @if ($branch->trashed())
                                <tr>
                                    <th>
                                        Diarsipkan
                                    </th>

                                    <td>
                                        {{ $branch->deleted_at?->format('d-m-Y H:i') ?? '-' }}
                                    </td>
                                </tr>
                            @endif

                        </tbody>

                    </table>
                </div>

            </div>
        </div>

        {{-- Organization --}}
        <div class="card shadow-sm">

            <div class="card-header">
                <strong>Organization</strong>
            </div>

            <div class="card-body">

                <p class="mb-1">
                    <strong>Kode:</strong>
                    {{ $branch->organization->organization_code }}
                </p>

                <p class="mb-1">
                    <strong>Nama:</strong>
                    {{ $branch->organization->organization_name }}
                </p>

                <a href="{{ route('organizations.show', $branch->organization->id) }}"
                   class="btn btn-info btn-sm mt-2">
                    <i class="fas fa-eye"></i>
                    Detail Organization
                </a>

            </div>

        </div>

    </div>
</x-app-layout>