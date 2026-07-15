<x-app>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-white border-bottom">
            <h5 class="mb-0 fw-bold">
                <i class='bx bx-edit me-2 text-primary'></i>
                Edit Status Penerima Bansos
            </h5>
        </div>
        <div class="card-body p-4">
            <form action="{{ route('penerima-bantuan.update', $penerimaBantuan->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="row g-3">
                    <div class="col-md-12">
                        <label class="form-label">Program Bantuan Sosial</label>
                        <input type="text" class="form-control" value="{{ $penerimaBantuan->bantuanSosial->nama_program }}" readonly disabled>
                    </div>

                    <div class="col-md-12">
                        <label class="form-label">Warga (Penerima)</label>
                        <input type="text" class="form-control" value="{{ $penerimaBantuan->warga->nik }} - {{ $penerimaBantuan->warga->nama }}" readonly disabled>
                    </div>

                    <div class="col-md-6">
                        <label for="status_penerimaan" class="form-label">Status Penerimaan <span class="text-danger">*</span></label>
                        <select class="form-select @error('status_penerimaan') is-invalid @enderror" id="status_penerimaan" name="status_penerimaan" required>
                            <option value="Diusulkan" {{ old('status_penerimaan', $penerimaBantuan->status_penerimaan) == 'Diusulkan' ? 'selected' : '' }}>Diusulkan</option>
                            <option value="Diterima" {{ old('status_penerimaan', $penerimaBantuan->status_penerimaan) == 'Diterima' ? 'selected' : '' }}>Diterima</option>
                            <option value="Ditolak" {{ old('status_penerimaan', $penerimaBantuan->status_penerimaan) == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                        </select>
                        @error('status_penerimaan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="tanggal_terima" class="form-label">Tanggal Terima (Jika Diterima)</label>
                        <input type="date" class="form-control @error('tanggal_terima') is-invalid @enderror" id="tanggal_terima" name="tanggal_terima" value="{{ old('tanggal_terima', $penerimaBantuan->tanggal_terima) }}">
                        @error('tanggal_terima')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-12">
                        <label for="keterangan" class="form-label">Keterangan / Alasan</label>
                        <textarea class="form-control @error('keterangan') is-invalid @enderror" id="keterangan" name="keterangan" rows="3">{{ old('keterangan', $penerimaBantuan->keterangan) }}</textarea>
                        @error('keterangan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary"><i class="bx bx-save"></i> Update Data</button>
                    <a href="{{ route('bantuan-sosial.show', $penerimaBantuan->bantuan_sosial_id) }}" class="btn btn-secondary"><i class="bx bx-arrow-back"></i> Batal</a>
                </div>
            </form>
        </div>
    </div>
</x-app>
