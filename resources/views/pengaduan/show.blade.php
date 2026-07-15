<x-app>
    <x-slot:title>{{ $title }}</x-slot:title>
    
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detail Pengaduan</h1>
        <a href="{{ route('pengaduan.index') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Informasi Laporan</h6>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <th width="20%">Judul</th>
                            <td>: {{ $pengaduan->judul }}</td>
                        </tr>
                        <tr>
                            <th>Pelapor</th>
                            <td>: 
                                @if($pengaduan->warga)
                                    {{ $pengaduan->warga->nama_lengkap }} (NIK: {{ $pengaduan->warga->nik }})
                                @else
                                    <span class="text-warning"><i class="fas fa-user-secret"></i> Warga Anonim</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Kategori</th>
                            <td>: {{ $pengaduan->kategori }}</td>
                        </tr>
                        <tr>
                            <th>Tanggal Lapor</th>
                            <td>: {{ $pengaduan->created_at->format('d M Y H:i') }}</td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>: 
                                @if($pengaduan->status == 'Pending')
                                    <span class="badge bg-danger text-white">Pending</span>
                                @elseif($pengaduan->status == 'Diproses')
                                    <span class="badge bg-warning text-dark">Diproses</span>
                                @elseif($pengaduan->status == 'Selesai')
                                    <span class="badge bg-success text-white">Selesai</span>
                                @else
                                    <span class="badge bg-secondary text-white">Ditolak</span>
                                @endif
                            </td>
                        </tr>
                    </table>

                    <hr>
                    <h6 class="font-weight-bold">Isi Laporan:</h6>
                    <p class="text-justify bg-light p-3 rounded">
                        {{ nl2br(e($pengaduan->isi_laporan)) }}
                    </p>

                    @if($pengaduan->foto)
                        <hr>
                        <h6 class="font-weight-bold">Bukti Foto:</h6>
                        <div class="text-center">
                            <img src="{{ Storage::url($pengaduan->foto) }}" alt="Bukti Laporan" class="img-fluid rounded" style="max-height: 400px;">
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow mb-4 border-left-info">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-info">Tanggapan Staf</h6>
                </div>
                <div class="card-body">
                    @if($pengaduan->tanggapan)
                        <div class="alert alert-info">
                            <strong>{{ $pengaduan->penanggap->name ?? 'Staf' }}</strong> pada {{ $pengaduan->updated_at->format('d M Y H:i') }}
                            <hr class="my-2">
                            <p class="mb-0">{{ nl2br(e($pengaduan->tanggapan)) }}</p>
                        </div>
                    @else
                        <div class="alert alert-warning">
                            Belum ada tanggapan.
                        </div>
                    @endif

                    @if(auth()->user()->hasRole(['Superadmin', 'Admin', 'Staf']))
                        <hr>
                        <h6 class="font-weight-bold text-dark">Berikan/Ubah Tanggapan</h6>
                        <form action="{{ route('pengaduan.respond', $pengaduan) }}" method="POST">
                            @csrf
                            <div class="form-group mb-3">
                                <label for="status">Ubah Status</label>
                                <select class="form-control" id="status" name="status" required>
                                    <option value="Pending" {{ $pengaduan->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="Diproses" {{ $pengaduan->status == 'Diproses' ? 'selected' : '' }}>Diproses</option>
                                    <option value="Selesai" {{ $pengaduan->status == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                                    <option value="Ditolak" {{ $pengaduan->status == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                                </select>
                            </div>
                            <div class="form-group mb-3">
                                <label for="tanggapan">Isi Tanggapan</label>
                                <textarea class="form-control" id="tanggapan" name="tanggapan" rows="4" required placeholder="Tuliskan tanggapan untuk warga...">{{ old('tanggapan', $pengaduan->tanggapan) }}</textarea>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Simpan Tanggapan</button>
                        </form>
                    @endif
                </div>
            </div>
            
            @if(auth()->user()->hasRole('Superadmin') || (auth()->user()->hasRole('Warga') && $pengaduan->warga_id == auth()->user()->warga->id))
                <div class="card shadow mb-4 border-left-danger">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-danger">Zona Berbahaya</h6>
                    </div>
                    <div class="card-body text-center">
                        <p>Penghapusan laporan tidak dapat dibatalkan.</p>
                        <form action="{{ route('pengaduan.destroy', $pengaduan) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus laporan ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">
                                <i class="fas fa-trash"></i> Hapus Laporan
                            </button>
                        </form>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
</x-app>
