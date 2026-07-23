<x-app-layout>

    <div class="container-fluid">

        <div class="d-flex justify-content-between align-items-center mb-3">

            <h4>
                Tambah Psikolog
            </h4>
                    <a href="{{ route('psychologists.index') }}"
                        class="btn btn-secondary">

                        Kembali

                    </a>


        </div>


        <div class="card">

            <div class="card-header">

                Data Psikolog

            </div>


            <div class="card-body">

                <form action="{{ route('psychologists.store') }}"
                      method="POST">

                    @csrf


                    <div class="mb-3">

                        <label class="form-label">
                            Nama 
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

                    <div class="mb-3">

                        <label class="form-label">
                            Email
                        </label>

                        <input type="email"
                                name="email"
                                class="form-control"
                                value="{{ old('email') }}"
                                placeholder="contoh: psikolog@psyclinic.id">

                            @error('email')
                                <div class="text-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                    </div>

                    <div class="mb-3">

                        <label class="form-label">
                            No. SIP
                        </label>

                        <input
                            type="text"
                            name="sip_number"
                            class="form-control"
                        >

                    </div>

                    <div class="mb-3">

                        <label class="form-label">
                            No. STR
                        </label>

                        <input
                            type="text"
                            name="str_number"
                            class="form-control"
                        >

                    </div>
                    <div class="mb-3">

                        <label class="form-label">
                            Spesialisasi
                        </label>

                        <input
                            type="text"
                            name="specialization"
                            class="form-control"
                        >

                    </div>
                   <div class="mb-3">

                        <label class="form-label">
                            Catatan
                        </label>

                        <textarea name="description"
                                  class="form-control"
                                  rows="5"
                                  placeholder="Catatan "></textarea>
                    </div>
                    <div class="mb-3">

                        <label for="is_active" class="form-label">
                            Status
                        </label>

                        <select name="is_active"
                                id="is_active"
                                class="form-select">

                            <option value="1" {{ old('is_active', 1) == 1 ? 'selected' : '' }}>
                                Aktif
                            </option>

                            <option value="0" {{ old('is_active') == '0' ? 'selected' : '' }}>
                                Tidak Aktif
                            </option>

                        </select>

                        @error('is_active')
                            <div class="text-danger">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>


                    <button type="submit"
                            class="btn btn-primary">

                        Simpan Psikolog

                    </button>

                    <a href="{{ route('psychologists.index') }}"
                        class="btn btn-secondary">

                        Batal

                    </a>


                </form>

            </div>

        </div>

    </div>

</x-app-layout>