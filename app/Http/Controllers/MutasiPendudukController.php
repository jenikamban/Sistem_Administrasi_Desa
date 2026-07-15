<?php

namespace App\Http\Controllers;

use App\Models\MutasiPenduduk;
use App\Models\Warga;
use Illuminate\Http\Request;

class MutasiPendudukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('mutasi_penduduk.index', [
            'title' => 'Data Mutasi Penduduk',
            'mutasiPenduduks' => MutasiPenduduk::with('warga')->latest()->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('mutasi_penduduk.create', [
            'title' => 'Catat Mutasi Baru',
            'wargas' => Warga::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'warga_id' => 'required|exists:wargas,id',
            'jenis_mutasi' => 'required|in:Lahir,Meninggal,Masuk,Keluar',
            'tanggal_mutasi' => 'required|date',
            'keterangan' => 'required',
        ]);

        $mutasi = MutasiPenduduk::create($validate);
        
        // Auto update status_keaktifan on Warga
        if (in_array($validate['jenis_mutasi'], ['Meninggal', 'Keluar'])) {
            $warga = Warga::find($validate['warga_id']);
            $warga->status_keaktifan = $validate['jenis_mutasi'] == 'Meninggal' ? 'Meninggal' : 'Pindah';
            $warga->save();
        }

        return to_route('mutasi-penduduk.index')->withSuccess('Mutasi penduduk berhasil dicatat');
    }

    /**
     * Display the specified resource.
     */
    public function show(MutasiPenduduk $mutasiPenduduk)
    {
        return view('mutasi_penduduk.show', [
            'title' => 'Detail Mutasi',
            'mutasiPenduduk' => $mutasiPenduduk,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MutasiPenduduk $mutasiPenduduk)
    {
        return view('mutasi_penduduk.edit', [
            'title' => 'Edit Data Mutasi',
            'mutasiPenduduk' => $mutasiPenduduk,
            'wargas' => Warga::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MutasiPenduduk $mutasiPenduduk)
    {
        $validate = $request->validate([
            'warga_id' => 'required|exists:wargas,id',
            'jenis_mutasi' => 'required|in:Lahir,Meninggal,Masuk,Keluar',
            'tanggal_mutasi' => 'required|date',
            'keterangan' => 'required',
        ]);

        $mutasiPenduduk->update($validate);

        // Auto update status_keaktifan on Warga
        if (in_array($validate['jenis_mutasi'], ['Meninggal', 'Keluar'])) {
            $warga = Warga::find($validate['warga_id']);
            $warga->status_keaktifan = $validate['jenis_mutasi'] == 'Meninggal' ? 'Meninggal' : 'Pindah';
            $warga->save();
        }

        return to_route('mutasi-penduduk.index')->withSuccess('Mutasi penduduk berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MutasiPenduduk $mutasiPenduduk)
    {
        $mutasiPenduduk->delete();
        return to_route('mutasi-penduduk.index')->withSuccess('Mutasi penduduk berhasil dihapus');
    }
}
