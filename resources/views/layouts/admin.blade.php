<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Kwarran Bekasi Timur</title>
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('logo.png') }}">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #4B2C20;
            --secondary-color: #F2C94C;
        }
        body {
            background-color: #f4f6f9;
        }
        .sidebar {
            min-height: 100vh;
            background-color: var(--primary-color);
            color: white;
            transition: all 0.3s;
        }
        .sidebar .nav-link {
            color: rgba(255,255,255,0.8);
            padding: 15px 20px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        .sidebar .nav-link:hover, .sidebar .nav-link.active {
            color: var(--secondary-color);
            background-color: rgba(255,255,255,0.05);
        }
        .sidebar .nav-link i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }
        .admin-header {
            background-color: white;
            padding: 15px 30px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }
        .card {
            border: none;
            box-shadow: 0 0.125rem 0.25rem rgba(0,0,0,0.075);
            margin-bottom: 1.5rem;
        }
        .transition {
            transition: transform 0.3s ease;
        }
        .collapsed .transition {
            transform: rotate(-90deg);
        }
        #sidebarNav .nav-link {
            cursor: pointer;
        }
        #sidebarNav .collapse .nav-link {
            font-size: 0.9rem;
            padding-top: 8px;
            padding-bottom: 8px;
        }
        #sidebarNav .collapse .nav-link:hover {
            padding-left: 25px;
            transition: padding-left 0.2s;
        }
    </style>
</head>
<body>
    <div class="container-fluid p-0">
        <div class="row g-0">
            <!-- Sidebar -->
            <div class="col-md-2 sidebar d-none d-md-block">
                <div class="p-4 text-center border-bottom border-secondary border-3 mb-3">
                    <img src="{{ asset('logo.png') }}" alt="Logo" height="60" class="mb-2">
                    <h5 class="fw-bold m-0" style="color: var(--secondary-color);">KWARRAN ADMIN</h5>
                </div>
                <nav class="nav flex-column" id="sidebarNav">
                    @php $user = auth()->user(); @endphp
                    
                    <!-- Dashboard -->
                    <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                        <i class="fas fa-tachometer-alt"></i> Dashboard
                    </a>

                    @if($user->role === 'admin' || $user->hasPermission('gudep'))
                    <a class="nav-link {{ request()->is('admin/gudep*') ? 'active' : '' }}" href="{{ route('admin.gudep.index') }}">
                        <i class="fas fa-university"></i> Gudep & Pangkalan
                    </a>
                    @endif

                    <!-- DKR Management -->
                    @if($user->hasPermission('dkr'))
                    <div class="nav-item">
                        <a class="nav-link d-flex justify-content-between align-items-center {{ request()->is('admin/dkr*') ? 'active' : 'collapsed' }}" 
                           data-bs-toggle="collapse" href="#dkrCollapse">
                            <span><i class="fas fa-users-cog"></i> Dewan Kerja (DKR)</span>
                            <i class="fas fa-chevron-down small transition"></i>
                        </a>
                        <div class="collapse {{ request()->routeIs('admin.dkr.*') ? 'show' : '' }}" id="dkrCollapse" data-bs-parent="#sidebarNav">
                            <ul class="nav flex-column bg-dark bg-opacity-10 ms-3 border-start border-secondary border-opacity-25">
                                <li class="nav-item">
                                    <a class="nav-link py-2 {{ request()->routeIs('admin.dkr.landingpage') ? 'active' : '' }}" href="{{ route('admin.dkr.landingpage') }}">
                                        <i class="fas fa-home me-2"></i> Landing Page DKR
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link py-2 {{ request()->routeIs('admin.dkr.albums.*') ? 'active' : '' }}" href="{{ route('admin.dkr.albums.index') }}">
                                        <i class="fas fa-images me-2"></i> Album Galeri
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link py-2 {{ request()->routeIs('admin.dkr.agendas.*') ? 'active' : '' }}" href="{{ route('admin.dkr.agendas.index') }}">
                                        <i class="fas fa-calendar-alt me-2"></i> Agenda Kerja
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link py-2 {{ request()->routeIs('admin.dkr.posts') ? 'active' : '' }}" href="{{ route('admin.dkr.posts') }}">
                                        <i class="fas fa-newspaper me-2"></i> Berita DKR
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link py-2" href="{{ route('admin.posts.create', ['category_id' => \App\Models\Category::where('name', 'DKR')->first()?->id]) }}">
                                        <i class="fas fa-plus-circle me-2"></i> Tambah Berita DKR
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    @endif

                    <!-- Group: Publikasi -->
                    @if($user->hasPermission('posts') || $user->hasPermission('sliders') || $user->hasPermission('events') || $user->hasPermission('gallery'))
                    <div class="nav-item">
                        <a class="nav-link d-flex justify-content-between align-items-center {{ request()->is('admin/posts*', 'admin/sliders*', 'admin/events*', 'admin/gallery*') ? 'active' : 'collapsed' }}" 
                           data-bs-toggle="collapse" href="#collapsePublikasi">
                            <span><i class="fas fa-bullhorn"></i> Publikasi Konten</span>
                            <i class="fas fa-chevron-down small transition"></i>
                        </a>
                        <div class="collapse {{ request()->is('admin/posts*', 'admin/sliders*', 'admin/events*', 'admin/gallery*') ? 'show' : '' }}" id="collapsePublikasi" data-bs-parent="#sidebarNav">
                            <div class="nav flex-column bg-dark bg-opacity-10 ms-3 border-start border-secondary border-opacity-25">
                                @if($user->hasPermission('posts'))
                                <a class="nav-link py-2 {{ request()->is('admin/posts') ? 'active' : '' }}" href="{{ route('admin.posts.index') }}">Berita</a>
                                <a class="nav-link py-2 {{ request()->is('admin/posts/materi*') ? 'active' : '' }}" href="{{ route('admin.posts.materi') }}">Materi Pokok</a>
                                @endif

                                @if($user->hasPermission('sliders'))
                                <a class="nav-link py-2 {{ request()->is('admin/sliders*') ? 'active' : '' }}" href="{{ route('admin.sliders.index') }}">Slider</a>
                                @endif

                                @if($user->hasPermission('events'))
                                <a class="nav-link py-2 {{ request()->is('admin/events*') ? 'active' : '' }}" href="{{ route('admin.events.index') }}">Agenda Kegiatan</a>
                                @endif

                                @if($user->hasPermission('gallery'))
                                <a class="nav-link py-2 {{ request()->is('admin/gallery*') ? 'active' : '' }}" href="{{ route('admin.gallery.index') }}">Galeri Foto/Video</a>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Group: Data & File -->
                    @if($user->hasPermission('downloads') || $user->hasPermission('documents') || $user->hasPermission('statistics'))
                    <div class="nav-item">
                        <a class="nav-link d-flex justify-content-between align-items-center {{ request()->is('admin/downloads*', 'admin/documents*', 'admin/statistics*') ? 'active' : 'collapsed' }}" 
                           data-bs-toggle="collapse" href="#collapseData">
                            <span><i class="fas fa-database"></i> Data & File</span>
                            <i class="fas fa-chevron-down small transition"></i>
                        </a>
                        <div class="collapse {{ request()->is('admin/downloads*', 'admin/documents*', 'admin/statistics*') ? 'show' : '' }}" id="collapseData" data-bs-parent="#sidebarNav">
                            <div class="nav flex-column bg-dark bg-opacity-10 ms-3 border-start border-secondary border-opacity-25">
                                @if($user->hasPermission('downloads'))
                                <a class="nav-link py-2 {{ request()->is('admin/downloads*') ? 'active' : '' }}" href="{{ route('admin.downloads.index') }}">File Download</a>
                                @endif
                                
                                @if($user->hasPermission('documents'))
                                <a class="nav-link py-2 {{ request()->is('admin/documents*') ? 'active' : '' }}" href="{{ route('admin.documents.index') }}">Embed Dokumen</a>
                                @endif

                                @if($user->hasPermission('statistics'))
                                <a class="nav-link py-2 {{ request()->is('admin/statistics*') ? 'active' : '' }}" href="{{ route('admin.statistics.index') }}">Statistik Manual</a>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Group: Website Manager (Admin Only) -->
                    @if($user->role === 'admin')
                    <div class="nav-item">
                        <a class="nav-link d-flex justify-content-between align-items-center {{ request()->is('admin/pages*', 'admin/menus*', 'admin/sidebar-widgets*', 'admin/categories*') ? 'active' : 'collapsed' }}" 
                           data-bs-toggle="collapse" href="#collapseWeb">
                            <span><i class="fas fa-globe"></i> Website Manager</span>
                            <i class="fas fa-chevron-down small transition"></i>
                        </a>
                        <div class="collapse {{ request()->is('admin/pages*', 'admin/menus*', 'admin/sidebar-widgets*', 'admin/categories*') ? 'show' : '' }}" id="collapseWeb" data-bs-parent="#sidebarNav">
                            <div class="nav flex-column bg-dark bg-opacity-10 ms-3 border-start border-secondary border-opacity-25">
                                <a class="nav-link py-2 {{ request()->is('admin/pages*') ? 'active' : '' }}" href="{{ route('admin.pages.index') }}">Halaman</a>
                                <a class="nav-link py-2 {{ request()->is('admin/menus*') ? 'active' : '' }}" href="{{ route('admin.menus.index') }}">Menu Navigasi</a>
                                <a class="nav-link py-2 {{ request()->is('admin/sidebar-widgets*') ? 'active' : '' }}" href="{{ route('admin.sidebar-widgets.index') }}">Sidebar Widgets</a>
                                <a class="nav-link py-2 {{ request()->is('admin/categories*') ? 'active' : '' }}" href="{{ route('admin.categories.index') }}">Kategori Berita</a>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Group: Sistem Informasi Kwarran (SISRAN) -->
                    @if($user->hasPermission('sisran'))
                    <div class="nav-item">
                        <a class="nav-link d-flex justify-content-between align-items-center {{ request()->is('admin/sisran*') ? 'active' : 'collapsed' }}" 
                           data-bs-toggle="collapse" href="#collapseSisran">
                            <span><i class="fas fa-chart-pie"></i> Sistem Informasi Kwarran</span>
                            <i class="fas fa-chevron-down small transition"></i>
                        </a>
                        <div class="collapse {{ request()->is('admin/sisran*') ? 'show' : '' }}" id="collapseSisran" data-bs-parent="#sidebarNav">
                            <div class="nav flex-column bg-dark bg-opacity-10 ms-3 border-start border-secondary border-opacity-25">
                                <a class="nav-link py-2 {{ request()->is('admin/sisran') ? 'active' : '' }}" href="{{ route('admin.sisran.index') }}">Desain Form</a>
                                <a class="nav-link py-2 {{ request()->is('admin/sisran/create') ? 'active' : '' }}" href="{{ route('admin.sisran.create') }}">Tambah Form Baru</a>
                                <a class="nav-link py-2 {{ request()->routeIs('admin.sisran.entries') ? 'active' : '' }}" href="{{ route('admin.sisran.index') }}">Rekap Data Isian</a>
                                <a class="nav-link py-2 {{ request()->routeIs('admin.sisran.visualize*') ? 'active' : '' }}" href="{{ route('admin.sisran.visualize.index') }}">Visualisasi Data</a>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Group: Pusat Informasi -->
                    @if($user->hasPermission('messages') || $user->hasPermission('visitors') || $user->hasPermission('organization'))
                    <div class="nav-item">
                        <a class="nav-link d-flex justify-content-between align-items-center {{ request()->is('admin/messages*', 'admin/visitors*', 'admin/organization*') ? 'active' : 'collapsed' }}" 
                           data-bs-toggle="collapse" href="#collapseInfo">
                            <span><i class="fas fa-info-circle"></i> Pusat Informasi</span>
                            <i class="fas fa-chevron-down small transition"></i>
                        </a>
                        <div class="collapse {{ request()->is('admin/messages*', 'admin/visitors*', 'admin/organization*') ? 'show' : '' }}" id="collapseInfo" data-bs-parent="#sidebarNav">
                            <div class="nav flex-column bg-dark bg-opacity-10 ms-3 border-start border-secondary border-opacity-25">
                                @if($user->hasPermission('messages'))
                                <a class="nav-link py-2 {{ request()->is('admin/messages*') ? 'active' : '' }}" href="{{ route('admin.messages.index') }}">Inbox Pesan</a>
                                @endif

                                @if($user->hasPermission('visitors'))
                                <a class="nav-link py-2 {{ request()->is('admin/visitors*') ? 'active' : '' }}" href="{{ route('admin.visitors.index') }}">Statistik Pengunjung</a>
                                @endif

                                @if($user->hasPermission('organization'))
                                <a class="nav-link py-2 {{ request()->is('admin/organization*') ? 'active' : '' }}" href="{{ route('admin.organization.index') }}">Struktur Organisasi</a>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Group: Administrasi & Keuangan -->
                    @if($user->role === 'admin' || $user->hasPermission('finances'))
                    <div class="nav-item">
                        <a class="nav-link d-flex justify-content-between align-items-center {{ request()->is('admin/users*', 'admin/settings*', 'admin/finances*') ? 'active' : 'collapsed' }}" 
                           data-bs-toggle="collapse" href="#collapseAdmin">
                            <span><i class="fas fa-user-shield"></i> Administrasi</span>
                            <i class="fas fa-chevron-down small transition"></i>
                        </a>
                        <div class="collapse {{ request()->is('admin/users*', 'admin/settings*', 'admin/finances*') ? 'show' : '' }}" id="collapseAdmin" data-bs-parent="#sidebarNav">
                            <div class="nav flex-column bg-dark bg-opacity-10 ms-3 border-start border-secondary border-opacity-25">
                                @if($user->role === 'admin')
                                <a class="nav-link py-2 {{ request()->is('admin/users*') ? 'active' : '' }}" href="{{ route('admin.users.index') }}">Manajemen User</a>
                                <a class="nav-link py-2 {{ request()->is('admin/settings*') ? 'active' : '' }}" href="{{ route('admin.settings.index') }}">Pengaturan Web</a>
                                @endif
                                
                                @if($user->hasPermission('finances'))
                                <a class="nav-link py-2 {{ request()->is('admin/finances*') ? 'active' : '' }}" href="{{ route('admin.finances.index') }}">Laporan Keuangan</a>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endif

                    <div class="mt-auto p-3">
                        <hr>
                        <a class="nav-link text-warning p-2" href="{{ route('home') }}">
                            <i class="fas fa-external-link-alt"></i> Lihat Situs
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="nav-link bg-transparent border-0 text-danger w-100 text-start p-2">
                                <i class="fas fa-sign-out-alt"></i> Keluar
                            </button>
                        </form>
                    </div>
                </nav>
            </div>

            <!-- Main Content -->
            <div class="col-md-10">
                <header class="admin-header d-flex justify-content-between align-items-center">
                    <h4 class="m-0 fw-bold">@yield('page_title', 'Dashboard')</h4>
                    <div class="user-info">
                        <span class="text-muted me-2">Halo, <strong>{{ auth()->user()->name }}</strong></span>
                        <i class="fas fa-user-circle fa-lg"></i>
                    </div>
                </header>

                <main class="p-4">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @yield('content')
                </main>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
    @yield('scripts')
</body>
</html>
