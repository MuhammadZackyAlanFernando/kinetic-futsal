@extends('layouts.admin')

@section('title', 'Kelola Transaksi')
@section('page-title', 'Kelola Transaksi')

@push('styles')
<style>
    :root { --dark-green:#1a3c2e; --medium-green:#2d6a4f; --light-green:#52b788; }

    /* ── Filter Tabs ── */
    .filter-tabs {
        display: flex; gap: .4rem; flex-wrap: wrap;
        background: #fff; border-radius: 14px;
        padding: .5rem; box-shadow: 0 2px 12px rgba(0,0,0,.06);
        margin-bottom: 1.5rem;
    }
    .filter-tab {
        display: inline-flex; align-items: center; gap: .45rem;
        padding: .5rem 1rem; border-radius: 10px; font-size: .82rem; font-weight: 600;
        cursor: pointer; border: none; background: none; color: #6b7280;
        transition: all .2s; white-space: nowrap;
    }
    .filter-tab:hover  { background: #f3f4f6; color: #374151; }
    .filter-tab.active { background: var(--medium-green); color: #fff; box-shadow: 0 3px 10px rgba(45,106,79,.3); }
    .filter-tab .tab-count {
        background: rgba(255,255,255,.25); color: inherit;
        font-size: .72rem; font-weight: 700; padding: .1rem .45rem;
        border-radius: 20px; min-width: 20px; text-align: center;
    }
    .filter-tab:not(.active) .tab-count { background: #e5e7eb; color: #6b7280; }

    /* ── Table Card ── */
    .table-card {
        background: #fff; border-radius: 18px;
        box-shadow: 0 4px 20px rgba(0,0,0,.07); overflow: hidden;
    }
    .table-card-header {
        display: flex; align-items: center; justify-content: space-between;
        padding: 1.1rem 1.5rem; border-bottom: 1px solid #f3f4f6;
    }
    .table-title { font-size: .95rem; font-weight: 700; color: #1f2937; margin: 0; }
    .result-count { font-size: .8rem; color: #9ca3af; }

    .table-modern thead th {
        background: #f8faf8; font-size: .72rem; font-weight: 600;
        text-transform: uppercase; letter-spacing: .5px;
        color: #9ca3af; border: none; padding: .85rem 1.1rem;
    }
    .table-modern tbody td { border-color: #f3f4f6; padding: .85rem 1.1rem; font-size: .875rem; vertical-align: middle; }
    .table-modern tbody tr { transition: background .15s; }

    /* Row color coding by status */
    .row-pending  { border-left: 3px solid #f59e0b; }
    .row-approved { border-left: 3px solid #10b981; }
    .row-rejected { border-left: 3px solid #ef4444; }
    .row-selesai  { border-left: 3px solid #3b82f6; }

    .row-pending:hover  { background: #fffbf0 !important; }
    .row-approved:hover { background: #f0fdf8 !important; }
    .row-rejected:hover { background: #fff5f5 !important; }
    .row-selesai:hover  { background: #eff6ff !important; }

    /* User avatar */
    .user-av {
        width: 34px; height: 34px; border-radius: 9px;
        background: linear-gradient(135deg, var(--light-green), var(--medium-green));
        display: flex; align-items: center; justify-content: center;
        font-size: .8rem; font-weight: 700; color: #fff; flex-shrink: 0;
    }

    /* Time badge */
    .time-badge {
        display: inline-block;
        background: #f3f4f6; color: #374151;
        padding: .25rem .65rem; border-radius: 8px;
        font-size: .78rem; font-weight: 600;
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

    /* Action buttons */
    .action-btn {
        width: 32px; height: 32px; border: none; border-radius: 8px;
        display: inline-flex; align-items: center; justify-content: center;
        font-size: .8rem; cursor: pointer; transition: all .2s;
        position: relative;
    }
    .action-btn-approve { background: #d1fae5; color: #059669; }
    .action-btn-approve:hover { background: #a7f3d0; transform: scale(1.12); }
    .action-btn-reject  { background: #fee2e2; color: #dc2626; }
    .action-btn-reject:hover  { background: #fecaca; transform: scale(1.12); }
    .action-btn-done    { background: #dbeafe; color: #2563eb; }
    .action-btn-done:hover    { background: #bfdbfe; transform: scale(1.12); }

    /* Tooltip */
    .action-btn::after {
        content: attr(data-tip);
        position: absolute; bottom: calc(100% + 6px); left: 50%;
        transform: translateX(-50%);
        background: #1f2937; color: #fff;
        font-size: .7rem; white-space: nowrap;
        padding: .25rem .55rem; border-radius: 6px;
        opacity: 0; pointer-events: none;
        transition: opacity .15s;
    }
    .action-btn:hover::after { opacity: 1; }

    /* Pagination */
    .pagination .page-link { border-radius: 8px !important; border: 2px solid #e8eae8; margin: 0 2px; font-size: .82rem; color: #374151; }
    .pagination .page-item.active .page-link { background: var(--medium-green); border-color: var(--medium-green); }
    .pagination .page-link:hover { border-color: var(--light-green); color: var(--medium-green); background: #e8f5ee; }

    /* Empty state */
    .empty-state { text-align: center; padding: 4rem 2rem; }
    .empty-icon  { font-size: 3.5rem; color: #e5e7eb; margin-bottom: 1rem; }
</style>
@endpush

@section('content')

{{-- ── Status Filter Tabs ── --}}
<div class="filter-tabs">
    <button class="filter-tab active" data-filter="all" onclick="filterStatus('all', this)">
        <i class="fas fa-list"></i> Semua
        <span class="tab-count">{{ $transaksis->total() }}</span>
    </button>
    <button class="filter-tab" data-filter="pending" onclick="filterStatus('pending', this)">
        <i class="fas fa-clock"></i> Pending
        <span class="tab-count">{{ $transaksis->where('status','pending')->count() }}</span>
    </button>
    <button class="filter-tab" data-filter="approved" onclick="filterStatus('approved', this)">
        <i class="fas fa-check-circle"></i> Approved
        <span class="tab-count">{{ $transaksis->where('status','approved')->count() }}</span>
    </button>
    <button class="filter-tab" data-filter="rejected" onclick="filterStatus('rejected', this)">
        <i class="fas fa-times-circle"></i> Rejected
        <span class="tab-count">{{ $transaksis->where('status','rejected')->count() }}</span>
    </button>
    <button class="filter-tab" data-filter="selesai" onclick="filterStatus('selesai', this)">
        <i class="fas fa-flag-checkered"></i> Selesai
        <span class="tab-count">{{ $transaksis->where('status','selesai')->count() }}</span>
    </button>
</div>

{{-- ── Table ── --}}
<div class="table-card">
    <div class="table-card-header">
        <h2 class="table-title"><i class="fas fa-calendar-check me-2" style="color:var(--light-green);"></i>Data Transaksi</h2>
        <span class="result-count" id="rowCountLabel">Menampilkan {{ $transaksis->count() }} transaksi</span>
    </div>
    <div class="table-responsive">
        <table class="table table-hover table-modern align-middle mb-0" id="transaksiTable">
            <thead>
                <tr>
                    <th style="width:45px;">#</th>
                    <th>User</th>
                    <th>Lapangan</th>
                    <th>Tanggal</th>
                    <th>Waktu</th>
                    <th>Status</th>
                    <th class="text-center" style="width:100px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transaksis as $t)
                <tr class="transaksi-row row-{{ $t->status }}" data-status="{{ $t->status }}">
                    <td style="color:#9ca3af; font-size:.8rem;">{{ $loop->iteration }}</td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <div class="user-av">{{ strtoupper(substr($t->user->name, 0, 1)) }}</div>
                            <div>
                                <div style="font-weight:600; color:#1f2937; font-size:.875rem;">{{ $t->user->name }}</div>
                                <div style="font-size:.74rem; color:#9ca3af;">{{ $t->user->email }}</div>
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
                    <td>
                        <span class="status-pill {{ $t->status }}">
                            <span class="status-dot"></span>
                            {{ ucfirst($t->status) }}
                        </span>
                    </td>
                    <td class="text-center">
                        <div class="d-flex justify-content-center gap-1">
                            {{-- View Payment --}}
                            <button type="button" class="action-btn" style="background:#e0e7ff; color:#4f46e5;"
                                    data-tip="Lihat Pembayaran"
                                    onclick="showPaymentModal('{{ $t->nama_rekening }}', '{{ $t->nomor_rekening }}', '{{ $t->bukti_pembayaran ? asset('storage/' . $t->bukti_pembayaran) : '' }}')">
                                <i class="fas fa-file-invoice-dollar"></i>
                            </button>
                            @if($t->status === 'pending')
                                {{-- Approve --}}
                                <form action="{{ route('admin.transaksi.updateStatus', $t) }}" method="POST">
                                    @csrf @method('PATCH')
                                    <input type="hidden" name="status" value="approved">
                                    <button type="submit" class="action-btn action-btn-approve"
                                            data-tip="Setujui"
                                            onclick="return confirm('Setujui booking ini?')">
                                        <i class="fas fa-check"></i>
                                    </button>
                                </form>
                                {{-- Reject --}}
                                <form action="{{ route('admin.transaksi.updateStatus', $t) }}" method="POST">
                                    @csrf @method('PATCH')
                                    <input type="hidden" name="status" value="rejected">
                                    <button type="submit" class="action-btn action-btn-reject"
                                            data-tip="Tolak"
                                            onclick="return confirm('Tolak booking ini?')">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </form>
                            @elseif($t->status === 'approved')
                                {{-- Selesai --}}
                                <form action="{{ route('admin.transaksi.updateStatus', $t) }}" method="POST">
                                    @csrf @method('PATCH')
                                    <input type="hidden" name="status" value="selesai">
                                    <button type="submit" class="action-btn action-btn-done"
                                            data-tip="Tandai Selesai"
                                            onclick="return confirm('Tandai sebagai selesai?')">
                                        <i class="fas fa-flag-checkered"></i>
                                    </button>
                                </form>
                            @else
                                <span style="color:#d1d5db; font-size:.85rem;">—</span>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7">
                        <div class="empty-state">
                            <div class="empty-icon"><i class="fas fa-inbox"></i></div>
                            <h6 style="color:#6b7280;">Belum ada transaksi masuk</h6>
                            <p style="font-size:.875rem; color:#9ca3af;">Transaksi dari user akan muncul di sini.</p>
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

{{-- Modal Pembayaran --}}
<div class="modal fade" id="paymentModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 16px; border: none;">
            <div class="modal-header" style="border-bottom: 1px solid #f3f4f6; padding: 1.25rem 1.5rem;">
                <h5 class="modal-title" style="font-weight: 700; font-size: 1.1rem; color: #1f2937;"><i class="fas fa-file-invoice-dollar me-2" style="color: var(--medium-green);"></i>Detail Pembayaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="padding: 1.5rem;">
                <div class="mb-3">
                    <label style="font-size: .8rem; color: #6b7280; font-weight: 600;">Nama Rekening</label>
                    <div id="modalNamaRekening" style="font-size: .95rem; color: #1f2937; font-weight: 500;"></div>
                </div>
                <div class="mb-3">
                    <label style="font-size: .8rem; color: #6b7280; font-weight: 600;">Nomor Rekening</label>
                    <div id="modalNomorRekening" style="font-size: .95rem; color: #1f2937; font-weight: 500;"></div>
                </div>
                <div>
                    <label style="font-size: .8rem; color: #6b7280; font-weight: 600; margin-bottom: .5rem; display: block;">Bukti Pembayaran</label>
                    <img id="modalBuktiImage" src="" alt="Bukti Pembayaran" style="width: 100%; border-radius: 12px; border: 1px solid #e5e7eb; display: none;">
                    <div id="modalNoBukti" style="padding: 2rem; text-align: center; background: #f9fafb; border-radius: 12px; color: #9ca3af; font-size: .85rem; display: none;">
                        <i class="fas fa-image fa-2x mb-2"></i><br>Tidak ada bukti pembayaran
                    </div>
                </div>
            </div>
            <div class="modal-footer" style="border-top: 1px solid #f3f4f6; padding: 1rem 1.5rem;">
                <button type="button" class="btn btn-secondary" style="border-radius: 10px; font-size: .875rem; font-weight: 500;" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    function filterStatus(status, btn) {
        // Update active tab
        document.querySelectorAll('.filter-tab').forEach(t => t.classList.remove('active'));
        btn.classList.add('active');

        // Filter rows
        const rows = document.querySelectorAll('.transaksi-row');
        let visible = 0;
        rows.forEach(row => {
            const match = status === 'all' || row.dataset.status === status;
            row.style.display = match ? '' : 'none';
            if (match) visible++;
        });

        // Update count label
        document.getElementById('rowCountLabel').textContent =
            `Menampilkan ${visible} transaksi`;
    }

    function showPaymentModal(nama, nomor, imageSrc) {
        document.getElementById('modalNamaRekening').textContent = nama || '-';
        document.getElementById('modalNomorRekening').textContent = nomor || '-';
        
        const img = document.getElementById('modalBuktiImage');
        const noImg = document.getElementById('modalNoBukti');
        
        if (imageSrc) {
            img.src = imageSrc;
            img.style.display = 'block';
            noImg.style.display = 'none';
        } else {
            img.style.display = 'none';
            noImg.style.display = 'block';
        }
        
        new bootstrap.Modal(document.getElementById('paymentModal')).show();
    }
</script>
@endpush