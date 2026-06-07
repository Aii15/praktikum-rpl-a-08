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
    public function bookingDetail($id)
    {
        $user = Auth::user();

        $booking = Booking::with(['property.coverPhoto', 'property.location'])
            ->where('id_user', $user->id)
            ->findOrFail($id);

        $start = Carbon::parse($booking->tanggal_mulai);
        $end = Carbon::parse($booking->tanggal_selesai);
        $days = max(1, $start->diffInDays($end) + 1);
        $booking->total_price = $booking->property ? ($booking->property->harga_per_hari * $days) : 0;
        $booking->rentang_hari = $start->translatedFormat('d M Y') . ' - ' . $end->translatedFormat('d M Y');

        return view('detail-riwayat-booking', compact('booking'));
    }
}
