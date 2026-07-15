# Task 6: Publikasi dan Transparansi Desa

## 1. Tujuan
Membangun modul publikasi berita desa serta transparansi anggaran pendapatan dan belanja desa (APBD). Modul ini menyediakan portal berita bagi warga (dilengkapi Rich Text Editor TinyMCE untuk penulisan artikel) dan grafik visualisasi anggaran untuk transparansi pengelolaan keuangan desa.

## 2. Ketergantungan
- **Task 1**: Untuk otentikasi admin/staf sebagai pembuat konten berita desa.

## 3. Detail Teknis Implementasi

### A. Database & Migrasi (Migrations)
1. **Tabel `beritas`** (CMS Berita):
   - `id` (bigint, primary key, auto-increment)
   - `judul` (string)
   - `slug` (string, unique - untuk URL ramah SEO)
   - `konten` (longtext)
   - `kategori` (string - contoh: 'Kegiatan', 'Pengumuman', 'Penyuluhan')
   - `gambar` (string, nullable - path banner berita di storage)
   - `penulis_id` (bigint, foreign key ditautkan ke `users.id`)
   - `status` (enum: 'Draft', 'Published')
   - `timestamps`
2. **Tabel `apbd_realisasis`** (Transparansi Keuangan):
   - `id` (bigint, primary key, auto-increment)
   - `kategori` (enum: 'Pendapatan', 'Belanja', 'Pembiayaan')
   - `nama_item` (string - contoh: 'Bantuan Provinsi', 'Pembangunan Jembatan RT 02', 'Operasional Kantor')
   - `anggaran` (decimal/bigint - alokasi dana awal)
   - `realisasi` (decimal/bigint - dana terpakai)
   - `tahun` (integer)
   - `timestamps`

### B. Eloquent Models & Relasi
1. **Model `Berita`**:
   - Relasi `belongsTo(User::class, 'penulis_id')`.
   - Gunakan event Eloquent (`saving` atau `creating`) untuk menghasilkan slug otomatis dari kolom judul menggunakan helper `Str::slug()`.
2. **Model `ApbdRealisasi`**:
   - Model mandiri untuk mencatat realisasi anggaran tahunan.

### C. Controllers & Routing
1. **`BeritaController`** (Resource Controller):
   - CRUD artikel berita (hanya diakses oleh Superadmin dan Staf).
   - Menyediakan route publik `/informasi/berita` (list berita) dan `/informasi/berita/{slug}` (detail berita) tanpa otentikasi.
2. **`ApbdController`** (Resource Controller):
   - CRUD entitas APBD Realisasi oleh admin.
   - Menyediakan route publik `/informasi/apbd` untuk memvisualisasikan data anggaran dalam bentuk tabel dan grafik persentase penyerapan anggaran.
3. **Routing (`routes/web.php`)**:
   - Daftarkan route admin di bawah middleware `auth` dan batasi akses ke `Superadmin`/`Staf`.
   - Daftarkan route pembaca publik di luar middleware `auth` agar warga/publik dapat mengakses tanpa masuk ke sistem.

### D. Seeders (Dummy Data Generation)
- **Target File**: `database/seeders/PublikasiSeeder.php`
- **Tanggung Jawab**:
  - Buat minimal 4 artikel berita desa dummy lengkap dengan konten kaya HTML (untuk menguji TinyMCE rendering) dan gambar default.
  - Buat minimal 8 data realisasi APBD dummy untuk tahun berjalan (terdiri dari komponen Pendapatan dan Belanja) agar data grafik visualisasi terisi.

### E. Integrasi Rich Text Editor & UI/UX
- **TinyMCE Integration**: Integrasikan script editor TinyMCE di form create/edit berita (memanfaatkan pustaka TinyMCE yang sudah ada di template NiceAdmin).
- **Public View Layout**: Tampilan publik (berita dan APBD) dibuat dengan antarmuka modern yang memukau warga saat pertama kali membukanya.
- **Visualisasi APBD**: Tampilkan perbandingan anggaran vs realisasi menggunakan visualisasi diagram batang (Bar Chart) ApexCharts atau Chart.js bawaan template NiceAdmin.

## 4. Rencana Pengujian & Kriteria Penerimaan
- [ ] Staf dapat menulis berita baru menggunakan TinyMCE dengan menyematkan format tulisan tebal/miring/list, dan menyimpannya sebagai draf atau langsung terbit (published).
- [ ] Berita dengan status `Published` berhasil tampil di halaman portal berita publik yang dapat diakses tanpa login.
- [ ] URL detail berita menggunakan slug ramah SEO (misal: `/informasi/berita/kegiatan-posyandu-balita-dusun-i`).
- [ ] Grafik APBD Desa berhasil merender perbandingan anggaran dan realisasi secara dinamis berdasarkan data seeder.
