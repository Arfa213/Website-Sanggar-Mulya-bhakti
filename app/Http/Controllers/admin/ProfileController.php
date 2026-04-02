<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{SanggarProfile, Pelatih, Pengelola, JadwalLatihan};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /* ── PROFIL SANGGAR ─────────────────────────── */
    public function index()
    {
        $profil   = SanggarProfile::getInstance();
        $pelatih  = Pelatih::orderBy('urutan')->get();
        $pengelola= Pengelola::orderBy('urutan')->get();
        $jadwal   = JadwalLatihan::orderBy('urutan')->get();
        return view('admin.profile.index', compact('profil','pelatih','pengelola','jadwal'));
    }

    public function updateProfil(Request $request)
    {
        $request->validate([
            'nama_sanggar'   => 'required|string|max:255',
            'tagline'        => 'nullable|string|max:500',
            'sejarah'        => 'required|string',
            'visi'           => 'required|string',
            'misi'           => 'required|array|min:1',
            'misi.*'         => 'required|string',
            'tahun_berdiri'  => 'nullable|string|max:10',
            'alamat'         => 'nullable|string',
            'no_hp'          => 'nullable|string|max:30',
            'email'          => 'nullable|email',
            'instagram'      => 'nullable|string',
            'facebook'       => 'nullable|string',
            'youtube'        => 'nullable|string',
            'jumlah_anggota'     => 'nullable|integer',
            'jumlah_penghargaan' => 'nullable|integer',
            'jumlah_event'       => 'nullable|integer',
            'foto_profil'    => 'nullable|image|max:2048',
            'foto_sejarah'   => 'nullable|image|max:2048',
        ]);

        $profil = SanggarProfile::getInstance();
        $data   = $request->except(['_token','_method','foto_profil','foto_sejarah']);

        foreach (['foto_profil','foto_sejarah'] as $field) {
            if ($request->hasFile($field)) {
                if ($profil->$field) Storage::disk('public')->delete($profil->$field);
                $data[$field] = $request->file($field)->store('profil', 'public');
            }
        }

        $profil->update($data);
        return back()->with('success', 'Profil sanggar berhasil diperbarui!');
    }

    /* ── PELATIH ────────────────────────────────── */
    public function storePelatih(Request $request)
    {
        $request->validate([
            'nama'         => 'required|string|max:255',
            'jabatan'      => 'required|string|max:255',
            'spesialisasi' => 'nullable|string|max:255',
            'pengalaman'   => 'nullable|string|max:100',
            'bio'          => 'nullable|string',
            'no_hp'        => 'nullable|string|max:30',
            'foto'         => 'nullable|image|max:2048',
        ]);

        $data = $request->except(['_token','foto']);
        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('pelatih', 'public');
        }
        $data['urutan'] = Pelatih::max('urutan') + 1;
        Pelatih::create($data);
        return back()->with('success', 'Pelatih berhasil ditambahkan!');
    }

    public function updatePelatih(Request $request, Pelatih $pelatih)
    {
        $request->validate([
            'nama'         => 'required|string|max:255',
            'jabatan'      => 'required|string|max:255',
            'spesialisasi' => 'nullable|string|max:255',
            'pengalaman'   => 'nullable|string|max:100',
            'bio'          => 'nullable|string',
            'no_hp'        => 'nullable|string|max:30',
            'foto'         => 'nullable|image|max:2048',
        ]);

        $data = $request->except(['_token','_method','foto']);
        if ($request->hasFile('foto')) {
            if ($pelatih->foto) Storage::disk('public')->delete($pelatih->foto);
            $data['foto'] = $request->file('foto')->store('pelatih', 'public');
        }
        $pelatih->update($data);
        return back()->with('success', 'Data pelatih berhasil diperbarui!');
    }

    public function destroyPelatih(Pelatih $pelatih)
    {
        if ($pelatih->foto) Storage::disk('public')->delete($pelatih->foto);
        $pelatih->delete();
        return back()->with('success', 'Pelatih berhasil dihapus.');
    }

    /* ── PENGELOLA ──────────────────────────────── */
    public function storePengelola(Request $request)
    {
        $request->validate([
            'nama'    => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'ikon'    => 'required|string',
            'foto'    => 'nullable|image|max:2048',
        ]);
        $data = $request->except(['_token','foto']);
        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('pengelola', 'public');
        }
        $data['urutan'] = Pengelola::max('urutan') + 1;
        Pengelola::create($data);
        return back()->with('success', 'Pengelola berhasil ditambahkan!');
    }

    public function updatePengelola(Request $request, Pengelola $pengelola)
    {
        $data = $request->validate([
            'nama'    => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'ikon'    => 'required|string',
            'foto'    => 'nullable|image|max:2048',
        ]);
        if ($request->hasFile('foto')) {
            if ($pengelola->foto) Storage::disk('public')->delete($pengelola->foto);
            $data['foto'] = $request->file('foto')->store('pengelola', 'public');
        }
        $pengelola->update($data);
        return back()->with('success', 'Data pengelola berhasil diperbarui!');
    }

    public function destroyPengelola(Pengelola $pengelola)
    {
        if ($pengelola->foto) Storage::disk('public')->delete($pengelola->foto);
        $pengelola->delete();
        return back()->with('success', 'Pengelola berhasil dihapus.');
    }

    /* ── JADWAL LATIHAN ─────────────────────────── */
    public function storeJadwal(Request $request)
    {
        $request->validate([
            'hari'        => 'required|string',
            'jam_mulai'   => 'required|string',
            'jam_selesai' => 'required|string',
            'kelas'       => 'required|string|max:255',
            'tempat'      => 'required|string|max:255',
        ]);
        $data = $request->except('_token');
        $data['urutan'] = JadwalLatihan::max('urutan') + 1;
        JadwalLatihan::create($data);
        return back()->with('success', 'Jadwal berhasil ditambahkan!');
    }

    public function updateJadwal(Request $request, JadwalLatihan $jadwal)
    {
        $data = $request->validate([
            'hari'        => 'required|string',
            'jam_mulai'   => 'required|string',
            'jam_selesai' => 'required|string',
            'kelas'       => 'required|string|max:255',
            'tempat'      => 'required|string|max:255',
            'aktif'       => 'boolean',
        ]);
        $jadwal->update($data);
        return back()->with('success', 'Jadwal berhasil diperbarui!');
    }

    public function destroyJadwal(JadwalLatihan $jadwal)
    {
        $jadwal->delete();
        return back()->with('success', 'Jadwal berhasil dihapus.');
    }
}