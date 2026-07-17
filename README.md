# Sistem Administrasi Desa

Sistem Administrasi Desa adalah sebuah aplikasi berbasis **Laravel 13** dan **Bootstrap 5 (NiceAdmin)** yang dirancang untuk membantu pengelolaan administrasi desa secara digital. Aplikasi ini mempermudah aparatur desa dalam mengelola data kependudukan, layanan persuratan, transparansi informasi, hingga pengelolaan inventaris.

## 🚀 Fitur Utama

- **Otentikasi & Keamanan**: Login, Logout, dan Middleware Multi-Role (Superadmin, Admin, Staf, Kades/Lurah, Warga).
- **Manajemen Kependudukan**: Pengelolaan data Kartu Keluarga (KK), Warga, dan Mutasi Penduduk.
- **Layanan Publik**:
    - **Surat Menyurat**: Warga dapat mengajukan permohonan surat (Domisili, Usaha, dll) secara online.
    - **Pengaduan & Aspirasi**: Sistem pelaporan keluhan/saran dari warga untuk ditindaklanjuti oleh aparatur desa.
- **Bantuan Sosial**: Pencatatan program bantuan sosial dan data penerima bantuan agar tepat sasaran.
- **Publikasi & Transparansi**: 
    - **Berita Desa**: Publikasi artikel dan kegiatan desa.
    - **Realisasi APBD**: Transparansi anggaran pendapatan dan belanja desa.
- **Manajemen Arsip & Inventaris**: Penyimpanan arsip dokumen desa dan pendataan barang inventaris desa.
- **Dashboard Analitik & Laporan**: Laporan statistik penduduk, grafik umur/jenis kelamin, serta tren pengajuan surat.

## 🎨 Kustomisasi Tema (Warna)

Aplikasi ini menggunakan tema yang mudah disesuaikan warnanya. Ubah **CSS Variables** pada `resources/views/layouts/app.blade.php`:

```css
:root {
    /* ====== UBAH WARNA TEMA DI SINI ====== */
    --theme-bg: #000080;    /* Warna utama tema */
    --theme-hover: #020260; /* Warna lebih gelap untuk efek hover */
    --theme-text: #ffffff;  /* Warna teks */
    --main-bg: #eeeeee;     /* Warna background halaman */
}
```

## 🔑 Kredensial Default

Setelah menjalankan seeder, Anda dapat login menggunakan akun berikut:

| Nama        | Role       | Email / Username  | Password   |
| ----------- | ---------- | ----------------- | ---------- |
| Tamus Tahir | Superadmin | `tamus@gmail.com` | `password` |
| Joh Doe     | Admin      | `admin@gmail.com` | `password` |
| Staf Desa   | Staf       | `staf@desa.id`    | `password` |
| Pak Kades   | Kades_Lurah| `kades@desa.id`   | `password` |
| Budi Warga  | Warga      | `warga@desa.id`   | `password` |

*(Catatan: Akun lain dapat dilihat pada database atau seeder sesuai pengaturan).*

## 🛠️ Stack Teknologi

- **Backend**: PHP 8.3 & Laravel 13.0
- **Frontend**: Bootstrap 5 (NiceAdmin Template), DataTables, SweetAlert2, Select2, ApexCharts.
- **Database**: MySQL / SQLite (default)
- **Library Tambahan**: `barryvdh/laravel-dompdf` untuk cetak surat/laporan.

## 💻 Instalasi Lokal

Ikuti langkah-langkah berikut untuk menjalankan proyek di mesin lokal Anda:

1. **Clone Repositori**:
    ```bash
    git clone https://github.com/jenikamban/Sistem_Administrasi_Desa.git
    cd Sistem_Administrasi_Desa
    ```

2. **Instal Dependensi**:
    ```bash
    composer install
    npm install
    ```

3. **Konfigurasi Lingkungan**:
    Salin file `.env.example` menjadi `.env` dan generate key:
    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

4. **Setup Database**:
    Sesuaikan konfigurasi database di file `.env`. Untuk SQLite:
    ```bash
    touch database/database.sqlite
    php artisan migrate --seed
    ```

5. **Jalankan Aplikasi**:
    ```bash
    php artisan serve
    npm run dev
    ```

## 📄 Lisensi

Proyek ini bersifat open-source di bawah lisensi [MIT](https://opensource.org/licenses/MIT).
