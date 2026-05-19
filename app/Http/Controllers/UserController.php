<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lapangan;
use App\Models\Transaksi;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function dashboard()
    {
        $lapangans = Lapangan::latest()->get();
        $myTransaksi = Transaksi::where('user_id', Auth::user()->id)
                        ->latest()->get();

        return view('user.dashboard', compact('lapangans', 'myTransaksi'));
    }
}