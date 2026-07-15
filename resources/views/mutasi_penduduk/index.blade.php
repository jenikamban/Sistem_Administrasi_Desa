<x-app>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold">
                <i class='bx bx-transfer me-2 text-primary'></i>
                Data Mutasi Penduduk
            </h5>
            <a href="{{ route('mutasi-penduduk.create') }}" class="btn btn-primary btn-sm">
                <i class="bx bx-plus"></i> Catat Mutasi
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
                <table class="table table-hover table-striped datatable" id="mutasiTable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal Mutasi</th>
                            <th>Nama Warga</th>
                            <th>NIK</th>
                            <th>Jenis Mutasi</th>
                            <th>Keterangan</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($mutasiPenduduks as $mutasi)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ \Carbon\Carbon::parse($mutasi->tanggal_mutasi)->isoFormat('D MMM YYYY') }}</td>
                                <td>{{ $mutasi->warga->nama }}</td>
                                <td><span class="badge bg-secondary">{{ $mutasi->warga->nik }}</span></td>
                                <td>
                                    @if($mutasi->jenis_mutasi == 'Lahir' || $mutasi->jenis_mutasi == 'Masuk')
                                        <span class="badge bg-success">{{ $mutasi->jenis_mutasi }}</span>
                                    @else
                                        <span class="badge bg-danger">{{ $mutasi->jenis_mutasi }}</span>
                                    @endif
                                </td>
                                <td>{{ Str::limit($mutasi->keterangan, 30) }}</td>
                                <td class="text-center">
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('mutasi-penduduk.show', $mutasi->id) }}" class="btn btn-info btn-sm text-white" title="Detail">
                                            <i class="bx bx-show"></i>
                                        </a>
                                        <a href="{{ route('mutasi-penduduk.edit', $mutasi->id) }}" class="btn btn-warning btn-sm text-white" title="Edit">
                                            <i class="bx bx-edit"></i>
                                        </a>
                                        <form action="{{ route('mutasi-penduduk.destroy', $mutasi->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data mutasi ini?');">
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
