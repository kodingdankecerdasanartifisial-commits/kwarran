@extends('layouts.admin')

@section('page_title', 'Edit Agenda LPK')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="m-0 fw-bold">Edit Detail Agenda</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.lpk.agendas.update', $agenda->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label class="form-label fw-bold">Judul Agenda</label>
                        <input type="text" name="title" class="form-control" required value="{{ $agenda->title }}">
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Tanggal</label>
                            <input type="date" name="date" class="form-control" required value="{{ $agenda->date->format('Y-m-d') }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Waktu (Opsional)</label>
                            <input type="text" name="time" class="form-control" value="{{ $agenda->time }}">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Lokasi</label>
                        <input type="text" name="location" class="form-control" value="{{ $agenda->location }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Deskripsi / Detail</label>
                        <textarea name="description" class="form-control" rows="4">{{ $agenda->description }}</textarea>
                    </div>

                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="is_public" id="isPublic" {{ $agenda->is_public ? 'checked' : '' }}>
                            <label class="form-check-label fw-bold" for="isPublic">Tampilkan di Halaman Publik</label>
                        </div>
                    </div>

                    <hr>
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.lpk.agendas.index') }}" class="btn btn-secondary">Batal</a>
                        <button type="submit" class="btn btn-primary px-4">Update Agenda</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
