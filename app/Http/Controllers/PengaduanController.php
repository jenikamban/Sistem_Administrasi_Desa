<?php

namespace App\Http\Controllers;

use App\Models\Pengaduan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PengaduanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = auth()->user();
        if ($user->hasRole('Warga') && $user->warga) {
            $pengaduans = Pengaduan::where('warga_id', $user->warga->id)->latest()->paginate(10);
        } else {
            $query = Pengaduan::query();
            if ($request->filled('kategori')) {
                $query->where('kategori', $request->kategori);
            }
            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }
            $pengaduans = $query->latest()->paginate(10);
        }

        $title = 'Daftar Pengaduan';
        return view('pengaduan.index', compact('pengaduans', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Buat Pengaduan Baru';
        return view('pengaduan.create', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'isi_laporan' => 'required|string',
            'kategori' => 'required|in:Infrastruktur,Keamanan,Sosial,Kebersihan,Lainnya',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->except(['foto', 'is_anonim']);
        $data['status'] = 'Pending';
        
        if ($request->has('is_anonim') && $request->is_anonim == 'on') {
            $data['warga_id'] = null;
        } else {
            $data['warga_id'] = auth()->user()->warga->id ?? null;
        }

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('public/pengaduan');
        }

        Pengaduan::create($data);

        return redirect()->route('pengaduan.index')->with('success', 'Pengaduan berhasil dikirim.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Pengaduan $pengaduan)
    {
        $title = 'Detail Pengaduan';
        return view('pengaduan.show', compact('pengaduan', 'title'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pengaduan $pengaduan)
    {
        // Not used
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pengaduan $pengaduan)
    {
        // Not used for editing entire pengaduan
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pengaduan $pengaduan)
    {
        $user = auth()->user();
        if ($user->hasRole('Warga') && $pengaduan->warga_id !== $user->warga->id) {
            abort(403);
        }
        
        if ($pengaduan->foto) {
            Storage::delete($pengaduan->foto);
        }
        $pengaduan->delete();

        return redirect()->route('pengaduan.index')->with('success', 'Pengaduan berhasil dihapus.');
    }

    public function respond(Request $request, Pengaduan $pengaduan)
    {
        $request->validate([
            'tanggapan' => 'required|string',
            'status' => 'required|in:Pending,Diproses,Selesai,Ditolak',
        ]);

        $pengaduan->update([
            'tanggapan' => $request->tanggapan,
            'status' => $request->status,
            'tanggapan_oleh' => auth()->id(),
        ]);

        return redirect()->route('pengaduan.show', $pengaduan)->with('success', 'Tanggapan berhasil disimpan.');
    }
}
