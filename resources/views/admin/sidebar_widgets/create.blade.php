@extends('layouts.admin')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Tambah Widget</h5>
    </div>
    <div class="card-body">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.sidebar-widgets.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="form-label">Nama (internal)</label>
                <input type="text" name="name" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Judul (tampil)</label>
                <input type="text" name="title" class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label">Tipe</label>
                <select name="type" class="form-select" required>
                    <option value="agenda">Agenda</option>
                    <option value="popular">Popular Posts</option>
                    <option value="visitor">Statistik Pengunjung</option>
                    <option value="html">Custom HTML</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Konten (untuk HTML)</label>
                <textarea name="content" class="form-control" rows="4"></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">URL (opsional)</label>
                <input type="url" name="url" class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label">Urutan (Order)</label>
                <input type="number" name="order" class="form-control" value="0">
            </div>

            <div class="mb-3 form-check">
                <input type="checkbox" name="is_active" class="form-check-input" id="is_active" checked>
                <label class="form-check-label" for="is_active">Aktif</label>
            </div>

            <button class="btn btn-primary">Simpan</button>
        </form>
    </div>
</div>
@endsection
