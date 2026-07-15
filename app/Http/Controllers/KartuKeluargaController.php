<?php

namespace App\Http\Controllers;

use App\Models\KartuKeluarga;
use Illuminate\Http\Request;

class KartuKeluargaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('kartu_keluarga.index', [
            'title' => 'Kartu Keluarga',
            'kartuKeluargas' => KartuKeluarga::with('kepalaKeluarga')->latest()->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('kartu_keluarga.create', [
            'title' => 'Tambah Kartu Keluarga',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'no_kk' => 'required|numeric|digits:16|unique:kartu_keluargas,no_kk',
            'alamat' => 'required',
            'rt' => 'required|max:3',
            'rw' => 'required|max:3',
            'dusun' => 'required',
            'kode_pos' => 'required|numeric|digits:5',
        ]);

        KartuKeluarga::create($validate);

        return to_route('kartu-keluarga.index')->withSuccess('Data Kartu Keluarga berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(KartuKeluarga $kartuKeluarga)
    {
        $kartuKeluarga->load('anggota', 'kepalaKeluarga');
        return view('kartu_keluarga.show', [
            'title' => 'Detail Kartu Keluarga',
            'kartuKeluarga' => $kartuKeluarga,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(KartuKeluarga $kartuKeluarga)
    {
        return view('kartu_keluarga.edit', [
            'title' => 'Edit Kartu Keluarga',
            'kartuKeluarga' => $kartuKeluarga,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, KartuKeluarga $kartuKeluarga)
    {
        $validate = $request->validate([
            'no_kk' => 'required|numeric|digits:16|unique:kartu_keluargas,no_kk,' . $kartuKeluarga->id,
            'alamat' => 'required',
            'rt' => 'required|max:3',
            'rw' => 'required|max:3',
            'dusun' => 'required',
            'kode_pos' => 'required|numeric|digits:5',
        ]);

        $kartuKeluarga->update($validate);

        return to_route('kartu-keluarga.index')->withSuccess('Data Kartu Keluarga berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(KartuKeluarga $kartuKeluarga)
    {
        $kartuKeluarga->delete();
        return to_route('kartu-keluarga.index')->withSuccess('Data Kartu Keluarga berhasil dihapus');
    }
}
