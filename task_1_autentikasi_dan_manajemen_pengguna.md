# Task 1: Autentikasi dan Manajemen Pengguna

## 1. Tujuan
Menyesuaikan sistem autentikasi dan manajemen pengguna (User Management) yang sudah ada di Laravel agar selaras dengan `PRD.md`, khususnya terkait penambahan peran pengguna (User Role) baru (`Superadmin`, `Kades_Lurah`, `Staf`, `Warga`), penyesuaian struktur tabel, pembaruan data dummy via seeder, serta penyesuaian logika CRUD agar mengenali peran yang baru tanpa membuat pola baru yang tidak konsisten dengan modul user saat ini.

## 2. Ketergantungan
- Tidak ada (merupakan task fondasi).

## 3. Detail Teknis Implementasi

### A. Database & Migrasi
- **Target File**: `database/migrations/0001_01_01_000000_create_users_table.php`
- **Perubahan**:
  - Ubah kolom enum `role` pada tabel `users` untuk menampung empat role baru:
    ```php
    $table->enum('role', ['Superadmin', 'Kades_Lurah', 'Staf', 'Warga'])->default('Warga');
    ```

### B. Eloquent Model
- **Target File**: `app/Models/User.php`
- **Perubahan**:
  - Pastikan pengisian massal (`#[Fillable]`) tetap mengizinkan kolom `role`.
  - Tambahkan metode helper untuk mempermudah pengecekan role jika diperlukan di masa depan, namun tetap pertahankan struktur default.

### C. Seeder & Data Dummy
- **Target File**: `database/seeders/UserSeeder.php`
- **Perubahan**:
  - Perbarui daftar pengguna default agar mencakup perwakilan dari keempat role dengan email dan kredensial uji coba:
    1. **Superadmin**: `tamus@gmail.com` (Tamus Tahir)
    2. **Kades/Lurah**: `kades@gmail.com` (Pak Kades)
    3. **Staf**: `staf@gmail.com` (Operator Desa)
    4. **Warga**: `warga@gmail.com` (Budi Warga)
  - Password default untuk semua akun uji coba: `password`.

### D. Controller (CRUD Logic)
- **Target File**: `app/Http/Controllers/UserController.php`
- **Perubahan**:
  - **Validation**:
    - Sesuaikan aturan validasi `role` pada method `store()` dan `update()` agar memastikan input hanya boleh berupa salah satu dari `Superadmin`, `Kades_Lurah`, `Staf`, atau `Warga`.
    - Aturan validasi: `'role' => 'required|in:Superadmin,Kades_Lurah,Staf,Warga'`.
  - **Logic**:
    - Pastikan semua fitur upload avatar, enkripsi password, dan database transaction (`DB::beginTransaction()` / `DB::commit()`) tetap dipertahankan persis seperti struktur controller saat ini.

### E. Views (UI/UX NiceAdmin)
- **Target File**: 
  1. `resources/views/user/create.blade.php`
  2. `resources/views/user/edit.blade.php`
  3. `resources/views/user/index.blade.php`
- **Perubahan**:
  - Pada form `create.blade.php` dan `edit.blade.php`, perbarui elemen `<select id="role">` agar memiliki opsi-opsi berikut:
    ```html
    <option value="Superadmin" @selected(old('role', $user->role ?? '') == 'Superadmin')>Superadmin</option>
    <option value="Kades_Lurah" @selected(old('role', $user->role ?? '') == 'Kades_Lurah')>Kepala Desa / Lurah</option>
    <option value="Staf" @selected(old('role', $user->role ?? '') == 'Staf')>Staf / Operator Desa</option>
    <option value="Warga" @selected(old('role', $user->role ?? '') == 'Warga')>Warga Desa</option>
    ```
  - Pada halaman `index.blade.php` dan `show.blade.php`, pastikan badge warna untuk masing-masing role ditampilkan dengan estetis dan rapi menggunakan utility class Bootstrap (misalnya warna biru untuk Superadmin, hijau untuk Kades, kuning untuk Staf, abu-abu/sekunder untuk Warga).

## 4. Rencana Pengujian & Kriteria Penerimaan
- [ ] Migrasi database berhasil dijalankan tanpa galat (`php artisan migrate:fresh --seed`).
- [ ] Pengguna dengan role `Superadmin`, `Kades_Lurah`, `Staf`, dan `Warga` berhasil dibuat oleh seeder dan dapat digunakan untuk masuk (login) ke dalam aplikasi.
- [ ] Pengguna dengan role `Superadmin` dapat mengakses halaman `/user` dan mengelola (Create, Read, Update, Delete) pengguna lain dengan role yang baru.
- [ ] Validasi form menolak input role di luar `Superadmin`, `Kades_Lurah`, `Staf`, atau `Warga`.
