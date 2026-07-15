<x-app>
    <x-slot:title>{{ $title }}</x-slot:title>
    
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Pengaduan dan Aspirasi</h1>
        @if(auth()->user()->hasRole('Warga'))
            <a href="{{ route('pengaduan.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                <i class="fas fa-plus fa-sm text-white-50"></i> Buat Pengaduan Baru
            </a>
        @endif
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Pengaduan</h6>
        </div>
        <div class="card-body">
            @if(auth()->user()->hasRole(['Superadmin', 'Admin', 'Staf']))
                <form action="{{ route('pengaduan.index') }}" method="GET" class="mb-3">
                    <div class="row g-2 align-items-center">
                        <div class="col-md-3">
                            <select name="kategori" class="form-select">
                                <option value="">Semua Kategori</option>
                                <option value="Infrastruktur" {{ request('kategori') == 'Infrastruktur' ? 'selected' : '' }}>Infrastruktur</option>
                                <option value="Keamanan" {{ request('kategori') == 'Keamanan' ? 'selected' : '' }}>Keamanan</option>
                                <option value="Sosial" {{ request('kategori') == 'Sosial' ? 'selected' : '' }}>Sosial</option>
                                <option value="Kebersihan" {{ request('kategori') == 'Kebersihan' ? 'selected' : '' }}>Kebersihan</option>
                                <option value="Lainnya" {{ request('kategori') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select name="status" class="form-select">
                                <option value="">Semua Status</option>
                                <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                                <option value="Diproses" {{ request('status') == 'Diproses' ? 'selected' : '' }}>Diproses</option>
                                <option value="Selesai" {{ request('status') == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                                <option value="Ditolak" {{ request('status') == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                            </select>
                        </div>
                        <div class="col-md-auto">
                            <button type="submit" class="btn btn-primary">Filter</button>
                        </div>
                    </div>
                </form>
            @endif

            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Pelapor</th>
                            <th>Judul</th>
                            <th>Kategori</th>
                            <th>Status</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pengaduans as $index => $pengaduan)
                            <tr>
                                <td>{{ $pengaduans->firstItem() + $index }}</td>
                                <td>
                                    @if($pengaduan->warga)
                                        {{ $pengaduan->warga->nama_lengkap }}
                                    @else
                                        <em>Warga Anonim</em>
                                    @endif
                                </td>
                                <td>{{ $pengaduan->judul }}</td>
                                <td>{{ $pengaduan->kategori }}</td>
                                <td>
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
                                <td>{{ $pengaduan->created_at->format('d M Y') }}</td>
                                <td>
                                    <a href="{{ route('pengaduan.show', $pengaduan) }}" class="btn btn-info btn-sm">
                                        <i class="fas fa-eye"></i> Detail
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">Belum ada data pengaduan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="mt-3">
                {{ $pengaduans->links() }}
            </div>
        </div>
    </div>
</div>
</x-app>
