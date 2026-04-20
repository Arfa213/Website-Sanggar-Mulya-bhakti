<?php
// ══════════════════════════════════════════════════════════════
// app/Http/Controllers/PenjadwalanController.php
// Controller untuk anggota yang sudah login
// ══════════════════════════════════════════════════════════════
namespace App\Http\Controllers;

use App\Models\{Tarian, JadwalLatihan, PendaftaranTari, Kehadiran};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PenjadwalanController extends Controller
{
    public function __construct() { $this->middleware('auth'); }

    // ── Halaman utama: daftar tarian + jadwal saya ───────────
    public function index()
    {
        $user = Auth::user();

        // Tarian yang sudah saya daftar
        $pendaftaran = PendaftaranTari::with(['tarian', 'jadwal'])
            ->where('user_id', $user->id)
            ->where('status', 'aktif')
            ->get();

        // Semua tarian yang tersedia untuk didaftar
        $tarianTersedia = Tarian::where('aktif', true)
            ->orderBy('urutan')
            ->get();

        // Jadwal latihan untuk tiap tarian
        $jadwalLatihan = JadwalLatihan::where('aktif', true)
            ->orderBy('urutan')
            ->get();

        // Statistik kehadiran saya
        $statsKehadiran = Kehadiran::where('user_id', $user->id)
            ->selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();

        return view('pages.penjadwalan', compact(
            'pendaftaran', 'tarianTersedia', 'jadwalLatihan', 'statsKehadiran'
        ));
    }

    // ── Daftar tarian ────────────────────────────────────────
    public function daftar(Request $request)
    {
        $request->validate([
            'tarian_id' => 'required|exists:tarian,id',
            'jadwal_id' => 'required|exists:jadwal_latihan,id',
            'catatan'   => 'nullable|string|max:500',
        ]);

        $user = Auth::user();

        // Cek apakah sudah terdaftar di tarian + jadwal ini
        $existing = PendaftaranTari::where([
            'user_id'   => $user->id,
            'tarian_id' => $request->tarian_id,
            'jadwal_id' => $request->jadwal_id,
        ])->first();

        if ($existing) {
            return back()->with('error', 'Anda sudah terdaftar di kelas ini!');
        }

        PendaftaranTari::create([
            'user_id'       => $user->id,
            'tarian_id'     => $request->tarian_id,
            'jadwal_id'     => $request->jadwal_id,
            'status'        => 'aktif',
            'tanggal_daftar'=> now(),
            'catatan'       => $request->catatan,
        ]);

        $tarian = Tarian::find($request->tarian_id);
        $jadwal = JadwalLatihan::find($request->jadwal_id);

        return back()->with('success',
            "Berhasil mendaftar Tari {$tarian->nama}! " .
            "Jadwal latihan: {$jadwal->hari}, {$jadwal->jam_mulai}–{$jadwal->jam_selesai} di {$jadwal->tempat}."
        );
    }

    // ── Batalkan pendaftaran ──────────────────────────────────
    public function batalkan($id)
    {
        $pendaftaran = PendaftaranTari::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $pendaftaran->update(['status' => 'nonaktif']);
        return back()->with('success', 'Pendaftaran dibatalkan.');
    }

    // ── Riwayat kehadiran ─────────────────────────────────────
    public function riwayatKehadiran()
    {
        $kehadiran = Kehadiran::with(['jadwal', 'tarian'])
            ->where('user_id', Auth::id())
            ->orderByDesc('tanggal')
            ->paginate(20);

        return view('pages.riwayat_kehadiran', compact('kehadiran'));
    }
}