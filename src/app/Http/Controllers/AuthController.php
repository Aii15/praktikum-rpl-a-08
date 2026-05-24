<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    /*** untuk menampilkan halaman login. */
    public function showLoginForm()
    {
        return view('login');
    }
/* untuk handle proses login*/    public function login(Request $request)
    {
        $request->validate([
            'login_id' => 'required',
            'password' => 'required'
        ]);

        $loginId = $request->input('login_id');
        $password = $request->input('password');

        // untuk validasi apakah login_id adalah email atau no_hp
        // untuk validasi format email
        $isEmailStrict = preg_match('/^[^\s@]+@[^\s@]+\.[^\s@]+$/', $loginId);
        $fieldType = $isEmailStrict ? 'email' : 'no_hp';

        $credentials = [
            $fieldType => $loginId,
            'password' => $password
        ];

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            // Cek role user untuk redirect
            $role = Auth::user()->role;
            if ($role === 'admin') {
                return redirect()->intended('/dashboard');
            } elseif ($role === 'mitra') {
                return redirect()->intended('/dashboard');
            }
            
            return redirect()->intended('/dashboard');
        }

        return back()->withErrors([
            'login_id' => 'Email atau nomor HP tidak valid, atau password salah.',
        ])->onlyInput('login_id');
    }

/* untuk menampilkan page registrasi*/
    public function showRegistrationForm()
    {
        return view('register');
    }

    /* Proses registrasi*/
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            // validasi apakah ada domain email dengan format yang benar
            'email' => ['required','string','email','max:255','unique:users','regex:/^[^\s@]+@[^\s@]+\.[^\s@]+$/'],
            'no_hp' => 'required|string|max:20|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'name.required' => 'Nama wajib diisi.',
            'name.max' => 'Nama maksimal 255 karakter.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.regex' => 'Format email harus berisi domain dengan titik (contoh: nama@example.com).',
            'email.max' => 'Email maksimal 255 karakter.',
            'email.unique' => 'Email sudah terdaftar.',
            'no_hp.required' => 'Nomor HP wajib diisi.',
            'no_hp.max' => 'Nomor HP maksimal 20 karakter.',
            'no_hp.unique' => 'Nomor HP sudah terdaftar.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
            'password' => Hash::make($request->password),
            'role' => 'penyewa', // Default role untuk pendaftar baru
        ]);

        Auth::login($user);

        return redirect('/dashboard');
    }

    /**
     * untuk menampilkan halaman registrasi Mitra*/
    public function showMitraRegistrationForm()
    {
        return view('register_mitra');
    }

    /*** untuk proses registrasi Mitra*/
    public function registerMitra(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required','string','email','max:255','unique:users','regex:/^[^\s@]+@[^\s@]+\.[^\s@]+$/'],
            'no_hp' => 'required|string|max:20|unique:users',
            'rekening_bank' => 'required|string|max:50',
            'ktp' => 'required|string|max:50',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'name.required' => 'Nama wajib diisi.',
            'name.max' => 'Nama maksimal 255 karakter.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.regex' => 'Format email harus berisi domain dengan titik (contoh: nama@example.com).',
            'email.max' => 'Email maksimal 255 karakter.',
            'email.unique' => 'Email sudah terdaftar.',
            'no_hp.required' => 'Nomor HP wajib diisi.',
            'no_hp.max' => 'Nomor HP maksimal 20 karakter.',
            'no_hp.unique' => 'Nomor HP sudah terdaftar.',
            'rekening_bank.required' => 'Rekening bank wajib diisi.',
            'rekening_bank.max' => 'Rekening bank maksimal 50 karakter.',
            'ktp.required' => 'KTP wajib diisi.',
            'ktp.max' => 'KTP maksimal 50 karakter.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
            'rekening_bank' => $request->rekening_bank,
            'ktp' => $request->ktp,
            'password' => Hash::make($request->password),
            'role' => 'mitra', // Set role mitra
        ]);

        Auth::login($user);

        return redirect('/dashboard');
    }

    /*** untuk fungsi logout.*/
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
