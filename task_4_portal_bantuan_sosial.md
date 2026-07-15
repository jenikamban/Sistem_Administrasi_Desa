# Task 4: Portal Bantuan Sosial

## 1. Tujuan
Membangun modul pengelolaan program bantuan sosial (Bansos) tingkat desa/kelurahan. Modul ini digunakan untuk mencatat berbagai program bantuan sosial (seperti PKH, BLT Dana Desa, BST, dll), menyeleksi warga penerima bantuan secara transparan, serta memfasilitasi warga untuk mencari dan memverifikasi status kepenerimaan bantuan secara mandiri menggunakan NIK.

## 2. Ketergantungan
- **Task 1**: Untuk otentikasi admin/staf dan warga.
- **Task 2**: Untuk mencari NIK warga dan memverifikasi data profil penerima bantuan.

## 3. Detail Teknis Implementasi

### A. Database & Migrasi (Migrations)
1. **Tabel `bantuan_sosials`**:
   - `id` (bigint, primary key, auto-increment)
   - `nama_program` (string - contoh: 'PKH', 'BLT Dana Desa', 'Bansos Sembako')
   - `deskripsi` (text)
   - `sumber_dana` (string - contoh: 'APBD Kabupaten', 'APBN', 'Dana Desa')
   - `tahun` (integer)
   - `timestamps`
2. **Tabel `penerima_bantuans`**:
   - `id` (bigint, primary key, auto-increment)
   - `bantuan_sosial_id` (bigint, foreign key, cascade on delete)
   - `warga_id` (bigint, foreign key, cascade on delete)
   - `status_penerimaan` (enum: 'Aktif', 'Ditangguhkan', 'Diberhentikan')
   - `keterangan` (text, nullable - alasan penangguhan atau info tambahan)
   - `timestamps`
   - *Indeks Unik*: Tambahkan indeks unik gabungan (`bantuan_sosial_id`, `warga_id`) untuk mencegah satu warga terdaftar dua kali pada program bansos yang sama di tahun yang sama.

### B. Eloquent Models & Relasi
1. **Model `BantuanSosial`**:
   - Relasi `hasMany(PenerimaBantuan::class)` untuk mengambil semua baris data penerima bantuan terkait.
   - Relasi `belongsToMany(Warga::class, 'penerima_bantuans')` untuk relasi langsung ke data model warga penerima bantuan.
2. **Model `PenerimaBantuan`**:
   - Relasi `belongsTo(BantuanSosial::class)`.
   - Relasi `belongsTo(Warga::class)`.

### C. Controllers & Routing
1. **`BantuanSosialController`** (Resource Controller):
   - CRUD Program Bansos (hanya diakses oleh Superadmin dan Staf).
2. **`PenerimaBantuanController`**:
   - `store(Request $request)`: Menambahkan warga sebagai penerima program bansos tertentu (menggunakan pencarian Select2 untuk NIK warga).
   - `update(Request $request, PenerimaBantuan $penerima)`: Mengubah status kepenerimaan bansos (misal dari 'Aktif' menjadi 'Ditangguhkan').
   - `destroy(PenerimaBantuan $penerima)`: Menghapus warga dari daftar penerima bansos.
3. **`PortalBansosController`** (Warga Route / Public Check):
   - `check(Request $request)`: Halaman pencarian bagi warga. Warga memasukkan NIK mereka ke dalam form pencarian, dan sistem menampilkan daftar program bantuan sosial yang diterima warga tersebut jika NIK terdaftar, lengkap dengan status keaktifannya.
4. **Routing (`routes/web.php`)**:
   - Proteksi CRUD program dan penerima bansos dalam middleware `auth` dan middleware `role` untuk `Superadmin` dan `Staf`.
   - Buka route pencarian status bansos `/bansos/cek` untuk warga (atau buat agar dapat diakses tanpa login/login warga).

### D. Seeders (Dummy Data Generation)
- **Target File**: `database/seeders/BantuanSosialSeeder.php`
- **Tanggung Jawab**:
  - Buat minimal 3 program bansos dummy (misal: 'BLT Dana Desa 2026', 'PKH Tahap 1', 'Bansos Sembako Darurat').
  - Hubungkan masing-masing program dengan 3-5 warga penerima dummy secara acak dari database warga hasil seeder Task 2.

### E. Views (UI/UX NiceAdmin & Portal Warga)
- **Dashboard Admin**: Halaman pengelolaan program bansos yang menampilkan jumlah penerima per program menggunakan card widget yang cantik. Sediakan halaman detail program di mana operator dapat menambah penerima baru secara cepat menggunakan dropdown select2.
- **Portal Warga / Cek Bansos**: Halaman landing page sederhana dengan input teks NIK. Tampilkan hasil pencarian menggunakan Alert Box yang rapi (hijau jika terdaftar aktif, kuning jika ditangguhkan, merah jika tidak ditemukan data penerimaan).

## 4. Rencana Pengujian & Kriteria Penerimaan
- [ ] Staf berhasil menambahkan program bansos baru.
- [ ] Staf dapat memetakan warga ke program bansos menggunakan dropdown Select2 pencarian NIK.
- [ ] Sistem menolak jika staf mencoba mendaftarkan warga yang sama ke program bansos yang sama untuk kedua kalinya (validasi Unique Constraint).
- [ ] Warga berhasil memeriksa status bantuan sosial mereka menggunakan NIK di portal warga dan melihat status keaktifannya dengan benar.
