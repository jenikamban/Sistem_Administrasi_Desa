<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Berita;
use App\Models\ApbdRealisasi;
use App\Models\User;

class PublikasiSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('role', 'Superadmin')->first() ?? User::first();

        // 4 Artikel Berita
        $beritas = [
            [
                'judul' => 'Kegiatan Posyandu Balita Dusun I',
                'kategori' => 'Kegiatan',
                'konten' => '<p>Kegiatan posyandu balita rutin diadakan setiap bulan. <strong>Bulan ini</strong> partisipasi warga sangat tinggi.</p><ul><li>Pemeriksaan berat badan</li><li>Pemberian vitamin A</li><li>Penyuluhan gizi</li></ul>',
                'status' => 'Published',
            ],
            [
                'judul' => 'Pengumuman Pendaftaran Bantuan Sosial Terpadu',
                'kategori' => 'Pengumuman',
                'konten' => '<p>Diberitahukan kepada seluruh warga bahwa pendaftaran bansos terpadu telah dibuka mulai hari ini. Syarat pendaftaran:</p><ol><li>Fotokopi KK</li><li>Fotokopi KTP</li><li>Surat Keterangan Tidak Mampu (SKTM)</li></ol>',
                'status' => 'Published',
            ],
            [
                'judul' => 'Penyuluhan Pertanian Organik Bersama Dinas Terkait',
                'kategori' => 'Penyuluhan',
                'konten' => '<p>Meningkatkan hasil panen dengan menggunakan <em>pupuk organik</em> buatan sendiri. Dinas pertanian memberikan pelatihan khusus kepada para petani desa.</p>',
                'status' => 'Published',
            ],
            [
                'judul' => 'Persiapan Lomba Desa Tingkat Kabupaten (Draft)',
                'kategori' => 'Kegiatan',
                'konten' => '<p>Rapat persiapan lomba desa masih terus berlangsung. Kami harap...</p>',
                'status' => 'Draft',
            ],
        ];

        foreach ($beritas as $b) {
            $b['penulis_id'] = $admin->id;
            Berita::create($b);
        }

        // 8 Data APBD Realisasi
        $apbd = [
            ['kategori' => 'Pendapatan', 'nama_item' => 'Dana Desa (APBN)', 'anggaran' => 850000000, 'realisasi' => 850000000, 'tahun' => 2026],
            ['kategori' => 'Pendapatan', 'nama_item' => 'Alokasi Dana Desa (ADD)', 'anggaran' => 450000000, 'realisasi' => 450000000, 'tahun' => 2026],
            ['kategori' => 'Pendapatan', 'nama_item' => 'Bagi Hasil Pajak & Retribusi', 'anggaran' => 75000000, 'realisasi' => 50000000, 'tahun' => 2026],
            ['kategori' => 'Pendapatan', 'nama_item' => 'Pendapatan Asli Desa (BUMDes)', 'anggaran' => 150000000, 'realisasi' => 125000000, 'tahun' => 2026],
            ['kategori' => 'Belanja', 'nama_item' => 'Penyelenggaraan Pemerintahan', 'anggaran' => 350000000, 'realisasi' => 320000000, 'tahun' => 2026],
            ['kategori' => 'Belanja', 'nama_item' => 'Pembangunan Infrastruktur', 'anggaran' => 650000000, 'realisasi' => 450000000, 'tahun' => 2026],
            ['kategori' => 'Belanja', 'nama_item' => 'Pembinaan Kemasyarakatan', 'anggaran' => 250000000, 'realisasi' => 200000000, 'tahun' => 2026],
            ['kategori' => 'Belanja', 'nama_item' => 'Pemberdayaan Masyarakat', 'anggaran' => 200000000, 'realisasi' => 150000000, 'tahun' => 2026],
        ];

        foreach ($apbd as $a) {
            ApbdRealisasi::create($a);
        }
    }
}
