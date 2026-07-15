<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat {{ $surat->jenis_surat }}</title>
    <style>
        body { font-family: 'Times New Roman', Times, serif; font-size: 12pt; line-height: 1.5; margin: 2cm; }
        .kop-surat { text-align: center; border-bottom: 3px solid black; padding-bottom: 10px; margin-bottom: 20px; }
        .kop-surat h1, .kop-surat h2, .kop-surat p { margin: 0; padding: 0; }
        .kop-surat h1 { font-size: 16pt; font-weight: bold; text-transform: uppercase; }
        .kop-surat h2 { font-size: 14pt; font-weight: bold; text-transform: uppercase; }
        .kop-surat p { font-size: 11pt; }
        .judul-surat { text-align: center; margin-bottom: 20px; }
        .judul-surat h3 { font-size: 14pt; text-decoration: underline; margin: 0; text-transform: uppercase; }
        .judul-surat p { margin: 0; }
        .isi-surat { text-align: justify; }
        .tabel-identitas { margin-left: 30px; margin-bottom: 15px; margin-top: 15px; }
        .tabel-identitas td { padding: 3px; vertical-align: top; }
        .tabel-identitas .label { width: 150px; }
        .tanda-tangan { margin-top: 50px; width: 100%; }
        .tanda-tangan td { width: 50%; text-align: center; }
        .qrcode { text-align: right; margin-top: -30px; margin-bottom: 30px; }
    </style>
</head>
<body>

    <div class="kop-surat">
        <h2>PEMERINTAH KABUPATEN INDONESIA</h2>
        <h2>KECAMATAN NUSANTARA</h2>
        <h1>DESA MAJU JAYA</h1>
        <p>Jl. Pembangunan No. 123, Desa Maju Jaya, Kec. Nusantara, Kode Pos: 12345</p>
        <p>Email: pemdes@majujaya.desa.id | Website: www.majujaya.desa.id</p>
    </div>

    <div class="judul-surat">
        <h3>{{ strtoupper($surat->jenis_surat) }}</h3>
        <p>Nomor: {{ $surat->nomor_surat }}</p>
    </div>

    <div class="isi-surat">
        <p>Yang bertanda tangan di bawah ini Kepala Desa Maju Jaya, Kecamatan Nusantara, Kabupaten Indonesia, dengan ini menerangkan bahwa:</p>

        <table class="tabel-identitas">
            <tr>
                <td class="label">Nama Lengkap</td>
                <td>:</td>
                <td><strong>{{ $surat->warga->nama }}</strong></td>
            </tr>
            <tr>
                <td class="label">NIK</td>
                <td>:</td>
                <td>{{ $surat->warga->nik }}</td>
            </tr>
            <tr>
                <td class="label">Tempat, Tgl Lahir</td>
                <td>:</td>
                <td>{{ $surat->warga->tempat_lahir }}, {{ \Carbon\Carbon::parse($surat->warga->tanggal_lahir)->isoFormat('D MMMM YYYY') }}</td>
            </tr>
            <tr>
                <td class="label">Jenis Kelamin</td>
                <td>:</td>
                <td>{{ $surat->warga->jenis_kelamin }}</td>
            </tr>
            <tr>
                <td class="label">Agama</td>
                <td>:</td>
                <td>{{ $surat->warga->agama }}</td>
            </tr>
            <tr>
                <td class="label">Pekerjaan</td>
                <td>:</td>
                <td>{{ $surat->warga->pekerjaan }}</td>
            </tr>
            <tr>
                <td class="label">Alamat Lengkap</td>
                <td>:</td>
                <td>{{ $surat->warga->alamat }}, RT {{ $surat->warga->rt }} / RW {{ $surat->warga->rw }}, Dusun {{ $surat->warga->dusun }}</td>
            </tr>
        </table>

        <p>Orang tersebut di atas adalah benar-benar warga penduduk Desa Maju Jaya, Kecamatan Nusantara. Surat keterangan ini dibuat untuk keperluan:</p>
        
        <p><strong><em>"{{ $surat->keperluan }}"</em></strong></p>

        <p>Demikian surat keterangan ini dibuat dengan sebenar-benarnya untuk dapat dipergunakan sebagaimana mestinya.</p>
    </div>

    <div class="qrcode">
        <img src="data:image/svg+xml;base64,{{ $qrcode }}" alt="QR Code Verifikasi" width="80" height="80">
        <br>
        <small style="font-size: 8pt; color: #555;">Scan untuk verifikasi</small>
    </div>

    <table class="tanda-tangan">
        <tr>
            <td></td>
            <td>
                Maju Jaya, {{ \Carbon\Carbon::now()->isoFormat('D MMMM YYYY') }}<br>
                Kepala Desa Maju Jaya
                <br><br><br><br><br>
                <strong><u>BAPAK KADES, S.IP., M.Si.</u></strong>
            </td>
        </tr>
    </table>

</body>
</html>
