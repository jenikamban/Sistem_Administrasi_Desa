<x-app>
    <x-slot:title>{{ $title }}</x-slot:title>
    
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Edit Realisasi APBD</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('apbd.update', $apbd) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label>Kategori</label>
                    <select name="kategori" class="form-control" required>
                        <option value="Pendapatan" {{ $apbd->kategori == 'Pendapatan' ? 'selected' : '' }}>Pendapatan</option>
                        <option value="Belanja" {{ $apbd->kategori == 'Belanja' ? 'selected' : '' }}>Belanja</option>
                        <option value="Pembiayaan" {{ $apbd->kategori == 'Pembiayaan' ? 'selected' : '' }}>Pembiayaan</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label>Nama Item</label>
                    <input type="text" name="nama_item" class="form-control" value="{{ $apbd->nama_item }}" required>
                </div>
                <div class="mb-3">
                    <label>Tahun</label>
                    <input type="number" name="tahun" class="form-control" value="{{ $apbd->tahun }}" required>
                </div>
                <div class="mb-3">
                    <label>Anggaran (Rp)</label>
                    <input type="number" name="anggaran" class="form-control" value="{{ $apbd->anggaran }}" required>
                </div>
                <div class="mb-3">
                    <label>Realisasi (Rp)</label>
                    <input type="number" name="realisasi" class="form-control" value="{{ $apbd->realisasi }}" required>
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('apbd.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
</x-app>
