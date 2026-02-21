@extends('layouts.public')

@section('page_title', 'Database Gugus Depan & Pangkalan')

@section('styles')
<style>
    .gudep-header {
        background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('https://source.unsplash.com/random/1600x400/?scout,nature');
        background-size: cover;
        background-position: center;
        padding: 100px 0;
        color: white;
        margin-bottom: 50px;
    }
    .gudep-card {
        transition: transform 0.3s, box-shadow 0.3s;
        border: none;
        border-radius: 15px;
        overflow: hidden;
    }
    .gudep-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.1) !important;
    }
    .gudep-logo-sm {
        width: 80px;
        height: 80px;
        object-fit: contain;
        background: white;
        padding: 5px;
        border-radius: 50%;
        margin-top: 15px;
        border: 3px solid #fff;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    .badge-gudep {
        position: absolute;
        top: 15px;
        right: 15px;
        background: rgba(var(--primary-color-rgb), 0.9);
        color: white;
        padding: 5px 15px;
        border-radius: 20px;
        font-weight: bold;
        font-size: 0.8rem;
    }
    .search-container {
        margin-top: -30px;
        z-index: 10;
        position: relative;
    }
    .stat-mini-card {
        border-left: 4px solid var(--primary-color);
        background: #f8f9fa;
        padding: 15px;
        border-radius: 8px;
    }
</style>
@endsection

@section('content')
<!-- Hero Section -->
<section class="gudep-header text-center">
    <div class="container">
        <h1 class="display-4 fw-bold animate__animated animate__fadeInDown">Database Gugus Depan</h1>
        <p class="lead animate__animated animate__fadeInUp">Sistem Informasi Pangkalan Kwartir Ranting Bekasi Timur</p>
    </div>
</section>

<div class="container mb-5">
    <!-- Quick Stats -->
    <div class="row g-4 mb-5">
        <div class="col-md-3">
            <div class="stat-mini-card shadow-sm h-100">
                <small class="text-muted text-uppercase fw-bold">Total Pangkalan</small>
                <h3 class="fw-bold mb-0">{{ $gudeps->count() }}</h3>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-mini-card shadow-sm h-100" style="border-left-color: #0d6efd;">
                <small class="text-muted text-uppercase fw-bold">Total Anggota Putra</small>
                <h3 class="fw-bold mb-0 text-primary">{{ number_format($gudeps->sum('male_members_count')) }}</h3>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-mini-card shadow-sm h-100" style="border-left-color: #dc3545;">
                <small class="text-muted text-uppercase fw-bold">Total Anggota Putri</small>
                <h3 class="fw-bold mb-0 text-danger">{{ number_format($gudeps->sum('female_members_count')) }}</h3>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-mini-card shadow-sm h-100" style="border-left-color: #ffc107;">
                <small class="text-muted text-uppercase fw-bold">Akumulasi Anggota</small>
                <h3 class="fw-bold mb-0 text-warning">{{ number_format($gudeps->sum('male_members_count') + $gudeps->sum('female_members_count')) }}</h3>
            </div>
        </div>
    </div>

    <!-- Gudep Grid -->
    <div class="row g-4">
        @forelse($gudeps as $gudep)
        <div class="col-md-4 col-lg-3">
            <div class="card gudep-card shadow-sm h-100">
                <div class="position-relative">
                    <img src="{{ $gudep->hero_image ? asset('storage/' . $gudep->hero_image) : 'https://source.unsplash.com/random/400x200/?scout,school' }}" 
                         class="card-img-top" style="height: 140px; object-fit: cover;" alt="{{ $gudep->pangkalan_name }}">
                </div>
                <div class="card-body text-center pt-0">
                    @if($gudep->logo)
                        <img src="{{ asset('storage/' . $gudep->logo) }}" 
                             class="gudep-logo-sm" alt="Logo {{ $gudep->pangkalan_name }}">
                    @else
                        <div class="gudep-logo-sm d-flex align-items-center justify-content-center" 
                             style="background: linear-gradient(135deg, var(--primary-color, #198754), #0d6efd); color: white; font-size: 1.4rem; font-weight: bold;">
                            {{ strtoupper(substr($gudep->pangkalan_name, 0, 2)) }}
                        </div>
                    @endif
                    <h5 class="fw-bold mt-3 mb-1 text-dark">{{ $gudep->pangkalan_name }}</h5>
                    <span class="badge rounded-pill px-3 py-1 mb-2 d-inline-block" style="background-color: var(--primary-color, #4B2C20); color: #fff; font-size: 0.75rem;">Gudep {{ $gudep->gudep_number }}</span>
                    <p class="text-muted small mb-3"><i class="fas fa-map-marker-alt me-1 text-primary"></i> Bekasi Timur</p>
                    
                    <div class="d-flex justify-content-around mb-3">
                        <div class="text-center">
                            <small class="d-block text-muted">Putra</small>
                            <span class="fw-bold">{{ number_format($gudep->male_members_count) }}</span>
                        </div>
                        <div class="vr"></div>
                        <div class="text-center">
                            <small class="d-block text-muted">Putri</small>
                            <span class="fw-bold">{{ number_format($gudep->female_members_count) }}</span>
                        </div>
                    </div>
                    
                    <a href="{{ route('gudep.show', $gudep->slug) }}" class="btn btn-outline-primary btn-sm w-100 rounded-pill fw-bold">
                        Lihat Profil Profil <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5">
            <div class="opacity-50">
                <i class="fas fa-database fa-4x mb-3"></i>
                <h5>Belum ada data pangkalan yang terdaftar.</h5>
            </div>
        </div>
        @endforelse
    </div>
</div>
@endsection
