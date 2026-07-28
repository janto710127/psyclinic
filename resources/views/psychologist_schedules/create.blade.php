<x-app-layout>

    <div class="container-fluid">

        <div class="d-flex justify-content-between align-items-center mb-3">

            <h4>
                Tambah Jadwal Praktik
            </h4>

            <a href="{{ route('psychologist_schedules.index') }}"
               class="btn btn-secondary">

                Kembali

            </a>

        </div>

        <div class="card">

            <div class="card-header">

                Data Jadwal Praktik

            </div>

            <div class="card-body">

                <form action="{{ route('psychologist_schedules.store') }}"
                      method="POST">

                    @csrf

                    <div class="row">

                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Psikolog
                            </label>

                            <select name="psychologist_id"
                                    class="form-select"
                                    required>

                                <option value="">
                                    -- Pilih Psikolog --
                                </option>

                                @foreach($psychologists as $psychologist)

                                    <option value="{{ $psychologist->id }}"
                                        {{ old('psychologist_id') == $psychologist->id ? 'selected' : '' }}>

                                        {{ $psychologist->name }}

                                    </option>

                                @endforeach

                            </select>

                        </div>

                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Hari
                            </label>

                            <select name="day_of_week"
                                    class="form-select"
                                    required>

                                <option value="">-- Pilih Hari --</option>
                                <option value="1">Senin</option>
                                <option value="2">Selasa</option>
                                <option value="3">Rabu</option>
                                <option value="4">Kamis</option>
                                <option value="5">Jumat</option>
                                <option value="6">Sabtu</option>
                                <option value="7">Minggu</option>

                            </select>

                        </div>

                    </div>


                    <div class="row">

                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Jam Mulai
                            </label>

                            <input type="time"
                                   name="start_time"
                                   class="form-control"
                                   value="{{ old('start_time') }}"
                                   required>

                        </div>

                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Jam Selesai
                            </label>

                            <input type="time"
                                   name="end_time"
                                   class="form-control"
                                   value="{{ old('end_time') }}"
                                   required>

                        </div>

                    </div>


                    <div class="row">

                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Durasi Slot
                            </label>

                            <select name="slot_duration"
                                    class="form-select">

                                <option value="30">30 Menit</option>
                                <option value="45">45 Menit</option>
                                <option value="60" selected>60 Menit</option>
                                <option value="90">90 Menit</option>
                                <option value="120">120 Menit</option>

                            </select>

                        </div>

                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Status
                            </label>

                            <select name="is_active"
                                    class="form-select">

                                <option value="1">Aktif</option>
                                <option value="0">Tidak Aktif</option>

                            </select>

                        </div>

                    </div>


                    <div class="mb-3">

                        <label class="form-label">
                            Catatan
                        </label>

                        <textarea name="notes"
                                  class="form-control"
                                  rows="4">{{ old('notes') }}</textarea>

                    </div>


                    <button type="submit"
                            class="btn btn-primary">

                        Simpan Jadwal Praktik

                    </button>

                    <a href="{{ route('psychologist_schedules.index') }}"
                       class="btn btn-secondary">

                        Batal

                    </a>

                </form>

            </div>

        </div>

    </div>

</x-app-layout>