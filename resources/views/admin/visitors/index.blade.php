@extends('layouts.admin')

@section('page_title', 'Statistik Pengunjung')

@section('content')
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4 text-center">
                <div class="bg-primary bg-opacity-10 p-3 rounded-circle d-inline-block mb-3">
                    <i class="fas fa-users text-primary fs-3"></i>
                </div>
                <h6 class="text-uppercase small fw-bold text-muted">Total Pengunjung</h6>
                <h3 class="fw-bold mb-0">{{ number_format($uniqueVisitors) }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4 text-center">
                <div class="bg-success bg-opacity-10 p-3 rounded-circle d-inline-block mb-3">
                    <i class="fas fa-user-check text-success fs-3"></i>
                </div>
                <h6 class="text-uppercase small fw-bold text-muted">Hari Ini (Unik)</h6>
                <h3 class="fw-bold mb-0 text-success">{{ number_format($todayUnique) }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4 text-center">
                <div class="bg-info bg-opacity-10 p-3 rounded-circle d-inline-block mb-3">
                    <i class="fas fa-eye text-info fs-3"></i>
                </div>
                <h6 class="text-uppercase small fw-bold text-muted">Total Tayangan</h6>
                <h3 class="fw-bold mb-0">{{ number_format($totalViews) }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4 text-center">
                <div class="bg-warning bg-opacity-10 p-3 rounded-circle d-inline-block mb-3 position-relative">
                    <i class="fas fa-pulse text-warning fs-3"></i>
                    <span class="position-absolute top-25 start-75 translate-middle p-2 bg-success border border-light rounded-circle"></span>
                </div>
                <h6 class="text-uppercase small fw-bold text-muted">Online (5 Menit)</h6>
                <h3 class="fw-bold mb-0">{{ number_format($onlineVisitors) }}</h3>
            </div>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-header bg-white p-4 border-0">
                <h5 class="fw-bold m-0">Grafik Kunjungan (7 Hari Terakhir)</h5>
            </div>
            <div class="card-body">
                <div style="position: relative; height: 350px;">
                    <canvas id="visitorChart"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm rounded-4 h-100 bg-primary text-white">
            <div class="card-body p-4 d-flex flex-column justify-content-center text-center">
                <i class="fas fa-chart-line fa-3x mb-3"></i>
                <h5 class="fw-bold">Tampilkan di Sidebar?</h5>
                <p class="small mb-4">Anda dapat menampilkan statistik ini di sidebar website dengan menambahkan widget baru.</p>
                <div class="bg-white bg-opacity-20 p-3 rounded-3 text-start mb-4">
                    <ol class="small mb-0 ps-3">
                        <li>Buka menu <strong>Sidebar Widgets</strong></li>
                        <li>Klik <strong>Tambah Widget</strong></li>
                        <li>Pilih Tipe: <strong>Statistik Pengunjung</strong></li>
                        <li>Klik <strong>Simpan</strong></li>
                    </ol>
                </div>
                <a href="{{ route('admin.sidebar-widgets.create') }}" class="btn btn-light fw-bold rounded-pill text-decoration-none text-primary">
                    Ke Pengaturan Widget
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-lg-12">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-white p-4 border-0">
                <h5 class="fw-bold m-0"><i class="fas fa-globe-asia me-2 text-primary"></i>Asal Negara (Top 10)</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4">Negara</th>
                                <th class="text-center">Pengunjung Unik</th>
                                <th class="text-end pe-4">Persentase</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $totalUniqueVal = $topCountries->sum('unique_visitors') ?: 1; @endphp
                            @forelse($topCountries as $tc)
                            <tr>
                                <td class="ps-4">
                                    <div class="d-flex align-items-center">
                                        @if($tc->country_code)
                                            <img src="https://flagcdn.com/24x18/{{ strtolower($tc->country_code) }}.png" width="20" height="15" class="me-2 rounded-1 shadow-sm" alt="{{ $tc->country }}">
                                        @endif
                                        <span>{{ $tc->country ?: 'Unknown' }}</span>
                                    </div>
                                </td>
                                <td class="text-center fw-bold">{{ number_format($tc->unique_visitors) }}</td>
                                <td class="pe-4 text-end">
                                    <div class="d-flex align-items-center justify-content-end">
                                        <div class="progress flex-grow-1 me-2" style="height: 6px; width: 60px;">
                                            <div class="progress-bar bg-primary" role="progressbar" style="width: {{ ($tc->unique_visitors / $totalUniqueVal) * 100 }}%"></div>
                                        </div>
                                        <small class="text-muted">{{ round(($tc->unique_visitors / $totalUniqueVal) * 100, 1) }}%</small>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="3" class="text-center py-4 text-muted">Belum ada data negara.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-header bg-white p-4 border-0">
        <h5 class="fw-bold m-0">Log Kunjungan Terbaru</h5>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4">Waktu</th>
                        <th>IP Address</th>
                        <th>Negara</th>
                        <th>Halaman</th>
                        <th>User Agent</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($logs as $log)
                    <tr>
                        <td class="ps-4 small text-muted">{{ $log->created_at->diffForHumans() }}</td>
                        <td><code>{{ $log->ip_address }}</code></td>
                        <td>
                            @if($log->country_code)
                                <img src="https://flagcdn.com/16x12/{{ strtolower($log->country_code) }}.png" width="16" height="12" class="me-1 rounded-1 shadow-sm" alt="{{ $log->country_code }}">
                            @endif
                            <small>{{ $log->country ?: '-' }}</small>
                        </td>
                        <td class="small">{{ Str::limit($log->url, 40) }}</td>
                        <td class="small text-muted">{{ Str::limit($log->user_agent, 50) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="p-4">
            {{ $logs->links() }}
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('visitorChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($chartData->pluck('date')) !!},
            datasets: [{
                label: 'Tayangan Halaman',
                data: {!! json_encode($chartData->pluck('views')) !!},
                borderColor: '#4e73df',
                backgroundColor: 'rgba(78, 115, 223, 0.05)',
                fill: true,
                tension: 0.3
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: { beginAtZero: true, grid: { drawBorder: false } },
                x: { grid: { display: false } }
            }
        }
    });
</script>
@endpush
@endsection
