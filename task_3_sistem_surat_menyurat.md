# Task 3: Sistem Surat-Menyurat Digital

## 1. Tujuan
Membangun modul pengajuan dan pembuatan surat keterangan digital terintegrasi. Modul ini menyediakan form pengajuan surat online bagi warga, dashboard peninjauan dokumen bagi staf, dashboard penandatanganan/persetujuan bagi Kepala Desa/Lurah, serta pengarsipan digital otomatis berupa file PDF yang dilengkapi QR Code sebagai tanda tangan elektronik verifikatif.

## 2. Ketergantungan
- **Task 1**: Untuk otentikasi user (Warga, Staf, Kades_Lurah).
- **Task 2**: Untuk memverifikasi dan menarik data penduduk (NIK, Nama, Tempat Lahir, Alamat) secara otomatis ke dalam template surat.

## 3. Detail Teknis Implementasi

### A. Database & Migrasi (Migrations)
- **Tabel `surat_permohonans`**:
  - `id` (bigint, primary key, auto-increment)
  - `nomor_surat` (string, nullable - diisi otomatis saat disetujui/disahkan)
  - `jenis_surat` (enum: 'SKU', 'SKTM', 'SKD', 'SK_Kematian', 'SK_Pindah', 'Surat_Pengantar')
  - `warga_id` (bigint, foreign key, cascade on delete - penduduk penerima surat)
  - `pengaju_id` (bigint, foreign key - user pengaju, baik staf maupun warga)
  - `keperluan` (text - alasan pengajuan surat)
  - `keterangan_tambahan` (text, nullable - detail dinamis seperti nama usaha untuk SKU, nama sekolah untuk SKTM)
  - `status` (enum: 'Draft', 'Ditinjau_Staf', 'Menunggu_Tanda_Tangan', 'Disetujui', 'Ditolak')
  - `catatan_penolakan` (text, nullable - diisi staf jika permohonan ditolak)
  - `tanggal_pengajuan` (timestamp)
  - `tanggal_persetujuan` (timestamp, nullable)
  - `disetujui_oleh` (bigint, foreign key, nullable - user Kepala Desa/Lurah yang menyetujui)
  - `file_surat` (string, nullable - path penyimpanan file PDF di storage)
  - `qr_code_token` (string, 64 karakter, unique, nullable - token verifikasi QR)
  - `timestamps`

### B. Eloquent Model `SuratPermohonan`
- Relasi `belongsTo(Warga::class)` untuk menarik informasi detail kependudukan.
- Relasi `belongsTo(User::class, 'pengaju_id')` untuk pelapor/pemohon akun.
- Relasi `belongsTo(User::class, 'disetujui_oleh')` untuk pelacakan penandatangan.

### C. Controllers & Alur Kerja Persetujuan (Workflow)
1. **`SuratPermohonanController`**:
   - `index()`: Staf melihat semua permohonan; Kades melihat permohonan berstatus 'Menunggu_Tanda_Tangan'; Warga hanya melihat riwayat permohonan pribadi mereka.
   - `create()`, `store()`: Warga mengajukan surat (mengisi jenis surat, keperluan, keterangan tambahan). Jika diajukan oleh staf, staf memilih warga menggunakan Select2 pencarian NIK.
   - `verify(Request $request, SuratPermohonan $surat)`: Staf memeriksa berkas. Jika oke, ubah status menjadi `Menunggu_Tanda_Tangan`. Jika gagal, ubah menjadi `Ditolak` dan input `catatan_penolakan`.
   - `approve(Request $request, SuratPermohonan $surat)`: Kades memberikan persetujuan. Logika ini akan:
     - Generate nomor surat resmi (format: `400/xxx/Desa-2026`).
     - Generate token QR Code acak.
     - Compile template blade surat dengan data penduduk dan QR Code menjadi format PDF menggunakan library `laravel-dompdf`.
     - Simpan file PDF di `storage/app/public/surat/`.
     - Ubah status menjadi `Disetujui` dan catat `tanggal_persetujuan`.
   - `download(SuratPermohonan $surat)`: Warga atau staf mengunduh berkas PDF surat yang sudah ditandatangani.
2. **`VerifikasiSuratController`** (Public Route / Tanpa Auth):
   - `verifyPublic($token)`: Halaman publik terbuka ketika QR Code pada surat dipindai menggunakan smartphone. Halaman ini hanya menampilkan tabel metadata menyatakan dokumen tersebut **Sah & Terverifikasi** di sistem SADEKA, lengkap dengan NIK, nama warga, jenis surat, nomor surat, dan tanggal disetujui. Jika token tidak valid, tampilkan pesan peringatan pemalsuan dokumen.

### D. Routing (`routes/web.php`)
- Route resource dan workflow surat harus diproteksi middleware `auth`.
- Tambahkan route publik `/verifikasi-surat/{token}` di luar grup `auth` untuk validasi QR Code.

### E. Seeders (Dummy Data Generation)
- **Target File**: `database/seeders/SuratPermohonanSeeder.php`
- **Tanggung Jawab**:
  - Buat minimal 10 dummy data pengajuan surat dalam berbagai status (3 draft, 2 ditinjau staf, 2 menunggu tanda tangan kades, 3 disetujui lengkap dengan file PDF dummy dan token QR code ter-generate).

### F. Views (UI/UX NiceAdmin & Dompdf Template)
- **Blade View Admin**: Halaman antrean yang teratur menggunakan tab/filter status (Draf, Perlu Verifikasi, Siap TTE, Selesai).
- **Blade View Portal Warga**: Antarmuka ringkas yang ramah seluler untuk warga mengajukan permohonan dan memantau status secara langsung (misal menggunakan visualisasi progress bar status).
- **Template PDF**: Menggunakan styling CSS dasar yang kompatibel dengan Dompdf untuk kop surat resmi desa, tabel data warga, isi pernyataan surat keterangan, serta ruang tanda tangan ber-QR Code di kanan bawah.

## 4. Rencana Pengujian & Kriteria Penerimaan
- [ ] Warga dapat mengajukan permohonan surat SKU secara mandiri dari akun warga.
- [ ] Staf dapat menolak pengajuan yang tidak lengkap dan menyertakan alasan penolakan yang langsung muncul di portal warga.
- [ ] Kepala Desa dapat melihat daftar surat siap tanda tangan dan menyetujuinya dengan sekali klik.
- [ ] Setelah disetujui, file PDF berhasil ter-generate di storage dan dapat diunduh secara instan oleh warga.
- [ ] Pemindaian QR Code pada PDF surat mengarahkan ke halaman web publik yang memverifikasi keaslian surat tersebut secara akurat.
