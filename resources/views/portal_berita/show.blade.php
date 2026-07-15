<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $berita->judul }}</title>
    <link href="{{ asset('niceadmin/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h1 class="mb-3">{{ $berita->judul }}</h1>
            <p class="text-muted">Kategori: {{ $berita->kategori }} | Dipublikasikan: {{ $berita->created_at->format('d M Y') }}</p>
            @if($berita->gambar)
                <img src="{{ Storage::url($berita->gambar) }}" class="img-fluid mb-4" alt="{{ $berita->judul }}">
            @endif
            <div class="content mb-5">
                {!! $berita->konten !!}
            </div>
            <a href="{{ route('portal.berita.index') }}" class="btn btn-secondary">Kembali ke Berita</a>
        </div>
    </div>
</div>
<script src="{{ asset('niceadmin/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>
