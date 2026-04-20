@extends('admin.layouts.app')
@section('title', 'Input Kehadiran')

@section('content')

<div class="page-header">
    <div class="page-header-text">
        <h1>Input Kehadiran</h1>
        <p>
            {{ $jadwal->hari }} ·
            {{ $jadwal->jam_mulai }}–{{ $jadwal->jam_selesai }} ·
            <strong>{{ $tarian->nama }}</strong> ·
            {{ \Carbon\Carbon::parse($request->tanggal)->isoFormat('D MMMM YYYY') }}
        </p>
    </div>
    <a href="{{ route('admin.kehadiran.index') }}"
        style="background:#F3F4F6;color:#3D3D3D;border:1px solid #E8E0D8;padding:10px 20px;border-radius:50px;font-size:.875rem;font-weight:700;text-decoration:none">
        ← Kembali
    </a>
</div>

@if($peserta->isEmpty())
<div style="background:#fff;border-radius:16px;border:1px solid #E8E0D8;padding:60px;text-align:center">
    <div style="font-size:3rem;margin-bottom:12px">🎭</div>
    <p style="font-weight:600;color:#1A1A1A;margin-bottom:6px">Belum ada peserta terdaftar</p>
    <p style="color:#7A7A7A;font-size:.875rem">
        Tidak ada anggota yang mendaftar ke kelas
        <strong>{{ $tarian->nama }}</strong> dengan jadwal <strong>{{ $jadwal->hari }}</strong>.
    </p>
    <a href="{{ route('admin.kehadiran.index') }}" class="btn btn-primary" style="display:inline-block;margin-top:16px">
        ← Pilih Sesi Lain
    </a>
</div>

@else

<form method="POST" action="{{ route('admin.kehadiran.simpan') }}">
    @csrf
    <input type="hidden" name="jadwal_id" value="{{ $jadwal->id }}">
    <input type="hidden" name="tarian_id" value="{{ $tarian->id }}">
    <input type="hidden" name="tanggal"   value="{{ $request->tanggal }}">

    <div style="background:#fff;border-radius:16px;border:1px solid #E8E0D8;overflow:hidden">

        {{-- HEADER CARD --}}
        <div style="padding:16px 24px;border-bottom:1px solid #F0EBE5;display:flex;align-items:center;justify-content:space-between">
            <span style="font-weight:700;color:#1A1A1A">{{ $peserta->count() }} Peserta Terdaftar</span>
            <div style="display:flex;gap:8px">
                <button type="button" onclick="setAll('hadir')"
                    style="background:#E8F5E9;border:1px solid #A5D6A7;color:#2E7D32;font-size:.75rem;font-weight:700;padding:6px 14px;border-radius:8px;cursor:pointer">
                    ✓ Semua Hadir
                </button>
                <button type="button" onclick="setAll('izin')"
                    style="background:#FFF3E0;border:1px solid #FFB74D;color:#E65100;font-size:.75rem;font-weight:700;padding:6px 14px;border-radius:8px;cursor:pointer">
                    ~ Semua Izin
                </button>
                <button type="button" onclick="setAll('alpa')"
                    style="background:#FEF2F2;border:1px solid #FECACA;color:#DC2626;font-size:.75rem;font-weight:700;padding:6px 14px;border-radius:8px;cursor:pointer">
                    ✗ Semua Alpa
                </button>
            </div>
        </div>

        {{-- TABEL --}}
        <div style="overflow-x:auto">
        <table style="width:100%;border-collapse:collapse">
            <thead>
                <tr style="background:#FAFAF8">
                    <th style="padding:12px 20px;text-align:left;font-size:.75rem;font-weight:700;color:#7A7A7A;letter-spacing:.5px;white-space:nowrap">#</th>
                    <th style="padding:12px 20px;text-align:left;font-size:.75rem;font-weight:700;color:#7A7A7A;letter-spacing:.5px">NAMA ANGGOTA</th>
                    <th style="padding:12px 20px;text-align:center;font-size:.75rem;font-weight:700;color:#2E7D32;letter-spacing:.5px">HADIR</th>
                    <th style="padding:12px 20px;text-align:center;font-size:.75rem;font-weight:700;color:#E65100;letter-spacing:.5px">IZIN</th>
                    <th style="padding:12px 20px;text-align:center;font-size:.75rem;font-weight:700;color:#DC2626;letter-spacing:.5px">ALPA</th>
                    <th style="padding:12px 20px;text-align:left;font-size:.75rem;font-weight:700;color:#7A7A7A;letter-spacing:.5px">KETERANGAN</th>
                </tr>
            </thead>
            <tbody>
                @foreach($peserta as $i => $p)
                @php $currentStatus = $existing[$p->user_id] ?? 'hadir'; @endphp
                <tr style="border-top:1px solid #F5F3F1" id="row-{{ $p->user_id }}">
                    <td style="padding:14px 20px;color:#7A7A7A;font-size:.85rem">{{ $i + 1 }}</td>
                    <td style="padding:14px 20px">
                        <div style="display:flex;align-items:center;gap:10px">
                            <div style="width:36px;height:36px;background:#FDF0EA;border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:800;color:#C65D2E;font-size:.875rem;flex-shrink:0">
                                {{ strtoupper(substr($p->user->name, 0, 1)) }}
                            </div>
                            <div>
                                <div style="font-weight:600;font-size:.875rem;color:#1A1A1A">{{ $p->user->name }}</div>
                                <div style="font-size:.75rem;color:#7A7A7A">{{ $p->user->email }}</div>
                            </div>
                        </div>
                    </td>

                    {{-- Radio: Hadir --}}
                    <td style="padding:14px 20px;text-align:center">
                        <label style="cursor:pointer;display:inline-flex;align-items:center;justify-content:center;width:28px;height:28px;border-radius:50%;border:2px solid {{ $currentStatus==='hadir'?'#2E7D32':'#D1D5DB' }};background:{{ $currentStatus==='hadir'?'#2E7D32':'transparent' }};transition:all .15s"
                            id="lbl-hadir-{{ $p->user_id }}"
                            onclick="selectStatus({{ $p->user_id }}, 'hadir')">
                            <input type="radio" name="kehadiran[{{ $p->user_id }}]" value="hadir"
                                {{ $currentStatus === 'hadir' ? 'checked' : '' }}
                                style="display:none">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg>
                        </label>
                    </td>

                    {{-- Radio: Izin --}}
                    <td style="padding:14px 20px;text-align:center">
                        <label style="cursor:pointer;display:inline-flex;align-items:center;justify-content:center;width:28px;height:28px;border-radius:50%;border:2px solid {{ $currentStatus==='izin'?'#E65100':'#D1D5DB' }};background:{{ $currentStatus==='izin'?'#E65100':'transparent' }};transition:all .15s"
                            id="lbl-izin-{{ $p->user_id }}"
                            onclick="selectStatus({{ $p->user_id }}, 'izin')">
                            <input type="radio" name="kehadiran[{{ $p->user_id }}]" value="izin"
                                {{ $currentStatus === 'izin' ? 'checked' : '' }}
                                style="display:none">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="3"><line x1="5" y1="12" x2="19" y2="12"/></svg>
                        </label>
                    </td>

                    {{-- Radio: Alpa --}}
                    <td style="padding:14px 20px;text-align:center">
                        <label style="cursor:pointer;display:inline-flex;align-items:center;justify-content:center;width:28px;height:28px;border-radius:50%;border:2px solid {{ $currentStatus==='alpa'?'#DC2626':'#D1D5DB' }};background:{{ $currentStatus==='alpa'?'#DC2626':'transparent' }};transition:all .15s"
                            id="lbl-alpa-{{ $p->user_id }}"
                            onclick="selectStatus({{ $p->user_id }}, 'alpa')">
                            <input type="radio" name="kehadiran[{{ $p->user_id }}]" value="alpa"
                                {{ $currentStatus === 'alpa' ? 'checked' : '' }}
                                style="display:none">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="3"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                        </label>
                    </td>

                    {{-- Keterangan --}}
                    <td style="padding:14px 20px">
                        <input type="text" name="keterangan[{{ $p->user_id }}]"
                            value="{{ $keteranganExisting[$p->user_id] ?? '' }}"
                            placeholder="Alasan izin/alpa..."
                            style="width:100%;max-width:240px;padding:7px 12px;border:1.5px solid #E8E0D8;border-radius:8px;font-size:.8rem;background:#FAF8F6;outline:none">
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        </div>

        {{-- FOOTER --}}
        <div style="padding:16px 24px;border-top:1px solid #F0EBE5;display:flex;align-items:center;gap:12px">
            <button type="submit"
                style="background:#C65D2E;color:#fff;font-weight:700;padding:12px 28px;border-radius:50px;border:none;cursor:pointer;font-size:.9rem">
                💾 Simpan Kehadiran ({{ $peserta->count() }} peserta)
            </button>
            <a href="{{ route('admin.kehadiran.index') }}"
                style="color:#7A7A7A;font-size:.875rem;font-weight:600;text-decoration:none">
                Batal
            </a>
        </div>

    </div>
</form>

@endif

<script>
const colors = {
    hadir: { border: '#2E7D32', bg: '#2E7D32' },
    izin:  { border: '#E65100', bg: '#E65100' },
    alpa:  { border: '#DC2626', bg: '#DC2626' },
};

function selectStatus(userId, status) {
    ['hadir','izin','alpa'].forEach(s => {
        const lbl = document.getElementById('lbl-' + s + '-' + userId);
        if (!lbl) return;
        if (s === status) {
            lbl.style.borderColor = colors[s].border;
            lbl.style.background  = colors[s].bg;
        } else {
            lbl.style.borderColor = '#D1D5DB';
            lbl.style.background  = 'transparent';
        }
        lbl.querySelector('input').checked = (s === status);
    });
}

function setAll(status) {
    @foreach($peserta as $p)
    selectStatus({{ $p->user_id }}, status);
    @endforeach
}
</script>

@endsection