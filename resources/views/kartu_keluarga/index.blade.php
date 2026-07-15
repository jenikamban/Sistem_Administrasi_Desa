<x-app>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold">
                <i class='bx bx-group me-2 text-primary'></i>
                Data Kartu Keluarga
            </h5>
            <a href="{{ route('kartu-keluarga.create') }}" class="btn btn-primary btn-sm">
                <i class="bx bx-plus"></i> Tambah KK Baru
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
                <table class="table table-hover table-striped datatable" id="kkTable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>No KK</th>
                            <th>Kepala Keluarga</th>
                            <th>Alamat</th>
                            <th>RT/RW</th>
                            <th>Dusun</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($kartuKeluargas as $kk)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td><span class="badge bg-secondary">{{ $kk->no_kk }}</span></td>
                                <td>{{ $kk->kepalaKeluarga ? $kk->kepalaKeluarga->nama : 'Belum Ditentukan' }}</td>
                                <td>{{ $kk->alamat }}</td>
                                <td>{{ $kk->rt }} / {{ $kk->rw }}</td>
                                <td>{{ $kk->dusun }}</td>
                                <td class="text-center">
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('kartu-keluarga.show', $kk->id) }}" class="btn btn-info btn-sm text-white" title="Detail">
                                            <i class="bx bx-show"></i>
                                        </a>
                                        <a href="{{ route('kartu-keluarga.edit', $kk->id) }}" class="btn btn-warning btn-sm text-white" title="Edit">
                                            <i class="bx bx-edit"></i>
                                        </a>
                                        <form action="{{ route('kartu-keluarga.destroy', $kk->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
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
