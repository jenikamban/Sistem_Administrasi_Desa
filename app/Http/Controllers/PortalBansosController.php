<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PenerimaBantuan;

class PortalBansosController extends Controller
{
    public function index()
    {
        return view('portal_bansos.index', [
            'title' => 'Cek Status Bantuan Sosial',
            'hasil' => null
        ]);
    }

    public function search(Request $request)
    {
        $request->validate([
            'nik' => 'required|numeric|digits:16'
        ]);

        $hasil = PenerimaBantuan::with(['bantuanSosial', 'warga'])
            ->whereHas('warga', function($q) use ($request) {
                $q->where('nik', $request->nik);
            })->get();

        return view('portal_bansos.index', [
            'title' => 'Cek Status Bantuan Sosial',
            'hasil' => $hasil,
            'nik' => $request->nik
        ]);
    }
}
