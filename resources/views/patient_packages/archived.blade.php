<x-app-layout>

    <div class="container-fluid">

        {{-- HEADER --}}
        <div class="d-flex justify-content-between align-items-center mb-3">

            <div>
                <h4 class="mb-1">
                    Patient Package Terarsip
                </h4>

                <small class="text-muted">
                    Daftar Patient Package yang telah diarsipkan
                </small>
            </div>

            <a href="{{ route('patient_packages.index') }}"
               class="btn btn-secondary">

                <i class="fas fa-arrow-left"></i>
                Kembali

            </a>

        </div>


        {{-- FLASH MESSAGE --}}
        @if(session('success'))

            <div class="alert alert-success alert-dismissible fade show"
                 role="alert">

                <i class="fas fa-check-circle"></i>

                {{ session('success') }}

                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="alert">
                </button>

            </div>

        @endif


        {{-- TABLE --}}
        <div class="card shadow-sm">

            <div class="card-header">

                <div class="d-flex justify-content-between align-items-center">

                    <h6 class="mb-0">

                        <i class="fas fa-archive"></i>

                        Patient Package Terarsip

                    </h6>

                    <span class="text-muted small">

                        Total:
                        {{ $patientPackages->total() }}

                    </span>

                </div>

            </div>


            <div class="card-body p-0">

                <div class="table-responsive">

                    <table class="table table-hover table-striped align-middle mb-0">

                        <thead class="table-light">

                            <tr>

                                <th width="60">
                                    #
                                </th>

                                <th>
                                    No. Package
                                </th>

                                <th>
                                    Pasien
                                </th>

                                <th>
                                    Paket
                                </th>

                                <th>
                                    Harga
                                </th>

                                <th>
                                    Status
                                </th>

                                <th>
                                    Diarsipkan
                                </th>

                                <th width="100">
                                    Aksi
                                </th>

                            </tr>

                        </thead>


                        <tbody>

                            @forelse(
                                $patientPackages as $index => $patientPackage
                            )

                                <tr>

                                    <td>

                                        {{
                                            $patientPackages->firstItem()
                                            + $index
                                        }}

                                    </td>


                                    <td>

                                        <strong>

                                            {{ $patientPackage->patient_package_no }}

                                        </strong>

                                    </td>


                                    <td>

                                        @if($patientPackage->patient)

                                            {{ $patientPackage->patient->name }}

                                        @else

                                            <span class="text-muted">
                                                -
                                            </span>

                                        @endif

                                    </td>


                                    <td>

                                        @if($patientPackage->servicePackage)

                                            {{ $patientPackage->servicePackage->package_name }}

                                        @else

                                            <span class="text-muted">
                                                -
                                            </span>

                                        @endif

                                    </td>


                                    <td>

                                        {{ $patientPackage->price_label }}

                                    </td>


                                    <td>

                                        <span class="badge bg-secondary">

                                            {{ $patientPackage->status_label }}

                                        </span>

                                    </td>


                                    <td>

                                        {{ $patientPackage->deleted_at?->format('d-m-Y H:i') }}

                                    </td>


                                    <td>

                                        <form method="POST"
                                              action="{{ route(
                                                  'patient_packages.restore',
                                                  $patientPackage->id
                                              ) }}">

                                            @csrf
                                            @method('PATCH')

                                            <button type="submit"
                                                    class="btn btn-sm btn-success"
                                                    title="Restore">

                                                <i class="fas fa-undo"></i>

                                            </button>

                                        </form>

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td colspan="8"
                                        class="text-center text-muted py-4">

                                        <i class="fas fa-archive fa-2x mb-2"></i>

                                        <div>
                                            Tidak ada Patient Package terarsip.
                                        </div>

                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>


            {{-- PAGINATION --}}
            @if($patientPackages->hasPages())

                <div class="card-footer">

                    {{ $patientPackages->links() }}

                </div>

            @endif

        </div>

    </div>

</x-app-layout>