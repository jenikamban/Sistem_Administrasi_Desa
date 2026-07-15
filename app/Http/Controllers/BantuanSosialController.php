<?php

namespace App\Http\Controllers;

use App\Models\BantuanSosial;
use Illuminate\Http\Request;

class BantuanSosialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('bantuan_sosial.index', [
            'title' => 'Program Bantuan Sosial',
            'bantuanSosials' => BantuanSosial::latest()->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('bantuan_sosial.create', [
            'title' => 'Tambah Program Bansos',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'nama_program' => 'required|string|max:255',
            'sumber_dana' => 'required|string|max:255',
            'tahun' => 'required|digits:4|integer|min:2000',
            'deskripsi' => 'nullable|string',
            'status' => 'required|in:Aktif,Selesai',
        ]);

        BantuanSosial::create($validate);
        return to_route('bantuan-sosial.index')->withSuccess('Program Bantuan Sosial berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(BantuanSosial $bantuanSosial)
    {
        // Load penerima_bantuan relationship
        $bantuanSosial->load('penerimaBantuan.warga');
        return view('bantuan_sosial.show', [
            'title' => 'Detail Program Bansos',
            'bantuanSosial' => $bantuanSosial,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BantuanSosial $bantuanSosial)
    {
        return view('bantuan_sosial.edit', [
            'title' => 'Edit Program Bansos',
            'bantuanSosial' => $bantuanSosial,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BantuanSosial $bantuanSosial)
    {
        $validate = $request->validate([
            'nama_program' => 'required|string|max:255',
            'sumber_dana' => 'required|string|max:255',
            'tahun' => 'required|digits:4|integer|min:2000',
            'deskripsi' => 'nullable|string',
            'status' => 'required|in:Aktif,Selesai',
        ]);

        $bantuanSosial->update($validate);
        return to_route('bantuan-sosial.index')->withSuccess('Program Bantuan Sosial berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BantuanSosial $bantuanSosial)
    {
        $bantuanSosial->delete();
        return to_route('bantuan-sosial.index')->withSuccess('Program Bantuan Sosial berhasil dihapus');
    }
}
