@extends('layouts.admin')

@section('title', 'Kelola User')
@section('page-title', 'Kelola User')

@push('styles')
<style>
    :root { --dark-green:#1a3c2e; --medium-green:#2d6a4f; --light-green:#52b788; }

    /* ── Stat Cards ── */
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

    /* ── Table Card ── */
    .table-card {
        background: #fff; border-radius: 18px;
        box-shadow: 0 4px 20px rgba(0,0,0,.07); overflow: hidden;
    }
    .table-card-header {
        display: flex; align-items: center; justify-content: space-between;
        padding: 1.1rem 1.5rem; border-bottom: 1px solid #f3f4f6;
        flex-wrap: wrap; gap: .75rem;
    }
    .table-title { font-size: .95rem; font-weight: 700; color: #1f2937; margin: 0; }
    .result-count { font-size: .8rem; color: #9ca3af; }

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

    /* User avatar */
    .user-av {
        width: 36px; height: 36px; border-radius: 10px;
        background: linear-gradient(135deg, var(--light-green), var(--medium-green));
        display: flex; align-items: center; justify-content: center;
        font-size: .85rem; font-weight: 700; color: #fff; flex-shrink: 0;
    }
    .user-av.self {
        background: linear-gradient(135deg, #818cf8, #4f46e5);
    }

    /* Role badge */
    .role-badge {
        display: inline-flex; align-items: center; gap: .3rem;
        padding: .28rem .7rem; border-radius: 20px; font-size: .75rem; font-weight: 700;
    }
    .role-badge.admin { background: #d1fae5; color: #065f46; }
    .role-badge.user  { background: #dbeafe; color: #1e40af; }

    /* Self badge */
    .self-badge {
        display: inline-flex; align-items: center; gap: .25rem;
        padding: .18rem .55rem; border-radius: 20px;
        background: #ede9fe; color: #5b21b6; font-size: .7rem; font-weight: 600;
    }

    /* Action buttons */
    .action-btn {
        width: 32px; height: 32px; border: none; border-radius: 8px;
        display: inline-flex; align-items: center; justify-content: center;
        font-size: .8rem; cursor: pointer; transition: all .2s;
        position: relative; text-decoration: none;
    }
    .action-btn-edit   { background: #fef3c7; color: #d97706; }
    .action-btn-edit:hover   { background: #fde68a; transform: scale(1.12); color: #b45309; }
    .action-btn-delete { background: #fee2e2; color: #dc2626; }
    .action-btn-delete:hover { background: #fecaca; transform: scale(1.12); color: #991b1b; }
    .action-btn:disabled { opacity: .45; cursor: not-allowed; transform: none !important; }

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

    /* Add user button */
    /* .btn-add-user {
        background: linear-gradient(135deg, var(--medium-green), var(--dark-green));
        border: none; color: #fff; font-weight: 600; font-size: .875rem;
        padding: .6rem 1.25rem; border-radius: 10px;
        display: inline-flex; align-items: center; gap: .45rem;
        transition: all .2s; box-shadow: 0 4px 12px rgba(45,106,79,.3);
        text-decoration: none;
    }
    .btn-add-user:hover {
        opacity: .9; transform: translateY(-1px);
        box-shadow: 0 8px 20px rgba(45,106,79,.4); color: #fff;
    } */

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

{{-- ── Summary Stat Cards ── --}}
<div class="row g-3 mb-4">
    <div class="col-sm-6 col-xl-4">
        <div class="stat-mini">
            <div class="stat-mini-icon" style="background:#d1fae5; color:#059669;">
                <i class="fas fa-users"></i>
            </div>
            <div>
                <div class="stat-mini-val">{{ $users->total() }}</div>
                <div class="stat-mini-label">Total User</div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-4">
        <div class="stat-mini">
            <div class="stat-mini-icon" style="background:#ede9fe; color:#5b21b6;">
                <i class="fas fa-user-shield"></i>
            </div>
            <div>
                <div class="stat-mini-val">{{ $users->getCollection()->where('role','admin')->count() }}</div>
                <div class="stat-mini-label">Admin</div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-4">
        <div class="stat-mini">
            <div class="stat-mini-icon" style="background:#dbeafe; color:#2563eb;">
                <i class="fas fa-user"></i>
            </div>
            <div>
                <div class="stat-mini-val">{{ $users->getCollection()->where('role','user')->count() }}</div>
                <div class="stat-mini-label">User Biasa</div>
            </div>
        </div>
    </div>
</div>

{{-- ── Table ── --}}
<div class="table-card">
    <div class="table-card-header">
        <h2 class="table-title">
            <i class="fas fa-users me-2" style="color:var(--light-green);"></i>Daftar User
        </h2>
        <!-- <div class="d-flex align-items-center gap-3">
            <span class="result-count">Menampilkan {{ $users->count() }} dari {{ $users->total() }} user</span>
            <a href="{{ route('admin.users.create') }}" class="btn-add-user">
                <i class="fas fa-user-plus"></i> Tambah User
            </a>
        </div> -->
    </div>

    <div class="table-responsive">
        <table class="table table-hover table-modern align-middle mb-0">
            <thead>
                <tr>
                    <th style="width:45px;">#</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Terdaftar</th>
                    <th class="text-center" style="width:90px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr>
                    <td style="color:#9ca3af; font-size:.8rem;">{{ $loop->iteration }}</td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <div class="user-av {{ $user->id === auth()->id() ? 'self' : '' }}">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            <div>
                                <div style="font-weight:600; color:#1f2937; font-size:.875rem;">
                                    {{ $user->name }}
                                    @if($user->id === auth()->id())
                                        <span class="self-badge ms-1"><i class="fas fa-star" style="font-size:.6rem;"></i> Anda</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </td>
                    <td style="color:#6b7280; font-size:.875rem;">{{ $user->email }}</td>
                    <td>
                        @if($user->role === 'admin')
                            <span class="role-badge admin">
                                <i class="fas fa-shield-halved" style="font-size:.7rem;"></i> Admin
                            </span>
                        @else
                            <span class="role-badge user">
                                <i class="fas fa-user" style="font-size:.7rem;"></i> User
                            </span>
                        @endif
                    </td>
                    <td style="color:#6b7280; font-size:.84rem;">
                        {{ $user->created_at->format('d M Y') }}
                    </td>
                    <td class="text-center">
                        <div class="d-flex justify-content-center gap-1">
                            <a href="{{ route('admin.users.edit', $user) }}"
                               class="action-btn action-btn-edit"
                               data-tip="Edit">
                                <i class="fas fa-pencil"></i>
                            </a>

                            @if($user->id !== auth()->id())
                                <form action="{{ route('admin.users.destroy', $user) }}"
                                      method="POST" class="d-inline"
                                      onsubmit="return confirm('Yakin ingin menghapus user {{ addslashes($user->name) }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="action-btn action-btn-delete"
                                            data-tip="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            @else
                                <button class="action-btn action-btn-delete"
                                        disabled data-tip="Tidak bisa hapus akun sendiri">
                                    <i class="fas fa-trash"></i>
                                </button>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6">
                        <div class="empty-state">
                            <div class="empty-icon"><i class="fas fa-users"></i></div>
                            <h6 style="color:#6b7280;">Belum ada user terdaftar</h6>
                            <p style="font-size:.875rem; color:#9ca3af;">User yang mendaftar akan muncul di sini.</p>
                            <a href="{{ route('admin.users.create') }}" class="btn-add-user d-inline-flex mt-2">
                                <i class="fas fa-user-plus"></i> Tambah User
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
    {{ $users->links() }}
</div>

@endsection