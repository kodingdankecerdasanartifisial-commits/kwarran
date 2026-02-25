@extends('layouts.public')

@section('title', 'Beranda - Kwarran Bekasi Timur')

@section('content')
<!-- Hero Slideshow -->
<section class="hero-slider-section pt-1">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="swiper main-slider shadow-sm overflow-hidden">
                    <div class="swiper-wrapper">
                        @forelse($sliders as $slider)
                        <div class="swiper-slide">
                            <div class="slider-bg" style="background-image: linear-gradient(rgba(0,0,0,0.2), rgba(0,0,0,0.5)), url('{{ asset('storage/' . $slider->image) }}');"></div>
                            <div class="container h-100">
                                <div class="row h-100 align-items-center">
                                    <div class="col-lg-8 ps-md-5 text-start animate__animated animate__fadeInUp">
                                        @if($slider->title)
                                            <h2 class="display-5 fw-bold text-white mb-2">{{ $slider->title }}</h2>
                                        @endif
                                        @if($slider->subtitle)
                                            <p class="lead text-white mb-4 fs-5 d-none d-md-block">{{ $slider->subtitle }}</p>
                                        @endif
                                        @if($slider->link)
                                            <a href="{{ $slider->link }}" class="btn btn-warning fw-bold shadow-sm">
                                                SELENGKAPNYA <i class="fas fa-arrow-right ms-2"></i>
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="swiper-slide">
                            <div class="slider-bg" style="background-image: linear-gradient(rgba(0,0,0,0.2), rgba(0,0,0,0.5)), url('https://images.unsplash.com/photo-1523240795612-9a054b0db644?q=80&w=1920&auto=format&fit=crop');"></div>
                            <div class="container h-100 text-center">
                                <div class="row h-100 align-items-center justify-content-center">
                                    <div class="col-lg-10">
                                        <h2 class="display-5 fw-bold text-white mb-2">Kwarran Bekasi Timur</h2>
                                        <p class="lead text-white mb-4 fs-5 d-none d-md-block">Membangun Karakter Bangsa melalui Gerakan Pramuka yang Inovatif.</p>
                                        <div class="d-flex gap-3 justify-content-center">
                                            <a href="{{ route('posts.index') }}" class="btn btn-warning fw-bold">Warta Pramuka</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforelse
                    </div>
                    <!-- Add Pagination -->
                    <div class="swiper-pagination"></div>
                    <!-- Add Navigation -->
                    <div class="swiper-button-next d-none d-md-flex"></div>
                    <div class="swiper-button-prev d-none d-md-flex"></div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    .hero-slider-section {
        background-color: #f8f9fa;
    }
    .main-slider {
        height: 550px; /* Adjusted height */
        width: 100%;
        position: relative;
        border-radius: 5px; /* Adjusted curvature */
    }
    .slider-bg {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-size: cover;
        background-position: center;
        z-index: -1;
        transition: transform 8s ease;
    }
    .swiper-slide-active .slider-bg {
        transform: scale(1.15);
    }
    .swiper-button-next, .swiper-button-prev {
        color: white;
        background: rgba(0,0,0,0.2);
        width: 40px;
        height: 40px;
        border-radius: 50%;
    }
    .swiper-button-next:after, .swiper-button-prev:after {
        font-size: 16px;
    }
    .swiper-pagination-bullet {
        background: white;
        opacity: 0.6;
    }
    .swiper-pagination-bullet-active {
        opacity: 1;
        background: var(--secondary-color);
    }
    
    @media (max-width: 768px) {
        .main-slider { height: 280px; border-radius: 5px; }
        .display-5 { font-size: 1.8rem; }
    }
</style>

<!-- Newsflash Section -->
<div class="newsflash-section py-1 bg-white text-dark mb-4 shadow-sm">
    <div class="container">
        <div class="row align-items-center g-0">
            <div class="col-auto">
                <div class="newsflash-label px-3 py-2 fw-bold text-uppercase small me-3 position-relative" style="background-color: var(--accent-color, #f39c12); color: #f7f0f0;">
                    <i class="fas fa-bullhorn me-2"></i> INFO TERBARU
                </div>
            </div>
            <div class="col overflow-hidden">
                <div class="newsflash-wrapper">
                    <marquee direction="down" height="25" onmouseover="this.stop();" onmouseout="this.start();" scrollamount="2" style="line-height: 25px;">
                        @foreach($latestPosts as $post)
                            <a href="{{ route('posts.show', $post->slug) }}" class="text-decoration-none text-dark d-block small fw-medium hover-opacity">
                                <span class="badge bg-secondary me-2" style="font-size: 0.7rem;">{{ $post->published_at?->format('d/m') }}</span> {{ $post->title }}
                            </a>
                        @endforeach
                    </marquee>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .newsflash-section {
        position: relative;
        z-index: 10;
        margin-top: 0;
    }
    .hover-opacity:hover {
        opacity: 0.8;
    }
    .newsflash-label {
        clip-path: polygon(0 0, 100% 0, 95% 100%, 0% 100%);
        padding-right: 1.5rem !important;
    }

    /* Digital Banner Styling */
    .digital-banner-section .banner-wrapper {
        width: 100%;
        overflow: hidden;
    }
    .digital-banner-section .banner-img {
        width: 100%;
        height: auto;
        display: block;
    }
</style>

<!-- Digital Banner Section -->
@if($digitalBanners->count() > 0)
<section class="digital-banner-section mb-4">
    <div class="container">
        <div class="row">
            <div class="col-12">
                @foreach($digitalBanners as $banner)
                <div class="banner-wrapper shadow-sm mb-3">
                    @if($banner->link)
                        <a href="{{ $banner->link }}" target="_blank">
                            <img src="{{ asset('storage/' . $banner->image) }}" alt="{{ $banner->title }}" class="banner-img">
                        </a>
                    @else
                        <img src="{{ asset('storage/' . $banner->image) }}" alt="{{ $banner->title }}" class="banner-img">
                    @endif
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
@endif

<div class="container my-5">
    <div class="row">
        <!-- Main Content Column (left) -->
        <div class="col-lg-8">
            <!-- Top Section: Featured & Stacked News -->
            <div class="row">
                <!-- Kolom 1: Cuplikan Berita Utama (Featured) -->
                <div class="col-lg-7 mb-4">
                    <h4 class="fw-bold mb-3 border-start border-4 border-warning ps-3">UTAMA</h4>
                    @if($mainPost)
                    <div class="card border-0 shadow-sm rounded-4 overflow-hidden h-100">
                        <div class="position-relative">
                            @php
                                $mainThumbnail = null;
                                if ($mainPost->featured_image) {
                                    $mainThumbnail = asset('storage/' . $mainPost->featured_image);
                                } elseif ($mainPost->youtube_url) {
                                    preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $mainPost->youtube_url, $matches);
                                    if (isset($matches[1])) {
                                        $mainThumbnail = "https://img.youtube.com/vi/{$matches[1]}/mqdefault.jpg";
                                    }
                                }
                            @endphp

                            @if($mainThumbnail)
                                <img src="{{ $mainThumbnail }}" class="card-img-top" style="height: 350px; object-fit: cover;" alt="{{ $mainPost->title }}">
                                @if(!$mainPost->featured_image && $mainPost->youtube_url)
                                <div class="position-absolute top-50 start-50 translate-middle">
                                    <i class="fab fa-youtube fa-4x text-danger bg-white rounded-circle p-1"></i>
                                </div>
                                @endif
                            @else
                                <div class="bg-light d-flex align-items-center justify-content-center" style="height: 350px;">
                                    <i class="fas fa-image fa-3x text-secondary opacity-25"></i>
                                </div>
                            @endif
                            @if($mainPost->category)
                            <div class="position-absolute top-0 start-0 m-3">
                                <span class="badge bg-warning text-dark px-3 py-2 fw-bold shadow-sm">{{ $mainPost->category->name }}</span>
                            </div>
                            @endif
                        </div>
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center text-muted small mb-2">
                                <i class="far fa-calendar-alt me-2"></i> {{ $mainPost->published_at?->format('d M Y') }}
                                <span class="mx-2">|</span>
                                <i class="far fa-user me-2"></i> {{ $mainPost->author }}
                            </div>
                            <h3 class="card-title fw-bold mb-3">
                                <a href="{{ route('posts.show', $mainPost->slug) }}" class="text-decoration-none text-dark hover-primary">{{ $mainPost->title }}</a>
                            </h3>
                            <p class="card-text text-muted mb-4">{{ $mainPost->excerpt ?? Str::limit(strip_tags($mainPost->content), 150) }}</p>
                            <a href="{{ route('posts.show', $mainPost->slug) }}" class="btn btn-outline-warning fw-bold px-4 rounded-pill">BACA SELENGKAPNYA</a>
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Kolom 2: Berita Bertumpuk (Recent List) -->
                <div class="col-lg-5 mb-4">
                    <h4 class="fw-bold mb-3 border-start border-4 border-warning ps-3">BERITA TERBARU</h4>
                    <div class="stacked-news">
                        @forelse($stackedPosts as $post)
                        <div class="card border-0 shadow-sm rounded-4 mb-3 overflow-hidden">
                            <div class="row g-0">
                                <div class="col-4">
                                    @php
                                        $stackedThumbnail = null;
                                        if ($post->featured_image) {
                                            $stackedThumbnail = asset('storage/' . $post->featured_image);
                                        } elseif ($post->youtube_url) {
                                            preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $post->youtube_url, $matches);
                                            if (isset($matches[1])) {
                                                $stackedThumbnail = "https://img.youtube.com/vi/{$matches[1]}/mqdefault.jpg";
                                            }
                                        }
                                    @endphp

                                    @if($stackedThumbnail)
                                        <div class="position-relative h-100">
                                            <img src="{{ $stackedThumbnail }}" class="img-fluid h-100 w-100" style="object-fit: cover; min-height: 100px;" alt="{{ $post->title }}">
                                            @if(!$post->featured_image && $post->youtube_url)
                                            <div class="position-absolute top-50 start-50 translate-middle">
                                                <i class="fab fa-youtube fa-2x text-danger bg-white rounded-circle p-1"></i>
                                            </div>
                                            @endif
                                        </div>
                                    @else
                                        <div class="bg-light d-flex align-items-center justify-content-center h-100" style="min-height: 100px;">
                                            <i class="fas fa-image text-secondary opacity-25"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="col-8">
                                    <div class="card-body p-3">
                                        <small class="text-muted d-block mb-1">{{ $post->published_at?->format('d M Y') }}</small>
                                        <h6 class="card-title fw-bold mb-0">
                                            <a href="{{ route('posts.show', $post->slug) }}" class="text-decoration-none text-dark hover-primary small" style="line-height: 1.4;">{{ Str::limit($post->title, 60) }}</a>
                                        </h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <p class="text-muted">Belum ada berita terbaru lainnya.</p>
                        @endforelse
                        <div class="text-center mt-4">
                            <a href="{{ route('posts.index') }}" class="btn btn-warning w-100 fw-bold rounded-pill shadow-sm">LIHAT SEMUA BERITA</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Berita Per Kategori (Now inside Left Column) -->
            @if($categorySections->count() > 0)
            <div class="category-news-sections mt-4 border-top pt-4">
                @foreach($categorySections as $section)
                <div class="category-block mb-5">
                    <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom border-warning border-opacity-25">
                        <h3 class="fw-bold text-uppercase m-0" style="letter-spacing: 1px; font-size: 1.25rem;">
                            <span class="border-start border-4 border-warning ps-3">{{ $section->name }}</span>
                        </h3>
                        <a href="{{ route('categories.show', $section->slug) }}" class="btn btn-sm btn-link text-warning text-decoration-none fw-bold">SELENGKAPNYA <i class="fas fa-arrow-right ms-1"></i></a>
                    </div>
                    
                    <div class="row">
                        @foreach($section->posts as $post)
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden post-card-hover">
                                <div class="position-relative">
                                    @php
                                        $catThumbnail = null;
                                        if ($post->featured_image) {
                                            $catThumbnail = asset('storage/' . $post->featured_image);
                                        } elseif ($post->youtube_url) {
                                            preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $post->youtube_url, $matches);
                                            if (isset($matches[1])) {
                                                $catThumbnail = "https://img.youtube.com/vi/{$matches[1]}/mqdefault.jpg";
                                            }
                                        }
                                    @endphp

                                    @if($catThumbnail)
                                        <img src="{{ $catThumbnail }}" class="card-img-top" style="height: 160px; object-fit: cover;" alt="{{ $post->title }}">
                                        @if(!$post->featured_image && $post->youtube_url)
                                        <div class="position-absolute top-50 start-50 translate-middle">
                                            <i class="fab fa-youtube fa-2x text-danger bg-white rounded-circle p-1"></i>
                                        </div>
                                        @endif
                                    @else
                                        <div class="bg-light d-flex align-items-center justify-content-center" style="height: 160px;">
                                            <i class="fas fa-image fa-2x text-secondary opacity-25"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="card-body p-3">
                                    <small class="text-muted d-block mb-2"><i class="far fa-calendar-alt me-1"></i> {{ $post->published_at?->format('d M Y') }}</small>
                                    <h6 class="fw-bold mb-0" style="font-size: 0.95rem; line-height: 1.4;">
                                        <a href="{{ route('posts.show', $post->slug) }}" class="text-decoration-none text-dark hover-primary">{{ Str::limit($post->title, 55) }}</a>
                                    </h6>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endforeach
            </div>
            @endif
        </div>

        <!-- Right Sidebar -->
        <div class="col-lg-4 d-none d-lg-block">
            @include('layouts.sidebar')
        </div>
    </div>
@endsection
