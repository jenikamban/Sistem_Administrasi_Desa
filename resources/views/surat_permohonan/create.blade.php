<x-app>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-white border-bottom">
            <h5 class="mb-0 fw-bold">
                <i class='bx bx-edit-alt me-2 text-primary'></i>
                Buat Pengajuan Surat Baru
            </h5>
        </div>
        <div class="card-body p-4">
            <form action="{{ route('surat-permohonan.store') }}" method="POST">
                @csrf
                <div class="row g-3">
                    <div class="col-md-12">
                        <label for="warga_id" class="form-label">Pemohon (Warga) <span class="text-danger">*</span></label>
                        <select class="form-select @error('warga_id') is-invalid @enderror" id="warga_id" name="warga_id" required>
                            <option value="">-- Pilih Pemohon --</option>
                            @foreach ($wargas as $warga)
                                <option value="{{ $warga->id }}" {{ old('warga_id') == $warga->id ? 'selected' : '' }}>
                                    {{ $warga->nik }} - {{ $warga->nama }}
                                </option>
                            @endforeach
                        </select>
                        @error('warga_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-12">
                        <label for="jenis_surat" class="form-label">Jenis Surat <span class="text-danger">*</span></label>
                        <select class="form-select @error('jenis_surat') is-invalid @enderror" id="jenis_surat" name="jenis_surat" required>
                            <option value="">-- Pilih Jenis Surat --</option>
                            <option value="Keterangan Domisili" {{ old('jenis_surat') == 'Keterangan Domisili' ? 'selected' : '' }}>Keterangan Domisili</option>
                            <option value="Keterangan Tidak Mampu" {{ old('jenis_surat') == 'Keterangan Tidak Mampu' ? 'selected' : '' }}>Keterangan Tidak Mampu</option>
                            <option value="Keterangan Usaha" {{ old('jenis_surat') == 'Keterangan Usaha' ? 'selected' : '' }}>Keterangan Usaha</option>
                            <option value="Pengantar SKCK" {{ old('jenis_surat') == 'Pengantar SKCK' ? 'selected' : '' }}>Pengantar SKCK</option>
                        </select>
                        @error('jenis_surat')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-12">
                        <label for="keperluan" class="form-label">Keperluan Pengajuan <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('keperluan') is-invalid @enderror" id="keperluan" name="keperluan" rows="4" required placeholder="Jelaskan keperluan dari surat ini secara detail...">{{ old('keperluan') }}</textarea>
                        @error('keperluan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text text-muted">
                            Pastikan alasan / keperluan dicantumkan dengan jelas untuk memudahkan proses verifikasi oleh perangkat desa.
                        </div>
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary"><i class="bx bx-paper-plane"></i> Ajukan Surat</button>
                    <a href="{{ route('surat-permohonan.index') }}" class="btn btn-secondary"><i class="bx bx-arrow-back"></i> Batal</a>
                </div>
            </form>
        </div>
    </div>
</x-app>
