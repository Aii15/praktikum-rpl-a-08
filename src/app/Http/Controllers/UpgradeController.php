<?php

namespace App\Http\Controllers;
/* untuk handle proses upgrade akun menjadi mitra */

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\MitraProfile;

class UpgradeController extends Controller
{
    public function showForm()
    {
        return view('upgrade_mitra');
    }

    public function upgrade(Request $request)
    {
        $user = Auth::user();

        if (! $user) {
            return redirect()->route('login');
        }

        if ($user->hasRole('mitra')) {
            return back()->with('info', 'Akun Anda sudah terdaftar sebagai Mitra.');
        }

        $request->validate([
            'nama_mitra' => 'required|string|max:100',
            'ktp' => 'required|string|max:50',
            'rekening_bank' => 'nullable|string|max:255',
        ]);

        // tambahkan role mitra dan buat profil mitra
        $user->assignRole('mitra');
        $user->role = 'mitra';
        $user->save();

        MitraProfile::create([
            'user_id' => $user->id,
            'nama_mitra' => $request->nama_mitra,
            'ktp' => $request->ktp,
            'rekening_bank' => $request->rekening_bank,
        ]);

        return redirect('/dashboard')->with('success', 'Akun Anda berhasil di-upgrade menjadi Mitra.');
    }
}
