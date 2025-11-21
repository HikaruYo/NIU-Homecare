<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminDashboardController extends Controller
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
            'currentTab' => 'dashboard'
        ];
    }

    public function index()
    {
        // Menggabungkan data user dengan data spesifik halaman ini
        $data = array_merge($this->userData(), ['currentTab' => 'dashboard']);
        return view('admin.dashboard', $data);
    }

    public function layanan()
    {
        // Tambahkan logic pengambilan data layanan di sini nanti
        $data = array_merge($this->userData(), ['currentTab' => 'layanan']);
        return view('admin.dashboard.layanan', $data);
    }

    public function booking()
    {
        // Tambahkan logic pengambilan data booking di sini nanti
        $data = array_merge($this->userData(), ['currentTab' => 'booking']);
        return view('admin.dashboard.booking', $data);
    }

    public function laporan()
    {
        // Tambahkan logic pengambilan data laporan di sini nanti
        $data = array_merge($this->userData(), ['currentTab' => 'laporan']);
        return view('admin.dashboard.laporan', $data);
    }
}
