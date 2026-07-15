<x-app>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0 fw-bold">
                        <i class='bx bx-info-circle me-2'></i>
                        Detail Program Bansos
                    </h5>
                </div>
                <div class="card-body">
                    <h5 class="fw-bold text-center mt-2">{{ $bantuanSosial->nama_program }}</h5>
                    <div class="text-center mb-4">
                        @if($bantuanSosial->status == 'Aktif')
                            <span class="badge bg-success">Status: Aktif</span>
                        @else
                            <span class="badge bg-secondary">Status: Selesai</span>
                        @endif
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <span class="text-muted">Sumber Dana</span>
                            <span class="fw-bold">{{ $bantuanSosial->sumber_dana }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <span class="text-muted">Tahun Pelaksanaan</span>
                            <span class="fw-bold">{{ $bantuanSosial->tahun }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <span class="text-muted">Total Penerima</span>
                            <span class="fw-bold">{{ $bantuanSosial->penerimaBantuan->count() }} Orang</span>
                        </li>
                        <li class="list-group-item px-0">
                            <span class="text-muted d-block mb-1">Deskripsi</span>
                            <span>{{ $bantuanSosial->deskripsi ?? '-' }}</span>
                        </li>
                    </ul>
                    <div class="mt-4">
                        <a href="{{ route('bantuan-sosial.edit', $bantuanSosial->id) }}" class="btn btn-warning btn-sm text-white w-100 mb-2">
                            <i class="bx bx-edit"></i> Edit Program
                        </a>
                        <a href="{{ route('bantuan-sosial.index') }}" class="btn btn-secondary btn-sm w-100">
                            <i class="bx bx-arrow-back"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-8 mb-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold">
                        <i class='bx bx-group me-2 text-primary'></i>
                        Daftar Penerima Bantuan
                    </h5>
                    @if($bantuanSosial->status == 'Aktif')
                    <a href="{{ route('penerima-bantuan.create', ['bantuan_sosial_id' => $bantuanSosial->id]) }}" class="btn btn-sm btn-primary">
                        <i class="bx bx-plus"></i> Tambah Penerima
                    </a>
                    @endif
                </div>
                <div class="card-body p-4">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="bx bx-check-circle me-1"></i> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="bx bx-error-circle me-1"></i> {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-hover table-striped datatable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>NIK / Nama</th>
                                    <th>Status</th>
                                    <th>Tgl Terima</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($bantuanSosial->penerimaBantuan as $penerima)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <a href="{{ route('warga.show', $penerima->warga->id) }}" class="fw-bold">{{ $penerima->warga->nama }}</a><br>
                                            <small class="text-muted">{{ $penerima->warga->nik }}</small>
                                        </td>
                                        <td>
                                            @if($penerima->status_penerimaan == 'Diusulkan')
                                                <span class="badge bg-warning text-dark">Diusulkan</span>
                                            @elseif($penerima->status_penerimaan == 'Diterima')
                                                <span class="badge bg-success">Diterima</span>
                                            @else
                                                <span class="badge bg-danger">Ditolak</span>
                                            @endif
                                        </td>
                                        <td>{{ $penerima->tanggal_terima ? \Carbon\Carbon::parse($penerima->tanggal_terima)->isoFormat('D MMM YYYY') : '-' }}</td>
                                        <td class="text-center">
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('penerima-bantuan.edit', $penerima->id) }}" class="btn btn-warning btn-sm text-white" title="Edit">
                                                    <i class="bx bx-edit"></i>
                                                </a>
                                                <form action="{{ route('penerima-bantuan.destroy', $penerima->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus penerima ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" title="Hapus">
                                                        <i class="bx bx-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted">Belum ada penerima yang didaftarkan pada program ini.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app>
