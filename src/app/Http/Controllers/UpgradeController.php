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
            'ktp' => ['required', 'string', 'regex:/^[0-9]{16}$/'],
            'rekening_bank' => ['nullable', 'string', 'regex:/^[0-9]{1,20}$/'],
        ], [
            'nama_mitra.required' => 'Nama Mitra wajib diisi.',
            'nama_mitra.max' => 'Nama Mitra maksimal 100 karakter.',
            'ktp.required' => 'Nomor KTP wajib diisi.',
            'ktp.regex' => 'Nomor KTP harus terdiri dari tepat 16 digit angka.',
            'rekening_bank.regex' => 'Format rekening bank tidak valid.',
        ]);

        // tambahkan role mitra, sinkronkan data mitra ke tabel users, dan buat profil mitra
        $user->assignRole('mitra');
        $user->role = 'mitra';
        $user->ktp = $request->ktp;
        $user->rekening_bank = $request->rekening_bank;
        $user->save();

        MitraProfile::create([
            'user_id' => $user->id,
            'nama_mitra' => $request->nama_mitra,
            'ktp' => $request->ktp,
            'rekening_bank' => $request->rekening_bank,
        ]);

        $request->session()->put('active_role', 'mitra');
        return redirect()->route('mitra.profile')->with('success', 'Akun Anda berhasil di-upgrade menjadi Mitra.');
    }
}
