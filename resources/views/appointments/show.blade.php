@if(session('success'))
    <div class="modal fade"
         id="successModal"
         tabindex="-1"
         aria-labelledby="successModalLabel"
         aria-hidden="true">

        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title" id="successModalLabel">
                        Appointment Berhasil Disimpan
                    </h5>

                    <button type="button"
                            class="btn-close btn-close-white"
                            data-bs-dismiss="modal"
                            aria-label="Close">
                    </button>
                </div>

                <div class="modal-body text-center py-4">

                    <div class="mb-3">
                        <i class="bi bi-check-circle-fill text-success"
                           style="font-size: 60px;">
                        </i>
                    </div>

                    <h5 class="mb-2">
                        Appointment berhasil dibuat
                    </h5>

                    <!-- <p class="text-muted mb-0">
                        {{ session('success') }}
                    </p>
 -->
                </div>

                <div class="modal-footer justify-content-center">

                    <button type="button"
                            class="btn btn-success"
                            data-bs-dismiss="modal">
                        OK
                    </button>

                </div>

            </div>
        </div>
    </div>
@endif

<x-app-layout>
    <div class="container-fluid">

        {{-- Header --}}
        <div class="d-flex justify-content-between align-items-center mb-3">

            <h2 class="h4 mb-0">
                Detail Appointment
            </h2>

            <div>

                <a href="{{ route('appointments.index') }}"
                   class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i>
                    Kembali
                </a>

                @if (!$appointment->trashed())

                    <a href="{{ route('appointments.edit', $appointment->id) }}"
                       class="btn btn-warning">
                        <i class="fas fa-edit"></i>
                        Edit
                    </a>

                @endif

            </div>

        </div>


        {{-- Success Message Alert--}}
        @if (session('success'))

            <div class="alert alert-success alert-dismissible fade show">

                {{ session('success') }}

                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="alert">
                </button>

            </div>

        @endif


        {{-- Appointment Information --}}
        <div class="card shadow-sm mb-3">

            <div class="card-header">
                <strong>Informasi Appointment</strong>
            </div>

            <div class="card-body">

                <div class="table-responsive">

                    <table class="table table-bordered align-middle mb-0">

                        <tbody>

                            {{-- Appointment Number --}}
                            <tr>

                                <th width="220">
                                    No. Appointment
                                </th>

                                <td>
                                    <strong>
                                        {{ $appointment->appointment_no }}
                                    </strong>
                                </td>

                            </tr>


                            {{-- Branch --}}
                            <tr>

                                <th>
                                    Branch
                                </th>

                                <td>

                                    <strong>
                                        {{ $appointment->branch->branch_code }}
                                    </strong>

                                    -
                                    {{ $appointment->branch->branch_name }}

                                </td>

                            </tr>


                            {{-- Organization --}}
                            <tr>

                                <th>
                                    Organization
                                </th>

                                <td>

                                    {{ $appointment->branch->organization->organization_code }}

                                    -

                                    {{ $appointment->branch->organization->organization_name }}

                                </td>

                            </tr>


                            {{-- Patient --}}
                            <tr>

                                <th>
                                    Patient
                                </th>

                                <td>

                                    <strong>
                                        {{ $appointment->patient->name }}
                                    </strong>

                                </td>

                            </tr>


                            {{-- Psychologist --}}
                            <tr>

                                <th>
                                    Psychologist
                                </th>

                                <td>

                                    {{ $appointment->psychologist?->name ?? '-' }}

                                </td>

                            </tr>


                            {{-- Schedule --}}
                            <tr>

                                <th>
                                    Schedule
                                </th>

                                <td>

                                    @if ($appointment->psychologistSchedule)

                                        {{ $appointment->psychologistSchedule->day_of_week }}

                                        <br>

                                        <small class="text-muted">

                                            {{ $appointment->psychologistSchedule->start_time }}
                                            -
                                            {{ $appointment->psychologistSchedule->end_time }}

                                        </small>

                                    @else

                                        -

                                    @endif

                                </td>

                            </tr>


                            {{-- Service --}}
                            <tr>

                                <th>
                                    Service / Layanan
                                </th>

                                <td>

                                    <strong>
                                        {{ $appointment->serviceRate->service_name }}
                                    </strong>

                                </td>

                            </tr>


                            {{-- Price --}}
                            <tr>

                                <th>
                                    Tarif
                                </th>

                                <td>

                                    Rp
                                    {{ number_format(
                                        $appointment->serviceRate->price,
                                        0,
                                        ',',
                                        '.'
                                    ) }}

                                </td>

                            </tr>


                            {{-- Date --}}
                            <tr>

                                <th>
                                    Tanggal
                                </th>

                                <td>

                                    {{ $appointment->appointment_date?->format('d-m-Y') }}

                                </td>

                            </tr>


                            {{-- Time --}}
                            <tr>

                                <th>
                                    Jam
                                </th>

                                <td>

                                    {{ $appointment->appointment_time?->format('H:i') }}

                                </td>

                            </tr>


                            {{-- Status --}}
                            <tr>

                                <th>
                                    Status
                                </th>

                                <td>

                                    @if ($appointment->trashed())

                                        <span class="badge bg-danger">
                                            Diarsipkan
                                        </span>

                                    @else

                                        <span class="badge bg-{{ $appointment->status_badge }}">
                                            {{ $appointment->status_label }}
                                        </span>

                                    @endif

                                </td>

                            </tr>


                            {{-- Notes --}}
                            <tr>

                                <th>
                                    Catatan Operasional
                                </th>

                                <td>

                                    {!! nl2br(e($appointment->notes ?? '-')) !!}

                                </td>

                            </tr>


                            {{-- Created By --}}
                            <tr>

                                <th>
                                    Dibuat Oleh
                                </th>

                                <td>

                                    {{ $appointment->creator?->name ?? '-' }}

                                </td>

                            </tr>


                            {{-- Created At --}}
                            <tr>

                                <th>
                                    Dibuat
                                </th>

                                <td>

                                    {{ $appointment->created_at?->format('d-m-Y H:i') ?? '-' }}

                                </td>

                            </tr>


                            {{-- Updated At --}}
                            <tr>

                                <th>
                                    Terakhir Diubah
                                </th>

                                <td>

                                    {{ $appointment->updated_at?->format('d-m-Y H:i') ?? '-' }}

                                </td>

                            </tr>


                            {{-- Deleted At --}}
                            @if ($appointment->trashed())

                                <tr>

                                    <th>
                                        Diarsipkan
                                    </th>

                                    <td>

                                        {{ $appointment->deleted_at?->format('d-m-Y H:i') ?? '-' }}

                                    </td>

                                </tr>

                            @endif

                        </tbody>

                    </table>

                </div>

            </div>

        </div>


        {{-- Patient Information --}}
        <div class="card shadow-sm mb-3">

            <div class="card-header">
                <strong>Informasi Patient</strong>
            </div>

            <div class="card-body">

                <p class="mb-1">

                    <strong>Nama:</strong>

                    {{ $appointment->patient->name }}

                </p>

                @if (isset($appointment->patient->nik))

                    <p class="mb-1">

                        <strong>NIK:</strong>

                        {{ $appointment->patient->nik }}

                    </p>

                @endif

                <a href="{{ route('patients.show', $appointment->patient->id) }}"
                   class="btn btn-info btn-sm mt-2">

                    <i class="fas fa-user"></i>
                    Detail Patient

                </a>

            </div>

        </div>


        {{-- Action --}}
        @if (!$appointment->trashed())

            <div class="card shadow-sm">

                <div class="card-header">
                    <strong>Aksi Appointment</strong>
                </div>

                <div class="card-body">

                    <form
                        action="{{ route('appointments.destroy', $appointment->id) }}"
                        method="POST"
                        class="d-inline"
                    >

                        @csrf
                        @method('DELETE')

                        <button
                            type="submit"
                            class="btn btn-danger"
                        >

                            <i class="fas fa-archive"></i>

                            Arsipkan Appointment

                        </button>

                    </form>

                </div>

            </div>

        @endif

    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {

                const successModalElement =
                    document.getElementById('successModal');

                if (successModalElement) {

                    const successModal =
                        new bootstrap.Modal(successModalElement);

                    successModal.show();
                }

            });
        </script>
    @endpush
</x-app-layout>