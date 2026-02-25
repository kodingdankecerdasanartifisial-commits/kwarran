@extends('layouts.admin')

@section('page_title', 'Agenda Kegiatan LPK')

@section('content')
<div class="card">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h5 class="m-0 fw-bold">Daftar Agenda LPK</h5>
        <a href="{{ route('admin.lpk.agendas.create') }}" class="btn btn-primary btn-sm">+ Tambah Agenda</a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Agenda</th>
                        <th>Lokasi</th>
                        <th>Status</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($agendas as $agenda)
                    <tr>
                        <td>{{ $agenda->date->format('d/m/Y') }} @if($agenda->time)<br><small class="text-muted">{{ $agenda->time }}</small>@endif</td>
                        <td>
                            <div class="fw-bold">{{ $agenda->title }}</div>
                            <small class="text-muted">{{ Str::limit($agenda->description, 50) }}</small>
                        </td>
                        <td>{{ $agenda->location ?: '-' }}</td>
                        <td>
                            @if($agenda->is_public)
                                <span class="badge bg-success">Publik</span>
                            @else
                                <span class="badge bg-secondary">Internal</span>
                            @endif
                        </td>
                        <td class="text-end">
                            <div class="btn-group">
                                <a href="{{ route('admin.lpk.agendas.edit', $agenda->id) }}" class="btn btn-sm btn-outline-primary"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('admin.lpk.agendas.destroy', $agenda->id) }}" method="POST" onsubmit="return confirm('Hapus agenda ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-4 text-muted">Belum ada agenda kegiatan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3">
            {{ $agendas->links() }}
        </div>
    </div>
</div>
@endsection
