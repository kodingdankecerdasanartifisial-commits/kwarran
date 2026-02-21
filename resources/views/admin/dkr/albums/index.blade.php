@extends('layouts.admin')

@section('page_title', 'Album Galeri DKR')

@section('content')
<div class="card">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h5 class="m-0 fw-bold text-dark text-uppercase">Album Galeri DKR</h5>
        <a href="{{ route('admin.dkr.albums.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus me-1"></i> Buat Album Baru
        </a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">Album</th>
                        <th>Jumlah Foto</th>
                        <th>Tanggal Dibuat</th>
                        <th class="text-end pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($albums as $album)
                    <tr>
                        <td class="ps-4">
                            <div class="d-flex align-items-center">
                                @if($album->cover_image)
                                    <img src="{{ asset('storage/' . $album->cover_image) }}" alt="Cover" class="rounded me-3 shadow-sm" style="width: 60px; height: 45px; object-fit: cover;">
                                @else
                                    <div class="bg-light rounded me-3 d-flex align-items-center justify-content-center border" style="width: 60px; height: 45px;"><i class="fas fa-images text-muted"></i></div>
                                @endif
                                <div>
                                    <div class="fw-bold text-dark">{{ $album->name }}</div>
                                    <small class="text-muted">{{ Str::limit($album->description, 50) }}</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="badge bg-info">{{ $album->photos->count() }} Foto</span>
                        </td>
                        <td>
                            {{ $album->created_at->format('d/m/Y') }}
                        </td>
                        <td class="text-end pe-4">
                            <div class="btn-group">
                                <a href="{{ route('admin.dkr.albums.edit', $album->id) }}" class="btn btn-sm btn-outline-primary" title="Edit Album">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.dkr.albums.destroy', $album->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus album ini beserta seluruh fotonya?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus"><i class="fas fa-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center py-5 text-muted">Belum ada album galeri.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer bg-white">
        {{ $albums->links() }}
    </div>
</div>
@endsection
