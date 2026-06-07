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

        return view('profile-admin', compact('pendingProperties', 'allProperties', 'bookings'));
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
}
