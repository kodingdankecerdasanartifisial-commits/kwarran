@extends('layouts.admin')

@section('page_title', 'Kelola Dokumen (Embed PDF)')

@section('content')
<div class="card">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h5 class="m-0 fw-bold">Daftar Dokumen</h5>
        <a href="{{ route('admin.documents.create') }}" class="btn btn-primary btn-sm rounded-pill">
            <i class="fas fa-plus me-1"></i> Upload Dokumen PDF
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="bg-light">
                    <tr>
                        <th width="5%">#</th>
                        <th>Judul Dokumen</th>
                        <th>Link Publik</th>
                        <th>Status</th>
                        <th width="15%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($documents as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td class="fw-bold">{{ $item->title }}</td>
                        <td>
                            <div class="input-group input-group-sm">
                                <input type="text" class="form-control" value="{{ route('documents.public.show', $item->slug) }}" id="link-{{ $item->id }}" readonly>
                                <button class="btn btn-outline-secondary" type="button" onclick="copyLink('link-{{ $item->id }}')">
                                    <i class="fas fa-copy"></i>
                                </button>
                            </div>
                        </td>
                        <td>
                            @if($item->is_published)
                                <span class="badge bg-success rounded-pill">Publik</span>
                            @else
                                <span class="badge bg-secondary rounded-pill">Draft</span>
                            @endif
                        </td>
                        <td>
                            <div class="btn-group">
                                <a href="{{ route('documents.public.show', $item->slug) }}" target="_blank" class="btn btn-sm btn-outline-info">
                                    <i class="fas fa-external-link-alt"></i>
                                </a>
                                <a href="{{ route('admin.documents.edit', $item->id) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-edit"></i>
                                </a>
                                @if(auth()->user()->role === 'admin')
                                <form action="{{ route('admin.documents.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus dokumen ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted">Belum ada dokumen PDF yang diupload.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3">
            {{ $documents->links() }}
        </div>
    </div>
</div>

<script>
function copyLink(id) {
    var copyText = document.getElementById(id);
    copyText.select();
    copyText.setSelectionRange(0, 99999);
    navigator.clipboard.writeText(copyText.value);
    alert("Link berhasil disalin!");
}
</script>
@endsection
