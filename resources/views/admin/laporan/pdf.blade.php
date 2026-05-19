<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Transaksi — Kinetic Futsal</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 11px;
            color: #333;
        }

        /* Header */
        .header {
            background-color: #1a3c2e;
            color: white;
            padding: 16px 20px;
            margin-bottom: 16px;
        }
        .header h1 { font-size: 18px; margin-bottom: 2px; }
        .header p  { font-size: 10px; opacity: 0.8; }

        /* Info Box */
        .info-box {
            background: #f0f4f0;
            border-left: 4px solid #2d6a4f;
            padding: 8px 12px;
            margin-bottom: 16px;
            font-size: 10px;
        }
        .info-box span { margin-right: 20px; }

        /* Table */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 16px;
        }
        thead tr {
            background-color: #2d6a4f;
            color: white;
        }
        thead th {
            padding: 8px 10px;
            text-align: left;
            font-size: 10px;
        }
        tbody tr:nth-child(even) { background-color: #f9f9f9; }
        tbody tr:nth-child(odd)  { background-color: #ffffff; }
        tbody td {
            padding: 7px 10px;
            border-bottom: 1px solid #e5e5e5;
            font-size: 10px;
        }

        /* Badge Status */
        .badge {
            padding: 2px 8px;
            border-radius: 10px;
            font-size: 9px;
            font-weight: bold;
            color: white;
        }
        .badge-pending  { background-color: #f59e0b; color: #000; }
        .badge-approved { background-color: #16a34a; }
        .badge-rejected { background-color: #dc2626; }
        .badge-selesai  { background-color: #0891b2; }

        /* Summary */
        .summary {
            background: #f0f4f0;
            padding: 10px 14px;
            border-radius: 6px;
            margin-bottom: 16px;
        }
        .summary table { margin: 0; }
        .summary td { border: none; padding: 3px 10px; font-size: 10px; }
        .summary td:first-child { font-weight: bold; width: 160px; }

        /* Footer */
        .footer {
            text-align: right;
            font-size: 9px;
            color: #888;
            border-top: 1px solid #ddd;
            padding-top: 8px;
            margin-top: 8px;
        }
    </style>
</head>
<body>

    {{-- Header --}}
    <div class="header">
        <h1>⚽ KINETIC FUTSAL</h1>
        <p>Laporan Data Transaksi Booking Lapangan</p>
    </div>

    {{-- Info Filter --}}
    <div class="info-box">
        <span><strong>Dicetak:</strong> {{ now()->format('d M Y, H:i') }} WIB</span>
        <span><strong>Dari:</strong> {{ $filters['dari'] ? \Carbon\Carbon::parse($filters['dari'])->format('d M Y') : 'Semua' }}</span>
        <span><strong>Sampai:</strong> {{ $filters['sampai'] ? \Carbon\Carbon::parse($filters['sampai'])->format('d M Y') : 'Semua' }}</span>
        <span><strong>Status:</strong> {{ $filters['status'] ? ucfirst($filters['status']) : 'Semua' }}</span>
        <span><strong>Total Data:</strong> {{ $transaksis->count() }} transaksi</span>
    </div>

    {{-- Summary --}}
    @php
        $totalPendapatan = 0;
        foreach ($transaksis as $t) {
            $durasi = \Carbon\Carbon::parse($t->jam_mulai)->diffInMinutes(\Carbon\Carbon::parse($t->jam_selesai));
            $totalPendapatan += ($durasi / 60) * $t->lapangan->harga_per_jam;
        }
    @endphp
    <!-- <div class="summary">
        <table>
            <tr>
                <td>Total Transaksi</td>
                <td>: {{ $transaksis->count() }} transaksi</td>
                <td width="30"></td>
                <td>Approved</td>
                <td>: {{ $transaksis->where('status', 'approved')->count() }}</td>
            </tr>
            <tr>
                <td>Total Pendapatan</td>
                <td>: Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</td>
                <td></td>
                <td>Selesai</td>
                <td>: {{ $transaksis->where('status', 'selesai')->count() }}</td>
            </tr>
            <tr>
                <td>Pending</td>
                <td>: {{ $transaksis->where('status', 'pending')->count() }}</td>
                <td></td>
                <td>Rejected</td>
                <td>: {{ $transaksis->where('status', 'rejected')->count() }}</td>
            </tr>
        </table>
    </div> -->

    {{-- Tabel Data --}}
    <table>
        <thead>
            <tr>
                <th width="30">#</th>
                <th>User</th>
                <th>Lapangan</th>
                <th>Tanggal</th>
                <th>Jam</th>
                <th>Durasi</th>
                <th>Total Biaya</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($transaksis as $i => $t)
            @php
                $durasi     = \Carbon\Carbon::parse($t->jam_mulai)->diffInMinutes(\Carbon\Carbon::parse($t->jam_selesai));
                $totalBiaya = ($durasi / 60) * $t->lapangan->harga_per_jam;
            @endphp
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $t->user->name }}</td>
                <td>{{ $t->lapangan->nama_lapangan }}</td>
                <td>{{ \Carbon\Carbon::parse($t->tanggal_booking)->format('d M Y') }}</td>
                <td>{{ substr($t->jam_mulai, 0, 5) }} - {{ substr($t->jam_selesai, 0, 5) }}</td>
                <td>{{ $durasi }} mnt</td>
                <td>Rp {{ number_format($totalBiaya, 0, ',', '.') }}</td>
                <td>
                    <span class="badge badge-{{ $t->status }}">
                        {{ ucfirst($t->status) }}
                    </span>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" style="text-align:center; padding:20px; color:#888;">
                    Tidak ada data transaksi.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Footer --}}
    <div class="footer">
        Kinetic Futsal &mdash; Dokumen ini digenerate otomatis oleh sistem &mdash; {{ now()->format('d/m/Y H:i') }}
    </div>

</body>
</html>