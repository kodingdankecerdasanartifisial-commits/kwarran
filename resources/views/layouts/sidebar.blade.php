@if(isset($sidebarWidgets) && $sidebarWidgets->count())
    @foreach($sidebarWidgets as $widget)
        <div class="sidebar-card bg-white shadow mb-4 p-3">
            @if($widget->title)
                <h5 class="mb-2 font-semibold">{{ $widget->title }}</h5>
            @endif

            @if($widget->type === 'agenda')
                @php
                    $events = \App\Models\Event::whereDate('event_date', '>=', now())->orderBy('event_date')->take(5)->get();
                @endphp
                @if($events->count())
                    <ul class="list-unstyled">
                        @foreach($events as $e)
                            <li class="mb-2">
                                <a href="{{ route('agenda.index') }}" class="d-block text-decoration-none">{{ Str::limit($e->title, 80) }}</a>
                                <small class="text-muted">{{ $e->event_date->format('d M Y') }}@if($e->end_date) - {{ $e->end_date->format('d M Y') }}@endif</small>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <div class="text-sm text-muted">Belum ada agenda mendatang.</div>
                @endif

            @elseif($widget->type === 'popular')
                @if(isset($popularPosts) && $popularPosts->count())
                    <div class="popular-posts-widget">
                        @foreach($popularPosts->take(4) as $index => $post)
                            @if($index === 0)
                                {{-- First item: Full width image + Title --}}
                                <div class="mb-3">
                                    <a href="{{ route('posts.show', $post->slug) }}" class="d-block text-decoration-none">
                                        <div class="ratio ratio-16x9 mb-2">
                                            <img src="{{ $post->featured_image ? asset('storage/' . $post->featured_image) : 'https://via.placeholder.com/300x200' }}" alt="{{ $post->title }}" class="img-fluid rounded object-fit-cover">
                                        </div>
                                        <h6 class="fw-bold text-dark mb-1">{{ Str::limit($post->title, 80) }}</h6>
                                        <div class="text-muted small">{{ $post->published_at?->format('d M Y') }}</div>
                                    </a>
                                </div>
                                @if($popularPosts->count() > 1)
                                    <hr class="my-3">
                                    <ul class="list-unstyled mb-0">
                                @endif
                            @else
                                {{-- Other items: Text only --}}
                                <li class="mb-2">
                                    <a href="{{ route('posts.show', $post->slug) }}" class="text-decoration-none text-dark d-flex align-items-start">
                                        <i class="fas fa-angle-right mt-1 me-2 text-warning"></i>
                                        <span>{{ Str::limit($post->title, 60) }}</span>
                                    </a>
                                </li>
                            @endif
                        @endforeach
                        @if($popularPosts->count() > 1)
                            </ul>
                        @endif
                    </div>
                @else
                    <div class="text-sm text-muted">Belum ada artikel populer.</div>
                @endif

            @elseif($widget->type === 'visitor')
                <div class="visitor-stats p-2">
                    <div class="d-flex justify-content-between mb-2 small">
                        <span><i class="fas fa-user-clock me-2 text-primary"></i>Online:</span>
                        <span class="fw-bold">{{ number_format($visitorStats['online'] ?? 0) }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2 small">
                        <span><i class="fas fa-user-plus me-2 text-success"></i>Hari Ini:</span>
                        <span class="fw-bold">{{ number_format($visitorStats['today'] ?? 0) }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2 small">
                        <span><i class="fas fa-calendar-day me-2 text-info"></i>Kemarin:</span>
                        <span class="fw-bold">{{ number_format($visitorStats['yesterday'] ?? 0) }}</span>
                    </div>
                    <div class="d-flex justify-content-between small">
                        <span><i class="fas fa-users me-2 text-warning"></i>Total:</span>
                        <span class="fw-bold">{{ number_format($visitorStats['total'] ?? 0) }}</span>
                    </div>
                </div>

            @elseif($widget->type === 'html')
                <div class="widget-content-html">
                    {!! $widget->content !!}
                </div>
            @endif
        </div>
    @endforeach
@else
    <div class="sidebar-card bg-white shadow">
        <!-- Profile Banner -->
        <div class="profile-banner bg-gradient-to-r from-yellow-400 to-red-600 text-white">
            <div class="p-6 text-center">
                @php
                    $profileImage = \App\Models\Setting::get('sidebar_profile_image');
                    $profileName = \App\Models\Setting::get('sidebar_profile_name', 'Kak GKR Hayu');
                    $profileBio = \App\Models\Setting::get('sidebar_profile_bio', 'Tokoh & Pembina');
                    $profileLink = \App\Models\Setting::get('sidebar_profile_link', '#');
                @endphp

                <img src="{{ $profileImage ? asset('storage/' . $profileImage) : 'https://via.placeholder.com/140' }}" alt="{{ $profileName }}" class="mx-auto rounded-circle img-fluid" style="width:100%;max-width:140px;height:auto;border:4px solid #fff;">
                <h3 class="mt-3 font-semibold text-lg">{{ $profileName }}</h3>
                <p class="text-sm opacity-90">{{ $profileBio }}</p>
                <a href="{{ $profileLink }}" class="mt-3 inline-block bg-white text-[#4B2C20] font-semibold px-4 py-2 rounded-full shadow-sm">Profil</a>
            </div>
        </div>

        <!-- Popular Articles -->
        <div class="p-4">
            <h4 class="font-semibold mb-3">Sering Banget Dibaca</h4>
            <ul class="space-y-4">
                @if(isset($popularPosts) && $popularPosts->count())
                    <div class="popular-posts-widget">
                        @foreach($popularPosts->take(4) as $index => $post)
                            @if($index === 0)
                                <div class="mb-3">
                                    <a href="{{ route('posts.show', $post->slug) }}" class="d-block text-decoration-none">
                                        <div class="ratio ratio-16x9 mb-2">
                                            <img src="{{ $post->featured_image ? asset('storage/' . $post->featured_image) : 'https://via.placeholder.com/300x200' }}" alt="{{ $post->title }}" class="img-fluid rounded object-fit-cover">
                                        </div>
                                        <h6 class="fw-bold text-dark mb-1">{{ Str::limit($post->title, 80) }}</h6>
                                        <div class="text-muted small">{{ $post->published_at?->format('d M Y') }}</div>
                                    </a>
                                </div>
                                @if($popularPosts->count() > 1)
                                    <hr class="my-3">
                                    <ul class="list-unstyled mb-0">
                                @endif
                            @else
                                <li class="mb-2">
                                    <a href="{{ route('posts.show', $post->slug) }}" class="text-decoration-none text-dark d-flex align-items-start">
                                        <i class="fas fa-angle-right mt-1 me-2 text-warning"></i>
                                        <span>{{ Str::limit($post->title, 60) }}</span>
                                    </a>
                                </li>
                            @endif
                        @endforeach
                        @if($popularPosts->count() > 1)
                            </ul>
                        @endif
                    </div>
                @else
                    <div class="text-sm text-muted">Belum ada artikel populer.</div>
                @endif
        </div>
    </div>
@endif
