<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(){
        $user = Auth::user();
        $full = $user->username;
        $short = strlen($full) > 20 ? substr($full, 0, 20) . '..' : $full;
        $email = $user->email;
        $no_hp = $user->no_hp;
        $alamat = $user->alamat;

        return $user->role === 'admin'
            ? view('admin.dashboard', compact('user', 'full', 'short', 'email', 'no_hp', 'alamat'))
            : view('dashboard', compact('user', 'full', 'short', 'email', 'no_hp', 'alamat'));
    }

    // Handle update profile
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'username' => [
                'required',
                'string',
                'max:50',
            ],
            'no_hp' => 'nullable|string|max:15',
            'alamat' => 'nullable|string|max:255',
        ]);

        $user->username = $request->username;
        $user->no_hp = $request->no_hp;
        $user->alamat = $request->alamat;
        $user->save();

        return redirect()->route('dashboard', ['tab' => 'profil'])->with('status', 'Profil berhasil diperbarui!');
    }
}
