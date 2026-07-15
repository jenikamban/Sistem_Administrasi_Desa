<x-app>
    <x-slot:title>{{ $title }}</x-slot:title>
    
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Form Tambah Inventaris</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('inventaris-desa.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label>Nama Item / Aset <span class="text-danger">*</span></label>
                    <input type="text" name="nama_item" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Kategori <span class="text-danger">*</span></label>
                    <select name="kategori" class="form-control" required>
                        <option value="Kendaraan">Kendaraan</option>
                        <option value="Peralatan Elektronik">Peralatan Elektronik</option>
                        <option value="Bangunan">Bangunan</option>
                        <option value="Lainnya">Lainnya</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label>Jumlah <span class="text-danger">*</span></label>
                    <input type="number" name="jumlah" class="form-control" min="1" value="1" required>
                </div>
                <div class="mb-3">
                    <label>Kondisi <span class="text-danger">*</span></label>
                    <select name="kondisi" class="form-control" required>
                        <option value="Baik">Baik</option>
                        <option value="Rusak Ringan">Rusak Ringan</option>
                        <option value="Rusak Berat">Rusak Berat</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label>Lokasi <span class="text-danger">*</span></label>
                    <input type="text" name="lokasi" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Penanggung Jawab</label>
                    <select name="penanggung_jawab_id" class="form-control">
                        <option value="">-- Pilih Staf Penanggung Jawab --</option>
                        @foreach($staf as $s)
                            <option value="{{ $s->id }}">{{ $s->name }} ({{ str_replace('_', ' ', $s->role) }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label>Tanggal Pencatatan</label>
                    <input type="date" name="tanggal_pencatatan" class="form-control" value="{{ date('Y-m-d') }}">
                </div>
                <div class="mb-3">
                    <label>Keterangan</label>
                    <textarea name="keterangan" class="form-control" rows="3"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('inventaris-desa.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
</x-app>
