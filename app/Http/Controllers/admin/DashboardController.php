<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{User, Event, Tarian, Pelatih, Galeri};

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'anggota'     => User::where('role','anggota')->count(),
            'event'       => Event::count(),
            'tarian'      => Tarian::count(),
            'pelatih'     => Pelatih::where('aktif', true)->count(),
            'galeri'      => Galeri::count(),
            'event_mendatang' => Event::mendatang()->count(),
        ];

        $recentEvents  = Event::orderByDesc('tanggal')->limit(5)->get();
        $recentAnggota = User::where('role','anggota')->orderByDesc('created_at')->limit(5)->get();

        return view('admin.dashboard.index', compact('stats','recentEvents','recentAnggota'));
    }
}