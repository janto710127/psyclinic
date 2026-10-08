<x-app-layout>

    <div class="container-fluid">

        {{-- Header --}}
        <div class="d-flex justify-content-between align-items-center mb-3">

            <div>

                <h4 class="mb-1">
                    Service Package Terarsip
                </h4>

                <small class="text-muted">
                    Daftar service package yang sudah diarsipkan
                </small>

            </div>

            <a href="{{ route('service_packages.index') }}"
               class="btn btn-secondary">

                <i class="fas fa-arrow-left"></i>
                Kembali

            </a>

        </div>


        {{-- Table --}}
        <div class="card shadow-sm">

            <div class="card-header">

                <strong>
                    <i class="fas fa-archive"></i>
                    Package Terarsip
                </strong>

            </div>


            <div class="card-body">

                <div class="table-responsive">

                    <table class="table table-hover table-striped align-middle">

                        <thead class="table-light">

                            <tr>

                                <th width="5%">
                                    No
                                </th>

                                <th>
                                    Kode
                                </th>

                                <th>
                                    Nama Package
                                </th>

                                <th>
                                    Jumlah Layanan
                                </th>

                                <th>
                                    Harga
                                </th>

                                <th>
                                    Masa Berlaku
                                </th>

                                <th>
                                    Deleted At
                                </th>

                                <th width="15%">
                                    Aksi
                                </th>

                            </tr>

                        </thead>


                        <tbody>

                            @forelse ($servicePackages as $index => $package)

                                <tr>

                                    <td>
                                        {{ $servicePackages->firstItem() + $index }}
                                    </td>

                                    <td>
                                        {{ $package->package_code }}
                                    </td>

                                    <td>
                                        {{ $package->package_name }}
                                    </td>

                                    <td>
                                        {{ $package->details->count() }}
                                        Layanan
                                    </td>

                                    <td>
                                        {{ $package->price_label }}
                                    </td>

                                    <td>
                                        {{ $package->validity_label }}
                                    </td>

                                    <td>
                                        {{ $package->deleted_at->format('d-m-Y H:i') }}
                                    </td>

                                    <td>

                                        <a href="{{ route('service_packages.show', $package->id) }}"
                                           class="btn btn-info btn-sm" >

                                            <i class="fas fa-eye"></i>

                                        </a>


                                        <form
                                            action="{{ route('service_packages.restore', $package->id) }}"
                                            method="POST"
                                            class="d-inline">

                                            @csrf
                                            @method('PATCH')

                                            <button type="submit"
                                                    class="btn btn-success btn-sm"
                                                    onclick="return confirm('Restore paket {{ $package->package_name }} ini?')">

                                                <i class="fas fa-undo"></i>

                                            </button>

                                        </form>

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td colspan="8"
                                        class="text-center text-muted py-4">

                                        Belum ada Service Package yang diarsipkan.

                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>


                {{ $servicePackages->links() }}

            </div>

        </div>

    </div>

</x-app-layout>