<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Property;
use App\Models\PropertyCategory;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    /**
     * Ensure the user has the administrator role.
     */
    protected function ensureAdmin()
    {
        $user = Auth::user();
        if (!$user || !$user->hasRole('admin')) {
            abort(403, 'Akses ditolak. Halaman ini hanya khusus untuk Administrator.');
        }
        return $user;
    }

    /**
     * Fetch aggregated data for the admin SPA dashboard.
     */
    public function dashboard()
    {
        $this->ensureAdmin();

        // 1. Pending properties for approval (Pengajuan Properti)
        $pendingProperties = Property::with(['coverPhoto', 'location', 'category', 'mitra'])
            ->where('status_pengajuan', 'pending')
            ->orderByDesc('created_at')
            ->get();

        // 2. All properties (List Properti)
        $allProperties = Property::with(['coverPhoto', 'location', 'category', 'mitra'])
            ->orderByDesc('created_at')
            ->get();

        // 3. All bookings in the system (Riwayat Pemesanan)
        $bookings = Booking::with(['property.coverPhoto', 'property.location', 'user'])
            ->orderByDesc('created_at')
            ->get()
            ->map(function ($booking) {
                $start = \Carbon\Carbon::parse($booking->tanggal_mulai);
                $end = \Carbon\Carbon::parse($booking->tanggal_selesai);
                $days = max(1, $start->diffInDays($end) + 1);
                $booking->total_price = $booking->property ? ($booking->property->harga_per_hari * $days) : 0;
                return $booking;
            });

        // 4. All reviews in the system (Kelola Komentar)
        $reviews = \App\Models\Review::with(['booking.property.coverPhoto', 'booking.user', 'booking.property.mitra'])
            ->orderByDesc('created_at')
            ->get();

        // 5. All users in the system (Manajemen Pengguna)
        $users = \App\Models\User::with('roles')
            ->orderBy('name')
            ->get();

        // 6. Statistics counters (Statistik)
        $stats = [
            'total_users' => \App\Models\User::count(),
            'total_tenants' => \App\Models\User::whereHas('roles', function($q) { $q->where('name', 'penyewa'); })->count(),
            'total_owners' => \App\Models\User::whereHas('roles', function($q) { $q->where('name', 'mitra'); })->count(),
            'total_admins' => \App\Models\User::whereHas('roles', function($q) { $q->where('name', 'admin'); })->count(),
            
            'total_properties' => Property::count(),
            'approved_properties' => Property::where('status_pengajuan', 'approved')->count(),
            'pending_properties' => Property::where('status_pengajuan', 'pending')->count(),
            'rejected_properties' => Property::where('status_pengajuan', 'rejected')->count(),
            
            'total_bookings' => Booking::count(),
            'pending_bookings' => Booking::where('status_booking', 'pending')->count(),
            'confirmed_bookings' => Booking::where('status_booking', 'confirmed')->count(),
            'completed_bookings' => Booking::where('status_booking', 'completed')->count(),
            'rejected_bookings' => Booking::where('status_booking', 'rejected')->count(),
        ];

        return view('profile-admin', compact('pendingProperties', 'allProperties', 'bookings', 'reviews', 'users', 'stats'));
    }

    /**
     * Handle property review approval/rejection.
     */
    public function reviewProperty(Request $request, $id)
    {
        $this->ensureAdmin();

        $request->validate([
            'status_pengajuan' => 'required|in:approved,rejected',
            'catatan' => 'nullable|string|max:1000',
        ], [
            'status_pengajuan.required' => 'Keputusan review wajib ditentukan.',
            'status_pengajuan.in' => 'Keputusan review tidak valid.',
        ]);

        $property = Property::findOrFail($id);
        $property->status_pengajuan = $request->input('status_pengajuan');
        $property->catatan = $request->input('catatan');
        $property->save();

        $statusMessage = $property->status_pengajuan === 'approved' ? 'disetujui' : 'ditolak';

        return redirect()->route('admin.dashboard')->with('success', "Properti '{$property->nama_properti}' berhasil {$statusMessage}.");
    }

    /**
     * Delete a review from the database.
     */
    public function deleteReview($id)
    {
        $this->ensureAdmin();
        $review = \App\Models\Review::findOrFail($id);
        $review->delete();

        return response()->json([
            'success' => true,
            'message' => 'Ulasan berhasil dihapus.'
        ]);
    }

    /**
     * Delete only the Mitra's feedback from a review.
     */
    public function deleteFeedback($id)
    {
        $this->ensureAdmin();
        $review = \App\Models\Review::findOrFail($id);
        $review->balasan_mitra = null;
        $review->tanggal_balasan = null;
        $review->save();

        return response()->json([
            'success' => true,
            'message' => 'Tanggapan mitra berhasil dihapus.'
        ]);
    }

    /**
     * Delete a user account and all their related data from the database.
     */
    public function deleteUser($id)
    {
        $this->ensureAdmin();

        $currentUser = Auth::user();
        if ($currentUser->id == $id) {
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak dapat menghapus akun Anda sendiri.'
            ], 400);
        }

        $user = \App\Models\User::findOrFail($id);
        $user->delete();

        return response()->json([
            'success' => true,
            'message' => "Akun pengguna '{$user->name}' berhasil dihapus."
        ]);
    }
}
