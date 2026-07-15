<x-app>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-white border-bottom">
            <h5 class="mb-0 fw-bold">
                <i class='bx bx-edit me-2 text-primary'></i>
                Edit Kartu Keluarga
            </h5>
        </div>
        <div class="card-body p-4">
            <form action="{{ route('kartu-keluarga.update', $kartuKeluarga->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="no_kk" class="form-label">Nomor KK <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('no_kk') is-invalid @enderror" id="no_kk" name="no_kk" value="{{ old('no_kk', $kartuKeluarga->no_kk) }}" required placeholder="Masukkan 16 digit No KK">
                        @error('no_kk')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-6">
                        <label for="kode_pos" class="form-label">Kode Pos <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('kode_pos') is-invalid @enderror" id="kode_pos" name="kode_pos" value="{{ old('kode_pos', $kartuKeluarga->kode_pos) }}" required placeholder="Masukkan 5 digit kode pos">
                        @error('kode_pos')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-12">
                        <label for="alamat" class="form-label">Alamat Lengkap <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('alamat') is-invalid @enderror" id="alamat" name="alamat" rows="3" required placeholder="Masukkan alamat lengkap">{{ old('alamat', $kartuKeluarga->alamat) }}</textarea>
                        @error('alamat')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label for="rt" class="form-label">RT <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('rt') is-invalid @enderror" id="rt" name="rt" value="{{ old('rt', $kartuKeluarga->rt) }}" required placeholder="Contoh: 001">
                        @error('rt')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label for="rw" class="form-label">RW <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('rw') is-invalid @enderror" id="rw" name="rw" value="{{ old('rw', $kartuKeluarga->rw) }}" required placeholder="Contoh: 002">
                        @error('rw')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label for="dusun" class="form-label">Dusun <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('dusun') is-invalid @enderror" id="dusun" name="dusun" value="{{ old('dusun', $kartuKeluarga->dusun) }}" required placeholder="Contoh: Dusun Krajan">
                        @error('dusun')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary"><i class="bx bx-save"></i> Update Data</button>
                    <a href="{{ route('kartu-keluarga.index') }}" class="btn btn-secondary"><i class="bx bx-arrow-back"></i> Batal</a>
                </div>
            </form>
        </div>
    </div>
</x-app>
