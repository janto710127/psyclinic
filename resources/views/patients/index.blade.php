<x-app-layout>

    <div class="container-fluid">

        <div class="d-flex justify-content-between align-items-center mb-4">

            <h3 class="mb-0">
                Daftar Pasien
            </h3>

            <a href="{{ route('patients.create') }}" class="btn btn-primary">
                <i class="bi bi-plus"></i>
                Tambah Pasien
            </a>
        </div>


        <div class="card shadow-sm">

            <div class="card-header">

                <h5 class="mb-0">
                    Data Pasien
                </h5>

            </div>


            <div class="card-body">

                <form method="GET" action="{{ route('patients.index') }}" class="row g-2 mb-3">

                    <div class="col-md-8">
                        <input type="text"
                            name="keyword"
                            class="form-control"
                            placeholder="Cari No RM / Nama / HP"
                            value="{{ $keyword }}">
                    </div>

                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">
                            Cari
                        </button>
                    </div>

                    <div class="col-md-2">
                        <a href="{{ route('patients.index') }}" class="btn btn-secondary w-100">
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
                                    No. Pasien
                                </th>

                                <th>
                                    Nama
                                </th>

                                <th>
                                    Jenis Kelamin
                                </th>

                                <th>
                                    No. HP
                                </th>

                                <th width="150">
                                    Aksi
                                </th>

                            </tr>

                        </thead>


                        <tbody>

                            @forelse ($patients as $patient)

                                <tr>

                                    <td>
                                        {{ $loop->iteration }}
                                    </td>

                                    <td>
                                        {{ $patient->patient_number }}
                                    </td>

                                    <td>
                                        {{ $patient->name }}
                                    </td>

                                    <td>
                                        {{ $patient->gender ?? '-' }}
                                    </td>

                                    <td>
                                        {{ $patient->phone ?? '-' }}
                                    </td>

                                    <td>

                                        <a href="{{ route('patients.show', $patient) }}"
                                        class="btn btn-sm btn-info">
                                            Lihat
                                        </a>
                                   </td>

                                </tr>

                            @empty

                                <tr>

                                    <td colspan="6"
                                        class="text-center text-muted">

                                        Belum ada data pasien

                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>
 
                </div>
               <div class="mt-3">
                    {{ $patients->links() }}
                </div>
 
            </div>

        </div>

    </div>

</x-app-layout>