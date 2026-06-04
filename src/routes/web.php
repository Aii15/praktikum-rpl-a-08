<?php
/* untuk routing */
/* berisi definisi route web aplikasi */
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UpgradeController;

// Mengubah dari '/landing' menjadi '/' agar menjadi halaman utama web
Route::get('/', function () {
    return view('landing');
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::get('/choose-role', [AuthController::class, 'showRoleSelectionForm'])->middleware('auth')->name('role.choose');
Route::post('/choose-role', [AuthController::class, 'setActiveRole'])->middleware('auth')->name('role.set');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/dashboard', function (Request $request) {
    $user = Auth::user();
    $roles = $user ? $user->roles()->pluck('name') : collect();

    if ($user && $roles->count() > 1 && ! $request->session()->has('active_role')) {
        return redirect()->route('role.choose');
    }

    if ($user && ! $request->session()->has('active_role')) {
        $request->session()->put('active_role', $user->primary_role ?? $roles->first());
    }

    return view('dashboard');
})->middleware('auth')->name('dashboard');

// Upgrade to mitra (for logged-in users)
Route::get('/upgrade-mitra', [UpgradeController::class, 'showForm'])->middleware('auth')->name('upgrade.mitra');
Route::post('/upgrade-mitra', [UpgradeController::class, 'upgrade'])->middleware('auth');