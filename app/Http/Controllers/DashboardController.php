<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalPenduduk = \App\Models\Warga::where('status_keaktifan', 'Aktif')->count();
        $totalKK = \App\Models\KartuKeluarga::count();
        $suratMenunggu = \App\Models\SuratPermohonan::whereIn('status', ['Menunggu_Tanda_Tangan', 'Ditinjau_Staf'])->count();
        $pengaduanBaru = \App\Models\Pengaduan::where('status', 'Pending')->count();

        $jenisKelamin = \App\Models\Warga::where('status_keaktifan', 'Aktif')
            ->select('jenis_kelamin', DB::raw('count(*) as total'))
            ->groupBy('jenis_kelamin')
            ->pluck('total', 'jenis_kelamin')->toArray();

        $pekerjaanPopuler = \App\Models\Warga::where('status_keaktifan', 'Aktif')
            ->select('pekerjaan', DB::raw('count(*) as total'))
            ->groupBy('pekerjaan')
            ->orderByDesc('total')
            ->limit(5)
            ->pluck('total', 'pekerjaan')->toArray();

        // Umur
        $wargas = \App\Models\Warga::where('status_keaktifan', 'Aktif')->get(['tanggal_lahir']);
        $umur = [
            'Balita (<5 th)' => 0,
            'Anak-anak (5-12 th)' => 0,
            'Remaja (13-18 th)' => 0,
            'Produktif (19-59 th)' => 0,
            'Lansia (>60 th)' => 0,
        ];

        foreach ($wargas as $w) {
            $age = \Carbon\Carbon::parse($w->tanggal_lahir)->age;
            if ($age < 5) $umur['Balita (<5 th)']++;
            elseif ($age <= 12) $umur['Anak-anak (5-12 th)']++;
            elseif ($age <= 18) $umur['Remaja (13-18 th)']++;
            elseif ($age <= 59) $umur['Produktif (19-59 th)']++;
            else $umur['Lansia (>60 th)']++;
        }

        // Tren Surat (SQLite compatible year/month extraction if using sqlite, or simple collection grouping)
        $suratPerBulan = \App\Models\SuratPermohonan::whereYear('created_at', date('Y'))
            ->get()
            ->groupBy(function($d) {
                return \Carbon\Carbon::parse($d->created_at)->format('M');
            })->map(function ($row) {
                return $row->count();
            });

        // Pengajuan Terbaru & Laporan Pengaduan Terkini
        $suratTerbaru = \App\Models\SuratPermohonan::latest()->limit(5)->get();
        $pengaduanTerkini = \App\Models\Pengaduan::latest()->limit(5)->get();

        return view('dashboard.index', [
            'title' => 'Dashboard Analitik',
            'totalPenduduk' => $totalPenduduk,
            'totalKK' => $totalKK,
            'suratMenunggu' => $suratMenunggu,
            'pengaduanBaru' => $pengaduanBaru,
            'jenisKelamin' => $jenisKelamin,
            'pekerjaanPopuler' => $pekerjaanPopuler,
            'umur' => $umur,
            'suratPerBulan' => $suratPerBulan,
            'suratTerbaru' => $suratTerbaru,
            'pengaduanTerkini' => $pengaduanTerkini,
        ]);
    }

    public function show()
    {
        return view('dashboard.show', [
            'title' => 'My Profile',
            'user' => Auth::user()
        ]);
    }

    public function edit()
    {
        return view('dashboard.edit', [
            'title' => 'Edit Profile',
            'user' => Auth::user()
        ]);
    }

    public function update(Request $request)
    {
        try {
            DB::beginTransaction();

            $user = Auth::user();
            $validate = $request->validate([
                'name' => 'required',
                'password' => 'nullable|min:8',
                'passwordconfirm' => 'nullable|same:password',
                'email' => 'required|email|lowercase|unique:users,email,' . $user->id,
                'avatar' => 'nullable|image|mimes:png,jpg,jpeg,svg|max:512'
            ], [
                'name.required' => 'Nama wajib diisi',
                'password.min' => 'Password minimal 8 karakter',
                'passwordconfirm.same' => 'Konfirmasi password tidak cocok',
                'email.required' => 'Email wajib diisi',
                'email.email' => 'Format email tidak valid',
                'email.unique' => 'Email sudah terdaftar',
                'avatar.image' => 'File avatar harus berupa gambar',
                'avatar.mimes' => 'Format avatar harus png, jpg, jpeg, atau svg',
                'avatar.max' => 'Ukuran avatar tidak boleh lebih dari 512 KB',
            ]);

            if ($request->file('avatar')) {
                $validate['avatar'] = $request->file('avatar')->store('img', 'public');
                if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                    Storage::disk('public')->delete($user->avatar);
                }
            }

            if ($request->password) {
                $validate['password'] = bcrypt($request->password);
            } else {
                unset($validate['password']);
            }
            $user->update($validate);

            DB::commit();
            return to_route('dashboard.show')->withSuccess('Data berhasil diubah');
        } catch (\Exception $e) {
            DB::rollBack();
            return to_route('dashboard.edit')->withError('Gagal mengubah data: ' . $e->getMessage());
        }
    }
}
