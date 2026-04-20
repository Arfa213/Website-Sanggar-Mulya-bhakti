@extends('admin.layouts.app')
@section('title', 'Laporan Kehadiran')

@section('content')

<div class="page-header">
    <div class="page-header-text">
        <h1>Laporan Kehadiran</h1>
        <p>Rekap kehadiran anggota per bulan, jadwal, dan tarian.</p>
    </div>
    <a href="{{ route('admin.kehadiran.index') }}"
        style="background:#F3F4F6;color:#3D3D3D;border:1px solid #E8E0D8;padding:10px 20px;border-radius:50px;font-size:.875rem;font-weight:700;text-decoration:none">
        ← Input Kehadiran
    </a>
</div>

{{-- FILTER --}}
<div style="background:#fff;border-radius:16px;border:1px solid #E8E0D8;padding:20px 24px;margin-bottom:24px">
    <form method="GET" style="display:flex;gap:14px;flex-wrap:wrap;align-items:flex-end">
        <div>
            <label style="font-size:.8rem;font-weight:700;display:block;margin-bottom:6px">Bulan</label>
            <input type="month" name="bulan" value="{{ $bulan }}"
                style="padding:9px 14px;border:1.5px solid #E8E0D8;border-radius:10px;font-size:.875rem;background:#FAF8F6;outline:none">
        </div>
        <div>
            <label style="font-size:.8rem;font-weight:700;display:block;margin-bottom:6px">Jadwal</label>
            <select name="jadwal_id"
                style="padding:9px 14px;border:1.5px solid #E8E0D8;border-radius:10px;font-size:.875rem;background:#FAF8F6;outline:none">
                <option value="">Semua Jadwal</option>
                @foreach($jadwalList as $j)
                <option value="{{ $j->id }}" {{ $jadwal_id == $j->id ? 'selected' : '' }}>
                    {{ $j->hari }} · {{ $j->jam_mulai }}
                </option>
                @endforeach
            </select>
        </div>
        <div>
            <label style="font-size:.8rem;font-weight:700;display:block;margin-bottom:6px">Tarian</label>
            <select name="tarian_id"
                style="padding:9px 14px;border:1.5px solid #E8E0D8;border-radius:10px;font-size:.875rem;background:#FAF8F6;outline:none">
                <option value="">Semua Tarian</option>
                @foreach($tarianList as $t)
                <option value="{{ $t->id }}" {{ $tarian_id == $t->id ? 'selected' : '' }}>
                    {{ $t->nama }}
                </option>
                @endforeach
            </select>
        </div>
        <button type="submit"
            style="background:#C65D2E;color:#fff;font-weight:700;padding:10px 24px;border-radius:50px;border:none;cursor:pointer;font-size:.875rem">
            Filter
        </button>
    </form>
</div>

{{-- REKAP PER ANGGOTA --}}
@if($rekap->count())
<div style="background:#fff;border-radius:16px;border:1px solid #E8E0D8;overflow:hidden;margin-bottom:24px">
    <div style="padding:16px 24px;border-bottom:1px solid #F0EBE5">
        <h3 style="font-size:1rem;font-weight:700;color:#1A1A1A">
            Rekap Per Anggota
            <span style="font-size:.8rem;font-weight:400;color:#7A7A7A;margin-left:8px">
                {{ \Carbon\Carbon::createFromFormat('Y-m', $bulan)->isoFormat('MMMM YYYY') }}
            </span>
        </h3>
    </div>
    <div style="overflow-x:auto">
    <table style="width:100%;border-collapse:collapse">
        <thead>
            <tr style="background:#FAFAF8">
                <th style="padding:12px 20px;text-align:left;font-size:.75rem;font-weight:700;color:#7A7A7A;letter-spacing:.5px">NAMA</th>
                <th style="padding:12px 20px;text-align:center;font-size:.75rem;font-weight:700;color:#2E7D32;letter-spacing:.5px">HADIR</th>
                <th style="padding:12px 20px;text-align:center;font-size:.75rem;font-weight:700;color:#E65100;letter-spacing:.5px">IZIN</th>
                <th style="padding:12px 20px;text-align:center;font-size:.75rem;font-weight:700;color:#DC2626;letter-spacing:.5px">ALPA</th>
                <th style="padding:12px 20px;text-align:left;font-size:.75rem;font-weight:700;color:#7A7A7A;letter-spacing:.5px">% KEHADIRAN</th>
            </tr>
        </thead>
        <tbody>
            @foreach($rekap as $r)
            @php
                $pColor = $r['persen'] >= 75 ? '#2E7D32' : ($r['persen'] >= 50 ? '#E65100' : '#DC2626');
            @endphp
            <tr style="border-top:1px solid #F5F3F1">
                <td style="padding:14px 20px">
                    <div style="display:flex;align-items:center;gap:10px">
                        <div style="width:36px;height:36px;background:#FDF0EA;border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:800;color:#C65D2E;font-size:.875rem;flex-shrink:0">
                            {{ strtoupper(substr($r['user']->name, 0, 1)) }}
                        </div>
                        <div>
                            <div style="font-weight:600;font-size:.875rem">{{ $r['user']->name }}</div>
                            <div style="font-size:.75rem;color:#7A7A7A">Total: {{ $r['total'] }} sesi</div>
                        </div>
                    </div>
                </td>
                <td style="padding:14px 20px;text-align:center">
                    <span style="background:#E8F5E9;color:#2E7D32;font-weight:700;font-size:.8rem;padding:4px 10px;border-radius:20px">
                        {{ $r['hadir'] }}
                    </span>
                </td>
                <td style="padding:14px 20px;text-align:center">
                    <span style="background:#FFF3E0;color:#E65100;font-weight:700;font-size:.8rem;padding:4px 10px;border-radius:20px">
                        {{ $r['izin'] }}
                    </span>
                </td>
                <td style="padding:14px 20px;text-align:center">
                    <span style="background:#FEF2F2;color:#DC2626;font-weight:700;font-size:.8rem;padding:4px 10px;border-radius:20px">
                        {{ $r['alpa'] }}
                    </span>
                </td>
                <td style="padding:14px 20px">
                    <div style="display:flex;align-items:center;gap:10px">
                        <div style="flex:1;max-width:120px;height:7px;background:#F3F4F6;border-radius:4px;overflow:hidden">
                            <div style="height:100%;background:{{ $pColor }};width:{{ $r['persen'] }}%;border-radius:4px;transition:width .3s"></div>
                        </div>
                        <span style="font-size:.85rem;font-weight:700;color:{{ $pColor }};min-width:36px">
                            {{ $r['persen'] }}%
                        </span>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    </div>
</div>
@endif

{{-- DETAIL KEHADIRAN --}}
<div style="background:#fff;border-radius:16px;border:1px solid #E8E0D8;overflow:hidden">
    <div style="padding:16px 24px;border-bottom:1px solid #F0EBE5">
        <h3 style="font-size:1rem;font-weight:700;color:#1A1A1A">Detail Kehadiran</h3>
    </div>

    @if($kehadiran->isEmpty())
    <div style="padding:40px;text-align:center;color:#7A7A7A">
        Tidak ada data kehadiran untuk filter yang dipilih.
    </div>
    @else
    <div style="overflow-x:auto">
    <table style="width:100%;border-collapse:collapse">
        <thead>
            <tr style="background:#FAFAF8">
                <th style="padding:12px 20px;text-align:left;font-size:.75rem;font-weight:700;color:#7A7A7A;letter-spacing:.5px">TANGGAL</th>
                <th style="padding:12px 20px;text-align:left;font-size:.75rem;font-weight:700;color:#7A7A7A;letter-spacing:.5px">ANGGOTA</th>
                <th style="padding:12px 20px;text-align:left;font-size:.75rem;font-weight:700;color:#7A7A7A;letter-spacing:.5px">JADWAL</th>
                <th style="padding:12px 20px;text-align:left;font-size:.75rem;font-weight:700;color:#7A7A7A;letter-spacing:.5px">TARIAN</th>
                <th style="padding:12px 20px;text-align:center;font-size:.75rem;font-weight:700;color:#7A7A7A;letter-spacing:.5px">STATUS</th>
                <th style="padding:12px 20px;text-align:left;font-size:.75rem;font-weight:700;color:#7A7A7A;letter-spacing:.5px">KETERANGAN</th>
            </tr>
        </thead>
        <tbody>
            @foreach($kehadiran as $k)
            @php
                $chip = [
                    'hadir' => ['bg'=>'#E8F5E9','color'=>'#2E7D32','label'=>'✓ Hadir'],
                    'izin'  => ['bg'=>'#FFF3E0','color'=>'#E65100','label'=>'~ Izin'],
                    'alpa'  => ['bg'=>'#FEF2F2','color'=>'#DC2626','label'=>'✗ Alpa'],
                ][$k->status];
            @endphp
            <tr style="border-top:1px solid #F5F3F1">
                <td style="padding:12px 20px;font-size:.85rem;white-space:nowrap">
                    {{ $k->tanggal->format('d M Y') }}
                </td>
                <td style="padding:12px 20px">
                    <div style="font-weight:600;font-size:.875rem">{{ $k->user->name }}</div>
                </td>
                <td style="padding:12px 20px;font-size:.85rem;color:#7A7A7A">
                    {{ $k->jadwal->hari }} · {{ $k->jadwal->jam_mulai }}
                </td>
                <td style="padding:12px 20px;font-size:.85rem">
                    {{ $k->tarian->nama }}
                </td>
                <td style="padding:12px 20px;text-align:center">
                    <span style="background:{{ $chip['bg'] }};color:{{ $chip['color'] }};font-size:.75rem;font-weight:700;padding:4px 10px;border-radius:20px;white-space:nowrap">
                        {{ $chip['label'] }}
                    </span>
                </td>
                <td style="padding:12px 20px;font-size:.8rem;color:#7A7A7A">
                    {{ $k->keterangan ?? '-' }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    </div>

    {{-- PAGINATION --}}
    @if($kehadiran->hasPages())
    <div style="padding:12px 24px;border-top:1px solid #F0EBE5">
        {{ $kehadiran->links() }}
    </div>
    @endif
    @endif

</div>

@endsection