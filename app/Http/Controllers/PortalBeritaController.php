<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use Illuminate\Http\Request;

class PortalBeritaController extends Controller
{
    public function index()
    {
        $title = 'Portal Berita Desa';
        $beritas = Berita::where('status', 'Published')->with('penulis')->latest()->paginate(9);
        return view('portal.berita.index', compact('title', 'beritas'));
    }

    public function show($slug)
    {
        $berita = Berita::where('slug', $slug)->where('status', 'Published')->firstOrFail();
        $title = $berita->judul;
        
        $berita_lainnya = Berita::where('status', 'Published')->where('id', '!=', $berita->id)->latest()->take(4)->get();
        
        return view('portal.berita.show', compact('title', 'berita', 'berita_lainnya'));
    }
}
