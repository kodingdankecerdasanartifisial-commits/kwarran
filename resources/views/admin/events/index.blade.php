@extends('layouts.admin')

@section('page_title', 'Kelola Agenda')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h5 class="m-0 fw-bold">Daftar Agenda</h5>
                <a href="{{ route('admin.events.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus me-1"></i> Tambah Agenda
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th width="150">Tanggal</th>
                                <th>Judul Agenda</th>
                                <th>Lokasi</th>
                                <th width="100">Status</th>
                                <th width="150">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($events as $event)
                            <tr>
                                <td>
                                    <div class="fw-bold text-primary">{{ $event->event_date->format('d M Y') }}</div>
                                </td>
                                <td>
                                    <div class="fw-bold">{{ $event->title }}</div>
                                    @if($event->description)
                                        <small class="text-muted d-block text-truncate" style="max-width: 300px;">{{ strip_tags($event->description) }}</small>
                                    @endif
                                </td>
                                <td>
                                    <small><i class="fas fa-map-marker-alt text-danger me-1"></i> {{ $event->location ?? '-' }}</small>
                                </td>
                                <td>
                                    @if($event->is_active)
                                        <span class="badge bg-success">Aktif</span>
                                    @else
                                        <span class="badge bg-danger">Non-aktif</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('admin.events.edit', $event->id) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.events.destroy', $event->id) }}" method="POST" onsubmit="return confirm('Hapus agenda ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">Belum ada agenda ditambahkan.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                    {{ $events->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
