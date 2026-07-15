<x-app>
    <x-slot:title>{{ $title }}</x-slot:title>
    
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Buat Pengaduan Baru</h1>
        <a href="{{ route('pengaduan.index') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('pengaduan.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group mb-3">
                    <label for="judul">Judul Laporan <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('judul') is-invalid @enderror" id="judul" name="judul" value="{{ old('judul') }}" required placeholder="Contoh: Lampu Jalan Mati di RT 01">
                </div>

                <div class="form-group mb-3">
                    <label for="kategori">Kategori <span class="text-danger">*</span></label>
                    <select class="form-control @error('kategori') is-invalid @enderror" id="kategori" name="kategori" required>
                        <option value="">Pilih Kategori</option>
                        <option value="Infrastruktur" {{ old('kategori') == 'Infrastruktur' ? 'selected' : '' }}>Infrastruktur</option>
                        <option value="Keamanan" {{ old('kategori') == 'Keamanan' ? 'selected' : '' }}>Keamanan</option>
                        <option value="Sosial" {{ old('kategori') == 'Sosial' ? 'selected' : '' }}>Sosial</option>
                        <option value="Kebersihan" {{ old('kategori') == 'Kebersihan' ? 'selected' : '' }}>Kebersihan</option>
                        <option value="Lainnya" {{ old('kategori') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                    </select>
                </div>

                <div class="form-group mb-3">
                    <label for="isi_laporan">Isi Laporan <span class="text-danger">*</span></label>
                    <textarea class="form-control @error('isi_laporan') is-invalid @enderror" id="isi_laporan" name="isi_laporan" rows="5" required placeholder="Jelaskan detail pengaduan Anda di sini...">{{ old('isi_laporan') }}</textarea>
                </div>

                <div class="form-group mb-3">
                    <label for="foto">Unggah Foto (Opsional)</label>
                    <input type="file" class="form-control-file @error('foto') is-invalid @enderror" id="foto" name="foto" accept="image/*">
                    <small class="form-text text-muted">Format yang didukung: JPG, JPEG, PNG. Maksimal 2MB.</small>
                </div>

                <div class="form-group mb-4">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="is_anonim" name="is_anonim">
                        <label class="custom-control-label text-warning" for="is_anonim">
                            <i class="fas fa-user-secret"></i> Laporkan secara Anonim
                        </label>
                        <small class="form-text text-muted d-block">Identitas Anda (nama) tidak akan ditampilkan kepada publik atau staf pengelola.</small>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-paper-plane"></i> Kirim Laporan
                </button>
            </form>
        </div>
    </div>
</div>
</x-app>
