<?php
namespace App\Http\Controllers;
use App\Models\Tarian;

class DigitalArchiveController extends Controller {
    public function index() {
        $tarian = Tarian::where('aktif', true)->orderBy('urutan')->get();
        return view('pages.digital-archive', compact('tarian'));
    }
}
