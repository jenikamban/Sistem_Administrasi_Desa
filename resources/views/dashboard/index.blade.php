<x-app>

    <x-slot:title>{{ $title }}</x-slot:title>

    <!-- Welcome Card -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body p-4">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h3 class="fw-bold mb-3">
                        <i class='bx bx-smile text-primary me-2'></i>
                        Selamat Datang, {{ Auth::user()->name }}!
                    </h3>
                    <p class="text-muted mb-0">
                        Anda login sebagai <span class="badge bg-primary">{{ Auth::user()->role }}</span>
                    </p>
                    <p class="text-muted mt-2">
                        <i class='bx bx-time-five me-1'></i>
                        {{ now()->isoFormat('dddd, D MMMM YYYY - HH:mm') }}
                    </p>
                </div>
                <div class="col-md-4 text-center">
                    <img src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : asset('niceadmin/img/noprofil.png') }}"
                        alt="Avatar" class="img-fluid rounded-circle border border-3 border-primary"
                        style="max-width: 150px;">
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    @if (Auth::user()->role !== 'Warga')
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="text-muted mb-1 small">Total Penduduk</p>
                            <h2 class="fw-bold mb-0">{{ $totalPenduduk }}</h2>
                        </div>
                        <div class="bg-primary bg-opacity-10 rounded-circle p-3">
                            <i class='bx bx-group fs-2 text-primary'></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="text-muted mb-1 small">Total KK</p>
                            <h2 class="fw-bold mb-0">{{ $totalKK }}</h2>
                        </div>
                        <div class="bg-success bg-opacity-10 rounded-circle p-3">
                            <i class='bx bx-home fs-2 text-success'></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="text-muted mb-1 small">Surat Menunggu</p>
                            <h2 class="fw-bold mb-0">{{ $suratMenunggu }}</h2>
                        </div>
                        <div class="bg-warning bg-opacity-10 rounded-circle p-3">
                            <i class='bx bx-envelope fs-2 text-warning'></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="text-muted mb-1 small">Pengaduan Baru</p>
                            <h2 class="fw-bold mb-0">{{ $pengaduanBaru }}</h2>
                        </div>
                        <div class="bg-danger bg-opacity-10 rounded-circle p-3">
                            <i class='bx bx-message-error fs-2 text-danger'></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="row g-4 mb-4">
        <!-- Demografi Jenis Kelamin -->
        <div class="col-md-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0 fw-bold">Demografi Jenis Kelamin</h5>
                </div>
                <div class="card-body">
                    <div id="chartJenisKelamin"></div>
                </div>
            </div>
        </div>

        <!-- Demografi Umur -->
        <div class="col-md-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0 fw-bold">Demografi Umur</h5>
                </div>
                <div class="card-body">
                    <div id="chartUmur"></div>
                </div>
            </div>
        </div>

        <!-- Pekerjaan Populer -->
        <div class="col-md-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0 fw-bold">Top 5 Pekerjaan</h5>
                </div>
                <div class="card-body">
                    <div id="chartPekerjaan"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tren Surat -->
    <div class="row g-4 mb-4">
        <div class="col-md-12">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0 fw-bold">Tren Pengajuan Surat (Tahun Ini)</h5>
                </div>
                <div class="card-body">
                    <div id="chartSurat"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tables Section -->
    <div class="row g-4 mb-4">
        <div class="col-md-6">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0 fw-bold">Pengajuan Surat Terbaru</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>No Surat</th>
                                    <th>Jenis</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($suratTerbaru as $surat)
                                <tr>
                                    <td>{{ $surat->nomor_surat ?? '-' }}</td>
                                    <td>{{ $surat->jenis_surat }}</td>
                                    <td>
                                        @if($surat->status == 'Menunggu_Tanda_Tangan' || $surat->status == 'Ditinjau_Staf' || $surat->status == 'Draft')
                                            <span class="badge bg-warning text-dark">Menunggu</span>
                                        @elseif($surat->status == 'Disetujui')
                                            <span class="badge bg-success">Disetujui</span>
                                        @else
                                            <span class="badge bg-danger">{{ $surat->status }}</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0 fw-bold">Laporan Pengaduan Terkini</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Judul</th>
                                    <th>Kategori</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pengaduanTerkini as $aduan)
                                <tr>
                                    <td>{{ $aduan->judul }}</td>
                                    <td>{{ $aduan->kategori }}</td>
                                    <td>
                                        @if($aduan->status == 'Pending')
                                            <span class="badge bg-danger">Baru</span>
                                        @elseif($aduan->status == 'Diproses')
                                            <span class="badge bg-warning">Diproses</span>
                                        @elseif($aduan->status == 'Selesai')
                                            <span class="badge bg-success">Selesai</span>
                                        @else
                                            <span class="badge bg-secondary">{{ $aduan->status }}</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @else
    <!-- Warga Dashboard Actions -->
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <a href="{{ route('surat-permohonan.create') }}" class="text-decoration-none">
                <div class="card shadow-sm border-0 h-100 btn-primary" style="transition: 0.3s;">
                    <div class="card-body p-4 text-center">
                        <div class="bg-white bg-opacity-10 rounded-circle p-3 d-inline-block mb-3">
                            <i class='bx bx-envelope-open fs-1 text-white'></i>
                        </div>
                        <h5 class="fw-bold text-white mb-0">Ajukan Surat</h5>
                        <p class="text-white-50 small mt-2 mb-0">(Domisili, Usaha, dll)</p>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-3">
            <a href="{{ route('surat-permohonan.index') }}" class="text-decoration-none">
                <div class="card shadow-sm border-0 h-100 btn-primary" style="transition: 0.3s;">
                    <div class="card-body p-4 text-center">
                        <div class="bg-white bg-opacity-10 rounded-circle p-3 d-inline-block mb-3">
                            <i class='bx bx-list-ul fs-1 text-white'></i>
                        </div>
                        <h5 class="fw-bold text-white mb-0">Status Pengajuan</h5>
                        <p class="text-white-50 small mt-2 mb-0">Lihat status surat Anda</p>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-3">
            <a href="{{ route('pengaduan.create') }}" class="text-decoration-none">
                <div class="card shadow-sm border-0 h-100 btn-primary" style="transition: 0.3s;">
                    <div class="card-body p-4 text-center">
                        <div class="bg-white bg-opacity-10 rounded-circle p-3 d-inline-block mb-3">
                            <i class='bx bx-message-error fs-1 text-white'></i>
                        </div>
                        <h5 class="fw-bold text-white mb-0">Pengaduan/Saran</h5>
                        <p class="text-white-50 small mt-2 mb-0">Sampaikan keluhan Anda</p>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-3">
            <a href="{{ route('surat-permohonan.index') }}" class="text-decoration-none">
                <div class="card shadow-sm border-0 h-100 btn-primary" style="transition: 0.3s;">
                    <div class="card-body p-4 text-center">
                        <div class="bg-white bg-opacity-10 rounded-circle p-3 d-inline-block mb-3">
                            <i class='bx bx-printer fs-1 text-white'></i>
                        </div>
                        <h5 class="fw-bold text-white mb-0">Cetak Surat</h5>
                        <p class="text-white-50 small mt-2 mb-0">Cetak surat disetujui</p>
                    </div>
                </div>
            </a>
        </div>
    </div>
    @endif

    @push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            // Data dari Controller
            const dataJenisKelamin = @json($jenisKelamin);
            const dataUmur = @json($umur);
            const dataPekerjaan = @json($pekerjaanPopuler);
            const dataSurat = @json($suratPerBulan);

            // Chart Jenis Kelamin
            new ApexCharts(document.querySelector("#chartJenisKelamin"), {
                series: Object.values(dataJenisKelamin),
                chart: { type: 'pie', height: 300 },
                labels: Object.keys(dataJenisKelamin),
                colors: ['#008FFB', '#FF4560']
            }).render();

            // Chart Umur
            new ApexCharts(document.querySelector("#chartUmur"), {
                series: Object.values(dataUmur),
                chart: { type: 'donut', height: 300 },
                labels: Object.keys(dataUmur),
            }).render();

            // Chart Pekerjaan
            new ApexCharts(document.querySelector("#chartPekerjaan"), {
                series: [{ name: 'Jumlah', data: Object.values(dataPekerjaan) }],
                chart: { type: 'bar', height: 300 },
                xaxis: { categories: Object.keys(dataPekerjaan) },
                plotOptions: {
                    bar: { horizontal: true, borderRadius: 4 }
                },
                colors: ['#00E396']
            }).render();

            // Chart Surat
            new ApexCharts(document.querySelector("#chartSurat"), {
                series: [{ name: 'Pengajuan Surat', data: Object.values(dataSurat) }],
                chart: { type: 'area', height: 350 },
                xaxis: { categories: Object.keys(dataSurat) },
                dataLabels: { enabled: false },
                stroke: { curve: 'smooth' },
                fill: { type: 'gradient' }
            }).render();
        });
    </script>
    @endpush

</x-app>
