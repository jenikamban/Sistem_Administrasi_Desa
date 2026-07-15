<x-app>
    <x-slot:title>{{ $title }}</x-slot:title>
    
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Realisasi APBD</h1>
        <a href="{{ route('apbd.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Realisasi APBD
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="data-table" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kategori</th>
                            <th>Nama Item</th>
                            <th>Tahun</th>
                            <th>Anggaran</th>
                            <th>Realisasi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($apbds as $apbd)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $apbd->kategori }}</td>
                                <td>{{ $apbd->nama_item }}</td>
                                <td>{{ $apbd->tahun }}</td>
                                <td>Rp {{ number_format($apbd->anggaran, 0, ',', '.') }}</td>
                                <td>Rp {{ number_format($apbd->realisasi, 0, ',', '.') }}</td>
                                <td>
                                    <a href="{{ route('apbd.edit', $apbd) }}" class="btn btn-warning btn-sm">Edit</a>
                                    <form action="{{ route('apbd.destroy', $apbd) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('delete')
                                        <button class="btn btn-danger btn-sm" onclick="return confirm('Hapus data ini?')">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                {{ $apbds->links() }}
            </div>
        </div>
    </div>
</div>
</x-app>
