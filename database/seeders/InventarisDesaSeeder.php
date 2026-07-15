<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\InventarisDesa;
use App\Models\User;
use Carbon\Carbon;

class InventarisDesaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $stafIds = User::whereIn('role', ['Staf', 'Kades_Lurah'])->pluck('id')->toArray();
        if (empty($stafIds)) $stafIds = [1];

        $inventaris = [
            [
                'nama_item' => 'Motor Dinas Kepala Desa',
                'kategori' => 'Kendaraan',
                'jumlah' => 1,
                'kondisi' => 'Baik',
                'lokasi' => 'Parkiran Balai Desa',
                'penanggung_jawab_id' => $stafIds[array_rand($stafIds)],
                'keterangan' => 'Yamaha NMAX 155cc, Nopol B 1234 CD'
            ],
            [
                'nama_item' => 'Laptop Lenovo Thinkpad',
                'kategori' => 'Peralatan Elektronik',
                'jumlah' => 2,
                'kondisi' => 'Baik',
                'lokasi' => 'Ruang Staf',
                'penanggung_jawab_id' => $stafIds[array_rand($stafIds)],
                'keterangan' => 'Laptop operasional staf administrasi'
            ],
            [
                'nama_item' => 'Printer Epson L3110',
                'kategori' => 'Peralatan Elektronik',
                'jumlah' => 1,
                'kondisi' => 'Rusak Ringan',
                'lokasi' => 'Ruang Pelayanan',
                'penanggung_jawab_id' => $stafIds[array_rand($stafIds)],
                'keterangan' => 'Tinta warna hitam sering macet'
            ],
            [
                'nama_item' => 'Meja Rapat Kayu Jati',
                'kategori' => 'Lainnya',
                'jumlah' => 1,
                'kondisi' => 'Baik',
                'lokasi' => 'Ruang Rapat Utama',
                'penanggung_jawab_id' => $stafIds[array_rand($stafIds)],
                'keterangan' => 'Meja rapat kapasitas 10 orang'
            ],
            [
                'nama_item' => 'Mesin Fotocopy Canon',
                'kategori' => 'Peralatan Elektronik',
                'jumlah' => 1,
                'kondisi' => 'Rusak Berat',
                'lokasi' => 'Gudang',
                'penanggung_jawab_id' => $stafIds[array_rand($stafIds)],
                'keterangan' => 'Mati total sejak 2 bulan lalu'
            ],
            [
                'nama_item' => 'Kursi Tunggu Besi',
                'kategori' => 'Lainnya',
                'jumlah' => 10,
                'kondisi' => 'Baik',
                'lokasi' => 'Ruang Tunggu Pelayanan',
                'penanggung_jawab_id' => $stafIds[array_rand($stafIds)],
                'keterangan' => 'Kursi tunggu 4 seater'
            ],
            [
                'nama_item' => 'Mobil Ambulance Desa',
                'kategori' => 'Kendaraan',
                'jumlah' => 1,
                'kondisi' => 'Baik',
                'lokasi' => 'Garasi Puskesdes',
                'penanggung_jawab_id' => $stafIds[array_rand($stafIds)],
                'keterangan' => 'Suzuki APV, Siaga 24 Jam'
            ],
            [
                'nama_item' => 'Gedung Serbaguna / Balai Desa',
                'kategori' => 'Bangunan',
                'jumlah' => 1,
                'kondisi' => 'Baik',
                'lokasi' => 'Komplek Balai Desa',
                'penanggung_jawab_id' => $stafIds[array_rand($stafIds)],
                'keterangan' => 'Dibangun tahun 2018'
            ],
            [
                'nama_item' => 'Genset 5000 Watt',
                'kategori' => 'Peralatan Elektronik',
                'jumlah' => 1,
                'kondisi' => 'Rusak Ringan',
                'lokasi' => 'Gudang Belakang',
                'penanggung_jawab_id' => $stafIds[array_rand($stafIds)],
                'keterangan' => 'Perlu ganti oli dan servis rutin'
            ],
            [
                'nama_item' => 'Motor Patroli Linmas',
                'kategori' => 'Kendaraan',
                'jumlah' => 2,
                'kondisi' => 'Baik',
                'lokasi' => 'Pos Linmas',
                'penanggung_jawab_id' => $stafIds[array_rand($stafIds)],
                'keterangan' => 'Honda Supra X 125'
            ]
        ];

        foreach ($inventaris as $item) {
            $item['tanggal_pencatatan'] = Carbon::now()->subMonths(rand(1, 12));
            InventarisDesa::create($item);
        }
    }
}
