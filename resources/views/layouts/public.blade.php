<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name', 'Kwarran Bekasi Timur'))</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('logo.png') }}">
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    
    <style>

        :root {
            --primary-color: #4B2C20; /* Pramuka Brown */
            --secondary-color: #F2C94C; /* Pramuka Gold */
            --accent-color: #D32F2F; /* Red for accents */
            --light-bg: #f8f9fa;
            --dark-text: #333333;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--light-bg);
            color: var(--dark-text);
        }

        /* Top Bar */
        .top-bar {
            background-color: var(--primary-color);
            color: white;
            padding: 5px 0;
            font-size: 0.85rem;
        }
        .top-bar a {
            color: white;
            text-decoration: none;
            margin-left: 15px;
        }

        /* Header */
        .header {
            background-color: white;
            padding: 20px 0;
            border-bottom: 3px solid var(--secondary-color);
        }
        .logo-text h1 {
            font-size: 1.8rem;
            font-weight: 700;
            margin: 0;
            color: var(--primary-color);
        }
        .logo-text p {
            margin: 0;
            font-size: 1rem;
            color: #666;
        }

        /* Navbar */
        .navbar {
            background-color: var(--primary-color) !important;
            padding: 0;
        }
        .navbar-nav .nav-link {
            color: white !important;
            padding: 15px 12px !important;
            font-weight: 500;
            text-transform: uppercase;
            font-size: 0.82rem;
        }
        .navbar-nav .nav-link:hover {
            background-color: var(--secondary-color);
            color: var(--primary-color) !important;
        }

        /* Hero Section */
        .hero {
            background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('https://images.unsplash.com/photo-1526772662000-3f88f10405ff?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80');
            background-size: cover;
            background-position: center;
            color: white;
            padding: 100px 0;
            text-align: center;
            margin-bottom: 50px;
        }
        .hero h1 {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 20px;
        }

        /* Posts */
        .post-card {
            border: none;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            transition: transform 0.3s;
            border-radius: 10px;
            overflow: hidden;
        }
        .post-card:hover {
            transform: translateY(-5px);
        }
        .post-category {
            background-color: var(--secondary-color);
            color: var(--primary-color);
            padding: 3px 10px;
            border-radius: 5px;
            font-size: 0.75rem;
            font-weight: 600;
            text-decoration: none;
            display: inline-block;
            margin-bottom: 10px;
        }
        .featured-image {
            height: 200px;
            object-fit: cover;
            width: 100%;
        }

        /* Footer */
        .footer {
            background-color: var(--primary-color);
            color: white;
            padding: 60px 0 20px;
            margin-top: 80px;
        }
        .footer h5 {
            color: var(--secondary-color);
            margin-bottom: 25px;
            font-weight: 600;
        }
        .footer-links ul {
            list-style: none;
            padding: 0;
        }
        .footer-links ul li {
            margin-bottom: 10px;
        }
        .footer-links ul li a {
            color: #ddd;
            text-decoration: none;
            transition: color 0.3s;
        }
        .footer-links ul li a:hover {
            color: var(--secondary-color);
        }
        .footer-bottom {
            text-align: center;
        }
        /* Sidebar */
        .sidebar-widget {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
            margin-bottom: 30px;
            border-left: 4px solid var(--secondary-color);
        }
        .sidebar-widget h5 {
            color: var(--primary-color);
            font-weight: 700;
            margin-bottom: 20px;
            text-transform: uppercase;
            font-size: 1rem;
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
        }
        .category-list a {
            display: block;
            padding: 8px 0;
            color: #555;
            text-decoration: none;
            transition: color 0.3s;
            border-bottom: 1px solid #f9f9f9;
        }
        .category-list a:hover {
            color: var(--primary-color);
            padding-left: 5px;
        }
        .category-list a i {
            margin-right: 8px;
            color: var(--secondary-color);
        }
        /* Sidebar behavior for two-column layout */
        .layout-sidebar { padding-left: 0; }
        @media (min-width: 992px) {
            .layout-main { width: 100%; }
        }
        /* Auto-resize images in sidebar widgets */
        .widget-content-html img {
            width: 100%;
            height: auto;
            display: block; /* Ensure no extra space below images */
        }

        /* Mega Menu Styles */
        .mega-dropdown {
            position: static !important;
        }
        .mega-menu {
            left: 0;
            right: 0;
            width: 100%;
            padding: 30px;
            border-radius: 0;
            margin-top: 0;
            border-top: 5px solid var(--secondary-color);
            background: #fff;
            box-shadow: 0 15px 30px rgba(0,0,0,0.1);
        }
        .mega-menu h6 {
            font-size: 0.9rem;
            letter-spacing: 1px;
            padding-bottom: 10px;
            border-bottom: 2px solid #eee;
        }
        .mega-menu a {
            font-size: 0.95rem;
            transition: color 0.2s;
        }
        .mega-menu a:hover {
            color: var(--primary-color) !important;
            padding-left: 5px;
        }

        /* Perbaikan untuk Mobile */
        @media (max-width: 991.98px) {
            .navbar-collapse {
                background-color: var(--primary-color);
                padding: 15px;
                border-bottom: 3px solid var(--secondary-color);
            }
            
            .footer {
                padding: 40px 20px;
                margin-top: 40px;
            }

            .footer-bottom {
                padding-bottom: 100px !important; /* Ruang ekstra signifikan agar terlihat di mobile browser */
            }

            .footer-bottom p, .footer-bottom a {
                color: #ffffff !important; /* Warna putih solid agar terbaca jelas */
            }
        }
    </style>
    @stack('styles')
    @yield('styles')
</head>
<body>
    <!-- Top Bar -->
    <div class="top-bar d-none d-lg-block">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <i class="far fa-calendar-alt me-2"></i> {{ now()->translatedFormat('l, d F Y') }}
                </div>
                <div class="col-md-6 text-end">
                    @if($fb = \App\Models\Setting::get('social_facebook')) <a href="{{ $fb }}" target="_blank"><i class="fab fa-facebook-f"></i></a> @endif
                    @if($ig = \App\Models\Setting::get('social_instagram')) <a href="{{ $ig }}" target="_blank"><i class="fab fa-instagram"></i></a> @endif
                    @if($yt = \App\Models\Setting::get('social_youtube')) <a href="{{ $yt }}" target="_blank"><i class="fab fa-youtube"></i></a> @endif
                    @if($x = \App\Models\Setting::get('social_x')) <a href="{{ $x }}" target="_blank"><i class="fa-brands fa-x-twitter"></i></a> @endif
                    @if($tt = \App\Models\Setting::get('social_tiktok')) <a href="{{ $tt }}" target="_blank"><i class="fab fa-tiktok"></i></a> @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Header -->
    <header class="header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-8 d-flex align-items-center">
                    <img src="{{ asset('logo.png') }}" alt="Logo" height="70" class="me-3">
                    <div class="logo-text">
                        <h1>KWARTIR RANTING BEKASI TIMUR</h1>
                        <p>Gerakan Pramuka Kota Bekasi</p>
                    </div>
                </div>
                <div class="col-md-4 text-end d-none d-md-block">
                    <!-- Search Bar or something -->
                </div>
            </div>
        </div>
    </header>

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark sticky-top">
        <div class="container">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav w-100 justify-content-between">
                    {{-- Search for Mobile --}}
                    <li class="nav-item d-lg-none py-3 border-bottom border-white border-opacity-25">
                        <form action="{{ route('posts.index') }}" method="GET" class="d-flex px-2">
                            <input class="form-control form-control-sm rounded-start-pill border-0" type="search" name="search" placeholder="Cari Berita..." aria-label="Search">
                            <button class="btn btn-warning btn-sm rounded-end-pill px-3" type="submit"><i class="fas fa-search"></i></button>
                        </form>
                    </li>
                    
                    @forelse($publicMenus as $menu)
                        @php
                            $isBerita = (str_contains(strtolower($menu->name), 'berita') || str_contains($menu->url, 'berita')) && !str_contains($menu->url, 'kirim-berita');
                            $isMateri = str_contains(strtolower($menu->name), 'materi');
                        @endphp
                        
                        @if($isMateri)
                            {{-- Skip separate Materi menu if it exists in DB, because we will inject it next to Berita or handle it specifically --}}
                            {{-- Actually, if it exists, let's just render it using our special Materi Mega Menu structure --}}
                             <li class="nav-item dropdown mega-dropdown">
                                <a class="nav-link dropdown-toggle {{ request()->is('materi*') ? 'active' : '' }}" href="#" id="navbarDropdownMateriDB" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    {{ $menu->name }}
                                </a>
                                <div class="dropdown-menu mega-menu" aria-labelledby="navbarDropdownMateriDB">
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <h6 class="text-uppercase fw-bold text-primary mb-3">Materi Belajar</h6>
                                                <ul class="list-unstyled">
                                                    @foreach(\App\Models\Category::where('type', 'materi')->get() as $cat)
                                                    <li class="mb-2"><a href="{{ route('categories.show', $cat->slug) }}" class="text-decoration-none text-dark hover-primary">{{ $cat->name }}</a></li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                            <div class="col-md-8">
                                                <h6 class="text-uppercase fw-bold text-primary mb-3">Materi Terbaru</h6>
                                                <div class="row">
                                                    @foreach(\App\Models\Post::whereHas('categories', function($q){ $q->where('type', 'materi'); })->latest()->take(2)->get() as $latest)
                                                    <div class="col-6">
                                                        <div class="card border-0 shadow-sm h-100">
                                                            @if($latest->thumbnail_url)
                                                                <img src="{{ $latest->thumbnail_url }}" class="card-img-top" alt="{{ $latest->title }}" style="height: 120px; object-fit: cover;">
                                                                @if(!$latest->featured_image && $latest->youtube_url)
                                                                <div class="position-absolute top-50 start-50 translate-middle"><i class="fab fa-youtube text-danger fa-2x bg-white rounded-circle p-1"></i></div>
                                                                @endif
                                                            @else
                                                                <div class="bg-light d-flex align-items-center justify-content-center" style="height: 120px;">
                                                                    <i class="fas fa-image text-muted"></i>
                                                                </div>
                                                            @endif
                                                            <div class="card-body p-2">
                                                                <h6 class="card-title small fw-bold mb-0">
                                                                    <a href="{{ route('posts.show', $latest->slug) }}" class="text-decoration-none text-dark stretched-link">{{ Str::limit($latest->title, 50) }}</a>
                                                                </h6>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>

                        @elseif($isBerita)
                            {{-- Berita Mega Menu (News Only) --}}
                            <li class="nav-item dropdown mega-dropdown">
                                <a class="nav-link dropdown-toggle {{ request()->is('berita*') || request()->is('posts*') ? 'active' : '' }}" href="{{ url($menu->url) }}" id="navbarDropdown{{ $menu->id }}" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    {{ $menu->name }}
                                </a>
                                <div class="dropdown-menu mega-menu" aria-labelledby="navbarDropdown{{ $menu->id }}">
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <h6 class="text-uppercase fw-bold text-primary mb-3">Kategori Berita</h6>
                                                <ul class="list-unstyled">
                                                    @foreach(\App\Models\Category::where('name', 'not like', 'Materi%')->take(6)->get() as $cat)
                                                    <li class="mb-2"><a href="{{ route('categories.show', $cat->slug) }}" class="text-decoration-none text-dark hover-primary">{{ $cat->name }}</a></li>
                                                    @endforeach
                                                    <li class="mt-3"><a href="{{ route('posts.index') }}" class="btn btn-sm btn-outline-warning rounded-pill">Lihat Semua Berita</a></li>
                                                </ul>
                                            </div>
                                            <div class="col-md-8">
                                                <h6 class="text-uppercase fw-bold text-primary mb-3">Berita Terbaru</h6>
                                                <div class="row">
                                                    @foreach(\App\Models\Post::whereHas('category', function($q){ $q->where('name', 'not like', 'Materi%'); })->latest()->take(2)->get() as $latest)
                                                    <div class="col-6">
                                                        <div class="card border-0 shadow-sm h-100">
                                                            @if($latest->thumbnail_url)
                                                                <img src="{{ $latest->thumbnail_url }}" class="card-img-top" alt="{{ $latest->title }}" style="height: 120px; object-fit: cover;">
                                                                @if(!$latest->featured_image && $latest->youtube_url)
                                                                <div class="position-absolute top-50 start-50 translate-middle"><i class="fab fa-youtube text-danger fa-2x bg-white rounded-circle p-1"></i></div>
                                                                @endif
                                                            @else
                                                                <div class="bg-light d-flex align-items-center justify-content-center" style="height: 120px;"><i class="fas fa-image text-muted"></i></div>
                                                            @endif
                                                            <div class="card-body p-2">
                                                                <h6 class="card-title small fw-bold mb-0">
                                                                    <a href="{{ route('posts.show', $latest->slug) }}" class="text-decoration-none text-dark stretched-link">{{ Str::limit($latest->title, 50) }}</a>
                                                                </h6>
                                                                <small class="text-muted" style="font-size: 0.7rem;">{{ $latest->published_at?->diffForHumans() }}</small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            {{-- INJECT MATERI HERE IF NOT IN DB --}}
                            {{-- We can't know for sure if it's in DB later in the loop, but usually navigation is sequential. 
                                 For now, let's assume if the user asks to split, they might NOT have a Materi menu. 
                                 However, to be safe and avoid duplicates, I will ONLY render this IF I know I should. 
                                 Actually, let's just stick to the request: "pisahkan".
                                 I'll add the "Materi" menu in the Fallback section. 
                                 If the user has DB menus, they need to add "Materi" themselves. 
                                 BUT, I will add a hardcoded "Materi" to the fallback list below.
                            --}}

                        @elseif($menu->children->count() > 0)
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown{{ $menu->id }}" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    {{ $menu->name }}
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdown{{ $menu->id }}">
                                    @foreach($menu->children as $child)
                                        <li><a class="dropdown-item" href="{{ url($child->url) }}">{{ $child->name }}</a></li>
                                    @endforeach
                                </ul>
                            </li>
                        @else
                            <li class="nav-item">
                                <a class="nav-link {{ request()->is(ltrim($menu->url, '/')) || request()->fullUrlIs(url($menu->url)) ? 'active' : '' }}" href="{{ url($menu->url) }}">{{ $menu->name }}</a>
                            </li>
                        @endif
                    @empty
                        <li class="nav-item"><a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Beranda</a></li>
                        
                        <!-- Berita Mega Menu Fallback -->
                        <li class="nav-item dropdown mega-dropdown">
                            <a class="nav-link dropdown-toggle {{ request()->routeIs('posts*') ? 'active' : '' }}" href="{{ route('posts.index') }}" id="navbarDropdownNews" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Berita
                            </a>
                            <div class="dropdown-menu mega-menu shadow border-0 mt-0" aria-labelledby="navbarDropdownNews">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <h6 class="text-uppercase fw-bold text-primary mb-3 text-start">Kategori Berita</h6>
                                            <ul class="list-unstyled text-start">
                                                @foreach(\App\Models\Category::where('name', 'not like', 'Materi%')->take(6)->get() as $cat)
                                                <li class="mb-2"><a href="{{ route('categories.show', $cat->slug) }}" class="text-decoration-none text-dark hover-primary">{{ $cat->name }}</a></li>
                                                @endforeach
                                                <li class="mt-3"><a href="{{ route('posts.index') }}" class="btn btn-sm btn-outline-warning rounded-pill">Lihat Semua Berita</a></li>
                                            </ul>
                                        </div>
                                        <div class="col-md-8">
                                            <h6 class="text-uppercase fw-bold text-primary mb-3 text-start">Berita Terbaru</h6>
                                            <div class="row">
                                                @foreach(\App\Models\Post::whereHas('category', function($q){ $q->where('name', 'not like', 'Materi%'); })->latest()->take(2)->get() as $latest)
                                                <div class="col-6">
                                                    <div class="card border-0 shadow-sm h-100">
                                                        @if($latest->thumbnail_url)
                                                            <img src="{{ $latest->thumbnail_url }}" class="card-img-top" alt="{{ $latest->title }}" style="height: 120px; object-fit: cover;">
                                                            @if(!$latest->featured_image && $latest->youtube_url)
                                                            <div class="position-absolute top-50 start-50 translate-middle"><i class="fab fa-youtube text-danger fa-2x bg-white rounded-circle p-1"></i></div>
                                                            @endif
                                                        @else
                                                            <div class="bg-light d-flex align-items-center justify-content-center" style="height: 120px;"><i class="fas fa-image text-muted"></i></div>
                                                        @endif
                                                        <div class="card-body p-2 text-start">
                                                            <h6 class="card-title small fw-bold mb-0">
                                                                <a href="{{ route('posts.show', $latest->slug) }}" class="text-decoration-none text-dark stretched-link">{{ Str::limit($latest->title, 50) }}</a>
                                                            </h6>
                                                            <small class="text-muted" style="font-size: 0.7rem;">{{ $latest->published_at?->diffForHumans() }}</small>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>

                        <!-- Materi Mega Menu Fallback -->
                         <li class="nav-item dropdown mega-dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMateriFallback" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Materi
                            </a>
                            <div class="dropdown-menu mega-menu shadow border-0 mt-0" aria-labelledby="navbarDropdownMateriFallback">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <h6 class="text-uppercase fw-bold text-primary mb-3 text-start">Materi Belajar</h6>
                                            <ul class="list-unstyled text-start">
                                                @foreach(\App\Models\Category::where('name', 'like', 'Materi%')->get() as $cat)
                                                <li class="mb-2"><a href="{{ route('categories.show', $cat->slug) }}" class="text-decoration-none text-dark hover-primary">{{ $cat->name }}</a></li>
                                                @endforeach
                                            </ul>
                                        </div>
                                        <div class="col-md-8">
                                            <h6 class="text-uppercase fw-bold text-primary mb-3 text-start">Materi Terbaru</h6>
                                            <div class="row">
                                                @foreach(\App\Models\Post::whereHas('category', function($q){ $q->where('name', 'like', 'Materi%'); })->latest()->take(2)->get() as $latest)
                                                <div class="col-6">
                                                    <div class="card border-0 shadow-sm h-100">
                                                        @if($latest->thumbnail_url)
                                                            <img src="{{ $latest->thumbnail_url }}" class="card-img-top" alt="{{ $latest->title }}" style="height: 120px; object-fit: cover;">
                                                            @if(!$latest->featured_image && $latest->youtube_url)
                                                            <div class="position-absolute top-50 start-50 translate-middle"><i class="fab fa-youtube text-danger fa-2x bg-white rounded-circle p-1"></i></div>
                                                            @endif
                                                        @else
                                                            <div class="bg-light d-flex align-items-center justify-content-center" style="height: 120px;"><i class="fas fa-image text-muted"></i></div>
                                                        @endif
                                                        <div class="card-body p-2 text-start">
                                                            <h6 class="card-title small fw-bold mb-0">
                                                                <a href="{{ route('posts.show', $latest->slug) }}" class="text-decoration-none text-dark stretched-link">{{ Str::limit($latest->title, 50) }}</a>
                                                            </h6>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>

                        <li class="nav-item"><a class="nav-link" href="{{ route('downloads.index') }}">Download</a></li>
                        <li class="nav-item"><a class="nav-link {{ request()->routeIs('bulletins.*') ? 'active' : '' }}" href="{{ route('bulletins.public') }}">Buletin</a></li>
                    @endforelse
                    
                    {{-- Social Icons for Mobile Menu --}}
                    <li class="nav-item d-lg-none border-top border-white border-opacity-25 pt-3 mt-2">
                        <div class="d-flex justify-content-center gap-4 py-2">
                            @if($fb = \App\Models\Setting::get('social_facebook')) <a href="{{ $fb }}" class="text-white fs-5" target="_blank"><i class="fab fa-facebook-f"></i></a> @endif
                            @if($ig = \App\Models\Setting::get('social_instagram')) <a href="{{ $ig }}" class="text-white fs-5" target="_blank"><i class="fab fa-instagram"></i></a> @endif
                            @if($yt = \App\Models\Setting::get('social_youtube')) <a href="{{ $yt }}" class="text-white fs-5" target="_blank"><i class="fab fa-youtube"></i></a> @endif
                            @if($x = \App\Models\Setting::get('social_x')) <a href="{{ $x }}" class="text-white fs-5" target="_blank"><i class="fab fa-x-twitter"></i></a> @endif
                            @if($tt = \App\Models\Setting::get('social_tiktok')) <a href="{{ $tt }}" class="text-white fs-5" target="_blank"><i class="fab fa-tiktok"></i></a> @endif
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        <div class="container my-5">
            @yield('content')
        </div>
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-4">
                    <h5>Tentang Kwarran</h5>
                    <p>{{ \App\Models\Setting::get('about', 'Kwartir Ranting Gerakan Pramuka Bekasi Timur merupakan satuan organisasi yang mengelola Gerakan Pramuka di tingkat Kecamatan Bekasi Timur.') }}</p>
                    {{-- Icons moved to footer bottom --}}
                </div>
                <div class="col-lg-2 mb-4">
                    <h5>Tautan Cepat</h5>
                    <div class="footer-links">
                        <ul>
                            <li><a href="{{ route('home') }}">Beranda</a></li>
                            <li><a href="#">Tentang Kami</a></li>
                            <li><a href="{{ route('posts.index') }}">Berita</a></li>
                            @auth
                            <li><a href="{{ route('admin.dashboard') }}">Panel Admin</a></li>
                            @else
                            <li><a href="{{ route('login') }}">Login Admin</a></li>
                            @endauth
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 mb-4">
                    <h5>Kategori</h5>
                    <div class="footer-links">
                        <ul>
                            @foreach(\App\Models\Category::take(4)->get() as $cat)
                            <li><a href="{{ route('categories.show', $cat->slug) }}">{{ $cat->name }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 mb-4">
                    <h5>Kontak Kami</h5>
                    <p><i class="fas fa-map-marker-alt me-2"></i> {{ \App\Models\Setting::get('address', 'Kec. Bekasi Timur, Kota Bekasi, Jawa Barat') }}</p>
                    <p><i class="fas fa-phone me-2"></i> {{ \App\Models\Setting::get('phone', '+62 ...') }}</p>
                    <p><i class="fas fa-envelope me-2"></i> {{ \App\Models\Setting::get('email', 'info@kwarranbekasitimur.id') }}</p>
                </div>
            </div>
        </div>
        <div class="footer-bottom border-top border-white border-opacity-10 py-5 mt-4">
            <div class="container text-center">
                {{-- Social Icons --}}
                <div class="d-flex justify-content-center gap-3 mb-4">
                    @if($fb = \App\Models\Setting::get('social_facebook')) <a href="{{ $fb }}" class="btn btn-outline-light btn-sm rounded-circle" style="width: 35px; height: 35px; display: flex; align-items: center; justify-content: center;" target="_blank"><i class="fab fa-facebook-f"></i></a> @endif
                    @if($ig = \App\Models\Setting::get('social_instagram')) <a href="{{ $ig }}" class="btn btn-outline-light btn-sm rounded-circle" style="width: 35px; height: 35px; display: flex; align-items: center; justify-content: center;" target="_blank"><i class="fab fa-instagram"></i></a> @endif
                    @if($yt = \App\Models\Setting::get('social_youtube')) <a href="{{ $yt }}" class="btn btn-outline-light btn-sm rounded-circle" style="width: 35px; height: 35px; display: flex; align-items: center; justify-content: center;" target="_blank"><i class="fab fa-youtube"></i></a> @endif
                    @if($x = \App\Models\Setting::get('social_x')) <a href="{{ $x }}" class="btn btn-outline-light btn-sm rounded-circle" style="width: 35px; height: 35px; display: flex; align-items: center; justify-content: center;" target="_blank"><i class="fa-brands fa-x-twitter"></i></a> @endif
                    @if($tt = \App\Models\Setting::get('social_tiktok')) <a href="{{ $tt }}" class="btn btn-outline-light btn-sm rounded-circle" style="width: 35px; height: 35px; display: flex; align-items: center; justify-content: center;" target="_blank"><i class="fab fa-tiktok"></i></a> @endif
                </div>

                <p class="mb-1 text-white">&copy; {{ date('Y') }} {{ config('app.name') }}. All Rights Reserved.</p>
                <p class="small text-white mb-0">
                    Di buat untuk Kwarran Bekasi Timur Oleh <a href="https://wa.me/6281389510337" target="_blank" style="color: var(--secondary-color); font-weight: bold;" class="text-decoration-none">Kak MD</a>
                </p>
            </div>
        </div>
    </footer>

    <!-- jQuery (Required for Lightbox) -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        const swiper = new Swiper('.main-slider', {
            loop: true,
            autoplay: {
                delay: 5000,
                disableOnInteraction: false,
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            effect: 'fade',
            fadeEffect: {
                crossFade: true
            },
        });
    </script>
    @stack('scripts')
    @yield('scripts')
</body>
</html>
