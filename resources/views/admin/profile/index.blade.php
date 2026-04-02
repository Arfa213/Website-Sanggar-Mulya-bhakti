@extends('admin.layouts.app')
@section('title','Profil Sanggar')
@section('content')

<div class="page-header">
    <div class="page-header-text">
        <h1>Profil Sanggar</h1>
        <p>Kelola semua informasi yang tampil di halaman profil website.</p>
    </div>
</div>

<div data-tabs>
<div class="tabs">
    <button class="tab-btn active" data-tab="tab-profil">🏠 Profil & Kontak</button>
    <button class="tab-btn" data-tab="tab-visi">👁 Visi & Misi</button>
    <button class="tab-btn" data-tab="tab-pelatih">🎓 Pelatih</button>
    <button class="tab-btn" data-tab="tab-pengelola">🏛 Pengelola</button>
    <button class="tab-btn" data-tab="tab-jadwal">🕐 Jadwal Latihan</button>
</div>

{{-- ── TAB: PROFIL ── --}}
<div id="tab-profil" class="tab-panel active">
<form method="POST" action="{{ route('admin.profil.update') }}" enctype="multipart/form-data">
@csrf @method('PUT')
<div class="card">
    <div class="card-header"><span class="card-title">Informasi Dasar Sanggar</span></div>
    <div class="card-body">
        <div class="form-grid">
            <div class="form-group">
                <label>Nama Sanggar <span class="required">*</span></label>
                <input type="text" name="nama_sanggar" class="form-control" value="{{ old('nama_sanggar',$profil->nama_sanggar) }}" required>
            </div>
            <div class="form-group">
                <label>Tagline</label>
                <input type="text" name="tagline" class="form-control" value="{{ old('tagline',$profil->tagline) }}" placeholder="Melestarikan Budaya Melalui Seni">
            </div>
            <div class="form-group">
                <label>Tahun Berdiri</label>
                <input type="text" name="tahun_berdiri" class="form-control" value="{{ old('tahun_berdiri',$profil->tahun_berdiri) }}" placeholder="2005">
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email',$profil->email) }}">
            </div>
            <div class="form-group">
                <label>No. HP / WhatsApp</label>
                <input type="text" name="no_hp" class="form-control" value="{{ old('no_hp',$profil->no_hp) }}">
            </div>
            <div class="form-group">
                <label>Alamat</label>
                <input type="text" name="alamat" class="form-control" value="{{ old('alamat',$profil->alamat) }}">
            </div>
            <div class="form-group">
                <label>Instagram</label>
                <input type="text" name="instagram" class="form-control" value="{{ old('instagram',$profil->instagram) }}" placeholder="@sanggarmulya">
            </div>
            <div class="form-group">
                <label>Facebook</label>
                <input type="text" name="facebook" class="form-control" value="{{ old('facebook',$profil->facebook) }}">
            </div>
            <div class="form-group">
                <label>YouTube</label>
                <input type="text" name="youtube" class="form-control" value="{{ old('youtube',$profil->youtube) }}">
            </div>
        </div>

        <div class="section-title-bar"><h3>Statistik Halaman Utama</h3></div>
        <div class="form-grid-3">
            <div class="form-group">
                <label>Jumlah Anggota Aktif</label>
                <input type="number" name="jumlah_anggota" class="form-control" value="{{ old('jumlah_anggota',$profil->jumlah_anggota) }}">
            </div>
            <div class="form-group">
                <label>Jumlah Penghargaan</label>
                <input type="number" name="jumlah_penghargaan" class="form-control" value="{{ old('jumlah_penghargaan',$profil->jumlah_penghargaan) }}">
            </div>
            <div class="form-group">
                <label>Jumlah Event Dihadiri</label>
                <input type="number" name="jumlah_event" class="form-control" value="{{ old('jumlah_event',$profil->jumlah_event) }}">
            </div>
        </div>

        <div class="section-title-bar"><h3>Foto</h3></div>
        <div class="form-grid">
            <div class="form-group">
                <label>Foto Profil Sanggar (Hero)</label>
                <div class="file-upload-area">
                    <input type="file" name="foto_profil" accept="image/*">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                    <p><strong>Klik atau seret</strong> foto ke sini</p>
                </div>
                <div class="file-preview" style="{{ $profil->foto_profil ? '' : 'display:none' }}">
                    <img src="{{ $profil->foto_profil ? asset('storage/'.$profil->foto_profil) : '' }}" alt="">
                </div>
            </div>
            <div class="form-group">
                <label>Foto Seksi Sejarah</label>
                <div class="file-upload-area">
                    <input type="file" name="foto_sejarah" accept="image/*">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                    <p><strong>Klik atau seret</strong> foto ke sini</p>
                </div>
                <div class="file-preview" style="{{ $profil->foto_sejarah ? '' : 'display:none' }}">
                    <img src="{{ $profil->foto_sejarah ? asset('storage/'.$profil->foto_sejarah) : '' }}" alt="">
                </div>
            </div>
        </div>
    </div>
</div>
<div style="margin-top:16px;display:flex;justify-content:flex-end"><button type="submit" class="btn btn-primary">💾 Simpan Perubahan</button></div>
</form>
</div>

{{-- ── TAB: VISI MISI ── --}}
<div id="tab-visi" class="tab-panel">
<form method="POST" action="{{ route('admin.profil.update') }}" enctype="multipart/form-data">
@csrf @method('PUT')
{{-- hidden fields to keep other data intact --}}
<input type="hidden" name="nama_sanggar" value="{{ $profil->nama_sanggar }}">
<input type="hidden" name="sejarah" value="{{ $profil->sejarah }}">
<div class="card">
    <div class="card-header"><span class="card-title">Sejarah Sanggar</span></div>
    <div class="card-body">
        <div class="form-group">
            <label>Teks Sejarah <span class="required">*</span></label>
            <textarea name="sejarah" class="form-control" rows="6" required>{{ old('sejarah',$profil->sejarah) }}</textarea>
        </div>
    </div>
</div>
<div class="card" style="margin-top:20px">
    <div class="card-header"><span class="card-title">Visi & Misi</span></div>
    <div class="card-body">
        <div class="form-group" style="margin-bottom:24px">
            <label>Visi <span class="required">*</span></label>
            <textarea name="visi" class="form-control" rows="3" required>{{ old('visi',$profil->visi) }}</textarea>
        </div>
        <label style="font-size:.875rem;font-weight:600;color:var(--dark)">Misi <span class="required">*</span></label>
        <div class="hint" style="margin-bottom:10px;font-size:.78rem;color:var(--muted)">Tambahkan poin misi satu per satu.</div>
        <div id="misiWrap">
            @foreach(old('misi', $profil->misi ?? []) as $i => $m)
            <div class="misi-row" style="display:flex;gap:8px;margin-bottom:8px">
                <input type="text" name="misi[{{ $i }}]" class="form-control" value="{{ $m }}" required>
                <button type="button" onclick="this.parentElement.remove()" class="btn btn-danger btn-sm btn-icon">✕</button>
            </div>
            @endforeach
        </div>
        <button type="button" id="addMisi" class="btn btn-secondary btn-sm" style="margin-top:8px">+ Tambah Poin Misi</button>
    </div>
</div>
<div style="margin-top:16px;display:flex;justify-content:flex-end"><button type="submit" class="btn btn-primary">💾 Simpan</button></div>
</form>
</div>

{{-- ── TAB: PELATIH ── --}}
<div id="tab-pelatih" class="tab-panel">
<div class="page-header-actions" style="margin-bottom:16px;justify-content:flex-end">
    <button class="btn btn-primary" data-modal-open="modalAddPelatih">+ Tambah Pelatih</button>
</div>
<div class="card">
    <div class="table-wrap">
        <table>
            <thead><tr><th>Foto</th><th>Nama</th><th>Jabatan</th><th>Spesialisasi</th><th>Pengalaman</th><th>Status</th><th>Aksi</th></tr></thead>
            <tbody>
                @forelse($pelatih as $p)
                <tr>
                    <td>@if($p->foto)<img src="{{ asset('storage/'.$p->foto) }}" class="thumb">@else<div class="thumb-placeholder"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg></div>@endif</td>
                    <td style="font-weight:600">{{ $p->nama }}</td>
                    <td>{{ $p->jabatan }}</td>
                    <td>{{ $p->spesialisasi ?? '-' }}</td>
                    <td>{{ $p->pengalaman ?? '-' }}</td>
                    <td><span class="chip {{ $p->aktif ? 'chip--green' : 'chip--gray' }}">{{ $p->aktif ? 'Aktif' : 'Non-aktif' }}</span></td>
                    <td class="td-actions">
                        <button class="btn btn-secondary btn-sm" data-modal-open="editPelatih{{ $p->id }}">Edit</button>
                        <form method="POST" action="{{ route('admin.pelatih.destroy',$p) }}" style="display:inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" data-confirm="Hapus pelatih {{ $p->nama }}?">Hapus</button>
                        </form>
                    </td>
                </tr>
                {{-- Edit Modal --}}
                <div class="modal-bg" id="editPelatih{{ $p->id }}">
                    <div class="modal-box">
                        <div class="modal-header"><h3>Edit Pelatih</h3><button class="modal-close-btn" data-modal-close>✕</button></div>
                        <form method="POST" action="{{ route('admin.pelatih.update',$p) }}" enctype="multipart/form-data">
                        @csrf @method('PUT')
                        <div class="modal-body">
                            <div class="form-group" style="margin-bottom:14px"><label>Nama</label><input type="text" name="nama" class="form-control" value="{{ $p->nama }}" required></div>
                            <div class="form-group" style="margin-bottom:14px"><label>Jabatan</label><input type="text" name="jabatan" class="form-control" value="{{ $p->jabatan }}" required></div>
                            <div class="form-group" style="margin-bottom:14px"><label>Spesialisasi</label><input type="text" name="spesialisasi" class="form-control" value="{{ $p->spesialisasi }}"></div>
                            <div class="form-group" style="margin-bottom:14px"><label>Pengalaman</label><input type="text" name="pengalaman" class="form-control" value="{{ $p->pengalaman }}" placeholder="15+ Tahun"></div>
                            <div class="form-group" style="margin-bottom:14px"><label>Bio</label><textarea name="bio" class="form-control" rows="3">{{ $p->bio }}</textarea></div>
                            <div class="form-group" style="margin-bottom:14px">
                                <label>Foto</label>
                                <input type="file" name="foto" class="form-control" accept="image/*">
                                @if($p->foto)<img src="{{ asset('storage/'.$p->foto) }}" style="height:60px;margin-top:8px;border-radius:8px">@endif
                            </div>
                            <label class="form-check"><input type="checkbox" name="aktif" value="1" {{ $p->aktif ? 'checked' : '' }}><span class="form-check-label">Tampilkan di website</span></label>
                        </div>
                        <div class="modal-footer"><button type="button" class="btn btn-secondary" data-modal-close>Batal</button><button type="submit" class="btn btn-primary">Simpan</button></div>
                        </form>
                    </div>
                </div>
                @empty
                <tr><td colspan="7"><div class="empty-state"><p>Belum ada pelatih.</p></div></td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Add Pelatih Modal --}}
<div class="modal-bg" id="modalAddPelatih">
    <div class="modal-box">
        <div class="modal-header"><h3>Tambah Pelatih</h3><button class="modal-close-btn" data-modal-close>✕</button></div>
        <form method="POST" action="{{ route('admin.pelatih.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="modal-body">
            <div class="form-group" style="margin-bottom:14px"><label>Nama <span class="required">*</span></label><input type="text" name="nama" class="form-control" required></div>
            <div class="form-group" style="margin-bottom:14px"><label>Jabatan <span class="required">*</span></label><input type="text" name="jabatan" class="form-control" required></div>
            <div class="form-group" style="margin-bottom:14px"><label>Spesialisasi</label><input type="text" name="spesialisasi" class="form-control"></div>
            <div class="form-group" style="margin-bottom:14px"><label>Pengalaman</label><input type="text" name="pengalaman" class="form-control" placeholder="15+ Tahun"></div>
            <div class="form-group" style="margin-bottom:14px"><label>Bio</label><textarea name="bio" class="form-control" rows="3"></textarea></div>
            <div class="form-group"><label>Foto</label><input type="file" name="foto" class="form-control" accept="image/*"></div>
        </div>
        <div class="modal-footer"><button type="button" class="btn btn-secondary" data-modal-close>Batal</button><button type="submit" class="btn btn-primary">Simpan</button></div>
        </form>
    </div>
</div>
</div>

{{-- ── TAB: PENGELOLA ── --}}
<div id="tab-pengelola" class="tab-panel">
<div style="margin-bottom:16px;display:flex;justify-content:flex-end">
    <button class="btn btn-primary" data-modal-open="modalAddPengelola">+ Tambah Pengelola</button>
</div>
<div class="card">
    <div class="table-wrap">
        <table>
            <thead><tr><th>Foto</th><th>Nama</th><th>Jabatan</th><th>Ikon</th><th>Status</th><th>Aksi</th></tr></thead>
            <tbody>
                @forelse($pengelola as $pg)
                <tr>
                    <td>@if($pg->foto)<img src="{{ asset('storage/'.$pg->foto) }}" class="thumb">@else<div class="thumb-placeholder"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg></div>@endif</td>
                    <td style="font-weight:600">{{ $pg->nama }}</td>
                    <td>{{ $pg->jabatan }}</td>
                    <td><span class="chip chip--gray">{{ $pg->ikon }}</span></td>
                    <td><span class="chip {{ $pg->aktif ? 'chip--green' : 'chip--gray' }}">{{ $pg->aktif ? 'Aktif' : 'Non-aktif' }}</span></td>
                    <td class="td-actions">
                        <button class="btn btn-secondary btn-sm" data-modal-open="editPengelola{{ $pg->id }}">Edit</button>
                        <form method="POST" action="{{ route('admin.pengelola.destroy',$pg) }}" style="display:inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" data-confirm="Hapus pengelola {{ $pg->nama }}?">Hapus</button>
                        </form>
                    </td>
                </tr>
                <div class="modal-bg" id="editPengelola{{ $pg->id }}">
                    <div class="modal-box">
                        <div class="modal-header"><h3>Edit Pengelola</h3><button class="modal-close-btn" data-modal-close>✕</button></div>
                        <form method="POST" action="{{ route('admin.pengelola.update',$pg) }}" enctype="multipart/form-data">@csrf @method('PUT')
                        <div class="modal-body">
                            <div class="form-group" style="margin-bottom:14px"><label>Nama</label><input type="text" name="nama" class="form-control" value="{{ $pg->nama }}" required></div>
                            <div class="form-group" style="margin-bottom:14px"><label>Jabatan</label><input type="text" name="jabatan" class="form-control" value="{{ $pg->jabatan }}" required></div>
                            <div class="form-group" style="margin-bottom:14px"><label>Ikon</label>
                                <select name="ikon" class="form-control">
                                    @foreach(['crown','edit','briefcase','star','calendar','users'] as $ic)
                                    <option value="{{ $ic }}" {{ $pg->ikon===$ic?'selected':'' }}>{{ $ic }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group"><label>Foto</label><input type="file" name="foto" class="form-control" accept="image/*">
                            @if($pg->foto)<img src="{{ asset('storage/'.$pg->foto) }}" style="height:60px;margin-top:8px;border-radius:8px">@endif</div>
                        </div>
                        <div class="modal-footer"><button type="button" class="btn btn-secondary" data-modal-close>Batal</button><button type="submit" class="btn btn-primary">Simpan</button></div>
                        </form>
                    </div>
                </div>
                @empty
                <tr><td colspan="6"><div class="empty-state"><p>Belum ada pengelola.</p></div></td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="modal-bg" id="modalAddPengelola">
    <div class="modal-box">
        <div class="modal-header"><h3>Tambah Pengelola</h3><button class="modal-close-btn" data-modal-close>✕</button></div>
        <form method="POST" action="{{ route('admin.pengelola.store') }}" enctype="multipart/form-data">@csrf
        <div class="modal-body">
            <div class="form-group" style="margin-bottom:14px"><label>Nama <span class="required">*</span></label><input type="text" name="nama" class="form-control" required></div>
            <div class="form-group" style="margin-bottom:14px"><label>Jabatan <span class="required">*</span></label><input type="text" name="jabatan" class="form-control" required></div>
            <div class="form-group" style="margin-bottom:14px"><label>Ikon</label>
                <select name="ikon" class="form-control">
                    @foreach(['crown','edit','briefcase','star','calendar','users'] as $ic)
                    <option value="{{ $ic }}">{{ $ic }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group"><label>Foto</label><input type="file" name="foto" class="form-control" accept="image/*"></div>
        </div>
        <div class="modal-footer"><button type="button" class="btn btn-secondary" data-modal-close>Batal</button><button type="submit" class="btn btn-primary">Simpan</button></div>
        </form>
    </div>
</div>
</div>

{{-- ── TAB: JADWAL ── --}}
<div id="tab-jadwal" class="tab-panel">
<div style="margin-bottom:16px;display:flex;justify-content:flex-end">
    <button class="btn btn-primary" data-modal-open="modalAddJadwal">+ Tambah Jadwal</button>
</div>
<div class="card">
    <div class="table-wrap">
        <table>
            <thead><tr><th>Hari</th><th>Kelas</th><th>Jam</th><th>Tempat</th><th>Status</th><th>Aksi</th></tr></thead>
            <tbody>
                @forelse($jadwal as $j)
                <tr>
                    <td style="font-weight:700;color:var(--p)">{{ $j->hari }}</td>
                    <td style="font-weight:600">{{ $j->kelas }}</td>
                    <td>{{ $j->jam_mulai }} – {{ $j->jam_selesai }}</td>
                    <td>{{ $j->tempat }}</td>
                    <td><span class="chip {{ $j->aktif ? 'chip--green' : 'chip--gray' }}">{{ $j->aktif ? 'Aktif' : 'Non-aktif' }}</span></td>
                    <td class="td-actions">
                        <button class="btn btn-secondary btn-sm" data-modal-open="editJadwal{{ $j->id }}">Edit</button>
                        <form method="POST" action="{{ route('admin.jadwal.destroy',$j) }}" style="display:inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" data-confirm="Hapus jadwal {{ $j->hari }}?">Hapus</button>
                        </form>
                    </td>
                </tr>
                <div class="modal-bg" id="editJadwal{{ $j->id }}">
                    <div class="modal-box">
                        <div class="modal-header"><h3>Edit Jadwal</h3><button class="modal-close-btn" data-modal-close>✕</button></div>
                        <form method="POST" action="{{ route('admin.jadwal.update',$j) }}">@csrf @method('PUT')
                        <div class="modal-body">
                            <div class="form-group" style="margin-bottom:14px"><label>Hari</label>
                                <select name="hari" class="form-control">
                                    @foreach(['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'] as $hr)
                                    <option value="{{ $hr }}" {{ $j->hari===$hr?'selected':'' }}>{{ $hr }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group" style="margin-bottom:14px"><label>Nama Kelas</label><input type="text" name="kelas" class="form-control" value="{{ $j->kelas }}" required></div>
                            <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;margin-bottom:14px">
                                <div class="form-group"><label>Jam Mulai</label><input type="time" name="jam_mulai" class="form-control" value="{{ $j->jam_mulai }}"></div>
                                <div class="form-group"><label>Jam Selesai</label><input type="time" name="jam_selesai" class="form-control" value="{{ $j->jam_selesai }}"></div>
                            </div>
                            <div class="form-group" style="margin-bottom:14px"><label>Tempat</label><input type="text" name="tempat" class="form-control" value="{{ $j->tempat }}" required></div>
                            <label class="form-check"><input type="checkbox" name="aktif" value="1" {{ $j->aktif ? 'checked' : '' }}><span class="form-check-label">Tampilkan di website</span></label>
                        </div>
                        <div class="modal-footer"><button type="button" class="btn btn-secondary" data-modal-close>Batal</button><button type="submit" class="btn btn-primary">Simpan</button></div>
                        </form>
                    </div>
                </div>
                @empty
                <tr><td colspan="6"><div class="empty-state"><p>Belum ada jadwal latihan.</p></div></td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="modal-bg" id="modalAddJadwal">
    <div class="modal-box">
        <div class="modal-header"><h3>Tambah Jadwal</h3><button class="modal-close-btn" data-modal-close>✕</button></div>
        <form method="POST" action="{{ route('admin.jadwal.store') }}">@csrf
        <div class="modal-body">
            <div class="form-group" style="margin-bottom:14px"><label>Hari <span class="required">*</span></label>
                <select name="hari" class="form-control">
                    @foreach(['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'] as $hr)
                    <option value="{{ $hr }}">{{ $hr }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group" style="margin-bottom:14px"><label>Nama Kelas <span class="required">*</span></label><input type="text" name="kelas" class="form-control" placeholder="Tari Dasar (Pemula)" required></div>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;margin-bottom:14px">
                <div class="form-group"><label>Jam Mulai</label><input type="time" name="jam_mulai" class="form-control" value="15:00"></div>
                <div class="form-group"><label>Jam Selesai</label><input type="time" name="jam_selesai" class="form-control" value="17:30"></div>
            </div>
            <div class="form-group"><label>Tempat <span class="required">*</span></label><input type="text" name="tempat" class="form-control" placeholder="Studio Utama" required></div>
        </div>
        <div class="modal-footer"><button type="button" class="btn btn-secondary" data-modal-close>Batal</button><button type="submit" class="btn btn-primary">Simpan</button></div>
        </form>
    </div>
</div>
</div>

</div> {{-- end data-tabs --}}
@endsection