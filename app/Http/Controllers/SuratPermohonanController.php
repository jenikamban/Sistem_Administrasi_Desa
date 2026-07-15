<?php

namespace App\Http\Controllers;

use App\Models\SuratPermohonan;
use App\Models\Warga;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class SuratPermohonanController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $query = SuratPermohonan::with('warga')->latest();

        if ($user->role == 'Admin' || $user->role == 'Superadmin') {
            // Can see all
        } elseif ($user->role == 'Staf') {
            // Can see all
        } else {
            // Warga only sees their own if we implement Warga login, but since this is admin dashboard
            // We assume admin/staf access for now.
        }

        return view('surat_permohonan.index', [
            'title' => 'Layanan Surat Menyurat',
            'suratPermohonans' => $query->get(),
        ]);
    }

    public function create()
    {
        return view('surat_permohonan.create', [
            'title' => 'Buat Pengajuan Surat',
            'wargas' => Warga::where('status_keaktifan', 'Aktif')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'warga_id' => 'required|exists:wargas,id',
            'jenis_surat' => 'required|in:SKU,SKTM,SKD,SK_Kematian,SK_Pindah,Surat_Pengantar',
            'keperluan' => 'required|string',
        ]);

        $validate['nomor_surat'] = null; // Generated upon approval
        $validate['status'] = 'Menunggu_Tanda_Tangan';
        $validate['kode_verifikasi'] = Str::random(10); // Code for QR later
        $validate['pengaju_id'] = auth()->id(); // Missing this!

        SuratPermohonan::create($validate);

        return to_route('surat-permohonan.index')->withSuccess('Pengajuan surat berhasil dibuat dan sedang menunggu persetujuan.');
    }

    public function show(SuratPermohonan $suratPermohonan)
    {
        return view('surat_permohonan.show', [
            'title' => 'Detail Surat Permohonan',
            'suratPermohonan' => $suratPermohonan,
        ]);
    }

    public function approve(Request $request, SuratPermohonan $surat_permohonan)
    {
        // Generate nomor surat
        $tahun = date('Y');
        $count = SuratPermohonan::where('status', 'Disetujui')->whereYear('created_at', $tahun)->count() + 1;
        $nomor = "470/" . str_pad($count, 3, '0', STR_PAD_LEFT) . "/DESA/" . $tahun;

        $surat_permohonan->update([
            'status' => 'Disetujui',
            'nomor_surat' => $nomor,
            'keterangan_penolakan' => null
        ]);

        return back()->withSuccess('Surat berhasil disetujui dengan Nomor: ' . $nomor);
    }

    public function reject(Request $request, SuratPermohonan $surat_permohonan)
    {
        $request->validate(['keterangan_penolakan' => 'required|string']);

        $surat_permohonan->update([
            'status' => 'Ditolak',
            'keterangan_penolakan' => $request->keterangan_penolakan
        ]);

        return back()->withError('Surat berhasil ditolak.');
    }

    public function print(SuratPermohonan $surat_permohonan)
    {
        if ($surat_permohonan->status != 'Disetujui') {
            abort(403, 'Surat belum disetujui, tidak dapat dicetak.');
        }

        // Generate QR Code URL
        $url = route('verifikasi.surat', $surat_permohonan->kode_verifikasi);
        $qrcode = base64_encode(QrCode::format('svg')->size(100)->errorCorrection('H')->generate($url));

        $pdf = Pdf::loadView('surat_permohonan.template_pdf', [
            'surat' => $surat_permohonan,
            'qrcode' => $qrcode
        ]);

        return $pdf->stream('Surat_'.$surat_permohonan->jenis_surat.'_'.$surat_permohonan->warga->nama.'.pdf');
    }

    public function edit(SuratPermohonan $suratPermohonan)
    {
        //
    }

    public function update(Request $request, SuratPermohonan $suratPermohonan)
    {
        //
    }

    public function destroy(SuratPermohonan $suratPermohonan)
    {
        $suratPermohonan->delete();
        return to_route('surat-permohonan.index')->withSuccess('Data surat berhasil dihapus.');
    }
}
