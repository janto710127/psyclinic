<x-app-layout>

    <div class="container-fluid">

        <div class="card shadow-sm">

            {{-- Header --}}
            <div class="card-header d-flex justify-content-between align-items-center">

                <h4 class="mb-0">
                    Tambah Psikolog
                </h4>

                <a href="{{ route('psychologists.index') }}"
                   class="btn btn-secondary">

                    <i class="bi bi-arrow-left"></i>
                    Kembali

                </a>

            </div>

            <div class="card-body">

                <form action="{{ route('psychologists.store') }}"
                      method="POST">

                    @csrf


                    {{-- ================= IDENTITAS ================= --}}

                    <div class="card mb-4">

                        <div class="card-header bg-light">

                            <strong>Identitas</strong>

                        </div>

                        <div class="card-body">

                            <div class="row">

                                <div class="col-md-6 mb-3">

                                    <label class="form-label">
                                        Nama Lengkap Psikolog
                                    </label>

                                    <input type="text"
                                           name="name"
                                           class="form-control"
                                           value="{{ old('name') }}"
                                           required>

                                    @error('name')
                                        <div class="text-danger">
                                            {{ $message }}
                                        </div>
                                    @enderror

                                </div>

                                <div class="col-md-6 mb-3">

                                    <label class="form-label">
                                        Jenis Kelamin
                                    </label>

                                    <select name="gender"
                                            class="form-select"
                                            required>

                                        <option value="">-- Pilih --</option>

                                        <option value="L"
                                            {{ old('gender')=='L' ? 'selected' : '' }}>
                                            Laki-laki
                                        </option>

                                        <option value="P"
                                            {{ old('gender')=='P' ? 'selected' : '' }}>
                                            Perempuan
                                        </option>

                                    </select>

                                </div>

                            </div>

                            <div class="row">

                                <div class="col-md-6 mb-3">

                                    <label class="form-label">
                                        No. HP
                                    </label>

                                    <input type="text"
                                           name="phone"
                                           class="form-control"
                                           value="{{ old('phone') }}">

                                </div>

                                <div class="col-md-6 mb-3">

                                    <label class="form-label">
                                        Email
                                    </label>

                                    <input type="email"
                                           name="email"
                                           class="form-control"
                                           value="{{ old('email') }}"
                                           placeholder="contoh : psikolog@psyclinic.id">

                                </div>

                            </div>

                        </div>

                    </div>


                    {{-- ================= LEGALITAS ================= --}}

                    <div class="card mb-4">

                        <div class="card-header bg-light">

                            <strong>Legalitas</strong>

                        </div>

                        <div class="card-body">

                            <div class="row">

                                <div class="col-md-6 mb-3">

                                    <label class="form-label">
                                        Nomor SIP
                                    </label>

                                    <input type="text"
                                           name="sip_number"
                                           class="form-control"
                                           value="{{ old('sip_number') }}">

                                </div>

                                <div class="col-md-6 mb-3">

                                    <label class="form-label">
                                        Expired SIP
                                    </label>

                                    <input type="date"
                                           name="sip_expired_at"
                                           class="form-control"
                                           value="{{ old('sip_expired_at') }}">

                                </div>

                            </div>

                            <div class="row">

                                <div class="col-md-6 mb-3">

                                    <label class="form-label">
                                        Nomor STR
                                    </label>

                                    <input type="text"
                                           name="str_number"
                                           class="form-control"
                                           value="{{ old('str_number') }}">

                                </div>

                                <div class="col-md-6 mb-3">

                                    <label class="form-label">
                                        Expired STR
                                    </label>

                                    <input type="date"
                                           name="str_expired_at"
                                           class="form-control"
                                           value="{{ old('str_expired_at') }}">

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

                            <div class="row">

                                <div class="col-md-6 mb-3">

                                    <label class="form-label">
                                        Spesialisasi
                                    </label>

                                    <input type="text"
                                           name="specialization"
                                           class="form-control"
                                           value="{{ old('specialization') }}">

                                </div>

                                <div class="col-md-6 mb-3">

                                    <label class="form-label">
                                        Status
                                    </label>

                                    <select name="is_active"
                                            class="form-select">

                                        <option value="1"
                                            {{ old('is_active',1)==1 ? 'selected' : '' }}>
                                            Aktif
                                        </option>

                                        <option value="0"
                                            {{ old('is_active')=='0' ? 'selected' : '' }}>
                                            Tidak Aktif
                                        </option>

                                    </select>

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

                            <textarea name="notes"
                                      class="form-control"
                                      rows="5"
                                      placeholder="Catatan psikolog...">{{ old('notes') }}</textarea>

                        </div>

                    </div>


                    {{-- Tombol --}}

                    <div class="text-end">

                        <button type="submit"
                                class="btn btn-primary">

                            <i class="bi bi-save"></i>
                            Simpan

                        </button>

                        <a href="{{ route('psychologists.index') }}"
                           class="btn btn-secondary">

                            <i class="bi bi-x-circle"></i>
                            Batal

                        </a>

                    </div>

                </form>

            </div>

        </div>

    </div>

</x-app-layout>