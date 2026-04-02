<?php
namespace App\Http\Controllers;
use App\Models\{SanggarProfile, Pelatih, Pengelola, JadwalLatihan, Event};

class ProfileController extends Controller {
    public function index() {
        $profil    = SanggarProfile::getInstance();
        $pelatih   = Pelatih::where('aktif', true)->orderBy('urutan')->get();
        $pengelola = Pengelola::where('aktif', true)->orderBy('urutan')->get();
        $jadwal    = JadwalLatihan::where('aktif', true)->orderBy('urutan')->get();
        $upcoming  = Event::where('status', 'akan_datang')->orderBy('tanggal')->limit(5)->get();
        return view('pages.profile', compact('profil','pelatih','pengelola','jadwal','upcoming'));
    }
}
