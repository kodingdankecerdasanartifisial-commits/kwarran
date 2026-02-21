@extends('layouts.admin')

@section('page_title', 'Edit Form SISRAN: ' . $sisran->title)

@section('content')
<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-4">
        <form action="{{ route('admin.sisran.update', $sisran) }}" method="POST" id="sisranForm">
            @csrf
            @method('PUT')
            
            <div class="row mb-4">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Judul Statistik</label>
                    <input type="text" name="title" class="form-control" value="{{ $sisran->title }}" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Kategori / Label</label>
                    <input type="text" name="category" class="form-control" value="{{ $sisran->category }}">
                </div>
                <div class="col-12">
                    <label class="form-label fw-bold">Deskripsi Singkat</label>
                    <textarea name="description" class="form-control" rows="2">{{ $sisran->description }}</textarea>
                </div>
            </div>

            <hr class="my-4">

            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="fw-bold m-0"><i class="fas fa-list me-2 text-primary"></i>Daftar Kolom Data (Fields)</h5>
                <button type="button" class="btn btn-sm btn-outline-primary rounded-pill" id="addField">
                    <i class="fas fa-plus me-1"></i>Tambah Kolom
                </button>
            </div>

            <div id="fieldsContainer">
                @foreach($sisran->fields as $index => $field)
                <div class="field-row bg-light p-3 rounded-3 mb-3 position-relative">
                    <input type="hidden" name="fields[{{ $index }}][id]" value="{{ $field->id }}">
                    <button type="button" class="btn-close position-absolute top-0 end-0 m-2 remove-field" style="font-size: 0.7rem;"></button>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="small fw-bold">Nama Kolom (Label)</label>
                            <input type="text" name="fields[{{ $index }}][label]" class="form-control form-control-sm" value="{{ $field->label }}" required>
                        </div>
                        <div class="col-md-3">
                            <label class="small fw-bold">Tipe Data</label>
                            <select name="fields[{{ $index }}][type]" class="form-select form-select-sm">
                                <option value="number" {{ $field->type == 'number' ? 'selected' : '' }}>Angka (Statistik)</option>
                                <option value="text" {{ $field->type == 'text' ? 'selected' : '' }}>Teks Singkat</option>
                                <option value="select" {{ $field->type == 'select' ? 'selected' : '' }}>Pilihan (Dropdown)</option>
                                <option value="radio" {{ $field->type == 'radio' ? 'selected' : '' }}>Pilihan Tunggal (Radio)</option>
                                <option value="checkbox" {{ $field->type == 'checkbox' ? 'selected' : '' }}>Pilihan Banyak (Checklist)</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="small fw-bold">Opsi (Pisahkan koma)</label>
                            <input type="text" name="fields[{{ $index }}][options]" class="form-control form-control-sm" value="{{ $field->options }}">
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="text-end mt-4">
                <a href="{{ route('admin.sisran.index') }}" class="btn btn-light rounded-pill px-4 me-2">Batal</a>
                <button type="submit" class="btn btn-primary rounded-pill px-5 shadow-sm">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    let fieldCount = {{ $sisran->fields->count() }};
    document.getElementById('addField').addEventListener('click', function() {
        const container = document.getElementById('fieldsContainer');
        const newField = document.createElement('div');
        newField.className = 'field-row bg-light p-3 rounded-3 mb-3 position-relative';
        newField.innerHTML = `
            <button type="button" class="btn-close position-absolute top-0 end-0 m-2 remove-field" style="font-size: 0.7rem;"></button>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="small fw-bold">Nama Kolom (Label)</label>
                    <input type="text" name="fields[${fieldCount}][label]" class="form-control form-control-sm" required>
                </div>
                <div class="col-md-3">
                    <label class="small fw-bold">Tipe Data</label>
                    <select name="fields[${fieldCount}][type]" class="form-select form-select-sm">
                        <option value="number">Angka (Statistik)</option>
                        <option value="text">Teks Singkat</option>
                        <option value="select">Pilihan (Dropdown)</option>
                        <option value="radio">Pilihan Tunggal (Radio)</option>
                        <option value="checkbox">Pilihan Banyak (Checklist)</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="small fw-bold">Opsi (Pisahkan koma)</label>
                    <input type="text" name="fields[${fieldCount}][options]" class="form-control form-control-sm">
                </div>
            </div>
        `;
        container.appendChild(newField);
        fieldCount++;
    });

    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-field')) {
            e.target.closest('.field-row').remove();
        }
    });
</script>
@endpush
@endsection
