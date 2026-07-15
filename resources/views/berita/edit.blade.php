<x-app>
    <x-slot:title>{{ $title }}</x-slot:title>
    
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Edit Berita</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('berita.update', $berita) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label>Judul</label>
                    <input type="text" name="judul" class="form-control" value="{{ $berita->judul }}" required>
                </div>
                <div class="mb-3">
                    <label>Kategori</label>
                    <select name="kategori" class="form-control" required>
                        <option value="Kegiatan" {{ $berita->kategori == 'Kegiatan' ? 'selected' : '' }}>Kegiatan</option>
                        <option value="Pengumuman" {{ $berita->kategori == 'Pengumuman' ? 'selected' : '' }}>Pengumuman</option>
                        <option value="Penyuluhan" {{ $berita->kategori == 'Penyuluhan' ? 'selected' : '' }}>Penyuluhan</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label>Konten</label>
                    <textarea name="konten" class="tinymce-editor form-control">{{ $berita->konten }}</textarea>
                </div>
                <div class="mb-3">
                    <label>Gambar Banner</label>
                    @if($berita->gambar)
                        <div class="mb-2">
                            <img src="{{ Storage::url($berita->gambar) }}" alt="Banner" width="150">
                        </div>
                    @endif
                    <input type="file" name="gambar" class="form-control">
                </div>
                <div class="mb-3">
                    <label>Status</label>
                    <select name="status" class="form-control" required>
                        <option value="Draft" {{ $berita->status == 'Draft' ? 'selected' : '' }}>Draft</option>
                        <option value="Published" {{ $berita->status == 'Published' ? 'selected' : '' }}>Published</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('berita.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
</x-app>
