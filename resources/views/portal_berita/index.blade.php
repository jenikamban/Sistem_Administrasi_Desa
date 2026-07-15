<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Berita Desa</title>
    <link href="{{ asset('niceadmin/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1 class="mb-4">Portal Berita Desa</h1>
    <a href="{{ url('/') }}" class="btn btn-secondary mb-3">Kembali ke Beranda</a>
    <div class="row">
        @foreach($beritas as $berita)
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm">
                    @if($berita->gambar)
                        <img src="{{ Storage::url($berita->gambar) }}" class="card-img-top" alt="{{ $berita->judul }}">
                    @else
                        <img src="{{ asset('niceadmin/img/news-default.jpg') }}" class="card-img-top" alt="Default">
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{ $berita->judul }}</h5>
                        <p class="card-text text-muted">{{ $berita->kategori }} | {{ $berita->created_at->format('d M Y') }}</p>
                        <p class="card-text">{{ Str::limit(strip_tags($berita->konten), 100) }}</p>
                        <a href="{{ route('portal.berita.show', $berita->slug) }}" class="btn btn-primary">Baca Selengkapnya</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="d-flex justify-content-center">
        {{ $beritas->links() }}
    </div>
</div>
<script src="{{ asset('niceadmin/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>
