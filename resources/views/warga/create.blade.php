<x-app>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-white border-bottom">
            <h5 class="mb-0 fw-bold">
                <i class='bx bx-user-plus me-2 text-primary'></i>
                Tambah Data Warga
            </h5>
        </div>
        <div class="card-body p-4">
            <form action="{{ route('warga.store') }}" method="POST">
                @csrf
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="kartu_keluarga_id" class="form-label">Tautkan ke Kartu Keluarga (Opsional)</label>
                        <select class="form-select @error('kartu_keluarga_id') is-invalid @enderror" id="kartu_keluarga_id" name="kartu_keluarga_id">
                            <option value="">-- Pilih Kartu Keluarga --</option>
                            @foreach ($kartuKeluargas as $kk)
                                <option value="{{ $kk->id }}" {{ old('kartu_keluarga_id') == $kk->id ? 'selected' : '' }}>
                                    {{ $kk->no_kk }} - {{ $kk->kepalaKeluarga ? $kk->kepalaKeluarga->nama : 'Tanpa Kepala' }}
                                </option>
                            @endforeach
                        </select>
                        @error('kartu_keluarga_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="nik" class="form-label">NIK <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('nik') is-invalid @enderror" id="nik" name="nik" value="{{ old('nik') }}" required placeholder="16 Digit NIK">
                        @error('nik')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="nama" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" value="{{ old('nama') }}" required placeholder="Nama Lengkap">
                        @error('nama')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-3">
                        <label for="tempat_lahir" class="form-label">Tempat Lahir <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('tempat_lahir') is-invalid @enderror" id="tempat_lahir" name="tempat_lahir" value="{{ old('tempat_lahir') }}" required>
                        @error('tempat_lahir')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-3">
                        <label for="tanggal_lahir" class="form-label">Tanggal Lahir <span class="text-danger">*</span></label>
                        <input type="date" class="form-control @error('tanggal_lahir') is-invalid @enderror" id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" required>
                        @error('tanggal_lahir')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-3">
                        <label for="jenis_kelamin" class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                        <select class="form-select @error('jenis_kelamin') is-invalid @enderror" id="jenis_kelamin" name="jenis_kelamin" required>
                            <option value="">Pilih...</option>
                            <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                        @error('jenis_kelamin')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-3">
                        <label for="agama" class="form-label">Agama <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('agama') is-invalid @enderror" id="agama" name="agama" value="{{ old('agama') }}" required>
                        @error('agama')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-3">
                        <label for="status_perkawinan" class="form-label">Status Perkawinan <span class="text-danger">*</span></label>
                        <select class="form-select @error('status_perkawinan') is-invalid @enderror" id="status_perkawinan" name="status_perkawinan" required>
                            <option value="">Pilih...</option>
                            <option value="Belum Kawin" {{ old('status_perkawinan') == 'Belum Kawin' ? 'selected' : '' }}>Belum Kawin</option>
                            <option value="Kawin" {{ old('status_perkawinan') == 'Kawin' ? 'selected' : '' }}>Kawin</option>
                            <option value="Cerai Hidup" {{ old('status_perkawinan') == 'Cerai Hidup' ? 'selected' : '' }}>Cerai Hidup</option>
                            <option value="Cerai Mati" {{ old('status_perkawinan') == 'Cerai Mati' ? 'selected' : '' }}>Cerai Mati</option>
                        </select>
                        @error('status_perkawinan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-3">
                        <label for="pekerjaan" class="form-label">Pekerjaan <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('pekerjaan') is-invalid @enderror" id="pekerjaan" name="pekerjaan" value="{{ old('pekerjaan') }}" required>
                        @error('pekerjaan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-12">
                        <label for="alamat" class="form-label">Alamat Lengkap <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('alamat') is-invalid @enderror" id="alamat" name="alamat" rows="2" required>{{ old('alamat') }}</textarea>
                        @error('alamat')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label for="rt" class="form-label">RT <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('rt') is-invalid @enderror" id="rt" name="rt" value="{{ old('rt') }}" required>
                        @error('rt')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label for="rw" class="form-label">RW <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('rw') is-invalid @enderror" id="rw" name="rw" value="{{ old('rw') }}" required>
                        @error('rw')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label for="dusun" class="form-label">Dusun <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('dusun') is-invalid @enderror" id="dusun" name="dusun" value="{{ old('dusun') }}" required>
                        @error('dusun')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="status_hubungan_keluarga" class="form-label">Hubungan Keluarga <span class="text-danger">*</span></label>
                        <select class="form-select @error('status_hubungan_keluarga') is-invalid @enderror" id="status_hubungan_keluarga" name="status_hubungan_keluarga" required>
                            <option value="">Pilih...</option>
                            <option value="Kepala Keluarga" {{ old('status_hubungan_keluarga') == 'Kepala Keluarga' ? 'selected' : '' }}>Kepala Keluarga</option>
                            <option value="Suami" {{ old('status_hubungan_keluarga') == 'Suami' ? 'selected' : '' }}>Suami</option>
                            <option value="Istri" {{ old('status_hubungan_keluarga') == 'Istri' ? 'selected' : '' }}>Istri</option>
                            <option value="Anak" {{ old('status_hubungan_keluarga') == 'Anak' ? 'selected' : '' }}>Anak</option>
                            <option value="Mertua" {{ old('status_hubungan_keluarga') == 'Mertua' ? 'selected' : '' }}>Mertua</option>
                            <option value="Orang Tua" {{ old('status_hubungan_keluarga') == 'Orang Tua' ? 'selected' : '' }}>Orang Tua</option>
                            <option value="Lainnya" {{ old('status_hubungan_keluarga') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                        </select>
                        @error('status_hubungan_keluarga')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="status_keaktifan" class="form-label">Status Keaktifan <span class="text-danger">*</span></label>
                        <select class="form-select @error('status_keaktifan') is-invalid @enderror" id="status_keaktifan" name="status_keaktifan" required>
                            <option value="Aktif" {{ old('status_keaktifan') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="Meninggal" {{ old('status_keaktifan') == 'Meninggal' ? 'selected' : '' }}>Meninggal</option>
                            <option value="Pindah" {{ old('status_keaktifan') == 'Pindah' ? 'selected' : '' }}>Pindah</option>
                        </select>
                        @error('status_keaktifan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary"><i class="bx bx-save"></i> Simpan Data</button>
                    <a href="{{ route('warga.index') }}" class="btn btn-secondary"><i class="bx bx-arrow-back"></i> Batal</a>
                </div>
            </form>
        </div>
    </div>
</x-app>
