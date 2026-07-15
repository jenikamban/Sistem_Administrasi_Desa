<x-app>
    <x-slot:title>{{ $title }}</x-slot:title>
    
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Form Tambah Arsip Dokumen</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('arsip-dokumen.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label>Judul Dokumen <span class="text-danger">*</span></label>
                    <input type="text" name="judul" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Jenis Dokumen <span class="text-danger">*</span></label>
                    <select name="jenis_dokumen" class="form-control" required>
                        <option value="Surat">Surat</option>
                        <option value="Laporan">Laporan</option>
                        <option value="Notulen">Notulen</option>
                        <option value="SK">Surat Keputusan (SK)</option>
                        <option value="Lainnya">Lainnya</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label>Tanggal Arsip/Terbit <span class="text-danger">*</span></label>
                    <input type="date" name="tanggal_arsip" class="form-control" value="{{ date('Y-m-d') }}" required>
                </div>
                <div class="mb-3">
                    <label>File Arsip (PDF/JPG/PNG, Max: 5MB) <span class="text-danger">*</span></label>
                    <input type="file" name="file_arsip" class="form-control" accept=".pdf,.jpg,.jpeg,.png" required>
                </div>
                <div class="mb-3">
                    <label>Keterangan Ringkas</label>
                    <textarea name="keterangan" class="form-control" rows="3"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Simpan Arsip</button>
                <a href="{{ route('arsip-dokumen.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
</x-app>
