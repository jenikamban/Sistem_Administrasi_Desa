# Task 2: Manajemen Kependudukan dan Mutasi

## 1. Tujuan
Membangun modul pengelolaan data kependudukan dan pencatatan mutasi secara dinamis. Modul ini merupakan pilar utama SADEKA, yang mencakup data Kartu Keluarga (KK), profil individu Warga Desa, serta log mutasi kependudukan (lahir, meninggal, pindah masuk, pindah keluar).

## 2. Ketergantungan
- **Task 1**: Harus diselesaikan terlebih dahulu agar middleware otentikasi dan pemetaan role user dapat berfungsi dengan baik.

## 3. Detail Teknis Implementasi

### A. Database & Migrasi (Migrations)
1. **Tabel `kartu_keluargas`**:
   - `id` (bigint, primary key, auto-increment)
   - `no_kk` (string, 16 karakter, unique)
   - `kepala_keluarga_id` (bigint, foreign key, nullable - ditautkan ke tabel `wargas`)
   - `alamat` (text)
   - `rt` (string, 3 karakter)
   - `rw` (string, 3 karakter)
   - `dusun` (string)
   - `kode_pos` (string, 5 karakter)
   - `timestamps`
2. **Tabel `wargas`**:
   - `id` (bigint, primary key, auto-increment)
   - `kartu_keluarga_id` (bigint, foreign key, nullable - cascade on delete / set null)
   - `nik` (string, 16 karakter, unique)
   - `nama` (string)
   - `tempat_lahir` (string)
   - `tanggal_lahir` (date)
   - `jenis_kelamin` (enum: 'Laki-laki', 'Perempuan')
   - `agama` (string)
   - `status_perkawinan` (enum: 'Belum Kawin', 'Kawin', 'Cerai Hidup', 'Cerai Mati')
   - `pekerjaan` (string)
   - `alamat` (text)
   - `rt` (string, 3 karakter)
   - `rw` (string, 3 karakter)
   - `dusun` (string)
   - `status_hubungan_keluarga` (enum: 'Kepala Keluarga', 'Suami', 'Istri', 'Anak', 'Mertua', 'Orang Tua', 'Lainnya')
   - `status_keaktifan` (enum: 'Aktif', 'Meninggal', 'Pindah')
   - `user_id` (bigint, foreign key, nullable - ditautkan ke tabel `users` untuk akun portal warga)
   - `timestamps`
3. **Tabel `mutasi_penduduks`**:
   - `id` (bigint, primary key, auto-increment)
   - `warga_id` (bigint, foreign key, cascade on delete)
   - `jenis_mutasi` (enum: 'Lahir', 'Meninggal', 'Masuk', 'Keluar')
   - `tanggal_mutasi` (date)
   - `keterangan` (text)
   - `timestamps`

### B. Eloquent Models & Relasi
1. **Model `KartuKeluarga`**:
   - Relasi `hasMany(Warga::class)` untuk mengambil semua anggota keluarga.
   - Relasi `belongsTo(Warga::class, 'kepala_keluarga_id')` untuk mengambil profil kepala keluarga.
2. **Model `Warga`**:
   - Relasi `belongsTo(KartuKeluarga::class)` untuk kartu keluarga.
   - Relasi `belongsTo(User::class)` untuk akun login sistem.
   - Relasi `hasMany(MutasiPenduduk::class)` untuk mencatat riwayat mutasi warga.
3. **Model `MutasiPenduduk`**:
   - Relasi `belongsTo(Warga::class)` untuk melihat profil warga yang bersangkutan.

### C. Controllers & Routing
1. **`KartuKeluargaController`** (Resource Controller):
   - `index()`: Menampilkan daftar kartu keluarga.
   - `create()`, `store()`: Input KK baru.
   - `show()`: Menampilkan detail KK lengkap dengan daftar anggota keluarga di dalamnya.
   - `edit()`, `update()`, `destroy()`.
2. **`WargaController`** (Resource Controller):
   - Mengelola data individu warga.
   - Pada form create/edit warga, sediakan input dropdown `kartu_keluarga_id` (menggunakan Select2) untuk menautkan warga ke KK.
3. **`MutasiPendudukController`** (Resource Controller):
   - Menginput mutasi warga. Jika status mutasi berupa 'Meninggal' atau 'Keluar', secara otomatis perbarui kolom `status_keaktifan` pada tabel `wargas` menjadi 'Meninggal' atau 'Pindah'.
4. **Routing (`routes/web.php`)**:
   - Daftarkan resource route untuk ketiga controller tersebut di dalam middleware `auth` dan batasi akses hanya untuk role `Superadmin` dan `Staf` (kecuali route `show` profil warga).

### D. Seeders (Dummy Data Generation)
- **Target File**: `database/seeders/KependudukanSeeder.php`
- **Tanggung Jawab**:
  - Buat minimal 5 Kartu Keluarga dummy.
  - Buat minimal 15-20 data Warga dummy yang tersebar ke dalam Kartu Keluarga tersebut (termasuk menetapkan salah satu anggota keluarga sebagai Kepala Keluarga).
  - Buat minimal 3-5 data mutasi penduduk dummy (misal: pencatatan kematian atau kepindahan) untuk mengisi histori mutasi kependudukan.

### E. Views (UI/UX NiceAdmin & Bootstrap 5)
- Gunakan tata letak grid dan tabel responsif dari template NiceAdmin.
- Gunakan library **DataTables** untuk semua halaman list (index) agar pencarian NIK/Nama warga instan.
- Gunakan detail view menggunakan Ajax modal bootstrap (mengikuti template `UserController.php`).
- Sediakan validasi form client-side (menggunakan Parsley.js jika terintegrasi, atau bawaan HTML5) dan server-side yang menampilkan pesan error yang rapi di bawah input yang tidak valid.

## 4. Rencana Pengujian & Kriteria Penerimaan
- [ ] Berhasil membuat data Kartu Keluarga baru melalui form admin.
- [ ] Berhasil menambahkan anggota keluarga baru ke dalam Kartu Keluarga, dan nama Kepala Keluarga ter-update secara otomatis di list KK.
- [ ] Berhasil mencatat mutasi 'Meninggal' untuk salah satu warga, dan status keaktifan warga tersebut otomatis berubah menjadi 'Meninggal'.
- [ ] Pencarian warga menggunakan NIK atau Nama berjalan instan di tabel pencarian (DataTables).
- [ ] Database seeder berhasil dijalankan tanpa error dan menghasilkan visualisasi data demografi awal yang kaya di database.
