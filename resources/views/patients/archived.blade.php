<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Arsip Pasien
        </h2>
    </x-slot>

    <div class="container-fluid">

        <div class="card">

            <div class="card-header">

                Data Pasien Diarsipkan

            </div>

            <div class="card-body">

                                <form method="GET"
                        action="{{ route('patients.archived') }}"
                        class="row mb-3">

                        <div class="col-md-8">

                            <input type="text"
                                name="search"
                                class="form-control"
                                placeholder="Cari No RM / Nama / HP"
                                value="{{ request('search') }}">

                        </div>

                        <div class="col-md-2">

                            <button class="btn btn-primary w-100">

                                Cari

                            </button>

                        </div>

                        <div class="col-md-2">

                            <a href="{{ route('patients.archived') }}"
                            class="btn btn-secondary w-100">

                                Reset

                            </a>

                        </div>

                    </form>

                <table class="table table-bordered table-striped">

                    <thead>

                        <tr>
                            <th>No</th>
                            <th>No Pasien</th>
                            <th>Nama</th>
                            <th>Dihapus</th>
                            <th>Aksi</th>
                        </tr>

                    </thead>

                    <tbody>

                        @forelse($patients as $patient)

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
                                    {{ $patient->deleted_at->format('d-m-Y H:i') }}
                                </td>

                                <td>

<form method="POST"
      action="{{ route('patients.restore', $patient->id) }}"
      style="display:inline">

    @csrf
    @method('PATCH')

    <button type="submit"
            class="btn btn-success btn-sm"
            onclick="return confirm('Pulihkan pasien ini?')">

        Restore

    </button>

</form>
                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="5"
                                    class="text-center">

                                    Tidak ada data arsip.

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

                {{ $patients->links() }}

                <div class="mt-3">

    <a href="{{ route('patients.index') }}"
       class="btn btn-secondary">

        Kembali ke Data Pasien

    </a>

</div>

            </div>

        </div>

    </div>

</x-app-layout>