<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\Lapangan;
use Illuminate\Support\Facades\Auth;

class TransaksiController extends Controller
{
    // Form booking untuk User
    public function create(Lapangan $lapangan)
    {
        return view('user.booking', compact('lapangan'));
    }

    // Simpan booking dari User
    public function store(Request $request)
    {
        $request->validate([
            'lapangan_id'      => 'required|exists:lapangans,id',
            'tanggal_booking'  => 'required|date|after_or_equal:today',
            'jam_mulai'        => 'required',
            'jam_selesai'      => 'required|after:jam_mulai',
            'bukti_pembayaran' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'nama_rekening'    => 'required|string|max:255',
            'nomor_rekening'   => 'required|string|max:50',
        ], [
            'lapangan_id.required'     => 'Lapangan wajib dipilih.',
            'lapangan_id.exists'       => 'Lapangan tidak valid.',
            'tanggal_booking.required' => 'Tanggal booking wajib diisi.',
            'tanggal_booking.date'     => 'Format tanggal tidak valid.',
            'tanggal_booking.after_or_equal' => 'Tanggal booking tidak boleh di masa lalu.',
            'jam_mulai.required'       => 'Jam mulai wajib diisi.',
            'jam_selesai.required'     => 'Jam selesai wajib diisi.',
            'jam_selesai.after'        => 'Jam selesai harus setelah jam mulai.',
            'bukti_pembayaran.required'=> 'Bukti pembayaran wajib diunggah.',
            'bukti_pembayaran.image'   => 'Bukti pembayaran harus berupa gambar.',
            'bukti_pembayaran.mimes'   => 'Format gambar harus jpeg, png, atau jpg.',
            'bukti_pembayaran.max'     => 'Ukuran gambar maksimal 2MB.',
            'nama_rekening.required'   => 'Nama rekening wajib diisi.',
            'nomor_rekening.required'  => 'Nomor rekening wajib diisi.',
        ]);

        // Cek apakah slot sudah dibooking (approved/pending)
        $conflict = Transaksi::where('lapangan_id', $request->lapangan_id)
            ->where('tanggal_booking', $request->tanggal_booking)
            ->where('status', '!=', 'rejected')
            ->where(function ($query) use ($request) {
                $query->whereBetween('jam_mulai', [$request->jam_mulai, $request->jam_selesai])
                      ->orWhereBetween('jam_selesai', [$request->jam_mulai, $request->jam_selesai])
                      ->orWhere(function ($q) use ($request) {
                          $q->where('jam_mulai', '<=', $request->jam_mulai)
                            ->where('jam_selesai', '>=', $request->jam_selesai);
                      });
            })->exists();

        if ($conflict) {
            return back()->withErrors([
                'jam_mulai' => 'Slot waktu ini sudah dibooking. Pilih jam lain.'
            ])->withInput();
        }

        $buktiPath = null;
        if ($request->hasFile('bukti_pembayaran')) {
            $buktiPath = $request->file('bukti_pembayaran')->store('bukti_pembayaran', 'public');
        }

       Transaksi::create([
            'user_id'          => Auth::id(), // <--- Ubah bagian ini
            'lapangan_id'      => $request->lapangan_id,
            'tanggal_booking'  => $request->tanggal_booking,
            'jam_mulai'        => $request->jam_mulai,
            'jam_selesai'      => $request->jam_selesai,
            'status'           => 'pending',
            'bukti_pembayaran' => $buktiPath,
            'nama_rekening'    => $request->nama_rekening,
            'nomor_rekening'   => $request->nomor_rekening,
        ]);

        return redirect()->route('user.dashboard')
                         ->with('success', 'Booking berhasil! Menunggu konfirmasi admin.');
    }

    // Tabel semua transaksi untuk Admin
    public function adminIndex()
    {
        $transaksis = Transaksi::with(['user', 'lapangan'])
                        ->latest()
                        ->paginate(100);

        return view('admin.transaksi.index', compact('transaksis'));
    }

    // Update status transaksi oleh Admin
    public function updateStatus(Request $request, Transaksi $transaksi)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected,selesai',
        ]);

        $transaksi->update(['status' => $request->status]);

        $pesan = match($request->status) {
            'approved' => 'Transaksi berhasil disetujui!',
            'rejected' => 'Transaksi berhasil ditolak.',
            'selesai'  => 'Transaksi ditandai selesai.',
            default    => 'Status transaksi diperbarui.',
        };

        return redirect()->route('admin.transaksi.index')->with('success', $pesan);
    }

    // Cetak nota pembayaran untuk user
    public function cetakNota(Transaksi $transaksi)
    {
        //  hanya pemilik transaksi yang bisa cetak nota
        if ($transaksi->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // hanya statusnya approved atau selesai
        if (!in_array($transaksi->status, ['approved', 'selesai'])) {
            return back()->with('error', 'Nota belum dapat dicetak.');
        }

        return view('user.nota', compact('transaksi'));
    }
}