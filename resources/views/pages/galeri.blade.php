@extends('layouts.app')
@section('title', 'Galeri - ' . ($profil->nama_sanggar ?? 'Sanggar Mulya Bhakti'))

@section('content')
{{-- Hero Section --}}
<section class="page-hero" style="padding-top: calc(var(--nav-h) + 40px); padding-bottom: 40px; background: var(--bg-soft);">
    <div class="container" style="text-align: center;">
        <span class="badge">Galeri</span>
        <h1 style="font-family: var(--font-display); font-size: clamp(2rem, 4vw, 3rem); font-weight: 900; color: var(--dark); margin-bottom: 12px;">Galeri Dokumentasi</h1>
        <p style="color: var(--muted); font-size: 1.1rem;">Dokumentasi kegiatan dan arsip digital Sanggar Seni</p>
    </div>
</section>

{{-- Galeri Content --}}
<section class="galeri-section" style="padding: 60px 0 80px;">
    <div class="container">
        {{-- Tabs --}}
        

        {{-- Tab Panels --}}
        @foreach(['dokumentasi', 'digital_archive', 'hero', 'about'] as $sek)
        @php
            $items = isset($grouped[$sek])
                ? $grouped[$sek]->where('aktif', true)
                : collect();
            $title = [
                'dokumentasi' => 'Dokumentasi Kegiatan',
                'digital_archive' => 'Digital Archive',
                'hero' => 'Hero / Banner',
                'about' => 'Tentang Kami'
            ][$sek];
        @endphp
        <div id="gt-{{ $sek }}" class="tab-panel" style="display: {{ $sek === 'dokumentasi' ? 'block' : 'none' }};">
            @if($items->isEmpty())
            <div style="text-align: center; padding: 80px 20px; background: var(--bg-soft); border-radius: var(--radius);">
                <svg width="80" height="80" viewBox="0 0 24 24" fill="none" stroke="#C65D2E" stroke-width="1" style="margin-bottom: 16px;">
                    <rect x="3" y="3" width="18" height="18" rx="2"/>
                    <circle cx="8.5" cy="8.5" r="1.5"/>
                    <polyline points="21 15 16 10 5 21"/>
                </svg>
                <h3 style="font-family: var(--font-display); font-size: 1.5rem; color: var(--dark); margin-bottom: 8px;">Belum ada media</h3>
                <p style="color: var(--muted);">Belum ada foto/video untuk bagian {{ $title }}</p>
            </div>
            @else
            <div class="galeri-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 24px;">
                @foreach($items as $item)
                <div class="galeri-item" style="border-radius: var(--radius); overflow: hidden; box-shadow: var(--shadow-sm); background: var(--white); transition: transform 0.3s, box-shadow 0.3s; cursor: pointer;"
                     onmouseenter="this.style.transform='translateY(-8px)'; this.style.boxShadow='var(--shadow-md)'"
                     onmouseleave="this.style.transform='translateY(0)'; this.style.boxShadow='var(--shadow-sm)'">
                    @if($item->tipe === 'foto')
                        <div style="position: relative; overflow: hidden; aspect-ratio: 1/1;">
                            <img src="{{ asset('storage/' . $item->file) }}"
                                 alt="{{ $item->judul ?? 'Galeri' }}"
                                 style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.4s;"
                                 onmouseenter="this.style.transform='scale(1.05)'"
                                 onmouseleave="this.style.transform='scale(1)'">
                            <div style="position: absolute; inset: 0; background: linear-gradient(to top, rgba(0,0,0,0.4) 0%, transparent 50%); opacity: 0; transition: opacity 0.3s;"
                                 onmouseenter="this.style.opacity='1'"
                                 onmouseleave="this.style.opacity='0'"></div>
                        </div>
                    @else
                        <div style="width: 100%; aspect-ratio: 1/1; background: var(--dark); display: flex; align-items: center; justify-content: center; flex-direction: column; color: white;">
                            <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                <polygon points="23 7 16 12 23 17 23 7"/>
                                <rect x="1" y="5" width="15" height="14" rx="2"/>
                            </svg>
                            <span style="margin-top: 12px; font-weight: 600;">Video</span>
                        </div>
                    @endif
                    @if($item->judul)
                    <div style="padding: 16px;">
                        <p style="margin: 0; font-size: 0.95rem; color: var(--text); font-weight: 500;">{{ $item->judul }}</p>
                        @if($item->deskripsi)
                        <p style="margin: 6px 0 0; font-size: 0.85rem; color: var(--muted);">{{ Str::limit($item->deskripsi, 80) }}</p>
                        @endif
                    </div>
                    @endif
                </div>
                @endforeach
            </div>
            <p style="margin-top: 24px; font-size: 0.9rem; color: var(--muted);">
                Menampilkan {{ $items->count() }} media
            </p>
            @endif
        </div>
        @endforeach
    </div>
</section>

<style>
    .tab-btn:hover {
        color: var(--primary) !important;
    }
</style>

<script>
    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const tabId = this.getAttribute('data-tab');

            // Update active tab button style
            document.querySelectorAll('.tab-btn').forEach(b => {
                b.style.color = 'var(--muted)';
                b.style.borderBottom = '3px solid transparent';
            });
            this.style.color = 'var(--primary)';
            this.style.borderBottom = '3px solid var(--primary)';

            // Show active panel
            document.querySelectorAll('.tab-panel').forEach(panel => {
                panel.style.display = 'none';
            });
            document.getElementById(tabId).style.display = 'block';
        });
    });
</script>
@endsection
