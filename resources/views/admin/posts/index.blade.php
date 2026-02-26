@extends('layouts.admin')

@section('page_title', request()->routeIs('admin.posts.materi') ? 'Kelola Postingan Materi' : 'Kelola Berita')

@section('content')
<div class="card">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h5 class="m-0 fw-bold text-dark">{{ request()->routeIs('admin.posts.materi') ? 'Daftar Materi' : 'Daftar Berita' }}</h5>
        <div class="d-flex align-items-center gap-3">
            <form method="GET" action="{{ url()->current() }}" class="d-flex align-items-center">
                <select name="category" class="form-select form-select-sm me-2" onchange="this.form.submit()">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
                <noscript><button type="submit" class="btn btn-sm btn-outline-secondary">Filter</button></noscript>
            </form>
            <a href="{{ route('admin.posts.create', ['type' => request()->routeIs('admin.posts.materi') ? 'materi' : 'berita']) }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus me-1"></i>
                {{ request()->routeIs('admin.posts.materi') ? 'Tambah Materi' : 'Tambah Berita' }}
            </a>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">Judul</th>
                        <th>Kategori</th>
                        <th>Materi</th>
                        <th>Status</th>
                        <th>Tanggal Post</th>
                        <th class="text-end pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($posts as $post)
                    <tr>
                        <td class="ps-4">
                            <div class="d-flex align-items-center">
                                @if($post->featured_image)
                                    <img src="{{ asset('storage/' . $post->featured_image) }}" alt="Img" class="rounded me-3" style="width: 50px; height: 50px; object-fit: cover;">
                                @elseif($post->youtube_url)
                                    @php
                                        // Simple regex to get video ID
                                        preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $post->youtube_url, $matches);
                                        $videoId = $matches[1] ?? null;
                                    @endphp
                                    @if($videoId)
                                        <img src="https://img.youtube.com/vi/{{ $videoId }}/default.jpg" alt="YT" class="rounded me-3" style="width: 50px; height: 50px; object-fit: cover;">
                                    @else
                                        <div class="bg-light rounded me-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;"><i class="fas fa-image text-muted"></i></div>
                                    @endif
                                @else
                                    <div class="bg-light rounded me-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;"><i class="fas fa-image text-muted"></i></div>
                                @endif
                                <div>
                                    <div class="fw-bold text-dark">{{ Str::limit($post->title, 40) }}</div>
                                    <small class="text-muted">{{ Str::limit(strip_tags($post->content), 40) }}</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            @forelse($post->categories as $category)
                                <span class="badge bg-secondary mb-1">{{ $category->name }}</span>
                            @empty
                                <span class="text-muted">-</span>
                            @endforelse
                        </td>

                        <td>
                            @if($post->material_pdf)
                                <a href="{{ asset('storage/' . $post->material_pdf) }}" target="_blank" class="btn btn-sm btn-outline-secondary me-1"><i class="fas fa-file-pdf"></i></a>
                            @endif
                            @if($post->youtube_url)
                                <a href="{{ $post->youtube_url }}" target="_blank" class="btn btn-sm btn-outline-danger"><i class="fab fa-youtube"></i></a>
                            @endif
                            @if(!$post->material_pdf && !$post->youtube_url)
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            @if($post->is_published)
                                <span class="badge bg-success">Published</span>
                            @else
                                <span class="badge bg-warning text-dark">Draft</span>
                            @endif
                        </td>
                        <td>
                            {{ $post->published_at?->format('d/m/Y') ?? '-' }}
                        </td>
                        <td class="text-end pe-4">
                            <div class="btn-group">
                                <a href="{{ route('posts.show', $post->slug) }}" class="btn btn-sm btn-outline-info" target="_blank" title="Lihat">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.posts.edit', $post->id) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button" class="btn btn-sm btn-outline-danger" title="Hapus" onclick="if(confirm('Hapus berita ini?')) document.getElementById('delete-post-{{ $post->id }}').submit();">
                                    <i class="fas fa-trash"></i>
                                </button>
                                <form id="delete-post-{{ $post->id }}" action="{{ route('admin.posts.destroy', $post->id) }}" method="POST" class="d-none">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted">Belum ada berita.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer bg-white">
        {{ $posts->links() }}
    </div>
</div>
@endsection
