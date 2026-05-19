@extends('layouts.user')

@section('title', 'Dashboard User')

@push('styles')
<style>
    :root { --dark-green:#1a3c2e; --medium-green:#2d6a4f; --light-green:#52b788; }

    /* ── Hero Banner ── */
    .hero-banner {
        background: linear-gradient(135deg, #0d2318 0%, var(--dark-green) 45%, #1e5c3a 100%);
        padding: 3.5rem 0 5rem;
        position: relative; overflow: hidden;
    }
    .hero-banner::before {
        content: '';
        position: absolute; inset: 0;
        background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%2352b788' fill-opacity='0.06'%3E%3Ccircle cx='30' cy='30' r='20'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        animation: bgScroll 20s linear infinite;
    }
    @keyframes bgScroll { from { background-position: 0 0; } to { background-position: 60px 60px; } }
    .hero-content { position: relative; z-index: 2; }
    .hero-greeting { font-size: .85rem; color: var(--light-green); font-weight: 600; letter-spacing: 1px; text-transform: uppercase; margin-bottom: .5rem; }
    .hero-title { font-size: 2rem; font-weight: 800; color: #fff; margin-bottom: .75rem; line-height: 1.2; }
    .hero-subtitle { font-size: .95rem; color: rgba(255,255,255,.65); margin-bottom: 1.75rem; }
    .hero-stats { display: flex; gap: 1.5rem; flex-wrap: wrap; }
    .hero-stat { text-align: center; }
    .hero-stat-num { font-size: 1.5rem; font-weight: 800; color: var(--light-green); }
    .hero-stat-label { font-size: .75rem; color: rgba(255,255,255,.55); }

    .btn-hero-book {
        background: linear-gradient(135deg, var(--light-green), #40a070);
        border: none; color: #fff; font-weight: 700;
        padding: .85rem 2rem; border-radius: 12px; font-size: .95rem;
        text-decoration: none; display: inline-flex; align-items: center; gap: .6rem;
        box-shadow: 0 8px 25px rgba(82,183,136,.4);
        transition: all .25s;
    }
    .btn-hero-book:hover { transform: translateY(-2px); box-shadow: 0 12px 35px rgba(82,183,136,.5); color: #fff; }

    /* ── Search & Filter bar ── */
    .search-bar-section {
        margin-top: -2rem; position: relative; z-index: 10;
        padding: 0 0 1.5rem;
    }
    .search-card {
        background: #fff; border-radius: 16px;
        box-shadow: 0 8px 30px rgba(0,0,0,.12);
        padding: 1.25rem 1.5rem;
    }
    .search-input-wrap { position: relative; }
    .search-input-wrap i { position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: #9ca3af; }
    .search-input-wrap input {
        padding-left: 2.75rem; border: 2px solid #e8eae8;
        border-radius: 10px; font-size: .9rem; height: 44px;
    }
    .search-input-wrap input:focus { border-color: var(--light-green); box-shadow: 0 0 0 4px rgba(82,183,136,.12); outline: none; }

    
    .section-title { font-size: 1.15rem; font-weight: 700; color: #1f2937; margin-bottom: 1.25rem; display: flex; align-items: center; gap: .6rem; }
    .section-title-line { flex: 1; height: 2px; background: linear-gradient(to right, var(--light-green), transparent); }

    .court-card {
        border: none; border-radius: 18px; overflow: hidden;
        box-shadow: 0 4px 20px rgba(0,0,0,.08);
        transition: transform .25s, box-shadow .25s;
        background: #fff; position: relative;
    }
    .court-card:hover { transform: translateY(-7px); box-shadow: 0 20px 50px rgba(0,0,0,.15); }
    .court-card-img { height: 180px; object-fit: cover; width: 100%; }
    .court-card-placeholder {
        height: 180px; background: linear-gradient(135deg, #e8f5ee, #f0faf5);
        display: flex; align-items: center; justify-content: center;
        font-size: 3rem; color: #a7d7bc;
    }
    .court-ribbon {
        position: absolute; top: 14px; right: 14px;
        background: linear-gradient(135deg, var(--light-green), #40a070);
        color: #fff; font-size: .7rem; font-weight: 700;
        padding: .3rem .7rem; border-radius: 20px; letter-spacing: .3px;
        box-shadow: 0 4px 12px rgba(82,183,136,.45);
    }
    .court-card-body { padding: 1.1rem 1.25rem 1.25rem; }
    .court-name { font-size: .95rem; font-weight: 700; color: #1f2937; margin-bottom: .3rem; }
    .court-desc { font-size: .8rem; color: #9ca3af; margin-bottom: .85rem; line-height: 1.5; }
    .court-price { font-size: 1.05rem; font-weight: 800; color: var(--medium-green); }
    .court-price span { font-size: .75rem; color: #9ca3af; font-weight: 400; }
    .btn-book-court {
        width: 100%; border: none;
        background: linear-gradient(135deg, var(--medium-green), var(--dark-green));
        color: #fff; font-weight: 600; font-size: .875rem;
        padding: .65rem; border-radius: 10px;
        text-decoration: none; display: block; text-align: center;
        transition: opacity .2s, transform .15s;
        box-shadow: 0 4px 12px rgba(45,106,79,.3);
    }
    .btn-book-court:hover { opacity: .9; transform: translateY(-1px); color: #fff; }

    /* ── Booking History ── */
    .history-card {
        background: #fff; border-radius: 18px;
        box-shadow: 0 4px 20px rgba(0,0,0,.07);
        overflow: hidden;
    }
    .history-card-header {
        padding: 1.1rem 1.5rem;
        border-bottom: 1px solid #f3f4f6;
        display: flex; align-items: center; justify-content: space-between;
    }
    .table-modern thead th {
        background: #f8faf8; font-size: .75rem; font-weight: 600;
        text-transform: uppercase; letter-spacing: .5px; color: #9ca3af;
        border: none; padding: .85rem 1.25rem;
    }
    .table-modern tbody td { border-color: #f3f4f6; padding: .9rem 1.25rem; font-size: .875rem; }
    .table-modern tbody tr:hover { background: #f9fafb; }

    .status-pill {
        display: inline-flex; align-items: center; gap: .3rem;
        padding: .3rem .75rem; border-radius: 20px; font-size: .75rem; font-weight: 600;
    }
    .status-dot { width: 6px; height: 6px; border-radius: 50%; background: currentColor; }
    .status-pill.pending  { background: #fef3c7; color: #92400e; }
    .status-pill.approved { background: #d1fae5; color: #065f46; }
    .status-pill.rejected { background: #fee2e2; color: #991b1b; }
    .status-pill.selesai  { background: #dbeafe; color: #1e40af; }

    .empty-state { text-align: center; padding: 3rem 1rem; }
    .empty-icon  { font-size: 3rem; color: #e5e7eb; margin-bottom: 1rem; }

    .container-page { max-width: 1200px; margin: 0 auto; padding: 0 1.5rem 3rem; }
</style>
@endpush

@section('content')

{{-- ── Hero Banner ── --}}
<div class="hero-banner">
    <div class="container-page">
        <div class="hero-content">
            <div class="hero-greeting"><i class="fas fa-hand-wave me-2"></i>Selamat Datang!</div>
            <h1 class="hero-title">Halo, {{ auth()->user()->name }} 👋</h1>
            <p class="hero-subtitle">Pesan lapangan futsal favoritmu sekarang dan rasakan pengalaman bermain terbaik!</p>
            <div class="d-flex flex-wrap gap-3 align-items-center">
                <a href="#lapangan" class="btn-hero-book">
                    <i class="fas fa-calendar-plus"></i> Booking Sekarang
                </a>
                <div class="hero-stats">
                    <div class="hero-stat">
                        <div class="hero-stat-num">{{ $lapangans->count() }}</div>
                        <div class="hero-stat-label">Lapangan</div>
                    </div>
                    <div class="hero-stat">
                        <div class="hero-stat-num">{{ $myTransaksi->count() }}</div>
                        <div class="hero-stat-label">Booking Saya</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ── Search Bar ── --}}
<div class="container-page">
    <div class="search-bar-section">
        <div class="search-card">
            <div class="row g-2 align-items-center">
                <div class="col-md-8">
                    <div class="search-input-wrap">
                        <i class="fas fa-search"></i>
                        <input type="text" class="form-control" id="searchCourt" placeholder="Cari lapangan...">
                    </div>
                </div>
                <div class="col-md-4">
                    <button class="btn w-100" style="background:var(--medium-green); color:#fff; border-radius:10px; font-weight:600; height:44px;" onclick="filterCourts()">
                        <i class="fas fa-search me-2"></i>Cari Lapangan
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- ── Court Cards ── --}}
    <div class="d-flex align-items-center gap-3 mb-3" id="lapangan">
        <h2 class="section-title mb-0"><i class="fas fa-door-open" style="color:var(--light-green);"></i> Lapangan Tersedia</h2>
        <div class="section-title-line"></div>
        <span style="font-size:.8rem; color:#9ca3af; white-space:nowrap;">{{ $lapangans->count() }} lapangan</span>
    </div>

    <div class="row g-3 mb-5" id="courtGrid">
        @forelse($lapangans as $lapangan)
        <div class="col-sm-6 col-lg-4 col-xl-3 court-item" data-name="{{ strtolower($lapangan->nama_lapangan) }}">
            <div class="court-card">
                <div class="court-ribbon"><i class="fas fa-check-circle me-1"></i>Tersedia</div>
                @if($lapangan->gambar)
                    <img src="{{ asset('storage/' . $lapangan->gambar) }}"
                         class="court-card-img" alt="{{ $lapangan->nama_lapangan }}">
                @else
                    <div class="court-card-placeholder"><i class="fas fa-futbol"></i></div>
                @endif
                <div class="court-card-body">
                    <div class="court-name">{{ $lapangan->nama_lapangan }}</div>
                    <div class="court-desc">{{ Str::limit($lapangan->deskripsi, 65) ?? 'Lapangan futsal berkualitas.' }}</div>
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="court-price">
                            Rp {{ number_format($lapangan->harga_per_jam, 0, ',', '.') }}
                            <span>/jam</span>
                        </div>
                    </div>
                    <a href="{{ route('user.booking.create', $lapangan) }}" class="btn-book-court">
                        <i class="fas fa-calendar-plus me-2"></i>Book Sekarang
                    </a>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="empty-state">
                <div class="empty-icon"><i class="fas fa-futbol"></i></div>
                <h6 style="color:#6b7280;">Belum ada lapangan tersedia</h6>
                <p style="font-size:.875rem; color:#9ca3af;">Hubungi admin untuk informasi lebih lanjut.</p>
            </div>
        </div>
        @endforelse
    </div>

    {{-- ── Booking History ── --}}
    <div class="d-flex align-items-center gap-3 mb-3" id="riwayat">
        <h2 class="section-title mb-0"><i class="fas fa-history" style="color:var(--light-green);"></i> Riwayat Booking</h2>
        <div class="section-title-line"></div>
        <span style="font-size:.8rem; color:#9ca3af; white-space:nowrap;">{{ $myTransaksi->count() }} booking</span>
    </div>

    <div class="history-card">
        <div class="table-responsive">
            <table class="table table-hover table-modern align-middle mb-0">
                <thead>
                    <tr>
                        <th>Lapangan</th>
                        <th>Tanggal</th>
                        <th>Waktu</th>
                        <th>Status</th>
                        <th>Bukti Booking</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($myTransaksi as $t)
                    <tr>
                        <td>
                            <div style="font-weight:600; color:#1f2937;">{{ $t->lapangan->nama_lapangan }}</div>
                        </td>
                        <td style="color:#374151;">{{ \Carbon\Carbon::parse($t->tanggal_booking)->format('d M Y') }}</td>
                        <td>
                            <span style="background:#f3f4f6; padding:.25rem .65rem; border-radius:8px; font-size:.8rem; font-weight:600; color:#374151;">
                                {{ substr($t->jam_mulai, 0, 5) }} – {{ substr($t->jam_selesai, 0, 5) }}
                            </span>
                        </td>
                        <td>
                            <span class="status-pill {{ $t->status }}">
                                <span class="status-dot"></span>
                                {{ ucfirst($t->status) }}
                            </span>
                        </td>
                        <td>
                            @if($t->bukti_pembayaran)
                                <a href="{{ asset('storage/' . $t->bukti_pembayaran) }}" target="_blank" class="btn btn-sm" style="background:#eef2ff; color:#4f46e5; border-radius:8px; font-weight:600; font-size:.75rem; padding: 0.3rem 0.6rem;">
                                    <i class="fas fa-image me-1"></i> Lihat
                                </a>
                            @else
                                <span style="font-size:.75rem; color:#9ca3af; font-style:italic;">-</span>
                            @endif
                        </td>
                        <td style="font-size:.8rem; color:#9ca3af;">
                            @if($t->status === 'pending') Menunggu konfirmasi admin
                            @elseif($t->status === 'approved' || $t->status === 'selesai')
                                <a href="{{ route('user.booking.nota', $t->id) }}" target="_blank" class="btn btn-sm" style="background:#d1fae5; color:#065f46; border-radius:8px; font-weight:600; font-size:.75rem; padding: 0.3rem 0.6rem;">
                                    <i class="fas fa-print me-1"></i> Cetak Nota
                                </a>
                            @elseif($t->status === 'rejected') Booking ditolak
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6">
                            <div class="empty-state">
                                <div class="empty-icon"><i class="fas fa-inbox"></i></div>
                                <h6 style="color:#6b7280;">Belum ada riwayat booking</h6>
                                <p style="font-size:.875rem; color:#9ca3af;">Mulai booking lapangan favoritmu sekarang!</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    document.getElementById('searchCourt').addEventListener('input', filterCourts);
    function filterCourts() {
        const q = document.getElementById('searchCourt').value.toLowerCase().trim();
        document.querySelectorAll('.court-item').forEach(el => {
            el.style.display = (!q || el.dataset.name.includes(q)) ? '' : 'none';
        });
    }
</script>
@endpush