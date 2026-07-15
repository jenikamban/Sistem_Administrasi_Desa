<x-app>
    <x-slot:title>{{ $title }}</x-slot:title>
    
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Manajemen Arsip Dokumen</h1>
        <a href="{{ route('arsip-dokumen.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Arsip Baru
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="data-table" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Judul Dokumen</th>
                            <th>Jenis</th>
                            <th>Tanggal Arsip</th>
                            <th>Diarsipkan Oleh</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($arsips as $arsip)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    @php
                                        $ext = pathinfo($arsip->file_path, PATHINFO_EXTENSION);
                                    @endphp
                                    @if($ext == 'pdf')
                                        <i class="bi bi-file-earmark-pdf text-danger me-2"></i>
                                    @elseif(in_array($ext, ['jpg','jpeg','png']))
                                        <i class="bi bi-file-earmark-image text-success me-2"></i>
                                    @else
                                        <i class="bi bi-file-earmark-text text-secondary me-2"></i>
                                    @endif
                                    {{ $arsip->judul }}
                                </td>
                                <td>{{ $arsip->jenis_dokumen }}</td>
                                <td>{{ $arsip->tanggal_arsip->format('d M Y') }}</td>
                                <td>{{ $arsip->user->name ?? '-' }}</td>
                                <td>
                                    <a href="{{ route('arsip-dokumen.show', $arsip) }}" class="btn btn-info btn-sm">Lihat</a>
                                    <form action="{{ route('arsip-dokumen.destroy', $arsip) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('delete')
                                        <button class="btn btn-danger btn-sm" onclick="return confirm('Hapus arsip ini beserta filenya?')">Hapus</button>
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
