@extends('layouts.admin')

@section('title', 'Laporan Transaksi')
@section('page-title', 'Laporan Transaksi')

@push('styles')
<style>
    :root { --dark-green:#1a3c2e; --medium-green:#2d6a4f; --light-green:#52b788; }

    /* ── Summary Stat Cards ── */
    .stat-mini {
        background: #fff; border-radius: 16px;
        box-shadow: 0 4px 18px rgba(0,0,0,.07);
        padding: 1.25rem 1.5rem;
        display: flex; align-items: center; gap: 1rem;
        transition: transform .2s, box-shadow .2s;
    }
    .stat-mini:hover { transform: translateY(-3px); box-shadow: 0 12px 30px rgba(0,0,0,.11); }
    .stat-mini-icon {
        width: 50px; height: 50px; border-radius: 14px; flex-shrink: 0;
        display: flex; align-items: center; justify-content: center; font-size: 1.2rem;
    }
    .stat-mini-val   { font-size: 1.4rem; font-weight: 800; color: #1f2937; line-height: 1; }
    .stat-mini-label { font-size: .78rem; color: #9ca3af; font-weight: 500; margin-top: .25rem; }

    /* ── Filter Card ── */
    .filter-card {
        background: #fff; border-radius: 18px;
        box-shadow: 0 4px 18px rgba(0,0,0,.07);
        padding: 1.5rem; margin-bottom: 1.5rem;
    }
    .filter-card-title {
        font-size: .82rem; font-weight: 700; color: #374151;
        text-transform: uppercase; letter-spacing: .5px;
        margin-bottom: 1rem;
        display: flex; align-items: center; gap: .5rem;
    }
    .filter-card-title i { color: var(--light-green); }

    .form-label-sm { font-size: .8rem; font-weight: 600; color: #6b7280; margin-bottom: .35rem; }
    .form-control-sm-modern {
        border: 2px solid #e8eae8; border-radius: 10px;
        padding: .55rem .85rem; font-size: .875rem; height: auto;
        transition: border-color .2s, box-shadow .2s;
    }
    .form-control-sm-modern:focus {
        border-color: var(--light-green);
        box-shadow: 0 0 0 4px rgba(82,183,136,.12); outline: none;
    }
    .form-select-modern {
        border: 2px solid #e8eae8; border-radius: 10px;
        padding: .55rem .85rem; font-size: .875rem; height: auto;
        transition: border-color .2s, box-shadow .2s;
    }
    .form-select-modern:focus {
        border-color: var(--light-green);
        box-shadow: 0 0 0 4px rgba(82,183,136,.12); outline: none;
    }

    /* Filter buttons */
    .btn-filter {
        background: linear-gradient(135deg, var(--medium-green), var(--dark-green));
        border: none; color: #fff; font-weight: 600; font-size: .875rem;
        padding: .6rem 1.25rem; border-radius: 10px;
        display: inline-flex; align-items: center; gap: .45rem;
        transition: all .2s; box-shadow: 0 4px 12px rgba(45,106,79,.3);
    }
    .btn-filter:hover { opacity:.9; transform:translateY(-1px); box-shadow:0 8px 20px rgba(45,106,79,.4); color:#fff; }

    .btn-reset {
        background: #f3f4f6; border: 2px solid #e8eae8; color: #374151;
        font-weight: 600; font-size: .875rem; padding: .58rem 1rem;
        border-radius: 10px; text-decoration: none;
        display: inline-flex; align-items: center; gap: .45rem;
        transition: all .2s;
    }
    .btn-reset:hover { background: #e5e7eb; color: #1f2937; }

    /* Export PDF button */
    .btn-export-pdf {
        background: linear-gradient(135deg, #dc2626, #991b1b);
        border: none; color: #fff; font-weight: 700; font-size: .9rem;
        padding: .7rem 1.5rem; border-radius: 12px;
        display: inline-flex; align-items: center; gap: .5rem;
        box-shadow: 0 4px 16px rgba(220,38,38,.35);
        text-decoration: none; transition: all .2s;
    }
    .btn-export-pdf:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 28px rgba(220,38,38,.45);
        color: #fff; opacity: .95;
    }

    /* ── Result header row ── */
    .result-bar {
        display: flex; align-items: center; justify-content: space-between;
        flex-wrap: wrap; gap: 1rem; margin-bottom: 1rem;
    }
    .result-info { font-size: .875rem; font-weight: 600; color: #374151; }
    .result-info span { color: var(--medium-green); }

    /* ── Table ── */
    .table-card {
        background: #fff; border-radius: 18px;
        box-shadow: 0 4px 20px rgba(0,0,0,.07); overflow: hidden;
    }
    .table-modern thead th {
        background: #f8faf8; font-size: .72rem; font-weight: 600;
        text-transform: uppercase; letter-spacing: .5px;
        color: #9ca3af; border: none; padding: .85rem 1.1rem;
    }
    .table-modern tbody td {
        border-color: #f3f4f6; padding: .85rem 1.1rem;
        font-size: .875rem; vertical-align: middle;
    }
    .table-modern tbody tr { transition: background .15s; }
    .table-modern tbody tr:hover { background: #f8faf8; }

    .time-badge {
        display: inline-block; background: #f3f4f6; color: #374151;
        padding: .25rem .65rem; border-radius: 8px; font-size: .78rem; font-weight: 600;
    }
    .total-biaya-badge {
        display: inline-flex; align-items: center; gap: .3rem;
        background: #d1fae5; color: #065f46; padding: .28rem .7rem;
        border-radius: 20px; font-size: .78rem; font-weight: 700;
    }

    /* Status pill */
    .status-pill {
        display: inline-flex; align-items: center; gap: .3rem;
        padding: .3rem .75rem; border-radius: 20px; font-size: .75rem; font-weight: 600;
    }
    .status-dot { width: 6px; height: 6px; border-radius: 50%; background: currentColor; }
    .status-pill.pending  { background: #fef3c7; color: #92400e; }
    .status-pill.approved { background: #d1fae5; color: #065f46; }
    .status-pill.rejected { background: #fee2e2; color: #991b1b; }
    .status-pill.selesai  { background: #dbeafe; color: #1e40af; }

    /* User avatar */
    .user-av {
        width: 32px; height: 32px; border-radius: 8px;
        background: linear-gradient(135deg, var(--light-green), var(--medium-green));
        display: flex; align-items: center; justify-content: center;
        font-size: .77rem; font-weight: 700; color: #fff; flex-shrink: 0;
    }

    /* Pagination */
    .pagination .page-link { border-radius: 8px !important; border: 2px solid #e8eae8; margin: 0 2px; font-size: .82rem; color: #374151; }
    .pagination .page-item.active .page-link { background: var(--medium-green); border-color: var(--medium-green); }
    .pagination .page-link:hover { border-color: var(--light-green); color: var(--medium-green); background: #e8f5ee; }

    /* Empty state */
    .empty-state { text-align: center; padding: 4rem 2rem; }
    .empty-icon  { font-size: 3.5rem; color: #e5e7eb; margin-bottom: 1rem; }

    /* Active filter chips */
    .active-filters { display: flex; flex-wrap: wrap; gap: .4rem; margin-top: .85rem; }
    .filter-chip {
        display: inline-flex; align-items: center; gap: .35rem;
        background: #e8f5ee; color: var(--medium-green); border: 1px solid #a7f3d0;
        padding: .28rem .75rem; border-radius: 20px; font-size: .78rem; font-weight: 600;
    }
</style>
@endpush

@section('content')

{{-- ── Summary Stat Cards ── --}}
{{-- Nilai dihitung dari SELURUH data yang difilter (dikirim oleh controller via $summaryStats) --}}
@php
    $totalTransaksiCount = $summaryStats['totalCount'];
    $totalPendapatan     = $summaryStats['totalPendapatan'];
    $totalSelesai        = $summaryStats['totalSelesai'];
    $totalPending        = $summaryStats['totalPending'];
@endphp

<div class="row g-3 mb-4">
    <div class="col-sm-6 col-xl-3">
        <div class="stat-mini">
            <div class="stat-mini-icon" style="background:#d1fae5; color:#059669;">
                <i class="fas fa-money-bill-wave"></i>
            </div>
            <div>
                <div class="stat-mini-val">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</div>
                <div class="stat-mini-label">Estimasi Pendapatan</div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="stat-mini">
            <div class="stat-mini-icon" style="background:#dbeafe; color:#2563eb;">
                <i class="fas fa-receipt"></i>
            </div>
            <div>
                <div class="stat-mini-val">{{ $totalTransaksiCount }}</div>
                <div class="stat-mini-label">Total Transaksi</div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="stat-mini">
            <div class="stat-mini-icon" style="background:#dcfce7; color:#16a34a;">
                <i class="fas fa-flag-checkered"></i>
            </div>
            <div>
                <div class="stat-mini-val">{{ $totalSelesai }}</div>
                <div class="stat-mini-label">Transaksi Selesai</div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="stat-mini">
            <div class="stat-mini-icon" style="background:#fef3c7; color:#d97706;">
                <i class="fas fa-hourglass-half"></i>
            </div>
            <div>
                <div class="stat-mini-val">{{ $totalPending }}</div>
                <div class="stat-mini-label">Menunggu Konfirmasi</div>
            </div>
        </div>
    </div>
</div>

{{-- ── Filter Form ── --}}
<div class="filter-card">
    <div class="filter-card-title">
        <i class="fas fa-sliders"></i> Filter Laporan
    </div>
    <form action="{{ route('admin.laporan.index') }}" method="GET" id="filterForm">
        <div class="row g-3 align-items-end">
            <div class="col-md-3">
                <div class="form-label-sm">Dari Tanggal</div>
                <input type="date" name="dari" class="form-control form-control-sm-modern"
                       value="{{ request('dari') }}">
            </div>
            <div class="col-md-3">
                <div class="form-label-sm">Sampai Tanggal</div>
                <input type="date" name="sampai" class="form-control form-control-sm-modern"
                       value="{{ request('sampai') }}">
            </div>
            <div class="col-md-3">
                <div class="form-label-sm">Status</div>
                <select name="status" class="form-select form-select-modern">
                    <option value="">— Semua Status —</option>
                    <option value="pending"  {{ request('status') == 'pending'  ? 'selected' : '' }}>Pending</option>
                    <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                    <option value="selesai"  {{ request('status') == 'selesai'  ? 'selected' : '' }}>Selesai</option>
                </select>
            </div>
            <div class="col-md-3">
                <div class="d-flex gap-2">
                    <button type="submit" class="btn-filter flex-fill">
                        <i class="fas fa-search"></i> Terapkan
                    </button>
                    <a href="{{ route('admin.laporan.index') }}" class="btn-reset">
                        <i class="fas fa-rotate-left"></i>
                    </a>
                </div>
            </div>
        </div>

        {{-- Active filter chips --}}
        @if(request('dari') || request('sampai') || request('status'))
        <div class="active-filters">
            @if(request('dari'))
                <div class="filter-chip"><i class="fas fa-calendar"></i> Dari: {{ request('dari') }}</div>
            @endif
            @if(request('sampai'))
                <div class="filter-chip"><i class="fas fa-calendar"></i> Sampai: {{ request('sampai') }}</div>
            @endif
            @if(request('status'))
                <div class="filter-chip"><i class="fas fa-tag"></i> Status: {{ ucfirst(request('status')) }}</div>
            @endif
        </div>
        @endif
    </form>
</div>

{{-- ── Result bar + Export ── --}}
<div class="result-bar">
    <div class="result-info">
        <i class="fas fa-list me-2" style="color:var(--light-green);"></i>
        Menampilkan <span>{{ $totalTransaksiCount }} transaksi</span>
    </div>
    <a href="{{ route('admin.laporan.exportPdf', request()->query()) }}" class="btn-export-pdf">
        <i class="fas fa-file-pdf"></i> Export PDF
    </a>
</div>

{{-- ── Table ── --}}
<div class="table-card">
    <div class="table-responsive">
        <table class="table table-hover table-modern align-middle mb-0">
            <thead>
                <tr>
                    <th style="width:45px;">#</th>
                    <th>User</th>
                    <th>Lapangan</th>
                    <th>Tanggal Booking</th>
                    <th>Jam</th>
                    <th>Durasi</th>
                    <th>Estimasi Biaya</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transaksis as $t)
                @php
                    $jamMulai   = \Carbon\Carbon::parse($t->jam_mulai);
                    $jamSelesai = \Carbon\Carbon::parse($t->jam_selesai);
                    $durasi     = $jamMulai->diffInMinutes($jamSelesai);
                    $totalBiaya = ($durasi / 60) * $t->lapangan->harga_per_jam;
                @endphp
                <tr>
                    <td style="color:#9ca3af; font-size:.8rem;">
                        {{ ($transaksis->currentPage() - 1) * $transaksis->perPage() + $loop->iteration }}
                    </td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <div class="user-av">{{ strtoupper(substr($t->user->name, 0, 1)) }}</div>
                            <div>
                                <div style="font-weight:600; color:#1f2937; font-size:.875rem;">{{ $t->user->name }}</div>
                                <div style="font-size:.73rem; color:#9ca3af;">{{ $t->user->email }}</div>
                            </div>
                        </div>
                    </td>
                    <td style="font-weight:500; color:#374151;">{{ $t->lapangan->nama_lapangan }}</td>
                    <td style="color:#374151;">{{ \Carbon\Carbon::parse($t->tanggal_booking)->format('d M Y') }}</td>
                    <td>
                        <span class="time-badge">
                            {{ substr($t->jam_mulai, 0, 5) }} – {{ substr($t->jam_selesai, 0, 5) }}
                        </span>
                    </td>
                    <td style="color:#6b7280; font-size:.84rem;">
                        {{ $durasi >= 60 ? floor($durasi/60).'j '.($durasi%60 ? ($durasi%60).'m' : '') : $durasi.' mnt' }}
                    </td>
                    <td>
                        <div class="total-biaya-badge">
                            <i class="fas fa-tag"></i>
                            Rp {{ number_format($totalBiaya, 0, ',', '.') }}
                        </div>
                    </td>
                    <td>
                        <span class="status-pill {{ $t->status }}">
                            <span class="status-dot"></span>
                            {{ ucfirst($t->status) }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8">
                        <div class="empty-state">
                            <div class="empty-icon"><i class="fas fa-file-chart-column"></i></div>
                            <h6 style="color:#6b7280;">Tidak ada data untuk filter ini</h6>
                            <p style="font-size:.875rem; color:#9ca3af;">Coba ubah filter atau reset pencarian.</p>
                            <a href="{{ route('admin.laporan.index') }}" class="btn-reset d-inline-flex mt-2">
                                <i class="fas fa-rotate-left"></i> Reset Filter
                            </a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Pagination --}}
<div class="mt-4 d-flex justify-content-end">
    {{ $transaksis->links() }}
</div>

@endsection