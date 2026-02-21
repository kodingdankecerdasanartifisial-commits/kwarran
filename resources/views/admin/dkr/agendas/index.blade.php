@extends('layouts.admin')

@section('page_title', 'Agenda Kerja DKR')

@section('content')
<div class="row">
    <div class="col-lg-4">
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-white"><h5 class="m-0 fw-bold">Tambah Agenda Baru</h5></div>
            <div class="card-body">
                <form action="{{ route('admin.dkr.agendas.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-bold small">Judul Agenda</label>
                        <input type="text" name="title" class="form-control" placeholder="Contoh: Rapat Kerja Cabang" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small">Tanggal</label>
                        <input type="date" name="date" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small">Waktu (Opsional)</label>
                        <input type="text" name="time" class="form-control" placeholder="Jam 08:00 - Selesai">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small">Lokasi</label>
                        <input type="text" name="location" class="form-control" placeholder="Gedung Kwarcab">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small">Keterangan</label>
                        <textarea name="description" class="form-control" rows="3" placeholder="Detail kegiatan..."></textarea>
                    </div>
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> SIMPAN AGENDA</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="card shadow-sm">
            <div class="card-header bg-white"><h5 class="m-0 fw-bold">Daftar Agenda Kerja</h5></div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">Tanggal</th>
                                <th>Agenda</th>
                                <th>Lokasi</th>
                                <th class="text-end pe-4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($agendas as $agenda)
                            <tr>
                                <td class="ps-4">
                                    <div class="fw-bold">{{ $agenda->date->format('d/m/Y') }}</div>
                                    <small class="text-muted">{{ $agenda->time }}</small>
                                </td>
                                <td>
                                    <div class="fw-bold text-dark">{{ $agenda->title }}</div>
                                    <small class="text-muted">{{ Str::limit($agenda->description, 50) }}</small>
                                </td>
                                <td>{{ $agenda->location }}</td>
                                <td class="text-end pe-4">
                                    <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editModal{{ $agenda->id }}"><i class="fas fa-edit"></i></button>
                                    <form action="{{ route('admin.dkr.agendas.destroy', $agenda->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus agenda ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                                    </form>

                                    <!-- Edit Modal -->
                                    <div class="modal fade" id="editModal{{ $agenda->id }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog text-start">
                                            <div class="modal-content">
                                                <form action="{{ route('admin.dkr.agendas.update', $agenda->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-header">
                                                        <h5 class="modal-title fw-bold">Edit Agenda</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label class="form-label fw-bold small">Judul Agenda</label>
                                                            <input type="text" name="title" class="form-control" value="{{ $agenda->title }}" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label fw-bold small">Tanggal</label>
                                                            <input type="date" name="date" class="form-control" value="{{ $agenda->date->format('Y-m-d') }}" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label fw-bold small">Waktu</label>
                                                            <input type="text" name="time" class="form-control" value="{{ $agenda->time }}">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label fw-bold small">Lokasi</label>
                                                            <input type="text" name="location" class="form-control" value="{{ $agenda->location }}">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label fw-bold small">Keterangan</label>
                                                            <textarea name="description" class="form-control" rows="3">{{ $agenda->description }}</textarea>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center py-5 text-muted">Belum ada agenda kerja.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer bg-white">
                {{ $agendas->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
