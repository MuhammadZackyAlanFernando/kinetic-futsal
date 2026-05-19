<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Lapangan;
use App\Models\Transaksi;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Cek role admin
        if (! Auth::check() || Auth::user()->role !== 'admin') {
            abort(403);
        }
        $totalLapangan  = Lapangan::count();
        $totalUser      = User::where('role', 'user')->count();
        $totalTransaksi = Transaksi::count();
        $transaksiTerbaru = Transaksi::with(['user', 'lapangan'])
                            ->latest()
                            ->get();
        // Data untuk Chart.js (transaksi per status)
        $chartData = [
            'pending'  => Transaksi::where('status', 'pending')->count(),
            'approved' => Transaksi::where('status', 'approved')->count(),
            'rejected' => Transaksi::where('status', 'rejected')->count(),
            'selesai'  => Transaksi::where('status', 'selesai')->count(),
        ];

        return view('admin.dashboard', compact(
            'totalLapangan',
            'totalUser',
            'totalTransaksi',
            'transaksiTerbaru',
            'chartData'
        ));
    }
}