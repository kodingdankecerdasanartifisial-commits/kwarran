@extends('layouts.public')

@section('title', 'Struktur Organisasi - Kwarran Bekasi Timur')

@section('content')
<div class="container py-5">
    <div class="text-center mb-5">
        <h1 class="fw-bold">Struktur Organisasi</h1>
        <p class="text-muted">Susunan kepengurusan Kwartir Ranting Gerakan Pramuka Bekasi Timur</p>
        <div class="border-bottom border-warning border-4 w-25 mx-auto mt-3"></div>
    </div>

    <div class="row g-4 justify-content-center">
        @forelse($members as $member)
        <div class="col-6 col-md-4 col-lg-3">
            <div class="org-card text-center p-4 border-0 shadow-sm rounded-4 h-100 transition">
                <div class="member-photo mx-auto mb-3 position-relative">
                    @if($member->photo)
                        <img src="{{ asset('storage/' . $member->photo) }}" class="rounded-circle object-fit-cover shadow img-fluid" style="width: 120px; height: 120px; max-width: 100%;">
                    @else
                        <div class="bg-light rounded-circle mx-auto d-flex align-items-center justify-content-center shadow" style="width: 120px; height: 120px;">
                            <i class="fas fa-user fa-3x text-muted opacity-25"></i>
                        </div>
                    @endif
                </div>
                <h5 class="fw-bold mb-2">{{ $member->name }}</h5>
                <div class="badge bg-primary-subtle text-primary rounded-pill px-3 py-2 text-wrap w-100" style="font-weight: 500; font-size: 0.85rem; line-height: 1.4;">
                    {{ $member->position }}
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5">
            <p class="text-muted">Data struktur organisasi belum tersedia.</p>
        </div>
        @endforelse
    </div>
</div>

<style>
.org-card {
    background: white;
    transition: all 0.3s ease;
}
.org-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 1rem 3rem rgba(0,0,0,0.1) !important;
}
.member-photo img {
    border: 5px solid white;
}
.transition {
    transition: all 0.3s ease;
}
</style>
@endsection
