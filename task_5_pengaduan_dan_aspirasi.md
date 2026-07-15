# Task 5: Pengaduan dan Aspirasi Warga

## 1. Tujuan
Membangun modul pelaporan pengaduan dan aspirasi warga desa secara digital. Modul ini bertujuan memberikan saluran pengaduan bagi warga mengenai isu-isu infrastruktur, kebersihan, keamanan, atau pelayanan sosial di desa, serta memfasilitasi staf desa untuk memberikan respon/tanggapan secara langsung dan transparan.

## 2. Ketergantungan
- **Task 1**: Untuk otentikasi user dan otorisasi role (Warga vs Staf).
- **Task 2**: Untuk menautkan data pengadu (warga) jika laporan tidak bersifat anonim.

## 3. Detail Teknis Implementasi

### A. Database & Migrasi (Migrations)
- **Tabel `pengaduans`**:
  - `id` (bigint, primary key, auto-increment)
  - `warga_id` (bigint, foreign key, nullable, cascade on delete - bernilai `NULL` jika warga memilih opsi laporan secara anonim)
  - `judul` (string)
  - `isi_laporan` (text)
  - `kategori` (enum: 'Infrastruktur', 'Keamanan', 'Sosial', 'Kebersihan', 'Lainnya')
  - `foto` (string, nullable - path gambar bukti fisik masalah yang dilaporkan)
  - `status` (enum: 'Pending', 'Diproses', 'Selesai', 'Ditolak')
  - `tanggapan` (text, nullable - respon/tanggapan tertulis dari staf desa)
  - `tanggapan_oleh` (bigint, foreign key, nullable - ditautkan ke tabel `users` untuk mencatat siapa staf yang merespon)
  - `timestamps`

### B. Eloquent Model `Pengaduan`
- Relasi `belongsTo(Warga::class)` untuk mengambil profil pengadu (jika bukan anonim).
- Relasi `belongsTo(User::class, 'tanggapan_oleh')` untuk mengambil profil staf yang memberikan respon.

### C. Controllers & Routing
1. **`PengaduanController`** (Resource Controller):
   - `index()`: 
     - Bagi warga: Menampilkan riwayat pengaduan yang dibuat oleh akun warga yang login saat itu.
     - Bagi staf/admin: Menampilkan seluruh daftar pengaduan dari seluruh warga dengan filter kategori atau status.
   - `create()`, `store()`: Form input pengaduan bagi warga. Mendukung unggah gambar bukti ke folder `storage/app/public/pengaduan/`.
   - `show()`: Menampilkan detail pengaduan beserta riwayat tanggapan staf desa.
   - `respond(Request $request, Pengaduan $pengaduan)`: Method khusus bagi staf/admin untuk menulis tanggapan dan mengubah status pengaduan menjadi 'Diproses', 'Selesai', atau 'Ditolak'.
2. **Routing (`routes/web.php`)**:
   - Daftarkan route resource `pengaduan` dalam middleware `auth`.
   - Tambahkan route POST `/pengaduan/{pengaduan}/respond` khusus untuk role `Superadmin` dan `Staf`.

### D. Seeders (Dummy Data Generation)
- **Target File**: `database/seeders/PengaduanSeeder.php`
- **Tanggung Jawab**:
  - Buat sekitar 5-8 data pengaduan dummy dengan variasi kategori (Infrastruktur, Kebersihan, Keamanan).
  - Variasikan status: beberapa berstatus 'Pending' tanpa tanggapan, beberapa 'Diproses', dan beberapa 'Selesai' lengkap dengan tanggapan admin dummy.
  - Sediakan beberapa laporan berstatus anonim (`warga_id` = null) dan non-anonim.

### E. Views (UI/UX NiceAdmin)
- **Portal Warga (Form Pengaduan)**: Form penginputan yang bersih dan responsif dengan input unggah file gambar, dropdown kategori, dan checkbox bertuliskan "Laporkan secara Anonim".
- **Dashboard Admin (Manajemen Laporan)**: Tampilkan daftar laporan menggunakan tabel dinamis dengan status badge berwarna (Pending = merah, Diproses = kuning, Selesai = hijau). Halaman detail pengaduan harus memiliki form input textarea khusus bagi staf untuk mengetik tanggapan dan tombol radio pilihan status baru.

## 4. Rencana Pengujian & Kriteria Penerimaan
- [ ] Warga berhasil membuat pengaduan baru dengan melampirkan foto bukti fisik.
- [ ] Pengaduan berhasil masuk ke antrean dashboard admin.
- [ ] Staf dapat mengetik tanggapan tertulis dan mengubah status menjadi 'Diproses' atau 'Selesai'.
- [ ] Tanggapan staf langsung muncul pada halaman detail pengaduan di akun warga pelapor.
- [ ] Jika checkbox "Anonim" dicentang saat pengajuan, nama warga tidak akan ditampilkan di dashboard admin dan hanya tertulis "Warga Anonim", namun datanya tetap tersimpan dengan relasi yang benar jika dibutuhkan untuk audit.
