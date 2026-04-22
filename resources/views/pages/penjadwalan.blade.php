@extends('layouts.member')
@section('title', 'Penjadwalan Tari')
@section('content')

<section style="padding-top:calc(var(--nav-h) + 32px);padding-bottom:80px;background:var(--bg-soft);min-height:100vh">
<div class="container">

    {{-- HEADER --}}
    <div style="text-align:center;margin-bottom:40px">
        <span class="badge">Pendaftaran Kelas</span>
        <h1 style="font-family:var(--font-display);font-size:2.5rem;font-weight:900;color:var(--dark);margin-bottom:8px">Pilih Kelas Tari</h1>
        <p style="color:var(--muted);max-width:540px;margin:0 auto">Daftar satu atau lebih kelas tari yang ingin kamu pelajari. Jadwal akan otomatis disesuaikan.</p>
    </div>

    {{-- FLASH --}}
    @if(session('success'))
    <div style="background:#F0FDF4;border:1px solid #86EFAC;border-radius:12px;padding:14px 20px;margin-bottom:24px;color:#15803D;display:flex;align-items:center;gap:10px">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
        {{ session('success') }}
    </div>
    @endif
    @if(session('error'))
    <div style="background:#FEF2F2;border:1px solid #FECACA;border-radius:12px;padding:14px 20px;margin-bottom:24px;color:#DC2626">
        {{ session('error') }}
    </div>
    @endif

    {{-- KELAS YANG SUDAH TERDAFTAR --}}
    @if($pendaftaran->count())
    <div style="background:#fff;border-radius:16px;border:1px solid var(--border);overflow:hidden;margin-bottom:32px">
        <div style="padding:18px 24px;border-bottom:1px solid var(--border);background:var(--bg-soft)">
            <h3 style="font-family:var(--font-display);font-size:1.1rem;font-weight:700">Kelas yang Sudah Saya Ikuti</h3>
        </div>
        <div style="padding:16px 24px">
            @foreach($pendaftaran as $p)
            <div style="display:flex;align-items:center;gap:16px;padding:14px 0;border-bottom:1px solid #FAF8F6">
                <div style="width:54px;height:54px;background:var(--primary-pale);border-radius:12px;display:flex;align-items:center;justify-content:center;flex-shrink:0">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#C65D2E" stroke-width="1.5"><path d="M9 18V5l12-2v13"/><circle cx="6" cy="18" r="3"/><circle cx="18" cy="16" r="3"/></svg>
                </div>
                <div style="flex:1">
                    <div style="font-weight:700;font-size:.95rem;color:var(--dark)">{{ $p->tarian->nama }}</div>
                    <div style="font-size:.8rem;color:var(--muted);margin-top:2px">
                        📅 {{ $p->jadwal->hari }} &nbsp;·&nbsp;
                        ⏰ {{ $p->jadwal->jam_mulai }}–{{ $p->jadwal->jam_selesai }} &nbsp;·&nbsp;
                        📍 {{ $p->jadwal->tempat }}
                    </div>
                    <div style="font-size:.75rem;color:var(--muted);margin-top:2px">
                        Terdaftar: {{ $p->tanggal_daftar->format('d M Y') }}
                    </div>
                </div>
                <span style="background:#E8F5E9;color:#2E7D32;font-size:.75rem;font-weight:700;padding:4px 12px;border-radius:20px">Aktif</span>
                <form method="POST" action="{{ route('penjadwalan.batalkan', $p->id) }}">
                    @csrf
                    <button type="submit" onclick="return confirm('Batalkan pendaftaran Tari {{ $p->tarian->nama }}?')"
                        style="background:#FEF2F2;border:1px solid #FECACA;color:#DC2626;font-size:.75rem;font-weight:600;padding:6px 12px;border-radius:8px;cursor:pointer">
                        Batalkan
                    </button>
                </form>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    {{-- DAFTAR TARIAN TERSEDIA --}}
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(300px,1fr));gap:24px">
        @foreach($tarianTersedia as $t)
        @php
            $sudahDaftar = $pendaftaran->where('tarian_id', $t->id)->count() > 0;
            $jadwalTarian = $jadwalLatihan; // semua jadwal tersedia
        @endphp

        <div style="background:#fff;border-radius:20px;border:2px solid {{ $sudahDaftar ? '#C65D2E' : 'var(--border)' }};overflow:hidden;transition:all .25s"
             id="card-tarian-{{ $t->id }}">

            {{-- Thumbnail --}}
            <div style="height:140px;background:var(--primary-pale);position:relative;display:flex;align-items:center;justify-content:center">
                @if($t->foto)
                    <img src="{{ asset('storage/'.$t->foto) }}" style="width:100%;height:100%;object-fit:cover">
                @else
                    <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#C65D2E" stroke-width="1"><path d="M9 18V5l12-2v13"/><circle cx="6" cy="18" r="3"/><circle cx="18" cy="16" r="3"/></svg>
                @endif
                @if($sudahDaftar)
                <div style="position:absolute;top:0;left:0;right:0;bottom:0;background:rgba(198,93,46,.12);display:flex;align-items:center;justify-content:center">
                    <span style="background:#C65D2E;color:#fff;font-weight:800;font-size:.8rem;padding:6px 14px;border-radius:20px">✓ Sudah Terdaftar</span>
                </div>
                @endif
                {{-- Category badge --}}
                <div style="position:absolute;top:10px;right:10px;background:rgba(255,255,255,.9);color:#C65D2E;font-size:.7rem;font-weight:800;padding:3px 10px;border-radius:20px">
                    {{ ucfirst($t->kategori) }}
                </div>
            </div>

            <div style="padding:18px">
                <h4 style="font-family:var(--font-display);font-size:1.1rem;font-weight:700;color:var(--dark);margin-bottom:4px">{{ $t->nama }}</h4>
                <p style="font-size:.8rem;color:var(--muted);margin-bottom:4px">📍 {{ $t->asal }}</p>
                @if($t->durasi)
                <p style="font-size:.8rem;color:var(--muted);margin-bottom:12px">⏱ Durasi: {{ $t->durasi }}</p>
                @endif
                <p style="font-size:.85rem;color:var(--text);line-height:1.6;margin-bottom:16px">
                    {{ Str::limit($t->deskripsi, 100) }}
                </p>

                @if(!$sudahDaftar)
                {{-- Form daftar --}}
                <form method="POST" action="{{ route('penjadwalan.daftar') }}" id="form-{{ $t->id }}">
                    @csrf
                    <input type="hidden" name="tarian_id" value="{{ $t->id }}">

                    <div style="margin-bottom:12px">
                        <label style="font-size:.8rem;font-weight:700;color:var(--dark);display:block;margin-bottom:6px">Pilih Jadwal Latihan <span style="color:#C65D2E">*</span></label>
                        <select name="jadwal_id" required
                            style="width:100%;padding:10px 14px;border:1.5px solid var(--border);border-radius:10px;font-size:.85rem;background:#FAF8F6;outline:none;appearance:none">
                            <option value="">-- Pilih hari & jam --</option>
                            @foreach($jadwalTarian as $j)
                            <option value="{{ $j->id }}" {{ request('jadwal_id') == $j->id ? 'selected' : '' }}>
                                {{ $j->hari }} · {{ $j->jam_mulai }}–{{ $j->jam_selesai }} · {{ $j->tempat }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div style="margin-bottom:16px">
                        <label style="font-size:.8rem;font-weight:700;color:var(--dark);display:block;margin-bottom:6px">Catatan (opsional)</label>
                        <input type="text" name="catatan" placeholder="Misal: saya pemula"
                            style="width:100%;padding:10px 14px;border:1.5px solid var(--border);border-radius:10px;font-size:.85rem;background:#FAF8F6;outline:none">
                    </div>

                    <button type="submit"
                        style="width:100%;background:var(--primary);color:#fff;font-family:var(--font-body);font-size:.9rem;font-weight:700;padding:12px;border-radius:50px;border:none;cursor:pointer;transition:background .2s"
                        onmouseover="this.style.background='#A34A22'" onmouseout="this.style.background='#C65D2E'">
                        Daftar Kelas Ini →
                    </button>
                </form>
                @else
                <div style="text-align:center;padding:10px;background:var(--bg-soft);border-radius:10px">
                    <p style="font-size:.85rem;color:var(--muted)">Kamu sudah terdaftar di kelas ini</p>
                </div>
                @endif
            </div>
        </div>
        @endforeach
    </div>

</div>
</section>

<script>
// Auto-select tarian jika ada query param
const tarianParam = new URLSearchParams(window.location.search).get('tarian');
if (tarianParam) {
    const card = document.getElementById('card-tarian-' + tarianParam);
    if (card) card.scrollIntoView({ behavior: 'smooth', block: 'center' });
}
</script>
@endsection