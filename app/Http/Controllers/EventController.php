<?php
namespace App\Http\Controllers;
use App\Models\Event;

class EventController extends Controller {
    public function index() {
        $allEvents = Event::where('status','selesai')->orderByDesc('tanggal')->get();
        $featured  = $allEvents->where('unggulan', true)->take(3);
        $byYear    = $allEvents->groupBy(fn($e) => $e->tanggal->year);
        $mendatang = Event::where('status','akan_datang')->orderBy('tanggal')->get();
        $awards    = $allEvents->whereNotNull('hasil')->take(6);
        $stats = [
            'total'          => Event::count(),
            'internasional'  => Event::where('kategori','internasional')->count(),
            'nasional_lokal' => Event::whereIn('kategori',['nasional','festival','pentas','kompetisi'])->count(),
            'penghargaan'    => Event::whereNotNull('hasil')->where('hasil','!=','')->count(),
        ];
        return view('pages.event', compact('featured','byYear','mendatang','awards','stats'));
    }
}
