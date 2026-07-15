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
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 20px;
        }
        .verify-card {
            max-width: 500px;
            width: 100%;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        .header-success {
            background: linear-gradient(135deg, #198754 0%, #146c43 100%);
            color: white;
            padding: 40px 20px;
            text-align: center;
        }
        .header-danger {
            background: linear-gradient(135deg, #dc3545 0%, #b02a37 100%);
            color: white;
            padding: 40px 20px;
            text-align: center;
        }
        .icon-circle {
            width: 80px;
            height: 80px;
            background: rgba(255,255,255,0.2);
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

    <div class="verify-card bg-white">
        @if($surat && $surat->status == 'Disetujui')
            <div class="header-success">
                <div class="icon-circle">
                    <i class='bx bx-check-shield' style="font-size: 3rem;"></i>
                </div>
                <h3 class="fw-bold mb-1">Surat Valid & Asli</h3>
                <p class="mb-0 opacity-75">Sistem Administrasi Desa Maju Jaya</p>
            </div>
            
            <div class="card-body p-4">
                <p class="text-center text-muted mb-4">Dokumen ini telah sah diverifikasi dan ditandatangani secara digital oleh Kepala Desa.</p>
                
                <ul class="list-group list-group-flush mb-4">
                    <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                        <span class="text-muted">Nomor Surat</span>
                        <span class="fw-bold">{{ $surat->nomor_surat }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                        <span class="text-muted">Jenis Surat</span>
                        <span class="fw-bold text-primary">{{ $surat->jenis_surat }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                        <span class="text-muted">Nama Pemohon</span>
                        <span class="fw-bold">{{ $surat->warga->nama }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                        <span class="text-muted">Tanggal Terbit</span>
                        <span class="fw-bold">{{ \Carbon\Carbon::parse($surat->updated_at)->isoFormat('D MMMM YYYY') }}</span>
                    </li>
                </ul>

                <div class="alert alert-success bg-success bg-opacity-10 border-success border-opacity-25 py-2 text-center" role="alert">
                    <small><i class='bx bx-check-circle'></i> Terdaftar di Database Desa</small>
                </div>
            </div>
        @else
            <div class="header-danger">
                <div class="icon-circle">
                    <i class='bx bx-x-circle' style="font-size: 3rem;"></i>
                </div>
                <h3 class="fw-bold mb-1">Surat Tidak Valid</h3>
                <p class="mb-0 opacity-75">Sistem Administrasi Desa Maju Jaya</p>
            </div>
            
            <div class="card-body p-4 text-center">
                <p class="text-muted mb-4">Dokumen ini <strong>TIDAK DITEMUKAN</strong> atau belum disetujui dalam sistem database Desa Maju Jaya. Harap berhati-hati terhadap pemalsuan dokumen.</p>
                <div class="alert alert-danger bg-danger bg-opacity-10 border-danger border-opacity-25 py-2" role="alert">
                    <small><i class='bx bx-error'></i> Tidak ada kecocokan data</small>
                </div>
            </div>
        @endif
        
        <div class="card-footer bg-light border-0 text-center py-3">
            <a href="{{ route('login') }}" class="text-decoration-none text-muted small">
                &copy; {{ date('Y') }} SADEKA - Sistem Administrasi Desa
            </a>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
