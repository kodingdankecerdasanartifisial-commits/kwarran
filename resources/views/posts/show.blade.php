@extends('layouts.public')

@section('title', $post->title . ' - Kwarran Bekasi Timur')

@section('content')
<!-- Page Header -->


<div class="container mb-5">
    @php
        $isMateri = $post->categories()->where('type', 'materi')->exists();
    @endphp
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none" style="color: var(--primary-color);">Beranda</a></li>
            @if($isMateri)
                <li class="breadcrumb-item"><a href="{{ route('materi.index') }}" class="text-decoration-none" style="color: var(--primary-color);">Materi</a></li>
            @else
                <li class="breadcrumb-item"><a href="{{ route('posts.index') }}" class="text-decoration-none" style="color: var(--primary-color);">Berita</a></li>
            @endif
            
            @php $category = $post->categories()->first(); @endphp
            @if($category)
            <li class="breadcrumb-item"><a href="{{ route('categories.show', $category->slug) }}" class="text-decoration-none" style="color: var(--primary-color);">{{ $category->name }}</a></li>
            @endif
            <li class="breadcrumb-item active">{{ Str::limit($post->title, 50) }}</li>
        </ol>
    </nav>

    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-8">
            <article class="card border-0 shadow-sm rounded-3 overflow-hidden mb-4">
                @if($post->thumbnail_url)
                <img src="{{ $post->thumbnail_url }}" class="img-fluid w-100" alt="{{ $post->title }}" style="max-height: 500px; object-fit: cover;">
                @endif
                
                <div class="card-body p-4 p-md-5">
                    <!-- Post Meta -->
                    <div class="mb-4">
                        @if($post->category)
                        <a href="{{ route('categories.show', $post->category->slug) }}" class="post-category">
                            {{ $post->category->name }}
                        </a>
                        @endif
                        <h1 class="fw-bold mt-2">{{ $post->title }}</h1>
                    </div>

                    <!-- Post Meta Info -->
                    <div class="d-flex flex-wrap gap-3 text-muted mb-4 pb-3 border-bottom">
                        <small><i class="far fa-calendar-alt me-1"></i> {{ $post->published_at?->format('d F Y') }}</small>
                        <small><i class="far fa-user me-1"></i> {{ $post->author }}</small>
                        <small><i class="far fa-folder me-1"></i> {{ $post->category?->name ?? 'Uncategorized' }}</small>
                    </div>

                    <div id="post-content-container">
                        @if($post->is_html)
                            <!-- High Performance Isolated Iframe: Maximum Full-Page feeling while maintaining layout safety -->
                            <div class="post-iframe-wrapper" style="position: relative; width: 100%; min-height: 1500px; background: #fff; border-radius: 12px; overflow: hidden; box-shadow: 0 10px 40px rgba(0,0,0,0.08); border: 1px solid #eee;">
                                <iframe 
                                    id="post-html-iframe" 
                                    style="width: 100%; border: none; overflow: hidden; display: block; height: 1500px; transition: height 0.3s ease-out;" 
                                    scrolling="no"
                                    allowfullscreen
                                ></iframe>
                            </div>

                            <script>
                                (function() {
                                    const iframe = document.getElementById('post-html-iframe');
                                    if (!iframe) return;

                                    const rawContent = {!! json_encode($post->content) !!};
                                    const embedCode = {!! json_encode($post->embed_code) !!} || '';
                                    
                                    // Robust resize script with extra buffer for "full" feel
                                    const resizeScript = `
                                        <script>
                                            function sendHeight() {
                                                // Get the maximum height from body and documentElement
                                                const height = Math.max(
                                                    document.documentElement.scrollHeight,
                                                    document.body.scrollHeight,
                                                    document.documentElement.offsetHeight,
                                                    document.body.offsetHeight
                                                );
                                                window.parent.postMessage({ type: 'resize-html', height: height }, '*');
                                            }
                                            // Run multiple times as dynamic content (Tailwind CDN) loads
                                            window.addEventListener('load', () => setTimeout(sendHeight, 300));
                                            window.addEventListener('load', () => setTimeout(sendHeight, 1000));
                                            window.addEventListener('load', () => setTimeout(sendHeight, 3000));
                                            window.addEventListener('resize', sendHeight);
                                            
                                            // Periodic check for dynamic height changes (essential for JS-heavy tools)
                                            let currentH = 0;
                                            setInterval(() => {
                                                const h = document.documentElement.scrollHeight;
                                                if (h !== currentH) {
                                                    currentH = h;
                                                    sendHeight();
                                                }
                                            }, 1000);
                                        <\\/script>
                                    `;

                                    // Inject script before closing body or at the end
                                    let fullHtml = (embedCode + rawContent);
                                    if (fullHtml.includes('</body>')) {
                                        fullHtml = fullHtml.replace('</body>', resizeScript + '</body>');
                                    } else {
                                        fullHtml += resizeScript;
                                    }

                                    iframe.srcdoc = fullHtml;
                                })();

                                window.addEventListener('message', function(event) {
                                    if (event.data.type === 'resize-html' && event.data.height) {
                                        const iframe = document.getElementById('post-html-iframe');
                                        if (iframe) {
                                            // Respect 1500px minimum or expand if content is larger
                                            const finalHeight = Math.max(event.data.height + 50, 1500);
                                            iframe.style.height = finalHeight + 'px';
                                        }
                                    }
                                }, false);
                            </script>
                        @else
                            <!-- Standard Post Rendering with Iframe Sandbox -->
                            <div class="standard-post-view">
                                @if($post->youtube_url)
                                    @php
                                        $youtubeId = preg_replace('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', '$1', $post->youtube_url);
                                    @endphp
                                    <div class="ratio ratio-16x9 mb-4 rounded overflow-hidden shadow-sm">
                                        <iframe src="https://www.youtube.com/embed/{{ $youtubeId }}" frameborder="0" allowfullscreen></iframe>
                                    </div>
                                @endif

                                @if($post->embed_code)
                                    <div class="embed-code-wrapper mb-4 rounded overflow-hidden">
                                        {!! $post->embed_code !!}
                                    </div>
                                @endif

                                @if($post->material_pdf)
                                    <div class="card bg-light border-0 mb-4">
                                        <div class="card-body d-flex align-items-center">
                                            <i class="fas fa-file-pdf fa-3x text-danger me-3"></i>
                                            <div>
                                                <h6 class="fw-bold mb-1">Dokumen Materi</h6>
                                                <a href="{{ asset('storage/' . $post->material_pdf) }}" class="btn btn-sm btn-outline-danger" target="_blank">Download PDF</a>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <div class="post-sandbox-wrapper" style="position: relative; width: 100%;">
                                    <iframe id="post-sandbox-iframe" style="width: 100%; border: none; overflow: hidden; display: block; height: 100px; transition: height 0.2s ease;" scrolling="no"></iframe>
                                </div>

                                <script>
                                    (function() {
                                        const iframe = document.getElementById('post-sandbox-iframe');
                                        const rawContent = {!! json_encode($post->content) !!}; 
                                        const defaultStyles = `<style>
                                            body { font-family: 'Inter', sans-serif; line-height: 1.8; font-size: 1.1rem; color: #333; margin: 0; padding: 15px; overflow-x: hidden; }
                                            * { max-width: 100%; box-sizing: border-box; }
                                            img { height: auto; margin: 20px 0; border-radius: 8px; box-shadow: 0 5px 15px rgba(0,0,0,0.05); }
                                            p { margin-bottom: 1.5rem; }
                                            h1, h2, h3, h4, h5, h6 { margin-top: 30px; margin-bottom: 20px; font-weight: 700; color: #4B2C20; }
                                            blockquote { background: #f9f9f9; border-left: 5px solid #F2C94C; padding: 20px 30px; margin: 30px 0; font-style: italic; }
                                        </style>`;
                                        const resizeScript = `<script>
                                            function sendHeight() {
                                                const height = Math.max(document.body.scrollHeight, document.body.offsetHeight, document.documentElement.scrollHeight);
                                                window.parent.postMessage({ type: 'resize', height: height }, '*');
                                            }
                                            window.addEventListener('load', sendHeight);
                                            window.addEventListener('resize', sendHeight);
                                            setInterval(sendHeight, 1000);
                                        <\\/script>`;
                                        if (iframe) {
                                            iframe.srcdoc = '<!DOCTYPE html><html><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><base target="_blank">' + defaultStyles + '</head><body>' + (rawContent || '') + resizeScript + '</body></html>';
                                        }
                                    })();
                                    window.addEventListener('message', function(event) {
                                        if (event.data.type === 'resize' && event.data.height) {
                                            const iframe = document.getElementById('post-sandbox-iframe');
                                            if (iframe) iframe.style.height = event.data.height + 'px';
                                        }
                                    }, false);
                                </script>
                            </div>
                        @endif
                    </div>

                    <!-- Share Buttons -->
                    <div class="mt-5 pt-4 border-top">
                        <h6 class="fw-bold mb-3">BAGIKAN ARTIKEL:</h6>
                        <div class="d-flex flex-wrap gap-2">
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ url()->current() }}" class="btn btn-sm btn-outline-dark" target="_blank">
                                <i class="fab fa-facebook-f me-2"></i>Facebook
                            </a>
                            <a href="https://twitter.com/intent/tweet?url={{ url()->current() }}&text={{ $post->title }}" class="btn btn-sm btn-outline-dark" target="_blank">
                                <i class="fab fa-twitter me-2"></i>Twitter
                            </a>
                            <a href="https://wa.me/?text={{ $post->title }} {{ url()->current() }}" class="btn btn-sm btn-outline-dark" target="_blank">
                                <i class="fab fa-whatsapp me-2"></i>WhatsApp
                            </a>
                        </div>
                    </div>
                </div>
            </article>

            <!-- Related Posts -->
            @if($relatedPosts->count() > 0)
            <section class="mt-5">
                <h4 class="fw-bold mb-4">ARTIKEL TERKAIT</h4>
                <div class="row">
                    @foreach($relatedPosts as $relatedPost)
                    <div class="col-md-6 mb-3">
                        <div class="card post-card h-100 shadow-sm border-0">
                            @if($relatedPost->thumbnail_url)
                            <a href="{{ route('posts.show', $relatedPost->slug) }}">
                                <img src="{{ $relatedPost->thumbnail_url }}" class="card-img-top" alt="{{ $relatedPost->title }}" style="height: 180px; object-fit: cover;">
                            </a>
                            @endif
                            <div class="card-body">
                                <div class="text-muted small mb-2"><i class="far fa-calendar-alt me-1"></i> {{ $relatedPost->published_at?->format('d M Y') }}</div>
                                <h6 class="card-title fw-bold">
                                    <a href="{{ route('posts.show', $relatedPost->slug) }}" class="text-decoration-none text-dark">
                                        {{ Str::limit($relatedPost->title, 50) }}
                                    </a>
                                </h6>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </section>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            @include('layouts.sidebar')
        </div>
    </div>
    </div>
</div>

<style>
    .post-content {
        line-height: 1.8;
        font-size: 1.1rem;
        color: #333;
    }
    .post-content p { margin-bottom: 1.5rem; }
    .post-content img {
        max-width: 100%;
        height: auto;
        margin: 20px 0;
        border-radius: 8px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    }
    .post-content h2, .post-content h3 {
        margin-top: 30px;
        margin-bottom: 20px;
        font-weight: 700;
        color: var(--primary-color);
    }
    .post-content blockquote {
        background: #f9f9f9;
        border-left: 5px solid var(--secondary-color);
        padding: 20px 30px;
        margin: 30px 0;
        font-style: italic;
        font-size: 1.2rem;
    }
</style>
@endsection

