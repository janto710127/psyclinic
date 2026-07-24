<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Arsip Psikolog
        </h2>
    </x-slot>

    <div class="container-fluid">

        <div class="card">

            <div class="card-header">

                Data Psikolog Diarsipkan

            </div>

            <div class="card-body">

                <form method="GET"
                        action="{{ route('psychologists.archived') }}"
                        class="row mb-3">

                        <div class="col-md-8">

                            <input type="text"
                                name="search"
                                class="form-control"
                                placeholder="Cari No PS / Nama / HP"
                                value="{{ request('search') }}">

                        </div>

                        <div class="col-md-2">

                            <button class="btn btn-primary w-100">

                                Cari

                            </button>

                        </div>

                        <div class="col-md-2">

                            <a href="{{ route('psychologists.archived') }}"
                            class="btn btn-secondary w-100">

                                Reset

                            </a>

                        </div>

                    </form>

                <table class="table table-bordered table-striped">

                    <thead>

                        <tr>
                            <th>No</th>
                            <th>No Psikolog</th>
                            <th>Nama</th>
                            <th>Dihapus</th>
                            <th>Aksi</th>
                        </tr>

                    </thead>

                    <tbody>

                        @forelse($psychologists as $psychologist)

                            <tr>

                                <td>
                                    {{ $loop->iteration }}
                                </td>

                                <td>
                                    {{ $psychologist->psychologist_number }}
                                </td>

                                <td>
                                    {{ $psychologist->name }}
                                </td>

                                <td>
                                    {{ $psychologist->deleted_at->format('d-m-Y H:i') }}
                                </td>

                                <td>

                                    <form method="POST"
                                        action="{{ route('psychologists.restore', $psychologist->id) }}"
                                        style="display:inline">

                                        @csrf
                                        @method('PATCH')

                                        <button type="submit"
                                                class="btn btn-success btn-sm"
                                                onclick="return confirm('Pulihkan psikolog ini?')">

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

                {{ $psychologists->links() }}

                <div class="mt-3">

    <a href="{{ route('psychologists.index') }}"
       class="btn btn-secondary">

        Kembali ke Data Psikolog

    </a>

</div>

            </div>

        </div>

    </div>

</x-app-layout>