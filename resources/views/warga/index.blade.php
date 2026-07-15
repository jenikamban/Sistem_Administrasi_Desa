<x-app>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold">
                <i class='bx bx-user me-2 text-primary'></i>
                Data Warga
            </h5>
            <a href="{{ route('warga.create') }}" class="btn btn-primary btn-sm">
                <i class="bx bx-plus"></i> Tambah Warga
            </a>
        </div>
        <div class="card-body p-4">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bx bx-check-circle me-1"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-hover table-striped datatable" id="wargaTable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>NIK</th>
                            <th>Nama Lengkap</th>
                            <th>JK</th>
                            <th>Dusun</th>
                            <th>Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($wargas as $w)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td><span class="badge bg-secondary">{{ $w->nik }}</span></td>
                                <td>{{ $w->nama }}</td>
                                <td>{{ $w->jenis_kelamin == 'Laki-laki' ? 'L' : 'P' }}</td>
                                <td>{{ $w->dusun }}</td>
                                <td>
                                    @if($w->status_keaktifan == 'Aktif')
                                        <span class="badge bg-success">Aktif</span>
                                    @elseif($w->status_keaktifan == 'Meninggal')
                                        <span class="badge bg-danger">Meninggal</span>
                                    @else
                                        <span class="badge bg-warning text-dark">Pindah</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('warga.show', $w->id) }}" class="btn btn-info btn-sm text-white" title="Detail">
                                            <i class="bx bx-show"></i>
                                        </a>
                                        <a href="{{ route('warga.edit', $w->id) }}" class="btn btn-warning btn-sm text-white" title="Edit">
                                            <i class="bx bx-edit"></i>
                                        </a>
                                        <form action="{{ route('warga.destroy', $w->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" title="Hapus">
                                                <i class="bx bx-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app>
