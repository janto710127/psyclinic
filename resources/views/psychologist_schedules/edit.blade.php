<x-app-layout>

    <div class="container-fluid">

        <div class="d-flex justify-content-between align-items-center mb-3">

            <h4>
                Edit Jadwal Praktik
            </h4>
            <a href="{{ route('psychologist_schedules.show',$schedule) }}"
               class="btn btn-secondary">

                Kembali

            </a>

        </div>

        <div class="card">

            <div class="card-header">

                Data Jadwal Praktik

            </div>

            <div class="card-body">

                <form action="{{ route('psychologist_schedules.update',$schedule) }}"
                      method="POST">

                    @csrf
                    @method('PUT')

                    <div class="row">

                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Psikolog
                            </label>

                            <div class="col-md-9">
                                {{ $schedule->psychologist?->name ?? '-' }}
                            </div>


                        </div>

                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Hari
                            </label>

                            <select name="day_of_week"
                                    class="form-select">
                                <option value="">-- Pilih Hari --</option>
                                <option value="1" {{ old('day_of_week', $schedule->day_of_week) == 1 ? 'selected' : '' }}>Senin</option>   
                                <option value="2" {{ old('day_of_week', $schedule->day_of_week) == 2 ? 'selected' : '' }}>Selasa</option>   
                                <option value="3" {{ old('day_of_week', $schedule->day_of_week) == 3 ? 'selected' : '' }}>Rabu</option>   
                                <option value="4" {{ old('day_of_week', $schedule->day_of_week) == 4 ? 'selected' : '' }}>Kamis</option>   
                                <option value="5" {{ old('day_of_week', $schedule->day_of_week) == 5 ? 'selected' : '' }}>Jumat</option>   
                                <option value="6" {{ old('day_of_week', $schedule->day_of_week) == 6 ? 'selected' : '' }}>Sabtu</option>   
                                <option value="7" {{ old('day_of_week', $schedule->day_of_week) == 7 ? 'selected' : '' }}>Minggu</option>   

                            </select>

                        </div>

                    </div>


                    <div class="row">

                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Jam Mulai
                            </label>
                            <!-- jika menggunakan accessor inputnya gunakan seperti yang di remark dibawah -->
                            <!-- value="{{ old('start_time', $schedule->start_time_for_input) }}" -->
                            <input type="time"
                                   name="start_time"
                                   class="form-control"
                                    value="{{ old('start_time', $schedule->start_time->format('H:i')) }}">                        </div>

                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Jam Selesai
                            </label>

                            <input type="time"
                                   name="end_time"
                                   class="form-control"
                                    value="{{ old('end_time', $schedule->end_time->format('H:i')) }}">                                   required>

                        </div>

                    </div>


                    <div class="row">

                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Durasi Slot
                            </label>

                            <select name="slot_duration" class="form-select">

                                <option value="30"
                                    {{ old('slot_duration', $schedule->slot_duration) == 30 ? 'selected' : '' }}>
                                    30 Menit
                                </option>

                                <option value="45"
                                    {{ old('slot_duration', $schedule->slot_duration) == 45 ? 'selected' : '' }}>
                                    45 Menit
                                </option>

                                <option value="60"
                                    {{ old('slot_duration', $schedule->slot_duration) == 60 ? 'selected' : '' }}>
                                    60 Menit
                                </option>

                                <option value="90"
                                    {{ old('slot_duration', $schedule->slot_duration) == 90 ? 'selected' : '' }}>
                                    90 Menit
                                </option>

                                <option value="120"
                                    {{ old('slot_duration', $schedule->slot_duration) == 120 ? 'selected' : '' }}>
                                    120 Menit
                                </option>

                            </select>

                        </div>

                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Status
                            </label>

                            <select name="is_active"
                                    class="form-select" 
                                    value="{{ old('is_active',$schedule->is_active) }}" >
                                    >

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
                                  rows="4">{{ old('notes',$schedule->notes) }}</textarea>

                    </div>


                    <button type="submit"
                            class="btn btn-primary">

                        Update Jadwal Praktik

                    </button>

                    <a href="{{ route('psychologist_schedules.show',$schedule) }}"
                       class="btn btn-secondary">

                        Batal

                    </a>

                </form>

            </div>

        </div>

    </div>

</x-app-layout>