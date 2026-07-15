<x-app>
    <x-slot:title>{{ $title }}</x-slot:title>
    
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Inventaris Desa</h1>
        <a href="{{ route('inventaris-desa.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Inventaris
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Aset</h6>
            <form action="{{ route('inventaris-desa.index') }}" method="GET" class="d-flex align-items-center">
                <select name="kondisi" class="form-control form-control-sm me-2" onchange="this.form.submit()">
                    <option value="">-- Semua Kondisi --</option>
                    <option value="Baik" {{ request('kondisi') == 'Baik' ? 'selected' : '' }}>Baik</option>
                    <option value="Rusak Ringan" {{ request('kondisi') == 'Rusak Ringan' ? 'selected' : '' }}>Rusak Ringan</option>
                    <option value="Rusak Berat" {{ request('kondisi') == 'Rusak Berat' ? 'selected' : '' }}>Rusak Berat</option>
                </select>
                <select name="kategori" class="form-control form-control-sm" onchange="this.form.submit()">
                    <option value="">-- Semua Kategori --</option>
                    <option value="Kendaraan" {{ request('kategori') == 'Kendaraan' ? 'selected' : '' }}>Kendaraan</option>
                    <option value="Peralatan Elektronik" {{ request('kategori') == 'Peralatan Elektronik' ? 'selected' : '' }}>Peralatan Elektronik</option>
                    <option value="Bangunan" {{ request('kategori') == 'Bangunan' ? 'selected' : '' }}>Bangunan</option>
                    <option value="Lainnya" {{ request('kategori') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                </select>
            </form>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="data-table" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Item</th>
                            <th>Kategori</th>
                            <th>Jumlah</th>
                            <th>Kondisi</th>
                            <th>Lokasi</th>
                            <th>Penanggung Jawab</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($inventaris as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->nama_item }}</td>
                                <td>{{ $item->kategori }}</td>
                                <td>{{ $item->jumlah }}</td>
                                <td>
                                    @if($item->kondisi == 'Baik')
                                        <span class="badge bg-success">Baik</span>
                                    @elseif($item->kondisi == 'Rusak Ringan')
                                        <span class="badge bg-warning">Rusak Ringan</span>
                                    @else
                                        <span class="badge bg-danger">Rusak Berat</span>
                                    @endif
                                </td>
                                <td>{{ $item->lokasi }}</td>
                                <td>{{ $item->penanggungJawab->name ?? 'Belum Ditentukan' }}</td>
                                <td>
                                    <a href="{{ route('inventaris-desa.edit', $item) }}" class="btn btn-warning btn-sm">Edit</a>
                                    <form action="{{ route('inventaris-desa.destroy', $item) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('delete')
                                        <button class="btn btn-danger btn-sm" onclick="return confirm('Hapus data inventaris ini?')">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</x-app>
