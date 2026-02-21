@extends('layouts.admin')

@section('page_title', 'Visualisasi Data SISRAN')

@section('content')
<div class="row mb-4">
    <div class="col">
        <p class="text-muted">Pilih formulir untuk mengatur bagaimana data statistik akan ditampilkan secara publik (grafik batang, lingkaran, dll).</p>
    </div>
</div>

<div class="row">
    @forelse($forms as $form)
    <div class="col-md-6 mb-4">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-body p-4 d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="fw-bold mb-1">{{ $form->title }}</h5>
                    <p class="small text-muted mb-0">{{ $form->entries_count }} Laporan Masuk • {{ $form->category }}</p>
                </div>
                <a href="{{ route('admin.sisran.visualize.show', $form) }}" class="btn btn-primary rounded-pill px-4">
                    Atur Grafik<i class="fas fa-chevron-right ms-2"></i>
                </a>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12 text-center py-5">
        <h5>Belum Ada Form SISRAN</h5>
    </div>
    @endforelse
</div>
@endsection
