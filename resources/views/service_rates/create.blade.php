<x-app-layout>

    <div class="container-fluid">

        <div class="d-flex justify-content-between align-items-center mb-3">

            <div>

                <h4 class="mb-0">
                    Tambah Tarif Layanan
                </h4>

                <small class="text-muted">
                    Tambahkan tarif layanan yang akan digunakan pada Appointment.
                </small>

            </div>

            <a href="{{ route('service_rates.index') }}"
               class="btn btn-secondary">

                Kembali

            </a>

        </div>

        <div class="card shadow-sm">

            <div class="card-header">

                Informasi Tarif Layanan

            </div>

            <div class="card-body">

                <form action="{{ route('service_rates.store') }}"
                      method="POST">

                    @csrf

                    <div class="row">

                        {{-- Kode --}}
                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Kode Layanan
                            </label>

                            <input type="text"
                                   class="form-control"
                                   value="Otomatis dibuat sistem"
                                   readonly>

                        </div>

                        {{-- Timeline --}}
                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Timeline Type
                            </label>

                            <select name="timeline_type_id"
                                    class="form-select"
                                    required>

                                <option value="">
                                    -- Pilih Timeline --
                                </option>

                                @foreach($timelineTypes as $timelineType)

                                    <option value="{{ $timelineType->id }}"
                                        {{ old('timeline_type_id') == $timelineType->id ? 'selected' : '' }}>

                                        {{ $timelineType->name }}

                                    </option>

                                @endforeach

                            </select>

                        </div>

                    </div>

                    <div class="row">

                        {{-- Nama Layanan --}}
                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Nama Layanan
                            </label>

                            <input type="text"
                                   name="service_name"
                                   class="form-control"
                                   value="{{ old('service_name') }}"
                                   required>

                        </div>

                        {{-- Psikolog --}}
                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Psikolog
                            </label>

                            <select name="psychologist_id"
                                    class="form-select">

                                <option value="">
                                    Semua Psikolog
                                </option>

                                @foreach($psychologists as $psychologist)

                                    <option value="{{ $psychologist->id }}"
                                        {{ old('psychologist_id') == $psychologist->id ? 'selected' : '' }}>

                                        {{ $psychologist->name }}

                                    </option>

                                @endforeach

                            </select>

                        </div>

                    </div>

                    <div class="row">

                        {{-- Durasi --}}
                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Durasi (Menit)
                            </label>

                            <select name="duration"
                                    class="form-select">

                                <option value="30">30 Menit</option>
                                <option value="45">45 Menit</option>
                                <option value="60" selected>60 Menit</option>
                                <option value="90">90 Menit</option>
                                <option value="120">120 Menit</option>

                            </select>

                        </div>

                        {{-- Tarif --}}
                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Tarif
                            </label>

                            <input type="number"
                                   name="price"
                                   class="form-control"
                                   value="{{ old('price') }}"
                                   min="0"
                                   required>

                        </div>

                    </div>

                    <div class="row">

                        {{-- Status --}}
                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Status
                            </label>

                            <select name="is_active"
                                    class="form-select">

                                <option value="1" selected>
                                    Aktif
                                </option>

                                <option value="0">
                                    Tidak Aktif
                                </option>

                            </select>

                        </div>

                    </div>

                    {{-- Catatan --}}
                    <div class="mb-3">

                        <label class="form-label">
                            Catatan
                        </label>

                        <textarea name="notes"
                                  rows="4"
                                  class="form-control">{{ old('notes') }}</textarea>

                    </div>

                    <hr>

                    <button type="submit"
                            class="btn btn-primary">

                        Simpan Tarif

                    </button>

                    <a href="{{ route('service_rates.index') }}"
                       class="btn btn-secondary">

                        Batal

                    </a>

                </form>

            </div>

        </div>

    </div>

</x-app-layout>