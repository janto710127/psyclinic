<x-app-layout>

    <div class="container-fluid">

        <div class="card">

            <div class="card-header bg-primary text-white">
                Tambah Timeline Pasien
            </div>

            <div class="card-body">

                <div class="mb-3">
                    <strong>Pasien:</strong>
                    {{ $patient->name }}
                </div>

                <form method="POST"
                      action="{{ route('patients.timelines.store', $patient) }}">

                    @csrf

                    <div class="mb-3">
                        <label class="form-label">
                            Tanggal
                        </label>

                        <input type="date"
                               name="timeline_date"
                               class="form-control"
                               value="{{ date('Y-m-d') }}"
                               required>
                    </div>

<div class="mb-3">
    <label class="form-label">
        Jenis Aktivitas
    </label>

    <select name="type"
            class="form-select"
            required>

        <option value="">
            -- Pilih Jenis Aktivitas --
        </option>

        @foreach ($timelineTypes as $type)

            <option value="{{ $type->code }}">
                {{ $type->name }}
            </option>

        @endforeach

    </select>
</div>
                    <div class="mb-3">
                        <label class="form-label">
                            Judul
                        </label>

                        <input type="text"
                               name="title"
                               class="form-control"
                               placeholder="Contoh: Konsultasi Awal"
                               required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">
                            Catatan
                        </label>

                        <textarea name="description"
                                  class="form-control"
                                  rows="5"
                                  placeholder="Catatan timeline pasien"></textarea>
                    </div>

                    <a href="{{ route('patients.show', $patient) }}"
                       class="btn btn-secondary">
                        Batal
                    </a>

                    <button type="submit"
                            class="btn btn-primary">
                        Simpan Timeline
                    </button>

                </form>

            </div>

        </div>

    </div>

</x-app-layout>