@extends('layouts.app')
@section('title', 'Dashboard Anggota')
@section('content')

<section style="padding-top:calc(var(--nav-h) + 32px);padding-bottom:60px;background:var(--bg-soft);min-height:100vh">
<div class="container">

    {{-- WELCOME HEADER --}}
    <div style="display:flex;align-items:center;gap:20px;margin-bottom:32px;flex-wrap:wrap">
        <div style="width:60px;height:60px;background:var(--primary);border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:1.5rem;font-weight:900;color:#fff;flex-shrink:0">
            {{ strtoupper(substr(auth()->user()->name,0,1)) }}
        </div>
        <div>
            <p style="font-size:.85rem;color:var(--muted);margin-bottom:2px">Selamat datang kembali,</p>
            <h1 style="font-family:var(--font-display);font-size:1.75rem;font-weight:900;color:var(--dark)">{{ $user->name }}</h1>
        </div>
        @if(auth()->user()->role === 'admin')
        <a href="{{ route('admin.dashboard') }}" class="btn-primary" style="margin-left:auto">
            ⚙️ Panel Admin
        </a>
        @endif
    </div>

    {{-- STATS KEHADIRAN --}}
    <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:16px;margin-bottom:32px">
        <div style="background:#fff;border-radius:16px;border:1px solid var(--border);padding:20px;text-align:center">
            <div style="font-family:var(--font-display);font-size:2rem;font-weight:900;color:var(--primary)">{{ $jadwalAktif->count() }}</div>
            <div style="font-size:.8rem;color:var(--muted);margin-top:4px">Kelas Aktif</div>
        </div>
        <div style="background:#fff;border-radius:16px;border:1px solid var(--border);padding:20px;text-align:center">
            <div style="font-family:var(--font-display);font-size:2rem;font-weight:900;color:#2E7D32">{{ $hadir }}</div>
            <div style="font-size:.8rem;color:var(--muted);margin-top:4px">Hadir Bulan Ini</div>
        </div>
        <div style="background:#fff;border-radius:16px;border:1px solid var(--border);padding:20px;text-align:center">
            <div style="font-family:var(--font-display);font-size:2rem;font-weight:900;color:{{ $persenHadir >= 75 ? '#2E7D32' : ($persenHadir >= 50 ? '#E65100' : '#DC2626') }}">{{ $persenHadir }}%</div>
            <div style="font-size:.8rem;color:var(--muted);margin-top:4px">Tingkat Kehadiran</div>
        </div>
        <div style="background:#fff;border-radius:16px;border:1px solid var(--border);padding:20px;text-align:center">
            <div style="font-family:var(--font-display);font-size:2rem;font-weight:900;color:var(--dark)">{{ $totalLatihan }}</div>
            <div style="font-size:.8rem;color:var(--muted);margin-top:4px">Total Sesi</div>
        </div>
    </div>

    <div style="display:grid;grid-template-columns:2fr 1fr;gap:24px;align-items:start">
    <div>

        {{-- JADWAL AKTIF --}}
        <div style="background:#fff;border-radius:16px;border:1px solid var(--border);overflow:hidden;margin-bottom:24px">
            <div style="padding:18px 24px;border-bottom:1px solid var(--border);display:flex;align-items:center;justify-content:space-between">
                <h3 style="font-family:var(--font-display);font-size:1.1rem;font-weight:700">Jadwal Latihan Saya</h3>
                <a href="{{ route('penjadwalan') }}" style="font-size:.8rem;color:var(--primary);font-weight:700">+ Tambah Kelas</a>
            </div>
            @if($jadwalAktif->isEmpty())
            <div style="padding:40px;text-align:center;color:var(--muted)">
                <div style="font-size:2.5rem;margin-bottom:12px">🎭</div>
                <p style="font-weight:600;margin-bottom:6px">Belum ada kelas terdaftar</p>
                <p style="font-size:.85rem">Daftar kelas tari yang ingin kamu pelajari!</p>
                <a href="{{ route('penjadwalan') }}" class="btn-primary" style="display:inline-block;margin-top:16px">Pilih Kelas Tari</a>
            </div>
            @else
            <div style="padding:16px 24px">
                @foreach($jadwalAktif as $p)
                <div style="display:flex;align-items:center;gap:16px;padding:14px 0;border-bottom:1px solid #FAF8F6">
                    <div style="width:50px;height:54px;background:var(--primary);border-radius:10px;display:flex;flex-direction:column;align-items:center;justify-content:center;flex-shrink:0">
                        <span style="color:#fff;font-size:.65rem;font-weight:700;letter-spacing:.5px">{{ strtoupper(substr($p->jadwal->hari,0,3)) }}</span>
                    </div>
                    <div style="flex:1">
                        <div style="font-weight:700;font-size:.95rem;color:var(--dark)">{{ $p->tarian->nama }}</div>
                        <div style="font-size:.8rem;color:var(--muted)">⏰ {{ $p->jadwal->jam_mulai }}–{{ $p->jadwal->jam_selesai }} &nbsp;·&nbsp; 📍 {{ $p->jadwal->tempat }}</div>
                    </div>
                    <form method="POST" action="{{ route('penjadwalan.batalkan', $p->id) }}" style="display:inline">
                        @csrf
                        <button type="submit" onclick="return confirm('Batalkan pendaftaran ini?')"
                            style="background:none;border:1px solid #FECACA;color:#DC2626;font-size:.75rem;padding:4px 10px;border-radius:8px;cursor:pointer">
                            Batalkan
                        </button>
                    </form>
                </div>
                @endforeach
            </div>
            @endif
        </div>

        {{-- ABSENSI TERAKHIR --}}
        @if($absensiTerakhir->count())
        <div style="background:#fff;border-radius:16px;border:1px solid var(--border);overflow:hidden;margin-bottom:24px">
            <div style="padding:18px 24px;border-bottom:1px solid var(--border);display:flex;align-items:center;justify-content:space-between">
                <h3 style="font-family:var(--font-display);font-size:1.1rem;font-weight:700">Absensi Terakhir</h3>
                <a href="{{ route('penjadwalan.kehadiran') }}" style="font-size:.8rem;color:var(--primary);font-weight:700">Lihat semua</a>
            </div>
            <div style="padding:8px 24px">
                @foreach($absensiTerakhir as $ab)
                @php
                    $abColor  = ['hadir'=>'#2E7D32','izin'=>'#E65100','alpa'=>'#DC2626'];
                    $abBg     = ['hadir'=>'#E8F5E9','izin'=>'#FFF3E0','alpa'=>'#FEF2F2'];
                    $abIcon   = ['hadir'=>'✓','izin'=>'~','alpa'=>'✗'];
                @endphp
                <div style="display:flex;align-items:center;gap:12px;padding:10px 0;border-bottom:1px solid #FAF8F6">
                    <div style="width:32px;height:32px;background:{{ $abBg[$ab->status] }};border-radius:8px;display:flex;align-items:center;justify-content:center;font-weight:900;color:{{ $abColor[$ab->status] }};font-size:.9rem">
                        {{ $abIcon[$ab->status] }}
                    </div>
                    <div style="flex:1">
                        <div style="font-size:.85rem;font-weight:600">{{ $ab->tarian->nama }}</div>
                        <div style="font-size:.75rem;color:var(--muted)">{{ $ab->tanggal->isoFormat('D MMM YYYY') }} · {{ $ab->jadwal->hari }}</div>
                    </div>
                    <span style="font-size:.75rem;font-weight:700;color:{{ $abColor[$ab->status] }}">{{ ucfirst($ab->status) }}</span>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        {{-- REKOMENDASI TARIAN --}}
        @if($tarianRekomendasi->count())
        <div style="background:#fff;border-radius:16px;border:1px solid var(--border);overflow:hidden">
            <div style="padding:18px 24px;border-bottom:1px solid var(--border)">
                <h3 style="font-family:var(--font-display);font-size:1.1rem;font-weight:700">Tarian Lain yang Bisa Kamu Pelajari</h3>
            </div>
            <div style="display:grid;grid-template-columns:repeat(2,1fr);gap:12px;padding:16px 24px">
                @foreach($tarianRekomendasi as $t)
                <a href="{{ route('penjadwalan') }}?tarian={{ $t->id }}"
                    style="display:block;background:var(--bg-soft);border-radius:12px;border:1px solid var(--border);padding:14px;text-decoration:none;transition:all .2s"
                    onmouseover="this.style.borderColor='var(--primary)'" onmouseout="this.style.borderColor='var(--border)'">
                    <div style="font-weight:700;font-size:.9rem;color:var(--dark)">{{ $t->nama }}</div>
                    <div style="font-size:.75rem;color:var(--muted);margin-top:2px">{{ ucfirst($t->kategori) }}</div>
                    <div style="font-size:.75rem;color:var(--primary);font-weight:700;margin-top:6px">Daftar →</div>
                </a>
                @endforeach
            </div>
        </div>
        @endif

    </div>

    {{-- SIDEBAR KANAN --}}
    <div>
        {{-- EVENT MENDATANG --}}
        @if($eventMendatang->count())
        <div style="background:#fff;border-radius:16px;border:1px solid var(--border);overflow:hidden;margin-bottom:20px">
            <div style="padding:16px 20px;border-bottom:1px solid var(--border)">
                <h3 style="font-family:var(--font-display);font-size:1rem;font-weight:700">Event Mendatang</h3>
            </div>
            @foreach($eventMendatang as $ev)
            <div style="padding:14px 20px;border-bottom:1px solid #FAF8F6">
                <div style="display:flex;align-items:center;gap:12px">
                    <div style="background:var(--primary);color:#fff;border-radius:8px;padding:6px 10px;text-align:center;flex-shrink:0">
                        <div style="font-size:1rem;font-weight:900;line-height:1">{{ $ev->tanggal->format('d') }}</div>
                        <div style="font-size:.6rem;font-weight:700">{{ $ev->tanggal->isoFormat('MMM') }}</div>
                    </div>
                    <div>
                        <div style="font-size:.85rem;font-weight:700;color:var(--dark)">{{ Str::limit($ev->nama,30) }}</div>
                        <div style="font-size:.75rem;color:var(--muted)">{{ $ev->lokasi }}</div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endif

        {{-- GRAFIK KEHADIRAN --}}
        <div style="background:var(--primary);border-radius:16px;padding:20px;color:#fff">
            <h3 style="font-family:var(--font-display);font-size:1rem;font-weight:700;margin-bottom:16px">Kehadiran Bulan Ini</h3>
            @php
                $h = $kehadiranBulanIni['hadir'] ?? 0;
                $i = $kehadiranBulanIni['izin']  ?? 0;
                $a = $kehadiranBulanIni['alpa']  ?? 0;
                $t = $h + $i + $a;
            @endphp
            @if($t > 0)
            <div style="height:8px;background:rgba(255,255,255,.2);border-radius:4px;overflow:hidden;margin-bottom:14px">
                <div style="height:100%;background:#fff;border-radius:4px;width:{{ round($h/$t*100) }}%"></div>
            </div>
            <div style="display:flex;flex-direction:column;gap:8px">
                <div style="display:flex;align-items:center;justify-content:space-between">
                    <span style="font-size:.8rem;opacity:.85">✓ Hadir</span>
                    <span style="font-weight:700">{{ $h }}</span>
                </div>
                <div style="display:flex;align-items:center;justify-content:space-between">
                    <span style="font-size:.8rem;opacity:.85">~ Izin</span>
                    <span style="font-weight:700">{{ $i }}</span>
                </div>
                <div style="display:flex;align-items:center;justify-content:space-between">
                    <span style="font-size:.8rem;opacity:.85">✗ Alpa</span>
                    <span style="font-weight:700">{{ $a }}</span>
                </div>
            </div>
            @else
            <p style="opacity:.75;font-size:.85rem">Belum ada data kehadiran bulan ini.</p>
            @endif
        </div>

    </div>
    </div>

</div>
</section>
@endsection