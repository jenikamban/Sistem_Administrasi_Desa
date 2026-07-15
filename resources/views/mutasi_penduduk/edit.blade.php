<x-app>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-white border-bottom">
            <h5 class="mb-0 fw-bold">
                <i class='bx bx-edit me-2 text-primary'></i>
                Edit Mutasi Penduduk
            </h5>
        </div>
        <div class="card-body p-4">
            <form action="{{ route('mutasi-penduduk.update', $mutasiPenduduk->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row g-3">
                    <div class="col-md-12">
                        <label for="warga_id" class="form-label">Pilih Warga <span class="text-danger">*</span></label>
                        <select class="form-select @error('warga_id') is-invalid @enderror" id="warga_id" name="warga_id" required>
                            <option value="">-- Cari NIK atau Nama Warga --</option>
                            @foreach ($wargas as $w)
                                <option value="{{ $w->id }}" {{ old('warga_id', $mutasiPenduduk->warga_id) == $w->id ? 'selected' : '' }}>
                                    {{ $w->nik }} - {{ $w->nama }} ({{ $w->status_keaktifan }})
                                </option>
                            @endforeach
                        </select>
                        @error('warga_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="jenis_mutasi" class="form-label">Jenis Mutasi <span class="text-danger">*</span></label>
                        <select class="form-select @error('jenis_mutasi') is-invalid @enderror" id="jenis_mutasi" name="jenis_mutasi" required>
                            <option value="">Pilih...</option>
                            <option value="Lahir" {{ old('jenis_mutasi', $mutasiPenduduk->jenis_mutasi) == 'Lahir' ? 'selected' : '' }}>Lahir</option>
                            <option value="Meninggal" {{ old('jenis_mutasi', $mutasiPenduduk->jenis_mutasi) == 'Meninggal' ? 'selected' : '' }}>Meninggal</option>
                            <option value="Masuk" {{ old('jenis_mutasi', $mutasiPenduduk->jenis_mutasi) == 'Masuk' ? 'selected' : '' }}>Masuk</option>
                            <option value="Keluar" {{ old('jenis_mutasi', $mutasiPenduduk->jenis_mutasi) == 'Keluar' ? 'selected' : '' }}>Keluar (Pindah)</option>
                        </select>
                        @error('jenis_mutasi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="tanggal_mutasi" class="form-label">Tanggal Kejadian <span class="text-danger">*</span></label>
                        <input type="date" class="form-control @error('tanggal_mutasi') is-invalid @enderror" id="tanggal_mutasi" name="tanggal_mutasi" value="{{ old('tanggal_mutasi', $mutasiPenduduk->tanggal_mutasi) }}" required>
                        @error('tanggal_mutasi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-12">
                        <label for="keterangan" class="form-label">Keterangan / Catatan Tambahan <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('keterangan') is-invalid @enderror" id="keterangan" name="keterangan" rows="3" required placeholder="Contoh: Pindah ke alamat baru di kota lain, atau sebab kematian">{{ old('keterangan', $mutasiPenduduk->keterangan) }}</textarea>
                        @error('keterangan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text text-muted">
                            <i class='bx bx-info-circle'></i> Mencatat mutasi "Meninggal" atau "Keluar" akan secara otomatis menonaktifkan status warga tersebut.
                        </div>
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary"><i class="bx bx-save"></i> Update Data</button>
                    <a href="{{ route('mutasi-penduduk.index') }}" class="btn btn-secondary"><i class="bx bx-arrow-back"></i> Batal</a>
                </div>
            </form>
        </div>
    </div>
</x-app>
