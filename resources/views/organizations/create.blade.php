<x-app-layout>

    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="h4 mb-0">
                Tambah Organization
            </h2>

            <a href="{{ route('organizations.index') }}"
               class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i>
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="container-fluid">

        <div class="card shadow-sm">

            <div class="card-header">
                <strong>Form Organization</strong>
            </div>

            <form action="{{ route('organizations.store') }}"
                  method="POST">

                @csrf

                <div class="card-body">

                    {{-- Kode Organization --}}
                    <div class="mb-3">

                        <label class="form-label">
                            Kode Organization
                        </label>

                        <input type="text"
                               class="form-control"
                               value="Otomatis oleh sistem"
                               readonly>

                        <small class="text-muted">
                            Kode akan dibuat otomatis oleh sistem,
                            contoh: ORG0001, ORG0002, dan seterusnya.
                        </small>

                    </div>

                    {{-- Nama Organization --}}
                    <div class="mb-3">

                        <label for="organization_name"
                               class="form-label">
                            Nama Organization
                            <span class="text-danger">*</span>
                        </label>

                        <input type="text"
                               name="organization_name"
                               id="organization_name"
                               class="form-control @error('organization_name') is-invalid @enderror"
                               value="{{ old('organization_name') }}"
                               maxlength="150"
                               required>

                        @error('organization_name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>

                    {{-- Alamat --}}
                    <div class="mb-3">

                        <label for="address"
                               class="form-label">
                            Alamat
                        </label>

                        <textarea name="address"
                                  id="address"
                                  rows="3"
                                  class="form-control @error('address') is-invalid @enderror">{{ old('address') }}</textarea>

                        @error('address')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>

                    <div class="row">

                        {{-- Telepon --}}
                        <div class="col-md-6 mb-3">

                            <label for="phone"
                                   class="form-label">
                                Telepon
                            </label>

                            <input type="text"
                                   name="phone"
                                   id="phone"
                                   class="form-control @error('phone') is-invalid @enderror"
                                   value="{{ old('phone') }}"
                                   maxlength="30">

                            @error('phone')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>

                        {{-- Email --}}
                        <div class="col-md-6 mb-3">

                            <label for="email"
                                   class="form-label">
                                Email
                            </label>

                            <input type="email"
                                   name="email"
                                   id="email"
                                   class="form-control @error('email') is-invalid @enderror"
                                   value="{{ old('email') }}"
                                   maxlength="150">

                            @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>

                    </div>

                    {{-- Status --}}
                    <div class="mb-3">

                        <label for="is_active"
                               class="form-label">
                            Status
                            <span class="text-danger">*</span>
                        </label>

                        <select name="is_active"
                                id="is_active"
                                class="form-select @error('is_active') is-invalid @enderror"
                                required>

                            <option value="1"
                                {{ old('is_active', '1') == '1' ? 'selected' : '' }}>
                                Aktif
                            </option>

                            <option value="0"
                                {{ old('is_active') === '0' ? 'selected' : '' }}>
                                Non Aktif
                            </option>

                        </select>

                        @error('is_active')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>

                    {{-- Catatan --}}
                    <div class="mb-3">

                        <label for="notes"
                               class="form-label">
                            Catatan
                        </label>

                        <textarea name="notes"
                                  id="notes"
                                  rows="3"
                                  class="form-control @error('notes') is-invalid @enderror">{{ old('notes') }}</textarea>

                        @error('notes')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>

                </div>

                <div class="card-footer d-flex justify-content-end gap-2">

                    <a href="{{ route('organizations.index') }}"
                       class="btn btn-secondary">
                        <i class="fas fa-times"></i>
                        Batal
                    </a>

                    <button type="submit"
                            class="btn btn-success">
                        <i class="fas fa-save"></i>
                        Simpan
                    </button>

                </div>

            </form>

        </div>

    </div>

</x-app-layout>