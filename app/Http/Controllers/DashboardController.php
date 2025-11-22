<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    private function userData()
    {
        $user = Auth::user();
        $full = $user->username;
        $short = strlen($full) > 20 ? substr($full, 0, 20) . '..' : $full;

        return [
            'user'   => $user,
            'full'   => $full,
            'short'  => $short,
            'email'  => $user->email,
            'no_hp'  => $user->no_hp,
            'alamat' => $user->alamat,
        ];
    }

    public function index()
    {
        return view('dashboard.profil', array_merge($this->userData()));
    }

    public function profil()
    {
        return view('dashboard.profil', $this->userData())
            ->with('currentTab', 'profil');
    }

    public function histori()
    {
        // Ambil booking milik user, urutkan dari yang terbaru
        // TODO: buat filter
        $bookings = Booking::where('user_id', Auth::id())
            ->with(['bookingLayanans.layanan'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('dashboard.histori', compact('bookings'), $this->userData())
            ->with('currentTab', 'histori');
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'username' => 'required|string|max:50',
            'no_hp' => 'nullable|string|max:15',
            'alamat' => 'nullable|string|max:255',
        ]);

//        Mengubah nama, no hp, dan alamat sesuai dari form edit yang diisi pengguna
        $user->update($request->only('username', 'no_hp', 'alamat'));
        return redirect()->route('dashboard.profil')->with('status', 'Profil berhasil diperbarui!');
    }

    public function edit()
    {
//        Menampilkan Form Edit Profil
        return view('dashboard.profil', array_merge($this->userData(), [
            'currentTab' => 'profil',
            'isEditMode' => true,
        ]));
    }
}

