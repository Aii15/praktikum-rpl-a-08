<?php
/* untuk routing */
/* berisi definisi route web aplikasi */
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UpgradeController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\MitraController;
use App\Http\Controllers\PropertyController;

// Mengubah dari '/landing' menjadi '/' agar menjadi halaman utama web
Route::get('/', [LandingController::class, 'index']);

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::get('/choose-role', [AuthController::class, 'showRoleSelectionForm'])->middleware('auth')->name('role.choose');
Route::post('/choose-role', [AuthController::class, 'setActiveRole'])->middleware('auth')->name('role.set');

Route::view('/profile-user', 'profile-user');
Route::view('/riwayat-booking', 'riwayat-booking');
Route::view('/detail-riwayat-booking', 'detail-riwayat-booking');

Route::view('/profile-mitra', 'profile-mitra');
Route::view('/riwayat-penyewaan', 'riwayat-penyewaan');
Route::view('/detail-riwayat-penyewaan', 'detail-riwayat-penyewaan');
Route::view('/properti-saya', 'properti-saya');
Route::view('/tambah-properti', 'tambah-properti');
Route::view('/tambah-foto-properti', 'tambah-foto-properti');
Route::view('/status-pengajuan', 'status-pengajuan'); 
Route::view('/detail-status-pengajuan', 'detail-status-pengajuan'); 


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

Route::get('/detail-properti/{id}', [PropertyController::class, 'show'])->name('detail-properti');
Route::post('/detail-properti/{id}/book', [PropertyController::class, 'book'])->middleware('auth')->name('detail-properti.book');
Route::post('/detail-properti/{id}/save', [PropertyController::class, 'save'])->middleware('auth')->name('detail-properti.save');

// Upgrade to mitra (for logged-in users)
Route::get('/upgrade-mitra', [UpgradeController::class, 'showForm'])->middleware('auth')->name('upgrade.mitra');
Route::post('/upgrade-mitra', [UpgradeController::class, 'upgrade'])->middleware('auth');

// Mitra profile and property management
Route::middleware(['auth'])->group(function () {
    Route::get('/mitra/profil', [MitraController::class, 'profile'])->name('mitra.profile');
    Route::post('/mitra/profil', [MitraController::class, 'updateProfile'])->name('mitra.profile.update');

    Route::get('/mitra/riwayat-penyewaan', [MitraController::class, 'bookingHistory'])->name('mitra.bookings');
    Route::get('/mitra/properti-saya', [MitraController::class, 'properties'])->name('mitra.properties');
    Route::get('/mitra/tambah-properti', [MitraController::class, 'createProperty'])->name('mitra.property.create');
    Route::post('/mitra/tambah-properti', [MitraController::class, 'storeProperty'])->name('mitra.property.store');
    Route::post('/mitra/properti/{id}/hapus', [MitraController::class, 'deleteProperty'])->name('mitra.property.delete');
    Route::get('/mitra/status-pengajuan', [MitraController::class, 'applicationStatus'])->name('mitra.status');
});