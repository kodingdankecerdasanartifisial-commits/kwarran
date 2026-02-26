@extends('layouts.admin')

@section('page_title', 'Submisi Berita')

@section('content')
<div class="card">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h5 class="m-0 fw-bold">Submisi Berita</h5>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Judul</th>
                        <th>Pengirim</th>
                        <th>Kategori</th>
                        <th>Tanggal</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($posts as $post)
                    <tr>
                        <td>{{ $post->title }}</td>
                        <td>{{ $post->submitter_name ?? $post->author }}</td>
                        <td>
                            @forelse($post->categories as $category)
                                <span class="badge bg-secondary mb-1 small">{{ $category->name }}</span>
                            @empty
                                <span class="text-muted">-</span>
                            @endforelse
                        </td>
                        <td>{{ $post->created_at->format('d/m/Y H:i') }}</td>
                        <td class="text-end">
                            <a href="{{ route('admin.posts.edit', $post->id) }}" class="btn btn-sm btn-outline-primary">Tinjau & Edit</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-4 text-muted">Belum ada submisi.</td>
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
