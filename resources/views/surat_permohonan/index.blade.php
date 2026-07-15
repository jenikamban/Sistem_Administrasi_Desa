<x-app>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold">
                <i class='bx bx-envelope me-2 text-primary'></i>
                Daftar Pengajuan Surat
            </h5>
            <a href="{{ route('surat-permohonan.create') }}" class="btn btn-primary btn-sm">
                <i class="bx bx-plus"></i> Buat Pengajuan Baru
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
                <table class="table table-hover table-striped datatable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal Pengajuan</th>
                            <th>Nama Pemohon</th>
                            <th>Jenis Surat</th>
                            <th>Nomor Surat</th>
                            <th>Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($suratPermohonans as $surat)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ \Carbon\Carbon::parse($surat->created_at)->isoFormat('D MMM YYYY') }}</td>
                                <td>{{ $surat->warga->nama }}<br><small class="text-muted">{{ $surat->warga->nik }}</small></td>
                                <td>{{ $surat->jenis_surat }}</td>
                                <td>{{ $surat->nomor_surat ?? '-' }}</td>
                                <td>
                                    @if($surat->status == 'Menunggu')
                                        <span class="badge bg-warning text-dark">Menunggu</span>
                                    @elseif($surat->status == 'Disetujui')
                                        <span class="badge bg-success">Disetujui</span>
                                    @else
                                        <span class="badge bg-danger">Ditolak</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('surat-permohonan.show', $surat->id) }}" class="btn btn-info btn-sm text-white" title="Lihat Detail & Proses">
                                            <i class="bx bx-search-alt"></i> Proses
                                        </a>
                                        @if($surat->status == 'Disetujui')
                                            <a href="{{ route('surat-permohonan.print', $surat->id) }}" target="_blank" class="btn btn-success btn-sm text-white" title="Cetak PDF">
                                                <i class="bx bx-printer"></i>
                                            </a>
                                        @endif
                                        <form action="{{ route('surat-permohonan.destroy', $surat->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengajuan ini?');">
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
