<x-app>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-white border-bottom">
            <h5 class="mb-0 fw-bold">
                <i class='bx bx-edit me-2 text-primary'></i>
                Edit Program Bantuan Sosial
            </h5>
        </div>
        <div class="card-body p-4">
            <form action="{{ route('bantuan-sosial.update', $bantuanSosial->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="nama_program" class="form-label">Nama Program <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('nama_program') is-invalid @enderror" id="nama_program" name="nama_program" value="{{ old('nama_program', $bantuanSosial->nama_program) }}" required>
                        @error('nama_program')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="sumber_dana" class="form-label">Sumber Dana <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('sumber_dana') is-invalid @enderror" id="sumber_dana" name="sumber_dana" value="{{ old('sumber_dana', $bantuanSosial->sumber_dana) }}" required>
                        @error('sumber_dana')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="tahun" class="form-label">Tahun Pelaksanaan <span class="text-danger">*</span></label>
                        <input type="number" class="form-control @error('tahun') is-invalid @enderror" id="tahun" name="tahun" value="{{ old('tahun', $bantuanSosial->tahun) }}" required min="2000">
                        @error('tahun')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                        <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                            <option value="Aktif" {{ old('status', $bantuanSosial->status) == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="Selesai" {{ old('status', $bantuanSosial->status) == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-12">
                        <label for="deskripsi" class="form-label">Deskripsi / Keterangan</label>
                        <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" name="deskripsi" rows="3">{{ old('deskripsi', $bantuanSosial->deskripsi) }}</textarea>
                        @error('deskripsi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary"><i class="bx bx-save"></i> Update Data</button>
                    <a href="{{ route('bantuan-sosial.index') }}" class="btn btn-secondary"><i class="bx bx-arrow-back"></i> Batal</a>
                </div>
            </form>
        </div>
    </div>
</x-app>
