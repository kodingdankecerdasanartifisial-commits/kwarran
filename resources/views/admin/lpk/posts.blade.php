@extends('layouts.admin')

@section('page_title', 'Berita / Posts LPK')

@section('content')
<div class="card">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h5 class="m-0 fw-bold">Daftar Berita LPK</h5>
        <a href="{{ route('admin.posts.create', ['category_id' => $category?->id]) }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus me-1"></i> Buat Berita LPK
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="bg-light">
                    <tr>
                        <th width="100">Gambar</th>
                        <th>Judul Berita</th>
                        <th>Status</th>
                        <th>Tanggal Publish</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($posts as $post)
                    <tr>
                        <td>
                            @if($post->featured_image)
                                <img src="{{ asset('storage/' . $post->featured_image) }}" class="rounded shadow-sm" style="width: 80px; height: 50px; object-fit: cover;">
                            @else
                                <div class="bg-light rounded text-center" style="width: 80px; height: 50px; line-height: 50px;">
                                    <i class="fas fa-image text-muted opacity-50"></i>
                                </div>
                            @endif
                        </td>
                        <td>
                            <div class="fw-bold">{{ $post->title }}</div>
                            <small class="text-muted"><i class="fas fa-eye me-1"></i> {{ $post->views }} tayangan</small>
                        </td>
                        <td>
                            @if($post->is_published)
                                <span class="badge bg-success">Published</span>
                            @else
                                <span class="badge bg-warning text-dark">Draft</span>
                            @endif
                        </td>
                        <td>
                            {{ $post->published_at ? $post->published_at->format('d/m/Y') : '-' }}<br>
                            <small class="text-muted">{{ $post->published_at ? $post->published_at->format('H:i') : '' }}</small>
                        </td>
                        <td class="text-end">
                            <div class="btn-group">
                                <a href="{{ route('posts.show', $post->slug) }}" target="_blank" class="btn btn-sm btn-outline-info" title="Lihat">
                                    <i class="fas fa-external-link-alt"></i>
                                </a>
                                <a href="{{ route('admin.posts.edit', $post->id) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.posts.destroy', $post->id) }}" method="POST" onsubmit="return confirm('Hapus berita ini?')">
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
                        <td colspan="5" class="text-center py-5 text-muted">
                            <i class="fas fa-newspaper fa-3x mb-3 opacity-25"></i>
                            <p>Belum ada berita khusus LPK.</p>
                            <a href="{{ route('admin.posts.create', ['category_id' => $category?->id]) }}" class="btn btn-primary btn-sm">Mulai Menulis</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{ $posts->links() }}
        </div>
    </div>
</div>
@endsection
