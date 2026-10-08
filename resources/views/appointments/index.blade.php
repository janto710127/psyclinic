<x-app-layout>
    <div class="container-fluid">

        {{-- Header --}}
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="h4 mb-0">Appointment</h2>

            <a href="{{ route('appointments.create') }}"
               class="btn btn-primary">
                <i class="fas fa-plus"></i>
                Tambah Appointment
            </a>
        </div>

        {{-- Success Message --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}

                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- Filter --}}
        <div class="card shadow-sm mb-3">

            <div class="card-body">

                <form method="GET"
                      action="{{ route('appointments.index') }}">

                    <div class="row g-2">

                        {{-- Search --}}
                        <div class="col-md-4">
                            <input
                                type="text"
                                name="search"
                                class="form-control"
                                placeholder="Cari nomor, patient, atau psychologist..."
                                value="{{ request('search') }}"
                            >
                        </div>

                        {{-- Branch --}}
                        <div class="col-md-2">
                            <select
                                name="branch_id"
                                class="form-select"
                            >
                                <option value="">
                                    -- Semua Branch --
                                </option>

                                @foreach ($branches as $branch)

                                    <option
                                        value="{{ $branch->id }}"
                                        {{ request('branch_id') == $branch->id ? 'selected' : '' }}
                                    >
                                        {{ $branch->branch_code }}
                                        -
                                        {{ $branch->branch_name }}
                                    </option>

                                @endforeach

                            </select>
                        </div>

                        {{-- Date --}}
                        <div class="col-md-2">
                            <input
                                type="date"
                                name="appointment_date"
                                class="form-control"
                                value="{{ request('appointment_date') }}"
                            >
                        </div>

                        {{-- Status --}}
                        <div class="col-md-2">

                            <select
                                name="status"
                                class="form-select"
                            >

                                <option value="">
                                    -- Semua Status --
                                </option>

                                <option value="1"
                                    {{ request('status') == '1' ? 'selected' : '' }}>
                                    Draft
                                </option>

                                <option value="2"
                                    {{ request('status') == '2' ? 'selected' : '' }}>
                                    Reserved
                                </option>

                                <option value="3"
                                    {{ request('status') == '3' ? 'selected' : '' }}>
                                    Checked In
                                </option>

                                <option value="4"
                                    {{ request('status') == '4' ? 'selected' : '' }}>
                                    In Progress
                                </option>

                                <option value="5"
                                    {{ request('status') == '5' ? 'selected' : '' }}>
                                    Completed
                                </option>

                                <option value="6"
                                    {{ request('status') == '6' ? 'selected' : '' }}>
                                    Closed
                                </option>

                                <option value="7"
                                    {{ request('status') == '7' ? 'selected' : '' }}>
                                    Cancelled
                                </option>

                                <option value="8"
                                    {{ request('status') == '8' ? 'selected' : '' }}>
                                    No Show
                                </option>

                            </select>

                        </div>

                        {{-- Search Button --}}
                        <div class="col-md-1">
                            <button
                                type="submit"
                                class="btn btn-primary w-100"
                                title="Cari"
                            >
                            Cari
                                <i class="fas fa-search"></i>
                            </button>
                        </div>

                        {{-- Reset --}}
                        <div class="col-md-1">
                            <a
                                href="{{ route('appointments.index') }}"
                                class="btn btn-secondary w-100"
                                title="Reset"
                            >
                            Reset
                                <i class="fas fa-sync"></i>
                            </a>
                        </div>

                    </div>

                </form>

            </div>
        </div>

        {{-- Summary --}}
        <div class="card shadow-sm mb-3">

            <div class="card-body">

                <strong>Total Appointment:</strong>
                {{ $appointments->total() }}

            </div>

        </div>

        {{-- Table --}}
        <div class="card shadow-sm">

            <div class="card-header d-flex justify-content-between align-items-center">

                <strong>Daftar Appointment</strong>

                <a
                    href="{{ route('appointments.archived') }}"
                    class="btn btn-secondary btn-sm"
                >
                    <i class="fas fa-archive"></i>
                    Arsip
                </a>

            </div>

            <div class="card-body p-0">

                <div class="table-responsive">

                    <table class="table table-hover table-striped align-middle mb-0">

                        <thead class="table-light">

                            <tr>

                                <th width="60">No</th>

                                <th>No. Appointment</th>

                                <th>Tanggal</th>

                                <th>Jam</th>

                                <th>Patient</th>

                                <th>Psychologist</th>

                                <th>Service</th>

                                <th>Branch</th>

                                <th>Status</th>

                                <th width="150">Aksi</th>

                            </tr>

                        </thead>

                        <tbody>

                            @forelse ($appointments as $appointment)

                                <tr>

                                    {{-- No --}}
                                    <td>
                                        {{ $appointments->firstItem() + $loop->index }}
                                    </td>

                                    {{-- Appointment Number --}}
                                    <td>
                                        <strong>
                                            {{ $appointment->appointment_no }}
                                        </strong>
                                    </td>

                                    {{-- Date --}}
                                    <td>
                                        {{ $appointment->appointment_date?->format('d-m-Y') }}
                                    </td>

                                    {{-- Time --}}
                                    <td>
                                        {{ $appointment->appointment_time?->format('H:i') }}
                                    </td>

                                    {{-- Patient --}}
                                    <td>
                                        {{ $appointment->patient->name }}
                                    </td>

                                    {{-- Psychologist --}}
                                    <td>
                                        {{ $appointment->psychologist?->name ?? '-' }}
                                    </td>

                                    {{-- Service --}}
                                    <td>
                                        {{ $appointment->serviceRate->service_name }}
                                    </td>

                                    {{-- Branch --}}
                                    <td>
                                        <strong>
                                            {{ $appointment->branch->branch_code }}
                                        </strong>

                                        <br>

                                        <small class="text-muted">
                                            {{ $appointment->branch->branch_name }}
                                        </small>
                                    </td>

                                    {{-- Status --}}
                                    <td>

                                        <span class="badge bg-{{ $appointment->status_badge }}">
                                            {{ $appointment->status_label }}
                                        </span>

                                    </td>

                                    {{-- Action --}}
                                    <td>

                                        {{-- Detail --}}
                                        <a
                                            href="{{ route('appointments.show', $appointment->id) }}"
                                            class="btn btn-info btn-sm"
                                            title="Detail"
                                        >
                                            <i class="fas fa-eye"></i>
                                        </a>

                                        {{-- Edit --}}
                                        <a
                                            href="{{ route('appointments.edit', $appointment->id) }}"
                                            class="btn btn-warning btn-sm"
                                            title="Edit"
                                        >
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        {{-- Archive --}}
                                        <form
                                            action="{{ route('appointments.destroy', $appointment->id) }}"
                                            method="POST"
                                            class="d-inline"
                                        >
                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="btn btn-danger btn-sm"
                                                title="Arsipkan"
                                            >
                                                <i class="fas fa-archive"></i>
                                            </button>

                                        </form>

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td
                                        colspan="10"
                                        class="text-center py-4 text-muted"
                                    >

                                        <i class="fas fa-calendar-alt fa-2x mb-2"></i>

                                        <div>
                                            Belum ada Appointment.
                                        </div>

                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

            {{-- Pagination --}}
            @if ($appointments->hasPages())

                <div class="card-footer">
                    {{ $appointments->links() }}
                </div>

            @endif

        </div>

    </div>
</x-app-layout>