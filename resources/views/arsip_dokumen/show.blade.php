<x-app>
    <x-slot:title>{{ $title }}</x-slot:title>
    
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Detail Arsip: {{ $arsip->judul }}</h6>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th width="200">Judul Dokumen</th>
                    <td>{{ $arsip->judul }}</td>
                </tr>
                <tr>
                    <th>Jenis Dokumen</th>
                    <td>{{ $arsip->jenis_dokumen }}</td>
                </tr>
                <tr>
                    <th>Tanggal Terbit/Arsip</th>
                    <td>{{ $arsip->tanggal_arsip->format('d M Y') }}</td>
                </tr>
                <tr>
                    <th>Diarsipkan Oleh</th>
                    <td>{{ $arsip->user->name ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Keterangan</th>
                    <td>{{ $arsip->keterangan ?? '-' }}</td>
                </tr>
            </table>

            <div class="mt-4">
                <h5>Preview Berkas</h5>
                @php
                    $ext = pathinfo($arsip->file_path, PATHINFO_EXTENSION);
                @endphp
                
                @if($ext == 'pdf')
                    <iframe src="{{ Storage::url($arsip->file_path) }}" width="100%" height="600px"></iframe>
                @elseif(in_array($ext, ['jpg','jpeg','png']))
                    <img src="{{ Storage::url($arsip->file_path) }}" alt="Arsip" class="img-fluid border">
                @else
                    <p class="text-muted">Preview tidak tersedia untuk tipe file ini.</p>
                @endif
            </div>

            <div class="mt-4">
                <a href="{{ Storage::url($arsip->file_path) }}" class="btn btn-success" download>
                    <i class="bi bi-download"></i> Unduh Berkas
                </a>
                <a href="{{ route('arsip-dokumen.index') }}" class="btn btn-secondary">Kembali</a>
            </div>
        </div>
    </div>
</div>
</x-app>
