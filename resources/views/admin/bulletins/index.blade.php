@extends('layouts.admin')

@section('page_title', 'Kelola Buletin')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h5 class="m-0 fw-bold">Daftar Buletin</h5>
                <a href="{{ route('admin.bulletins.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus me-1"></i> Tambah Buletin
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Judul</th>
                                <th>Embed Link (Canva)</th>
                                <th width="100">Urutan</th>
                                <th width="100">Status</th>
                                <th width="150">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($bulletins as $bulletin)
                            <tr>
                                <td>
                                    <div class="fw-bold">{{ $bulletin->title }}</div>
                                    <small class="text-muted">{{ $bulletin->slug }}</small>
                                </td>
                                <td>
                                    <div class="text-truncate" style="max-width: 300px;">
                                        <a href="{{ $bulletin->embed_link }}" target="_blank" class="text-decoration-none">
                                            {{ $bulletin->embed_link }}
                                        </a>
                                    </div>
                                </td>
                                <td>{{ $bulletin->order }}</td>
                                <td>
                                    @if($bulletin->is_active)
                                        <span class="badge bg-success">Aktif</span>
                                    @else
                                        <span class="badge bg-danger">Non-aktif</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('bulletins.public') }}" class="btn btn-sm btn-outline-info" target="_blank" title="Lihat Publik">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.bulletins.edit', $bulletin->id) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.bulletins.destroy', $bulletin->id) }}" method="POST" onsubmit="return confirm('Hapus buletin ini?')">
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
                                <td colspan="5" class="text-center py-4 text-muted">Belum ada buletin ditambahkan.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
