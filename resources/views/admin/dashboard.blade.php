@extends('layouts.admin')

@section('title', 'Dashboard Admin')
@section('page-title', 'Dashboard')

@push('styles')
<style>
    /* ── Stat Cards ── */
    .stat-card-v2 {
        border: none; border-radius: 18px; padding: 1.5rem;
        position: relative; overflow: hidden;
        transition: transform .25s, box-shadow .25s;
        box-shadow: 0 4px 20px rgba(0,0,0,.09);
    }
    .stat-card-v2:hover { transform: translateY(-5px); box-shadow: 0 16px 40px rgba(0,0,0,.15); }
    .stat-card-v2 .card-bg-icon {
        position: absolute; right: -10px; bottom: -10px;
        font-size: 5rem; opacity: .08; pointer-events: none;
    }
    .stat-card-v2 .stat-badge {
        display: inline-flex; align-items: center; gap: .3rem;
        font-size: .72rem; font-weight: 600; padding: .3rem .65rem;
        border-radius: 20px; margin-bottom: .75rem;
    }
    .stat-card-v2 .stat-num { font-size: 2.4rem; font-weight: 800; line-height: 1; margin-bottom: .25rem; }
    .stat-card-v2 .stat-label { font-size: .83rem; opacity: .75; font-weight: 500; }
    .stat-card-v2 .trend {
        display: inline-flex; align-items: center; gap: .25rem;
        font-size: .75rem; font-weight: 600; margin-top: .5rem;
    }

    /* Card gradient colors */
    .card-green { background: linear-gradient(135deg, #1a3c2e, #2d6a4f); color: #fff; }
    .card-blue  { background: linear-gradient(135deg, #1e3a5f, #2563eb); color: #fff; }
    .card-amber { background: linear-gradient(135deg, #78350f, #d97706); color: #fff; }
    .card-teal  { background: linear-gradient(135deg, #134e4a, #0d9488); color: #fff; }

    /* Quick Actions */
    .quick-action-btn {
        display: flex; align-items: center; gap: .75rem;
        background: #fff; border: 2px solid #e8eae8;
        border-radius: 12px; padding: .75rem 1rem;
        text-decoration: none; color: #374151;
        font-size: .875rem; font-weight: 500;
        transition: all .2s;
    }
    .quick-action-btn:hover {
        border-color: var(--light-green);
        background: #e8f5ee; color: var(--dark-green);
        transform: translateY(-2px);
    }
    .quick-action-btn .qa-icon {
        width: 36px; height: 36px; border-radius: 9px;
        display: flex; align-items: center; justify-content: center;
        font-size: .9rem; flex-shrink: 0;
    }

    /* Chart card */
    .chart-card {
        background: #fff; border: none; border-radius: 18px;
        box-shadow: 0 4px 20px rgba(0,0,0,.07); padding: 1.5rem; height: 100%;
    }
    .chart-card-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.25rem; }
    .chart-card-title  { font-size: .95rem; font-weight: 700; color: #1f2937; margin: 0; }

    /* Transactions table */
    .modern-table { background: #fff; border-radius: 18px; box-shadow: 0 4px 20px rgba(0,0,0,.07); overflow: hidden; }
    .modern-table .table { margin: 0; }
    .modern-table .table thead { background: #f8faf8; }
    .modern-table .table thead th {
        font-size: .78rem; font-weight: 600; text-transform: uppercase;
        letter-spacing: .5px; color: #9ca3af; border: none;
        padding: .9rem 1.1rem;
    }
    .modern-table .table tbody td { border-color: #f3f4f6; padding: .85rem 1.1rem; font-size: .875rem; }
    .modern-table .table tbody tr { transition: background .15s; }
    .modern-table .table tbody tr:hover { background: #f8faf8; }

    .avatar-sm {
        width: 32px; height: 32px; border-radius: 9px;
        background: linear-gradient(135deg, var(--light-green), var(--medium-green));
        display: flex; align-items: center; justify-content: center;
        font-size: .78rem; font-weight: 700; color: #fff; flex-shrink: 0;
    }

    /* Status pill */
    .status-pill {
        display: inline-flex; align-items: center; gap: .3rem;
        padding: .3rem .75rem; border-radius: 20px;
        font-size: .75rem; font-weight: 600;
    }
    .status-pill.pending  { background: #fef3c7; color: #92400e; }
    .status-pill.approved { background: #d1fae5; color: #065f46; }
    .status-pill.rejected { background: #fee2e2; color: #991b1b; }
    .status-pill.selesai  { background: #dbeafe; color: #1e40af; }
    .status-dot { width: 6px; height: 6px; border-radius: 50%; background: currentColor; }

    :root { --dark-green:#1a3c2e; --medium-green:#2d6a4f; --light-green:#52b788; }
</style>
@endpush

@section('content')

{{-- ── Stat Cards ── --}}
<div class="row g-3 mb-4">
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card-v2 card-green">
            <div class="stat-badge" style="background:rgba(255,255,255,.15); color:#fff;">
                <i class="fas fa-door-open"></i> Lapangan
            </div>
            <div class="stat-num">{{ $totalLapangan }}</div>
            <div class="stat-label">Total Lapangan Aktif</div>
            <div class="trend" style="color:rgba(255,255,255,.7);">
                <i class="fas fa-arrow-trend-up"></i> Siap disewa
            </div>
            <i class="fas fa-door-open card-bg-icon"></i>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card-v2 card-blue">
            <div class="stat-badge" style="background:rgba(255,255,255,.15); color:#fff;">
                <i class="fas fa-users"></i> Member
            </div>
            <div class="stat-num">{{ $totalUser }}</div>
            <div class="stat-label">Total User Terdaftar</div>
            <div class="trend" style="color:rgba(255,255,255,.7);">
                <i class="fas fa-arrow-trend-up"></i> Pengguna aktif
            </div>
            <i class="fas fa-users card-bg-icon"></i>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card-v2 card-amber">
            <div class="stat-badge" style="background:rgba(255,255,255,.15); color:#fff;">
                <i class="fas fa-calendar-check"></i> Booking
            </div>
            <div class="stat-num">{{ $totalTransaksi }}</div>
            <div class="stat-label">Total Transaksi</div>
            <div class="trend" style="color:rgba(255,255,255,.7);">
                <i class="fas fa-arrow-trend-up"></i> Semua waktu
            </div>
            <i class="fas fa-calendar-check card-bg-icon"></i>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card-v2 card-teal">
            <div class="stat-badge" style="background:rgba(255,255,255,.15); color:#fff;">
                <i class="fas fa-flag-checkered"></i> Selesai
            </div>
            <div class="stat-num">{{ $chartData['selesai'] }}</div>
            <div class="stat-label">Transaksi Selesai</div>
            <div class="trend" style="color:rgba(255,255,255,.7);">
                <i class="fas fa-circle-check"></i> Terkonfirmasi
            </div>
            <i class="fas fa-flag-checkered card-bg-icon"></i>
        </div>
    </div>
</div>

{{-- ── Quick Actions ── --}}
<div class="row g-2 mb-4">
    <div class="col-12">
        <div style="background:#fff; border-radius:16px; padding:1rem 1.25rem; box-shadow:0 2px 12px rgba(0,0,0,.06);">
            <p class="mb-2 fw-600" style="font-size:.78rem; color:#9ca3af; text-transform:uppercase; letter-spacing:.5px; font-weight:600;">Quick Actions</p>
            <div class="d-flex flex-wrap gap-2">
                <a href="{{ route('admin.lapangan.create') }}" class="quick-action-btn">
                    <div class="qa-icon" style="background:#d1fae5; color:#059669;"><i class="fas fa-plus"></i></div>
                    Tambah Lapangan
                </a>
                <a href="{{ route('admin.transaksi.index') }}" class="quick-action-btn">
                    <div class="qa-icon" style="background:#fef3c7; color:#d97706;"><i class="fas fa-clock"></i></div>
                    Cek Transaksi
                </a>
                <a href="{{ route('admin.users.index') }}" class="quick-action-btn">
                    <div class="qa-icon" style="background:#dbeafe; color:#2563eb;"><i class="fas fa-user-plus"></i></div>
                    Kelola User
                </a>
                <a href="{{ route('admin.laporan.index') }}" class="quick-action-btn">
                    <div class="qa-icon" style="background:#fce7f3; color:#db2777;"><i class="fas fa-file-pdf"></i></div>
                    Export Laporan
                </a>
            </div>
        </div>
    </div>
</div>

{{-- ── Chart & Table ── --}}
<div class="row g-3">
    {{-- Bar + Line Chart --}}
    <div class="col-lg-5">
        <div class="chart-card">
            <div class="chart-card-header">
                <h6 class="chart-card-title"><i class="fas fa-chart-bar me-2 text-success"></i>Status Transaksi</h6>
                <span style="font-size:.75rem; color:#9ca3af;">Overview</span>
            </div>
            <canvas id="transaksiChart" height="240"></canvas>

            {{-- Legend --}}
            <div class="d-flex flex-wrap gap-2 mt-3 justify-content-center">
                <div class="d-flex align-items-center gap-1" style="font-size:.78rem; color:#6b7280;">
                    <span style="width:10px;height:10px;border-radius:3px;background:#f59e0b;display:inline-block;"></span> Pending: <strong>{{ $chartData['pending'] }}</strong>
                </div>
                <div class="d-flex align-items-center gap-1" style="font-size:.78rem; color:#6b7280;">
                    <span style="width:10px;height:10px;border-radius:3px;background:#10b981;display:inline-block;"></span> Approved: <strong>{{ $chartData['approved'] }}</strong>
                </div>
                <div class="d-flex align-items-center gap-1" style="font-size:.78rem; color:#6b7280;">
                    <span style="width:10px;height:10px;border-radius:3px;background:#ef4444;display:inline-block;"></span> Rejected: <strong>{{ $chartData['rejected'] }}</strong>
                </div>
                <div class="d-flex align-items-center gap-1" style="font-size:.78rem; color:#6b7280;">
                    <span style="width:10px;height:10px;border-radius:3px;background:#3b82f6;display:inline-block;"></span> Selesai: <strong>{{ $chartData['selesai'] }}</strong>
                </div>
            </div>
        </div>
    </div>

    {{-- Recent Transactions --}}
    <div class="col-lg-7">
        <div class="chart-card p-0" style="padding:0 !important;">
            <div class="d-flex align-items-center justify-content-between p-4 pb-2">
                <h6 class="chart-card-title mb-0"><i class="fas fa-clock me-2 text-success"></i>Transaksi Terbaru</h6>
                <a href="{{ route('admin.transaksi.index') }}"
                   style="font-size:.8rem; color:var(--medium-green); text-decoration:none; font-weight:600;">
                   Lihat semua <i class="fas fa-arrow-right ms-1"></i>
                </a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead style="background:#f8faf8;">
                        <tr>
                            <th style="font-size:.75rem;font-weight:600;text-transform:uppercase;letter-spacing:.4px;color:#9ca3af;border:none;padding:.75rem 1rem;">User</th>
                            <th style="font-size:.75rem;font-weight:600;text-transform:uppercase;letter-spacing:.4px;color:#9ca3af;border:none;padding:.75rem 1rem;">Lapangan</th>
                            <th style="font-size:.75rem;font-weight:600;text-transform:uppercase;letter-spacing:.4px;color:#9ca3af;border:none;padding:.75rem 1rem;">Tanggal</th>
                            <th style="font-size:.75rem;font-weight:600;text-transform:uppercase;letter-spacing:.4px;color:#9ca3af;border:none;padding:.75rem 1rem;">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transaksiTerbaru->take(8) as $t)
                        <tr style="border-color:#f3f4f6;">
                            <td style="padding:.8rem 1rem;">
                                <div class="d-flex align-items-center gap-2">
                                    <div class="avatar-sm">{{ strtoupper(substr($t->user->name, 0, 1)) }}</div>
                                    <div>
                                        <div style="font-size:.84rem; font-weight:600; color:#1f2937;">{{ $t->user->name }}</div>
                                        <div style="font-size:.72rem; color:#9ca3af;">{{ $t->user->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td style="padding:.8rem 1rem; font-size:.84rem; color:#374151;">{{ $t->lapangan->nama_lapangan }}</td>
                            <td style="padding:.8rem 1rem; font-size:.84rem; color:#374151;">{{ \Carbon\Carbon::parse($t->tanggal_booking)->format('d M Y') }}</td>
                            <td style="padding:.8rem 1rem;">
                                <span class="status-pill {{ $t->status }}">
                                    <span class="status-dot"></span>
                                    {{ ucfirst($t->status) }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">
                                <i class="fas fa-inbox fa-2x mb-2 d-block opacity-25"></i>
                                Belum ada transaksi
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    const pending  = parseInt("{{ $chartData['pending'] }}");
    const approved = parseInt("{{ $chartData['approved'] }}");
    const rejected = parseInt("{{ $chartData['rejected'] }}");
    const selesai  = parseInt("{{ $chartData['selesai'] }}");

    const ctx = document.getElementById('transaksiChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Pending', 'Approved', 'Rejected', 'Selesai'],
            datasets: [
                {
                    type: 'bar',
                    label: 'Jumlah',
                    data: [pending, approved, rejected, selesai],
                    backgroundColor: [
                        'rgba(245,158,11,.85)',
                        'rgba(16,185,129,.85)',
                        'rgba(239,68,68,.85)',
                        'rgba(59,130,246,.85)',
                    ],
                    borderRadius: 8,
                    borderSkipped: false,
                    barPercentage: .6,
                },
                {
                    type: 'line',
                    label: 'Tren',
                    data: [pending, approved, rejected, selesai],
                    borderColor: 'rgba(82,183,136,.8)',
                    backgroundColor: 'rgba(82,183,136,.08)',
                    borderWidth: 2.5,
                    pointBackgroundColor: '#52b788',
                    pointRadius: 4,
                    tension: .4,
                    fill: true,
                }
            ]
        },
        options: {
            responsive: true,
            interaction: { mode: 'index', intersect: false },
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#1f2937',
                    titleColor: '#fff',
                    bodyColor: '#9ca3af',
                    cornerRadius: 10,
                    padding: 10,
                }
            },
            scales: {
                x: { grid: { display: false }, border: { display: false } },
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 1, color: '#9ca3af', font: { size: 11 } },
                    grid: { color: 'rgba(0,0,0,.05)' },
                    border: { display: false }
                }
            }
        }
    });
</script>
@endpush