<?php

namespace App\Http\Controllers;
/* untuk handle proses autentikasi: login, register, dan pemilihan role aktif */

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Role;
use App\Models\MitraProfile;

class AuthController extends Controller
{
    /*** untuk menampilkan halaman login. */
    public function showLoginForm()
    {
        return view('login');
    }

    /* finalisasi sesi autentikasi dan arahkan pengguna multi-role ke pemilihan role */
    protected function finishLogin(User $user, Request $request)
    {
        $request->session()->regenerate();
        $request->session()->forget(['active_role', 'pending_role_selection_user_id']);

        $roles = $user->roles()->pluck('name')->values();

        if ($roles->count() > 1) {
            $request->session()->put('pending_role_selection_user_id', $user->id);

            return redirect()->route('role.choose');
        }

        $activeRole = $roles->first() ?: ($user->role ?? null);

        if ($activeRole) {
            $request->session()->put('active_role', $activeRole);
        }

        return redirect('/dashboard');
    }

    /* tampilkan form pemilihan role untuk pengguna yang punya lebih dari satu role */
    public function showRoleSelectionForm(Request $request)
    {
        $user = Auth::user();

        if (! $user) {
            return redirect()->route('login');
        }

        $roles = $user->roles()->pluck('name')->values();

        if ($roles->count() <= 1) {
            $activeRole = $roles->first() ?: ($user->role ?? null);

            if ($activeRole) {
                $request->session()->put('active_role', $activeRole);
            }

            $request->session()->forget('pending_role_selection_user_id');

            return redirect('/dashboard');
        }

        return view('choose-role', [
            'user' => $user,
            'roles' => $roles,
        ]);
    }

    /* simpan role aktif yang dipilih ke sesi */
    public function setActiveRole(Request $request)
    {
        $user = Auth::user();

        if (! $user) {
            return redirect()->route('login');
        }

        $request->validate([
            'role' => 'required|string',
        ]);

        $selectedRole = $request->input('role');
        $allowedRoles = $user->roles()->pluck('name')->all();

        if (! in_array($selectedRole, $allowedRoles, true)) {
            return back()->withErrors([
                'role' => 'Role yang dipilih tidak tersedia untuk akun ini.',
            ]);
        }

        $request->session()->put('active_role', $selectedRole);
        $request->session()->forget('pending_role_selection_user_id');

        return redirect('/dashboard')->with('success', 'Anda masuk sebagai '.ucfirst($selectedRole).'.');
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
            return $this->finishLogin(Auth::user(), $request);
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
            'email' => ['required','string','email','max:255','regex:/^[^\s@]+@[^\s@]+\.[^\s@]+$/'],
            'no_hp' => ['required','string','regex:/^[0-9]{10,13}$/'],
            'password' => 'required|string|min:8|confirmed',
        ], [
            'name.required' => 'Nama wajib diisi.',
            'name.max' => 'Nama maksimal 255 karakter.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.regex' => 'Format email harus berisi domain dengan titik (contoh: nama@example.com).',
            'email.max' => 'Email maksimal 255 karakter.',
            'no_hp.required' => 'Nomor HP wajib diisi.',
            'no_hp.regex' => 'Nomor HP harus berupa 10-13 digit angka.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        // Jika akun dengan email ini sudah ada, tambahkan role 'penyewa' jika password cocok
        $existing = User::where('email', $request->email)->first();

        if ($existing) {
            if (Hash::check($request->password, $existing->password)) {
                $phoneOwner = User::where('no_hp', $request->no_hp)->first();
                if ($phoneOwner && $phoneOwner->id !== $existing->id) {
                    return back()->withErrors(['no_hp' => 'Nomor HP sudah terdaftar pada akun lain. Gunakan nomor lain atau login ke akun yang sesuai.'])->onlyInput('no_hp');
                }

                $penyewaRole = Role::firstOrCreate(['name' => 'penyewa']);
                if (! $existing->roles()->where('role_id', $penyewaRole->id)->exists()) {
                    $existing->roles()->attach($penyewaRole->id);
                }

                // keep legacy role for compatibility when not set or still default
                if (empty($existing->role) || $existing->role === 'penyewa') {
                    $existing->role = 'penyewa';
                }

                if (empty($existing->no_hp) && ! empty($request->no_hp)) {
                    $existing->no_hp = $request->no_hp;
                }

                $existing->save();

                Auth::login($existing);

                return $this->finishLogin($existing, $request)->with('success', 'Akun sudah terdaftar. Anda berhasil masuk sebagai Penyewa menggunakan akun yang sama.');
            }

            return back()->withErrors(['email' => 'Email sudah terdaftar. Gunakan password akun yang sama untuk masuk, atau login lewat halaman login.'])->with('info', 'Akun ini sudah ada. Silakan login atau isi password yang benar untuk memakai akun yang sama.')->onlyInput('email');
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
            'password' => Hash::make($request->password),
            'role' => 'penyewa', // role default untuk pendaftar baru
        ]);

        $penyewaRole = Role::firstOrCreate(['name' => 'penyewa']);
        if (! $user->roles()->where('role_id', $penyewaRole->id)->exists()) {
            $user->roles()->attach($penyewaRole->id);
        }

        Auth::login($user);

        return $this->finishLogin($user, $request)->with('success', 'Pendaftaran Penyewa berhasil.');
    }

    /*** untuk fungsi logout.*/
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();
        $request->session()->forget(['active_role', 'pending_role_selection_user_id']);

        return redirect('/login');
    }
}
