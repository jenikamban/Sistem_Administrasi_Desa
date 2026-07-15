<?php

namespace App\Http\Controllers;

use App\Models\PenerimaBantuan;
use App\Models\BantuanSosial;
use App\Models\Warga;
use Illuminate\Http\Request;

class PenerimaBantuanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Usually accessed via BantuanSosial show page, but we can redirect or show all
        return redirect()->route('bantuan-sosial.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $bantuan_sosial_id = $request->query('bantuan_sosial_id');
        if (!$bantuan_sosial_id) {
            return redirect()->route('bantuan-sosial.index')->withError('Pilih program bansos terlebih dahulu.');
        }

        return view('penerima_bantuan.create', [
            'title' => 'Tambah Penerima Bansos',
            'bantuanSosial' => BantuanSosial::findOrFail($bantuan_sosial_id),
            'wargas' => Warga::where('status_keaktifan', 'Aktif')->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'bantuan_sosial_id' => 'required|exists:bantuan_sosials,id',
            'warga_id' => 'required|exists:wargas,id',
            'status_penerimaan' => 'required|in:Diusulkan,Diterima,Ditolak',
            'tanggal_terima' => 'nullable|date',
            'keterangan' => 'nullable|string',
        ]);

        // Check if already exist
        $exists = PenerimaBantuan::where('bantuan_sosial_id', $validate['bantuan_sosial_id'])
            ->where('warga_id', $validate['warga_id'])
            ->first();

        if ($exists) {
            return back()->withInput()->withError('Warga ini sudah terdaftar di program bansos tersebut.');
        }

        PenerimaBantuan::create($validate);
        return redirect()->route('bantuan-sosial.show', $validate['bantuan_sosial_id'])
            ->withSuccess('Penerima Bantuan berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(PenerimaBantuan $penerimaBantuan)
    {
        return redirect()->route('bantuan-sosial.show', $penerimaBantuan->bantuan_sosial_id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PenerimaBantuan $penerimaBantuan)
    {
        return view('penerima_bantuan.edit', [
            'title' => 'Edit Penerima Bansos',
            'penerimaBantuan' => $penerimaBantuan,
            'wargas' => Warga::where('status_keaktifan', 'Aktif')->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PenerimaBantuan $penerimaBantuan)
    {
        $validate = $request->validate([
            'status_penerimaan' => 'required|in:Diusulkan,Diterima,Ditolak',
            'tanggal_terima' => 'nullable|date',
            'keterangan' => 'nullable|string',
        ]);

        $penerimaBantuan->update($validate);
        return redirect()->route('bantuan-sosial.show', $penerimaBantuan->bantuan_sosial_id)
            ->withSuccess('Data Penerima Bantuan berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PenerimaBantuan $penerimaBantuan)
    {
        $bansosId = $penerimaBantuan->bantuan_sosial_id;
        $penerimaBantuan->delete();
        return redirect()->route('bantuan-sosial.show', $bansosId)
            ->withSuccess('Data Penerima Bantuan berhasil dihapus');
    }
}
