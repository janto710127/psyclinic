<x-app-layout>

    <div class="container-fluid">

        {{-- =========================================================
             HEADER
        ========================================================== --}}
        <div class="d-flex justify-content-between align-items-center mb-3">

            <div>
                <h4 class="mb-1">
                    Detail Patient Package
                </h4>

                <small class="text-muted">
                    Informasi paket layanan pasien
                </small>
            </div>

            <div class="d-flex gap-2">

                <a href="{{ route('patient_packages.index') }}"
                   class="btn btn-secondary">

                    <i class="fas fa-arrow-left"></i>
                    Kembali

                </a>

                <a href="{{ route('patient_packages.edit', $patientPackage) }}"
                   class="btn btn-warning">

                    <i class="fas fa-edit"></i>
                    Edit

                </a>

            </div>

        </div>


        {{-- =========================================================
             FLASH MESSAGE
        ========================================================== --}}
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


        {{-- =========================================================
             PACKAGE INFORMATION
        ========================================================== --}}
        <div class="card shadow-sm mb-3">

            <div class="card-header">

                <h6 class="mb-0">
                    <i class="fas fa-box"></i>
                    Informasi Patient Package
                </h6>

            </div>


            <div class="card-body">

                <div class="row">

                    {{-- No Package --}}
                    <div class="col-md-4 mb-3">

                        <div class="text-muted small">
                            No. Package
                        </div>

                        <strong>
                            {{ $patientPackage->patient_package_no }}
                        </strong>

                    </div>


                    {{-- Patient --}}
                    <div class="col-md-4 mb-3">

                        <div class="text-muted small">
                            Pasien
                        </div>

                        @if($patientPackage->patient)

                            <strong>
                                {{ $patientPackage->patient->name }}
                            </strong>

                        @else

                            <span class="text-muted">
                                -
                            </span>

                        @endif

                    </div>


                    {{-- Service Package --}}
                    <div class="col-md-4 mb-3">

                        <div class="text-muted small">
                            Service Package
                        </div>

                        @if($patientPackage->servicePackage)

                            <strong>
                                {{ $patientPackage->servicePackage->package_name }}
                            </strong>

                            <div class="small text-muted">

                                {{ $patientPackage->servicePackage->package_code }}

                            </div>

                        @else

                            <span class="text-muted">
                                -
                            </span>

                        @endif

                    </div>


                    {{-- Price --}}
                    <div class="col-md-4 mb-3">

                        <div class="text-muted small">
                            Harga Paket
                        </div>

                        <strong>
                            {{ $patientPackage->price_label }}
                        </strong>

                    </div>


                    {{-- Purchased --}}
                    <div class="col-md-4 mb-3">

                        <div class="text-muted small">
                            Tanggal Pembelian
                        </div>

                        <strong>

                            {{ $patientPackage->purchased_at?->format('d-m-Y') }}

                        </strong>

                    </div>


                    {{-- Started --}}
                    <div class="col-md-4 mb-3">

                        <div class="text-muted small">
                            Tanggal Mulai
                        </div>

                        <strong>

                            @if($patientPackage->started_at)

                                {{ $patientPackage->started_at->format('d-m-Y') }}

                            @else

                                <span class="text-muted">
                                    Belum mulai
                                </span>

                            @endif

                        </strong>

                    </div>


                    {{-- Expired --}}
                    <div class="col-md-4 mb-3">

                        <div class="text-muted small">
                            Berlaku Sampai
                        </div>

                        <strong>

                            @if($patientPackage->expired_at)

                                {{ $patientPackage->expired_at->format('d-m-Y') }}

                            @else

                                <span class="text-muted">
                                    Tidak terbatas
                                </span>

                            @endif

                        </strong>

                    </div>


                    {{-- Status --}}
                    <div class="col-md-4 mb-3">

                        <div class="text-muted small">
                            Status
                        </div>

                        <span class="badge bg-{{ $patientPackage->status_badge }}">

                            {{ $patientPackage->status_label }}

                        </span>

                    </div>


                    {{-- Notes --}}
                    <div class="col-md-4 mb-3">

                        <div class="text-muted small">
                            Catatan
                        </div>

                        <div>

                            @if($patientPackage->notes)

                                {{ $patientPackage->notes }}

                            @else

                                <span class="text-muted">
                                    -
                                </span>

                            @endif

                        </div>

                    </div>

                </div>

            </div>

        </div>


        <div class="row">

            {{-- =====================================================
                 PACKAGE DETAILS
            ====================================================== --}}
            <div class="col-md-6">

                <div class="card shadow-sm mb-3">

                    <div class="card-header">

                        <h6 class="mb-0">
                            <i class="fas fa-list"></i>
                            Isi Paket
                        </h6>

                    </div>


                    <div class="card-body p-0">

                        <div class="table-responsive">

                            <table class="table table-hover table-striped align-middle mb-0">

                                <thead class="table-light">

                                    <tr>

                                        <th width="50">
                                            #
                                        </th>

                                        <th>
                                            Layanan
                                        </th>

                                        <th width="80"
                                            class="text-center">

                                            Qty

                                        </th>

                                        <th class="text-end">
                                            Harga
                                        </th>

                                        <th class="text-end">
                                            Subtotal
                                        </th>

                                    </tr>

                                </thead>


                                <tbody>

                                    @forelse(
                                        $patientPackage->servicePackage?->details ?? []
                                        as $index => $detail
                                    )

                                        <tr>

                                            <td>
                                                {{ $index + 1 }}
                                            </td>

                                            <td>

                                                @if($detail->serviceRate)

                                                    {{ $detail->serviceRate->service_name }}

                                                @else

                                                    <span class="text-muted">
                                                        -
                                                    </span>

                                                @endif

                                            </td>

                                            <td class="text-center">

                                                {{ $detail->quantity }}

                                            </td>

                                            <td class="text-end">

                                                {{ $detail->price_label }}

                                            </td>

                                            <td class="text-end">

                                                {{ $detail->subtotal_label }}

                                            </td>

                                        </tr>

                                    @empty

                                        <tr>

                                            <td colspan="5"
                                                class="text-center text-muted py-4">

                                                Belum ada detail layanan.

                                            </td>

                                        </tr>

                                    @endforelse

                                </tbody>


                                @if(
                                    $patientPackage->servicePackage &&
                                    $patientPackage->servicePackage->details->count()
                                )

                                    <tfoot class="table-light">

                                        <tr>

                                            <th colspan="4"
                                                class="text-end">

                                                Total Detail

                                            </th>

                                            <th class="text-end">

                                                Rp
                                                {{
                                                    number_format(
                                                        $patientPackage
                                                            ->servicePackage
                                                            ->details
                                                            ->sum('subtotal'),
                                                        0,
                                                        ',',
                                                        '.'
                                                    )
                                                }}

                                            </th>

                                        </tr>

                                    </tfoot>

                                @endif

                            </table>

                        </div>

                    </div>

                </div>

            </div>


            {{-- =====================================================
                 USAGE SUMMARY
            ====================================================== --}}
            <div class="col-md-6">

                <div class="card shadow-sm mb-3">

                    <div class="card-header">

                        <h6 class="mb-0">
                            <i class="fas fa-chart-pie"></i>
                            Ringkasan Pemakaian
                        </h6>

                    </div>


                    <div class="card-body">

                        @if($patientPackage->servicePackage)

                            @foreach(
                                $patientPackage->servicePackage->details
                                as $detail
                            )

                                @php

                                    $usedQuantity =
                                        $patientPackage->usages
                                            ->where(
                                                'service_package_detail_id',
                                                $detail->id
                                            )
                                            ->sum('quantity');

                                    $remainingQuantity =
                                        max(
                                            0,
                                            $detail->quantity -
                                            $usedQuantity
                                        );

                                @endphp


                                <div class="mb-3">

                                    <div class="d-flex justify-content-between">

                                        <strong>

                                            @if($detail->serviceRate)

                                                {{ $detail->serviceRate->service_name }}

                                            @else

                                                Layanan

                                            @endif

                                        </strong>

                                        <span>

                                            {{ $usedQuantity }}
                                            /
                                            {{ $detail->quantity }}

                                        </span>

                                    </div>


                                    <div class="progress mt-1"
                                         style="height: 8px;">

                                        @php

                                            $percentage =
                                                $detail->quantity > 0
                                                    ? min(
                                                        100,
                                                        ($usedQuantity / $detail->quantity) * 100
                                                    )
                                                    : 0;

                                        @endphp

                                        <div class="progress-bar
                                            @if($remainingQuantity <= 0)
                                                bg-success
                                            @else
                                                bg-primary
                                            @endif"
                                            role="progressbar"
                                            style="width: {{ $percentage }}%;">

                                        </div>

                                    </div>


                                    <div class="small text-muted mt-1">

                                        Terpakai:
                                        <strong>
                                            {{ $usedQuantity }}
                                        </strong>

                                        &nbsp;|&nbsp;

                                        Sisa:
                                        <strong>
                                            {{ $remainingQuantity }}
                                        </strong>

                                    </div>

                                </div>

                            @endforeach

                        @else

                            <div class="text-muted text-center py-3">
                                Tidak ada data paket.
                            </div>

                        @endif

                    </div>

                </div>

            </div>

        </div>


        {{-- =========================================================
             USAGE HISTORY
        ========================================================== --}}
        <div class="card shadow-sm mb-3">

            <div class="card-header">

                <h6 class="mb-0">
                    <i class="fas fa-history"></i>
                    Riwayat Pemakaian
                </h6>

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
                                    Tanggal
                                </th>

                                <th>
                                    Layanan
                                </th>

                                <th>
                                    Quantity
                                </th>

                                <th>
                                    Appointment
                                </th>

                                <th>
                                    Harga
                                </th>

                                <th>
                                    Catatan
                                </th>

                            </tr>

                        </thead>


                        <tbody>

                            @forelse(
                                $patientPackage->usages as $index => $usage
                            )

                                <tr>

                                    <td>
                                        {{ $index + 1 }}
                                    </td>


                                    <td>

                                        {{ $usage->used_at?->format('d-m-Y') }}

                                    </td>


                                    <td>

                                        @if($usage->servicePackageDetail?->serviceRate)

                                            {{ $usage->servicePackageDetail->serviceRate->service_name }}

                                        @else

                                            <span class="text-muted">
                                                -
                                            </span>

                                        @endif

                                    </td>


                                    <td>

                                        {{ $usage->quantity }}

                                    </td>


                                    <td>

                                        @if($usage->appointment)

                                            <a href="{{ route(
                                                'appointments.show',
                                                $usage->appointment
                                            ) }}">

                                                {{ $usage->appointment->appointment_no }}

                                            </a>

                                        @else

                                            <span class="text-muted">
                                                -
                                            </span>

                                        @endif

                                    </td>


                                    <td>

                                        {{ $usage->price_label }}

                                    </td>


                                    <td>

                                        @if($usage->notes)

                                            {{ $usage->notes }}

                                        @else

                                            <span class="text-muted">
                                                -
                                            </span>

                                        @endif

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td colspan="7"
                                        class="text-center text-muted py-4">

                                        <i class="fas fa-history fa-2x mb-2"></i>

                                        <div>
                                            Belum ada pemakaian paket.
                                        </div>

                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </div>


        {{-- =========================================================
             ACTION
        ========================================================== --}}
        <div class="card shadow-sm">

            <div class="card-body">

                <div class="d-flex justify-content-end">

                    <form method="POST"
                          action="{{ route(
                              'patient_packages.destroy',
                              $patientPackage
                          ) }}">

                        @csrf
                        @method('DELETE')

                        <button type="submit"
                                class="btn btn-danger"
                                onclick="return confirm('Arsipkan Patient Package ini?')">

                            <i class="fas fa-archive"></i>
                            Arsipkan

                        </button>

                    </form>

                </div>

            </div>

        </div>

    </div>

</x-app-layout>