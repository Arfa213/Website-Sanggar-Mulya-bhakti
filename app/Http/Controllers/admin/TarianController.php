<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tarian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TarianController extends Controller
{
    public function index()
    {
        $tarian = Tarian::orderBy('urutan')->paginate(15);
        return view('admin.tarian.index', compact('tarian'));
    }

    public function create()
    {
        return view('admin.tarian.form', ['tarian' => new Tarian, 'mode' => 'create']);
    }

    public function store(Request $request)
    {
        $data = $this->validateTarian($request);
        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('tarian', 'public');
        }
        $data['urutan'] = Tarian::max('urutan') + 1;
        Tarian::create($data);
        return redirect()->route('admin.tarian.index')->with('success', 'Tarian berhasil ditambahkan!');
    }

    public function edit(Tarian $tarian)
    {
        return view('admin.tarian.form', compact('tarian') + ['mode' => 'edit']);
    }

    public function update(Request $request, Tarian $tarian)
    {
        $data = $this->validateTarian($request);
        if ($request->hasFile('foto')) {
            if ($tarian->foto) Storage::disk('public')->delete($tarian->foto);
            $data['foto'] = $request->file('foto')->store('tarian', 'public');
        }
        $tarian->update($data);
        return redirect()->route('admin.tarian.index')->with('success', 'Tarian berhasil diperbarui!');
    }

    public function destroy(Tarian $tarian)
    {
        if ($tarian->foto) Storage::disk('public')->delete($tarian->foto);
        $tarian->delete();
        return redirect()->route('admin.tarian.index')->with('success', 'Tarian berhasil dihapus.');
    }

    private function validateTarian(Request $request): array
    {
        return $request->validate([
            'nama'      => 'required|string|max:255',
            'asal'      => 'required|string|max:255',
            'kategori'  => 'required|in:sakral,hiburan,penyambutan,ritual,perang',
            'deskripsi' => 'required|string',
            'fungsi'    => 'nullable|string|max:255',
            'kostum'    => 'nullable|string|max:255',
            'durasi'    => 'nullable|string|max:100',
            'video_url' => 'nullable|url|max:500',
            'unggulan'  => 'boolean',
            'aktif'     => 'boolean',
            'foto'      => 'nullable|image|max:3072',
        ]);
    }
}