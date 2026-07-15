<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ArsipDokumen;
use App\Models\User;
use Carbon\Carbon;

class ArsipDokumenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $staf = User::where('role', 'Staf')->first();

        $arsips = [
            [
                'judul' => 'Laporan Pertanggungjawaban Dana Desa 2025',
                'jenis_dokumen' => 'Laporan',
                'file_path' => 'public/arsip/dummy1.pdf',
                'tanggal_arsip' => Carbon::now()->subMonths(1),
                'keterangan' => 'Laporan akhir tahun terkait penggunaan anggaran dana desa tahun 2025.',
            ],
            [
                'judul' => 'Notulen Rapat BPD Januari',
                'jenis_dokumen' => 'Notulen',
                'file_path' => 'public/arsip/dummy2.pdf',
                'tanggal_arsip' => Carbon::now()->subMonths(2),
                'keterangan' => 'Notulen rapat pembahasan program kerja tahunan.',
            ],
            [
                'judul' => 'SK Kades Pengangkatan Perangkat',
                'jenis_dokumen' => 'Surat',
                'file_path' => 'public/arsip/dummy3.pdf',
                'tanggal_arsip' => Carbon::now()->subMonths(3),
                'keterangan' => 'Surat Keputusan pengangkatan staf desa yang baru.',
            ],
            [
                'judul' => 'Peraturan Desa No 3 Tahun 2024',
                'jenis_dokumen' => 'Lainnya',
                'file_path' => 'public/arsip/dummy4.pdf',
                'tanggal_arsip' => Carbon::now()->subMonths(4),
                'keterangan' => 'Perdes tentang ketertiban lingkungan.',
            ],
            [
                'judul' => 'Proposal Pembangunan Jembatan',
                'jenis_dokumen' => 'Surat',
                'file_path' => 'public/arsip/dummy5.pdf',
                'tanggal_arsip' => Carbon::now()->subMonths(5),
                'keterangan' => 'Proposal permohonan dana pembangunan infrastruktur.',
            ]
        ];

        foreach ($arsips as $arsip) {
            $arsip['diarsipkan_oleh'] = $staf->id ?? 1;
            ArsipDokumen::create($arsip);
        }
    }
}
