@extends('layouts.admin')

@section('title', 'Kelola Lapangan')
@section('page-title', 'Kelola Lapangan')

@push('styles')
<style>
    :root { --dark-green:#1a3c2e; --medium-green:#2d6a4f; --light-green:#52b788; }

    /* ── Toolbar ── */
    .page-toolbar {
        display: flex; align-items: center; justify-content: space-between;
        flex-wrap: wrap; gap: 1rem; margin-bottom: 1.5rem;
    }
    .page-toolbar-left { display: flex; align-items: center; gap: .75rem; flex-wrap: wrap; }
    .page-heading { font-size: 1.15rem; font-weight: 700; color: #1f2937; margin: 0; }

    /* Search */
    .search-wrap { position: relative; }
    .search-wrap i { position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #9ca3af; font-size: .85rem; }
    .search-wrap input {
        padding: .55rem .9rem .55rem 2.4rem;
        border: 2px solid #e8eae8; border-radius: 10px;
        font-size: .875rem; width: 220px;
        transition: border-color .2s, box-shadow .2s;
    }
    .search-wrap input:focus {
        border-color: var(--light-green);
        box-shadow: 0 0 0 4px rgba(82,183,136,.12); outline: none;
    }

    /* View toggle */
    .view-toggle { display: flex; gap: 4px; background: #f3f4f6; padding: 4px; border-radius: 10px; }
    .view-btn {
        width: 34px; height: 34px; border: none; border-radius: 7px;
        display: flex; align-items: center; justify-content: center;
        font-size: .85rem; color: #9ca3af; background: none; cursor: pointer;
        transition: all .2s;
    }
    .view-btn.active { background: #fff; color: var(--medium-green); box-shadow: 0 1px 4px rgba(0,0,0,.1); }

    /* Add button */
    .btn-add {
        background: linear-gradient(135deg, var(--medium-green), var(--dark-green));
        border: none; color: #fff; font-weight: 600; font-size: .875rem;
        padding: .55rem 1.25rem; border-radius: 10px; text-decoration: none;
        display: inline-flex; align-items: center; gap: .5rem;
        box-shadow: 0 4px 12px rgba(45,106,79,.3); transition: all .2s;
    }
    .btn-add:hover { opacity:.9; transform:translateY(-1px); box-shadow:0 8px 20px rgba(45,106,79,.4); color:#fff; }

    /* ── TABLE VIEW ── */
    .table-card {
        background: #fff; border-radius: 18px;
        box-shadow: 0 4px 20px rgba(0,0,0,.07); overflow: hidden;
    }
    .table-modern thead th {
        background: #f8faf8; font-size: .73rem; font-weight: 600;
        text-transform: uppercase; letter-spacing: .5px;
        color: #9ca3af; border: none; padding: .85rem 1.1rem;
    }
    .table-modern tbody td { border-color: #f3f4f6; padding: .9rem 1.1rem; font-size: .875rem; vertical-align: middle; }
    .table-modern tbody tr { transition: background .15s; }
    .table-modern tbody tr:hover { background: #f8faf8; }

    .court-thumb {
        width: 72px; height: 52px; object-fit: cover;
        border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,.1);
    }
    .court-thumb-placeholder {
        width: 72px; height: 52px; border-radius: 10px;
        background: linear-gradient(135deg, #e8f5ee, #d1fae5);
        display: flex; align-items: center; justify-content: center;
        color: #a7d7bc; font-size: 1.1rem;
    }

    .price-badge {
        display: inline-flex; align-items: center; gap: .3rem;
        background: #d1fae5; color: #065f46;
        padding: .28rem .7rem; border-radius: 20px;
        font-size: .78rem; font-weight: 700;
    }

    /* Action buttons */
    .action-btn {
        width: 34px; height: 34px; border: none; border-radius: 9px;
        display: inline-flex; align-items: center; justify-content: center;
        font-size: .82rem; cursor: pointer; transition: all .2s;
        text-decoration: none;
    }
    .action-btn.edit { background: #fef3c7; color: #d97706; }
    .action-btn.edit:hover { background: #fde68a; transform: scale(1.1); }
    .action-btn.del  { background: #fee2e2; color: #dc2626; }
    .action-btn.del:hover  { background: #fecaca; transform: scale(1.1); }

    /* ── CARD VIEW ── */
    #cardView { display: none; }
    .court-grid-card {
        background: #fff; border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0,0,0,.07); overflow: hidden;
        transition: transform .25s, box-shadow .25s;
    }
    .court-grid-card:hover { transform: translateY(-5px); box-shadow: 0 16px 40px rgba(0,0,0,.12); }
    .court-grid-img { width: 100%; height: 160px; object-fit: cover; }
    .court-grid-placeholder {
        height: 160px; background: linear-gradient(135deg, #0d2318, var(--dark-green));
        display: flex; align-items: center; justify-content: center;
        font-size: 3rem; color: rgba(82,183,136,.4);
    }
    .court-grid-body { padding: 1rem 1.1rem 1.1rem; }
    .court-grid-name { font-size: .92rem; font-weight: 700; color: #1f2937; margin-bottom: .25rem; }
    .court-grid-desc { font-size: .78rem; color: #9ca3af; margin-bottom: .75rem; line-height: 1.5; }
    .court-grid-price { font-size: .95rem; font-weight: 800; color: var(--medium-green); margin-bottom: .85rem; }
    .court-grid-actions { display: flex; gap: .5rem; }
    .court-grid-btn {
        flex: 1; padding: .5rem; border: none; border-radius: 9px;
        font-size: .8rem; font-weight: 600; cursor: pointer;
        text-decoration: none; text-align: center; transition: all .2s;
        display: flex; align-items: center; justify-content: center; gap: .35rem;
    }
    .court-grid-btn.edit { background: #fef3c7; color: #d97706; }
    .court-grid-btn.edit:hover { background: #fde68a; }
    .court-grid-btn.del  { background: #fee2e2; color: #dc2626; }
    .court-grid-btn.del:hover  { background: #fecaca; }

    /* Pagination */
    .pagination .page-link { border-radius: 8px !important; border: 2px solid #e8eae8; margin: 0 2px; font-size: .82rem; color: #374151; }
    .pagination .page-item.active .page-link { background: var(--medium-green); border-color: var(--medium-green); }
    .pagination .page-link:hover { border-color: var(--light-green); color: var(--medium-green); }

    /* Empty state */
    .empty-state { text-align: center; padding: 4rem 2rem; }
    .empty-icon  { font-size: 3.5rem; color: #e5e7eb; margin-bottom: 1rem; }
</style>
@endpush

@section('content')

{{-- ── Toolbar ── --}}
<div class="page-toolbar">
    <div class="page-toolbar-left">
        <h1 class="page-heading"><i class="fas fa-door-open me-2" style="color:var(--light-green);"></i>Daftar Lapangan</h1>
        {{-- Search --}}
        <div class="search-wrap">
            <i class="fas fa-search"></i>
            <input type="text" id="searchInput" placeholder="Cari lapangan..." oninput="filterTable()">
        </div>
        {{-- View toggle --}}
        <div class="view-toggle">
            <button class="view-btn active" id="btnTable" onclick="switchView('table')" title="Tampilan Tabel">
                <i class="fas fa-list"></i>
            </button>
            <button class="view-btn" id="btnCard" onclick="switchView('card')" title="Tampilan Kartu">
                <i class="fas fa-grip"></i>
            </button>
        </div>
    </div>
    <a href="{{ route('admin.lapangan.create') }}" class="btn-add">
        <i class="fas fa-plus"></i> Tambah Lapangan
    </a>
</div>

{{-- ════════ TABLE VIEW ════════ --}}
<div id="tableView">
    <div class="table-card">
        <div class="table-responsive">
            <table class="table table-hover table-modern align-middle mb-0" id="lapanganTable">
                <thead>
                    <tr>
                        <th style="width:45px;">#</th>
                        <th style="width:90px;">Foto</th>
                        <th>Nama Lapangan</th>
                        <th>Deskripsi</th>
                        <th>Harga/Jam</th>
                        <th class="text-center" style="width:110px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($lapangans as $lapangan)
                    <tr class="table-row-item">
                        <td style="color:#9ca3af; font-size:.8rem;">{{ $loop->iteration }}</td>
                        <td>
                            @if($lapangan->gambar)
                                <img src="{{ asset('storage/' . $lapangan->gambar) }}"
                                     alt="{{ $lapangan->nama_lapangan }}"
                                     class="court-thumb">
                            @else
                                <div class="court-thumb-placeholder">
                                    <i class="fas fa-futbol"></i>
                                </div>
                            @endif
                        </td>
                        <td>
                            <div style="font-weight:600; color:#1f2937;">{{ $lapangan->nama_lapangan }}</div>
                        </td>
                        <td style="color:#6b7280; font-size:.84rem; max-width:200px;">
                            {{ Str::limit($lapangan->deskripsi, 55) ?? '—' }}
                        </td>
                        <td>
                            <div class="price-badge">
                                <i class="fas fa-tag"></i>
                                Rp {{ number_format($lapangan->harga_per_jam, 0, ',', '.') }}
                            </div>
                        </td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-1">
                                <a href="{{ route('admin.lapangan.edit', $lapangan) }}"
                                   class="action-btn edit" title="Edit">
                                    <i class="fas fa-pen"></i>
                                </a>
                                <form action="{{ route('admin.lapangan.destroy', $lapangan) }}"
                                      method="POST" class="d-inline"
                                      onsubmit="return confirm('Yakin ingin menghapus lapangan ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="action-btn del" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6">
                            <div class="empty-state">
                                <div class="empty-icon"><i class="fas fa-futbol"></i></div>
                                <h6 style="color:#6b7280;">Belum ada lapangan</h6>
                                <p style="font-size:.875rem; color:#9ca3af;">Tambahkan lapangan pertama Anda sekarang!</p>
                                <a href="{{ route('admin.lapangan.create') }}" class="btn-add d-inline-flex mt-2">
                                    <i class="fas fa-plus"></i> Tambah Lapangan
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- ════════ CARD VIEW ════════ --}}
<div id="cardView">
    <div class="row g-3" id="cardGrid">
        @forelse($lapangans as $lapangan)
        <div class="col-sm-6 col-lg-4 col-xl-3 card-item" data-name="{{ strtolower($lapangan->nama_lapangan) }}">
            <div class="court-grid-card">
                @if($lapangan->gambar)
                    <img src="{{ asset('storage/' . $lapangan->gambar) }}"
                         class="court-grid-img" alt="{{ $lapangan->nama_lapangan }}">
                @else
                    <div class="court-grid-placeholder"><i class="fas fa-futbol"></i></div>
                @endif
                <div class="court-grid-body">
                    <div class="court-grid-name">{{ $lapangan->nama_lapangan }}</div>
                    <div class="court-grid-desc">{{ Str::limit($lapangan->deskripsi, 60) ?? 'Tidak ada deskripsi.' }}</div>
                    <div class="court-grid-price">Rp {{ number_format($lapangan->harga_per_jam, 0, ',', '.') }}<small style="font-size:.72rem; color:#9ca3af; font-weight:400;">/jam</small></div>
                    <div class="court-grid-actions">
                        <a href="{{ route('admin.lapangan.edit', $lapangan) }}" class="court-grid-btn edit">
                            <i class="fas fa-pen"></i> Edit
                        </a>
                        <form action="{{ route('admin.lapangan.destroy', $lapangan) }}"
                              method="POST" class="d-contents"
                              onsubmit="return confirm('Yakin ingin menghapus lapangan ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="court-grid-btn del">
                                <i class="fas fa-trash"></i> Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="empty-state">
                <div class="empty-icon"><i class="fas fa-futbol"></i></div>
                <h6 style="color:#6b7280;">Belum ada lapangan</h6>
            </div>
        </div>
        @endforelse
    </div>
</div>

{{-- Pagination --}}
<div class="mt-4 d-flex justify-content-end">
    {{ $lapangans->links() }}
</div>

@endsection

@push('scripts')
<script>
    // Switch view
    function switchView(mode) {
        const tableView = document.getElementById('tableView');
        const cardView  = document.getElementById('cardView');
        const btnTable  = document.getElementById('btnTable');
        const btnCard   = document.getElementById('btnCard');
        if (mode === 'table') {
            tableView.style.display = ''; cardView.style.display = 'none';
            btnTable.classList.add('active'); btnCard.classList.remove('active');
        } else {
            tableView.style.display = 'none'; cardView.style.display = '';
            btnCard.classList.add('active'); btnTable.classList.remove('active');
        }
    }

    // Search filter
    function filterTable() {
        const q = document.getElementById('searchInput').value.toLowerCase();
        // Table rows
        document.querySelectorAll('.table-row-item').forEach(row => {
            const name = row.querySelector('td:nth-child(3)')?.textContent.toLowerCase() || '';
            row.style.display = name.includes(q) ? '' : 'none';
        });
        // Card items
        document.querySelectorAll('.card-item').forEach(card => {
            card.style.display = (card.dataset.name || '').includes(q) ? '' : 'none';
        });
    }
</script>
@endpush