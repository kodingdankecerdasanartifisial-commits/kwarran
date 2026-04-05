@extends('layouts.public')

@section('title', 'Struktur Organisasi - Kwarran Bekasi Timur')

@section('content')
<div class="py-4">
    <div class="text-center mb-5">
        <h1 class="fw-bold">Struktur Organisasi</h1>
        <p class="text-muted">Susunan kepengurusan Kwartir Ranting Gerakan Pramuka Bekasi Timur</p>
        <div class="border-bottom border-warning border-4 w-25 mx-auto mt-3"></div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-10">
            @forelse($members as $member)
            <div class="org-list-item card border-0 shadow-sm rounded-4 mb-3 overflow-hidden transition">
                <div class="card-body p-3">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <div class="member-photo-list">
                                <img src="{{ $member->photo_url }}" class="rounded-circle object-fit-cover shadow-sm border border-2 border-white" style="width: 70px; height: 70px;" alt="{{ $member->name }}">
                            </div>
                        </div>
                        <div class="col">
                            <h5 class="fw-bold mb-1 text-dark">{{ $member->name }}</h5>
                            <div class="text-primary fw-medium small mb-0">
                                <i class="fas fa-id-badge me-1"></i> {{ $member->position }}
                            </div>
                        </div>
                        <div class="col-auto d-none d-md-block">
                             <div class="badge bg-light text-muted rounded-pill px-3 py-2 border">
                                Pengurus Kwarran
                             </div>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="text-center py-5">
                <p class="text-muted">Data struktur organisasi belum tersedia.</p>
            </div>
            @endforelse
        </div>
    </div>
</div>

<style>
.org-list-item {
    background: white;
    transition: all 0.3s ease;
    border-left: 5px solid var(--primary-color) !important;
}
.org-list-item:hover {
    transform: translateX(8px);
    box-shadow: 0 0.5rem 1.5rem rgba(0,0,0,0.1) !important;
    border-left-color: var(--secondary-color) !important;
}
.transition {
    transition: all 0.3s ease;
}
</style>
@endsection
