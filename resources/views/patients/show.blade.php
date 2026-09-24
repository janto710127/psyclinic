<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detail Pasien
        </h2>
    </x-slot>
    <div class="container-fluid">
        <div class="card shadow-sm">
             <div class="card-header d-flex justify-content-between align-items-center">

                <div>
                    <h4 class="mb-0">
                        Detail Pasien
                    </h4>

                    <small class="text-muted">
                        Informasi lengkap data pasien
                    </small>

                </div>

                <div class="d-flex gap-2">

                    @if($patient->trashed())

                        <form action="{{ route('patients.restore', $patient->id) }}"
                              method="POST"
                              class="d-inline">

                            @csrf
                            @method('PATCH')

                            <button type="submit"
                                    class="btn btn-success btn-sm"
                                    onclick="return confirm('Pulihkan pasien ini?')">

                                Restore

                            </button>

                        </form>

                        <a href="{{ route('patients.archived') }}"
                           class="btn btn-secondary btn-sm">

                            Kembali

                        </a>

                    @else

                        <a href="{{ route('patients.edit', $patient) }}"
                           class="btn btn-warning btn-sm">

                            Edit

                        </a>

                        <form action="{{ route('patients.destroy', $patient) }}"
                              method="POST"
                              class="d-inline">

                            @csrf
                            @method('DELETE')

                            <button type="submit"
                                    class="btn btn-danger btn-sm"
                                    onclick="return confirm('Arsipkan pasien ini?')">
                                Arsipkan
                            </button>
                        </form>

                        <a href="{{ route('patients.index') }}"
                           class="btn btn-secondary btn-sm">
                            Kembali
                        </a>

                    @endif

                </div>

                </div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <th width="25%">No Pasien</th>
                            <td>{{ $patient->patient_number }}</td>
                        </tr>

                        <tr>
                            <th>Nama</th>
                            <td>{{ $patient->name }}</td>
                        </tr>
                        <tr>
                            <th>Jenis Kelamin</th>
                            <td>{{ $patient->gender }}</td>
                        </tr>
                        <tr>
                            <th>No HP</th>
                            <td>{{ $patient->phone }}</td>
                        </tr>
                    </table>
                    <hr>

                    <!-- <table class="table table-borderless"> -->

                    <!-- <div class="card-header d-flex justify-content-between align-items-center"> -->
                    <div class="card-header d-flex justify-content-between align-items-center">

                        <h4 class="mb-0">
                            Timeline Pasien
                        </h4>

                        

                        <a href="{{ route('patients.timelines.create', $patient) }}"
                        class="btn btn-primary">

                            <i class="bi bi-plus-circle"></i>
                            Tambah Timeline

                        </a>

                    </div>

                    @if($patient->timelines->count())

                        <div class="list-group">

                            @foreach($patient->timelines->sortByDesc('occurred_at') as $timeline)

                                <div class="list-group-item">

                                    <div class="d-flex justify-content-between">

                                        <h5 class="mb-1">
                                            {{ $timeline->title }}
                                        </h5>

                                        <small class="text-muted">

                                            {{ $timeline->occurred_at->format('d M Y H:i') }}

                                        </small>

                                    </div>

                                    <p class="mb-1">

                                        {{ $timeline->description ?? '-' }}

                                    </p>

                                    <small class="badge bg-secondary">

                                        {{ $timeline->type }}

                                    </small>

                                </div>

                            @endforeach

                        </div>

                    @else

                        <div class="alert alert-info">

                            Belum ada timeline pasien.

                        </div>

                    @endif

                    <!-- </table> -->

                <div>

            </div>
        </div>
    </div>
</x-app-layout>