<x-app>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-white border-bottom">
            <h5 class="mb-0 fw-bold">
                <i class='bx bx-user-plus me-2 text-primary'></i>
                Tambah Penerima Bansos ({{ $bantuanSosial->nama_program }})
            </h5>
        </div>
        <div class="card-body p-4">
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bx bx-error-circle me-1"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <form action="{{ route('penerima-bantuan.store') }}" method="POST">
                @csrf
                <input type="hidden" name="bantuan_sosial_id" value="{{ $bantuanSosial->id }}">
                
                <div class="row g-3">
                    <div class="col-md-12">
                        <label for="warga_id" class="form-label">Pilih Warga (Calon Penerima) <span class="text-danger">*</span></label>
                        <select class="form-select @error('warga_id') is-invalid @enderror" id="warga_id" name="warga_id" required>
                            <option value="">-- Cari NIK atau Nama Warga --</option>
                            @foreach ($wargas as $w)
                                <option value="{{ $w->id }}" {{ old('warga_id') == $w->id ? 'selected' : '' }}>
                                    {{ $w->nik }} - {{ $w->nama }} ({{ $w->alamat }})
                                </option>
                            @endforeach
                        </select>
                        @error('warga_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="status_penerimaan" class="form-label">Status Penerimaan <span class="text-danger">*</span></label>
                        <select class="form-select @error('status_penerimaan') is-invalid @enderror" id="status_penerimaan" name="status_penerimaan" required>
                            <option value="Diusulkan" {{ old('status_penerimaan') == 'Diusulkan' ? 'selected' : '' }}>Diusulkan</option>
                            <option value="Diterima" {{ old('status_penerimaan') == 'Diterima' ? 'selected' : '' }}>Diterima</option>
                            <option value="Ditolak" {{ old('status_penerimaan') == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                        </select>
                        @error('status_penerimaan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="tanggal_terima" class="form-label">Tanggal Terima (Jika Diterima)</label>
                        <input type="date" class="form-control @error('tanggal_terima') is-invalid @enderror" id="tanggal_terima" name="tanggal_terima" value="{{ old('tanggal_terima') }}">
                        @error('tanggal_terima')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-12">
                        <label for="keterangan" class="form-label">Keterangan / Alasan</label>
                        <textarea class="form-control @error('keterangan') is-invalid @enderror" id="keterangan" name="keterangan" rows="3" placeholder="Contoh: Alasan ditolak, atau keterangan tambahan lainnya">{{ old('keterangan') }}</textarea>
                        @error('keterangan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary"><i class="bx bx-save"></i> Simpan Data</button>
                    <a href="{{ route('bantuan-sosial.show', $bantuanSosial->id) }}" class="btn btn-secondary"><i class="bx bx-arrow-back"></i> Batal</a>
                </div>
            </form>
        </div>
    </div>
</x-app>
