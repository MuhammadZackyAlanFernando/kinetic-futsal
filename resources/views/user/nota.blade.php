<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nota Booking - {{ $transaksi->lapangan->nama_lapangan }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f8faf8; font-family: 'Inter', sans-serif; padding: 2rem 1rem; }
        .invoice-card {
            background: #fff; max-width: 600px; margin: 0 auto;
            border-radius: 16px; box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            overflow: hidden;
        }
        .invoice-header {
            background: linear-gradient(135deg, #2d6a4f, #1a3c2e);
            color: #fff; padding: 2rem; text-align: center;
        }
        .invoice-header h2 { font-weight: 800; margin: 0; font-size: 1.75rem; letter-spacing: 1px; }
        .invoice-header p { margin: 0; color: rgba(255,255,255,0.8); font-size: 0.9rem; margin-top: 0.5rem; }
        
        .invoice-body { padding: 2.5rem; }
        
        .info-row { display: flex; justify-content: space-between; margin-bottom: 1rem; padding-bottom: 1rem; border-bottom: 1px dashed #e5e7eb; }
        .info-row:last-child { border-bottom: none; margin-bottom: 0; padding-bottom: 0; }
        
        .info-label { font-size: 0.85rem; color: #6b7280; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; }
        .info-value { font-size: 1rem; color: #1f2937; font-weight: 700; text-align: right; }
        
        .status-badge {
            display: inline-block; padding: 0.35rem 1rem; border-radius: 20px;
            font-size: 0.8rem; font-weight: 700; text-transform: uppercase;
            background: #d1fae5; color: #065f46;
        }

        .total-section {
            background: #f8faf8; border-radius: 12px; padding: 1.5rem;
            margin-top: 2rem; text-align: center;
        }
        .total-label { font-size: 0.9rem; color: #4b5563; font-weight: 600; margin-bottom: 0.25rem; }
        .total-value { font-size: 2rem; font-weight: 800; color: #2d6a4f; }

        .invoice-footer {
            text-align: center; padding: 2rem; border-top: 1px solid #f3f4f6;
            background: #fff;
        }
        .invoice-footer p { font-size: 0.85rem; color: #9ca3af; margin: 0; }
        
        .btn-print {
            display: block; width: 100%; max-width: 600px; margin: 1.5rem auto 0;
            background: #2d6a4f; color: #fff; padding: 0.85rem; border-radius: 12px;
            font-weight: 600; text-align: center; text-decoration: none; border: none;
            transition: all 0.2s;
        }
        .btn-print:hover { background: #1a3c2e; color: #fff; }

        @media print {
            body { background: #fff; padding: 0; }
            .invoice-card { box-shadow: none; border: 1px solid #e5e7eb; border-radius: 0; }
            .btn-print { display: none; }
        }
    </style>
</head>
<body>

    <div class="invoice-card">
        <div class="invoice-header">
            <h2>KINETIC FUTSAL</h2>
            <p>Nota Bukti Booking Lapangan</p>
        </div>
        
        <div class="invoice-body">
            <div class="text-center mb-4">
                <div class="status-badge">
                    {{ $transaksi->status == 'approved' ? 'Disetujui' : 'Selesai' }}
                </div>
            </div>

            <div class="info-row">
                <div class="info-label">ID Booking</div>
                <div class="info-value">#BKG-{{ str_pad($transaksi->id, 5, '0', STR_PAD_LEFT) }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Nama Pemesan</div>
                <div class="info-value">{{ $transaksi->user->name }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Lapangan</div>
                <div class="info-value">{{ $transaksi->lapangan->nama_lapangan }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Tanggal Main</div>
                <div class="info-value">{{ \Carbon\Carbon::parse($transaksi->tanggal_booking)->format('d F Y') }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Waktu Main</div>
                <div class="info-value">{{ substr($transaksi->jam_mulai, 0, 5) }} - {{ substr($transaksi->jam_selesai, 0, 5) }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Tanggal Dibuat</div>
                <div class="info-value">{{ $transaksi->created_at->format('d/m/Y H:i') }}</div>
            </div>

            @php
                $mulai = \Carbon\Carbon::parse($transaksi->jam_mulai);
                $selesai = \Carbon\Carbon::parse($transaksi->jam_selesai);
                $durasi = $mulai->diffInHours($selesai);
                if ($durasi == 0) {
                    $durasi = 1; // Minimal 1 jam jika perhitungan 0
                }
                $total = $durasi * $transaksi->lapangan->harga_per_jam;
            @endphp

            <div class="total-section">
                <div class="total-label">Total Pembayaran ({{ $durasi }} Jam)</div>
                <div class="total-value">Rp {{ number_format($total, 0, ',', '.') }}</div>
            </div>
        </div>

        <div class="invoice-footer">
            <p>Terima kasih telah melakukan pemesanan.</p>
            <p>Silakan tunjukkan nota ini kepada petugas lapangan kami.</p>
        </div>
    </div>

    <button onclick="window.print()" class="btn-print">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-printer me-2" viewBox="0 0 16 16" style="vertical-align: -0.125em;">
            <path d="M2.5 8a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z"/>
            <path d="M5 1a2 2 0 0 0-2 2v2H2a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2h1v1a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2v-1h1a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-1V3a2 2 0 0 0-2-2H5zM4 3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v2H4V3zm1 5a2 2 0 0 0-2 2v1H2a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-1v-1a2 2 0 0 0-2-2H5zm7 2v3a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1z"/>
        </svg>
        Cetak / Simpan PDF
    </button>

</body>
</html>
