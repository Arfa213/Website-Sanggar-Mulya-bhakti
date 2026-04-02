<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AnggotaController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', 'anggota');
        if ($request->filled('search')) {
            $q = $request->search;
            $query->where(fn($w) => $w->where('name','like',"%$q%")->orWhere('email','like',"%$q%"));
        }
        if ($request->filled('status')) $query->where('status', $request->status);
        $anggota = $query->orderByDesc('created_at')->paginate(15)->withQueryString();
        return view('admin.anggota.index', compact('anggota'));
    }

    public function create()
    {
        return view('admin.anggota.form', ['anggota' => new User, 'mode' => 'create']);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'alamat'   => 'nullable|string',
            'no_hp'    => 'nullable|string|max:30',
            'password' => 'required|min:8|confirmed',
            'status'   => 'required|in:aktif,nonaktif',
        ]);
        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'alamat'   => $request->alamat,
            'no_hp'    => $request->no_hp,
            'password' => Hash::make($request->password),
            'role'     => 'anggota',
            'status'   => $request->status,
        ]);
        return redirect()->route('admin.anggota.index')->with('success', 'Anggota berhasil ditambahkan!');
    }

    public function edit(User $anggota)
    {
        abort_if($anggota->role === 'admin', 403);
        return view('admin.anggota.form', compact('anggota') + ['mode' => 'edit']);
    }

    public function update(Request $request, User $anggota)
    {
        abort_if($anggota->role === 'admin', 403);
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,'.$anggota->id,
            'alamat'   => 'nullable|string',
            'no_hp'    => 'nullable|string|max:30',
            'status'   => 'required|in:aktif,nonaktif',
            'password' => 'nullable|min:8|confirmed',
        ]);
        $data = $request->only('name','email','alamat','no_hp','status');
        if ($request->filled('password')) $data['password'] = Hash::make($request->password);
        $anggota->update($data);
        return redirect()->route('admin.anggota.index')->with('success', 'Data anggota berhasil diperbarui!');
    }

    public function destroy(User $anggota)
    {
        abort_if($anggota->role === 'admin', 403);
        $anggota->delete();
        return redirect()->route('admin.anggota.index')->with('success', 'Anggota berhasil dihapus.');
    }

    public function toggleStatus(User $anggota)
    {
        $anggota->update(['status' => $anggota->status === 'aktif' ? 'nonaktif' : 'aktif']);
        return back()->with('success', 'Status anggota diperbarui.');
    }
}