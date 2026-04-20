<?php
// app/Http/Controllers/DashboardController.php
namespace App\Http\Controllers;

use App\Models\{PendaftaranTari, Kehadiran, Event, Tarian};
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct() { $this->middleware('auth'); }

    public function index()
    {
        $user = Auth::user();

        // Jadwal aktif saya
        $jadwalAktif = PendaftaranTari::with(['tarian', 'jadwal'])
            ->where('user_id', $user->id)
            ->where('status', 'aktif')
            ->get();

        // Kehadiran bulan ini
        $bulanIni = now()->format('Y-m');
        $kehadiranBulanIni = Kehadiran::where('user_id', $user->id)
            ->whereRaw("DATE_FORMAT(tanggal, '%Y-%m') = ?", [$bulanIni])
            ->selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();

        $totalLatihan = array_sum($kehadiranBulanIni);
        $hadir        = $kehadiranBulanIni['hadir'] ?? 0;
        $persenHadir  = $totalLatihan > 0 ? round($hadir / $totalLatihan * 100) : 0;

        // Event mendatang
        $eventMendatang = Event::where('status', 'akan_datang')
            ->orderBy('tanggal')->limit(3)->get();

        // Tarian populer (untuk rekomendasi)
        $tarianRekomendasi = Tarian::where('aktif', true)
            ->whereNotIn('id', $jadwalAktif->pluck('tarian_id'))
            ->orderBy('urutan')->limit(4)->get();

        // Absensi terakhir 5 sesi
        $absensiTerakhir = Kehadiran::with(['jadwal', 'tarian'])
            ->where('user_id', $user->id)
            ->orderByDesc('tanggal')->limit(5)->get();

        return view('pages.dashboard', compact(
            'user', 'jadwalAktif', 'kehadiranBulanIni',
            'totalLatihan', 'hadir', 'persenHadir',
            'eventMendatang', 'tarianRekomendasi', 'absensiTerakhir'
        ));
    }
}