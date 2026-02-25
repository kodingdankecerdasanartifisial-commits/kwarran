@extends('layouts.public')

@section('title', $dkr->name . ' - Kwarran Bekasi Timur')

@section('content')
<!-- DKR Hero Section -->
<section class="dkr-hero mb-5 rounded-4 shadow-lg overflow-hidden position-relative">
    <div class="hero-overlay" style="background-image: linear-gradient(rgba(0,0,0,0.3), rgba(0,0,0,0.7)), url('{{ $dkr->hero_image ? asset('storage/' . $dkr->hero_image) : 'https://images.unsplash.com/photo-1523240795612-9a054b0db644?q=80&w=1920&auto=format&fit=crop' }}');"></div>
    <div class="container h-100 position-relative z-1 d-flex align-items-center">
        <div class="row w-100 py-5">
            <div class="col-lg-2 text-center text-lg-start mb-4 mb-lg-0">
                <img src="{{ $dkr->logo ? asset('storage/' . $dkr->logo) : asset('logo.png') }}" alt="Logo DKR" class="img-fluid bg-white rounded-circle p-2 shadow" style="max-height: 150px; width: 150px; object-fit: contain;">
            </div>
            <div class="col-lg-10 ps-lg-5 text-center text-lg-start">
                <h1 class="display-4 fw-bold text-white mb-2 text-uppercase">{{ $dkr->name }}</h1>
                <p class="lead text-white opacity-90 mb-3 fs-4 border-start border-4 border-warning ps-3">Dewan Kerja Pramuka Penegak dan Pandega Kwartir Ranting Bekasi Timur</p>
                <div class="text-white mb-4">
                    <div class="h4 fw-bold mb-1" style="letter-spacing: 1px;">⚜️𝐖𝐚𝐧𝐠𝐛𝐚𝐧𝐠 𝐖𝐢𝐫𝐚𝐭𝐚𝐫𝐚 𝐁𝐡𝐚𝐠𝐚𝐬𝐚𝐬𝐢⚜️</div>
                    <div class="h5 opacity-75">⚜️Masa Bakti 2026-2029⚜️</div>
                </div>
                <div class="d-flex flex-wrap gap-2 justify-content-center justify-content-lg-start">
                    @if(!empty($dkr->social_media['instagram']))
                        <a href="{{ $dkr->social_media['instagram'] }}" target="_blank" class="btn btn-danger btn-sm rounded-pill px-3 shadow-sm"><i class="fab fa-instagram me-1"></i> Instagram</a>
                    @endif
                    @if(!empty($dkr->social_media['facebook']))
                        <a href="{{ $dkr->social_media['facebook'] }}" target="_blank" class="btn btn-primary btn-sm rounded-pill px-3 shadow-sm"><i class="fab fa-facebook me-1"></i> Facebook</a>
                    @endif
                    @if(!empty($dkr->social_media['youtube']))
                        <a href="{{ $dkr->social_media['youtube'] }}" target="_blank" class="btn btn-danger btn-sm rounded-pill px-3 shadow-sm"><i class="fab fa-youtube me-1"></i> YouTube</a>
                    @endif
                    @if(!empty($dkr->social_media['tiktok']))
                        <a href="{{ $dkr->social_media['tiktok'] }}" target="_blank" class="btn btn-dark btn-sm rounded-pill px-3 shadow-sm"><i class="fab fa-tiktok me-1"></i> TikTok</a>
                    @endif
                    @if($dkr->whatsapp)
                        <a href="https://wa.me/{{ $dkr->whatsapp }}" target="_blank" class="btn btn-success btn-sm rounded-pill px-3 shadow-sm"><i class="fab fa-whatsapp me-1"></i> WhatsApp</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    .dkr-hero {
        height: 450px;
        background-color: #333;
    }
    .hero-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-size: cover;
        background-position: center;
        transition: transform 10s ease;
    }
    .dkr-hero:hover .hero-overlay {
        transform: scale(1.1);
    }
    .opacity-90 { opacity: 0.9; }
    .z-1 { z-index: 1; }
    
    @media (max-width: 991px) {
        .dkr-hero { height: auto; min-height: 400px; }
    }
</style>

<div class="container mb-5">
    <div class="row">
        <!-- Left Column: Details -->
        <div class="col-lg-8">
            <!-- Stats Row -->
            <div class="row g-3 mb-5">
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm text-center p-4 rounded-4 h-100 border-bottom border-4 border-warning">
                        <i class="fas fa-user-friends fa-2x text-warning mb-3"></i>
                        <h2 class="fw-bold mb-0">{{ number_format($dkr->active_members_count) }}</h2>
                        <p class="text-muted small text-uppercase fw-bold mb-0">Total Anggota</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm text-center p-4 rounded-4 h-100 border-bottom border-4 border-primary">
                        <i class="fas fa-male fa-2x text-primary mb-3"></i>
                        <h2 class="fw-bold mb-0">{{ number_format($dkr->male_members_count) }}</h2>
                        <p class="text-muted small text-uppercase fw-bold mb-0">Anggota Putra</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm text-center p-4 rounded-4 h-100 border-bottom border-4 border-danger">
                        <i class="fas fa-female fa-2x text-danger mb-3"></i>
                        <h2 class="fw-bold mb-0">{{ number_format($dkr->female_members_count) }}</h2>
                        <p class="text-muted small text-uppercase fw-bold mb-0">Anggota Putri</p>
                    </div>
                </div>
            </div>

            <!-- Vision & Mission -->
            <div class="row mb-5">
                <div class="col-md-6 mb-4">
                    <h3 class="fw-bold mb-4 border-start border-4 border-primary ps-3">VISI</h3>
                    <div class="card border-0 shadow-sm rounded-4 p-4 bg-white h-100">
                        <p class="lead mb-0 fst-italic text-dark">{{ $dkr->vision ?? 'Belum diisi.' }}</p>
                    </div>
                </div>
                <div class="col-md-6 mb-4">
                    <h3 class="fw-bold mb-4 border-start border-4 border-primary ps-3">MISI</h3>
                    <div class="card border-0 shadow-sm rounded-4 p-4 bg-white h-100">
                        <div class="text-muted">{!! nl2br(e($dkr->mission)) ?: 'Belum diisi.' !!}</div>
                    </div>
                </div>
            </div>

            <!-- Achievements -->
            @if($dkr->achievements && count($dkr->achievements) > 0)
            <div class="achievements-section mb-5">
                <h3 class="fw-bold mb-4 border-start border-4 border-success ps-3">PRESTASI & PENCAPAIAN</h3>
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                    <div class="list-group list-group-flush">
                        @foreach($dkr->achievements as $achievement)
                        <div class="list-group-item d-flex align-items-center py-3">
                            <i class="fas fa-trophy text-warning me-3 fa-lg"></i>
                            <span class="fw-medium">{{ $achievement }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

            <!-- Video Gallery -->
            @if($dkr->videos && count($dkr->videos) > 0)
            <div class="video-gallery-section mt-5 pt-4">
                <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom border-danger">
                    <h3 class="fw-bold text-uppercase m-0" style="letter-spacing: 1px;">
                        <span class="ps-1">VIDEO KEGIATAN</span>
                    </h3>
                </div>
                <div class="row g-3">
                    @foreach($dkr->videos as $videoUrl)
                        @php
                            preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $videoUrl, $matches);
                            $videoId = $matches[1] ?? null;
                        @endphp
                        @if($videoId)
                        <div class="col-md-6">
                            <div class="card border-0 shadow-sm rounded-4 overflow-hidden h-100">
                                <div class="ratio ratio-16x9">
                                    <iframe src="https://www.youtube.com/embed/{{ $videoId }}" title="YouTube video" allowfullscreen></iframe>
                                </div>
                            </div>
                        </div>
                        @endif
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Photo Album Gallery -->
            @if($albums && count($albums) > 0)
            <div class="photo-gallery-section mt-5 pt-4">
                <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom border-primary">
                    <h3 class="fw-bold text-uppercase m-0" style="letter-spacing: 1px;">
                        <span class="ps-1">ALBUM GALERI</span>
                    </h3>
                </div>
                <div class="row g-3">
                    @foreach($albums as $album)
                        <div class="col-md-6 col-lg-4">
                            <a href="{{ route('dkr.album.show', $album->slug) }}" class="text-decoration-none">
                                <div class="card border-0 shadow-sm rounded-4 overflow-hidden post-card-hover h-100">
                                    <div class="position-relative">
                                        @if($album->cover_image)
                                            <img src="{{ asset('storage/' . $album->cover_image) }}" class="card-img-top" style="height: 180px; width: 100%; object-fit: cover;" alt="{{ $album->name }}">
                                        @else
                                            <div class="bg-light d-flex align-items-center justify-content-center" style="height: 180px;">
                                                <i class="fas fa-images fa-3x text-secondary opacity-25"></i>
                                            </div>
                                        @endif
                                        <div class="position-absolute bottom-0 end-0 m-2">
                                            <span class="badge bg-dark bg-opacity-75 rounded-pill"><i class="fas fa-camera me-1"></i> {{ $album->photos->count() }}</span>
                                        </div>
                                    </div>
                                    <div class="card-body p-3">
                                        <h6 class="fw-bold mb-1 text-dark">{{ Str::limit($album->name, 40) }}</h6>
                                        <small class="text-muted">{{ $album->created_at->format('d M Y') }}</small>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- DKR News (Like Home Page) -->
            <div class="dkr-news-section mt-5 pt-4">
                <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom border-warning">
                    <h3 class="fw-bold text-uppercase m-0" style="letter-spacing: 1px;">
                        <span class="ps-1">KEGIATAN & BERITA DKR</span>
                    </h3>
                </div>
                
                <div class="row">
                    @forelse($posts as $post)
                    <div class="col-md-6 mb-4">
                        <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden position-relative post-card-hover">
                            @if($post->featured_image)
                                <img src="{{ asset('storage/' . $post->featured_image) }}" class="card-img-top" style="height: 200px; object-fit: cover;" alt="{{ $post->title }}">
                            @else
                                <div class="bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                                    <i class="fas fa-image fa-3x text-secondary opacity-25"></i>
                                </div>
                            @endif
                            <div class="card-body p-4">
                                <div class="text-muted small mb-2">
                                    <i class="far fa-calendar-alt me-1"></i> {{ $post->published_at?->format('d M Y') }}
                                </div>
                                <h5 class="fw-bold mb-3">
                                    <a href="{{ route('posts.show', $post->slug) }}" class="text-decoration-none text-dark hover-primary">{{ Str::limit($post->title, 60) }}</a>
                                </h5>
                                <p class="text-muted small mb-0">{{ Str::limit(strip_tags($post->content), 100) }}</p>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-12 text-center py-5">
                        <div class="text-muted mb-3"><i class="fas fa-newspaper fa-4x opacity-25"></i></div>
                        <p class="text-muted">Belum ada berita terbaru dari DKR.</p>
                    </div>
                    @endforelse
                </div>
                @if($posts->count() > 0)
                <div class="text-center mt-3">
                    <a href="{{ route('categories.show', 'dkr') }}" class="btn btn-outline-warning rounded-pill px-4 fw-bold">LIHAT SEMUA BERITA DKR</a>
                </div>
                @endif
            </div>
        </div>

        <!-- Right Side: Sidebar specialized -->
        <div class="col-lg-4">
            <!-- Sidebar: Structure -->
            @if($dkr->structure)
            <div class="sidebar-block mb-5">
                <h4 class="fw-bold mb-4 border-start border-4 border-warning ps-3">PENGURUS DKR</h4>
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                    <div class="list-group list-group-flush">
                        @foreach($dkr->structure as $person)
                        <div class="list-group-item border-0 p-3 hover-light transition">
                            <div class="d-flex align-items-center">
                                @if(!empty($person['photo']))
                                    <img src="{{ asset('storage/' . $person['photo']) }}" class="rounded shadow-sm me-3" style="width: 50px; height: 65px; object-fit: cover;">
                                @else
                                    <div class="bg-light rounded d-flex align-items-center justify-content-center border me-3" style="width: 50px; height: 65px;"><i class="fas fa-user text-muted opacity-50"></i></div>
                                @endif
                                <div>
                                    <h6 class="fw-bold mb-0 text-dark" style="font-size: 0.95rem;">{{ $person['name'] }}</h6>
                                    <small class="text-muted">{{ $person['position'] }}</small>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

            <!-- Contact Card -->
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden bg-primary text-white p-4">
                <h4 class="fw-bold mb-4">Sekretariat</h4>
                <div class="mb-3 d-flex align-items-start">
                    <i class="fas fa-map-marker-alt me-3 mt-1"></i>
                    <p class="small mb-0 opacity-90">{{ $dkr->address ?: 'Bekasi Timur, Kota Bekasi' }}</p>
                </div>
                <div class="mb-3 d-flex align-items-center">
                    <i class="fas fa-envelope me-3"></i>
                    <p class="small mb-0 opacity-90">{{ $dkr->email ?: '-' }}</p>
                </div>
                @if($dkr->whatsapp)
                <a href="https://wa.me/{{ $dkr->whatsapp }}" target="_blank" class="btn btn-warning w-100 fw-bold mt-2">HUBUNGI KAMI</a>
                @endif
            </div>

            <!-- Agenda Kerja Calendar -->
            <div class="agenda-sidebar mt-4">
                <h5 class="fw-bold mb-3 border-start border-4 border-warning ps-3">AGENDA KERJA</h5>
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                    <div class="list-group list-group-flush">
                        @forelse($agendas as $agenda)
                        <div class="list-group-item p-3 border-0 border-bottom">
                            <div class="d-flex">
                                <div class="calendar-icon text-center me-3 bg-light rounded px-2 py-1 border" style="min-width: 50px;">
                                    <div class="small fw-bold text-uppercase text-danger" style="font-size: 0.65rem;">{{ $agenda->date->format('M') }}</div>
                                    <div class="h5 fw-bold mb-0">{{ $agenda->date->format('d') }}</div>
                                </div>
                                <div class="overflow-hidden">
                                    <h6 class="fw-bold mb-1 text-truncate" title="{{ $agenda->title }}">{{ $agenda->title }}</h6>
                                    @if($agenda->time || $agenda->location)
                                    <div class="small text-muted text-truncate">
                                        <i class="far fa-clock me-1"></i> {{ $agenda->time ?? 'Sesuai agenda' }}
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="list-group-item p-4 text-center text-muted"> Belum ada agenda terdekat. </div>
                        @endforelse
                    </div>
                </div>
            </div>

            @if($dkr->custom_html)
            <div class="custom-html-block mt-4 overflow-hidden rounded-4 shadow-sm bg-white border">
                <div class="custom-content-wrapper">
                    {!! $dkr->custom_html !!}
                </div>
            </div>
            <style>
                .custom-content-wrapper {
                    width: 100%;
                }
                .custom-content-wrapper img {
                    display: block;
                    max-width: 100% !important;
                    height: auto !important;
                    border-radius: 8px;
                    margin: 0 auto;
                }
                .custom-content-wrapper iframe {
                    width: 100% !important;
                    border: 0;
                    display: block;
                }
                /* Padding otomatis jika isinya adalah text (p, h1-h6) */
                .custom-content-wrapper > p, 
                .custom-content-wrapper > h1, 
                .custom-content-wrapper > h2, 
                .custom-content-wrapper > h3,
                .custom-content-wrapper > h4,
                .custom-content-wrapper > h5,
                .custom-content-wrapper > h6,
                .custom-content-wrapper > ul,
                .custom-content-wrapper > ol {
                    padding-left: 1.25rem;
                    padding-right: 1.25rem;
                    margin-top: 1rem;
                }
                .custom-content-wrapper > *:first-child { margin-top: 1.25rem; }
                .custom-content-wrapper > *:last-child { margin-bottom: 1.25rem; }
                
                /* Jika isinya hanya satu gambar tanpa elemen lain, hilangkan padding agar pas ke pinggir */
                .custom-content-wrapper > img:only-child {
                    border-radius: 0;
                    margin: 0;
                }
            </style>
            @endif
            
            <div class="mt-5 text-center d-none d-lg-block">
                <img src="{{ asset('logo.png') }}" class="opacity-25" style="max-height: 100px;">
            </div>
        </div>
    </div>
</div>

<style>
    .post-card-hover { transition: all 0.3s ease; }
    .post-card-hover:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important; }
    .list-group-item.transition { transition: background 0.2s; }
    .hover-light:hover { background-color: #f8f9fa !important; }
</style>
@endsection
