<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Warga;
use App\Models\SuratPermohonan;
use App\Models\Pengaduan;
use App\Models\MutasiPenduduk;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $totalPenduduk = Warga::where('status_keaktifan', 'Aktif')->count();
        $totalSuratSelesai = SuratPermohonan::where('status', 'Selesai')->count();
        $totalPengaduanSelesai = Pengaduan::where('status', 'Selesai')->count();
        $totalMutasi = MutasiPenduduk::count();

        // Optional filtering by year/month if we want to make it advanced later.
        
        // Let's get the summary of surat by category
        $suratKategori = SuratPermohonan::select('jenis_surat', DB::raw('count(*) as total'))
            ->groupBy('jenis_surat')
            ->pluck('total', 'jenis_surat')->toArray();

        // Pengaduan by category
        $pengaduanKategori = Pengaduan::select('kategori', DB::raw('count(*) as total'))
            ->groupBy('kategori')
            ->pluck('total', 'kategori')->toArray();

        return view('laporan.index', [
            'title' => 'Laporan Keseluruhan',
            'totalPenduduk' => $totalPenduduk,
            'totalSuratSelesai' => $totalSuratSelesai,
            'totalPengaduanSelesai' => $totalPengaduanSelesai,
            'totalMutasi' => $totalMutasi,
            'suratKategori' => $suratKategori,
            'pengaduanKategori' => $pengaduanKategori
        ]);
    }
}
