<x-app-layout>

    <div class="container-fluid">

        <div class="card shadow-sm">

            
            <div class="card-header d-flex justify-content-between align-items-center">

                <div>
                    <h4 class="mb-0">
                        Detail Psikolog
                    </h4>

                    <small class="text-muted">
                        Informasi lengkap data psikolog
                    </small>

                </div>

                <div class="d-flex gap-2">

                    @if($psychologist->trashed())

                        <form action="{{ route('psychologists.restore', $psychologist->id) }}"
                              method="POST"
                              class="d-inline">

                            @csrf
                            @method('PATCH')

                            <button type="submit"
                                    class="btn btn-success btn-sm"
                                    onclick="return confirm('Pulihkan psikolog ini?')">

                                Restore

                            </button>

                        </form>

                        <a href="{{ route('psychologists.archived') }}"
                           class="btn btn-secondary btn-sm">

                            Kembali

                        </a>

                    @else

                        <a href="{{ route('psychologists.edit', $psychologist) }}"
                           class="btn btn-warning btn-sm">

                            Edit

                        </a>

                        <form action="{{ route('psychologists.destroy', $psychologist) }}"
                              method="POST"
                              class="d-inline">

                            @csrf
                            @method('DELETE')

                            <button type="submit"
                                    class="btn btn-danger btn-sm"
                                    onclick="return confirm('Arsipkan psikolog ini?')">

                                Arsipkan

                            </button>

                        </form>

                        <a href="{{ route('psychologists.index') }}"
                           class="btn btn-secondary btn-sm">

                            Kembali

                        </a>

                    @endif

                </div>

            </div>


            {{-- Body --}}
            <div class="card-body">
                
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