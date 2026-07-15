<?php

namespace App\Http\Controllers;

use App\Models\ApbdRealisasi;
use Illuminate\Http\Request;

class PortalApbdController extends Controller
{
    public function index()
    {
        $title = 'Transparansi APBD';
        
        $tahun_aktif = request('tahun', date('Y'));
        
        $apbds = ApbdRealisasi::where('tahun', $tahun_aktif)->get();
        
        $pendapatan = $apbds->where('kategori', 'Pendapatan');
        $belanja = $apbds->where('kategori', 'Belanja');
        
        $total_anggaran_pendapatan = $pendapatan->sum('anggaran');
        $total_realisasi_pendapatan = $pendapatan->sum('realisasi');
        
        $total_anggaran_belanja = $belanja->sum('anggaran');
        $total_realisasi_belanja = $belanja->sum('realisasi');
        
        // Formatting for Chart
        $chart_labels_pendapatan = $pendapatan->pluck('nama_item')->toJson();
        $chart_anggaran_pendapatan = $pendapatan->pluck('anggaran')->toJson();
        $chart_realisasi_pendapatan = $pendapatan->pluck('realisasi')->toJson();
        
        $chart_labels_belanja = $belanja->pluck('nama_item')->toJson();
        $chart_anggaran_belanja = $belanja->pluck('anggaran')->toJson();
        $chart_realisasi_belanja = $belanja->pluck('realisasi')->toJson();
        
        $list_tahun = ApbdRealisasi::select('tahun')->distinct()->orderBy('tahun', 'desc')->pluck('tahun');
        
        return view('portal.apbd.index', compact(
            'title', 'tahun_aktif', 'list_tahun',
            'pendapatan', 'belanja',
            'total_anggaran_pendapatan', 'total_realisasi_pendapatan',
            'total_anggaran_belanja', 'total_realisasi_belanja',
            'chart_labels_pendapatan', 'chart_anggaran_pendapatan', 'chart_realisasi_pendapatan',
            'chart_labels_belanja', 'chart_anggaran_belanja', 'chart_realisasi_belanja'
        ));
    }
}
