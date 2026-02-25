@extends('layouts.admin')

@section('page_title', 'Kelola Spanduk Digital')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h5 class="m-0 fw-bold">Daftar Spanduk Digital</h5>
                <a href="{{ route('admin.digital-banners.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus me-1"></i> Tambah Spanduk
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th width="150">Pratinjau</th>
                                <th>Judul / Link</th>
                                <th width="100">Urutan</th>
                                <th width="100">Status</th>
                                <th width="150">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($banners as $banner)
                            <tr>
                                <td>
                                    <img src="{{ asset('storage/' . $banner->image) }}" class="rounded shadow-sm" width="120" style="max-height: 80px; object-fit: contain;">
                                </td>
                                <td>
                                    <div class="fw-bold">{{ $banner->title ?? 'Tanpa Judul' }}</div>
                                    @if($banner->link)
                                        <small class="text-primary"><i class="fas fa-link me-1"></i>{{ $banner->link }}</small>
                                    @endif
                                </td>
                                <td>{{ $banner->order }}</td>
                                <td>
                                    @if($banner->is_active)
                                        <span class="badge bg-success">Aktif</span>
                                    @else
                                        <span class="badge bg-danger">Non-aktif</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('admin.digital-banners.edit', $banner->id) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.digital-banners.destroy', $banner->id) }}" method="POST" onsubmit="return confirm('Hapus spanduk ini?')">
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
                                <td colspan="5" class="text-center py-4 text-muted">Belum ada spanduk digital ditambahkan.</td>
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
