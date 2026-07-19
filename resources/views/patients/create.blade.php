<x-app-layout>

    <div class="container-fluid">

        <div class="d-flex justify-content-between align-items-center mb-3">

            <h4>
                Tambah Pasien
            </h4>

            <a href="{{ route('patients.index') }}"
               class="btn btn-secondary">

                Kembali

            </a>

        </div>


        <div class="card">

            <div class="card-header">

                Data Pasien

            </div>


            <div class="card-body">

                <form action="{{ route('patients.store') }}"
                      method="POST">

                    @csrf


                    <div class="mb-3">

                        <label class="form-label">
                            Nama Pasien
                        </label>

                        <input
                            type="text"
                            name="name"
                            class="form-control"
                            value="{{ old('name') }}"
                            required
                        >

                        @error('name')

                            <div class="text-danger">
                                {{ $message }}
                            </div>

                        @enderror

                    </div>


                    <div class="mb-3">

                        <label class="form-label">
                            Jenis Kelamin
                        </label>

                        <select name="gender"
                                class="form-select"
                                required>

                            <option value="">
                                -- Pilih --
                            </option>

                            <option value="L">
                                Laki-laki
                            </option>

                            <option value="P">
                                Perempuan
                            </option>

                        </select>

                        @error('gender')

                            <div class="text-danger">
                                {{ $message }}
                            </div>

                        @enderror

                    </div>


                    <div class="mb-3">

                        <label class="form-label">
                            No. HP
                        </label>

                        <input
                            type="text"
                            name="phone"
                            class="form-control"
                        >

                    </div>


                    <button type="submit"
                            class="btn btn-primary">

                        Simpan Pasien

                    </button>

                </form>

            </div>

        </div>

    </div>

</x-app-layout>