<?php

namespace App\Http\Controllers;

use App\Models\Warga;
use App\Models\KartuKeluarga;
use Illuminate\Http\Request;

class WargaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('warga.index', [
            'title' => 'Data Warga',
            'wargas' => Warga::with('kartuKeluarga')->latest()->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('warga.create', [
            'title' => 'Tambah Data Warga',
            'kartuKeluargas' => KartuKeluarga::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'kartu_keluarga_id' => 'nullable|exists:kartu_keluargas,id',
            'nik' => 'required|numeric|digits:16|unique:wargas,nik',
            'nama' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'agama' => 'required',
            'status_perkawinan' => 'required|in:Belum Kawin,Kawin,Cerai Hidup,Cerai Mati',
            'pekerjaan' => 'required',
            'alamat' => 'required',
            'rt' => 'required|max:3',
            'rw' => 'required|max:3',
            'dusun' => 'required',
            'status_hubungan_keluarga' => 'required|in:Kepala Keluarga,Suami,Istri,Anak,Mertua,Orang Tua,Lainnya',
            'status_keaktifan' => 'required|in:Aktif,Meninggal,Pindah',
        ]);

        $warga = Warga::create($validate);
        
        // If they are selected as Kepala Keluarga, update the KK
        if ($validate['status_hubungan_keluarga'] == 'Kepala Keluarga' && $validate['kartu_keluarga_id']) {
            KartuKeluarga::find($validate['kartu_keluarga_id'])->update(['kepala_keluarga_id' => $warga->id]);
        }

        return to_route('warga.index')->withSuccess('Data Warga berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Warga $warga)
    {
        $warga->load('kartuKeluarga', 'mutasiPenduduk');
        return view('warga.show', [
            'title' => 'Detail Warga',
            'warga' => $warga,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Warga $warga)
    {
        return view('warga.edit', [
            'title' => 'Edit Data Warga',
            'warga' => $warga,
            'kartuKeluargas' => KartuKeluarga::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Warga $warga)
    {
        $validate = $request->validate([
            'kartu_keluarga_id' => 'nullable|exists:kartu_keluargas,id',
            'nik' => 'required|numeric|digits:16|unique:wargas,nik,' . $warga->id,
            'nama' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'agama' => 'required',
            'status_perkawinan' => 'required|in:Belum Kawin,Kawin,Cerai Hidup,Cerai Mati',
            'pekerjaan' => 'required',
            'alamat' => 'required',
            'rt' => 'required|max:3',
            'rw' => 'required|max:3',
            'dusun' => 'required',
            'status_hubungan_keluarga' => 'required|in:Kepala Keluarga,Suami,Istri,Anak,Mertua,Orang Tua,Lainnya',
            'status_keaktifan' => 'required|in:Aktif,Meninggal,Pindah',
        ]);

        $warga->update($validate);
        
        // If they are selected as Kepala Keluarga, update the KK
        if ($validate['status_hubungan_keluarga'] == 'Kepala Keluarga' && $validate['kartu_keluarga_id']) {
            KartuKeluarga::find($validate['kartu_keluarga_id'])->update(['kepala_keluarga_id' => $warga->id]);
        }

        return to_route('warga.index')->withSuccess('Data Warga berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Warga $warga)
    {
        $warga->delete();
        return to_route('warga.index')->withSuccess('Data Warga berhasil dihapus');
    }
}
