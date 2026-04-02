@extends('admin.layouts.app')
@section('title','Dashboard')
@section('content')

<div class="page-header">
    <div class="page-header-text">
        <h1>Dashboard</h1>
        <p>Selamat datang kembali, {{ Auth::user()->name }}! Berikut ringkasan aktivitas sanggar.</p>
    </div>
    <div class="page-header-actions">
        <a href="{{ route('admin.event.create') }}" class="btn btn-primary">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Tambah Event
        </a>
    </div>
</div>

{{-- STAT CARDS --}}
<div class="stat-grid">
    <div class="stat-card">
        <div class="stat-icon stat-icon--orange">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
        </div>
        <div>
            <div class="stat-num">{{ $stats['anggota'] }}</div>
            <div class="stat-label">Total Anggota</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon stat-icon--blue">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
        </div>
        <div>
            <div class="stat-num">{{ $stats['event'] }}</div>
            <div class="stat-label">Total Event</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon stat-icon--purple">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 18V5l12-2v13"/><circle cx="6" cy="18" r="3"/><circle cx="18" cy="16" r="3"/></svg>
        </div>
        <div>
            <div class="stat-num">{{ $stats['tarian'] }}</div>
            <div class="stat-label">Arsip Tarian</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon stat-icon--green">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="8" r="6"/><path d="M15.477 12.89L17 22l-5-3-5 3 1.523-9.11"/></svg>
        </div>
        <div>
            <div class="stat-num">{{ $stats['pelatih'] }}</div>
            <div class="stat-label">Pelatih Aktif</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon stat-icon--yellow">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
        </div>
        <div>
            <div class="stat-num">{{ $stats['galeri'] }}</div>
            <div class="stat-label">Foto & Media</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon stat-icon--orange">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
        </div>
        <div>
            <div class="stat-num">{{ $stats['event_mendatang'] }}</div>
            <div class="stat-label">Event Mendatang</div>
        </div>
    </div>
</div>

{{-- QUICK LINKS --}}
<div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;margin-bottom:28px">
    <div class="card">
        <div class="card-header"><span class="card-title">⚡ Akses Cepat</span></div>
        <div class="card-body" style="display:grid;grid-template-columns:1fr 1fr;gap:10px">
            @php $links = [
                ['route'=>'admin.profil.index','icon'=>'🏠','label'=>'Edit Profil'],
                ['route'=>'admin.event.create','icon'=>'📅','label'=>'Tambah Event'],
                ['route'=>'admin.tarian.create','icon'=>'🎭','label'=>'Tambah Tarian'],
                ['route'=>'admin.galeri.index','icon'=>'🖼️','label'=>'Upload Foto'],
                ['route'=>'admin.anggota.index','icon'=>'👥','label'=>'Kelola Anggota'],
                ['route'=>'admin.anggota.create','icon'=>'➕','label'=>'Tambah Anggota'],
            ]; @endphp
            @foreach($links as $link)
            <a href="{{ route($link['route']) }}" class="btn btn-secondary" style="justify-content:flex-start">
                <span>{{ $link['icon'] }}</span> {{ $link['label'] }}
            </a>
            @endforeach
        </div>
    </div>

    {{-- RECENT ANGGOTA --}}
    <div class="card">
        <div class="card-header">
            <span class="card-title">👥 Anggota Terbaru</span>
            <a href="{{ route('admin.anggota.index') }}" class="btn btn-secondary btn-sm">Lihat Semua</a>
        </div>
        <div class="table-wrap">
            <table>
                <tbody>
                    @forelse($recentAnggota as $a)
                    <tr>
                        <td>
                            <div style="display:flex;align-items:center;gap:10px">
                                <div class="user-avatar" style="width:32px;height:32px;font-size:.8rem">{{ strtoupper(substr($a->name,0,1)) }}</div>
                                <div>
                                    <div style="font-weight:600;font-size:.875rem">{{ $a->name }}</div>
                                    <div style="font-size:.75rem;color:var(--muted)">{{ $a->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td><span class="chip {{ $a->status==='aktif' ? 'chip--green' : 'chip--gray' }}">{{ ucfirst($a->status) }}</span></td>
                    </tr>
                    @empty
                    <tr><td colspan="2" style="text-align:center;color:var(--muted);padding:20px">Belum ada anggota</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- RECENT EVENTS --}}
<div class="card">
    <div class="card-header">
        <span class="card-title">📅 Event Terkini</span>
        <a href="{{ route('admin.event.index') }}" class="btn btn-secondary btn-sm">Lihat Semua</a>
    </div>
    <div class="table-wrap">
        <table>
            <thead><tr><th>Nama Event</th><th>Tanggal</th><th>Lokasi</th><th>Kategori</th><th>Status</th></tr></thead>
            <tbody>
                @forelse($recentEvents as $ev)
                @php $catColor = ['internasional'=>'chip--blue','nasional'=>'chip--green','festival'=>'chip--orange','pentas'=>'chip--purple','kompetisi'=>'chip--yellow']; @endphp
                <tr>
                    <td style="font-weight:600">{{ $ev->nama }}</td>
                    <td>{{ $ev->tanggal->format('d M Y') }}</td>
                    <td>{{ $ev->lokasi }}</td>
                    <td><span class="chip {{ $catColor[$ev->kategori] ?? 'chip--gray' }}">{{ ucfirst($ev->kategori) }}</span></td>
                    <td><span class="chip {{ $ev->status==='selesai' ? 'chip--green' : 'chip--orange' }}">{{ $ev->status==='selesai' ? 'Selesai' : 'Mendatang' }}</span></td>
                </tr>
                @empty
                <tr><td colspan="5" style="text-align:center;color:var(--muted);padding:20px">Belum ada event</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection