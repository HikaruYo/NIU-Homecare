<?php

namespace App\Http\Controllers;

use App\Models\Layanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminLayananController extends Controller
{
    public function index()
    {
        return view('admin.dashboard.layanan', [
            'currentTab' => 'layanan',
            'layanan' => Layanan::orderBy('created_at', 'desc')->get()
        ]);
    }

    public function create()
    {
        return view('admin.components.layanan-create', [
            'currentTab' => 'layanan'
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_layanan' => 'required|string|max:100',
            'gambar' => 'image|mimes:jpg,jpeg,png,webp|max:5120',
            'nominal' => 'required|integer|min:1000',
            'deskripsi' => 'required|string|max:100',
            'durasi' => 'required|integer|min:10',
            'is_flexible_duration' => 'required|boolean',
            'harga_per_30menit' => 'nullable|integer|min:1000',
        ]);

        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $request->file('gambar')->store('layanan_images', 'public');
        }

        Layanan::create($validated);

        return redirect()
            ->route('admin.dashboard.layanan')
            ->with('status', 'Layanan berhasil ditambahkan!');
    }

    public function edit($id)
    {
        return view('admin.components.layanan-edit', [
            'currentTab' => 'layanan',
            'layanan' => Layanan::findOrFail($id)
        ]);
    }

    public function update(Request $request, $id)
    {
        $layanan = Layanan::findOrFail($id);

        $validated = $request->validate([
            'nama_layanan' => 'required|string',
            'gambar' => 'image|mimes:jpg,jpeg,png,webp|max:5120',
            'nominal' => 'required|integer|min:1000',
            'deskripsi' => 'required|string',
            'durasi' => 'nullable|integer',
            'is_flexible_duration' => 'required|boolean',
            'harga_per_30menit' => 'nullable|integer|min:1000',
        ]);

        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika ada
            if ($layanan->gambar && Storage::disk('public')->exists($layanan->gambar)) {
                Storage::disk('public')->delete($layanan->gambar);
            }
            // Upload gambar baru
            $validated['gambar'] = $request->file('gambar')->store('layanan_images', 'public');
        }

        $layanan->update($validated);

        return redirect()
            ->route('admin.dashboard.layanan')
            ->with('status', 'Layanan berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $layanan = Layanan::findOrFail($id);

        // Hapus gambar
        if ($layanan->gambar && Storage::disk('public')->exists($layanan->gambar)) {
            Storage::disk('public')->delete($layanan->gambar);
        }

        // Hapus record
        $layanan->delete();

        return redirect()
            ->route('admin.dashboard.layanan')
            ->with('status', 'Layanan berhasil dihapus!');
    }

    public function search(Request $request)
    {
        $keyword = $request->get('q');

        $layanans = Layanan::where('nama_layanan', 'LIKE', "%{$keyword}%")
            ->orWhere('deskripsi', 'LIKE', "%{$keyword}%")
            ->get();

        return response()->json($layanans);
    }
}
