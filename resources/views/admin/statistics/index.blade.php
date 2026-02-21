@extends('layouts.admin')

@section('page_title', 'Manajemen Statistik')

@section('content')
<div class="card">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h5 class="m-0 fw-bold text-primary">Daftar Statistik Publik</h5>
        <a href="{{ route('admin.statistics.create') }}" class="btn btn-primary btn-sm rounded-pill">
            <i class="fas fa-plus me-1"></i> Buat Statistik Baru
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="bg-light">
                    <tr>
                        <th width="5%">#</th>
                        <th>Judul Statistik</th>
                        <th>Deskripsi</th>
                        <th>Status</th>
                        <th>Dibuat</th>
                        <th width="20%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($statistics as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            <div class="fw-bold">{{ $item->title }}</div>
                            <small class="text-muted">Slug: {{ $item->slug }}</small>
                        </td>
                        <td>{{ \Illuminate\Support\Str::limit($item->description, 50) }}</td>
                        <td>
                            @if($item->is_published)
                                <span class="badge bg-success rounded-pill">Publik</span>
                            @else
                                <span class="badge bg-secondary rounded-pill">Draft</span>
                            @endif
                        </td>
                        <td>{{ $item->created_at->format('d M Y') }}</td>
                        <td>
                            <div class="btn-group">
                                <a href="{{ route('statistics.public.show', $item->slug) }}" target="_blank" class="btn btn-sm btn-outline-info" title="Lihat Publik">
                                    <i class="fas fa-external-link-alt"></i>
                                </a>
                                <a href="{{ route('admin.statistics.edit', $item->id) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.statistics.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus statistik ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">
                            <i class="fas fa-chart-line fa-3x mb-3 d-block opacity-25"></i>
                            Belum ada data statistik yang dibuat.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="mt-4 text-center">
    <a href="{{ route('statistics.public.index') }}" target="_blank" class="btn btn-outline-secondary rounded-pill">
        <i class="fas fa-th-list me-1"></i> Lihat Semua Indeks Statistik Publik
    </a>
</div>
@endsection
