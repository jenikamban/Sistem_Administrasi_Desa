# Task 9: Inventaris Desa

## 1. Tujuan
Membangun modul pencatatan dan pelacakan aset desa. Modul ini bertujuan memastikan seluruh barang investasi dan kekayaan desa (kendaraan dinas, peralatan kantor, mesin, hingga bangunan) tercatat secara akurat mulai dari kondisi, letak, hingga staf yang menjadi penanggung jawab utamanya.

## 2. Ketergantungan
- **Task 1**: Untuk otentikasi admin dan pengambilan referensi daftar staf (untuk ditugaskan sebagai `penanggung_jawab_id`).

## 3. Detail Teknis Implementasi

### A. Database & Migrasi (Migrations)
- **Tabel `inventaris_desas`**:
  - `id` (bigint, primary key, auto-increment)
  - `nama_item` (string - nama/merk aset, misal: 'Motor Dinas Kepala Desa', 'Laptop Lenovo Staf')
  - `kategori` (string - enum disarankan, contoh: 'Kendaraan', 'Peralatan Elektronik', 'Bangunan', 'Lainnya')
  - `jumlah` (integer - kuantitas barang)
  - `kondisi` (enum: 'Baik', 'Rusak Ringan', 'Rusak Berat')
  - `lokasi` (string - letak fisik aset, misal: 'Ruang Kepala Desa', 'Gudang')
  - `penanggung_jawab_id` (bigint, foreign key ditautkan ke `users.id` - mencatat pejabat/staf yang memegang/bertanggung jawab)
  - `tanggal_pencatatan` (timestamp - kapan aset dibeli/didata)
  - `keterangan` (text, nullable - detail spesifikasi, nomor rangka/mesin, dsb.)
  - `timestamps`

### B. Eloquent Models & Relasi
- **Model `InventarisDesa`**:
  - Relasi `belongsTo(User::class, 'penanggung_jawab_id')` untuk mengetahui staf yang bertanggung jawab atas aset.

### C. Controllers & Routing
1. **`InventarisDesaController`** (Resource Controller):
   - `index()`: Tampilkan daftar seluruh aset desa menggunakan DataTables. Sertakan filter/dropdown untuk menyortir aset berdasarkan "Kondisi" (sehingga staf cepat mengetahui aset apa saja yang rusak) atau "Kategori".
   - `create()`, `store()`: Input data aset baru. Gunakan elemen *dropdown select* untuk kolom Penanggung Jawab dengan menarik data pengguna ber-role `Staf` dan `Kades_Lurah` dari tabel `users`.
   - `edit()`, `update()`: Form untuk mengubah kondisi barang (misal dari 'Baik' menjadi 'Rusak Ringan') jika terjadi depresiasi/kerusakan seiring berjalannya waktu.
   - `destroy()`: Hapus aset jika barang sudah dijual/dihibahkan/dimusnahkan (sebaiknya berikan peringatan ekstra/SweetAlert).
2. **Routing (`routes/web.php`)**:
   - Daftarkan resource route di dalam middleware `auth` dan batasi untuk `Superadmin` atau `Staf`.

### D. Seeders (Dummy Data Generation)
- **Target File**: `database/seeders/InventarisDesaSeeder.php`
- **Tanggung Jawab**:
  - Buat minimal 10 aset dummy dengan variasi kategori.
  - Variasikan kondisi barang (mayoritas 'Baik', sisipkan 'Rusak Ringan' dan 'Rusak Berat' agar filter/badge warna di DataTables dapat teruji visualisasinya).
  - Tautkan `penanggung_jawab_id` secara acak ke ID staf dari seeder User yang telah di-generate sebelumnya.

### E. Views (UI/UX NiceAdmin)
- **Index View**: Tabel informatif dengan label warna untuk status/kondisi: 
  - Hijau: Baik
  - Kuning: Rusak Ringan
  - Merah: Rusak Berat
- **Dashboard Integrasi (Opsional)**: Di masa depan (atau tambahkan modifikasi kecil di Task 7), tampilkan ringkasan jumlah barang 'Rusak Berat' pada halaman Dashboard Admin agar dapat segera dianggarkan biaya perbaikannya.

## 4. Rencana Pengujian & Kriteria Penerimaan
- [ ] Staf dapat menambahkan data aset/inventaris baru beserta detail penanggung jawabnya.
- [ ] Data aset yang diinput langsung muncul di dalam tabel inventaris (DataTables).
- [ ] Staf dapat memfilter tabel untuk hanya menampilkan aset dengan kategori 'Kendaraan' atau kondisi 'Rusak Ringan'.
- [ ] Kolom penanggung jawab di tabel index merender nama staf secara tepat sesuai relasi `users.name`.
- [ ] Seeder berhasil berjalan dan menyisipkan data dummy aset yang melimpah dan bervariasi.
