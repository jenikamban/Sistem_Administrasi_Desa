<?php

namespace App\Http\Controllers;

use App\Models\ApbdRealisasi;
use Illuminate\Http\Request;

class ApbdRealisasiController extends Controller
{
    public function index()
    {
        $title = 'Manajemen APBD Realisasi';
        $apbds = ApbdRealisasi::latest()->paginate(10);
        return view('apbd.index', compact('title', 'apbds'));
    }

    public function create()
    {
        $title = 'Tambah Data APBD';
        return view('apbd.create', compact('title'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kategori' => 'required|in:Pendapatan,Belanja,Pembiayaan',
            'nama_item' => 'required|string|max:255',
            'anggaran' => 'required|numeric|min:0',
            'realisasi' => 'required|numeric|min:0',
            'tahun' => 'required|numeric|min:2000',
        ]);

        ApbdRealisasi::create($request->all());

        return redirect()->route('apbd.index')->with('success', 'Data APBD berhasil ditambahkan.');
    }

    public function show(ApbdRealisasi $apbd)
    {
        // unused
    }

    public function edit(ApbdRealisasi $apbd)
    {
        $title = 'Edit Data APBD';
        return view('apbd.edit', compact('title', 'apbd'));
    }

    public function update(Request $request, ApbdRealisasi $apbd)
    {
        $request->validate([
            'kategori' => 'required|in:Pendapatan,Belanja,Pembiayaan',
            'nama_item' => 'required|string|max:255',
            'anggaran' => 'required|numeric|min:0',
            'realisasi' => 'required|numeric|min:0',
            'tahun' => 'required|numeric|min:2000',
        ]);

        $apbd->update($request->all());

        return redirect()->route('apbd.index')->with('success', 'Data APBD berhasil diperbarui.');
    }

    public function destroy(ApbdRealisasi $apbd)
    {
        $apbd->delete();

        return redirect()->route('apbd.index')->with('success', 'Data APBD berhasil dihapus.');
    }
}
