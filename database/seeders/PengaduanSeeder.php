<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Pengaduan;
use App\Models\Warga;
use App\Models\User;

class PengaduanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $wargas = Warga::all();
        $staf = User::whereIn('role', ['Staf', 'Superadmin'])->first();

        if ($staf) {
            // 1. Pending (Anonim)
            Pengaduan::create([
                'warga_id' => null,
                'judul' => 'Lampu Jalan Mati di RT 01',
                'isi_laporan' => 'Terdapat 3 lampu jalan yang mati di sepanjang jalan utama RT 01. Mohon segera diperbaiki karena rawan kecelakaan.',
                'kategori' => 'Infrastruktur',
                'status' => 'Pending',
            ]);

            // 4. Selesai (Anonim)
            Pengaduan::create([
                'warga_id' => null,
                'judul' => 'Jalan Berlubang di Depan Balai Desa',
                'isi_laporan' => 'Ada lubang cukup dalam di jalan masuk balai desa.',
                'kategori' => 'Infrastruktur',
                'status' => 'Selesai',
                'tanggapan' => 'Sudah dilakukan penambalan oleh tim gotong royong pagi ini. Terima kasih laporannya.',
                'tanggapan_oleh' => $staf->id,
            ]);

            if ($wargas->count() > 0) {
                // 2. Pending (Non-anonim)
                Pengaduan::create([
                    'warga_id' => $wargas->random()->id,
                    'judul' => 'Tumpukan Sampah di Dekat Sungai',
                    'isi_laporan' => 'Ada tumpukan sampah yang belum diangkut selama seminggu di dekat jembatan sungai.',
                    'kategori' => 'Kebersihan',
                    'status' => 'Pending',
                ]);

                // 3. Diproses (Non-anonim)
                Pengaduan::create([
                    'warga_id' => $wargas->random()->id,
                    'judul' => 'Keamanan Pos Ronda Kurang',
                    'isi_laporan' => 'Perlu tambahan jadwal ronda malam karena belakangan banyak laporan kehilangan ayam.',
                    'kategori' => 'Keamanan',
                    'status' => 'Diproses',
                    'tanggapan' => 'Laporan diterima. Kami akan berkoordinasi dengan Ketua RT dan Linmas untuk penambahan jadwal.',
                    'tanggapan_oleh' => $staf->id,
                ]);

                // 5. Ditolak (Non-anonim)
                Pengaduan::create([
                    'warga_id' => $wargas->random()->id,
                    'judul' => 'Bantuan Sosial Tidak Tepat Sasaran',
                    'isi_laporan' => 'Banyak warga mampu yang dapat bantuan.',
                    'kategori' => 'Sosial',
                    'status' => 'Ditolak',
                    'tanggapan' => 'Mohon sertakan data spesifik RT/RW dan nama agar kami dapat memverifikasi. Laporan yang terlalu umum tidak dapat diproses lebih lanjut.',
                    'tanggapan_oleh' => $staf->id,
                ]);
            }
        }
    }
}
