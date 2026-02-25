@extends('layouts.admin')

@section('page_title', 'Tambah Buletin Baru')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-body p-4">
                <form action="{{ route('admin.bulletins.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-4">
                        <label for="title" class="form-label fw-bold">Judul Buletin <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}" placeholder="Contoh: Buletin Edisi Januari 2024" required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="cover_image" class="form-label fw-bold">Cover Buletin</label>
                        <input type="file" class="form-control @error('cover_image') is-invalid @enderror" id="cover_image" name="cover_image" accept="image/*">
                        <div class="form-text mt-2">
                             <i class="fas fa-info-circle me-1"></i> Upload gambar untuk tampilan cover di halaman publik. (Optional)
                        </div>
                        @error('cover_image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="embed_link" class="form-label fw-bold">Link Embed Canva <span class="text-danger">*</span></label>
                        <input type="url" class="form-control @error('embed_link') is-invalid @enderror" id="embed_link" name="embed_link" value="{{ old('embed_link') }}" placeholder="https://www.canva.com/design/.../view?..." required>
                        <div class="form-text mt-2">
                             <i class="fas fa-info-circle me-1"></i> Masukkan link dari Canva (bisa link view atau link embed).
                        </div>
                        @error('embed_link')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-4">
                                <label for="order" class="form-label fw-bold">Urutan Tampil</label>
                                <input type="number" class="form-control @error('order') is-invalid @enderror" id="order" name="order" value="{{ old('order', 0) }}">
                                @error('order')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-4">
                                <label class="form-label fw-bold d-block">Status</label>
                                <div class="form-check form-switch mt-2">
                                    <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" checked>
                                    <label class="form-check-label" for="is_active">Aktifkan Buletin</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr class="my-4">

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.bulletins.index') }}" class="btn btn-outline-secondary px-4">Batal</a>
                        <button type="submit" class="btn btn-primary px-5">Simpan Buletin</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
