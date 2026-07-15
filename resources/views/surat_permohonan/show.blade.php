<x-app>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="row">
        <div class="col-md-7 mb-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold">
                        <i class='bx bx-file me-2 text-primary'></i>
                        Detail Surat Permohonan
                    </h5>
                    @if($suratPermohonan->status == 'Menunggu')
                        <span class="badge bg-warning text-dark px-3 py-2">Menunggu Persetujuan</span>
                    @elseif($suratPermohonan->status == 'Disetujui')
                        <span class="badge bg-success px-3 py-2">Disetujui</span>
                    @else
                        <span class="badge bg-danger px-3 py-2">Ditolak</span>
                    @endif
                </div>
                <div class="card-body p-4">
                    <table class="table table-borderless">
                        <tbody>
                            <tr>
                                <td class="text-muted" width="30%">Tanggal Pengajuan</td>
                                <td class="fw-bold">: {{ \Carbon\Carbon::parse($suratPermohonan->created_at)->isoFormat('dddd, D MMMM YYYY') }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Jenis Surat</td>
                                <td class="fw-bold text-primary">: {{ $suratPermohonan->jenis_surat }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Pemohon</td>
                                <td class="fw-bold">: <a href="{{ route('warga.show', $suratPermohonan->warga->id) }}">{{ $suratPermohonan->warga->nama }}</a></td>
                            </tr>
                            <tr>
                                <td class="text-muted">NIK Pemohon</td>
                                <td class="fw-bold">: {{ $suratPermohonan->warga->nik }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Nomor Surat</td>
                                <td class="fw-bold">: {{ $suratPermohonan->nomor_surat ?? 'Belum ada (Menunggu persetujuan)' }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted align-top">Keperluan</td>
                                <td>
                                    <div class="bg-light p-3 rounded">
                                        {{ $suratPermohonan->keperluan }}
                                    </div>
                                </td>
                            </tr>
                            @if($suratPermohonan->status == 'Ditolak')
                            <tr>
                                <td class="text-danger align-top">Alasan Penolakan</td>
                                <td>
                                    <div class="bg-danger text-white p-3 rounded bg-opacity-75">
                                        {{ $suratPermohonan->keterangan_penolakan }}
                                    </div>
                                </td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-5 mb-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-primary text-white border-bottom">
                    <h5 class="mb-0 fw-bold">
                        <i class='bx bx-check-shield me-2'></i>
                        Proses Verifikasi
                    </h5>
                </div>
                <div class="card-body p-4">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="bx bx-check-circle me-1"></i> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="bx bx-error-circle me-1"></i> {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if($suratPermohonan->status == 'Menunggu')
                        <div class="text-center mb-4">
                            <i class='bx bx-time text-warning' style="font-size: 4rem;"></i>
                            <p class="mt-2 text-muted">Surat ini sedang menunggu tindak lanjut dari pihak desa.</p>
                        </div>
                        
                        <div class="d-grid gap-2">
                            <!-- Tombol Setujui -->
                            <form action="{{ route('surat-permohonan.approve', $suratPermohonan->id) }}" method="POST" onsubmit="return confirm('Anda yakin ingin menyetujui surat ini? Nomor surat akan digenerate otomatis.');">
                                @csrf
                                <button type="submit" class="btn btn-success w-100 p-3 fw-bold shadow-sm">
                                    <i class="bx bx-check-circle fs-5 me-1"></i> Setujui & Terbitkan Surat
                                </button>
                            </form>
                            
                            <!-- Tombol Tolak -->
                            <button type="button" class="btn btn-danger w-100 p-2 fw-bold" data-bs-toggle="collapse" data-bs-target="#collapseTolak" aria-expanded="false" aria-controls="collapseTolak">
                                <i class="bx bx-x-circle me-1"></i> Tolak Pengajuan
                            </button>
                            
                            <!-- Form Tolak (Collapse) -->
                            <div class="collapse mt-2" id="collapseTolak">
                                <div class="card card-body bg-light border-danger border-opacity-25">
                                    <form action="{{ route('surat-permohonan.reject', $suratPermohonan->id) }}" method="POST">
                                        @csrf
                                        <div class="mb-3">
                                            <label class="form-label text-danger fw-bold">Alasan Penolakan</label>
                                            <textarea name="keterangan_penolakan" class="form-control" rows="3" required placeholder="Jelaskan alasan menolak..."></textarea>
                                        </div>
                                        <button type="submit" class="btn btn-danger btn-sm w-100">Konfirmasi Penolakan</button>
                                    </form>
                                </div>
                            </div>
                        </div>

                    @elseif($suratPermohonan->status == 'Disetujui')
                        <div class="text-center mb-4">
                            <i class='bx bx-check-shield text-success' style="font-size: 4rem;"></i>
                            <h5 class="mt-2 text-success fw-bold">Surat Telah Disetujui</h5>
                            <p class="text-muted mb-0">Nomor Registrasi: <strong>{{ $suratPermohonan->nomor_surat }}</strong></p>
                            <p class="text-muted small">Kode Unik: {{ $suratPermohonan->kode_verifikasi }}</p>
                        </div>
                        <div class="d-grid">
                            <a href="{{ route('surat-permohonan.print', $suratPermohonan->id) }}" target="_blank" class="btn btn-primary p-3 fw-bold shadow-sm">
                                <i class="bx bx-printer fs-5 me-1"></i> Cetak / Download PDF
                            </a>
                        </div>
                    @else
                        <div class="text-center mb-4">
                            <i class='bx bx-block text-danger' style="font-size: 4rem;"></i>
                            <h5 class="mt-2 text-danger fw-bold">Pengajuan Ditolak</h5>
                            <p class="text-muted">Pengajuan surat ini telah ditolak oleh perangkat desa.</p>
                        </div>
                    @endif

                    <hr class="mt-4 mb-3">
                    <div class="text-center">
                        <a href="{{ route('surat-permohonan.index') }}" class="btn btn-outline-secondary">
                            <i class="bx bx-arrow-back"></i> Kembali ke Daftar
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app>
