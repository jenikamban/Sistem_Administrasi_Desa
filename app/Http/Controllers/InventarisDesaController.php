<?php

namespace App\Http\Controllers;

use App\Models\InventarisDesa;
use App\Models\User;
use Illuminate\Http\Request;

class InventarisDesaController extends Controller
{
    public function index(Request $request)
    {
        $query = InventarisDesa::with('penanggungJawab');

        if ($request->has('kondisi') && $request->kondisi != '') {
            $query->where('kondisi', $request->kondisi);
        }

        if ($request->has('kategori') && $request->kategori != '') {
            $query->where('kategori', $request->kategori);
        }

        $inventaris = $query->latest()->get();

        return view('inventaris_desa.index', [
            'title' => 'Inventaris Desa',
            'inventaris' => $inventaris
        ]);
    }

    public function create()
    {
        $staf = User::whereIn('role', ['Staf', 'Kades_Lurah'])->get();
        return view('inventaris_desa.create', [
            'title' => 'Tambah Inventaris Baru',
            'staf' => $staf
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_item' => 'required|string|max:255',
            'kategori' => 'required|string|max:100',
            'jumlah' => 'required|integer|min:1',
            'kondisi' => 'required|in:Baik,Rusak Ringan,Rusak Berat',
            'lokasi' => 'required|string|max:255',
            'penanggung_jawab_id' => 'nullable|exists:users,id',
            'keterangan' => 'nullable|string'
        ]);

        $data = $request->all();
        if (empty($data['tanggal_pencatatan'])) {
            $data['tanggal_pencatatan'] = now();
        }

        InventarisDesa::create($data);

        return redirect()->route('inventaris-desa.index')->with('success', 'Data inventaris berhasil ditambahkan.');
    }

    public function edit(InventarisDesa $inventarisDesa)
    {
        $staf = User::whereIn('role', ['Staf', 'Kades_Lurah'])->get();
        return view('inventaris_desa.edit', [
            'title' => 'Edit Inventaris',
            'inventaris' => $inventarisDesa,
            'staf' => $staf
        ]);
    }

    public function update(Request $request, InventarisDesa $inventarisDesa)
    {
        $request->validate([
            'nama_item' => 'required|string|max:255',
            'kategori' => 'required|string|max:100',
            'jumlah' => 'required|integer|min:1',
            'kondisi' => 'required|in:Baik,Rusak Ringan,Rusak Berat',
            'lokasi' => 'required|string|max:255',
            'penanggung_jawab_id' => 'nullable|exists:users,id',
            'keterangan' => 'nullable|string'
        ]);

        $inventarisDesa->update($request->all());

        return redirect()->route('inventaris-desa.index')->with('success', 'Data inventaris berhasil diperbarui.');
    }

    public function destroy(InventarisDesa $inventarisDesa)
    {
        $inventarisDesa->delete();

        return redirect()->route('inventaris-desa.index')->with('success', 'Data inventaris berhasil dihapus.');
    }
}
