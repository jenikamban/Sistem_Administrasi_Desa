<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }} - SADEKA</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Boxicons -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f6f9ff;
        }
        .portal-header {
            background: linear-gradient(135deg, #4154f1 0%, #2a3eb1 100%);
            color: white;
            padding: 60px 0;
            border-bottom-left-radius: 30px;
            border-bottom-right-radius: 30px;
            margin-bottom: 40px;
        }
        .search-card {
            margin-top: -60px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>

    <div class="portal-header text-center">
        <div class="container">
            <h1 class="fw-bold mb-3"><i class='bx bx-search-alt'></i> Portal Cek Bansos</h1>
            <p class="lead mb-0">Sistem Administrasi Desa - Cek Status Penerimaan Bantuan Sosial Anda</p>
        </div>
    </div>

    <div class="container mb-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card border-0 search-card mb-4">
                    <div class="card-body p-5">
                        <form action="{{ route('portal.bansos.search') }}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <label for="nik" class="form-label fw-bold">Masukkan Nomor Induk Kependudukan (NIK)</label>
                                <div class="input-group input-group-lg">
                                    <span class="input-group-text bg-white"><i class='bx bx-id-card text-primary'></i></span>
                                    <input type="text" class="form-control @error('nik') is-invalid @enderror" id="nik" name="nik" placeholder="16 Digit NIK Anda" value="{{ request('nik') ?? old('nik') }}" required>
                                    <button class="btn btn-primary px-4" type="submit">Cari Data</button>
                                </div>
                                @error('nik')
                                    <div class="text-danger mt-2 small">{{ $message }}</div>
                                @enderror
                            </div>
                        </form>
                    </div>
                </div>

                @if(isset($hasil))
                    <div class="card border-0 shadow-sm rounded-4">
                        <div class="card-header bg-white border-bottom p-4">
                            <h5 class="mb-0 fw-bold">
                                <i class='bx bx-list-ul me-2 text-primary'></i>
                                Hasil Pencarian untuk NIK: <span class="text-primary">{{ $nik }}</span>
                            </h5>
                        </div>
                        <div class="card-body p-4">
                            @if($hasil->count() > 0)
                                <div class="alert alert-success d-flex align-items-center" role="alert">
                                    <i class='bx bxs-check-circle fs-4 me-2'></i>
                                    <div>
                                        Data ditemukan! Berikut adalah daftar bantuan sosial yang terkait dengan NIK Anda.
                                    </div>
                                </div>

                                <div class="table-responsive mt-4">
                                    <table class="table table-hover table-bordered">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Nama Program</th>
                                                <th>Tahun</th>
                                                <th>Status Program</th>
                                                <th>Status Penerimaan Anda</th>
                                                <th>Tanggal Terima</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($hasil as $data)
                                                <tr>
                                                    <td class="fw-bold">{{ $data->bantuanSosial->nama_program }}</td>
                                                    <td>{{ $data->bantuanSosial->tahun }}</td>
                                                    <td>
                                                        @if($data->bantuanSosial->status == 'Aktif')
                                                            <span class="badge bg-success">Aktif</span>
                                                        @else
                                                            <span class="badge bg-secondary">Selesai</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($data->status_penerimaan == 'Diusulkan')
                                                            <span class="badge bg-warning text-dark">Diusulkan</span>
                                                        @elseif($data->status_penerimaan == 'Diterima')
                                                            <span class="badge bg-success">Diterima</span>
                                                        @else
                                                            <span class="badge bg-danger">Ditolak</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ $data->tanggal_terima ? \Carbon\Carbon::parse($data->tanggal_terima)->isoFormat('D MMM YYYY') : '-' }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="text-center py-5">
                                    <i class='bx bx-sad text-muted' style="font-size: 5rem;"></i>
                                    <h5 class="mt-3 text-muted">Mohon Maaf, Data Tidak Ditemukan</h5>
                                    <p class="text-muted">NIK yang Anda masukkan tidak terdaftar sebagai penerima program bantuan sosial manapun.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif
                
                <div class="text-center mt-4">
                    <a href="{{ route('login') }}" class="text-decoration-none text-muted">
                        <i class='bx bx-home-alt me-1'></i> Kembali ke Login Admin
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
