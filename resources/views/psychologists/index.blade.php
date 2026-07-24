<x-app-layout>

    <div class="container-fluid">

        <div class="card shadow-sm">

            {{-- Header --}}
            <div class="card-header d-flex justify-content-between align-items-center">

                <h4 class="mb-0">
                    Daftar Psikolog
                </h4>

                <a href="{{ route('psychologists.create') }}"
                   class="btn btn-primary">

                    <i class="bi bi-person-plus-fill"></i>
                    Tambah Psikolog

                </a>

            </div>

            <div class="card-body">

                {{-- Form Pencarian --}}
                <form method="GET"
                      action="{{ route('psychologists.index') }}"
                      class="row g-2 mb-3">

                    <div class="col-md-8">

                        <input type="text"
                               name="search"
                               class="form-control"
                               placeholder="Cari Kode Psikolog / Nama / No. HP"
                               value="{{ $search }}">

                    </div>

                    <div class="col-md-2">

                        <button type="submit"
                                class="btn btn-primary w-100">

                            <i class="bi bi-search"></i>
                            Cari

                        </button>

                    </div>

                    <div class="col-md-2">

                        <a href="{{ route('psychologists.index') }}"
                           class="btn btn-secondary w-100">

                            <i class="bi bi-arrow-clockwise"></i>
                            Reset

                        </a>

                    </div>

                </form>

                {{-- Total Data --}}
                <div class="mb-3 text-muted">

                    Total Data :
                    <strong>{{ $psychologists->total() }}</strong> Psikolog

                </div>

                <div class="table-responsive">

                    <table class="table table-striped table-hover align-middle">

                        <thead class="table-light">

                            <tr>

                                <th width="60" class="text-center">
                                    No
                                </th>

                                <th width="140">
                                    Kode
                                </th>

                                <th>
                                    Nama Psikolog
                                </th>

                                <th width="140">
                                    Jenis Kelamin
                                </th>

                                <th width="180">
                                    No. SIP
                                </th>

                                <th width="150">
                                    No. HP
                                </th>

                                <th width="120" class="text-center">
                                    Status
                                </th>

                                <th width="120" class="text-center">
                                    Aksi
                                </th>

                            </tr>

                        </thead>

                        <tbody>

                            @forelse($psychologists as $psychologist)

                                <tr>

                                    <td class="text-center">

                                        {{ $psychologists->firstItem() + $loop->index }}

                                    </td>

                                    <td>

                                        {{ $psychologist->psychologist_code }}

                                    </td>

                                    <td>

                                        {{ $psychologist->name }}

                                    </td>

                                    <td>

                                        {{ $psychologist->gender }}

                                    </td>

                                    <td>

                                        {{ $psychologist->sip_number ?? '-' }}

                                    </td>

                                    <td>

                                        {{ $psychologist->phone ?? '-' }}

                                    </td>

                                    <td class="text-center">

                                        @if($psychologist->is_active)

                                            <span class="badge bg-success rounded-pill">

                                                Aktif

                                            </span>

                                        @else

                                            <span class="badge bg-secondary rounded-pill">

                                                Non Aktif

                                            </span>

                                        @endif

                                    </td>

                                    <td class="text-center">

                                        <a href="{{ route('psychologists.show',$psychologist) }}"
                                           class="btn btn-sm btn-info">

                                            <i class="bi bi-eye"></i>

                                        </a>

                                        <a href="{{ route('psychologists.edit',$psychologist) }}"
                                           class="btn btn-sm btn-warning">

                                            <i class="bi bi-pencil-square"></i>

                                        </a>

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td colspan="8"
                                        class="text-center text-muted py-4">

                                        Belum ada data Psikolog.

                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

                <div class="mt-3">

                    {{ $psychologists->links() }}

                </div>

            </div>

        </div>

    </div>

</x-app-layout>