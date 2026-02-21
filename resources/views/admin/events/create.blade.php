@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold">Tambah Agenda Baru</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.events.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Judul Agenda</label>
                            <input type="text" name="title" class="form-control" required>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Tanggal</label>
                                <input type="date" name="event_date" class="form-control" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Tanggal Akhir (Opsional)</label>
                                <input type="date" name="end_date" class="form-control">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Waktu Mulai</label>
                                <input type="time" name="start_time" class="form-control">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Waktu Selesai</label>
                                <input type="time" name="end_time" class="form-control">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Lokasi</label>
                            <input type="text" name="location" class="form-control" placeholder="Contoh: Sanggar Bakti Pramuka">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Warna Label</label>
                            <div class="d-flex align-items-center">
                                <input type="color" name="color" class="form-control form-control-color me-2" value="#4B2C20" title="Pilih warna agenda">
                                <small class="text-muted">Pilih warna untuk tampilan di kalender.</small>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Deskripsi</label>
                            <textarea name="description" rows="4" class="form-control"></textarea>
                        </div>

                        <div class="mb-3 form-check">
                            <input type="checkbox" name="is_active" class="form-check-input" id="isActive" checked>
                            <label class="form-check-label" for="isActive">Aktifkan Agenda</label>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary fw-bold">Simpan Agenda</button>
                            <a href="{{ route('admin.events.index') }}" class="btn btn-light">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
