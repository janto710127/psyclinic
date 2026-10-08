<x-app-layout>
    <div class="container-fluid">

        {{-- Header --}}
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="h4 mb-0">Edit Branch</h2>

            <a href="{{ route('branches.show', $branch->id) }}"
               class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i>
                Kembali
            </a>
        </div>

        {{-- Validation Error --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Periksa kembali data berikut:</strong>

                <ul class="mb-0 mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Form --}}
        <div class="card shadow-sm">

            <div class="card-header">
                <strong>Form Edit Branch</strong>
            </div>

            <div class="card-body">

                <form action="{{ route('branches.update', $branch->id) }}"
                      method="POST">

                    @csrf
                    @method('PUT')

                    {{-- Organization --}}
                    <div class="mb-3">
                        <label for="organization_id" class="form-label">
                            Organization <span class="text-danger">*</span>
                        </label>

                        <select
                            name="organization_id"
                            id="organization_id"
                            class="form-select @error('organization_id') is-invalid @enderror"
                            required
                        >

                            <option value="">
                                -- Pilih Organization --
                            </option>

                            @foreach ($organizations as $organization)

                                <option
                                    value="{{ $organization->id }}"
                                    {{ old('organization_id', $branch->organization_id) == $organization->id ? 'selected' : '' }}
                                >
                                    {{ $organization->organization_code }}
                                    -
                                    {{ $organization->organization_name }}
                                </option>

                            @endforeach

                        </select>

                        @error('organization_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                        <div class="form-text">
                            Organization tempat Branch berada.
                        </div>
                    </div>

                    {{-- Branch Code --}}
                    <div class="mb-3">
                        <label for="branch_code" class="form-label">
                            Kode Branch
                        </label>

                        <input
                            type="text"
                            id="branch_code"
                            class="form-control"
                            value="{{ $branch->branch_code }}"
                            readonly
                        >

                        <div class="form-text">
                            Kode Branch dibuat otomatis oleh sistem dan tidak dapat diubah.
                        </div>
                    </div>

                    {{-- Branch Name --}}
                    <div class="mb-3">
                        <label for="branch_name" class="form-label">
                            Nama Branch <span class="text-danger">*</span>
                        </label>

                        <input
                            type="text"
                            name="branch_name"
                            id="branch_name"
                            class="form-control @error('branch_name') is-invalid @enderror"
                            value="{{ old('branch_name', $branch->branch_name) }}"
                            maxlength="150"
                            required
                        >

                        @error('branch_name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- Address --}}
                    <div class="mb-3">
                        <label for="address" class="form-label">
                            Alamat
                        </label>

                        <textarea
                            name="address"
                            id="address"
                            rows="3"
                            class="form-control @error('address') is-invalid @enderror"
                        >{{ old('address', $branch->address) }}</textarea>

                        @error('address')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="row">

                        {{-- Phone --}}
                        <div class="col-md-6 mb-3">

                            <label for="phone" class="form-label">
                                Telepon
                            </label>

                            <input
                                type="text"
                                name="phone"
                                id="phone"
                                class="form-control @error('phone') is-invalid @enderror"
                                value="{{ old('phone', $branch->phone) }}"
                                maxlength="30"
                            >

                            @error('phone')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>

                        {{-- Email --}}
                        <div class="col-md-6 mb-3">

                            <label for="email" class="form-label">
                                Email
                            </label>

                            <input
                                type="email"
                                name="email"
                                id="email"
                                class="form-control @error('email') is-invalid @enderror"
                                value="{{ old('email', $branch->email) }}"
                                maxlength="150"
                            >

                            @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>

                    </div>

                    {{-- Status --}}
                    <div class="mb-3">

                        <label for="is_active" class="form-label">
                            Status <span class="text-danger">*</span>
                        </label>

                        <select
                            name="is_active"
                            id="is_active"
                            class="form-select @error('is_active') is-invalid @enderror"
                            required
                        >

                            <option value="1"
                                {{ old('is_active', $branch->is_active ? '1' : '0') == '1' ? 'selected' : '' }}>
                                Aktif
                            </option>

                            <option value="0"
                                {{ old('is_active', $branch->is_active ? '1' : '0') == '0' ? 'selected' : '' }}>
                                Non Aktif
                            </option>

                        </select>

                        @error('is_active')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>

                    {{-- Notes --}}
                    <div class="mb-3">

                        <label for="notes" class="form-label">
                            Catatan
                        </label>

                        <textarea
                            name="notes"
                            id="notes"
                            rows="3"
                            class="form-control @error('notes') is-invalid @enderror"
                        >{{ old('notes', $branch->notes) }}</textarea>

                        @error('notes')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>

                    {{-- Buttons --}}
                    <div class="d-flex justify-content-end gap-2">

                        <a href="{{ route('branches.show', $branch->id) }}"
                           class="btn btn-secondary">
                            <i class="fas fa-times"></i>
                            Batal
                        </a>

                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save"></i>
                            Simpan Perubahan
                        </button>

                    </div>

                </form>

            </div>
        </div>

    </div>
</x-app-layout>