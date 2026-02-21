@extends('layouts.admin')

@section('page_title', 'Edit Statistik')

@section('content')
<div class="card">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h5 class="m-0 fw-bold">Edit Detail Statistik</h5>
        <a href="{{ route('admin.statistics.index') }}" class="btn btn-secondary btn-sm rounded-pill">Kembali</a>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.statistics.update', $statistic->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Judul Statistik</label>
                        <input type="text" name="title" class="form-control" value="{{ $statistic->title }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Keterangan / Deskripsi</label>
                        <textarea name="description" class="form-control" rows="6">{{ $statistic->description }}</textarea>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Status Publikasi</label>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="is_published" value="1" id="publishCheck" {{ $statistic->is_published ? 'checked' : '' }}>
                            <label class="form-check-label" for="publishCheck">Tampilkan di Publik</label>
                        </div>
                    </div>
                    <div class="bg-light p-3 rounded-3 border">
                        <h6 class="fw-bold mb-2"><i class="fas fa-info-circle me-1"></i> Informasi</h6>
                        <ul class="small text-muted mb-0">
                            <li>Link Publik: <a href="{{ route('statistics.public.show', $statistic->slug) }}" target="_blank">{{ route('statistics.public.show', $statistic->slug) }}</a></li>
                            <li>Dibuat pada: {{ $statistic->created_at->format('d/m/Y H:i') }}</li>
                            <li>Terakhir update: {{ $statistic->updated_at->format('d/m/Y H:i') }}</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="d-grid mt-4">
                <button type="submit" class="btn btn-primary rounded-pill">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
@endsection
