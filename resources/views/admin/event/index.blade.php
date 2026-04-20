@extends('admin.layouts.app')
@section('title','Event & Pentas')
@section('content')

<div class="page-header">
    <div class="page-header-text">
        <h1>Event & Pentas</h1>
        <p>Kelola semua event, festival, dan pentas yang diikuti sanggar.</p>
    </div>
    <div class="page-header-actions">
        <a href="{{ route('admin.event.create') }}" class="btn btn-primary">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Tambah Event
        </a>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <span class="card-title">Daftar Semua Event ({{ $events->total() }})</span>
    </div>
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Foto</th><th>Nama Event</th><th>Tanggal</th><th>Lokasi</th>
                    <th>Kategori</th><th>Hasil</th><th>Unggulan</th><th>Status</th><th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($events as $ev)
                @php $catColor = ['internasional'=>'chip--blue','nasional'=>'chip--green','festival'=>'chip--orange','pentas'=>'chip--purple','kompetisi'=>'chip--yellow']; @endphp
                <tr>
                    <td>
                        @if($ev->foto)
                            <img src="{{ asset('storage/'.$ev->foto) }}" class="thumb">
                        @else
                            <div class="thumb-placeholder">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                            </div>
                        @endif
                    </td>
                    <td style="font-weight:600;max-width:200px">{{ $ev->nama }}</td>
                    <td style="white-space:nowrap">{{ $ev->tanggal->format('d M Y') }}</td>
                    <td style="max-width:160px">{{ $ev->lokasi }}</td>
                    <td><span class="chip {{ $catColor[$ev->kategori] ?? 'chip--gray' }}">{{ ucfirst($ev->kategori) }}</span></td>
                    <td style="max-width:120px;font-size:.8rem">{{ $ev->hasil ?? '-' }}</td>
                    <td><span class="chip {{ $ev->unggulan ? 'chip--orange' : 'chip--gray' }}">{{ $ev->unggulan ? '★ Ya' : 'Tidak' }}</span></td>
                    <td><span class="chip {{ $ev->status==='selesai' ? 'chip--green' : 'chip--orange' }}">{{ $ev->status==='selesai' ? 'Selesai' : 'Mendatang' }}</span></td>
                    <td class="td-actions">
                        <a href="{{ route('admin.event.edit',$ev->id) }}" class="btn btn-secondary btn-sm">Edit</a>
                        <form method="POST" action="{{ route('admin.event.destroy',$ev->id) }}" style="display:inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" data-confirm="Hapus event '{{ $ev->nama }}'?">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="9">
                    <div class="empty-state">
                        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                        <h3>Belum ada event</h3>
                        <p>Tambahkan event pertama sanggar.</p>
                        <a href="{{ route('admin.event.create') }}" class="btn btn-primary">+ Tambah Event</a>
                    </div>
                </td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div style="padding:0 16px">{{ $events->links() }}</div>
</div>
@endsection