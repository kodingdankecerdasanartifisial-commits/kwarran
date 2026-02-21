@extends('layouts.admin')

@section('page_title', 'Edit User')

@section('content')
<div class="card">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h5 class="m-0 fw-bold">Edit User</h5>
        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary btn-sm rounded-pill"><i class="fas fa-arrow-left me-1"></i> Kembali</a>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="mb-3">
                <label class="form-label fw-bold">Nama Lengkap</label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" required>
                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Email</label>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" required>
                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="bg-light p-3 rounded mb-3">
                <small class="text-muted d-block mb-2">Biarkan kosong jika tidak ingin mengubah password.</small>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Password Baru</label>
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror">
                        @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        <small class="text-muted">Minimal 8 karakter.</small>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Konfirmasi Password Baru</label>
                        <input type="password" name="password_confirmation" class="form-control">
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Role Akses</label>
                <select name="role" class="form-select @error('role') is-invalid @enderror" id="roleSelect" required>
                    <option value="admin"          {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin (Semua Akses)</option>
                    <option value="humas"          {{ old('role', $user->role) == 'humas' ? 'selected' : '' }}>Humas (Edit Konten, No Delete/Settings)</option>
                    <option value="lpk"            {{ old('role', $user->role) == 'lpk' ? 'selected' : '' }}>LPK (Laporan Keuangan Sahaja)</option>
                    <option value="operator_gudep" {{ old('role', $user->role) == 'operator_gudep' ? 'selected' : '' }}>🏫 Operator Gudep (Kelola Data Gudep Pangkalan)</option>
                    <option value="dkr"            {{ old('role', $user->role) == 'dkr' ? 'selected' : '' }}>🚩 Operator DKR (Kelola Landing Page DKR)</option>
                </select>
                @error('role')<div class="invalid-feedback">{{ $message }}</div>@enderror
                <small class="text-muted d-block mt-1">Ganti tingkat akses jika diperlukan.</small>
            </div>

            {{-- Info box shown when Operator Gudep is selected --}}
            <div id="gudepRoleInfo" class="alert alert-info d-flex gap-2 align-items-start mb-4 {{ old('role', $user->role) == 'operator_gudep' ? '' : 'd-none' }}">
                <i class="fas fa-university fa-lg mt-1"></i>
                <div>
                    <strong>Role: Operator Gudep</strong>
                    <p class="mb-0 small">User ini hanya dapat mengakses dan mengelola data <strong>Gudep & Pangkalan</strong>. Permission <em>gudep</em> akan diberikan secara otomatis.</p>
                </div>
            </div>

            <div id="dkrRoleInfo" class="alert alert-warning d-flex gap-2 align-items-start mb-4 {{ old('role', $user->role) == 'dkr' ? '' : 'd-none' }}">
                <i class="fas fa-users-cog fa-lg mt-1"></i>
                <div>
                    <strong>Role: Operator DKR</strong>
                    <p class="mb-0 small">User ini hanya dapat mengakses dan mengelola <strong>Landing Page & Berita DKR</strong>. Permission <em>dkr</em> akan diberikan secara otomatis.</p>
                </div>
            </div>

            <div id="permissionsSection" class="mb-4 {{ in_array(old('role', $user->role), ['admin', 'operator_gudep', 'dkr']) ? 'd-none' : '' }}">
                <label class="form-label fw-bold d-block mb-3 border-bottom pb-2">Izin Akses Menu (Custom Permissions)</label>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <h6 class="small fw-bold text-primary">PUBLIKASI KONTEN</h6>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="permissions[]" value="posts" id="perm_posts" {{ in_array('posts', old('permissions', $user->permissions ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label" for="perm_posts text-truncate">Kelola Berita & Materi Pokok</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="permissions[]" value="sliders" id="perm_sliders" {{ in_array('sliders', old('permissions', $user->permissions ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label" for="perm_sliders">Kelola Slider Beranda</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="permissions[]" value="events" id="perm_events" {{ in_array('events', old('permissions', $user->permissions ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label" for="perm_events">Kelola Agenda Kegiatan</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="permissions[]" value="gallery" id="perm_gallery" {{ in_array('gallery', old('permissions', $user->permissions ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label" for="perm_gallery">Kelola Galeri Foto/Video</label>
                        </div>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <h6 class="small fw-bold text-primary">SISTEM INFORMASI (SISRAN)</h6>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="permissions[]" value="sisran" id="perm_sisran" {{ in_array('sisran', old('permissions', $user->permissions ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label" for="perm_sisran">Desain & Rekap Data SISRAN</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="permissions[]" value="finances" id="perm_finances" {{ in_array('finances', old('permissions', $user->permissions ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label" for="perm_finances">Kelola Keuangan (LPK)</label>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <h6 class="small fw-bold text-primary">PUSAT INFORMASI</h6>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="permissions[]" value="messages" id="perm_messages" {{ in_array('messages', old('permissions', $user->permissions ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label" for="perm_messages">Lihat Inbox Pesan</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="permissions[]" value="visitors" id="perm_visitors" {{ in_array('visitors', old('permissions', $user->permissions ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label" for="perm_visitors">Lihat Statistik Pengunjung</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="permissions[]" value="organization" id="perm_organization" {{ in_array('organization', old('permissions', $user->permissions ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label" for="perm_organization">Kelola Struktur Organisasi</label>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <h6 class="small fw-bold text-primary">FILE & DOKUMEN</h6>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="permissions[]" value="downloads" id="perm_downloads" {{ in_array('downloads', old('permissions', $user->permissions ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label" for="perm_downloads">Kelola Download Area</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="permissions[]" value="documents" id="perm_documents" {{ in_array('documents', old('permissions', $user->permissions ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label" for="perm_documents">Kelola Dokumen Publik</label>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="alert alert-warning py-2 d-flex align-items-center gap-2 mt-2">
                            <i class="fas fa-university fa-lg"></i>
                            <div>
                                <h6 class="small fw-bold mb-0">DATABASE GUDEP & PANGKALAN</h6>
                                <div class="form-check mt-1">
                                    <input class="form-check-input" type="checkbox" name="permissions[]" value="gudep" id="perm_gudep" {{ in_array('gudep', old('permissions', $user->permissions ?? [])) ? 'checked' : '' }}>
                                    <label class="form-check-label fw-bold" for="perm_gudep">Kelola Data Gudep & Pangkalan</label>
                                    <small class="d-block text-muted">User hanya bisa mengakses dan mengelola data Gudep/Pangkalan saja.</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @push('scripts')
            <script>
                function handleRoleChange(role) {
                    const section = document.getElementById('permissionsSection');
                    const gudepInfo = document.getElementById('gudepRoleInfo');
                    const dkrInfo = document.getElementById('dkrRoleInfo');

                    if (role === 'admin') {
                        section.classList.add('d-none');
                        gudepInfo.classList.add('d-none');
                        dkrInfo.classList.add('d-none');
                    } else if (role === 'operator_gudep') {
                        section.classList.add('d-none');
                        gudepInfo.classList.remove('d-none');
                        dkrInfo.classList.add('d-none');
                    } else if (role === 'dkr') {
                        section.classList.add('d-none');
                        gudepInfo.classList.add('d-none');
                        dkrInfo.classList.remove('d-none');
                    } else {
                        section.classList.remove('d-none');
                        gudepInfo.classList.add('d-none');
                        dkrInfo.classList.add('d-none');
                    }
                }

                document.getElementById('roleSelect').addEventListener('change', function() {
                    handleRoleChange(this.value);
                });

                // Run on page load
                handleRoleChange(document.getElementById('roleSelect').value);
            </script>
            @endpush

            <div class="d-grid mt-4">
                <button type="submit" class="btn btn-primary rounded-pill">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
@endsection
