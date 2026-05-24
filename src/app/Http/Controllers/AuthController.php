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
        $fieldType = filter_var($loginId, FILTER_VALIDATE_EMAIL) ? 'email' : 'no_hp';

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
            'login_id' => 'Kredensial yang diberikan tidak cocok dengan data kami.',
        ])->onlyInput('login_id');
    }

/* untuk menampilkan page registrasi*/
    public function showRegistrationForm()
    {
        return view('register');
    }

    /*** Proses registrasi.*/
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'no_hp' => 'required|string|max:20|unique:users',
            'password' => 'required|string|min:8|confirmed',
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

    /*** untuk proses registrasi Mitra.*/
    public function registerMitra(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'no_hp' => 'required|string|max:20|unique:users',
            'rekening_bank' => 'required|string|max:50',
            'ktp' => 'required|string|max:50',
            'password' => 'required|string|min:8|confirmed',
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
