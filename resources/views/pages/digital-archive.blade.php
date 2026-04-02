@extends('layouts.app')
@section('title', 'Arsip Digital Tari Indramayu')
@section('content')

{{-- HERO --}}
<section class="page-hero page-hero--archive">
    <div class="page-hero__bg page-hero__bg--archive"></div>
    <div class="container page-hero__inner">
        <span class="badge">Arsip Digital</span>
        <h1 class="page-hero__title">Tari Tradisional<br><em>Indramayu</em></h1>
        <p class="page-hero__sub">Memperkenalkan dan melestarikan kekayaan seni tari tradisional Indramayu — warisan leluhur yang tak ternilai.</p>
        <div class="archive-search-wrap">
            <div class="archive-search">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#7A7A7A" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                <input type="text" id="searchInput" placeholder="Cari nama tarian..." class="archive-search-input">
            </div>
        </div>
    </div>
</section>

{{-- FILTER --}}
<div class="filter-bar">
    <div class="container filter-bar__inner">
        <button class="filter-btn active" data-filter="semua">Semua</button>
        <button class="filter-btn" data-filter="sakral">🌿 Sakral</button>
        <button class="filter-btn" data-filter="hiburan">🎭 Hiburan</button>
        <button class="filter-btn" data-filter="penyambutan">🌺 Penyambutan</button>
        <button class="filter-btn" data-filter="ritual">🔥 Ritual</button>
        <button class="filter-btn" data-filter="perang">⚔️ Perang</button>
    </div>
</div>

{{-- TARIAN --}}
<section class="section">
    <div class="container">
        <div class="section-header">
            <span class="badge">Koleksi Tarian</span>
            <h2 class="section-heading">Tarian Khas Indramayu</h2>
            <p class="section-sub">Setiap gerakan menyimpan cerita, setiap tarian adalah doa dari leluhur.</p>
        </div>

        @if($tarian->count())
        <div class="tarian-grid" id="tarianGrid">
            @foreach($tarian as $idx => $t)
            @php $catColor=['sakral'=>'event-cat--sakral','hiburan'=>'event-cat--hiburan','penyambutan'=>'event-cat--penyambutan','ritual'=>'event-cat--ritual','perang'=>'event-cat--perang']; @endphp
            <div class="tari-card {{ $t->unggulan ? 'tari-card--featured' : '' }}"
                 data-cat="{{ $t->kategori }}"
                 data-nama="{{ strtolower($t->nama) }}">
                <div class="tari-thumb">
                    @if($t->foto)
                        <img src="{{ asset('storage/'.$t->foto) }}" alt="{{ $t->nama }}"
                             class="img-placeholder--tari"
                             style="width:100%;height:220px;object-fit:cover;border-radius:var(--radius) var(--radius) 0 0">
                    @else
                        <div class="img-placeholder img-placeholder--tari">
                            <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#C65D2E" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                        </div>
                    @endif
                    @if($t->unggulan)
                        <span class="tari-featured-badge">★ Unggulan</span>
                    @endif
                    <span class="tari-cat-badge event-cat {{ $catColor[$t->kategori] ?? '' }}">{{ ucfirst($t->kategori) }}</span>
                </div>
                <div class="tari-body">
                    <h3 class="tari-nama">{{ $t->nama }}</h3>
                    <p class="tari-asal">📍 {{ $t->asal }}</p>
                    <p class="tari-desc">{{ Str::limit($t->deskripsi, 120) }}</p>
                    <div class="tari-meta-row">
                        @if($t->fungsi)<span class="tari-meta-item">🎭 {{ $t->fungsi }}</span>@endif
                        @if($t->durasi)<span class="tari-meta-item">⏱ {{ $t->durasi }}</span>@endif
                    </div>
                    <button class="btn-detail" onclick="openModal({{ $idx }})">Lihat Selengkapnya →</button>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div style="text-align:center;padding:60px 20px;color:var(--muted)">
            <p>Belum ada data tarian. Silakan tambahkan melalui panel admin.</p>
        </div>
        @endif
    </div>
</section>

{{-- MODAL --}}
<div class="modal-overlay" id="modalOverlay" onclick="closeModal()">
    <div class="modal-box" onclick="event.stopPropagation()">
        <button class="modal-close" onclick="closeModal()">✕</button>
        <div id="modalContent"></div>
    </div>
</div>

{{-- DATA JSON --}}
<script>
@php
    $tarianJson = $tarian->values()->map(function($t) {
        return [
            'nama'      => $t->nama,
            'asal'      => $t->asal,
            'cat'       => ucfirst($t->kategori),
            'deskripsi' => $t->deskripsi,
            'fungsi'    => $t->fungsi,
            'kostum'    => $t->kostum,
            'durasi'    => $t->durasi,
            'foto'      => $t->foto ? asset('storage/'.$t->foto) : null,
            'video'     => $t->video_url,
        ];
    });
@endphp

    // Sekarang tinggal panggil variabel yang sudah jadi
    const tarianData = @json($tarianJson);


function openModal(idx) {
    const t = tarianData[idx];
    const fotoHtml = t.foto
        ? `<img src="${t.foto}" alt="${t.nama}" style="width:100%;height:260px;object-fit:cover;border-radius:var(--radius) var(--radius) 0 0">`
        : `<div class="img-placeholder img-placeholder--modal"><svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="#C65D2E" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg></div>`;
    const videoHtml = t.video
        ? `<div class="modal-video-wrap" style="margin-top:20px">
               <h4 class="modal-section-title">🎬 Video Tarian</h4>
               <div class="video-embed"><iframe src="${t.video}" frameborder="0" allowfullscreen></iframe></div>
           </div>`
        : `<p class="no-video" style="margin-top:20px">📹 Video belum tersedia untuk tarian ini.</p>`;

    document.getElementById('modalContent').innerHTML = `
        ${fotoHtml}
        <div class="modal-body">
            <span class="badge">${t.cat}</span>
            <h2 class="modal-title">${t.nama}</h2>
            <p class="modal-asal">📍 ${t.asal}</p>
            <p class="modal-desc">${t.deskripsi}</p>
            <div class="modal-info-grid">
                ${t.fungsi ? `<div class="mig-item"><strong>Fungsi</strong><span>${t.fungsi}</span></div>` : ''}
                ${t.kostum ? `<div class="mig-item"><strong>Kostum</strong><span>${t.kostum}</span></div>` : ''}
                ${t.durasi ? `<div class="mig-item"><strong>Durasi</strong><span>${t.durasi}</span></div>` : ''}
            </div>
            ${videoHtml}
        </div>`;
    document.getElementById('modalOverlay').classList.add('active');
    document.body.style.overflow = 'hidden';
}

function closeModal() {
    document.getElementById('modalOverlay').classList.remove('active');
    document.body.style.overflow = '';
    const iframe = document.querySelector('.modal-box iframe');
    if (iframe) iframe.src = iframe.src;
}

// Search
document.getElementById('searchInput')?.addEventListener('input', function () {
    const q = this.value.toLowerCase();
    document.querySelectorAll('.tari-card').forEach(c => {
        c.style.display = c.dataset.nama?.includes(q) ? '' : 'none';
    });
});

// Filter
document.querySelectorAll('.filter-btn').forEach(btn => {
    btn.addEventListener('click', () => {
        document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        const f = btn.dataset.filter;
        document.querySelectorAll('.tari-card').forEach(c => {
            c.style.display = (f === 'semua' || c.dataset.cat === f) ? '' : 'none';
        });
    });
});

document.addEventListener('keydown', e => { if (e.key === 'Escape') closeModal(); });
</script>

@endsection
