@extends('layouts.admin')

@section('page_title', 'Tambah Galeri')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-white p-4">
                <h5 class="m-0 fw-bold">Tambah Koleksi Baru</h5>
            </div>
            <div class="card-body p-4">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form action="{{ route('admin.gallery.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="mb-4">
                        <label class="form-label fw-bold">Tipe Galeri</label>
                        <div class="d-flex gap-3">
                            <div class="form-check custom-option">
                                <input class="form-check-input" type="radio" name="type" id="typePhoto" value="photo" checked onclick="toggleFields('photo')">
                                <label class="form-check-label" for="typePhoto">
                                    <i class="fas fa-camera me-1"></i> Foto
                                </label>
                            </div>
                            <div class="form-check custom-option">
                                <input class="form-check-input" type="radio" name="type" id="typeVideo" value="video" onclick="toggleFields('video')">
                                <label class="form-check-label" for="typeVideo">
                                    <i class="fas fa-video me-1"></i> Video YouTube
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Judul/Nama Kegiatan</label>
                        <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" required placeholder="Contoh: Jambore Ranting 2025">
                        @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div id="photoFields">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Pilih Metode:</label>
                            <div class="card bg-light border-0">
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold small">1. Upload File Langsung (Bisa banyak)</label>
                                        <input type="file" name="images[]" class="form-control @error('images.*') is-invalid @enderror" multiple accept="image/*">
                                        <small class="text-muted">Gunakan ini jika ingin menyimpan foto di server.</small>
                                    </div>
                                    <div class="text-center my-2"><span class="badge bg-secondary">ATAU</span></div>
                                    <div class="mb-0">
                                        <label class="form-label fw-semibold small">2. Link Google Drive / Album Luar + Cover</label>
                                        <input type="url" name="external_link" class="form-control mb-2" value="{{ old('external_link') }}" placeholder="https://photos.google.com/share/...">
                                        <input type="file" name="image" class="form-control" accept="image/*">
                                        <small class="text-muted text-xs">Masukkan link album dan unggah 1 foto sebagai sampul (cover).</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="videoFields" style="display: none;">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Link YouTube / ID Video</label>
                            <input type="text" name="external_link_video" class="form-control" placeholder="Contoh: https://www.youtube.com/watch?v=xxxxxx">
                            <small class="text-muted">Masukkan URL lengkap atau cukup ID videonya saja.</small>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold">Keterangan (Opsional)</label>
                        <textarea name="description" class="form-control" rows="3"></textarea>
                    </div>

                    <div class="d-flex justify-content-between pt-3 border-top">
                        <a href="{{ route('admin.gallery.index') }}" class="btn btn-secondary rounded-pill px-4">Batal</a>
                        <button type="submit" class="btn btn-primary rounded-pill px-4">Simpan Galeri</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function toggleFields(type) {
    const photoFields = document.getElementById('photoFields');
    const videoFields = document.getElementById('videoFields');
    const extLink = document.querySelector('input[name="external_link"]');
    const extLinkVideo = document.querySelector('input[name="external_link_video"]');

    if (type === 'photo') {
        photoFields.style.display = 'block';
        videoFields.style.display = 'none';
        extLinkVideo.name = 'unused';
        extLink.name = 'external_link';
    } else {
        photoFields.style.display = 'none';
        videoFields.style.display = 'block';
        extLink.name = 'unused';
        extLinkVideo.name = 'external_link';
    }
}
</script>
@endsection
