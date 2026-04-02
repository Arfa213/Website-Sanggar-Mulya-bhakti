<?php
namespace App\Http\Controllers;
use App\Models\{SanggarProfile, Galeri};

class HomeController extends Controller {
    public function index() {
        $profil = SanggarProfile::getInstance();
        // Ambil SEMUA galeri aktif, dikelompokkan di blade pakai ->where()
        $galeri = Galeri::aktif()->get();
        return view('pages.home', compact('profil', 'galeri'));
    }
}
