<x-app>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="row">
        <div class="col-md-5 mb-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0 fw-bold">
                        <i class='bx bx-user-circle me-2'></i>
                        Profil Warga
                    </h5>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4 mt-3">
                        <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 100px; height: 100px;">
                            <i class='bx bx-user fs-1 text-primary'></i>
                        </div>
                        <h5 class="mt-3 fw-bold">{{ $warga->nama }}</h5>
                        <p class="text-muted mb-0">{{ $warga->nik }}</p>
                        <div class="mt-2">
                            @if($warga->status_keaktifan == 'Aktif')
                                <span class="badge bg-success">Aktif</span>
                            @elseif($warga->status_keaktifan == 'Meninggal')
                                <span class="badge bg-danger">Meninggal</span>
                            @else
                                <span class="badge bg-warning text-dark">Pindah</span>
                            @endif
                        </div>
                    </div>

                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <span class="text-muted">No KK</span>
                            <span class="fw-bold">
                                @if($warga->kartuKeluarga)
                                    <a href="{{ route('kartu-keluarga.show', $warga->kartuKeluarga->id) }}">{{ $warga->kartuKeluarga->no_kk }}</a>
                                @else
                                    Belum Ditautkan
                                @endif
                            </span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <span class="text-muted">TTL</span>
                            <span class="fw-bold">{{ $warga->tempat_lahir }}, {{ \Carbon\Carbon::parse($warga->tanggal_lahir)->isoFormat('D MMMM YYYY') }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <span class="text-muted">Jenis Kelamin</span>
                            <span class="fw-bold">{{ $warga->jenis_kelamin }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <span class="text-muted">Agama</span>
                            <span class="fw-bold">{{ $warga->agama }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <span class="text-muted">Status Perkawinan</span>
                            <span class="fw-bold">{{ $warga->status_perkawinan }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <span class="text-muted">Pekerjaan</span>
                            <span class="fw-bold">{{ $warga->pekerjaan }}</span>
                        </li>
                        <li class="list-group-item px-0">
                            <span class="text-muted d-block mb-1">Alamat</span>
                            <span class="fw-bold">{{ $warga->alamat }}, RT {{ $warga->rt }}/RW {{ $warga->rw }}, Dusun {{ $warga->dusun }}</span>
                        </li>
                    </ul>
                    <div class="mt-4">
                        @if(Auth::user()->role == 'Superadmin' || Auth::user()->role == 'Admin' || Auth::user()->role == 'Staf')
                        <a href="{{ route('warga.edit', $warga->id) }}" class="btn btn-warning btn-sm text-white w-100 mb-2">
                            <i class="bx bx-edit"></i> Edit Data Warga
                        </a>
                        <a href="{{ route('warga.index') }}" class="btn btn-secondary btn-sm w-100">
                            <i class="bx bx-arrow-back"></i> Kembali ke Daftar
                        </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-7 mb-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold">
                        <i class='bx bx-history me-2 text-primary'></i>
                        Riwayat Mutasi
                    </h5>
                    @if(Auth::user()->role == 'Superadmin' || Auth::user()->role == 'Admin' || Auth::user()->role == 'Staf')
                    <a href="{{ route('mutasi-penduduk.create', ['warga_id' => $warga->id]) }}" class="btn btn-sm btn-primary">
                        <i class="bx bx-plus"></i> Catat Mutasi
                    </a>
                    @endif
                </div>
                <div class="card-body p-4">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal</th>
                                    <th>Jenis Mutasi</th>
                                    <th>Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($warga->mutasiPenduduk as $mutasi)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ \Carbon\Carbon::parse($mutasi->tanggal_mutasi)->isoFormat('D MMMM YYYY') }}</td>
                                        <td>
                                            @if($mutasi->jenis_mutasi == 'Lahir' || $mutasi->jenis_mutasi == 'Masuk')
                                                <span class="badge bg-success">{{ $mutasi->jenis_mutasi }}</span>
                                            @else
                                                <span class="badge bg-danger">{{ $mutasi->jenis_mutasi }}</span>
                                            @endif
                                        </td>
                                        <td>{{ $mutasi->keterangan }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted">Belum ada riwayat mutasi untuk warga ini.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app>
