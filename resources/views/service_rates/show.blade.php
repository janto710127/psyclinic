<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detail Tarif Layanan
        </h2>
    </x-slot>

    <div class="container-fluid">

        <div class="card shadow-sm">

            <div class="card-header d-flex justify-content-between align-items-center">

                <div>
                    <h4 class="mb-0">
                        Detail Tarif Layanan
                    </h4>

                    <small class="text-muted">
                        Informasi lengkap tarif layanan
                    </small>

                </div>

                <div class="d-flex gap-2">

                    @if($serviceRate->trashed())

                        <form action="{{ route('service_rates.restore', $serviceRate->id) }}"
                              method="POST"
                              class="d-inline">

                            @csrf
                            @method('PATCH')

                            <button type="submit"
                                    class="btn btn-success btn-sm"
                                    onclick="return confirm('Pulihkan tarif ini?')">

                                Restore

                            </button>

                        </form>

                        <a href="{{ route('service_rates.archived') }}"
                           class="btn btn-secondary btn-sm">

                            Kembali

                        </a>

                    @else

                        <a href="{{ route('service_rates.edit', $serviceRate) }}"
                           class="btn btn-warning btn-sm">

                            Edit

                        </a>

                        <form action="{{ route('service_rates.destroy', $serviceRate) }}"
                              method="POST"
                              class="d-inline">

                            @csrf
                            @method('DELETE')

                            <button type="submit"
                                    class="btn btn-danger btn-sm"
                                    onclick="return confirm('Arsipkan tarif ini?')">

                                Arsipkan

                            </button>

                        </form>

                        <a href="{{ route('service_rates.index') }}"
                           class="btn btn-secondary btn-sm">

                            Kembali

                        </a>

                    @endif

                </div>

            </div>


            <div class="card-body">

                <table class="table table-borderless">

                    <tr>
                        <th width="25%">Kode Layanan</th>
                        <td>{{ $serviceRate->service_code }}</td>
                    </tr>

                    <tr>
                        <th>Nama Layanan</th>
                        <td>{{ $serviceRate->service_name }}</td>
                    </tr>

                    <tr>
                        <th>Timeline</th>
                        <td>{{ $serviceRate->timelineType->name }}</td>
                    </tr>

                    <tr>
                        <th>Psikolog</th>
                        <td>{{ $serviceRate->psychologist?->name ?? 'Semua Psikolog' }}</td>
                    </tr>

                    <tr>
                        <th>Durasi</th>
                        <td>{{ $serviceRate->duration_label }}</td>
                    </tr>

                    <tr>
                        <th>Tarif</th>
                        <td>{{ $serviceRate->price_label }}</td>
                    </tr>

                    <tr>
                        <th>Status</th>
                        <td>
                            @if($serviceRate->is_active)
                                <span class="badge bg-success">Aktif</span>
                            @else
                                <span class="badge bg-danger">Tidak Aktif</span>
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <th>Catatan</th>
                        <td>{{ $serviceRate->notes ?: '-' }}</td>
                    </tr>

                </table>

            </div>

        </div>

    </div>

</x-app-layout>