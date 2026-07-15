<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BeritaController extends Controller
{
    public function index()
    {
        $title = 'Manajemen Berita';
        $beritas = Berita::with('penulis')->latest()->paginate(10);
        return view('berita.index', compact('title', 'beritas'));
    }

    public function create()
    {
        $title = 'Tulis Berita Baru';
        return view('berita.create', compact('title'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'konten' => 'required|string',
            'kategori' => 'required|string|max:100',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'status' => 'required|in:Draft,Published',
        ]);

        $data = $request->except('gambar');
        $data['penulis_id'] = auth()->id();

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('public/berita');
        }

        Berita::create($data);

        return redirect()->route('berita.index')->with('success', 'Berita berhasil ditambahkan.');
    }

    public function show(Berita $berita)
    {
        // For admin preview
        $title = 'Preview Berita';
        return view('berita.show', compact('title', 'berita'));
    }

    public function edit(Berita $berita)
    {
        $title = 'Edit Berita';
        return view('berita.edit', compact('title', 'berita'));
    }

    public function update(Request $request, Berita $berita)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'konten' => 'required|string',
            'kategori' => 'required|string|max:100',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'status' => 'required|in:Draft,Published',
        ]);

        $data = $request->except('gambar');

        if ($request->hasFile('gambar')) {
            if ($berita->gambar) {
                Storage::delete($berita->gambar);
            }
            $data['gambar'] = $request->file('gambar')->store('public/berita');
        }

        $berita->update($data);

        return redirect()->route('berita.index')->with('success', 'Berita berhasil diperbarui.');
    }

    public function destroy(Berita $berita)
    {
        if ($berita->gambar) {
            Storage::delete($berita->gambar);
        }
        $berita->delete();

        return redirect()->route('berita.index')->with('success', 'Berita berhasil dihapus.');
    }
}
