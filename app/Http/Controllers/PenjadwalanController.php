<?php

namespace App\Http\Controllers;

use App\Models\{Tarian, JadwalLatihan, PendaftaranTari, Kehadiran};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PenjadwalanController extends Controller
{
    // Tidak ada __construct middleware — sudah dihandle di routes/web.php

    public function index()
    {
        $user = Auth::user();

        $pendaftaran = PendaftaranTari::with(['tarian', 'jadwal'])
            ->where('user_id', $user->id)
            ->where('status', 'aktif')
            ->get();

        $tarianTersedia = Tarian::where('aktif', true)
            ->orderBy('urutan')->get();

        $jadwalLatihan = JadwalLatihan::where('aktif', true)
            ->orderBy('urutan')->get();

        $statsKehadiran = Kehadiran::where('user_id', $user->id)
            ->selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();

        return view('pages.penjadwalan', compact(
            'pendaftaran', 'tarianTersedia', 'jadwalLatihan', 'statsKehadiran'
        ));
    }

    public function daftar(Request $request)
    {
        $request->validate([
            'tarian_id' => 'required|exists:tarian,id',
            'jadwal_id' => 'required|exists:jadwal_latihan,id',
            'catatan'   => 'nullable|string|max:500',
        ]);

        $user = Auth::user();

        $existing = PendaftaranTari::where([
            'user_id'   => $user->id,
            'tarian_id' => $request->tarian_id,
            'jadwal_id' => $request->jadwal_id,
        ])->first();

        if ($existing) {
            return back()->with('error', 'Kamu sudah terdaftar di kelas ini!');
        }

        PendaftaranTari::create([
            'user_id'        => $user->id,
            'tarian_id'      => $request->tarian_id,
            'jadwal_id'      => $request->jadwal_id,
            'status'         => 'aktif',
            'tanggal_daftar' => now()->toDateString(),
            'catatan'        => $request->catatan,
        ]);

        $tarian = Tarian::find($request->tarian_id);
        $jadwal = JadwalLatihan::find($request->jadwal_id);

        return back()->with('success',
            "Berhasil mendaftar Tari {$tarian->nama}! " .
            "Jadwal: {$jadwal->hari}, {$jadwal->jam_mulai}–{$jadwal->jam_selesai} di {$jadwal->tempat}."
        );
    }

    public function batalkan($id)
    {
        $pendaftaran = PendaftaranTari::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $pendaftaran->update(['status' => 'nonaktif']);
        return back()->with('success', 'Pendaftaran berhasil dibatalkan.');
    }

    public function riwayatKehadiran()
    {
        $kehadiran = Kehadiran::with(['jadwal', 'tarian'])
            ->where('user_id', Auth::id())
            ->orderByDesc('tanggal')
            ->paginate(20);

        return view('pages.riwayat_kehadiran', compact('kehadiran'));
    }
}
