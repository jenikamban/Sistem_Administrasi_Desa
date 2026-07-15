<?php

namespace App\Http\Controllers;

use App\Models\ArsipDokumen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class ArsipDokumenController extends Controller
{
    public function index()
    {
        $arsips = ArsipDokumen::with('user')->latest()->get();
        return view('arsip_dokumen.index', [
            'title' => 'Manajemen Arsip Dokumen',
            'arsips' => $arsips
        ]);
    }

    public function create()
    {
        return view('arsip_dokumen.create', [
            'title' => 'Tambah Arsip Dokumen'
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'jenis_dokumen' => 'required|string|max:100',
            'file_arsip' => 'required|file|mimes:pdf,jpg,png|max:5120', // max 5MB
            'tanggal_arsip' => 'required|date',
            'keterangan' => 'nullable|string'
        ]);

        $data = $request->except('file_arsip');
        $data['diarsipkan_oleh'] = Auth::id();

        if ($request->hasFile('file_arsip')) {
            $data['file_path'] = $request->file('file_arsip')->store('public/arsip');
        }

        ArsipDokumen::create($data);

        return redirect()->route('arsip-dokumen.index')->with('success', 'Arsip berhasil ditambahkan.');
    }

    public function show(ArsipDokumen $arsipDokuman) // Route parameter uses $arsipDokuman
    {
        return view('arsip_dokumen.show', [
            'title' => 'Detail Arsip Dokumen',
            'arsip' => $arsipDokuman
        ]);
    }

    public function destroy(ArsipDokumen $arsipDokuman)
    {
        if ($arsipDokuman->file_path && Storage::exists($arsipDokuman->file_path)) {
            Storage::delete($arsipDokuman->file_path);
        }
        $arsipDokuman->delete();

        return redirect()->route('arsip-dokumen.index')->with('success', 'Arsip berhasil dihapus.');
    }
}
