@extends('layouts.public')

@section('title', $bulletin->title . ' - Kwarran Bekasi Timur')

@section('content')
<section class="py-5">
    <div class="container">
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
                <li class="breadcrumb-item"><a href="{{ route('bulletins.public') }}">Buletin</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $bulletin->title }}</li>
            </ol>
        </nav>

        <div class="row align-items-center mb-4">
            <div class="col-md-8">
                <h1 class="fw-bold m-0">{{ $bulletin->title }}</h1>
                <p class="text-muted mt-2 mb-0">
                    <i class="far fa-calendar-alt me-1"></i> Dipublikasikan pada {{ $bulletin->created_at->format('d F Y') }}
                </p>
            </div>
            <div class="col-md-4 text-md-end mt-3 mt-md-0">
                <a href="{{ route('bulletins.public') }}" class="btn btn-outline-secondary rounded-pill px-4">
                    <i class="fas fa-arrow-left me-1"></i> Kembali ke Daftar
                </a>
            </div>
        </div>

        <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="card-body p-0">
                <div style="position: relative; width: 100%; height: 0; padding-top: 141.4286%; margin-top: 0; margin-bottom: 0; box-shadow: 0 2px 8px 0 rgba(63,69,81,0.16); transition: all 0.3s ease-in-out;">
                    @php
                        $embed_url = $bulletin->embed_link;
                        if (str_contains($embed_url, '/view?')) {
                            $embed_url = str_replace('/view?', '/view?embed&', $embed_url);
                        } elseif (!str_contains($embed_url, 'embed')) {
                             if (str_contains($embed_url, '?')) {
                                $embed_url .= '&embed';
                             } else {
                                $embed_url .= '?embed';
                             }
                        }
                    @endphp
                    <iframe scrolling="no" title="{{ $bulletin->title }}" src="{{ $embed_url }}" style="position: absolute; width: 100%; height: 100%; top: 0; left: 0; border: none; padding: 0;margin: 0;" allowfullscreen="allowfullscreen" allow="fullscreen">
                    </iframe>
                </div>
            </div>
            <div class="card-footer bg-white p-4 text-center border-0">
                <p class="mb-0 text-muted">Gunakan kontrol di dalam Canva untuk memperbesar atau berpindah halaman.</p>
            </div>
        </div>
    </div>
</section>
@endsection
