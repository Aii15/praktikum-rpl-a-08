<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Location;
use App\Models\Property;
use App\Models\PropertyCategory;
use App\Models\MitraProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class MitraController extends Controller
{

    protected function ensureMitra()
    {
        $user = Auth::user();

        if (! $user || ! $user->hasRole('mitra')) {
            abort(403, 'Akses hanya untuk Mitra.');
        }

        return $user;
    }

    protected function getUnifiedData()
    {
        $user = $this->ensureMitra();
        $profile = $user->mitraProfile;

        // Fetch bookings
        $bookings = Booking::with(['property.coverPhoto', 'property.location', 'user'])
            ->whereHas('property', function ($query) use ($user) {
                $query->where('id_mitra', $user->id);
            })
            ->orderByRaw("CASE WHEN status_booking = 'pending' THEN 0 ELSE 1 END")
            ->orderByDesc('tanggal_mulai')
            ->get();

        // Calculate booking prices
        $bookings = $bookings->map(function ($booking) {
            $start = \Carbon\Carbon::parse($booking->tanggal_mulai);
            $end = \Carbon\Carbon::parse($booking->tanggal_selesai);
            $days = max(1, $start->diffInDays($end) + 1);
            $booking->total_price = $booking->property ? ($booking->property->harga_per_hari * $days) : 0;
            return $booking;
        });

        // Fetch properties
        $properties = Property::with(['coverPhoto', 'category', 'location'])
            ->withCount('bookings')
            ->where('id_mitra', $user->id)
            ->orderByDesc('created_at')
            ->get();

        $categories = PropertyCategory::orderBy('nama_kategori')->get();
        $locations = Location::orderBy('kota')->get();

        return compact('user', 'profile', 'bookings', 'properties', 'categories', 'locations');
    }

    public function profile()
    {
        return view('mitra.profile', $this->getUnifiedData());
    }

    public function updateProfile(Request $request)
    {
        $user = $this->ensureMitra();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,'.$user->id,
            'no_hp' => ['required','string','regex:/^08[0-9]{8,11}$/','unique:users,no_hp,'.$user->id],
            'ktp' => ['required', 'string', 'regex:/^[0-9]{16}$/'],
            'rekening_bank' => ['nullable', 'string', 'max:50'],
            'nama_mitra' => 'required|string|max:100',
            'password' => 'nullable|string|confirmed|min:8',
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'no_hp.required' => 'Nomor telepon wajib diisi.',
            'no_hp.regex' => 'Nomor telepon harus diawali 08 dan terdiri dari 10 sampai 13 digit angka.',
            'ktp.required' => 'Nomor KTP wajib diisi.',
            'ktp.regex' => 'Nomor KTP harus terdiri dari 16 digit angka.',
            'nama_mitra.required' => 'Nama Mitra/Perusahaan wajib diisi.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'password.min' => 'Password minimal 8 karakter.',
        ]);

        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->no_hp = $request->input('no_hp');
        $user->ktp = $request->input('ktp');
        $user->rekening_bank = $request->input('rekening_bank');

        if ($request->filled('password')) {
            $user->password = Hash::make($request->input('password'));
        }

        $user->save();

        $profile = $user->mitraProfile;
        if (! $profile) {
            $profile = new MitraProfile();
            $profile->user_id = $user->id;
        }

        $profile->nama_mitra = $request->input('nama_mitra');
        $profile->ktp = $request->input('ktp');
        $profile->rekening_bank = $request->input('rekening_bank');
        $profile->save();

        return back()->with('success', 'Profil berhasil diperbarui.');
    }

    public function bookingHistory()
    {
        return $this->profile();
    }

    public function properties()
    {
        return $this->profile();
    }

    public function createProperty()
    {
        return $this->profile();
    }

    public function storeProperty(Request $request)
    {
        $user = $this->ensureMitra();

        $request->validate([
            'nama_properti' => 'required|string|max:150',
            'id_kategori' => 'required|exists:property_categories,id_kategori',
            'alamat_detail' => 'required|string|max:500',
            'kota' => 'required|string|max:100',
            'provinsi' => 'required|string|max:100',
            'kode_pos' => 'nullable|string|max:10',
            'harga_per_hari' => 'required|numeric|min:0',
            'fasilitas' => 'nullable|string|max:1000',
            'deskripsi' => 'required|string',
            'images' => 'required|array|min:2|max:5',
            'images.*' => 'file|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'positions' => 'nullable|array',
            'positions.*' => 'string|max:20',
        ], [
            'nama_properti.required' => 'Nama properti wajib diisi.',
            'id_kategori.required' => 'Kategori properti wajib dipilih.',
            'alamat_detail.required' => 'Alamat detail wajib diisi.',
            'kota.required' => 'Kota wajib diisi.',
            'provinsi.required' => 'Provinsi wajib diisi.',
            'harga_per_hari.required' => 'Harga per hari wajib diisi.',
            'deskripsi.required' => 'Deskripsi properti wajib diisi.',
            'images.required' => 'Minimal 2 foto wajib diunggah.',
            'images.min' => 'Minimal 2 foto wajib diunggah.',
            'images.max' => 'Maksimal 5 foto dapat diunggah.',
            'images.*.image' => 'File harus berupa gambar.',
            'images.*.mimes' => 'Jenis gambar harus jpeg, png, jpg, gif, atau webp.',
            'images.*.max' => 'Ukuran setiap foto maksimal 2MB.',
        ]);

        $location = Location::firstOrCreate([
            'alamat_detail' => $request->input('alamat_detail'),
            'kota' => $request->input('kota'),
            'provinsi' => $request->input('provinsi'),
            'kode_pos' => $request->input('kode_pos'),
        ], [
            'nama_lokasi' => $request->input('kota'),
        ]);

        $property = Property::create([
            'id_mitra' => $user->id,
            'id_kategori' => $request->input('id_kategori'),
            'id_lokasi' => $location->id_lokasi,
            'nama_properti' => $request->input('nama_properti'),
            'deskripsi' => $request->input('deskripsi'),
            'harga_per_hari' => $request->input('harga_per_hari'),
            'fasilitas' => $request->input('fasilitas'),
            'status_pengajuan' => 'pending',
        ]);

        if ($request->hasFile('images')) {
            $files = $request->file('images');
            $positions = $request->input('positions', []);
            foreach ($files as $index => $file) {
                $path = $file->store('property_photos/property_' . $property->id_properti, 'public');
                $pos = $positions[$index] ?? '50';
                $property->photos()->create([
                    'url_foto' => '/storage/'.$path,
                    'urutan' => $index + 1,
                    'is_cover' => $index === 0,
                    'object_position' => $pos,
                ]);
            }
        }

        return redirect()->route('mitra.properties')->with('success', 'Properti berhasil ditambahkan dan diajukan.');
    }

    public function deleteProperty($id)
    {
        $user = $this->ensureMitra();

        $property = Property::withCount('bookings')
            ->where('id_mitra', $user->id)
            ->findOrFail($id);

        if ($property->bookings_count > 0) {
            return back()->with('error', 'Properti tidak dapat dihapus karena sudah pernah dibooking oleh user.');
        }

        $property->delete();

        return back()->with('success', 'Properti berhasil dihapus.');
    }

    public function applicationStatus()
    {
        return $this->profile();
    }

    public function bookingDetail(Request $request, $id)
    {
        $user = $this->ensureMitra();

        $booking = Booking::with(['property.coverPhoto', 'property.location', 'user', 'review'])
            ->whereHas('property', function ($query) use ($user) {
                $query->where('id_mitra', $user->id);
            })
            ->findOrFail($id);

        $start = \Carbon\Carbon::parse($booking->tanggal_mulai);
        $end = \Carbon\Carbon::parse($booking->tanggal_selesai);
        $days = max(1, $start->diffInDays($end) + 1);
        $booking->total_price = $booking->property ? ($booking->property->harga_per_hari * $days) : 0;
        
        $rentang_sewa = $start->translatedFormat('d F Y') . ' - ' . $end->translatedFormat('d F Y');

        if ($request->wantsJson() || $request->ajax()) {
            $status_text = '';
            if ($booking->status_booking === 'pending') {
                $status_text = 'Menunggu Konfirmasi';
            } elseif ($booking->status_booking === 'confirmed') {
                $status_text = 'Disetujui / Aktif';
            } elseif ($booking->status_booking === 'completed') {
                $status_text = 'Transaksi Selesai';
            } else {
                $status_text = 'Ditolak';
            }

            return response()->json([
                'success' => true,
                'booking' => [
                    'id_booking' => $booking->id_booking,
                    'status_booking' => $booking->status_booking,
                    'status_text' => $status_text,
                    'total_price_formatted' => 'Rp ' . number_format($booking->total_price, 0, ',', '.'),
                    'rentang_sewa' => $rentang_sewa,
                    'nama_properti' => $booking->property->nama_properti ?? '',
                    'cover_photo' => $booking->property->coverPhoto->url_foto ?? '/images/landing/property.png',
                    'cover_photo_position' => $booking->property->coverPhoto->object_position ?? '50',
                    'penyewa' => $booking->user->name ?? 'Penyewa Tidak Diketahui',
                    'email_penyewa' => $booking->user->email ?? '-',
                    'no_hp_penyewa' => $booking->user->no_hp ?? '-',
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

        // For direct loads, retrieve all unified data and set activeBookingId
        $unifiedData = $this->getUnifiedData();
        $unifiedData['activeBookingId'] = $id;

        return view('mitra.profile', $unifiedData);
    }

    public function propertyDetail($id)
    {
        $user = $this->ensureMitra();

        $property = Property::with(['category', 'location', 'photos', 'coverPhoto'])
            ->where('id_mitra', $user->id)
            ->findOrFail($id);

        $bookedDateRanges = $property->bookings()
            ->whereIn('status_booking', ['pending', 'confirmed'])
            ->orderBy('tanggal_mulai')
            ->get(['tanggal_mulai', 'tanggal_selesai'])
            ->map(function ($booking) {
                return [
                    'from' => $booking->tanggal_mulai,
                    'to' => $booking->tanggal_selesai,
                ];
            });

        return view('mitra.property_detail', [
            'property' => $property,
            'bookedDateRanges' => $bookedDateRanges,
        ]);
    }

    public function applicationStatusDetail($id)
    {
        $user = $this->ensureMitra();

        $property = Property::with(['category', 'location', 'photos'])
            ->where('id_mitra', $user->id)
            ->findOrFail($id);

        return view('mitra.status_detail', [
            'property' => $property,
        ]);
    }

    public function updateBookingStatus(Request $request, $id)
    {
        $user = $this->ensureMitra();

        $request->validate([
            'status' => 'required|string|in:confirmed,rejected',
        ]);

        $booking = Booking::whereHas('property', function ($query) use ($user) {
                $query->where('id_mitra', $user->id);
            })
            ->findOrFail($id);

        if ($booking->status_booking !== 'pending') {
            return response()->json([
                'success' => false,
                'message' => 'Status booking ini tidak bisa diubah karena sudah diproses.'
            ], 400);
        }

        $booking->status_booking = $request->input('status');
        $booking->save();

        $status_text = '';
        if ($booking->status_booking === 'confirmed') {
            $status_text = 'Disetujui / Aktif';
        } else {
            $status_text = 'Ditolak';
        }

        return response()->json([
            'success' => true,
            'message' => 'Status booking berhasil diperbarui.',
            'booking' => [
                'id_booking' => $booking->id_booking,
                'status_booking' => $booking->status_booking,
                'status_text' => $status_text,
            ]
        ]);
    }

    /**
     * Store feedback for a review.
     */
    public function storeFeedback(Request $request, $id)
    {
        $user = $this->ensureMitra();

        $request->validate([
            'balasan_mitra' => 'required|string|max:1000',
        ], [
            'balasan_mitra.required' => 'Tanggapan wajib diisi.',
        ]);

        $review = \App\Models\Review::findOrFail($id);
        $booking = $review->booking;

        if (!$booking || $booking->property->id_mitra !== $user->id) {
            abort(403, 'Akses ditolak. Anda bukan pemilik properti untuk ulasan ini.');
        }

        if ($review->balasan_mitra !== null) {
            return response()->json([
                'success' => false,
                'message' => 'Anda sudah memberikan feedback untuk ulasan ini.'
            ], 400);
        }

        $review->balasan_mitra = $request->input('balasan_mitra');
        $review->tanggal_balasan = now();
        $review->save();

        return response()->json([
            'success' => true,
            'message' => 'Tanggapan ulasan berhasil dikirim!',
            'review' => [
                'id_review' => $review->id_review,
                'balasan_mitra' => $review->balasan_mitra,
                'tanggal_balasan' => \Carbon\Carbon::parse($review->tanggal_balasan)->format('d/m/Y'),
            ]
        ]);
    }
}
