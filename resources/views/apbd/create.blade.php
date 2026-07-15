<x-app>
    <x-slot:title>{{ $title }}</x-slot:title>
    
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Tambah Realisasi APBD</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('apbd.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label>Kategori</label>
                    <select name="kategori" class="form-control" required>
                        <option value="Pendapatan">Pendapatan</option>
                        <option value="Belanja">Belanja</option>
                        <option value="Pembiayaan">Pembiayaan</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label>Nama Item</label>
                    <input type="text" name="nama_item" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Tahun</label>
                    <input type="number" name="tahun" class="form-control" value="{{ date('Y') }}" required>
                </div>
                <div class="mb-3">
                    <label>Anggaran (Rp)</label>
                    <input type="number" name="anggaran" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Realisasi (Rp)</label>
                    <input type="number" name="realisasi" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('apbd.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
</x-app>
