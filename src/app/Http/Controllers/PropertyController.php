<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Property;
use App\Models\Booking;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;

class PropertyController extends Controller
{
    public function show($id)
    {
        $property = Property::with(['category', 'location', 'photos', 'mitra', 'bookings', 'reviews.booking.user'])
            ->findOrFail($id);

        $avgRating = $property->reviews->avg('rating') ?: 0.0;
        
        $disabledDates = $property->bookings()
            ->whereIn('status_booking', ['confirmed', 'pending'])
            ->get(['tanggal_mulai', 'tanggal_selesai'])
            ->map(function ($booking) {
                return [
                    'from' => $booking->tanggal_mulai,
                    'to' => $booking->tanggal_selesai
                ];
            });

        $isSaved = false;
        if (Auth::check()) {
            $isSaved = Wishlist::where('id_user', Auth::id())
                ->where('id_properti', $id)
                ->exists();
        }

        return view('detail-properti', compact('property', 'avgRating', 'disabledDates', 'isSaved'));
    }

    public function book(Request $request, $id)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('info', 'Silakan masuk atau daftar terlebih dahulu untuk memesan properti.');
        }

        $request->validate([
            'date_range' => 'required|string',
        ]);

        $dateRange = $request->input('date_range');
        // Flatpickr range format is usually: "YYYY-MM-DD to YYYY-MM-DD"
        $dates = explode(' to ', $dateRange);

        if (count($dates) !== 2) {
            return redirect()->back()->with('error', 'Silakan pilih rentang tanggal check-in dan check-out yang valid.');
        }

        $start = trim($dates[0]);
        $end = trim($dates[1]);

        // Validate date availability (make sure no overlapping booking exists)
        $exists = Booking::where('id_properti', $id)
            ->whereIn('status_booking', ['confirmed', 'pending'])
            ->where(function ($query) use ($start, $end) {
                $query->whereBetween('tanggal_mulai', [$start, $end])
                    ->orWhereBetween('tanggal_selesai', [$start, $end])
                    ->orWhere(function ($q) use ($start, $end) {
                        $q->where('tanggal_mulai', '<=', $start)
                          ->where('tanggal_selesai', '>=', $end);
                    });
            })
            ->exists();

        if ($exists) {
            return redirect()->back()->with('error', 'Tanggal yang Anda pilih sudah terpesan. Silakan pilih tanggal lain.');
        }

        Booking::create([
            'id_properti' => $id,
            'id_user' => Auth::id(),
            'tanggal_mulai' => $start,
            'tanggal_selesai' => $end,
            'status_booking' => 'pending',
        ]);

        return redirect()->back()->with('success', 'Permintaan pemesanan berhasil diajukan! Menunggu konfirmasi dari Mitra.');
    }

    public function save(Request $request, $id)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $wishlist = Wishlist::where('id_user', Auth::id())
            ->where('id_properti', $id)
            ->first();

        if ($wishlist) {
            $wishlist->delete();
            $saved = false;
        } else {
            Wishlist::create([
                'id_user' => Auth::id(),
                'id_properti' => $id,
            ]);
            $saved = true;
        }

        if ($request->wantsJson()) {
            return response()->json(['saved' => $saved]);
        }

        return redirect()->back();
    }
}
