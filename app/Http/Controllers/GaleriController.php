<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Galeri;
use App\Models\SanggarProfile;

class GaleriController extends Controller
{
    // Untuk carousel di homepage
public function getForHomepage()
{
    $galeri = Galeri::where('aktif', true)
        ->where('tipe', 'foto')
        ->orderBy('created_at', 'desc')
        ->get();
    
    return view('pages.home', compact('galeri')); // Sesuaikan dengan view homepage Anda
}

// Untuk halaman galeri lengkap
public function frontendIndex($seksi = null)
{
    $query = Galeri::where('aktif', true);

    if ($seksi && in_array($seksi, ['dokumentasi', 'digital_archive', 'hero', 'about'])) {
        $query->where('seksi', $seksi);
    }

    $items = $query->orderBy('created_at', 'desc')->get();
    $grouped = $items->groupBy('seksi');
    $profil = SanggarProfile::first();

    return view('pages.galeri', compact('grouped', 'seksi', 'profil'));
}
}
