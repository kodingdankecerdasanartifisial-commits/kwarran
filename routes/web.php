<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\Admin\SliderController;
use Illuminate\Support\Facades\Route;

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/berita', [PostController::class, 'index'])->name('posts.index');
Route::get('/berita/{post:slug}', [PostController::class, 'show'])->name('posts.show');
Route::get('/kategori/{category:slug}', [App\Http\Controllers\CategoryController::class, 'show'])->name('categories.show');
Route::get('/agenda', [App\Http\Controllers\AgendaController::class, 'index'])->name('agenda.index');
Route::get('/agenda/feed', [App\Http\Controllers\AgendaController::class, 'getEvents'])->name('agenda.feed');
Route::get('/download', [App\Http\Controllers\DownloadController::class, 'index'])->name('downloads.index');
Route::get('/download/{id}', [App\Http\Controllers\DownloadController::class, 'download'])->name('downloads.download');
Route::get('/statistik', [\App\Http\Controllers\Admin\StatisticsController::class, 'publicIndex'])->name('statistics.public.index');
Route::get('/statistik/{slug}', [\App\Http\Controllers\Admin\StatisticsController::class, 'publicShow'])->name('statistics.public.show');
Route::get('/transparansi', [\App\Http\Controllers\Admin\FinanceController::class, 'publicIndex'])->name('finances.public');
Route::get('/dokumen', [\App\Http\Controllers\Admin\DocumentController::class, 'publicIndex'])->name('documents.public.index');
Route::get('/dokumen/{slug}', [\App\Http\Controllers\Admin\DocumentController::class, 'publicShow'])->name('documents.public.show');
Route::get('/buletin', [\App\Http\Controllers\BulletinController::class, 'index'])->name('bulletins.public');
Route::get('/buletin/{bulletin:slug}', [\App\Http\Controllers\BulletinController::class, 'show'])->name('bulletins.show');
Route::get('/struktur-organisasi', function() {
    $members = \App\Models\OrganizationMember::orderBy('sort_order')->get();
    return view('pages.organization', compact('members'));
})->name('organization.public');
Route::get('/kontak', function () {
    return view('pages.contact'); // Assuming a contact page exists or will exist
});
// Handle contact form submissions
Route::post('/kontak', function (\Illuminate\Http\Request $request) {
    $validated = $request->validate([
        'name' => 'required|max:255',
        'email' => 'required|email',
        'message' => 'required',
    ]);

    // If reCAPTCHA is configured, verify it
    $recaptchaSecret = env('RECAPTCHA_SECRET');
    if ($recaptchaSecret) {
        $token = $request->input('g-recaptcha-response');
        if (! $token) {
            return redirect()->back()->withErrors(['captcha' => 'Harap verifikasi captcha'])->withInput();
        }

        $resp = \Illuminate\Support\Facades\Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => $recaptchaSecret,
            'response' => $token,
            'remoteip' => $request->ip(),
        ]);

        $body = $resp->json();
        if (empty($body['success']) || $body['success'] !== true) {
            return redirect()->back()->withErrors(['captcha' => 'Captcha tidak valid. Silakan coba lagi.'])->withInput();
        }
    }

    // Save to messages table
    \App\Models\Message::create([
        'name' => $validated['name'],
        'email' => $validated['email'],
        'message' => $validated['message'],
    ]);

    return redirect()->back()->with('success', 'Pesan berhasil dikirim. Terima kasih.');
})->name('contact.send');

// Auth Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
    
    // Modules with Granular Permissions
    Route::middleware('permission:posts,dkr')->group(function() {
        Route::get('posts/materi', [\App\Http\Controllers\Admin\PostController::class, 'materi'])->name('posts.materi');
        Route::get('posts/submissions', [\App\Http\Controllers\Admin\PostController::class, 'submissions'])->name('posts.submissions');
        Route::resource('posts', \App\Http\Controllers\Admin\PostController::class);
    });

    Route::middleware('permission:sliders')->group(function() {
        Route::resource('sliders', SliderController::class);
    });

    Route::middleware('permission:bulletins')->group(function() {
        Route::resource('bulletins', \App\Http\Controllers\Admin\BulletinController::class)->names([
            'index' => 'bulletins.index',
            'create' => 'bulletins.create',
            'store' => 'bulletins.store',
            'edit' => 'bulletins.edit',
            'update' => 'bulletins.update',
            'destroy' => 'bulletins.destroy',
        ]);
    });

    Route::middleware('permission:events')->group(function() {
        Route::resource('events', \App\Http\Controllers\Admin\EventController::class);
    });

    Route::middleware('permission:gallery')->group(function() {
        Route::resource('gallery', \App\Http\Controllers\Admin\GalleryController::class);
    });

    Route::middleware('permission:downloads')->group(function() {
        Route::resource('downloads', \App\Http\Controllers\Admin\DownloadController::class)->except(['show']);
    });

    Route::middleware('permission:documents')->group(function() {
        Route::resource('documents', \App\Http\Controllers\Admin\DocumentController::class);
    });

    Route::middleware('permission:statistics')->group(function() {
        Route::post('statistics/upload', [\App\Http\Controllers\Admin\StatisticsController::class, 'upload'])->name('statistics.upload');
        Route::resource('statistics', \App\Http\Controllers\Admin\StatisticsController::class);
    });

    Route::middleware('permission:messages')->group(function() {
        Route::resource('messages', \App\Http\Controllers\Admin\MessageController::class)->only(['index', 'show', 'destroy']);
    });

    Route::middleware('permission:visitors')->group(function() {
        Route::get('visitors', [\App\Http\Controllers\Admin\VisitorController::class, 'index'])->name('visitors.index');
    });

    Route::middleware('permission:organization')->group(function() {
        Route::resource('organization', \App\Http\Controllers\Admin\OrganizationMemberController::class);
    });

    // LPK Management (Termasuk Keuangan)
    Route::middleware('permission:lpk')->group(function() {
        Route::get('lpk', [\App\Http\Controllers\Admin\LpkController::class, 'dashboard']);
        Route::get('lpk/dashboard', [\App\Http\Controllers\Admin\LpkController::class, 'dashboard'])->name('lpk.dashboard');
        Route::get('lpk/landingpage', [\App\Http\Controllers\Admin\LpkController::class, 'landingPage'])->name('lpk.landingpage');
        Route::post('lpk/landingpage', [\App\Http\Controllers\Admin\LpkController::class, 'updateLandingPage'])->name('lpk.landingpage.update');
        Route::resource('lpk/agendas', \App\Http\Controllers\Admin\LpkAgendaController::class, ['names' => 'lpk.agendas']);
        Route::get('lpk/posts', [\App\Http\Controllers\Admin\LpkController::class, 'posts'])->name('lpk.posts');
        
        // Keuangan dipindahkan ke bawah LPK
        Route::get('lpk/finances/calendar', [\App\Http\Controllers\Admin\FinanceController::class, 'calendar'])->name('lpk.finances.calendar');
        Route::resource('lpk/finances', \App\Http\Controllers\Admin\FinanceController::class, ['names' => 'lpk.finances']);

        // WORKAROUND: Alias untuk route lama agar view keuangan tidak error.
        // Ini diperlukan karena view 'admin.finances.index' kemungkinan masih menggunakan route('admin.finances.*')
        Route::get('/finances/calendar', [\App\Http\Controllers\Admin\FinanceController::class, 'calendar'])->name('finances.calendar');
        Route::resource('finances', \App\Http\Controllers\Admin\FinanceController::class);

    });

    Route::middleware('permission:sisran')->group(function() {
        Route::get('sisran/visualize', [\App\Http\Controllers\Admin\SisranController::class, 'visualizeIndex'])->name('sisran.visualize.index');
        Route::get('sisran/{sisran_form}/visualize', [\App\Http\Controllers\Admin\SisranController::class, 'visualizeShow'])->name('sisran.visualize.show');
        Route::post('sisran/{sisran_form}/visualize', [\App\Http\Controllers\Admin\SisranController::class, 'visualizeUpdate'])->name('sisran.visualize.update');
        Route::get('sisran/{sisran_form}/entries', [\App\Http\Controllers\Admin\SisranController::class, 'entries'])->name('sisran.entries');
        Route::resource('sisran', \App\Http\Controllers\Admin\SisranController::class);
    });

    // Admin Only Management
    Route::middleware('role:admin')->group(function() {
        Route::resource('users', \App\Http\Controllers\Admin\UserController::class);
        Route::get('settings', [\App\Http\Controllers\Admin\SettingController::class, 'index'])->name('settings.index');
        Route::post('settings', [\App\Http\Controllers\Admin\SettingController::class, 'update'])->name('settings.update');
        Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class);
        Route::resource('pages', \App\Http\Controllers\Admin\PageController::class);
        Route::post('menus/update-order', [\App\Http\Controllers\Admin\MenuController::class, 'updateOrder'])->name('menus.update-order');
        Route::resource('menus', \App\Http\Controllers\Admin\MenuController::class)->except(['show']);
        Route::resource('sidebar-widgets', \App\Http\Controllers\Admin\SidebarWidgetController::class)->except(['show']);
        Route::resource('digital-banners', \App\Http\Controllers\Admin\DigitalBannerController::class);
    });

    // Gudep Management (accessible by admin OR users with 'gudep' permission)
    Route::middleware('permission:gudep')->group(function() {
        Route::resource('gudep', \App\Http\Controllers\Admin\GudepController::class);
    });

    // DKR Management
    Route::middleware('permission:dkr')->group(function() {
        Route::get('dkr/landingpage', [\App\Http\Controllers\Admin\DkrController::class, 'landingPage'])->name('dkr.landingpage');
        Route::post('dkr/landingpage', [\App\Http\Controllers\Admin\DkrController::class, 'updateLandingPage'])->name('dkr.landingpage.update');
        Route::get('dkr/posts', [\App\Http\Controllers\Admin\DkrController::class, 'posts'])->name('dkr.posts');
        
        // DKR Albums
        Route::resource('dkr/albums', \App\Http\Controllers\Admin\DkrAlbumController::class, [
            'names' => 'dkr.albums'
        ]);
        
        // DKR Agendas
        Route::resource('dkr/agendas', \App\Http\Controllers\Admin\DkrAgendaController::class, [
            'names' => 'dkr.agendas'
        ]);
    });
});

// Gudep Public Landing Page
Route::get('/gudep', [\App\Http\Controllers\GudepController::class, 'index'])->name('gudep.index');
Route::get('/gudep/{slug}', [\App\Http\Controllers\GudepController::class, 'show'])->name('gudep.show');

// DKR Public Landing Page
Route::get('/dkr', [\App\Http\Controllers\DkrController::class, 'index'])->name('dkr.index');
Route::get('/dkr/album/{slug}', [\App\Http\Controllers\DkrController::class, 'showAlbum'])->name('dkr.album.show');

// LPK Public Landing Page
Route::get('/lpk', [\App\Http\Controllers\LpkController::class, 'index'])->name('lpk.index');

// SISRAN Public Routes
Route::get('/sisran/isi/{slug}', [\App\Http\Controllers\SisranPublicController::class, 'showForm'])->name('sisran.public.form');
Route::post('/sisran/isi/{slug}', [\App\Http\Controllers\SisranPublicController::class, 'storeEntry'])->name('sisran.public.store');
Route::get('/sisran/hasil/{slug}', [\App\Http\Controllers\SisranPublicController::class, 'showResult'])->name('sisran.public.result');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/galeri', [\App\Http\Controllers\Admin\GalleryController::class, 'publicIndex'])->name('gallery.public');

require __DIR__.'/auth.php';
// Public submit news (must be before the catch-all page route)
Route::get('/kirim-berita', [App\Http\Controllers\SubmissionController::class, 'create'])->name('posts.submit');
Route::post('/kirim-berita', [App\Http\Controllers\SubmissionController::class, 'store'])->name('posts.submit.store');

// Catch-all Page Route (Must be last)
Route::get('/{page:slug}', [PageController::class, 'show'])->name('pages.show');
// Tes update ke vps