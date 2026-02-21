@extends('layouts.admin')

@section('page_title', 'Manajemen Galeri')

@section('content')
<div class="card">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h5 class="m-0 fw-bold">Daftar Galeri</h5>
        <a href="{{ route('admin.gallery.create') }}" class="btn btn-primary btn-sm rounded-pill">
            <i class="fas fa-plus me-1"></i> Tambah Galeri Baru
        </a>
    </div>
    <div class="card-body">
        <div class="row g-4">
            @forelse($galleries as $item)
            <div class="col-md-3">
                <div class="card h-100 border-0 shadow-sm rounded-3 overflow-hidden">
                    <div class="position-relative">
                        @if($item->type === 'photo')
                            <img src="{{ $item->image ? asset('storage/' . $item->image) : asset('img/drive-placeholder.png') }}" class="card-img-top object-fit-cover" style="height: 180px;">
                            <span class="position-absolute top-0 start-0 m-2 badge bg-primary">Foto</span>
                        @else
                            <img src="https://img.youtube.com/vi/{{ $item->external_link }}/0.jpg" class="card-img-top object-fit-cover" style="height: 180px;">
                            <span class="position-absolute top-0 start-0 m-2 badge bg-danger">Video</span>
                        @endif
                    </div>
                    <div class="card-body p-3">
                        <h6 class="fw-bold mb-1 text-truncate">{{ $item->title }}</h6>
                        <p class="small text-muted mb-3">{{ Str::limit($item->description, 50) }}</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="small text-muted">{{ $item->created_at->format('d M y') }}</span>
                            <div class="btn-group">
                                <a href="{{ route('admin.gallery.edit', $item->id) }}" class="btn btn-sm btn-outline-primary"><i class="fas fa-edit"></i></a>
                                @if(auth()->user()->role === 'admin')
                                <form action="{{ route('admin.gallery.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus item ini?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                                </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-5">
                <p class="text-muted">Belum ada koleksi galeri.</p>
            </div>
            @endforelse
        </div>
        <div class="mt-4">
            {{ $galleries->links() }}
        </div>
    </div>
</div>
@endsection
