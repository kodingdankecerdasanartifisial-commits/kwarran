@extends('layouts.admin')

@section('title', 'Kelola Download')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Kelola File Download</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('admin.downloads.create') }}" class="btn btn-sm btn-primary">
            <i class="fas fa-plus me-1"></i> Tambah File
        </a>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="card shadow rounded-3 border-0">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="bg-light">
                    <tr>
                        <th class="border-0 rounded-start">Judul File</th>
                        <th class="border-0">Deskripsi</th>
                        <th class="border-0 text-center">Unduhan</th>
                        <th class="border-0 text-center">Status</th>
                        <th class="border-0 rounded-end text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($downloads as $download)
                    <tr>
                        <td class="fw-bold">{{ $download->title }}</td>
                        <td class="text-muted small">{{ Str::limit($download->description, 50) }}</td>
                        <td class="text-center">
                            <span class="badge bg-info text-dark">{{ $download->downloads_count }}x</span>
                        </td>
                        <td class="text-center">
                            @if($download->is_active)
                                <span class="badge bg-success">Aktif</span>
                            @else
                                <span class="badge bg-secondary">Draft</span>
                            @endif
                        </td>
                        <td class="text-end">
                            <div class="btn-group">
                                <a href="{{ route('admin.downloads.edit', $download->id) }}" class="btn btn-sm btn-outline-secondary" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.downloads.destroy', $download->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus file ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-4 text-muted">
                            <div class="d-flex flex-column align-items-center">
                                <i class="fas fa-file-alt fa-3x mb-3 text-secondary opacity-50"></i>
                                <p class="mb-0">Belum ada file yang diunggah.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="mt-3">
            {{ $downloads->links() }}
        </div>
    </div>
</div>
@endsection
