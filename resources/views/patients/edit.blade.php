<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Profil Pasien
        </h2>
    </x-slot>

    <div class="py-6">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                <div class="p-6 text-gray-900">

                    <div class="d-flex justify-content-between align-items-center mb-4">

                        <h4>Edit Profil Pasien</h4>

                        <a href="{{ route('patients.show', $patient) }}"
                           class="btn btn-secondary">

                            Kembali

                        </a>

                    </div>


                    <form action="{{ route('patients.update', $patient) }}"
                          method="POST">

                        @csrf

                        @method('PUT')


                        <div class="row">


                            <div class="col-md-6 mb-3">

                                <label class="form-label">
                                    No. Pasien
                                </label>

                                <input type="text"
                                       class="form-control"
                                       value="{{ $patient->patient_number }}"
                                       disabled>

                            </div>


                            <div class="col-md-6 mb-3">

                                <label class="form-label">
                                    Nama Pasien
                                </label>

                                <input type="text"
                                       name="name"
                                       class="form-control"
                                       value="{{ old('name', $patient->name) }}"
                                       required>

                            </div>


                            <div class="col-md-6 mb-3">

                                <label class="form-label">
                                    Jenis Kelamin
                                </label>

                                <select name="gender"
                                        class="form-select"
                                        required>

                                    <option value="L"
                                        {{ $patient->gender == 'L' ? 'selected' : '' }}>

                                        Laki-laki

                                    </option>

                                    <option value="P"
                                        {{ $patient->gender == 'P' ? 'selected' : '' }}>

                                        Perempuan

                                    </option>

                                </select>

                            </div>


                            <div class="col-md-6 mb-3">

                                <label class="form-label">
                                    Tanggal Lahir
                                </label>

                                <input type="date"
                                       name="birth_date"
                                       class="form-control"
                                       value="{{ old('birth_date', $patient->birth_date?->format('Y-m-d')) }}">

                            </div>


                            <div class="col-md-6 mb-3">

                                <label class="form-label">
                                    No. HP
                                </label>

                                <input type="text"
                                       name="phone"
                                       class="form-control"
                                       value="{{ old('phone', $patient->phone) }}">

                            </div>


                            <div class="col-md-6 mb-3">

                                <label class="form-label">
                                    Email
                                </label>

                                <input type="email"
                                       name="email"
                                       class="form-control"
                                       value="{{ old('email', $patient->email) }}">

                            </div>


                            <div class="col-md-6 mb-3">

                                <label class="form-label">
                                    Pekerjaan
                                </label>

                                <input type="text"
                                       name="occupation"
                                       class="form-control"
                                       value="{{ old('occupation', $patient->occupation) }}">

                            </div>


                            <div class="col-md-6 mb-3">

                                <label class="form-label">
                                    Pendidikan
                                </label>

                                <input type="text"
                                       name="education"
                                       class="form-control"
                                       value="{{ old('education', $patient->education) }}">

                            </div>


                            <div class="col-md-6 mb-3">

                                <label class="form-label">
                                    Status Pernikahan
                                </label>

                                <select name="marital_status"
                                        class="form-select">

                                    <option value="">
                                        -- Pilih --
                                    </option>

                                    <option value="Belum Menikah"
                                        {{ $patient->marital_status == 'Belum Menikah' ? 'selected' : '' }}>

                                        Belum Menikah

                                    </option>

                                    <option value="Menikah"
                                        {{ $patient->marital_status == 'Menikah' ? 'selected' : '' }}>

                                        Menikah

                                    </option>

                                    <option value="Cerai"
                                        {{ $patient->marital_status == 'Cerai' ? 'selected' : '' }}>

                                        Cerai

                                    </option>

                                </select>

                            </div>


                            <div class="col-md-6 mb-3">

                                <label class="form-label">
                                    Kontak Darurat
                                </label>

                                <input type="text"
                                       name="emergency_contact_name"
                                       class="form-control"
                                       value="{{ old('emergency_contact_name', $patient->emergency_contact_name) }}">

                            </div>


                            <div class="col-md-6 mb-3">

                                <label class="form-label">
                                    No. Kontak Darurat
                                </label>

                                <input type="text"
                                       name="emergency_contact_phone"
                                       class="form-control"
                                       value="{{ old('emergency_contact_phone', $patient->emergency_contact_phone) }}">

                            </div>


                            <div class="col-12 mb-3">

                                <label class="form-label">
                                    Catatan
                                </label>

                                <textarea name="notes"
                                          class="form-control"
                                          rows="4">{{ old('notes', $patient->notes) }}</textarea>

                            </div>

                        </div>


                        <button type="submit"
                                class="btn btn-primary">

                            Simpan Perubahan

                        </button>

                    </form>

                </div>

            </div>

        </div>

    </div>

</x-app-layout>