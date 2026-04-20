<?php
// app/Http/Controllers/Admin/KehadiranController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kehadiran;
use App\Models\JadwalLatihan;
use App\Models\Tarian;
use App\Models\PendaftaranTari;
use App\Models\User;
use Illuminate\Http\Request;

class KehadiranController extends Controller
{
    // ══════════════════════════════════════════════════════════
    // INDEX — Halaman pilih sesi untuk input kehadiran
    // GET /admin/kehadiran
    // ══════════════════════════════════════════════════════════
    public function index()
    {
        $jadwal = JadwalLatihan::where('aktif', true)
            ->orderBy('urutan')
            ->get();

        $tarian = Tarian::where('aktif', true)
            ->orderBy('urutan')
            ->get();

        $today = now()->format('Y-m-d');

        // Statistik kehadiran hari ini
        $statsHariIni = Kehadiran::whereDate('tanggal', $today)
            ->selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();

        // Sesi yang sudah diinput hari ini
        $sesiHariIni = Kehadiran::whereDate('tanggal', $today)
            ->with(['jadwal', 'tarian'])
            ->select('jadwal_id', 'tarian_id')
            ->distinct()
            ->get();

        return view('admin.kehadiran.index', compact(
            'jadwal', 'tarian', 'statsHariIni', 'sesiHariIni', 'today'
        ));
    }

    // ══════════════════════════════════════════════════════════
    // INPUT — Tampilkan form input kehadiran per sesi
    // POST /admin/kehadiran/input
    // ══════════════════════════════════════════════════════════
    public function inputKehadiran(Request $request)
    {
        $request->validate([
            'jadwal_id' => 'required|exists:jadwal_latihan,id',
            'tarian_id' => 'required|exists:tarian,id',
            'tanggal'   => 'required|date',
        ]);

        $jadwal = JadwalLatihan::findOrFail($request->jadwal_id);
        $tarian = Tarian::findOrFail($request->tarian_id);

        // Anggota yang terdaftar di jadwal + tarian ini
        $peserta = PendaftaranTari::with('user')
            ->where('jadwal_id', $request->jadwal_id)
            ->where('tarian_id', $request->tarian_id)
            ->where('status', 'aktif')
            ->get();

        // Kehadiran yang sudah pernah diinput untuk sesi ini
        $existing = Kehadiran::where('jadwal_id', $request->jadwal_id)
            ->where('tarian_id', $request->tarian_id)
            ->whereDate('tanggal', $request->tanggal)
            ->pluck('status', 'user_id')
            ->toArray();

        $keteranganExisting = Kehadiran::where('jadwal_id', $request->jadwal_id)
            ->where('tarian_id', $request->tarian_id)
            ->whereDate('tanggal', $request->tanggal)
            ->pluck('keterangan', 'user_id')
            ->toArray();

        return view('admin.kehadiran.input', compact(
            'peserta', 'existing', 'keteranganExisting',
            'jadwal', 'tarian', 'request'
        ));
    }

    // ══════════════════════════════════════════════════════════
    // SIMPAN — Simpan hasil input kehadiran
    // POST /admin/kehadiran/simpan
    // ══════════════════════════════════════════════════════════
    public function simpanKehadiran(Request $request)
    {
        $request->validate([
            'jadwal_id'   => 'required|exists:jadwal_latihan,id',
            'tarian_id'   => 'required|exists:tarian,id',
            'tanggal'     => 'required|date',
            'kehadiran'   => 'required|array',
            'kehadiran.*' => 'required|in:hadir,izin,alpa',
        ]);

        $dicatatOleh = auth()->user()->name;
        $jumlah      = 0;

        foreach ($request->kehadiran as $userId => $status) {
            Kehadiran::updateOrCreate(
                [
                    'user_id'   => $userId,
                    'jadwal_id' => $request->jadwal_id,
                    'tarian_id' => $request->tarian_id,
                    'tanggal'   => $request->tanggal,
                ],
                [
                    'status'       => $status,
                    'keterangan'   => $request->keterangan[$userId] ?? null,
                    'dicatat_oleh' => $dicatatOleh,
                ]
            );
            $jumlah++;
        }

        return redirect()
            ->route('admin.kehadiran.index')
            ->with('success', "Kehadiran berhasil disimpan untuk {$jumlah} peserta!");
    }

    // ══════════════════════════════════════════════════════════
    // LAPORAN — Rekap kehadiran per bulan
    // GET /admin/kehadiran/laporan
    // ══════════════════════════════════════════════════════════
    public function laporan(Request $request)
    {
        $jadwal_id = $request->get('jadwal_id');
        $tarian_id = $request->get('tarian_id');
        $bulan     = $request->get('bulan', now()->format('Y-m'));

        // Query dasar
        $query = Kehadiran::with(['user', 'jadwal', 'tarian'])
            ->whereRaw("DATE_FORMAT(tanggal, '%Y-%m') = ?", [$bulan]);

        if ($jadwal_id) $query->where('jadwal_id', $jadwal_id);
        if ($tarian_id) $query->where('tarian_id', $tarian_id);

        $kehadiran = $query->orderBy('tanggal')->paginate(50)->withQueryString();

        // Rekap per anggota
        $queryRekap = Kehadiran::with('user')
            ->whereRaw("DATE_FORMAT(tanggal, '%Y-%m') = ?", [$bulan]);
        if ($jadwal_id) $queryRekap->where('jadwal_id', $jadwal_id);
        if ($tarian_id) $queryRekap->where('tarian_id', $tarian_id);

        $rekap = $queryRekap->get()
            ->groupBy('user_id')
            ->map(function ($items) {
                $hadir = $items->where('status', 'hadir')->count();
                $izin  = $items->where('status', 'izin')->count();
                $alpa  = $items->where('status', 'alpa')->count();
                $total = $hadir + $izin + $alpa;
                return [
                    'user'   => $items->first()->user,
                    'hadir'  => $hadir,
                    'izin'   => $izin,
                    'alpa'   => $alpa,
                    'total'  => $total,
                    'persen' => $total > 0 ? round($hadir / $total * 100) : 0,
                ];
            })
            ->sortByDesc('persen')
            ->values();

        $jadwalList = JadwalLatihan::where('aktif', true)->get();
        $tarianList = Tarian::where('aktif', true)->get();

        return view('admin.kehadiran.laporan', compact(
            'kehadiran', 'rekap', 'jadwalList', 'tarianList',
            'bulan', 'jadwal_id', 'tarian_id'
        ));
    }
}