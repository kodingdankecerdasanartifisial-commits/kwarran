@extends('layouts.admin')

@section('page_title', 'Tambah Spanduk Digital')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="m-0 fw-bold">Form Spanduk Digital</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.digital-banners.store') }}" method="POST" enctype="multipart/form-data" id="bannerForm">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-bold">Judul (Opsional)</label>
                        <input type="text" name="title" class="form-control" value="{{ old('title') }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Gambar / GIF</label>
                        <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" accept="image/*">
                        <div class="form-text text-danger mt-1">Format: JPG, PNG, GIF. Ukuran ideal: Lebar sama dengan slider, Tinggi 1/4 slider.</div>
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Link (Opsional)</label>
                        <input type="url" name="link" class="form-control" value="{{ old('link') }}" placeholder="https://example.com">
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Urutan</label>
                                <input type="number" name="order" class="form-control" value="{{ old('order', 0) }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold d-block">Status</label>
                                <div class="form-check form-switch mt-2">
                                    <input class="form-check-input" type="checkbox" name="is_active" id="is_active" checked>
                                    <label class="form-check-label" for="is_active">Aktif</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary px-4">Simpan</button>
                        <a href="{{ route('admin.digital-banners.index') }}" class="btn btn-outline-secondary px-4">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
