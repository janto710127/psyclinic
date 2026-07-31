<x-app-layout>

    <div class="container-fluid">

        <div class="card shadow-sm">

            <div class="card-header d-flex justify-content-between align-items-center">

                <div>

                    <h4 class="mb-0">
                        Master Tarif
                    </h4>

                    <small class="text-muted">
                        Kelola tarif layanan klinik
                    </small>

                </div>

                <!--ADD -->
                <a href="{{ route('service_rates.create') }}"
                   class="btn btn-primary">

                    Tambah Tarif

                </a>

            </div>

            <div class="card-body">

                <form method="GET"
                      action="{{ route('service_rates.index') }}"
                      class="row g-2 mb-3">

                    <div class="col-md-8">

                        <input type="text"
                               name="search"
                               class="form-control"
                               placeholder="Cari kode atau nama layanan..."
                               value="{{ $search }}">

                    </div>

                    <div class="col-md-2">

                        <button class="btn btn-primary w-100">

                            Cari

                        </button>

                    </div>

                    <div class="col-md-2">

                        <a href="{{ route('service_rates.index') }}"
                           class="btn btn-secondary w-100">

                            Reset

                        </a>

                    </div>

                </form>

                <div class="mb-3">

                    Total Tarif :

                    <strong>

                        {{ $serviceRates->total() }}

                    </strong>

                </div>

                <div class="table-responsive">

                    <table class="table table-hover table-striped align-middle">

                        <thead class="table-light">

                            <tr>

                                <th width="60">
                                    No
                                </th>

                                <th width="120">
                                    Kode
                                </th>

                                <th>
                                    Nama Layanan
                                </th>

                                <th width="170">
                                    Timeline
                                </th>

                                <th width="150">
                                    Psikolog
                                </th>

                                <th width="100">
                                    Durasi
                                </th>

                                <th width="140">
                                    Tarif
                                </th>

                                <th width="100">
                                    Status
                                </th>

                                <th width="120" class="text-center">
                                    Aksi
                                </th>

                            </tr>

                        </thead>

                        <tbody>

                            @forelse($serviceRates as $serviceRate)

                                <tr>

                                    <td>

                                        {{ $serviceRates->firstItem() + $loop->index }}

                                    </td>

                                    <td>

                                        {{ $serviceRate->service_code }}

                                    </td>

                                    <td>

                                        {{ $serviceRate->service_name }}

                                    </td>

                                    <td>

                                        {{ $serviceRate->timelineType?->name }}

                                    </td>

                                    <td>

                                        {{ $serviceRate->psychologist?->name ?? 'Semua Psikolog' }}

                                    </td>

                                    <td>

                                        {{ $serviceRate->duration }} Menit

                                    </td>

                                    <td>

                                        Rp {{ number_format($serviceRate->price,0,',','.') }}

                                    </td>

                                    <td>

                                        @if($serviceRate->is_active)

                                            <span class="badge bg-success">

                                                Aktif

                                            </span>

                                        @else

                                            <span class="badge bg-secondary">

                                                Non Aktif

                                            </span>

                                        @endif

                                    </td>

                                    <td class="text-center">

                                        <div class="btn-group btn-group-sm">

                                            <a href="{{ route('service_rates.show',$serviceRate) }}"
                                               class="btn btn-info">

                                                Detail

                                            </a>

                                            <a href="{{ route('service_rates.edit',$serviceRate) }}"
                                               class="btn btn-warning">

                                                Edit

                                            </a>

                                        </div>

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td colspan="9"
                                        class="text-center text-muted py-4">

                                        Belum ada data tarif.

                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

                <div class="mt-3">

                    {{ $serviceRates->links() }}

                </div>

            </div>

        </div>

    </div>

</x-app-layout>