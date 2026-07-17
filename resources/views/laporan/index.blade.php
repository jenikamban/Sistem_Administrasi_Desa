<x-app>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body p-4">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="fw-bold mb-1"><i class="bi bi-file-earmark-bar-graph text-primary me-2"></i>Laporan Keseluruhan SADEKA</h4>
                    <p class="text-muted mb-0">Ringkasan operasional dan pelayanan administrasi desa.</p>
                </div>
                <button class="btn btn-primary" onclick="window.print()">
                    <i class="bi bi-printer me-1"></i> Cetak Laporan
                </button>
            </div>
        </div>
    </div>

    <!-- Statistik Utama -->
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card shadow-sm border-0 bg-primary text-white h-100">
                <div class="card-body p-4 text-center">
                    <i class="bi bi-people fs-1 mb-2"></i>
                    <h2 class="fw-bold">{{ $totalPenduduk }}</h2>
                    <p class="mb-0">Total Penduduk Aktif</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm border-0 bg-success text-white h-100">
                <div class="card-body p-4 text-center">
                    <i class="bi bi-envelope-check fs-1 mb-2"></i>
                    <h2 class="fw-bold">{{ $totalSuratSelesai }}</h2>
                    <p class="mb-0">Surat Selesai</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm border-0 bg-warning text-dark h-100">
                <div class="card-body p-4 text-center">
                    <i class="bi bi-megaphone fs-1 mb-2"></i>
                    <h2 class="fw-bold">{{ $totalPengaduanSelesai }}</h2>
                    <p class="mb-0">Pengaduan Selesai</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm border-0 bg-info text-dark h-100">
                <div class="card-body p-4 text-center">
                    <i class="bi bi-arrow-left-right fs-1 mb-2"></i>
                    <h2 class="fw-bold">{{ $totalMutasi }}</h2>
                    <p class="mb-0">Total Mutasi Tercatat</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Laporan Surat Menyurat -->
        <div class="col-md-6">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-white border-0 pt-4 pb-0">
                    <h5 class="fw-bold">Rincian Surat Menyurat</h5>
                </div>
                <div class="card-body p-4">
                    <table class="table table-striped table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Jenis Surat</th>
                                <th>Total Pengajuan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($suratKategori as $jenis => $total)
                            <tr>
                                <td>{{ str_replace('_', ' ', $jenis) }}</td>
                                <td><span class="badge bg-primary">{{ $total }}</span></td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="2" class="text-center text-muted">Belum ada data surat menyurat.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Laporan Pengaduan -->
        <div class="col-md-6">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-white border-0 pt-4 pb-0">
                    <h5 class="fw-bold">Rincian Pengaduan</h5>
                </div>
                <div class="card-body p-4">
                    <table class="table table-striped table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Kategori</th>
                                <th>Total Pengaduan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pengaduanKategori as $kategori => $total)
                            <tr>
                                <td>{{ $kategori }}</td>
                                <td><span class="badge bg-warning text-dark">{{ $total }}</span></td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="2" class="text-center text-muted">Belum ada data pengaduan.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <style>
        @media print {
            body { background: white !important; }
            #header, #sidebar, .btn, .page-header-card { display: none !important; }
            #main { margin-left: 0 !important; padding: 0 !important; }
            .card { box-shadow: none !important; border: 1px solid #ddd !important; }
        }
    </style>

</x-app>
