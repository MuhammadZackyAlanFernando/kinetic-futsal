<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lapangan;
use Illuminate\Support\Facades\Storage;

class LapanganController extends Controller
{
    // Tampilkan semua lapangan
    public function index()
    {
        $lapangans = Lapangan::latest()->paginate(10);
        return view('admin.lapangan.index', compact('lapangans'));
    }

    // Form tambah lapangan
    public function create()
    {
        return view('admin.lapangan.create');
    }

    // Simpan lapangan baru
    public function store(Request $request)
    {
        $request->validate([
            'nama_lapangan' => 'required|string|max:100',
            'deskripsi'     => 'nullable|string',
            'harga_per_jam' => 'required|integer|min:1000',
            'gambar'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ], [
            'nama_lapangan.required' => 'Nama lapangan wajib diisi.',
            'harga_per_jam.required' => 'Harga per jam wajib diisi.',
            'harga_per_jam.integer'  => 'Harga harus berupa angka.',
            'harga_per_jam.min'      => 'Harga minimal Rp 1.000.',
            'gambar.image'           => 'File harus berupa gambar.',
            'gambar.mimes'           => 'Format gambar: jpg, jpeg, png, webp.',
            'gambar.max'             => 'Ukuran gambar maksimal 2MB.',
        ]);

        $data = $request->only(['nama_lapangan', 'deskripsi', 'harga_per_jam']);

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('lapangan', 'public');
        }

        Lapangan::create($data);

        return redirect()->route('admin.lapangan.index')
                         ->with('success', 'Lapangan berhasil ditambahkan!');
    }

    // Form edit lapangan
    public function edit(Lapangan $lapangan)
    {
        return view('admin.lapangan.edit', compact('lapangan'));
    }

    // Update lapangan
    public function update(Request $request, Lapangan $lapangan)
    {
        $request->validate([
            'nama_lapangan' => 'required|string|max:100',
            'deskripsi'     => 'nullable|string',
            'harga_per_jam' => 'required|integer|min:1000',
            'gambar'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ], [
            'nama_lapangan.required' => 'Nama lapangan wajib diisi.',
            'harga_per_jam.required' => 'Harga per jam wajib diisi.',
            'harga_per_jam.integer'  => 'Harga harus berupa angka.',
            'gambar.image'           => 'File harus berupa gambar.',
            'gambar.mimes'           => 'Format gambar: jpg, jpeg, png, webp.',
            'gambar.max'             => 'Ukuran gambar maksimal 2MB.',
        ]);

        $data = $request->only(['nama_lapangan', 'deskripsi', 'harga_per_jam']);

        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika ada
            if ($lapangan->gambar) {
                Storage::disk('public')->delete($lapangan->gambar);
            }
            $data['gambar'] = $request->file('gambar')->store('lapangan', 'public');
        }

        $lapangan->update($data);

        return redirect()->route('admin.lapangan.index')
                         ->with('success', 'Lapangan berhasil diperbarui!');
    }

    // Hapus lapangan
    public function destroy(Lapangan $lapangan)
    {
        if ($lapangan->gambar) {
            Storage::disk('public')->delete($lapangan->gambar);
        }

        $lapangan->delete();

        return redirect()->route('admin.lapangan.index')
                         ->with('success', 'Lapangan berhasil dihapus!');
    }
}