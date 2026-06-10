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
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;

// Mengubah dari '/landing' menjadi '/' agar menjadi halaman utama web
Route::get('/', [LandingController::class, 'index']);

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/admin/login', [AuthController::class, 'showAdminLoginForm'])->name('admin.login');
Route::post('/admin/login', [AuthController::class, 'adminLogin'])->name('admin.login.submit');

Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::get('/choose-role', [AuthController::class, 'showRoleSelectionForm'])->middleware('auth')->name('role.choose');
Route::post('/choose-role', [AuthController::class, 'setActiveRole'])->middleware('auth')->name('role.set');

Route::middleware(['auth', \App\Http\Middleware\CheckRole::class . ':penyewa'])->group(function () {
    Route::get('/profile-user', [UserController::class, 'profile'])->name('user.profile');
    Route::post('/profile-user', [UserController::class, 'updateProfile'])->name('user.profile.update');
    Route::get('/riwayat-booking', [UserController::class, 'bookingHistory'])->name('user.booking.history');
    Route::get('/saved-properti', [UserController::class, 'profile'])->name('user.saved');
    Route::get('/detail-riwayat-booking/{id}', [UserController::class, 'bookingDetail'])->name('user.booking.detail');
    Route::post('/booking/{id}/review', [UserController::class, 'storeReview'])->name('user.booking.review.store');
});

// Route::view('/profile-mitra', 'profile-mitra');
// Route::view('/riwayat-penyewaan', 'riwayat-penyewaan');
// Route::view('/detail-riwayat-penyewaan', 'detail-riwayat-penyewaan');
// Route::view('/properti-saya', 'properti-saya');
// Route::view('/detail-properti-saya', 'detail-properti-saya');
// Route::view('/tambah-properti', 'tambah-properti');
// Route::view('/tambah-foto-properti', 'tambah-foto-properti');
// Route::view('/status-pengajuan', 'status-pengajuan'); 
// Route::view('/detail-status-pengajuan', 'detail-status-pengajuan');  

Route::middleware(['auth', \App\Http\Middleware\CheckRole::class . ':admin'])->group(function () {
    Route::get('/profile-admin', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/pengajuan-properti', [AdminController::class, 'dashboard'])->name('admin.pengajuan');
    Route::get('/admin/riwayat-pemesanan', [AdminController::class, 'dashboard'])->name('admin.riwayat');
    Route::get('/admin/list-properti', [AdminController::class, 'dashboard'])->name('admin.properties');
    Route::get('/admin/manage-comments', [AdminController::class, 'dashboard'])->name('admin.comments');
    Route::get('/admin/manage-users', [AdminController::class, 'dashboard'])->name('admin.users');
    Route::delete('/admin/user/{id}', [AdminController::class, 'deleteUser'])->name('admin.user.delete');

    Route::post('/admin/pengajuan-properti/{id}/review', [AdminController::class, 'reviewProperty'])->name('admin.property.review');
    Route::delete('/admin/review/{id}', [AdminController::class, 'deleteReview'])->name('admin.review.delete');
    Route::post('/admin/review/{id}/delete-feedback', [AdminController::class, 'deleteFeedback'])->name('admin.review.deleteFeedback');
});

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

    $activeRole = session('active_role');
    if ($activeRole === 'penyewa') {
        return redirect('/profile-user');
    } elseif ($activeRole === 'mitra') {
        return redirect()->route('mitra.profile');
    } elseif ($activeRole === 'admin') {
        return redirect()->route('admin.dashboard');
    }

    return view('dashboard');
})->middleware('auth')->name('dashboard');

Route::get('/detail-properti/{id}', [PropertyController::class, 'show'])->name('detail-properti');
Route::post('/detail-properti/{id}/book', [PropertyController::class, 'book'])->middleware(['auth', \App\Http\Middleware\CheckRole::class . ':penyewa'])->name('detail-properti.book');
Route::post('/detail-properti/{id}/save', [PropertyController::class, 'save'])->middleware('auth')->name('detail-properti.save');

Route::get('/payment/{id}', [PropertyController::class, 'showPaymentPage'])->middleware(['auth', \App\Http\Middleware\CheckRole::class . ':penyewa'])->name('property.payment');
Route::post('/payment/{id}/store', [PropertyController::class, 'storeBooking'])->middleware(['auth', \App\Http\Middleware\CheckRole::class . ':penyewa'])->name('property.payment.store');

// Upgrade to mitra (for logged-in users)
Route::get('/upgrade-mitra', [UpgradeController::class, 'showForm'])->middleware('auth')->name('upgrade.mitra');
Route::post('/upgrade-mitra', [UpgradeController::class, 'upgrade'])->middleware('auth');

// Mitra profile and property management
Route::middleware(['auth', \App\Http\Middleware\CheckRole::class . ':mitra'])->group(function () {
    Route::get('/profile-mitra', [MitraController::class, 'profile'])->name('mitra.profile');
    Route::post('/profile-mitra', [MitraController::class, 'updateProfile'])->name('mitra.profile.update');

    Route::get('/riwayat-penyewaan', [MitraController::class, 'bookingHistory'])->name('mitra.bookings');
    Route::get('/detail-riwayat-penyewaan/{id}', [MitraController::class, 'bookingDetail'])->name('mitra.booking.detail');
    Route::post('/detail-riwayat-penyewaan/{id}/status', [MitraController::class, 'updateBookingStatus'])->name('mitra.booking.updateStatus');
    Route::post('/mitra/review/{id}/feedback', [MitraController::class, 'storeFeedback'])->name('mitra.review.feedback.store');

    Route::get('/properti-saya', [MitraController::class, 'properties'])->name('mitra.properties');
    Route::get('/detail-properti-saya/{id}', [MitraController::class, 'propertyDetail'])->name('mitra.property.detail');

    Route::get('/tambah-properti', [MitraController::class, 'createProperty'])->name('mitra.property.create');
    Route::post('/tambah-properti', [MitraController::class, 'storeProperty'])->name('mitra.property.store');
    Route::post('/properti/{id}/hapus', [MitraController::class, 'deleteProperty'])->name('mitra.property.delete');

    Route::get('/status-pengajuan', [MitraController::class, 'applicationStatus'])->name('mitra.status');
    Route::get('/detail-status-pengajuan/{id}', [MitraController::class, 'applicationStatusDetail'])->name('mitra.status.detail');
});