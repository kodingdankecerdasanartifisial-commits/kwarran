@extends('layouts.admin')

@section('page_title', 'Buat Album DKR')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="card shadow-sm">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h5 class="m-0 fw-bold">Buat Album Galeri Baru</h5>
                <a href="{{ route('admin.dkr.albums.index') }}" class="btn btn-sm btn-outline-secondary">Kembali</a>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.dkr.albums.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Nama Album</label>
                                <input type="text" name="name" class="form-control" placeholder="Contoh: Sidang Paripurna Ranting 2025" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Deskripsi Singkat</label>
                                <textarea name="description" class="form-control" rows="2" placeholder="Keterangan mengenai album ini..."></textarea>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Foto Sampul (Cover)</label>
                                <input type="file" name="cover_image" class="form-control" accept="image/*">
                                <small class="text-muted">Foto utama yang muncul di depan.</small>
                            </div>
                        </div>
                    </div>

                    <hr class="my-4">

                    <div class="mb-4 p-4 border-2 border-dashed rounded-4 text-center bg-light">
                        <i class="fas fa-cloud-upload-alt fa-3x text-primary mb-3"></i>
                        <h6 class="fw-bold">Upload Foto Album Sekaligus</h6>
                        <p class="text-muted small">Pilih banyak foto sekaligus dari galeri Anda</p>
                        <input type="file" name="bulk_photos[]" class="form-control" multiple accept="image/*">
                        <div class="form-text mt-2">Anda bisa menahan tombol <kbd>Ctrl</kbd> atau <kbd>Shift</kbd> untuk memilih banyak foto.</div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="fw-bold m-0"><i class="fas fa-images me-1"></i> Input Foto Manual (Dengan Caption)</h6>
                        <button type="button" class="btn btn-sm btn-outline-primary" onclick="addPhotoInput()">+ Tambah Baris Manual</button>
                    </div>

                    <div id="photo-inputs-container">
                        <!-- Individual rows will be added here -->
                    </div>

                    <div class="alert alert-info small d-flex align-items-center gap-2">
                        <i class="fas fa-info-circle"></i>
                        Semua foto yang diupload akan otomatis dikompress oleh sistem untuk menjaga performa website.
                    </div>

                    <div class="d-grid mt-4">
                        <button type="submit" class="btn btn-primary btn-lg shadow-sm">SIMPAN ALBUM & FOTO</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    let rowCount = 1;
    function addPhotoInput() {
        const container = document.getElementById('photo-inputs-container');
        const html = `
            <div class="row g-2 mb-3 photo-input-row border p-2 rounded bg-light" id="row-${rowCount}">
                <div class="col-md-5">
                    <input type="file" name="photos[]" class="form-control form-control-sm" accept="image/*" required>
                </div>
                <div class="col-md-6">
                    <input type="text" name="captions[]" class="form-control form-control-sm" placeholder="Keterangan foto (opsional)">
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
