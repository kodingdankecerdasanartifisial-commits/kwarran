@extends('layouts.public')

@section('title', $lpk->name . ' - Kwarran Bekasi Timur')

@section('content')
<!-- LPK Hero Section -->
<section class="lpk-hero mb-5 rounded-4 shadow-lg overflow-hidden position-relative">
    <div class="hero-overlay" style="background-image: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.8)), url('{{ $lpk->hero_image_url }}');"></div>
    <div class="container h-100 position-relative z-1 d-flex align-items-center">
        <div class="row w-100 py-5">
            <div class="col-lg-2 text-center text-lg-start mb-4 mb-lg-0">
                <img src="{{ $lpk->logo_url }}" alt="Logo LPK" class="img-fluid bg-white rounded-circle p-2 shadow" style="max-height: 150px; width: 150px; object-fit: contain;">
            </div>
            <div class="col-lg-10 ps-lg-5 text-center text-lg-start">
                <h1 class="display-4 fw-bold text-white mb-2 text-uppercase">{{ $lpk->name }}</h1>
                <p class="lead text-white opacity-90 mb-4 fs-4 border-start border-4 border-success ps-3">Transparansi, Akuntabilitas, dan Integritas Kwartir Ranting Bekasi Timur</p>
                <div class="d-flex flex-wrap gap-2 justify-content-center justify-content-lg-start">
                    @if(!empty($lpk->social_media['instagram']))
                        <a href="{{ $lpk->social_media['instagram'] }}" target="_blank" class="btn btn-danger btn-sm rounded-pill px-3 shadow-sm"><i class="fab fa-instagram me-1"></i> Instagram</a>
                    @endif
                    @if(!empty($lpk->social_media['facebook']))
                        <a href="{{ $lpk->social_media['facebook'] }}" target="_blank" class="btn btn-primary btn-sm rounded-pill px-3 shadow-sm"><i class="fab fa-facebook me-1"></i> Facebook</a>
                    @endif
                    @if(!empty($lpk->social_media['youtube']))
                        <a href="{{ $lpk->social_media['youtube'] }}" target="_blank" class="btn btn-danger btn-sm rounded-pill px-3 shadow-sm"><i class="fab fa-youtube me-1"></i> YouTube</a>
                    @endif
                    @if($lpk->whatsapp)
                        <a href="https://wa.me/{{ $lpk->whatsapp }}" target="_blank" class="btn btn-success btn-sm rounded-pill px-3 shadow-sm"><i class="fab fa-whatsapp me-1"></i> WhatsApp</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    .lpk-hero {
        height: 400px;
        background-color: #1a5c37;
    }
    .hero-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-size: cover;
        background-position: center;
    }
    .z-1 { z-index: 1; }
</style>

<div class="container mb-5">
    <div class="row">
        <div class="col-lg-8">
            <!-- Vision & Mission -->
            <div class="row mb-5">
                <div class="col-md-6 mb-4">
                    <h3 class="fw-bold mb-4 border-start border-4 border-success ps-3">VISI</h3>
                    <div class="card border-0 shadow-sm rounded-4 p-4 bg-white h-100">
                        <p class="lead mb-0 fst-italic text-dark">{{ $lpk->vision ?? 'Belum diisi.' }}</p>
                    </div>
                </div>
                <div class="col-md-6 mb-4">
                    <h3 class="fw-bold mb-4 border-start border-4 border-success ps-3">MISI</h3>
                    <div class="card border-0 shadow-sm rounded-4 p-4 bg-white h-100">
                        <div class="text-muted">{!! nl2br(e($lpk->mission)) ?: 'Belum diisi.' !!}</div>
                    </div>
                </div>
            </div>

            <!-- Financial Reports (Transparency) -->
            <div class="transparency-section mb-5">
                <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom border-success">
                    <h3 class="fw-bold text-uppercase m-0" style="letter-spacing: 1px;">
                        <span class="ps-1">LAPORAN KEUANGAN TERBARU</span>
                    </h3>
                    <a href="{{ route('finances.public') }}" class="btn btn-sm btn-outline-success rounded-pill fw-bold">LIHAT SEMUA</a>
                </div>
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-4">Tanggal</th>
                                    <th>Keterangan</th>
                                    <th>Tipe</th>
                                    <th class="text-end pe-4">Jumlah</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($finances as $finance)
                                <tr>
                                    <td class="ps-4 small text-muted">{{ $finance->transaction_date }}</td>
                                    <td class="fw-bold text-dark">{{ $finance->description }}</td>
                                    <td>
                                        <span class="badge {{ $finance->type == 'income' ? 'bg-success' : 'bg-danger' }}">
                                            {{ $finance->type == 'income' ? 'Pemasukan' : 'Pengeluaran' }}
                                        </span>
                                    </td>
                                    <td class="text-end pe-4 fw-bold {{ $finance->type == 'income' ? 'text-success' : 'text-danger' }}">
                                        Rp {{ number_format($finance->amount, 0, ',', '.') }}
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center py-5 text-muted">Belum ada data keuangan publik.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- News & Posts -->
            <div class="lpk-news-section mb-5">
                <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom border-warning">
                    <h3 class="fw-bold text-uppercase m-0" style="letter-spacing: 1px;">
                        <span class="ps-1">BERITA & INFORMASI LPK</span>
                    </h3>
                </div>
                <div class="row">
                    @forelse($posts as $post)
                    <div class="col-md-6 mb-4">
                        <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden post-card-hover">
                            @if($post->thumbnail_url)
                                <img src="{{ $post->thumbnail_url }}" class="card-img-top" style="height: 180px; object-fit: cover;">
                            @else
                                <div class="bg-light d-flex align-items-center justify-content-center" style="height: 180px;">
                                    <i class="fas fa-image fa-3x text-secondary opacity-25"></i>
                                </div>
                            @endif
                            <div class="card-body p-4">
                                <h5 class="fw-bold mb-2">
                                    <a href="{{ route('posts.show', $post->slug) }}" class="text-decoration-none text-dark">{{ Str::limit($post->title, 50) }}</a>
                                </h5>
                                <p class="text-muted small mb-0">{{ Str::limit(strip_tags($post->content), 80) }}</p>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-12 py-4 text-center text-muted">Belum ada berita LPK.</div>
                    @endforelse
                </div>
            </div>

            @if($lpk->custom_html)
            <div class="custom-block mb-5">
                 {!! $lpk->custom_html !!}
            </div>
            @endif
        </div>

        <div class="col-lg-4">
            <!-- Personnel -->
            @if($lpk->structure)
            <div class="sidebar-block mb-5">
                <h4 class="fw-bold mb-4 border-start border-4 border-success ps-3">PERSONIL LPK</h4>
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                    <div class="list-group list-group-flush">
                        @foreach($lpk->structure as $person)
                        <div class="list-group-item border-0 p-3 hover-light transition">
                            <div class="d-flex align-items-center">
                                @if(!empty($person['photo']))
                                    <img src="{{ \App\Models\Lpk::getMemberPhotoUrl($person['photo']) }}" class="rounded shadow-sm me-3" style="width: 50px; height: 65px; object-fit: cover;">
                                @else
                                    <div class="bg-light rounded d-flex align-items-center justify-content-center border me-3" style="width: 50px; height: 65px;"><i class="fas fa-user text-muted opacity-50"></i></div>
                                @endif
                                <div>
                                    <h6 class="fw-bold mb-0 text-dark">{{ $person['name'] }}</h6>
                                    <small class="text-muted">{{ $person['position'] }}</small>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

            <!-- Contact/Office -->
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden bg-success text-white p-4 mb-4">
                <h4 class="fw-bold mb-4">Kantor LPK</h4>
                <div class="mb-3 d-flex align-items-start">
                    <i class="fas fa-map-marker-alt me-3 mt-1"></i>
                    <p class="small mb-0">{{ $lpk->address ?: 'Bekasi Timur, Kota Bekasi' }}</p>
                </div>
                <div class="mb-3 d-flex align-items-center">
                    <i class="fas fa-envelope me-3"></i>
                    <p class="small mb-0">{{ $lpk->email ?: '-' }}</p>
                </div>
                @if($lpk->whatsapp)
                <a href="https://wa.me/{{ $lpk->whatsapp }}" target="_blank" class="btn btn-warning w-100 fw-bold mt-2">KONTAK KAMI</a>
                @endif
            </div>

            <!-- Videos -->
            @if($lpk->videos)
                @foreach($lpk->videos as $videoUrl)
                    @php
                        preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $videoUrl, $matches);
                        $videoId = $matches[1] ?? null;
                    @endphp
                    @if($videoId)
                    <div class="mb-3">
                        <div class="ratio ratio-16x9 rounded shadow-sm overflow-hidden">
                            <iframe src="https://www.youtube.com/embed/{{ $videoId }}" allowfullscreen></iframe>
                        </div>
                    </div>
                    @endif
                @endforeach
            @endif

            <!-- Agenda Kerja Calendar -->
            <div class="agenda-sidebar mt-4">
                <h5 class="fw-bold mb-3 border-start border-4 border-success ps-3">AGENDA KERJA LPK</h5>
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
        </div>
    </div>
</div>

<style>
    .post-card-hover { transition: all 0.3s ease; }
    .post-card-hover:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important; }
    .hover-light:hover { background-color: #f8f9fa !important; }
</style>
@endsection
