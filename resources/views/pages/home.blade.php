@extends('layouts.app')
@section('title', $profil->nama_sanggar ?? 'Beranda')
@section('content')

{{-- HERO --}}
<section class="hero">
    <div class="container hero-inner">
        <div class="hero-text">
            <span class="badge">Sanggar Seni Tradisional</span>
            <h1 class="hero-title">{{ $profil->tagline ?? 'Melestarikan Budaya Melalui Seni' }}</h1>
            <p class="hero-desc">
                Bergabunglah dengan komunitas pecinta seni tari tradisional Indonesia.
                Belajar, berkreasi, dan lestarikan warisan budaya bersama kami.
            </p>
            <a href="{{ route('register') }}" class="btn-primary">Daftar Anggota →</a>
        </div>
        <div class="hero-image">
            <div class="hero-img-wrapper">
                @php $heroFoto = $galeri->where('seksi','hero')->first(); @endphp
                @if($heroFoto)
                    <img src="{{ asset('storage/'.$heroFoto->file) }}"
                         alt="{{ $profil->nama_sanggar }}"
                         class="hero-placeholder">
                @else
                    <div class="img-placeholder hero-placeholder">
                        <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="#C65D2E" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                    </div>
                @endif
                <div class="hero-badge-float">
                    <span class="float-number">{{ $profil->jumlah_penghargaan ?? 0 }}+</span>
                    <span class="float-title">Penghargaan</span>
                    <span class="float-sub">Tingkat Nasional</span>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- STATS --}}
<section class="stats">
    <div class="container stats-grid">
        <div class="stat-item">
            <div class="stat-icon">
                <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#C65D2E" stroke-width="1.5"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
            </div>
            <div class="stat-number">{{ $profil->jumlah_anggota ?? 0 }}+</div>
            <div class="stat-label">Anggota Aktif</div>
        </div>
        <div class="stat-item">
            <div class="stat-icon">
                <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#C65D2E" stroke-width="1.5"><circle cx="12" cy="8" r="6"/><path d="M15.477 12.89L17 22l-5-3-5 3 1.523-9.11"/></svg>
            </div>
            <div class="stat-number">{{ $profil->jumlah_penghargaan ?? 0 }}+</div>
            <div class="stat-label">Penghargaan</div>
        </div>
        <div class="stat-item">
            <div class="stat-icon">
                <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#C65D2E" stroke-width="1.5"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
            </div>
            <div class="stat-number">{{ $profil->jumlah_event ?? 0 }}+</div>
            <div class="stat-label">Menghadiri Event</div>
        </div>
    </div>
</section>

{{-- TENTANG KAMI --}}
<section class="about">
    <div class="container about-inner">
        <div class="about-image">
            @php $aboutFoto = $galeri->where('seksi','about')->first(); @endphp
            @if($aboutFoto)
                <img src="{{ asset('storage/'.$aboutFoto->file) }}"
                     alt="Tentang {{ $profil->nama_sanggar }}"
                     class="about-placeholder"
                     style="object-fit:cover;width:100%;height:420px;border-radius:var(--radius)">
            @elseif($profil->foto_sejarah)
                <img src="{{ asset('storage/'.$profil->foto_sejarah) }}"
                     alt="Tentang {{ $profil->nama_sanggar }}"
                     class="about-placeholder"
                     style="object-fit:cover;width:100%;height:420px;border-radius:var(--radius)">
            @else
                <div class="img-placeholder about-placeholder">
                    <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="#C65D2E" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                </div>
            @endif
        </div>
        <div class="about-text">
            <span class="badge">Tentang Kami</span>
            <h2>{{ $profil->nama_sanggar }}</h2>
            @if($profil->tahun_berdiri)
                <p class="about-subtitle">BERDIRI SEJAK {{ $profil->tahun_berdiri }}</p>
            @endif
            <p class="about-desc">
                {{ Str::limit($profil->sejarah ?? 'Sanggar seni tari tradisional yang berdedikasi melestarikan kekayaan budaya Indonesia.', 280) }}
            </p>
            <a href="{{ route('profile') }}" class="btn-primary">Selengkapnya →</a>
        </div>
    </div>
</section>

{{-- DIGITAL ARCHIVE --}}
<section class="archive-section">
    <div class="container">
        <span class="badge">Digital Archive</span>
        <div class="archive-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
            <h2 style="font-family: var(--font-display); font-size: 1.75rem; font-weight: 700; color: var(--dark);">Arsip Digital</h2>
            <a href="{{ route('digital-archive') }}" class="btn-lihat-sm">Lihat Semua →</a>
        </div>

        <!-- Archive Carousel -->
        <div class="archive-carousel" style="position: relative; overflow: hidden; border-radius: var(--radius);">
            <div class="archive-track" style="display: flex; transition: transform 0.5s ease-in-out;">
                @php $archiveFotos = $galeri->where('seksi','digital_archive'); @endphp
                @if($archiveFotos->count())
                    @foreach($archiveFotos as $foto)
                    <div class="archive-slide" style="min-width: 200px; max-width: 200px; margin: 0 8px; flex-shrink: 0; aspect-ratio: 1/1;">
                        <a href="{{ route('digital-archive') }}" class="archive-card" style="display: block; width: 100%; height: 100%; border-radius: var(--radius-sm); overflow: hidden;">
                            <img src="{{ asset('storage/'.$foto->file) }}"
                                 alt="{{ $foto->judul ?? 'Arsip Digital' }}"
                                 style="width:100%;height:100%;object-fit:cover; transition: transform 0.3s;">
                        </a>
                    </div>
                    @endforeach
                @else
                    @for($i = 0; $i < 4; $i++)
                    <div class="archive-slide" style="min-width: 200px; max-width: 200px; margin: 0 8px; flex-shrink: 0; aspect-ratio: 1/1;">
                        <a href="{{ route('digital-archive') }}" class="archive-card" style="display: flex; width: 100%; height: 100%; border-radius: var(--radius-sm); overflow: hidden; align-items: center; justify-content: center; background: var(--primary-pale);">
                            <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#C65D2E" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                        </a>
                    </div>
                    @endfor
                @endif
            </div>

            <!-- Archive Navigation - Always show if more than 1 photo -->
            @if($archiveFotos->count() > 1)
            <button class="archive-nav-btn prev" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); background: var(--primary); color: white; border: none; border-radius: 50%; width: 44px; height: 44px; cursor: pointer; z-index: 10; display: flex; align-items: center; justify-content: center; transition: all 0.3s; box-shadow: var(--shadow-sm);">‹</button>
            <button class="archive-nav-btn next" style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); background: var(--primary); color: white; border: none; border-radius: 50%; width: 44px; height: 44px; cursor: pointer; z-index: 10; display: flex; align-items: center; justify-content: center; transition: all 0.3s; box-shadow: var(--shadow-sm);">›</button>
            @endif
        </div>

        <!-- Archive Indicators -->
        @if($archiveFotos->count() > 1)
        <div class="archive-indicators" style="display: flex; justify-content: center; gap: 8px; margin-top: 20px;">
        </div>
        @endif
    </div>
</section>

{{-- DOKUMENTASI --}}
<section class="dokumentasi">
    <div class="container">
        <div class="section-header" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px; margin-bottom: 30px;">
            <h2 class="section-title" style="margin-bottom: 0;">Dokumentasi Kegiatan</h2>
            <a href="{{ route('galeri.frontend.index', 'dokumentasi') }}" class="btn-lihat-sm" style="display: inline-flex; align-items: center; gap: 8px; background: var(--primary); color: white; padding: 10px 20px; border-radius: var(--radius-pill); text-decoration: none; font-weight: 500; transition: all 0.3s;">
                Lihat Lainnya
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"></polyline></svg>
            </a>
        </div>

        <!-- Dokumentasi Carousel -->
        <div class="dok-carousel" style="position: relative; overflow: hidden; border-radius: var(--radius);">
            <div class="dok-track" style="display: flex; transition: transform 0.5s ease-in-out;">
                @php
                    $dokFotos = isset($galeri)
                        ? $galeri->where('seksi', 'dokumentasi')->where('tipe', 'foto')->where('aktif', true)
                        : (isset($grouped['dokumentasi'])
                            ? $grouped['dokumentasi']->where('tipe', 'foto')->where('aktif', true)
                            : collect());
                @endphp

                @if($dokFotos->count())
                    @foreach($dokFotos as $foto)
                    <div class="dok-card carousel-slide" style="min-width: 200px; max-width: 200px; margin: 0 8px; flex-shrink: 0; aspect-ratio: 1/1;">
                        @if($foto->tipe === 'foto')
                            <img src="{{ asset('storage/' . $foto->file) }}"
                                 alt="{{ $foto->judul ?? 'Dokumentasi' }}"
                                 style="width:100%; height:100%; object-fit:cover; display:block; border-radius: var(--radius-sm);">
                        @else
                            <div style="width:100%; height:100%; display:flex; align-items:center; justify-content:center; background:var(--dark); color:white; border-radius: var(--radius-sm);">
                                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                    <polygon points="23 7 16 12 23 17 23 7"/>
                                    <rect x="1" y="5" width="15" height="14" rx="2"/>
                                </svg>
                                <span style="margin-left:8px;">Video</span>
                            </div>
                        @endif
                    </div>
                    @endforeach
                @else
                    @for($i = 0; $i < 4; $i++)
                    <div class="dok-card carousel-slide" style="min-width: 200px; max-width: 200px; margin: 0 8px; flex-shrink: 0; aspect-ratio: 1/1;">
                        <div class="img-placeholder dok-placeholder" style="background: var(--primary-pale); border-radius: var(--radius-sm); display: flex; align-items: center; justify-content: center;">
                            <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#C65D2E" stroke-width="1.5">
                                <rect x="3" y="3" width="18" height="18" rx="2"/>
                                <circle cx="8.5" cy="8.5" r="1.5"/>
                                <polyline points="21 15 16 10 5 21"/>
                            </svg>
                        </div>
                    </div>
                    @endfor
                @endif
            </div>

            <!-- Navigation Buttons - Always show if more than 1 photo -->
            @if($dokFotos->count() > 1)
            <button class="dok-nav-btn prev" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); background: var(--primary); color: white; border: none; border-radius: 50%; width: 44px; height: 44px; cursor: pointer; z-index: 10; display: flex; align-items: center; justify-content: center; transition: all 0.3s; box-shadow: var(--shadow-sm);">‹</button>
            <button class="dok-nav-btn next" style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); background: var(--primary); color: white; border: none; border-radius: 50%; width: 44px; height: 44px; cursor: pointer; z-index: 10; display: flex; align-items: center; justify-content: center; transition: all 0.3s; box-shadow: var(--shadow-sm);">›</button>
            @endif
        </div>

        <!-- Indicators -->
        @if($dokFotos->count() > 1)
        <div class="dok-indicators" style="display: flex; justify-content: center; gap: 8px; margin-top: 20px;">
        </div>
        @endif
    </div>
</section>

<script>
    // Continuous Carousel - slides 1 photo at a time through all photos
    function initCarousel(trackSelector, navPrevSelector, navNextSelector, indicatorContainerSelector, autoSlideInterval = 4000) {
        const track = document.querySelector(trackSelector);
        if (!track) return;

        const slides = Array.from(track.children);
        const nextButton = document.querySelector(navNextSelector);
        const prevButton = document.querySelector(navPrevSelector);
        const indicatorContainer = document.querySelector(indicatorContainerSelector);

        if (slides.length === 0) return;

        let currentIndex = 0;
        const totalSlides = slides.length;
        let autoTimer = null;

        // Create indicators
        function createIndicators() {
            if (!indicatorContainer) return;
            indicatorContainer.innerHTML = '';
            for (let i = 0; i < totalSlides; i++) {
                const dot = document.createElement('button');
                dot.style.cssText = `width: 8px; height: 8px; border-radius: 50%; border: none; background: ${i === 0 ? 'var(--primary)' : 'var(--border)'}; cursor: pointer; transition: all 0.3s; padding: 0;`;
                dot.addEventListener('click', () => moveToSlide(i));
                indicatorContainer.appendChild(dot);
            }
        }
        createIndicators();

        function updateIndicators() {
            if (!indicatorContainer) return;
            const dots = indicatorContainer.children;
            for (let i = 0; i < dots.length; i++) {
                dots[i].style.background = i === currentIndex ? 'var(--primary)' : 'var(--border)';
                dots[i].style.transform = i === currentIndex ? 'scale(1.3)' : 'scale(1)';
            }
        }

        function updateButtons() {
            if (prevButton) {
                prevButton.style.opacity = '1';
                prevButton.style.pointerEvents = 'auto';
            }
            if (nextButton) {
                nextButton.style.opacity = '1';
                nextButton.style.pointerEvents = 'auto';
            }
        }

        function moveToSlide(index) {
            currentIndex = index;
            const slideWidth = 200 + 16; // 200px width + 16px margin
            const amount = -currentIndex * slideWidth;
            track.style.transform = `translateX(${amount}px)`;
            updateButtons();
            updateIndicators();
        }

        function nextSlide() {
            if (currentIndex < totalSlides - 1) {
                moveToSlide(currentIndex + 1);
            } else {
                moveToSlide(0); // Loop back to start
            }
        }

        function prevSlide() {
            if (currentIndex > 0) {
                moveToSlide(currentIndex - 1);
            } else {
                moveToSlide(totalSlides - 1); // Go to last slide
            }
        }

        function startAutoSlide() {
            stopAutoSlide();
            autoTimer = setInterval(nextSlide, autoSlideInterval);
        }

        function stopAutoSlide() {
            if (autoTimer) {
                clearInterval(autoTimer);
                autoTimer = null;
            }
        }

        if (nextButton) {
            nextButton.addEventListener('click', () => {
                nextSlide();
                startAutoSlide();
            });
        }

        if (prevButton) {
            prevButton.addEventListener('click', () => {
                prevSlide();
                startAutoSlide();
            });
        }

        // Pause on hover
        const carouselEl = track.parentElement;
        carouselEl.addEventListener('mouseenter', stopAutoSlide);
        carouselEl.addEventListener('mouseleave', startAutoSlide);

        let resizeTimer;
        window.addEventListener('resize', function() {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(() => {
                moveToSlide(currentIndex);
            }, 150);
        });

        moveToSlide(0);
        startAutoSlide();
    }

    // Initialize both carousels
    document.addEventListener('DOMContentLoaded', function() {
        initCarousel('.archive-track', '.archive-nav-btn.prev', '.archive-nav-btn.next', '.archive-indicators', 4000);
        initCarousel('.dok-track', '.dok-nav-btn.prev', '.dok-nav-btn.next', '.dok-indicators', 4000);
    });
</script>


{{-- CTA --}}
<section class="cta">
    <div class="container cta-inner">
        <h2>Bergabung dengan Komunitas Kami</h2>
        <p>Jadilah bagian dari gerakan pelestarian budaya Indramayu. Daftarkan diri Anda sekarang dan mulai perjalanan seni Anda bersama kami.</p>
        <a href="{{ route('register') }}" class="btn-cta">Daftar Sekarang</a>
    </div>
</section>

@endsection