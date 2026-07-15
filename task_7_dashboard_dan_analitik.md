# Task 7: Dashboard dan Analitik

## 1. Tujuan
Membangun dasbor analitis eksekutif bagi perangkat desa (Kepala Desa, Lurah, dan Staf). Dasbor ini menyajikan ringkasan visual berupa matriks data kependudukan (jenis kelamin, usia, pekerjaan), statistik pelayanan surat-menyurat, monitoring pengaduan aktif, serta gambaran penyaluran bantuan sosial secara real-time.

## 2. Ketergantungan
- **Task 1** s/d **Task 6**: Dasbor ini merangkum data dari seluruh modul yang telah dikembangkan sebelumnya.

## 3. Detail Teknis Implementasi

### A. Controller (Dashboard Logic)
- **Target File**: `app/Http/Controllers/DashboardController.php`
- **Perubahan**:
  - Ganti query statis pada dashboard controller dengan agregasi data dinamis dari database:
    - **Widget Utama**:
      - Total Penduduk (hitung baris aktif pada tabel `wargas`).
      - Total Kepala Keluarga (hitung baris pada tabel `kartu_keluargas`).
      - Pengajuan Surat Menunggu Persetujuan (hitung baris status `Menunggu_Tanda_Tangan` dan `Ditinjau_Staf` pada tabel `surat_permohonans`).
      - Pengaduan Baru Aktif (hitung status `Pending` pada tabel `pengaduans`).
    - **Demografi Chart Data**:
      - Agregasi jumlah penduduk berdasarkan Jenis Kelamin (`Laki-laki` vs `Perempuan`).
      - Agregasi berdasarkan kelompok umur (misal: Balita <5 th, Anak-anak 5-12 th, Remaja 13-18 th, Produktif 19-59 th, Lansia >60 th).
      - Agregasi berdasarkan 5 Pekerjaan terpopuler.
    - **Statistik Pelayanan Surat**:
      - Agregasi jumlah pengajuan surat masuk per bulan untuk tahun berjalan untuk melihat tren pelayanan.

### B. Routes (`routes/web.php`)
- Pastikan route dashboard index `/dashboard` memproses data agregasi yang dikirim dari `DashboardController`.

### C. Seeder Integration
- Dasbor ini tidak memerlukan seeder mandiri baru. Dasbor akan memanfaatkan data dummy yang telah dihasilkan oleh `UserSeeder`, `KependudukanSeeder`, `SuratPermohonanSeeder`, `BantuanSosialSeeder`, `PengaduanSeeder`, dan `PublikasiSeeder`.

### D. Views (UI/UX NiceAdmin & Charts)
- **Target File**: `resources/views/dashboard/index.blade.php`
- **Perubahan**:
  - Tampilkan widget angka ringkasan di bagian paling atas dengan ikon-ikon yang representatif dari library Boxicons (contoh: ikon warga untuk penduduk, ikon surat untuk permohonan).
  - Gunakan **ApexCharts** (yang sudah bawaan terintegrasi di NiceAdmin) untuk menggambar:
    - **Donut/Pie Chart**: Representasi demografi jenis kelamin dan kelompok umur warga.
    - **Bar Chart**: 5 jenis pekerjaan terpopuler di desa.
    - **Area/Line Chart**: Tren pengajuan dan penyelesaian surat dari bulan ke bulan.
  - Sediakan tabel mini "Pengajuan Surat Terbaru" dan "Laporan Pengaduan Terkini" untuk mempermudah navigasi staf mengakses data yang memerlukan tindakan cepat langsung dari halaman depan dasbor.

## 4. Rencana Pengujian & Kriteria Penerimaan
- [ ] Angka widget utama pada dasbor (Total Penduduk, KK, Surat, Aduan) menampilkan data riil yang sinkron dengan database.
- [ ] Grafik donat/pie Chart merender proporsi persentase demografi warga dengan benar dan memiliki legenda interaktif.
- [ ] Grafik area/line Chart menampilkan histori jumlah transaksi surat per bulan secara dinamis.
- [ ] Dasbor termuat dengan cepat (< 1,5 detik) tanpa performa kueri yang lambat (N+1 query issue dihindari dengan menggunakan *eager loading* jika diperlukan).
