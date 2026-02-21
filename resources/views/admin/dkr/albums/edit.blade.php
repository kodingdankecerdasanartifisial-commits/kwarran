@extends('layouts.admin')

@section('page_title', 'Edit Album DKR')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-12">
        <form action="{{ route('admin.dkr.albums.update', $album->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="row">
                <div class="col-lg-4">
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-white"><h5 class="m-0 fw-bold">Detail Album</h5></div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Nama Album</label>
                                <input type="text" name="name" class="form-control" value="{{ $album->name }}" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Deskripsi</label>
                                <textarea name="description" class="form-control" rows="3">{{ $album->description }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Ubah Sampul (Cover)</label>
                                @if($album->cover_image)
                                    <div class="mb-2"><img src="{{ asset('storage/' . $album->cover_image) }}" class="img-fluid rounded border shadow-sm"></div>
                                @endif
                                <input type="file" name="cover_image" class="form-control" accept="image/*">
                            </div>
                            <div class="d-grid gap-2 mt-4">
                                <button type="submit" class="btn btn-primary">SIMPAN PERUBAHAN</button>
                                <a href="{{ route('admin.dkr.albums.index') }}" class="btn btn-outline-secondary">Kembali</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-8">
                    <div class="card shadow-sm">
                        <div class="card-header bg-white d-flex justify-content-between align-items-center">
                            <h5 class="m-0 fw-bold">Kelola Foto ({{ $album->photos->count() }})</h5>
                            <button type="button" class="btn btn-sm btn-outline-primary" onclick="addPhotoInput()">+ Tambah Foto Baru</button>
                        </div>
                        <div class="card-body">
                            <h6 class="text-muted small mb-3">FOTO YANG SUDAH ADA</h6>
                            <div class="row g-3" id="existing-photos-container">
                                @foreach($album->photos as $photo)
                                <div class="col-md-6" id="photo-card-{{ $photo->id }}">
                                    <div class="card h-100 border shadow-none">
                                        <div class="position-relative">
                                            <img src="{{ asset('storage/' . $photo->image) }}" class="card-img-top" style="height: 150px; object-fit: cover;">
                                            <div class="position-absolute top-0 end-0 m-2">
                                                <div class="form-check bg-white rounded px-2 py-1 shadow-sm border border-danger">
                                                    <input class="form-check-input" type="checkbox" name="delete_photos[]" value="{{ $photo->id }}" id="del-{{ $photo->id }}">
                                                    <label class="form-check-label text-danger fw-bold small" for="del-{{ $photo->id }}"> HAPUS</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body p-2">
                                            <input type="text" name="existing_photos[{{ $photo->id }}][caption]" class="form-control form-control-sm" value="{{ $photo->caption }}" placeholder="Caption...">
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>

                            <hr class="my-4">
                            <div class="mb-4 p-4 border-2 border-dashed rounded-4 text-center bg-light">
                                <i class="fas fa-cloud-upload-alt fa-2x text-primary mb-2"></i>
                                <h6 class="fw-bold">Tambah Banyak Foto Sekaligus</h6>
                                <input type="file" name="bulk_photos[]" class="form-control form-control-sm" multiple accept="image/*">
                            </div>

                            <h6 class="text-primary fw-bold mb-3"><i class="fas fa-plus-circle me-1"></i> TAMBAH FOTO MANUAL</h6>
                            <div id="new-photos-container">
                                <!-- Inputs will be added here -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    let rowCount = 0;
    function addPhotoInput() {
        const container = document.getElementById('new-photos-container');
        const html = `
            <div class="row g-2 mb-3 photo-input-row border p-2 rounded bg-light" id="row-${rowCount}">
                <div class="col-md-5">
                    <input type="file" name="new_photos[]" class="form-control form-control-sm" accept="image/*" required>
                </div>
                <div class="col-md-6">
                    <input type="text" name="new_captions[]" class="form-control form-control-sm" placeholder="Keterangan foto baru">
                </div>
                <div class="col-md-1 text-end">
                    <button type="button" class="btn btn-sm btn-danger w-100" onclick="removeRow(${rowCount})"><i class="fas fa-times"></i></button>
                </div>
            </div>
        `;
        container.insertAdjacentHTML('beforeend', html);
        rowCount++;
    }

    function removeRow(id) {
        document.getElementById(`row-${id}`).remove();
    }
</script>
@endsection
