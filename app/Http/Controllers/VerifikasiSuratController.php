<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SuratPermohonan;

class VerifikasiSuratController extends Controller
{
    public function verify($kode)
    {
        $surat = SuratPermohonan::with('warga')->where('kode_verifikasi', $kode)->first();

        return view('verifikasi_surat.verify', [
            'title' => 'Verifikasi Keaslian Surat',
            'surat' => $surat
        ]);
    }
}
