<x-app>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold">
                <i class='bx bx-gift me-2 text-primary'></i>
                Program Bantuan Sosial
            </h5>
            <a href="{{ route('bantuan-sosial.create') }}" class="btn btn-primary btn-sm">
                <i class="bx bx-plus"></i> Tambah Program Baru
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
                <table class="table table-hover table-striped datatable" id="bansosTable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Program</th>
                            <th>Sumber Dana</th>
                            <th>Tahun</th>
                            <th>Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($bantuanSosials as $bansos)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td><strong>{{ $bansos->nama_program }}</strong></td>
                                <td>{{ $bansos->sumber_dana }}</td>
                                <td>{{ $bansos->tahun }}</td>
                                <td>
                                    @if($bansos->status == 'Aktif')
                                        <span class="badge bg-success">Aktif</span>
                                    @else
                                        <span class="badge bg-secondary">Selesai</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('bantuan-sosial.show', $bansos->id) }}" class="btn btn-info btn-sm text-white" title="Detail & Kelola Penerima">
                                            <i class="bx bx-show"></i>
                                        </a>
                                        <a href="{{ route('bantuan-sosial.edit', $bansos->id) }}" class="btn btn-warning btn-sm text-white" title="Edit">
                                            <i class="bx bx-edit"></i>
                                        </a>
                                        <form action="{{ route('bantuan-sosial.destroy', $bansos->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus program ini? Menghapus program ini akan menghapus semua data penerima yang terikat.');">
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
