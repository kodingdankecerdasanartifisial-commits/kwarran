@extends('layouts.public')

@section('title', 'Indeks Statistik - Kwarran Bekasi Timur')

@section('content')
<div class="container py-5">
    <div class="text-center mb-5">
        <h1 class="fw-bold">Pusat Data & Statistik</h1>
        <p class="text-muted">Kumpulan visualisasi data dan laporan statistik Kwarran Bekasi Timur</p>
        <div class="border-bottom border-warning border-4 w-25 mx-auto mt-3"></div>
    </div>

    <div class="row g-4">
        @forelse($statistics as $item)
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 border-0 shadow-sm rounded-4 hover-lift transition">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-primary bg-opacity-10 p-3 rounded-3 me-3">
                            <i class="fas fa-chart-pie text-primary fs-4"></i>
                        </div>
                        <h5 class="fw-bold m-0">{{ $item->title }}</h5>
                    </div>
                    <p class="text-muted small mb-4">
                        {{ \Illuminate\Support\Str::limit($item->description, 100) }}
                    </p>
                    <div class="d-flex justify-content-between align-items-center mt-auto">
                        <span class="small text-muted"><i class="far fa-calendar-alt me-1"></i> {{ $item->created_at->format('M Y') }}</span>
                        <a href="{{ route('statistics.public.show', $item->slug) }}" class="btn btn-primary btn-sm rounded-pill px-4">Lihat Detail</a>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5">
            <p class="text-muted">Belum ada data statistik publik yang tersedia saat ini.</p>
        </div>
        @endforelse
    </div>
</div>

<style>
.hover-lift:hover {
    transform: translateY(-5px);
    box-shadow: 0 1rem 3rem rgba(0,0,0,0.1) !important;
}
.transition {
    transition: all 0.3s ease;
}
</style>
@endsection
