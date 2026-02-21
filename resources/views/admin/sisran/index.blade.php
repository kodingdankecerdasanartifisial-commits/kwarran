@extends('layouts.admin')

@section('page_title', 'SISRAN (Sistem Informasi Statistik Kwarran)')

@section('content')
<div class="row mb-4">
    <div class="col-md-8">
        <p class="text-muted">Kelola formulir publikasi data statistik potensi Kwarran. Anda bisa membuat form kustom, membagikan link ke operator, dan menampilkan hasilnya dalam bentuk grafik secara publik.</p>
    </div>
    <div class="col-md-4 text-end">
        <a href="{{ route('admin.sisran.create') }}" class="btn btn-primary shadow-sm rounded-pill px-4">
            <i class="fas fa-plus me-2"></i>Buat Form Baru
        </a>
    </div>
</div>

<div class="row">
    @forelse($forms as $form)
    <div class="col-md-6 col-lg-4 mb-4">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <span class="badge bg-secondary bg-opacity-10 text-secondary rounded-pill px-3">{{ $form->category ?: 'Tanpa Kategori' }}</span>
                    <div class="dropdown">
                        <button class="btn btn-link text-muted p-0" data-bs-toggle="dropdown">
                            <i class="fas fa-ellipsis-v"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end border-0 shadow-sm">
                            <li><a class="dropdown-item" href="{{ route('admin.sisran.edit', $form) }}"><i class="fas fa-edit me-2"></i>Edit Desain Form</a></li>
                            <li><a class="dropdown-item" href="{{ route('admin.sisran.entries', $form) }}"><i class="fas fa-list me-2"></i>Lihat Data Masuk</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('admin.sisran.destroy', $form) }}" method="POST" onsubmit="return confirm('Hapus form ini dan semua datanya?')">
                                    @csrf @method('DELETE')
                                    <button class="dropdown-item text-danger"><i class="fas fa-trash me-2"></i>Hapus Form</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
                <h5 class="fw-bold mb-2">{{ $form->title }}</h5>
                <p class="small text-muted mb-4">{{ Str::limit($form->description, 100) }}</p>
                
                <div class="bg-light p-3 rounded-3 mb-4">
                    <div class="row text-center">
                        <div class="col-6 border-end">
                            <h4 class="fw-bold mb-0">{{ $form->entries_count }}</h4>
                            <small class="text-muted">Total Input</small>
                        </div>
                        <div class="col-6">
                            <h4 class="fw-bold mb-0">{{ $form->fields_count }}</h4>
                            <small class="text-muted">Kolom Data</small>
                        </div>
                    </div>
                </div>

                <div class="d-grid gap-2">
                    <a href="{{ route('sisran.public.form', $form->slug) }}" target="_blank" class="btn btn-outline-primary btn-sm rounded-pill">
                        <i class="fas fa-external-link-alt me-2"></i>Link Form Operator
                    </a>
                    <a href="{{ route('sisran.public.result', $form->slug) }}" target="_blank" class="btn btn-success btn-sm rounded-pill">
                        <i class="fas fa-chart-pie me-2"></i>Lihat Hasil Grafik
                    </a>
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12 text-center py-5">
        <div class="mb-3 text-muted">
            <i class="fas fa-folder-open fa-3x"></i>
        </div>
        <h5>Belum Ada Form SISRAN</h5>
        <p class="text-muted">Klik tombol "Buat Form Baru" untuk mulai mengumpulkan data statistik.</p>
    </div>
    @endforelse
</div>
@endsection
