<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Booking;
use Carbon\Carbon;

class UserController extends Controller
{

    /**
     * Show the user profile view with authenticated user data and booking history.
     */
    public function profile()
    {
        $user = Auth::user();
        $bookings = Booking::with(['property.coverPhoto', 'property.location'])
            ->where('id_user', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        $bookings = $bookings->map(function ($booking) {
            $start = Carbon::parse($booking->tanggal_mulai);
            $end = Carbon::parse($booking->tanggal_selesai);
            $days = max(1, $start->diffInDays($end) + 1);
            $booking->total_price = $booking->property ? ($booking->property->harga_per_hari * $days) : 0;
            return $booking;
        });

        $wishlists = \App\Models\Wishlist::with(['property.coverPhoto', 'property.location'])
            ->where('id_user', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('profile-user', compact('user', 'bookings', 'wishlists'));
    }

    /**
     * Update user profile data.
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,'.$user->id,
            'no_hp' => ['required', 'string', 'regex:/^08[0-9]{8,11}$/', 'unique:users,no_hp,'.$user->id],
            'alamat' => 'nullable|string|max:500',
            'password' => 'nullable|string|min:8',
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'no_hp.required' => 'Nomor telepon wajib diisi.',
            'no_hp.regex' => 'Nomor telepon harus diawali 08 dan terdiri dari 10 sampai 13 digit angka.',
            'password.min' => 'Password minimal 8 karakter.',
        ]);

        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->no_hp = $request->input('no_hp');
        $user->alamat = $request->input('alamat');

        if ($request->filled('password')) {
            $user->password = Hash::make($request->input('password'));
        }

        $user->save();

        return back()->with('success', 'Profil berhasil diperbarui.');
    }

    /**
     * Show booking history (maps to the unified view).
     */
    public function bookingHistory()
    {
        return $this->profile();
    }

    /**
     * Show detail for a specific booking.
     */
    public function bookingDetail(Request $request, $id)
    {
        $user = Auth::user();

        $booking = Booking::with(['property.coverPhoto', 'property.location', 'property.mitra', 'review'])
            ->where('id_user', $user->id)
            ->findOrFail($id);

        $start = Carbon::parse($booking->tanggal_mulai);
        $end = Carbon::parse($booking->tanggal_selesai);
        $days = max(1, $start->diffInDays($end) + 1);
        $booking->total_price = $booking->property ? ($booking->property->harga_per_hari * $days) : 0;
        $booking->rentang_hari = $start->translatedFormat('d M Y') . ' - ' . $end->translatedFormat('d M Y');

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'booking' => [
                    'id_booking' => $booking->id_booking,
                    'status_booking' => $booking->status_booking,
                    'status_pembayaran' => in_array($booking->status_booking, ['confirmed', 'completed']) 
                        ? 'Lunas' 
                        : ($booking->status_booking === 'pending' 
                            ? 'Menunggu Konfirmasi' 
                            : ($booking->status_booking === 'cancelled' ? 'Dibatalkan' : 'Booking Ditolak')),
                    'total_price_formatted' => 'Rp ' . number_format($booking->total_price, 0, ',', '.'),
                    'rentang_hari' => $booking->rentang_hari,
                    'nama_properti' => $booking->property->nama_properti ?? '',
                    'cover_photo' => $booking->property->coverPhoto->url_foto ?? '/images/landing/property.png',
                    'pemilik' => $booking->property->mitra->name ?? 'Tidak Diketahui',
                    'email_mitra' => $booking->property->mitra->email ?? 'Tidak Diketahui',
                    'review' => $booking->review ? [
                        'id_review' => $booking->review->id_review,
                        'rating' => $booking->review->rating,
                        'komentar' => $booking->review->komentar,
                        'tanggal_review' => \Carbon\Carbon::parse($booking->review->tanggal_review)->format('d/m/Y'),
                        'balasan_mitra' => $booking->review->balasan_mitra,
                        'tanggal_balasan' => $booking->review->tanggal_balasan ? \Carbon\Carbon::parse($booking->review->tanggal_balasan)->format('d/m/Y') : null,
                    ] : null,
                ]
            ]);
        }

        $bookings = Booking::with(['property.coverPhoto', 'property.location'])
            ->where('id_user', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        $bookings = $bookings->map(function ($b) {
            $start = Carbon::parse($b->tanggal_mulai);
            $end = Carbon::parse($b->tanggal_selesai);
            $days = max(1, $start->diffInDays($end) + 1);
            $b->total_price = $b->property ? ($b->property->harga_per_hari * $days) : 0;
            return $b;
        });

        $wishlists = \App\Models\Wishlist::with(['property.coverPhoto', 'property.location'])
            ->where('id_user', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        $activeBookingId = $id;

        return view('profile-user', compact('user', 'bookings', 'wishlists', 'activeBookingId'));
    }

    /**
     * Store rating and review for a booking.
     */
    public function storeReview(Request $request, $id)
    {
        $user = Auth::user();

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'komentar' => 'nullable|string|max:1000',
        ], [
            'rating.required' => 'Rating wajib dipilih.',
            'rating.integer' => 'Rating harus berupa angka.',
            'rating.min' => 'Rating minimal 1 bintang.',
            'rating.max' => 'Rating maksimal 5 bintang.',
        ]);

        $booking = Booking::where('id_user', $user->id)
            ->whereIn('status_booking', ['confirmed', 'completed'])
            ->findOrFail($id);

        if ($booking->review()->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Anda sudah memberikan review untuk pesanan ini.'
            ], 400);
        }

        $review = \App\Models\Review::create([
            'id_booking' => $booking->id_booking,
            'rating' => $request->input('rating'),
            'komentar' => $request->input('komentar'),
            'tanggal_review' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Ulasan berhasil dikirim!',
            'review' => [
                'id_review' => $review->id_review,
                'rating' => $review->rating,
                'komentar' => $review->komentar,
                'tanggal_review' => \Carbon\Carbon::parse($review->tanggal_review)->format('d/m/Y'),
            ]
        ]);
    }

    /**
     * Cancel a pending booking.
     */
    public function cancelBooking($id)
    {
        $user = Auth::user();
        $booking = Booking::where('id_user', $user->id)
            ->where('status_booking', 'pending')
            ->findOrFail($id);

        $booking->status_booking = 'cancelled';
        $booking->save();

        return response()->json([
            'success' => true,
            'message' => 'Booking Anda berhasil dibatalkan.',
            'booking' => [
                'id_booking' => $booking->id_booking,
                'status_booking' => $booking->status_booking,
            ]
        ]);
    }
}
