<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Transaksi;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    /**
     * Bangun query transaksi berdasarkan filter request.
     */
    private function buildQuery(Request $request)
    {
        $query = Transaksi::with(['user', 'lapangan'])
                          ->orderBy('tanggal_booking', 'desc');

        // Filter tanggal dari
        if ($request->filled('dari')) {
            $dari = Carbon::parse($request->dari)->startOfDay()->toDateString();
            $query->whereDate('tanggal_booking', '>=', $dari);
        }

        // Filter tanggal sampai
        if ($request->filled('sampai')) {
            $sampai = Carbon::parse($request->sampai)->endOfDay()->toDateString();
            $query->whereDate('tanggal_booking', '<=', $sampai);
        }

        // Filter status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        return $query;
    }

    // Tampilkan halaman laporan dengan filter
    public function index(Request $request)
    {
        $query = $this->buildQuery($request);

        // Hitung summary dari SELURUH data yang difilter (bukan hanya current page)
        $allFiltered = (clone $query)->get();
        $summaryStats = [
            'totalPendapatan' => $allFiltered->sum(function ($t) {
                $menit = \Carbon\Carbon::parse($t->jam_mulai)
                            ->diffInMinutes(\Carbon\Carbon::parse($t->jam_selesai));
                return ($menit / 60) * $t->lapangan->harga_per_jam;
            }),
            'totalCount'   => $allFiltered->count(),
            'totalSelesai' => $allFiltered->where('status', 'selesai')->count(),
            'totalPending' => $allFiltered->where('status', 'pending')->count(),
        ];

        $transaksis = $query->paginate(15)->withQueryString();

        return view('admin.laporan.index', compact('transaksis', 'summaryStats'));
    }

    // Export PDF
    public function exportPdf(Request $request)
    {
        $transaksis = $this->buildQuery($request)->get();

        $filters = [
            'dari'   => $request->dari,
            'sampai' => $request->sampai,
            'status' => $request->status,
        ];

        $pdf = Pdf::loadView('admin.laporan.pdf', compact('transaksis', 'filters'))
                  ->setPaper('a4', 'landscape');

        return $pdf->download('laporan-transaksi-' . date('Ymd') . '.pdf');
    }
}