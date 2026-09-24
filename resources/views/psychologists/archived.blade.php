<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Arsip Psikolog
        </h2>
    </x-slot>

    <div class="container-fluid">

        <div class="card shadow-sm">

            <div class="card-header d-flex justify-content-between align-items-center">

                <div>

                    <h4 class="mb-0">
                        Arsip Data Psikolog
                    </h4>

                    <small class="text-muted">
                        Kelola data psikolog yang telah diarsipkan
                    </small>

                </div>

                <!--ADD -->
                <a href="{{ route('psychologists.index') }}"
                   class="btn btn-primary">

                    Kembali

                </a>

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
                            <th width="160">Dihapus</th>
                            <th width="120" class="text-center">Aksi</th>
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

                                <td class="text-center">

                                        <div class="btn-group btn-group-sm">

                                            <a href="{{ route('psychologists.show',$psychologist->id) }}"
                                               class="btn btn-info">

                                                Detail
                                            </a>    

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
                                            
                                        </div>
                                        
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