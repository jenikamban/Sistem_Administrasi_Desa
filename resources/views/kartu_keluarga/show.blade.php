<x-app>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0 fw-bold">
                        <i class='bx bx-id-card me-2'></i>
                        Informasi KK
                    </h5>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <span class="text-muted">Nomor KK</span>
                            <span class="fw-bold">{{ $kartuKeluarga->no_kk }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <span class="text-muted">Kepala Keluarga</span>
                            <span class="fw-bold">{{ $kartuKeluarga->kepalaKeluarga ? $kartuKeluarga->kepalaKeluarga->nama : 'Belum Ditentukan' }}</span>
                        </li>
                        <li class="list-group-item px-0">
                            <span class="text-muted d-block mb-1">Alamat</span>
                            <span class="fw-bold">{{ $kartuKeluarga->alamat }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <span class="text-muted">RT / RW</span>
                            <span class="fw-bold">{{ $kartuKeluarga->rt }} / {{ $kartuKeluarga->rw }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <span class="text-muted">Dusun</span>
                            <span class="fw-bold">{{ $kartuKeluarga->dusun }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <span class="text-muted">Kode Pos</span>
                            <span class="fw-bold">{{ $kartuKeluarga->kode_pos }}</span>
                        </li>
                    </ul>
                    <div class="mt-3">
                        <a href="{{ route('kartu-keluarga.edit', $kartuKeluarga->id) }}" class="btn btn-warning btn-sm text-white w-100 mb-2">
                            <i class="bx bx-edit"></i> Edit Data KK
                        </a>
                        <a href="{{ route('kartu-keluarga.index') }}" class="btn btn-secondary btn-sm w-100">
                            <i class="bx bx-arrow-back"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-8 mb-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold">
                        <i class='bx bx-group me-2 text-primary'></i>
                        Anggota Keluarga
                    </h5>
                    <a href="{{ route('warga.create') }}" class="btn btn-sm btn-primary">
                        <i class="bx bx-plus"></i> Tambah Anggota
                    </a>
                </div>
                <div class="card-body p-4">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>NIK</th>
                                    <th>Nama Lengkap</th>
                                    <th>Status Hub. Keluarga</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($kartuKeluarga->anggota as $anggota)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $anggota->nik }}</td>
                                        <td>{{ $anggota->nama }}</td>
                                        <td>
                                            <span class="badge {{ $anggota->status_hubungan_keluarga == 'Kepala Keluarga' ? 'bg-primary' : 'bg-secondary' }}">
                                                {{ $anggota->status_hubungan_keluarga }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('warga.show', $anggota->id) }}" class="btn btn-info btn-sm text-white" title="Detail">
                                                <i class="bx bx-show"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted">Belum ada anggota keluarga yang didaftarkan pada KK ini.</td>
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
