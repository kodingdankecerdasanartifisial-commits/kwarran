@extends('layouts.admin')

@section('page_title', 'Edit Spanduk Digital')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="m-0 fw-bold">Edit Form Spanduk Digital</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.digital-banners.update', $digitalBanner->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label class="form-label fw-bold">Judul (Opsional)</label>
                        <input type="text" name="title" class="form-control" value="{{ old('title', $digitalBanner->title) }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Gambar / GIF Sekarang</label>
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $digitalBanner->image) }}" class="rounded border shadow-sm" width="200">
                        </div>
                        <label class="form-label fw-bold">Ganti Gambar / GIF</label>
                        <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" accept="image/*">
                        <div class="form-text mt-1">Kosongkan jika tidak ingin mengganti gambar. Format: JPG, PNG, GIF.</div>
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Link (Opsional)</label>
                        <input type="url" name="link" class="form-control" value="{{ old('link', $digitalBanner->link) }}" placeholder="https://example.com">
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Urutan</label>
                                <input type="number" name="order" class="form-control" value="{{ old('order', $digitalBanner->order) }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold d-block">Status</label>
                                <div class="form-check form-switch mt-2">
                                    <input class="form-check-input" type="checkbox" name="is_active" id="is_active" {{ $digitalBanner->is_active ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_active">Aktif</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary px-4">Update</button>
                        <a href="{{ route('admin.digital-banners.index') }}" class="btn btn-outline-secondary px-4">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
