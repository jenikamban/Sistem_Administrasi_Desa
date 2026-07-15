# Task 8: Manajemen Arsip Dokumen

## 1. Tujuan
Membangun modul pengarsipan dokumen digital untuk menyimpan berbagai arsip penting desa (seperti surat keluar/masuk manual, laporan, notulen rapat, dll) ke dalam database secara terpusat agar mudah dicari, tidak hilang, dan aman.

## 2. Ketergantungan
- **Task 1**: Untuk otentikasi staf/admin (Superadmin & Staf) yang berwenang mengunggah dan mengakses arsip.

## 3. Detail Teknis Implementasi

### A. Database & Migrasi (Migrations)
- **Tabel `arsip_dokumens`**:
  - `id` (bigint, primary key, auto-increment)
  - `judul` (string - nama/judul dokumen)
  - `jenis_dokumen` (string - contoh: 'Surat', 'Laporan', 'Notulen', 'Lainnya')
  - `file_path` (string - path direktori penyimpanan file PDF/Scan dokumen di server)
  - `diarsipkan_oleh` (bigint, foreign key ditautkan ke `users.id` - mencatat staf yang mengunggah)
  - `tanggal_arsip` (timestamp - tanggal dokumen diterbitkan/diarsipkan)
  - `keterangan` (text, nullable - ringkasan singkat isi dokumen)
  - `timestamps`

### B. Eloquent Models & Relasi
- **Model `ArsipDokumen`**:
  - Relasi `belongsTo(User::class, 'diarsipkan_oleh')` untuk melacak petugas arsiparis.

### C. Controllers & Routing
1. **`ArsipDokumenController`** (Resource Controller):
   - `index()`: Tampilkan daftar arsip. Gunakan DataTables untuk memungkinkan fitur pencarian cepat berdasarkan judul dokumen atau jenis dokumen.
   - `create()`, `store()`: Menangani input form beserta upload file PDF/Scan (maks. 5MB per file) ke direktori `storage/app/public/arsip/`.
   - `show()`: Menampilkan detail arsip dan menyediakan tombol untuk pratinjau (preview) atau unduh (download) file.
   - `destroy()`: Hapus record dari database sekaligus menghapus file fisik di dalam folder `storage`.
2. **Routing (`routes/web.php`)**:
   - Daftarkan resource route di dalam middleware `auth` dan proteksi khusus untuk role `Superadmin` dan `Staf`. 

### D. Seeders (Dummy Data Generation)
- **Target File**: `database/seeders/ArsipDokumenSeeder.php`
- **Tanggung Jawab**:
  - Buat minimal 5-10 rekaman arsip dummy (contoh: 'Laporan Pertanggungjawaban Dana Desa 2025', 'Notulen Rapat BPD', 'SK Kades Pengangkatan Perangkat').
  - Isi `file_path` dengan lokasi dummy atau file PDF kosong (*placeholder*) agar tombol unduh bisa diuji secara visual.
  - Kaitkan `diarsipkan_oleh` dengan ID akun Staf dari seeder sebelumnya secara acak.

### E. Views (UI/UX NiceAdmin)
- Buat form pengunggahan yang ramah pengguna, berikan indikasi tipe file yang diizinkan (hanya PDF, JPG, atau PNG).
- Untuk tampilan list (Index), gunakan format tabel sederhana dengan ikon (misalnya ikon PDF merah, ikon Word biru) yang di-render berdasarkan ekstensi file yang disimpan di database.

## 4. Rencana Pengujian & Kriteria Penerimaan
- [ ] Staf dapat mengunggah dokumen arsip berupa PDF beserta metadata (judul, jenis, dll).
- [ ] Arsip baru langsung muncul di tabel pencarian (DataTables).
- [ ] Staf dapat mengunduh atau melihat (preview) berkas dokumen yang telah diunggah sebelumnya.
- [ ] Jika record dihapus, file fisik di folder storage juga otomatis terhapus (menggunakan fitur `Storage::delete`).
