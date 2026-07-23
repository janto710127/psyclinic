<x-app-layout>

    <div class="container-fluid">

        <div class="d-flex justify-content-between align-items-center mb-4">

            <h3 class="mb-0">
                Daftar Psikolog
            </h3>

            <a href="{{ route('psychologists.create') }}" class="btn btn-primary">
                <i class="bi bi-plus"></i>
                Tambah Psikolog
            </a>
        </div>


        <div class="card shadow-sm">

            <div class="card-header">

                <h5 class="mb-0">
                    Data Psikolog
                </h5>

            </div>


            <div class="card-body">

                <form method="GET" action="{{ route('psychologists.index') }}" class="row g-2 mb-3">

                    <div class="col-md-8">
                        <input type="text"
                            name="search"
                            class="form-control"
                            placeholder="Cari Kode Psikolog / Nama / HP"
                            value="{{ $search }}">
                    </div>

                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">
                            Cari
                        </button>
                    </div>

                    <div class="col-md-2">
                        <a href="{{ route('psychologists.index') }}" class="btn btn-secondary w-100">
                            Reset
                        </a>
                    </div>

                </form>

                <div class="table-responsive">

                    <table class="table table-bordered table-hover">

                        <thead class="table-light">

                            <tr>

                                <th width="60">
                                    No
                                </th>

                                <th>
                                    Kode Psikolog
                                </th>

                                <th>
                                    Nama
                                </th>
                                <th>
                                    Jenis Kelamin
                                </th>

                                <th>
                                    SIP
                                </th>

                                <th>
                                    No. HP
                                </th>

                                <th>
                                    Status
                                </th>

                                <th width="180">
                                    Aksi
                                </th>

                            </tr>

                        </thead>


                        <tbody>

                            @forelse ($psychologists as $psychologist)

                                <tr>

                                    <td>
                                        {{ $loop->iteration }}
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

                                    <td>

                                        @if($psychologist->is_active)

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

                                        <a href="{{ route('psychologists.show', $psychologist) }}"
                                        class="btn btn-sm btn-info">
                                            Lihat
                                        </a>
                                   </td>

                                </tr>

                            @empty

                                <tr>

                                    <td colspan="6"
                                        class="text-center text-muted">

                                        Belum ada data Psikolog

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