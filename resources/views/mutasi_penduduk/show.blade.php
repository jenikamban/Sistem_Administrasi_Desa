<x-app>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold">
                        <i class='bx bx-transfer me-2 text-primary'></i>
                        Detail Mutasi Penduduk
                    </h5>
                    <a href="{{ route('mutasi-penduduk.index') }}" class="btn btn-secondary btn-sm">
                        <i class="bx bx-arrow-back"></i> Kembali
                    </a>
                </div>
                <div class="card-body p-4">
                    <div class="row mb-3">
                        <div class="col-sm-4 text-muted">Tanggal Kejadian</div>
                        <div class="col-sm-8 fw-bold">{{ \Carbon\Carbon::parse($mutasiPenduduk->tanggal_mutasi)->isoFormat('dddd, D MMMM YYYY') }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4 text-muted">Nama Warga</div>
                        <div class="col-sm-8 fw-bold">
                            <a href="{{ route('warga.show', $mutasiPenduduk->warga->id) }}">{{ $mutasiPenduduk->warga->nama }}</a>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4 text-muted">NIK Warga</div>
                        <div class="col-sm-8 fw-bold">{{ $mutasiPenduduk->warga->nik }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4 text-muted">Jenis Mutasi</div>
                        <div class="col-sm-8 fw-bold">
                            @if($mutasiPenduduk->jenis_mutasi == 'Lahir' || $mutasiPenduduk->jenis_mutasi == 'Masuk')
                                <span class="badge bg-success">{{ $mutasiPenduduk->jenis_mutasi }}</span>
                            @else
                                <span class="badge bg-danger">{{ $mutasiPenduduk->jenis_mutasi }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4 text-muted">Keterangan Tambahan</div>
                        <div class="col-sm-8 fw-bold">
                            {{ $mutasiPenduduk->keterangan }}
                        </div>
                    </div>
                    
                    <hr>
                    
                    <div class="d-flex justify-content-end mt-4">
                        <a href="{{ route('mutasi-penduduk.edit', $mutasiPenduduk->id) }}" class="btn btn-warning text-white me-2">
                            <i class="bx bx-edit"></i> Edit Data
                        </a>
                        <form action="{{ route('mutasi-penduduk.destroy', $mutasiPenduduk->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data mutasi ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <i class="bx bx-trash"></i> Hapus Data
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app>
