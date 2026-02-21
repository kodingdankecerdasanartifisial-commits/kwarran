@extends('layouts.public')

@section('title', $gudep->pangkalan_name . ' (' . $gudep->gudep_number . ') - Kwarran Bekasi Timur')

@section('styles')
<style>
    .gudep-hero {
        height: 60vh;
        min-height: 400px;
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
        display: flex;
        align-items: center;
        position: relative;
    }
    .gudep-hero::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        background: linear-gradient(rgba(0,0,0,0.2), rgba(0,0,0,0.7));
    }
    .hero-content {
        position: relative;
        z-index: 2;
        color: white;
    }
    .gudep-logo-container {
        width: 120px;
        height: 120px;
        background: white;
        padding: 5px;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        margin-bottom: 20px;
        display: inline-block;
    }
    .gudep-logo-container img {
        width: 100%;
        height: 100%;
        object-fit: contain;
    }
    .section-title {
        position: relative;
        padding-bottom: 15px;
        margin-bottom: 30px;
        font-weight: 700;
        color: var(--primary-color);
    }
    .section-title::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 60px;
        height: 4px;
        background: var(--secondary-color);
        border-radius: 2px;
    }
    .sidebar-menu-gudep {
        position: sticky;
        top: 100px;
    }
    .menu-gudep-item {
        display: flex;
        align-items: center;
        padding: 12px 15px;
        color: #555;
        text-decoration: none;
        border-radius: 8px;
        margin-bottom: 5px;
        transition: all 0.3s;
    }
    .menu-gudep-item:hover, .menu-gudep-item.active {
        background: var(--primary-color);
        color: white !important;
    }
    .menu-gudep-item i {
        width: 25px;
        margin-right: 10px;
        font-size: 1.1rem;
    }
    .member-card {
        border: none;
        transition: transform 0.3s;
        text-align: center;
    }
    .member-card:hover {
        transform: translateY(-10px);
    }
    .member-photo {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        object-fit: cover;
        margin: 0 auto 15px;
        border: 4px solid #f8f9fa;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    .stat-card {
        background: linear-gradient(135deg, var(--primary-color), #6d4133);
        color: white;
        border-radius: 15px;
        padding: 30px;
        text-align: center;
    }
    .activity-card {
        border-left: 5px solid var(--secondary-color);
        background: #fff;
        padding: 20px;
        border-radius: 0 10px 10px 0;
        box-shadow: 0 4px 6px rgba(0,0,0,0.05);
        margin-bottom: 20px;
    }
    .gallery-item {
        position: relative;
        overflow: hidden;
        border-radius: 10px;
        cursor: pointer;
    }
    .gallery-item img {
        transition: transform 0.5s;
    }
    .gallery-item:hover img {
        transform: scale(1.1);
    }
    .video-card {
        transition: all 0.3s;
    }
    .video-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
    }
    .video-btn {
        cursor: pointer;
        width: 100%;
        height: 100%;
    }
    .hover-scale {
        transition: transform 0.3s;
    }
    .video-btn:hover .hover-scale {
        transform: scale(1.2);
        color: var(--secondary-color) !important;
    }
    .contact-item {
        display: flex;
        align-items: center;
        margin-bottom: 10px;
        color: #555;
    }
    .contact-item i {
        width: 30px;
        color: var(--primary-color);
    }
</style>
@endsection

@section('content')
</div> {{-- Break the container from layout --}}

<!-- Hero Section -->
<section class="gudep-hero" style="background-image: url('{{ $gudep->hero_image ? asset('storage/' . $gudep->hero_image) : 'https://images.unsplash.com/photo-1526772662000-3f88f10405ff' }}');">
    <div class="container">
        <div class="hero-content animate__animated animate__fadeInUp">
            <div class="gudep-logo-container">
                <img src="{{ $gudep->logo ? asset('storage/' . $gudep->logo) : asset('logo.png') }}" alt="Logo {{ $gudep->pangkalan_name }}">
            </div>
            <h1 class="display-4 fw-bold mb-1">{{ $gudep->pangkalan_name }}</h1>
            <h3 class="fw-bold text-warning mb-3">Gugus Depan {{ $gudep->gudep_number }}</h3>
            <p class="lead opacity-90"><i class="fas fa-map-marker-alt me-2"></i> Kwartir Ranting Bekasi Timur - Kota Bekasi</p>
            
            <div class="d-flex gap-3 mt-4">
                @if($gudep->social_media['facebook'] ?? null) <a href="{{ $gudep->social_media['facebook'] }}" class="btn btn-light rounded-circle" target="_blank"><i class="fab fa-facebook-f"></i></a> @endif
                @if($gudep->social_media['instagram'] ?? null) <a href="{{ $gudep->social_media['instagram'] }}" class="btn btn-light rounded-circle" target="_blank"><i class="fab fa-instagram"></i></a> @endif
                @if($gudep->social_media['youtube'] ?? null) <a href="{{ $gudep->social_media['youtube'] }}" class="btn btn-light rounded-circle" target="_blank"><i class="fab fa-youtube"></i></a> @endif
                @if($gudep->social_media['tiktok'] ?? null) <a href="{{ $gudep->social_media['tiktok'] }}" class="btn btn-light rounded-circle" target="_blank"><i class="fab fa-tiktok"></i></a> @endif
            </div>
        </div>
    </div>
</section>

<div class="container my-5">
    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-8 order-2 order-lg-1">
            
            <!-- Vision & Mission -->
            <section id="visi-misi" class="mb-5 py-3">
                <h3 class="section-title">Visi & Misi</h3>
                <div class="row">
                    <div class="col-md-6 mb-4 mb-md-0">
                        <div class="card h-100 border-0 shadow-sm p-4 text-center">
                            <div class="icon-box-sm bg-primary bg-opacity-10 text-primary mx-auto mb-3">
                                <i class="fas fa-eye fa-2x"></i>
                            </div>
                            <h4 class="fw-bold">Visi</h4>
                            <p class="mb-0 text-muted fst-italic">{{ $gudep->vision ?? 'Visi belum diisi.' }}</p>
                            
                            @if($gudep->whatsapp || $gudep->email)
                            <hr class="my-4">
                            <div class="text-start">
                                <h6 class="fw-bold mb-3"><i class="fas fa-address-book me-2"></i> Kontak Pangkalan</h6>
                                @if($gudep->whatsapp)
                                <div class="contact-item">
                                    <i class="fab fa-whatsapp"></i>
                                    <span>{{ $gudep->whatsapp }}</span>
                                </div>
                                @endif
                                @if($gudep->email)
                                <div class="contact-item">
                                    <i class="fas fa-envelope"></i>
                                    <span>{{ $gudep->email }}</span>
                                </div>
                                @endif
                                @if($gudep->address)
                                <div class="contact-item">
                                    <i class="fas fa-map-marker-alt"></i>
                                    <span>{{ $gudep->address }}</span>
                                </div>
                                @endif
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card h-100 border-0 shadow-sm p-4 text-center">
                            <div class="icon-box-sm bg-secondary bg-opacity-10 text-secondary mx-auto mb-3">
                                <i class="fas fa-bullseye fa-2x"></i>
                            </div>
                            <h4 class="fw-bold">Misi</h4>
                            <div class="text-muted text-start">
                                {!! nl2br(e($gudep->mission)) !!}
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Struktur Kepengurusan -->
            <section id="struktur" class="mb-5 py-3">
                <h3 class="section-title">Struktur Kepengurusan</h3>
                <div class="card border-0 shadow-sm overflow-hidden">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-primary text-white" style="background-color: #0d6efd !important;">
                                <tr>
                                    <th class="px-4 py-3" style="width: 80px;">Foto</th>
                                    <th class="py-3">Nama Lengkap</th>
                                    <th class="py-3">Jabatan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($gudep->structure ?? [] as $member)
                                <tr>
                                    <td class="px-4 py-3">
                                        <img src="{{ !empty($member['photo']) ? asset('storage/' . $member['photo']) : 'https://ui-avatars.com/api/?name='.urlencode($member['name']).'&background=random' }}" 
                                             class="rounded shadow-sm" 
                                             style="width: 50px; height: 70px; object-fit: cover; border: 1px solid #eee;" 
                                             alt="{{ $member['name'] }}">
                                    </td>
                                    <td class="py-3 fw-bold text-dark">{{ $member['name'] }}</td>
                                    <td class="py-3 text-dark">{{ $member['position'] }}</td>
                                </tr>
                                @empty
                                <tr><td colspan="3" class="text-center py-4 text-muted">Data kepengurusan belum diunggah.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>

            <!-- Statistik Anggota -->
            <section id="statistik" class="mb-5 py-3">
                <div class="stat-card">
                    <div class="row align-items-center">
                        <div class="col-md-4 mb-4 mb-md-0">
                            <i class="fas fa-users fa-3x mb-3 text-warning"></i>
                            <h2 class="display-5 fw-bold mb-0">{{ number_format(($gudep->male_members_count + $gudep->female_members_count) ?: $gudep->active_members_count) }}</h2>
                            <p class="text-uppercase tracking-wider mb-0 opacity-75 small">Total Anggota</p>
                        </div>
                        <div class="col-md-8">
                            <div class="row g-3">
                                <div class="col-6">
                                    <div class="bg-white bg-opacity-10 rounded p-3 text-center border border-white border-opacity-25 h-100">
                                        <i class="fas fa-male fa-2x mb-2 text-info"></i>
                                        <h3 class="fw-bold mb-0 text-white">{{ number_format($gudep->male_members_count) }}</h3>
                                        <p class="small mb-0 opacity-75">Putra</p>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="bg-white bg-opacity-10 rounded p-3 text-center border border-white border-opacity-25 h-100">
                                        <i class="fas fa-female fa-2x mb-2 text-danger"></i>
                                        <h3 class="fw-bold mb-0 text-white">{{ number_format($gudep->female_members_count) }}</h3>
                                        <p class="small mb-0 opacity-75">Putri</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="stat-card mb-4" style="background: linear-gradient(135deg, #166534 0%, #14532d 100%);">
                    <div class="row align-items-center">
                        <div class="col-md-4 mb-4 mb-md-0">
                            <i class="fas fa-user-tie fa-3x mb-3 text-warning"></i>
                            <h2 class="display-5 fw-bold mb-0 text-white">{{ number_format($gudep->male_pembina_count + $gudep->female_pembina_count) }}</h2>
                            <p class="text-uppercase tracking-wider mb-0 opacity-75 small text-white">Total Pembina</p>
                        </div>
                        <div class="col-md-8">
                            <div class="row g-3">
                                <div class="col-6">
                                    <div class="bg-white bg-opacity-10 rounded p-3 text-center border border-white border-opacity-25 h-100">
                                        <i class="fas fa-male fa-2x mb-2 text-info"></i>
                                        <h3 class="fw-bold mb-0 text-white">{{ number_format($gudep->male_pembina_count) }}</h3>
                                        <p class="small mb-0 opacity-75 text-white">Pembina Putra</p>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="bg-white bg-opacity-10 rounded p-3 text-center border border-white border-opacity-25 h-100">
                                        <i class="fas fa-female fa-2x mb-2 text-danger"></i>
                                        <h3 class="fw-bold mb-0 text-white">{{ number_format($gudep->female_pembina_count) }}</h3>
                                        <p class="small mb-0 opacity-75 text-white">Pembina Putri</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Data Potensi -->
            @if(!empty($gudep->potensi))
            <section id="potensi" class="mb-5 py-3">
                <h3 class="section-title">Data Potensi Anggota</h3>
                <div class="card border-0 shadow-sm overflow-hidden">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="text-white" style="background-color: var(--primary-color, #4B2C20);">
                                <tr>
                                    <th class="px-4 py-3">Jenjang</th>
                                    <th class="py-3">Tingkatan</th>
                                    <th class="py-3 text-center">Jenis Kelamin</th>
                                    <th class="py-3 text-center">Jumlah</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $jenjangOrder = ['Siaga', 'Penggalang', 'Penegak', 'Pandega'];
                                    $potensiByJenjang = collect($gudep->potensi)->groupBy('jenjang');
                                @endphp
                                @foreach($jenjangOrder as $jenjang)
                                    @if($potensiByJenjang->has($jenjang))
                                        @php $items = $potensiByJenjang[$jenjang]; @endphp
                                        @foreach($items as $i => $item)
                                        <tr>
                                            @if($i === 0)
                                            <td class="px-4 py-3 fw-bold" style="color: var(--primary-color);" rowspan="{{ $items->count() }}">
                                                {{ $jenjang }}
                                            </td>
                                            @endif
                                            <td class="py-3">
                                                <span class="badge bg-warning text-dark px-3 py-2 rounded-pill">{{ $item['tingkatan'] ?? '-' }}</span>
                                            </td>
                                            <td class="py-3 text-center">
                                                @if(($item['gender'] ?? '') == 'Laki-Laki')
                                                    <i class="fas fa-male text-primary me-1"></i> Putra
                                                @else
                                                    <i class="fas fa-female text-danger me-1"></i> Putri
                                                @endif
                                            </td>
                                            <td class="py-3 text-center fw-bold">{{ number_format($item['jumlah'] ?? 0) }}</td>
                                        </tr>
                                        @endforeach
                                        <tr class="table-light">
                                            <td colspan="3" class="px-4 py-2 text-end fw-bold small">Subtotal {{ $jenjang }}</td>
                                            <td class="py-2 text-center fw-bold">{{ number_format($items->sum('jumlah')) }}</td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr style="background-color: var(--primary-color, #4B2C20); color: white;">
                                    <td colspan="3" class="px-4 py-3 fw-bold">Total Seluruh Potensi Anggota</td>
                                    <td class="py-3 text-center fw-bold fs-5">{{ number_format(collect($gudep->potensi)->sum('jumlah')) }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </section>
            @endif

            <!-- Data Potensi Pembina -->
            @if(!empty($gudep->potensi_pembina))
            <section id="potensi-pembina" class="mb-5 py-3">
                <h3 class="section-title">Data Potensi Pembina</h3>
                <div class="card border-0 shadow-sm overflow-hidden">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="text-white" style="background-color: var(--secondary-color, #c2410c);">
                                <tr>
                                    <th class="px-4 py-3">Jenis Kelamin</th>
                                    <th class="py-3">Jenis Kursus & Tahun</th>
                                    <th class="py-3 text-center">Jumlah</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($gudep->potensi_pembina as $item)
                                <tr>
                                    <td class="px-4 py-3 fw-bold">
                                        @if(($item['jenis_kelamin'] ?? '') == 'Laki-laki')
                                            <i class="fas fa-male text-primary me-1"></i> Laki-laki
                                        @else
                                            <i class="fas fa-female text-danger me-1"></i> Perempuan
                                        @endif
                                    </td>
                                    <td class="py-3">
                                        @if(!empty($item['belum_kursus']))
                                            <span class="badge bg-secondary px-2 py-1 rounded-pill">Belum Kursus</span>
                                        @elseif(isset($item['kursus_data']) && is_array($item['kursus_data']))
                                            @foreach($item['kursus_data'] as $kursus)
                                                <div class="mb-1">
                                                    <span class="badge bg-success px-2 py-1 rounded-pill">{{ $kursus['jenis'] }}</span>
                                                    <span class="small text-muted">({{ $kursus['tahun'] }})</span>
                                                </div>
                                            @endforeach
                                        @endif
                                    </td>
                                    <td class="py-3 text-center fw-bold">{{ number_format($item['jumlah'] ?? 0) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr style="background-color: var(--secondary-color, #c2410c); color: white;">
                                    <td colspan="2" class="px-4 py-3 fw-bold">Total Pembina</td>
                                    <td class="py-3 text-center fw-bold fs-5">{{ number_format(collect($gudep->potensi_pembina)->sum('jumlah')) }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </section>
            @endif

            <!-- Daftar Prestasi -->
            @if(!empty($gudep->achievements))
            <section id="prestasi" class="mb-5 py-3">
                <h3 class="section-title">Daftar Prestasi</h3>
                <div class="card border-0 shadow-sm overflow-hidden">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-primary text-white">
                                <tr>
                                    <th class="px-4 py-3" style="width: 100px;">Tahun</th>
                                    <th class="py-3">Prestasi / Kegiatan</th>
                                    <th class="py-3 text-center">Tingkat</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($gudep->achievements as $ach)
                                <tr>
                                    <td class="px-4 py-3 fw-bold text-primary">{{ $ach['year'] }}</td>
                                    <td class="py-3 fw-bold">{{ $ach['title'] }}</td>
                                    <td class="py-3 text-center">
                                        <span class="badge bg-warning text-dark px-3 py-2 rounded-pill">{{ $ach['level'] ?? '-' }}</span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
            @endif

            <!-- Kegiatan Rutin -->
            <section id="kegiatan" class="mb-5 py-3">
                <h3 class="section-title">Kegiatan Rutin</h3>
                @forelse($gudep->routine_activities ?? [] as $activity)
                <div class="activity-card">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <h5 class="fw-bold text-primary mb-0">{{ $activity['title'] }}</h5>
                        <span class="badge bg-warning text-dark">{{ $activity['day'] ?? 'Sabtu' }}</span>
                    </div>
                    <p class="text-muted small mb-2"><i class="far fa-clock me-1"></i> {{ $activity['time'] ?? '14:00 - 16:00' }} WIB</p>
                    <p class="mb-0">{{ $activity['description'] }}</p>
                </div>
                @empty
                <div class="text-center text-muted py-4">Belum ada daftar kegiatan rutin.</div>
                @endforelse
            </section>

            <!-- Galeri Foto -->
            <section id="galeri" class="mb-5 py-3">
                <h3 class="section-title">Galeri Foto</h3>
                <div class="row g-3">
                    @forelse($gudep->gallery ?? [] as $item)
                    <div class="col-md-4 col-6">
                        <div class="gallery-item shadow-sm">
                            <img src="{{ asset('storage/' . $item['image_path']) }}" class="img-fluid w-100" style="height: 180px; object-fit: cover;" alt="{{ $item['caption'] ?? '' }}">
                            @if(!empty($item['caption']))
                                <div class="p-2 small text-center bg-white border-top">{{ $item['caption'] }}</div>
                            @endif
                        </div>
                    </div>
                    @empty
                    <div class="col-12 text-center text-muted py-4">Galeri foto masih kosong.</div>
                    @endforelse
                </div>
            </section>

            <!-- Video Dokumentasi -->
            @if(!empty($gudep->videos))
            <section id="video" class="mb-5 py-3">
                <h3 class="section-title">Dokumentasi Video</h3>
                <div class="row g-4">
                    @foreach($gudep->videos as $video)
                        @if(!empty($video['url']))
                            @php
                                $url = $video['url'];
                                $videoId = '';
                                if (preg_match('/embed\/([a-zA-Z0-9_-]+)/', $url, $matches)) {
                                    $videoId = $matches[1];
                                }
                            @endphp
                            <div class="col-12 col-md-6 mb-4">
                                <div class="card border-0 shadow-sm overflow-hidden h-100 video-card">
                                    <div class="ratio ratio-16x9 position-relative bg-dark">
                                        @if($videoId)
                                            <div class="video-btn" onclick="this.innerHTML='<iframe src=\'{{ $url }}?autoplay=1\' class=\'w-100 h-100 border-0\' allow=\'autoplay; encrypted-media\' allowfullscreen></iframe>'">
                                                <img src="https://img.youtube.com/vi/{{ $videoId }}/hqdefault.jpg" class="w-100 h-100 object-fit-cover opacity-75" alt="{{ $video['title'] ?? '' }}">
                                                <div class="position-absolute top-50 start-50 translate-middle">
                                                    <i class="fas fa-play-circle fa-4x text-white opacity-90 transition-all hover-scale"></i>
                                                </div>
                                            </div>
                                        @else
                                            <iframe src="{{ $url }}" title="{{ $video['title'] ?? 'Video Dokumentasi' }}" allowfullscreen></iframe>
                                        @endif
                                    </div>
                                    <div class="card-body p-3">
                                        <h6 class="fw-bold mb-0 text-truncate">{{ $video['title'] ?? 'Dokumentasi Video' }}</h6>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </section>
            @endif
        </div>

        <!-- Sidebar Rigt: Menu Gudep -->
        <div class="col-lg-4 order-1 order-lg-2">
            <div class="sidebar-menu-gudep">
                <div class="card border-0 shadow-sm overflow-hidden mb-4">
                    <div class="card-header bg-primary text-white py-3">
                        <h5 class="m-0 fw-bold"><i class="fas fa-list-ul me-2"></i> Menu Gudep</h5>
                    </div>
                    <div class="card-body p-2 mt-2">
                        <a href="#visi-misi" class="menu-gudep-item">
                            <i class="fas fa-bullseye"></i> Visi & Misi
                        </a>
                        <a href="#struktur" class="menu-gudep-item">
                            <i class="fas fa-sitemap"></i> Struktur Kepengurusan
                        </a>
                        <a href="#statistik" class="menu-gudep-item">
                            <i class="fas fa-users-cog"></i> Data Anggota Aktif
                        </a>
                        <a href="#potensi" class="menu-gudep-item">
                            <i class="fas fa-chart-bar"></i> Data Potensi Anggota
                        </a>
                        <a href="#potensi-pembina" class="menu-gudep-item">
                            <i class="fas fa-user-tie"></i> Data Potensi Pembina
                        </a>
                        <a href="#prestasi" class="menu-gudep-item">
                            <i class="fas fa-medal"></i> Daftar Prestasi
                        </a>
                        <a href="#kegiatan" class="menu-gudep-item">
                            <i class="fas fa-calendar-alt"></i> Kegiatan Rutin
                        </a>
                        <a href="#galeri" class="menu-gudep-item">
                            <i class="fas fa-camera"></i> Galeri Foto
                        </a>
                        <a href="#video" class="menu-gudep-item">
                            <i class="fas fa-video"></i> Dokumentasi Video
                        </a>
                    </div>
                </div>

                {{-- Include general sidebar if needed, or just specific text --}}
                <div class="p-3 bg-light rounded text-center mb-4">
                    <p class="small text-muted mb-0">Butuh informasi lebih lanjut? Hubungi admin Kwarran atau pangkalan ini secara langsung.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container"> {{-- Restore the container for layout --}}
@endsection

@section('scripts')
<script>
    // Simple smooth scroll and active state for side menu
    document.querySelectorAll('.menu-gudep-item').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const targetId = this.getAttribute('href');
            const targetElement = document.querySelector(targetId);
            
            if (targetElement) {
                window.scrollTo({
                    top: targetElement.offsetTop - 100,
                    behavior: 'smooth'
                });

                // Update active state
                document.querySelectorAll('.menu-gudep-item').forEach(item => item.classList.remove('active'));
                this.classList.add('active');
            }
        });
    });

    // Scroll spy like effect
    window.addEventListener('scroll', function() {
        const sections = ['visi-misi', 'struktur', 'statistik', 'potensi', 'potensi-pembina', 'prestasi', 'kegiatan', 'galeri', 'video'];
        let current = '';

        sections.forEach(section => {
            const element = document.getElementById(section);
            if (element) {
                const rect = element.getBoundingClientRect();
                if (rect.top <= 150) {
                    current = section;
                }
            }
        });

        if (current) {
            document.querySelectorAll('.menu-gudep-item').forEach(item => {
                item.classList.remove('active');
                if (item.getAttribute('href') === `#${current}`) {
                    item.classList.add('active');
                }
            });
        }
    });
</script>
@endsection
