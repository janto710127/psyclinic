<x-app-layout>

    <div class="container-fluid">

        <div class="card shadow-sm">

            {{-- Header --}}
            <div class="card-header">
                <h4 class="mb-0">
                    Profil Psikolog
                </h4>
            </div>

            {{-- Body --}}
            <div class="card-body">

                {{-- Toolbar --}}
                <div class="d-flex justify-content-end mb-4">

                    <a href="{{ route('psychologists.edit', $psychologist) }}"
                       class="btn btn-warning me-2">
                        Edit
                    </a>

                    <form action="{{ route('psychologists.destroy', $psychologist) }}"
                          method="POST"
                          class="me-2"
                          onsubmit="return confirm('Yakin ingin mengarsipkan psikolog ini?')">

                        @csrf
                        @method('DELETE')

                        <button type="submit"
                                class="btn btn-danger">
                            Arsipkan
                        </button>

                    </form>

                    <a href="{{ route('psychologists.index') }}"
                       class="btn btn-secondary">
                        Kembali
                    </a>

                </div>

                {{-- ================= IDENTITAS ================= --}}

                <div class="card mb-4">

                    <div class="card-header bg-light">
                        <strong>Identitas</strong>
                    </div>

                    <div class="card-body">

                        <div class="row mb-3">
                            <div class="col-md-3 text-muted">
                                Kode Psikolog
                            </div>
                            <div class="col-md-9">
                                {{ $psychologist->psychologist_code }}
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-3 text-muted">
                                Nama
                            </div>
                            <div class="col-md-9">
                                {{ $psychologist->name }}
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-3 text-muted">
                                Jenis Kelamin
                            </div>
                            <div class="col-md-9">
                                {{ $psychologist->gender }}
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-3 text-muted">
                                No. HP
                            </div>
                            <div class="col-md-9">
                                {{ $psychologist->phone ?? '-' }}
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3 text-muted">
                                Email
                            </div>
                            <div class="col-md-9">
                                {{ $psychologist->email ?? '-' }}
                            </div>
                        </div>

                    </div>

                </div>


                {{-- ================= LEGALIITAS ================= --}}

                <div class="card mb-4">

                    <div class="card-header bg-light">
                        <strong>Legalitas</strong>
                    </div>

                    <div class="card-body">

                        <div class="row mb-3">
                            <div class="col-md-3 text-muted">
                                Nomor SIP
                            </div>
                            <div class="col-md-9">
                                {{ $psychologist->sip_number ?? '-' }}
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-3 text-muted">
                                Expired SIP
                            </div>
                            <div class="col-md-9">

                                {{ $psychologist->sip_expired_at?->format('d-m-Y') ?? '-' }}

                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-3 text-muted">
                                Nomor STR
                            </div>
                            <div class="col-md-9">
                                {{ $psychologist->str_number ?? '-' }}
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3 text-muted">
                                Expired STR
                            </div>
                            <div class="col-md-9">

                                {{ $psychologist->str_expired_at?->format('d-m-Y') ?? '-' }}

                            </div>
                        </div>

                    </div>

                </div>


                {{-- ================= PROFESIONAL ================= --}}

                <div class="card mb-4">

                    <div class="card-header bg-light">
                        <strong>Profesional</strong>
                    </div>

                    <div class="card-body">

                        <div class="row mb-3">

                            <div class="col-md-3 text-muted">
                                Spesialisasi
                            </div>

                            <div class="col-md-9">
                                {{ $psychologist->specialization ?? '-' }}
                            </div>

                        </div>

                        <div class="row">

                            <div class="col-md-3 text-muted">
                                Status
                            </div>

                            <div class="col-md-9">

                                @if($psychologist->is_active)

                                    <span class="badge bg-success rounded-pill px-3 py-2">

                                        Aktif

                                    </span>

                                @else

                                    <span class="badge bg-secondary rounded-pill px-3 py-2">

                                        Tidak Aktif

                                    </span>

                                @endif

                            </div>

                        </div>

                    </div>

                </div>


                {{-- ================= CATATAN ================= --}}

                <div class="card mb-4">

                    <div class="card-header bg-light">

                        <strong>Catatan</strong>

                    </div>

                    <div class="card-body">

                        {{ $psychologist->notes ?: '-' }}

                    </div>

                </div>


                {{-- ================= INFORMASI SISTEM ================= --}}

                <div class="card">

                    <div class="card-header bg-light">

                        <strong>Informasi Sistem</strong>

                    </div>

                    <div class="card-body">

                        <div class="row mb-3">

                            <div class="col-md-3 text-muted">

                                Dibuat

                            </div>

                            <div class="col-md-9">

                                {{ $psychologist->created_at->format('d-m-Y H:i') }}

                            </div>

                        </div>

                        <div class="row">

                            <div class="col-md-3 text-muted">

                                Terakhir Diubah

                            </div>

                            <div class="col-md-9">

                                {{ $psychologist->updated_at->format('d-m-Y H:i') }}

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</x-app-layout>