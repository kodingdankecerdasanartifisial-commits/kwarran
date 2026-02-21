@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Add Menu Form -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold"><i class="fas fa-plus-circle me-2 text-primary"></i>Tambah Menu</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.menus.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-bold">Nama Menu</label>
                            <input type="text" name="name" class="form-control" placeholder="Contoh: Profil" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">URL</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-link"></i></span>
                                <input type="text" name="url" class="form-control" placeholder="/profil" required>
                            </div>
                            <small class="text-muted d-block mt-1">Gunakan <code>#</code> jika ini adalah menu induk (dropdown).</small>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary fw-bold text-uppercase" style="letter-spacing: 1px;">
                                <i class="fas fa-save me-1"></i> Simpan Menu
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-4 bg-light">
                <div class="card-body">
                    <h6 class="fw-bold mb-3"><i class="fas fa-info-circle me-1"></i> Petunjuk Penggunaan</h6>
                    <ul class="ps-3 mb-0 small text-muted" style="line-height: 1.6;">
                        <li><strong>Geser (Drag & Drop)</strong> item menu untuk mengubah urutan tampilan.</li>
                        <li>Geser item sedikit ke <strong>kanan</strong> di bawah item lain untuk menjadikannya <strong>Sub Menu</strong>.</li>
                        <li>Klik ikon <i class="fas fa-pencil-alt text-primary mx-1"></i> untuk mengedit nama atau URL.</li>
                        <li>Klik ikon <i class="fas fa-trash text-danger mx-1"></i> untuk menghapus menu selamanya.</li>
                        <li>Urutan tersimpan otomatis setelah digeser.</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Menu List -->
        <div class="col-md-8">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold"><i class="fas fa-sitemap me-2 text-primary"></i>Struktur Menu</h5>
                    <div id="save-status" class="badge bg-success d-none"><i class="fas fa-check me-1"></i> Tersimpan</div>
                </div>
                <div class="card-body">
                    @if($menus->count() > 0)
                    <div class="dd" id="menu-nestable">
                        <ol class="dd-list">
                            @foreach($menus as $menu)
                                <li class="dd-item" data-id="{{ $menu->id }}">
                                    <div class="dd-handle d-flex justify-content-between align-items-center">
                                        <div>
                                            <i class="fas fa-bars text-muted me-2 handle-icon"></i>
                                            <span class="fw-bold text-dark">{{ $menu->name }}</span>
                                            <small class="text-muted ms-2 fst-italic" style="font-size: 0.8rem;">{{ $menu->url }}</small>
                                        </div>
                                    </div>
                                    
                                    <div class="dd-actions">
                                        <button class="btn btn-sm btn-light text-primary section-edit-btn me-1" 
                                                type="button"
                                                data-bs-toggle="modal" 
                                                data-bs-target="#editModal{{ $menu->id }}"
                                                title="Edit">
                                            <i class="fas fa-pencil-alt"></i>
                                        </button>
                                        <form action="{{ route('admin.menus.destroy', $menu->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus menu ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-light text-danger" title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>

                                    @if($menu->children->count() > 0)
                                        <ol class="dd-list">
                                            @foreach($menu->children as $child)
                                                <li class="dd-item" data-id="{{ $child->id }}">
                                                    <div class="dd-handle d-flex justify-content-between align-items-center">
                                                        <div>
                                                            <i class="fas fa-bars text-muted me-2 handle-icon"></i>
                                                            <span>{{ $child->name }}</span>
                                                            <small class="text-muted ms-2 fst-italic" style="font-size: 0.8rem;">{{ $child->url }}</small>
                                                        </div>
                                                    </div>

                                                    <div class="dd-actions">
                                                        <button class="btn btn-sm btn-light text-primary section-edit-btn me-1" 
                                                                type="button"
                                                                data-bs-toggle="modal" 
                                                                data-bs-target="#editModal{{ $child->id }}"
                                                                title="Edit">
                                                            <i class="fas fa-pencil-alt"></i>
                                                        </button>
                                                        <form action="{{ route('admin.menus.destroy', $child->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus menu ini?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-light text-danger" title="Hapus">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ol>
                                    @endif
                                </li>
                            @endforeach
                        </ol>
                    </div>
                    @else
                        <div class="text-center py-5">
                            <div class="mb-3">
                                <i class="fas fa-layer-group fa-3x text-light"></i>
                            </div>
                            <p class="text-muted">Belum ada menu. Silakan tambahkan menu baru.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modals Container (Placed outside the nestable list to avoid z-index/clipping issues) -->
<div id="modals-container">
    @foreach($menus as $menu)
        @include('admin.menus.edit_modal', ['menu' => $menu])
        @foreach($menu->children as $child)
            @include('admin.menus.edit_modal', ['menu' => $child])
        @endforeach
    @endforeach
</div>

@push('styles')
<style>
    .dd { position: relative; display: block; margin: 0; padding: 0; max-width: 100%; list-style: none; font-size: 14px; line-height: 20px; }
    .dd-list { display: block; position: relative; margin: 0; padding: 0; list-style: none; }
    .dd-list .dd-list { padding-left: 30px; }
    .dd-collapsed .dd-list { display: none; }
    .dd-item, .dd-empty, .dd-placeholder { display: block; position: relative; margin: 0; padding: 0; min-height: 20px; font-size: 14px; line-height: 20px; }
    
    .dd-handle { 
        display: block; 
        margin: 5px 0; 
        padding: 12px 15px; 
        color: #333; 
        text-decoration: none; 
        border: 1px solid #e5e5e5;
        background: #fff;
        border-radius: 8px;
        transition: all 0.2s;
        cursor: grab;
        min-height: 50px; /* Ensure height specifically for handle */
    }
    .dd-handle:hover { background: #f9f9f9; border-color: #ddd; }
    
    /* Custom Actions Button Positioning */
    .dd-actions { 
        position: absolute; 
        top: 12px; 
        right: 15px; 
        z-index: 5; 
        opacity: 0.8;
        transition: opacity 0.2s;
    }
    .dd-item:hover > .dd-actions { opacity: 1; }
    
    .dd-placeholder { background: #f0f2f5; border: 2px dashed #ccc; min-height: 50px; margin: 5px 0; border-radius: 8px; }
    .dd-empty { border: 1px dashed #bbb; min-height: 100px; background-color: #e5e5e5; background-size: 60px 60px; background-position: 0 0, 30px 30px; }
    .dd-dragel { position: absolute; pointer-events: none; z-index: 9999; }
    .dd-dragel > .dd-item .dd-handle { margin-top: 0; box-shadow: 2px 4px 6px 0 rgba(0,0,0,.1); opacity: 0.9; background: #fff; transform: scale(1.02); }
    
    .dd-item > button { display: none; } 
    
    .handle-icon { cursor: grab; opacity: 0.5; }
    .dd-handle:hover .handle-icon { opacity: 1; }
</style>
@endpush

@push('scripts')
<!-- Use specific Nestable2 CDN that works well with jQuery 3+ -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/nestable2/1.6.0/jquery.nestable.min.js"></script>
<script>
    $(document).ready(function() {
        $('#menu-nestable').nestable({
            maxDepth: 2,
            handleClass: 'dd-handle'
        }).on('change', function() {
            var json = $('#menu-nestable').nestable('serialize');
            
            $('#save-status').removeClass('d-none').html('<i class="fas fa-spinner fa-spin me-1"></i> Menyimpan...');

            $.ajax({
                url: "{{ route('admin.menus.update-order') }}",
                method: "POST",
                data: {
                    order: json,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    $('#save-status').html('<i class="fas fa-check me-1"></i> Tersimpan').delay(2000).fadeOut();
                },
                error: function() {
                    $('#save-status').html('<i class="fas fa-times me-1"></i> Gagal').addClass('bg-danger').removeClass('bg-success');
                }
            });
        });
    });
</script>
@endpush

@endsection
